<?php

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

	}
	
	public function index($message = '')
	{
		$data['Message'] = '';
		if (!empty($message)) {
			$data['Message'] = $this->Message($message);
		}
		else
		{
			$data['Message'] = '';
		}
		$this->load->view('login',$data);
	}

	function signup()
	{
		$login 		= $this->input->post('email');
		$password 	= md5($this->input->post('password'));
		if (empty($login) || empty($password)) {
			$Message = array('Message' => 'Please Fill The Fields','type' => 'default');
			$this->index($Message);
		}
		else
		{
		// Checking for email or phone
		$email = $this->Admin->getAllData('users','*',array('email_id' => $login,'status' => '1'));
		if (!empty($email)) {
			// Authentication
			$getAuthentication = $this->Admin->Authentication('users',array('email_id' => $login,'password' => $password));
			if ($getAuthentication) {
				$session = array(
					'user_type' => $getAuthentication->type,
					'email' => $getAuthentication->email_id,
					'fullname' => $getAuthentication->fullname,
					'user_id' => $getAuthentication->user_id,
					'logged' => true
				);
				$this->session->set_userdata($session);
				$usertype = $getAuthentication->type;
				if ($usertype == "Accountant") {
					redirect(base_url().'Sales');
				}
				else if($usertype == "Agent")
				{
					redirect(base_url().'Cif');
				}
				else if($usertype == "Admin")
				{
					redirect(base_url().'Master/dashboard');
				} elseif ($usertype == 'ccd') {
					redirect(base_url().'Cif');
				}
				else
				{
					redirect(base_url().'Customers');
				}
			}
			else
			{
				$Message = array('Message' => 'Password is incorrect','type' => 'error');
				$this->index($Message);
			}
		}
		else
		{
			$phone = $this->Admin->getAllData('users','phone_login',array('phone_login' => $login,'status' => 1));
			if ($phone) {
				$getAuthentication = $this->Admin->Authentication('users',array('phone_login' => $login,'password' => $password));
				if ($getAuthentication) {
					$session = array(
						'user_type' => $getAuthentication->type,
						'email' => $getAuthentication->email_id,
						'fullname' => $getAuthentication->fullname,
						'user_id' => $getAuthentication->user_id,
						'logged' => true
					);
					$this->session->set_userdata($session);
					$usertype = $getAuthentication->type;
					if ($usertype == "Accountant") {
						redirect(base_url().'Sales');
					}
					else if($usertype == "Agent")
					{
						redirect(base_url().'Cif');
					}
					else if($usertype == "Admin")
					{
						redirect(base_url().'Master/dashboard');
					}
					else
					{
						redirect(base_url().'Customers');
					}
				}
				else
				{
					$Message = array('Message' => 'Password is incorrect','type' => 'error');
					$this->index($Message);
				}
			}
			else
			{
				$Message = array('Message' => 'Login Details Invalid','type' => 'error');
				$this->index($Message);
			}
			
		}
		}
	}

	function Message($param)
	{
		$message = $param['Message'];
		$type    = $param['type'];
		if ($type == "error") {
			return '<div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <strong>'.$message.'
                </div>';
		}
		else if ($type == "warning") {
			return '<div class="alert alert-warning" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <strong>'.$message.'
                </div>';
		}
		else
		{
			return '<div class="alert alert-info" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <strong>'.$message.'
                </div>';
		}
	}

	function logout()
	{
		$this->session->set_userdata('');
		$this->session->sess_destroy();
		redirect(base_url().'Login');
	}

}
