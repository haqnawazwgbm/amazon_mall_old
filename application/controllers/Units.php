<?php  
/**
*  Units Sizes Prices & Other Details
*/
class Units extends CI_Controller
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

	function index()
	{
		$data['project']  = json_encode($this->Admin->getAllData('project','project_id,project_name'));
		$this->load->view('units/unit_details',$data);
	}

	function getFloors()
	{
		$id = $this->input->post('id');
		if (!empty($id)) {
			$floors = $this->Admin->getAllData('basic_floors','floor_id,floor_types',array('project_id' => $id));
			echo '<div class="form-group">                                        
	            <label class="col-md-6 col-xs-12 control-label"><br>Unit Size/Square Feet</label>
	            <div class="col-md-12 col-xs-12">';            
			echo "<select class='form-control' name='floor_id'>";
			echo "<option>Select Floor</option>";
			foreach ($floors as $each) {
				echo '<option value="'.$each->floor_id.'">'.$each->floor_types.'</option>';
			}
			echo "</select></div></div>";
		}
	}

	// Adding New Units
	function saveUnitDetails()
	{
		$saveUnits = $this->Admin->InsertData('sales_units',$_POST);
		if ($saveUnits) {
			$response = array('success' => true, 'param' => 'success', 'message' => 'Sale Unit Added Successfully');
			echo json_encode($response);
		}
		else
		{
			$response = array('success' => false, 'param' => 'danger', 'message' => 'Failed to Add New Sale Unit');
			echo json_encode($response);
		}
	}
	
	function addFiles()
	{
		$data['id'] = $this->uri->segment(3);
		$this->load->view('units/files',$data);
	}

	function getAllFiles()
	{
		$id = $this->input->post('id');
		$data['allfiles'] = $this->Admin->getAllData('files','',array('type_id' => $id,'type' => 'Units','is_deleted' => 'N'));
		$this->load->view('units/allfiles',$data);
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
			'type' => 'Units',
			'type_id' => $id
		);
		$UploadFile = $this->Admin->InsertData('files',$planArray);

	}
	// getting all Unitss
	function getAllUnits()
	{
		$AllUnitss = $this->Admin->DJoin('*,sales_units.unit_id,sales_units.price_sqft as shop_price_sqft,sales_units.size_sqft as size','sales_units','basic_floors',array('project' => 'project.project_id = basic_floors.project_id'),'sales_units.floor_id = basic_floors.floor_id');
		$fetchAllUnitss = array();
		$ActionButton = '';
		foreach ($AllUnitss as $each) {
			$UnitChanges  = $this->Admin->getAllData('unit_changes','',array('unit_id' => $each->unit_id));
			// Checking Status
			$Buttons = '<div class="btn-group">
			<a href="'.base_url().'Units/addFiles/'.$each->unit_id.'" class="btn btn-danger btn-sm">Files</a>
				<a href="'.base_url().'Units/unitdetails/'.$each->unit_id.'" class="btn btn-primary btn-sm"> See Details </a>
				<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#GetAlLData" onclick="doUnitsAction(2,'.$each->unit_id.')"> Edit </button>
				';
			$Archecticural = '<a href="'.base_url().'Units/plans/'.$each->unit_id.'" class="btn btn-default">See Details</a>';
		
			$fetchAllUnitss[] = array(
				'11' 		=> substr($each->shopID,0,7),
				'0' 		=> $each->shopID,
				'1' 		=> $each->unit_type,
				'2' 		=> $each->floor_types,
				'7' 		=> $each->project_name,
				'3' 		=> $each->size,
				'4' 		=> $each->shop_price_sqft == "" ? 'Rs.'.number_format($each->price_sqft,2,'.',',') : 'Rs.'.number_format($each->shop_price_sqft,2,'.',','),
				'5' 		=> $each->shop_price_sqft == "" ? 'Rs.'.number_format($each->price_sqft * $each->size,2,'.',',') : 'Rs.'.number_format($each->shop_price_sqft * $each->size,2,'.',','),
				'9' 		=> $Buttons,
			);
		}
		$output = array(
             "data" => $fetchAllUnitss
        );
        echo json_encode($output);
	}

	
	// To Modify Units
	function EditUnits()
	{
		$unit_id = $this->input->post('id');
		$getUnits = $this->Admin->getAllData('sales_units','',array('unit_id' => $unit_id));
		$data['getUnits'] = json_encode($getUnits);
		$data['project']  = json_encode($this->Admin->getAllData('project'));
		$data['Floors']   = json_encode($this->Admin->getAllData('basic_floors'));
		$this->load->view('units/edit_unit_detail',$data);
	}

	// Updating The Units
	function ModifyUnits()
	{
		$id = $this->input->post('unit_id');
		//Creating Change Report
		$GetPreviousData = $this->Admin->getAllData('sales_units','',array('unit_id' => $id));
		$changesReport = '';
		if (!empty($GetPreviousData)) {
			foreach ($GetPreviousData as $pre) {
				$changesReport = array(
					'unit_id' => $id,
					'change_in_size' =>	$pre->size_sqft,
					'authorized_files'  => 's',
				);
			}
		}
		$Insert = $this->Admin->InsertData('unit_changes',$changesReport);
		
		// Saving Changes Made
		$data = $_POST;
		$update = $this->Admin->UpdateDB('sales_units',array('unit_id' => $id),$data);
		if ($update) {
			$response = array('success' => true, 'param' => 'success', 'message' => 'Sale Units Updated');
			echo json_encode($response);
		}
		else
		{
			$response = array('success' => false, 'param' => 'danger', 'message' => 'Sale Units Updation  Failed');
			echo json_encode($response);
		}
	}

	// To View Units
	function unitdetails()
	{
		$ReportId  = $this->uri->segment(3);
		$AllUnits  = $this->Admin->DJoin(
						'*,sales_units.size_sqft as size',
						'sales_units',
						'basic_floors',
						array('project' => 'project.project_id = basic_floors.project_id'),
						'sales_units.floor_id = basic_floors.floor_id',
						"sales_units.unit_id ='$ReportId'"
					);
		$Json = json_encode($AllUnits);
		$this->load->view('units/view_unit',array('getUnits' => $Json));
	}

	// To View Units
	function unitchanges()
	{
		$ReportId = $this->uri->segment(3);
		$getUnits = $this->Admin->DJoin(
						'*',
						'unit_changes',
						'sales_units',
						'',
						'unit_changes.unit_id = sales_units.unit_id',
						"unit_changes.unit_id ='$ReportId'"
					);
		$Json = json_encode($getUnits);
		$this->load->view('unit_changes/unit_change_report',array('getUnits' => $Json));
	}

	// Adding Architecture Files to Sale Unit

	function AddArchiFiles()
	{
		$Zoneid   = $this->input->post('saleunit');
		$FileName = $_FILES['file']['name']; 
		$FileTmp  = $_FILES['file']['tmp_name']; 
		$uploadfile = $this->Admin->fileUpload($FileName,$FileTmp,'Sales_Unit');
		// Checking For Existing Data
		$archiFiles = $this->Admin->getAllData('sales_units','archi__plans',array('unit_id' => $Zoneid));

		
		$planArray = array(
			'orignal' => $uploadfile['orignal'],
			'filename' => $uploadfile['filename'],
			'url' => base_url().'/assets/uploads/Sales_Unit/',
			'ext' => $uploadfile['ext'],
			'isShown' => true,
			'isDeleted' => false
		);

		$archiplan = [];
		$architectFiles = $archiFiles[0]->archi__plans;
		if (!empty($architectFiles)) {
			$Planed = json_decode($architectFiles);
			foreach ($Planed as $previous) {
				$archiplan[] = $previous;
			}
			$archiplan[] = $planArray;
			$EncodeThem  = json_encode($archiplan);
			$Update  = $this->Admin->UpdateDB('sales_units',array('unit_id' => $Zoneid),array('archi__plans'=>$EncodeThem));
		}
		else
		{
			$archiplan[] = $planArray;
			$EncodeThem  = json_encode($archiplan);
			$Update  = $this->Admin->UpdateDB('sales_units',array('unit_id' => $Zoneid),array('archi__plans'=>$EncodeThem));
		}
		if ($Update) {
			$response  = array('success'=> true,'status'=> 200, 'message' => 'Architecture Plan Added');
			echo json_encode($response);
		}
		else
		{
			$response  = array('success'=> false,'status'=> 403, 'message' => 'Failed To Add Plans');
			echo json_encode($response);
		}
		
	}

	function uploadAuthorizeFiles()
	{
		$Zoneid   = $this->input->post('saleunit');
		$FileName = $_FILES['file']['name']; 
		$FileTmp  = $_FILES['file']['tmp_name']; 
		$uploadfile = $this->Admin->fileUpload($FileName,$FileTmp,'Unit_Authorization_files','Unit_Change_id_'.$Zoneid);
		// Checking For Existing Data
		$archiFiles = $this->Admin->getAllData('unit_changes','authorized_files',array('unit_change_id' => $Zoneid));

		
		$planArray = array(
			'orignal' => $uploadfile['orignal'],
			'filename' => $uploadfile['filename'],
			'url' => base_url().'/assets/uploads/Unit_Authorization_files/Unit_Change_id_'.$Zoneid,
			'ext' => $uploadfile['ext'],
			'isShown' => true,
			'isDeleted' => false
		);

		$archiplan = [];
		$architectFiles = $archiFiles[0]->authorized_files;
		if (!empty($architectFiles)) {
			$Planed = json_decode($architectFiles);
			foreach ($Planed as $previous) {
				$archiplan[] = $previous;
			}
			$archiplan[] = $planArray;
			$EncodeThem  = json_encode($archiplan);
			$Update  = $this->Admin->UpdateDB('unit_changes',array('unit_change_id' => $Zoneid),array('authorized_files'=>$EncodeThem));
		}
		else
		{
			$archiplan[] = $planArray;
			$EncodeThem  = json_encode($archiplan);
			$Update  = $this->Admin->UpdateDB('unit_changes',array('unit_change_id' => $Zoneid),array('authorized_files'=>$EncodeThem));
		}
		if ($Update) {
			$response  = array('success'=> true,'status'=> 200, 'message' => 'Files Added');
			echo json_encode($response);
		}
		else
		{
			$response  = array('success'=> false,'status'=> 403, 'message' => 'Failed To Add Files');
			echo json_encode($response);
		}
	}

	function AuthorizedFiles()
	{
		$id = $this->input->post('id');
		$getFiles = $this->Admin->getAllData('unit_changes','authorized_files',array('unit_change_id' => $id));
		$this->load->view('unit_changes/unit_authorize_files',array('files' => $getFiles,'id' => $id));
	}

	function getID()
	{
		$project = $_POST['project'];
		$floor = $_POST['floor'];
		$unit = $_POST['unit'];
		$id = '';
		$pexp = explode(" ",$project);
		if (!empty($pexp[0])) {
			$pre  = substr($pexp[0],0,1);
			if (!empty($pexp[1])) {
				$post = substr($pexp[1],0,1).'-';
			}
			else
			{
				$post = "1-";
			}
			$id  .= $pre.$post; 
		}
		$fexp = explode(" ",$floor);
		if (!empty($fexp[0])) {
			$pre  = substr($fexp[0],0,1);
			if (!empty($fexp[1])) {
				$post = substr($fexp[1],0,1).'-';
			}
			else
			{
				$post = "1-";
			}
			$id  .= $pre.$post; 
		}
		$uexp = explode(" ",$unit);
		if (!empty($uexp[0])) {
			$pre  = substr($uexp[0],0,1);
			if (!empty($uexp[1])) {
				$post = substr($uexp[1],0);
			}
			else
			{
				$post = "1";
			}
			$id  .= $pre.$post; 
		}
		echo trim($id);
	}

}
?>		