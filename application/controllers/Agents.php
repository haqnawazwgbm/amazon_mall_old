<?php  

/**
*. Agents Controller 
*/

class Agents extends CI_Controller
{
	private $agent_id;
	
	function __construct()
	{
		parent::__construct();
		$this->agent_id = $this->session->userdata('user_id');
	}

	function customers()
	{
		
		$data['country'] =  $this->Admin->getAllData('countries');
		$this->load->view('agents/agents',$data);
		if ($this->session->userdata('logged') != true) {
			redirect(base_url().'Login');
		}
		$type = $this->session->userdata('user_type');
		if ($type != "Admin" ) {
			redirect(base_url().'Login');
		}
	}

	function users()
	{
		$data['country'] =  $this->Admin->getAllData('countries');
		$this->load->view('agents/users',$data);
		if ($this->session->userdata('logged') != true) {
			redirect(base_url().'Login');
		}
		$type = $this->session->userdata('user_type');
		if ($type != "Admin" ) {
			redirect(base_url().'Login');
		}
	}

	// Adding New Agent
	function UploadAgent()
	{
		$status = $this->input->post('status');
		// Creating Password
		$name = $this->input->post('fullname');
		$firstChar = substr($name,0,4);
		$password = $firstChar.rand();
		$newpassword = md5($password);
		$email = $this->input->post('email');

		$getEmail = $this->Admin->getAllData('users','email_id',array('email_id' => $email));
		if (!empty($getEmail[0]->email_id)) {
			$response = array('success' => true, 'param' => 'danger', 'message' => 'Email Already Exists');
			echo json_encode($response);
			die;
		}
		// Password created;
		$agentArray = array(
			'title'  		=> $this->input->post('title'),  
			'fullname'  	=> $this->input->post('fullname'),  
			'email_id'   	=> $this->input->post('email'),  
			'phone_login'  	=> $this->input->post('phone'),  
			'phone'   		=> $this->input->post('phone-opt'),  
			'nationality'   => $this->input->post('nationality'),
			'address'  		=> $this->input->post('address'),  
			'country'  		=> $this->input->post('country'),
			'province'  	=> $this->input->post('province'),  
			'district'  	=> $this->input->post('district'),  
			'city'  		=> $this->input->post('city'),  
			'status'  		=> isset($status) ? $status : 0,  
			'type'  		=> $this->input->post('type'),  
			'cnic'  		=> $this->input->post('cnic'),  
			'agent_id'  		=> $this->agent_id,  
			'password'  	=> $newpassword  
		);

		$saveAgent = $this->Admin->InsertData('users',$agentArray);

		if ($saveAgent) {
			// Sending Email
// 			$config = array(
// 					        'mailtype'  => 'html', 
// 					        'charset' => 'utf-8',
// 					        'wordwrap' => TRUE

//   					 );
//     		$this->load->library('email', $config);
// 			$this->email->from('info@swatshawls.com', 'Amazon');
// 			$this->email->to($email);
// 			$this->email->subject('Profile Details');
// 			$this->email->message('Your Profile is Successfully Created. You login Email is:
// 								  '.$email.'<br> Your Password is:'.$password.'<br> Thank You');
// 			$this->email->send(); 
			// Email End
			$response = array('success' => true, 'param' => 'success', 'message' => 'New Agent Added Successfully');
			echo json_encode($response);
		}
		else
		{
			$response = array('success' => false, 'param' => 'danger', 'message' => 'Failed to Add New Agent');
			echo json_encode($response);
		}
	}

	// getting all agents
	function getAllAgents($type = 'customer')
	{
		$selectOnlyColumns = 'user_id,fullname,type,email_id,title,status,phone,phone_login,city,country'; 
		if ($type == 'customer') {
				$condition = array(
				'users.type' => 'User'
			);	
		} elseif ($type == 'user') {
				$condition = array(
				'users.type !=' => 'User'
			);
		}
		
		$AllAgents = $this->Admin->getAllData('users',$selectOnlyColumns, $condition);
		$fetchAllAgents = array();
		foreach ($AllAgents as $each) {
			// Checking Status
			$Buttons = '<div class="btn-group">
				<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loadDatas" onclick="doAgentAction(1,'.$each->user_id.')"> <span class="fa fa-eye fa-lg"></span> </button>
				<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#loadDatas" onclick="doAgentAction(2,'.$each->user_id.')"> <span class="fa fa-pencil fa-lg"></span> </button>
				<button class="btn btn-danger btn-sm" onclick="reSendPassword('.$each->user_id.')"> Resend Password </button>';
			$status = '';
			if ($each->status == 0) {
				$status = "<b><small>Not Approved</small></b>";
				$Buttons = $Buttons.'<button class="btn btn-success btn-sm" onclick="performAction(\'performAgentAction\',1,'.$each->user_id.')"> <span class="fa fa-check fa-lg"></span> </button>
					</div>';
			}
			else
			{
				$status = "<b><small>Approved</small></b>";
				$Buttons = $Buttons.'<button class="btn btn-info btn-sm" onclick="performAction(\'performAgentAction\',0,'.$each->user_id.')"> <span class="fa fa-times-circle fa-lg"></span> </button></div>';

			}

			$phone = '';
			if (!empty($each->phone)) {
				$phone = $each->phone;
			}
			else
			{
				$phone = $each->phone_login;
			}
			$Country = '';
			if (!empty($each->country)) {
				$get = $this->Admin->getAllData('countries','country_name',array('id' => $each->country));
				$Country = @$get[0]->country_name;
			}

			$fetchAllAgents[] = array(
				'11' 	=> $each->type,
				'0' 	=> $each->title.' '.$each->fullname,
				'1' 	=> $each->email_id,
				'2' 	=> $phone,
				'3' 	=> $each->city,
				'4' 	=> $Country,
				'5' 	=> $status,
				'6' 	=> $Buttons,
			);
		}
		$output = array(
             "data" => $fetchAllAgents
        );
        echo json_encode($output);
	}

