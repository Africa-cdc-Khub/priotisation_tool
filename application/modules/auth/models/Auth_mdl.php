<?php

use function PHPUnit\Framework\returnArgument;
defined('BASEPATH') or exit('No direct script access allowed');
#[AllowDynamicProperties]
class Auth_mdl extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->table = "user";
		$this->default_password = setting()->default_password;
	}
	public function login($postdata)
	{
		$email = $postdata['email'];
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			//login using email
			$this->db->where("email", $email);
			$this->db->where("status", 1);
			$this->db->join('user_groups', 'user_groups.id=user.role');
			$qry = $this->db->get($this->table);
			$rows = $qry->num_rows();
			if ($rows !== 0) {
				$person = $qry->row();
				return $person;
			}
		}
		else{
			return "";
		}
		
	}

	public function getAll($start, $limit, $key)
	{
		if (!empty($key)) {
			$this->db->like("email", "$key", "both");
			$this->db->or_like("name", "$key", "both");
		}
		$this->db->limit($start, $limit);

		$qry = $this->db->get($this->table);
		return $qry->result();
	}
	public function count_Users($key)
	{
		if (!empty($key)) {
			$this->db->like("username", "$key", "both");
			$this->db->or_like("name", "$key", "both");
		}
		$qry = $this->db->get($this->table);
		return $qry->num_rows();
	}
	public function addUser($postdata)
	{

		$user = array(
			"email" => $postdata['email'],
			"memberstate_id" => $postdata["memberstate_id"],
			"organization_name" => $postdata["organization_name"],
			"password" => $this->default_password,
			"name" => $postdata['name'],
			"role" => $postdata['role'],
			"status" => "1"

		);
		$qry = $this->db->insert($this->table, $user);
		$last_id = $this->db->insert_id();
		//insert access levels
		$rows = $this->db->affected_rows();
		if ($qry) {
			return "Saved Successfully";
		} else {
			return "Operation failed";
		}
	}

	// Update user's details safely
	public function updateUser($postdata)
	{
		$uid = $postdata['id'];
	
		$name = $postdata['name'];
		$role = $postdata['role'];
		$organization_name = $postdata['organization_name'];
		$memberstate_id = $postdata['memberstate_id'];
		$priotisation_level = $postdata['priotisation_level'];
		$uid = $postdata['id'];
		
		$updated = $this->db->query("
			UPDATE user 
			SET 
				name = " . $this->db->escape($name) . ",
				role = " . $this->db->escape($role) . ",
				organization_name = " . $this->db->escape($organization_name) . ",
				memberstate_id = " . $this->db->escape($memberstate_id) . ",
				priotisation_level = " . $this->db->escape($priotisation_level) . "
			WHERE id = " . $this->db->escape($uid)
		);
		
	
		if ($updated) {
			return [
				'status' => 'success',
				'message' => 'User details updated successfully.'
			];
		} else {
			return [
				'status' => 'error',
				'message' => 'No changes made or update failed.'
			];
		}
	}
	

	// change password
	public function updateProfile($postdata)
	{
		$uid = $postdata['id'];
		$this->db->where('user_id', $uid);
		$done = $this->db->update($this->table, $postdata);

		if ($done) {
			return "Update Successful";
		} else {
			return "Update Failed";
		}
	}

	//block
	public function blockUser($postdata)
	{
		$uid = $postdata['user_id'];
		$data = array("status" => 0);
		$this->db->where('user_id', $uid);
		$done = $this->db->update($this->table, $data);

		if ($done) {
			return "User has been blocked";
		} else {
			return "Failed, Try Again";
		}
	}
	//unblock user
	public function unblockUser($postdata)
	{
		$uid = $postdata['user_id'];
		$data = array("status" => 1);
		$this->db->where('user_id', $uid);
		$done = $this->db->update($this->table, $data);
		if ($done) {
			return "User has been Unblocked";
		} else {
			return "Failed, Try Again";
		}
	}


	public function getPermissions()
	{
		$query = $this->db->get("permissions");
		$perms = $query->result();
		return $perms;
	}
	public function groupPermissions($group)
	{
		$query = $this->db->query("SELECT permissions.id, name, definition,id,group_permissions.permission_id from permissions,group_permissions where permissions.id=group_permissions.permission_id and id='$group'");
		$perms = $query->result_array();
		return $perms;
	}

	public function getGroupPerms($groupId = FALSE)
	{
		$this->db->where('id', $groupId);
		$this->db->join('permissions', 'permissions.id=group_permissions.permission_id');
		$qry = $this->db->get('group_permissions');
		return $qry->result();
	}
	public function getUserPerms($groupId)
	{
		$this->db->where('id', $groupId);
		$qry = $this->db->get('group_permissions');
		$permissions = $qry->result();
		$perms = array();
		foreach ($permissions as $perm) {
			array_push($perms, $perm->permission_id);
		}
		return $perms;
	}
	public function savePermissions($data)
	{
		$data['definition'] = ucwords($data['definition']);
		$data['name'] = strtolower(str_replace(" ", "", $data['name']));
		$save = $this->db->insert('permissions', $data);
		return $save;
	}
	public function assignPermissions($groupId, $data)
	{
		if (count($data) > 0) {
			$this->db->where('id', $groupId);
			$this->db->delete('group_permissions');
			$save = $this->db->insert_batch('group_permissions', $data);
			return $save;
		}
		return false;
	}
	public function access_level1($user_id)
	{
	
	}
	public function access_level2($user_id)
	{
	
	}

	public function user_permissions($role)
	{
		 $this->db->select('permission_id');
		 $this->db->where("group_id", $role);
		$query = $this->db->get('group_permissions')->result();

		$perms = array();
		foreach ($query as $perm) {
			array_push($perms, $perm->permission_id);
		}
		return $perms;
	}

	public function find_user($id)
	{
		$this->db->where('user_id', $id);
		return $this->db->get($this->table, $id)->row();
	}
	// change password
	public function changePass($postdata)
	{
		$oldpass = $postdata['old_password'];
		$newpass = $this->argonhash->make($postdata['new_password']);
		$user = $this->session->get_userdata();
		$uid = $user['id'];
		$this->db->select('password');
		$this->db->where('id', $uid);
		$qry = $this->db->get($this->table);
		$user = $qry->row();
		
		
		if($this->validate_password($oldpass,$user->password)){
		
			// change the password
			$data = array("password" => $newpass, "isChanged" => 1);
			$this->db->where('id', $uid);
			$query = $this->db->update($this->table, $data);

			if ($query) {
				$_SESSION['changed'] = 1;
				return "Password Change Successful";
			} else {
				return "Operation failed, try again";
			}
		} else {
			return "The old password you provided is wrong";
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

	// Security and logging methods
	public function get_failed_attempts($email)
	{
		$this->db->where('email', $email);
		$this->db->where('attempt_time >', date('Y-m-d H:i:s', strtotime('-15 minutes')));
		$query = $this->db->get('login_attempts');
		return $query->num_rows();
	}
	
	public function log_failed_attempt($email, $reason, $ip_address)
	{
		$data = array(
			'email' => $email,
			'reason' => $reason,
			'ip_address' => $ip_address,
			'attempt_time' => date('Y-m-d H:i:s')
		);
		$this->db->insert('login_attempts', $data);
	}
	
	public function clear_failed_attempts($email)
	{
		$this->db->where('email', $email);
		$this->db->delete('login_attempts');
	}
	
	public function log_successful_login($email, $ip_address)
	{
		$data = array(
			'email' => $email,
			'ip_address' => $ip_address,
			'login_time' => date('Y-m-d H:i:s')
		);
		$this->db->insert('login_logs', $data);
	}
	
	public function store_remember_token($user_id, $token, $expiry)
	{
		$data = array(
			'user_id' => $user_id,
			'token' => $token,
			'expires_at' => date('Y-m-d H:i:s', $expiry),
			'created_at' => date('Y-m-d H:i:s')
		);
		$this->db->insert('remember_tokens', $data);
	}
	
	public function get_user_by_remember_token($token)
	{
		$this->db->select('u.*');
		$this->db->from('user u');
		$this->db->join('remember_tokens rt', 'u.id = rt.user_id');
		$this->db->where('rt.token', $token);
		$this->db->where('rt.expires_at >', date('Y-m-d H:i:s'));
		$query = $this->db->get();
		return $query->row();
	}
	
	public function delete_remember_token($token)
	{
		$this->db->where('token', $token);
		$this->db->delete('remember_tokens');
	}
	
}
