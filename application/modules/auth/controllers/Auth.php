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
      $this->session->unset_userdata('error_message');
  
      $postdata = $this->input->post();
  
      $email = $postdata['email'];
      $password = $postdata['password'];
      //dd($this->argonhash->make($password));
  
      // Fetch user data from database
      $user = $this->auth_mdl->login(['email' => $email]);
  
      // Check if user exists
      if (empty($user)) {
          $this->session->set_flashdata('error_message', 'Invalid Email');
          redirect('auth');
      }
      else if($this->validate_password($password, $user->password)) {
        
  
      // Ensure user data is an array
      $user = (array) $user;
      unset($user['password']);
  
      // Retrieve additional user access details
      $user['permissions'] = $this->auth_mdl->user_permissions($user['role']);
      if($user['role']==10){
      $user['is_admin']    = true;
      }
      else{
        $user['is_admin']    = false;
      }
      $this->session->set_userdata($user);
   
      // Redirect to dashboard or intended page
      redirect('records');
    }
    else{
      $this->session->set_flashdata('error_message', 'Invalid Password');
    redirect('auth');
    }
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

    render("users/profile", $data);

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
    $postdata = $this->input->post();
    $res = $this->auth_mdl->addUser($postdata);
    echo $res;
  }
  public function updateUser()
  {
    $postdata = $this->input->post();
    $userfile = $postdata['id'];
    //CHECK whether user upload a photo
    if (!empty($_FILES['photo']['tmp_name'])) {
      $config['upload_path']   = './assets/images/sm/';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['max_size']      = 3070;
      $config['file_name']      = $userfile;
      $this->load->library('upload', $config);
      if (!$this->upload->do_upload('photo')) {
        $error = $this->upload->display_errors();
        echo strip_tags($error);
      } else {
        $data = $this->upload->data();
        $photofile = $data['file_name'];
        $path = $config['upload_path'] . $photofile;
        //water mark the photo
        $this->photoMark($path);
        $postdata['photo'] = $photofile;
        $res = $this->auth_mdl->updateUser($postdata);
      }
    } //user uploaded with a photo
    else {
      $res = $this->auth_mdl->updateUser($postdata);
    } //no photo
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

}
