<?php  

/**
*. Floors Controller 
*/

class Floors extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('logged') != true) {
			redirect(base_url().'Login');
		}
		$type = $this->session->userdata('user_type');
		if ($type != "Admin" ) {
			redirect(base_url().'Login');
		}
	}

	function Floors()
	{
		$data['Projects'] = json_encode($this->Admin->getAllData('project','project_id,project_name'));
		$this->load->view('floors/floors',$data);
	}

	function saveFloor()
	{
		$SaveFloor = $this->Admin->InsertData('basic_floors',$_POST);
		if ($SaveFloor){
			$response = array('success' => true, 'param' => 'success', 'message' => 'Floor Added');
			echo json_encode($response);
		}
		else
		{
			$response = array('success' => false, 'param' => 'danger', 'message' => 'Failed To Add Unit');
			echo json_encode($response);
		}
	}
	function addFiles()
	{
		$data['id'] = $this->uri->segment(3);
		$this->load->view('floors/files',$data);
	}

	function viewFloor()
	{
		$id = $this->uri->segment(3);
		$data['floor'] =  $this->Admin->DJoin('*,basic_floors.size_sqft as one','basic_floors','project','','basic_floors.project_id = project.project_id',array('basic_floors.floor_id' => $id));
		$data['units'] = $this->Admin->DJoin('*,basic_floors.price_sqft as one,sales_units.size_sqft as size','basic_floors','sales_units','','basic_floors.floor_id = sales_units.floor_id',array('basic_floors.floor_id' => $id));
		$this->load->view('floors/floordetails',$data);
	}

	function getAllFiles()
	{
		$id = $this->input->post('id');
		$data['allfiles'] = $this->Admin->getAllData('files','',array('type_id' => $id,'type' => 'Floor','is_deleted' => 'N'));
		$this->load->view('floors/allfiles',$data);
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
			'type' => 'Floor',
			'type_id' => $id
		);
		$UploadFile = $this->Admin->InsertData('files',$planArray);

	}
	// getting all floor
	function getAllFloors()
	{
		$Floors = $this->Admin->DJoin('*,basic_floors.size_sqft as one','basic_floors','project','','basic_floors.project_id = project.project_id');
		$AllFloors = array();
		$ActionButton = '
		';
		$i = 1;
		foreach ($Floors as $each) {
			// Checking Status
			$Buttons = '<div class="btn-group">
			<a href="'.base_url().'Floors/viewFloor/'.$each->floor_id.'" class="btn btn-info btn-sm">View Details</a>
				<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#loadDatas" onclick="doFloorAction(2,'.$each->floor_id.')"> <span class="fa fa-pencil fa-lg"></span> </button><a href="'.base_url().'Floors/addFiles/'.$each->floor_id.'" class="btn btn-primary btn-sm">Files</a>';
			$AllFloors[] = array(
				'1' 	=> $i,
				'2' 	=> $each->floor_types,
				'3' 	=> $each->project_name,
				'4' 	=> $each->one,
				'5' 	=> date("d M Y h:i:s a",strtotime($each->created_at)),
				'7' 	=> 'Rs.'.number_format($each->price_sqft,2,'.',','),
				'6' 	=> $Buttons,
				'8' 	=> 'Rs.'.number_format($each->rent_price,2,'.',','),
			);
			$i++;
		}
		$output = array(
             "data" => $AllFloors
        );
        echo json_encode($output);
	}

	// To Delete Floors
	function deleteFloors()
	{
		$Floors = $this->input->post('id');
		$Delete = $this->Admin->DeleteDB('basic_floors',array('floor_id' => $Floors));
		if ($Delete){
			$response = array('success' => true, 'param' => 'success', 'message' => 'Floors Deleted');
			echo json_encode($response);
		}
		else
		{
			$response = array('success' => false, 'param' => 'danger', 'message' => 'Floors Deleted Failed');
			echo json_encode($response);
		}
	}

	// To Modify Floors
	function EditFloors()
	{
		$data['Projects'] = json_encode($this->Admin->getAllData('project','project_id,project_name'));
		$Floorsid = $this->input->post('id');
		$getUnit = $this->Admin->getAllData('basic_floors','',array('floor_id' => $Floorsid));
		$data['Floors'] = json_encode($getUnit);
		$this->load->view('floors/edit_floor',$data);
	}

	// Updating The Floors
	function ModifyFloors()
	{
		$id = $this->input->post('floor_id');
		$data = $_POST;
		$data['updated_at'] = date("Y-m-d h:i:s");
		$update = $this->Admin->UpdateDB('basic_floors',array('floor_id' => $id),$data);
		if ($update){
			$response = array('success' => true, 'param' => 'success', 'message' => 'Floors Updated');
			echo json_encode($response);
		}
		else
		{
			$response = array('success' => false, 'param' => 'danger', 'message' => 'Floors Updated Failed');
			echo json_encode($response);
		}
	}
	
}

?>