	// Approve Or Disable Agents

	function performAgentAction()
	{
		$userID = $this->input->post('id');
		$status = $this->input->post('status');
		$UpdateStatus = $this->Admin->UpdateDB('users',array('user_id' => $userID),array('status' => $status));
		if ($UpdateStatus){
			$response = array('success' => true, 'param' => 'success', 'message' => 'Agent Status Updated');
			echo json_encode($response);
		}
		else
		{
			$response = array('success' => false, 'param' => 'danger', 'message' => 'Agent Status Updation Failed');
			echo json_encode($response);
		}
	}

	// To Delete Agent
	
	function deleteAgent()
	{
		$userid = $this->input->post('id');
		$Delete = $this->Admin->DeleteDB('users',array('user_id' => $userid));
		if ($Delete){
			$response = array('success' => true, 'param' => 'success', 'message' => 'Agent Deleted');
			echo json_encode($response);
		}
		else
		{
			$response = array('success' => false, 'param' => 'danger', 'message' => 'Agent Deleted Updation Failed');
			echo json_encode($response);
		}
	}

	// To Modify Agent

	function EditAgent()
	{
		$userid = $this->input->post('id');
		$getAgent = $this->Admin->getAllData('users','',array('user_id' => $userid));
		$data['getAgent'] = json_encode($getAgent);
		$data['country'] =  $this->Admin->getAllData('countries');
		$this->load->view('agents/edit_agent',$data);
	}
	// Updating The Agent
	function ModifyAgent()
	{
		$id = $this->input->post('user_id');
		$data = $_POST;
		$update = $this->Admin->UpdateDB('users',array('user_id' => $id),$data);
	}

	// To View Agent

	function ViewAgent()
	{
		$userid = $this->input->post('id');
		$getAgent = $this->Admin->DJoin('*',
			'users',
			'countries',
			 array(
			 	'provinces' => 'provinces.province_id = users.province',
			 	'districts' => 'districts.id = users.district'
			 ),
			'users.country = countries.id',array('user_id' => $userid));;
		$Json = json_encode($getAgent);
		$this->load->view('agents/view_agent',array('getAgent' => $Json));
	}

	function ResendPassword()
	{
		$id = $this->input->post('id');
		$getEmail = $this->Admin->getAllData('users','email_id',array('user_id' => $id));
		$email = $getEmail[0]->email_id;
		$firstChar = substr($email,0,4);
		$password = $firstChar.rand();
		$newpassword = md5($password);
		$updatePassword =  $this->Admin->UpdateDB('users',array('user_id' => $id),array('password' => $newpassword));
		if ($updatePassword){
			// Sending Email
			$config = array(
					        'mailtype'  => 'html', 
					        'charset' => 'utf-8',
					        'wordwrap' => TRUE

   					 );
    		$this->load->library('email', $config);
			$this->email->from('info@swatshawls.com', 'Amazon');
			$this->email->to($email);
			$this->email->subject('Profile Details');
			$this->email->message('A New Password has been Created. You login Email is:
								  '.$email.'<br> Your New Password is:'.$password.'<br> Thank You');
			$this->email->send(); 
			// Email End
		
		
			$response = array('success' => true, 'param' => 'success', 'message' => 'Password Updated');
			echo json_encode($response);
		}
		else
		{
			$response = array('success' => false, 'param' => 'danger', 'message' => 'Password Updation Failed');
			echo json_encode($response);
		}
	}

	function RecheckEmail()
	{
		$email = $this->input->post('val');
		$getEmail = $this->Admin->getAllData('users','email_id',array('email_id' => $email));
		$email = @$getEmail[0]->email_id;
		if (!empty($email)){
			$response = array('success' => true, 'param' => 'success', 'message' => 'Email Already Exists');
			echo json_encode($response);
		}
		else
		{
		    echo "0";
		}
	}

}
?>