<?php  


/**
*.  Password Changing Panel 
*/


class Password extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();	
	}

	function index()
	{
		$this->load->view('password/index');
	}

	function changePassword()
	{
		$userid = $this->session->userdata('user_id');
		if (!empty($userid)) {
			$oldPassword = $this->input->post('old');
			// Checking if Old Password is correct
			$oldPasswordCheck = $this->Admin->getAllData('users','password',array('user_id'=> $userid,'password' => md5($oldPassword)));
			if (!empty($oldPasswordCheck[0]->password)) {
				$newPassword = $this->input->post('new');
				$updateNewPassword = $this->Admin->UpdateDB('users',array('user_id' => $userid),array('password' => md5($newPassword)));
				if ($updateNewPassword) {
					$response = array('success' => true, 'param' => 'success', 'message' => 'Password Updated Successfully','clear' => 1);
					echo json_encode($response);
				}
				else
				{
					$response = array('success' => false, 'param' => 'warning', 'message' => 'Server Error');
					echo json_encode($response);
				}
			}
			else
			{
				$response = array('success' => false, 'param' => 'danger', 'message' => 'Old Password is Incorrect');
				echo json_encode($response);
			}
		}
	}


}
?>