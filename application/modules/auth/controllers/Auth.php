<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth extends MX_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('auth_mdl');
    $this->module = "auth";
  }
  
  public function index(){
  $data['module'] = $this->module;
  $this->load->view("login/login");
  }

  public function login()
  {
      // Clear any previous error messages
      $this->session->unset_userdata('error_message');
      
      // Load form validation library
      $this->load->library('form_validation');
      
      // Set validation rules
      $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
      $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|trim');
      
      // Run validation
      if ($this->form_validation->run() === FALSE) {
          $errors = $this->form_validation->error_array();
          $error_message = implode('<br>', $errors);
          $this->session->set_flashdata('error_message', $error_message);
          redirect('auth');
      }
  
      $postdata = $this->input->post();
      $email = $postdata['email'];
      $password = $postdata['password'];
      $remember_me = isset($postdata['remember_me']) ? $postdata['remember_me'] : false;
  
      // Rate limiting check (simple implementation)
      $this->check_login_attempts($email);
  
      // Fetch user data from database
      $user = $this->auth_mdl->login(['email' => $email]);
  
      // Check if user exists
      if (empty($user)) {
          $this->log_failed_attempt($email, 'Invalid email');
          $this->session->set_flashdata('error_message', 'Invalid email address or password.');
          redirect('auth');
      }
      
      // Check if user is active
      if ($user->status != 1) {
          $this->log_failed_attempt($email, 'Account disabled');
          $this->session->set_flashdata('error_message', 'Your account has been disabled. Please contact your administrator.');
          redirect('auth');
      }
      
      // Validate password
      if (!$this->validate_password($password, $user->password)) {
          $this->log_failed_attempt($email, 'Invalid password');
          $this->session->set_flashdata('error_message', 'Invalid email address or password.');
          redirect('auth');
      }
      
      // Clear failed attempts on successful login
      $this->clear_failed_attempts($email);
  
      // Prepare user data for session
      $user_data = (array) $user;
      unset($user_data['password']);
  
      // Retrieve additional user access details
      $user_data['permissions'] = $this->auth_mdl->user_permissions($user_data['role']);
      $user_data['is_admin'] = ($user_data['role'] == 10);
      $user_data['last_login'] = date('Y-m-d H:i:s');
      
      // Set session data
      $this->session->set_userdata($user_data);
      
      // Handle remember me functionality
      if ($remember_me) {
          $this->set_remember_me_cookie($user_data['id']);
      }
      
      // Log successful login
      $this->log_successful_login($email);
   
      // Redirect to dashboard or intended page
      redirect('records');
  }
  public function validate_password($post_password,$dbpassword){
    $auth = ($this->argonhash->check($post_password, $dbpassword));
     if ($auth) {
       return TRUE;
     }
     else{
       return FALSE;
     }
     
   }

  public function profile()
  {
    $data['module'] = "auth";
    $data['view'] = "profile";
    $data['title'] = "My Profile";

    render_site("users/profile", $data);

  }
  public function logout()
  {
    session_unset();
    session_destroy();
    redirect("auth");
  }

  public function getUserByid($id)
  {
    $userrow = $this->auth_mdl->getUser($id);
    //print_r($userrow);
    return $userrow;
  }

  public function users()
  {
    $searchkey = $this->input->post('search_key');
    if (empty($searchkey)) {
      $searchkey = "";
    }
    $this->load->library('pagination');
    $config = array();
    $config['base_url'] = base_url() . "auth/users";
    $config['total_rows'] = $this->auth_mdl->count_Users($searchkey);
    $config['per_page'] = 20; //records per page
    $config['uri_segment'] = 3; //segment in url  
    //pagination links styling
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['attributes'] = ['class' => 'page-link'];
    $config['first_link'] = false;
    $config['last_link'] = false;
    $config['first_tag_open'] = '<li class="page-item">';
    $config['first_tag_close'] = '</li>';
    $config['prev_link'] = '&laquo';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = '&raquo';
    $config['next_tag_open'] = '<li class="page-item">';
    $config['next_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li class="page-item">';
    $config['last_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
    $config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    $config['use_page_numbers'] = false;
    $this->pagination->initialize($config);
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0; //default starting point for limits 
    $data['links'] = $this->pagination->create_links();
    $data['users'] = $this->auth_mdl->getAll($config['per_page'], $page, $searchkey);
    $data['module'] = "auth";
    $data['title'] = "User Management";
    $data['uptitle'] = "User Management";
    render("users/add_users", $data);
  }
  public function addUser()
  {
      // Load the form validation library
      $this->load->library('form_validation');
  
      // Define validation rules
      $this->form_validation->set_rules('name', 'Name', 'required|trim');
      $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
      $this->form_validation->set_rules('role', 'User Group', 'required|integer');
      $this->form_validation->set_rules('memberstate_id', 'Member State', 'required|integer');
      $this->form_validation->set_rules('priotisation_level', 'Level of Prioritisation', 'required|integer');
  
      // Run validation
      if ($this->form_validation->run() === FALSE) {
          // Validation failed
          $errors = $this->form_validation->error_array();
          return $this->output
                      ->set_content_type('application/json')
                      ->set_status_header(400)
                      ->set_output(json_encode([
                          'status' => 'error',
                          'message' => 'Validation failed.',
                          'errors' => $errors
                      ]));
      }
  
      // Retrieve POST data
      $postdata = $this->input->post();
  
      // Attempt to add user via the model
      $res = $this->auth_mdl->addUser($postdata);
  
      if ($res) {
        $msg = array(
          'msg' => 'Staff Updated successfully.',
          'type' => 'success'
        );
        
        
      }
      else{
        $msg = array(
          'msg' => 'Updated Failed!.',
          'type' => 'error'
        );
  
      }
      Modules::run('utility/setFlash', $msg);
      redirect('auth/users');
  }
  
  public function updateUser()
  {
      // Check if this is an AJAX request
      if ($this->input->is_ajax_request()) {
          $postdata = $this->input->post();
          
          // Validate required fields
          if (empty($postdata['id']) || empty($postdata['name']) || empty($postdata['email'])) {
              echo json_encode([
                  'status' => 'error',
                  'message' => 'Required fields are missing.'
              ]);
              return;
          }
          
          $result = $this->auth_mdl->updateUser($postdata);
          
          if ($result && $result['status'] === 'success') {
              echo json_encode([
                  'status' => 'success',
                  'message' => 'User updated successfully.'
              ]);
          } else {
              echo json_encode([
                  'status' => 'error',
                  'message' => $result['message'] ?? 'Update failed.'
              ]);
          }
      } else {
          // Handle non-AJAX requests (fallback)
          $postdata = $this->input->post();
          $result = $this->auth_mdl->updateUser($postdata);

          if ($result && $result['status'] === 'success') {
              $msg = array(
                  'msg' => 'User updated successfully.',
                  'type' => 'success'
              );
          } else {
              $msg = array(
                  'msg' => $result['message'] ?? 'Update failed.',
                  'type' => 'error'
              );
          }
          Modules::run('utility/setFlash', $msg);
          redirect('auth/users');
      }
  }
  

  public function changePass()
  {
    $postdata = $this->input->post();
    echo $res = $this->auth_mdl->changePass($postdata);
  }
  public function resetPass()
  {
    $postdata = $this->input->post();
    //print_r ($postdata);
    $res = $this->auth_mdl->resetPass($postdata);
    echo  $res;
  }
  public function blockUser()
  {
    $postdata = $this->input->post();
    //print_r ($postdata);
    $res = $this->auth_mdl->blockUser($postdata);
    echo $res;
  }
  public function unblockUser()                                                                                                                                                                                                                                                              
  {
    $postdata = $this->input->post();
    $res = $this->auth_mdl->unblockUser($postdata);
    echo $res;
  }
  public function getUsersData()
  {
      // DataTables server-side processing
      $draw = intval($this->input->post("draw"));
      $start = intval($this->input->post("start"));
      $length = intval($this->input->post("length"));
      $search = $this->input->post("search")["value"];
      $order = $this->input->post("order");
      $columns = $this->input->post("columns");
      
      // Get total records count
      $totalRecords = $this->auth_mdl->count_Users($search);
      
      // Get filtered records count
      $totalFiltered = $this->auth_mdl->count_Users($search);
      
      // Get users data
      $users = $this->auth_mdl->getAll($length, $start, $search);
      
      // Prepare data for DataTables
      $data = array();
      $no = $start + 1;
      
      foreach($users as $user) {
          $nestedData = array();
          $nestedData[] = $no++;
          $nestedData[] = $user->name;
          $nestedData[] = $user->email;
          $nestedData[] = get_value($user->memberstate_id, 'member_states')->member_state ?? '-';
          $nestedData[] = get_value($user->priotisation_level, 'priotisation_category')->name ?? '-';
          $nestedData[] = $user->organization_name;
          $nestedData[] = get_user_group($user->role)->group_name;
          
          // Action buttons
          $actions = '<a class="btn btn-sm btn-info editBtn" 
                        data-id="'.$user->id.'"
                        data-name="'.htmlspecialchars($user->name, ENT_QUOTES).'"
                        data-email="'.htmlspecialchars($user->email, ENT_QUOTES).'"
                        data-role="'.$user->role.'"
                        data-org="'.htmlspecialchars($user->organization_name, ENT_QUOTES).'"
                        data-memberstate="'.$user->memberstate_id.'"
                        data-level="'.$user->priotisation_level.'"
                        data-toggle="modal" data-target="#editUserModal">
                        Edit
                      </a>';
          
          if ($user->status == 1) {
              $actions .= ' <a href="#" class="btn btn-sm btn-warning blockBtn" 
                                data-id="'.$user->id.'" 
                                data-name="'.htmlspecialchars($user->name, ENT_QUOTES).'">
                                Block
                              </a>';
          } else {
              $actions .= ' <a href="#" class="btn btn-sm btn-danger unblockBtn" 
                                data-id="'.$user->id.'" 
                                data-name="'.htmlspecialchars($user->name, ENT_QUOTES).'">
                                Activate
                              </a>';
          }
          
          $actions .= ' <a href="#" class="btn btn-sm btn-danger resetBtn" 
                            data-id="'.$user->id.'" 
                            data-name="'.htmlspecialchars($user->name, ENT_QUOTES).'">
                            Reset
                          </a>';
          
          $nestedData[] = $actions;
          $data[] = $nestedData;
      }
      
      $json_data = array(
          "draw" => $draw,
          "recordsTotal" => $totalRecords,
          "recordsFiltered" => $totalFiltered,
          "data" => $data
      );
      
      echo json_encode($json_data);
  }

  public function updateProfile()
  {
    $postdata = $this->input->post();
    $username = $postdata['username'];
    if (!empty($_POST['photo'])) {
      //if user changed image
      $data = $_POST['photo'];
      list($type, $data) = explode(';', $data);
      list(, $data)      = explode(',', $data);
      $data = base64_decode($data);
      $imageName = $username . time() . '.png';
      unlink('./assets/images/sm/' . $this->session->userdata('photo'));
      $this->session->set_userdata('photo', $imageName);
      file_put_contents('./assets/images/sm/' . $imageName, $data);
      $postdata['photo'] = $imageName;
      //water mark the photo
      $path = './assets/images/sm/' . $imageName;
      //$this->photoMark($path);
    } else {
      $postdata['photo'] = $this->session->userdata('photo');
    }
    $res = $this->auth_mdl->updateProfile($postdata);
    if ($res == 'ok') {
      $msg = "Your profile has been Updated successfully";
    } else {
      $msg = $res . " .But may be if you changed your photo";
    }
    $alert = '<div class="alert alert-info"><a class="pull-right" href="#" data-dismiss="alert">X</a>' . $msg . '</div>';
    $this->session->set_flashdata('msg', $alert);
    redirect("auth/myprofile");
  }
  public function photoMark($imagepath)
  {
    $config['image_library'] = 'gd2';
    $config['source_image'] = $imagepath;
    //$config['wm_text'] = ' Uganda';
    $config['wm_type'] = 'overlay';
    $config['wm_overlay_path'] = './assets/images/daswhite.png';
    //$config['wm_font_color'] = 'ffffff';
    $config['wm_opacity'] = 40;
    $config['wm_vrt_alignment'] = 'bottom';
    $config['wm_hor_alignment'] = 'left';
    //$config['wm_padding'] = '50';
    $this->load->library('image_lib');
    $this->image_lib->initialize($config);
    $this->image_lib->watermark();
  }
  //permissions management

  public function frontend_logout()
  {
    session_unset();
    session_destroy(); 
    redirect( 'auth');
  }

  // Security helper methods
  private function check_login_attempts($email)
  {
      $this->load->model('auth_mdl');
      $attempts = $this->auth_mdl->get_failed_attempts($email);
      
      if ($attempts >= 5) { // Max 5 attempts
          $this->session->set_flashdata('error_message', 'Too many failed login attempts. Please try again in 15 minutes.');
          redirect('auth');
      }
  }
  
  private function log_failed_attempt($email, $reason)
  {
      $this->load->model('auth_mdl');
      $this->auth_mdl->log_failed_attempt($email, $reason, $this->input->ip_address());
  }
  
  private function clear_failed_attempts($email)
  {
      $this->load->model('auth_mdl');
      $this->auth_mdl->clear_failed_attempts($email);
  }
  
  private function log_successful_login($email)
  {
      $this->load->model('auth_mdl');
      $this->auth_mdl->log_successful_login($email, $this->input->ip_address());
  }
  
  private function set_remember_me_cookie($user_id)
  {
      $token = bin2hex(random_bytes(32));
      $expiry = time() + (30 * 24 * 60 * 60); // 30 days
      
      // Store token in database
      $this->load->model('auth_mdl');
      $this->auth_mdl->store_remember_token($user_id, $token, $expiry);
      
      // Set cookie
      setcookie('remember_token', $token, $expiry, '/', '', false, true);
  }

}
