<?php

/**
*	Projects Controller
*/

class Projects extends CI_Controller
{
	// Constructor
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('logged') != true) {
			redirect(base_url().'Login');
		}
		$type = $this->session->userdata('user_type');
		if ($type != "Admin") {
			redirect(base_url().'Login');
		}
	}

	function index()
	{
		$this->load->view('projects/projects');
	}

	function UploadProject()
	{
		$saveAgent = $this->Admin->InsertData('project',$_POST);
		if ($saveAgent) {
			$response = array('success' => true, 'param' => 'success', 'message' => 'New Project Added Successfully');
			echo json_encode($response);
		}
		else
		{
			$response = array('success' => false, 'param' => 'danger', 'message' => 'Failed to Add Project');
			echo json_encode($response);
		}
	}
	
	function addFiles()
	{
		$data['id'] = $this->uri->segment(3);
		$this->load->view('projects/files',$data);
	}

	function getAllFiles()
	{
		$id = $this->input->post('id');
		$data['allfiles'] = $this->Admin->getAllData('files','',array('type_id' => $id,'type' => 'Project','is_deleted' => 'N'));
		$this->load->view('projects/allfiles',$data);
	}
	
	function deletefile()
	{
		$this->Admin->UpdateDB('files',array('id' => $_POST['id']),array('is_deleted' => 'Y'));
	}

	function UploadFiles()
	{
		$id = $this->input->post('id');
		$FileName = $_FILES['file']['name']; 
		$FileTmp  = $_FILES['file']['tmp_name']; 
		$uploadfile = $this->Admin->fileUpload($FileName,$FileTmp,'files');
		// Checking For Existing Data
		$planArray = array(
			'orignal_name' => $uploadfile['orignal'],
			'filename' => $uploadfile['filename'],
			'url' => base_url().'assets/uploads/files/',
			'extension' => $uploadfile['ext'],
			'type' => 'Project',
			'type_id' => $id
		);
		$UploadFile = $this->Admin->InsertData('files',$planArray);

	}

	function getAllProjects()
	{
		$AllAgents = $this->Admin->getAllData('project');
		$fetchAllAgents = '';
		$ActionButton = '';

		foreach ($AllAgents as $each) {
			// Checking Status
			$Buttons = '<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#loadDatas" onclick="doAgentAction('.$each->project_id.')"><span class="glyphicon glyphicon-pencil fa-lg"></span></button><a href="'.base_url().'Projects/addFiles/'.$each->project_id.'" class="btn btn-primary btn-sm">Files</a>';

			$fetchAllAgents[] = array(
				'1' 	=> $each->project_name,
				'2' 	=> $each->project_location,
				'3' 	=> date("d M Y",strtotime($each->starting_date)),
				'4' 	=> date("d M Y",strtotime($each->expected_end)),
				'5' 	=> $each->size_sqft.' square feet',
				'6' 	=> $Buttons,
			);
		}
		$output = array(
             "data" => $fetchAllAgents
        );
        echo json_encode($output);
	}

	function deleteProject()
	{
		$userid = $this->input->post('id');
		$Delete = $this->Admin->DeleteDB('project',array('project_id' => $userid));
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

	function EditProject()
	{
		$userid = $this->input->post('id');
		$getAgent = $this->Admin->getAllData('project','',array('project_id' => $userid));
		$Json = json_encode($getAgent);
		$this->load->view('projects/edit_project',array('project' => $Json));
	}

	function ModifyProject()
	{
		$id = $this->input->post('project_id');
		$data = $_POST;
		$update = $this->Admin->UpdateDB('project',array('project_id' => $id),$data);
	}

	function ViewProject()
	{
		$userid = $this->input->post('id');
		$getAgent = $this->Admin->getAllData('project','',array('project_id' => $userid));
		$Json = json_encode($getAgent);
		$this->load->view('projects/view_project',array('getAgent' => $Json));
	}

}

?>
