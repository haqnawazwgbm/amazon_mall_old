<?php  
/**
*  Unit Sales Controller
*/
class Cif extends CI_Controller
{
	private $agent_id;
	private $user_type;
	function __construct()
	{
		parent::__construct();
		$this->agent_id = $this->session->userdata('user_id');
		if ($this->session->userdata('logged') != true) {
			redirect(base_url().'Login');
		}
		$this->user_type = $this->session->userdata('user_type');
		if ($this->user_type != "Admin" && $this->user_type != "Agent" && $this->user_type != 'ccd') {
			redirect(base_url().'Login');
		}
	}

	function index()
	{
		$data['country'] = $this->Admin->getAllData('countries');
		$data['units']   = $this->Admin->getAllData('sales_units','unit_id,unit_type');
		$data['floors']  = $this->Admin->getAllData('basic_floors','floor_id,floor_types');
		$data['project']  = $this->Admin->getAllData('project','project_id,project_name');
		$con['conditions'] = array(
			'status' => 1,
			'type' => 'User'
		);
		$data['users'] = $this->Admin->getRows($con, 'users');
		// Graphs Data
		$this->load->view('cif/cif',$data);
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

	// Get users in dropdown form
	function getUsers($id = '')
	{	
		if ($id != '') {
			$condition = array(
				'status' => 1,
				'user_id !=' => $id
			);
		} else {
			$condition = array(
				'status' => 1
			);
		}
			
			$users = $this->Admin->getAllData('users','user_id,fullname,title',$condition);
		         
			$user_dropdown =  "<select class='form-control selectpicker' data-live-search='true' name='to_user_id' id='to_user_id' required>";
			$user_dropdown = $user_dropdown .  "<option value=''>Select Customer</option>";
			foreach ($users as $user) {
				$user_dropdown = $user_dropdown . '<option value="'.$user->user_id.'">'.$user->title . ' '  . ucfirst($user->fullname) . '</option>';
			}
			$user_dropdown = $user_dropdown . "</select>";
			exit($user_dropdown);
	}

	// Adding New Units
	function saveUser()
	{
		$data = $_POST;
		$data['status'] = 1;
		$data['agent_id'] = $this->agent_id;
		// Creating Password
		$name = $this->input->post('fullname');
		$firstChar = substr($name,0,4);
		$password = $firstChar.rand();
		$newpassword = md5($password);
		$email = $this->input->post('email_id');
		// Password created;
		$data['type'] = 'User';
		$data['password'] = $newpassword;
		$relation = array(
			'relationship' => $this->input->post('relationship'),
			'relation_name' => $this->input->post('relation_name')
		);
		unset($data['relationship']);
		unset($data['relation_name']);
		$con['conditions'] = array(
			'cnic' => $this->input->post('cnic')
		);
		$con['returnType'] = 'single';
		$checkUser = $this->Admin->getRows($con, 'users');
		if ($checkUser) {
			$response = array('success' => false, 'param' => 'danger', 'message' => 'User already exist');
			echo json_encode($response);
		} else {
			$saveUnits = $this->Admin->InsertData('users',$data);
			$userid = $this->db->insert_id();
			$relation['user_id'] = $userid;
			$saveUnits = $this->Admin->InsertData('relation',$relation);
			if ($saveUnits) {
				// Sending Email
				$this->load->library('email');
				$this->email->from('info@swatshawls.com', 'Amazon');
				$this->email->to($email);
				$this->email->subject('Profile Details');
				$this->email->message('Your Profile is Successfully Created. You login Email is:
									  '.$email.'<br> Your Password is:'.$password.'<br> Thank You');
				$this->email->send(); 
				// Email End
				$response = array('success' => true, 'param' => 'success', 'message' => 'User Added Successfully','userid' => $userid);
				echo json_encode($response);
			}
			else
			{
				$response = array('success' => false, 'param' => 'danger', 'message' => 'Failed To Add User');
				echo json_encode($response);
			}
		}
		
	}

	function manyUsers()
	{
		$data['country'] = $this->Admin->getAllData('countries');
		$this->load->view('cif/users',$data);
	}
	function getAllOWners()
	{
		$id = $this->input->post('id');
		$getAllUser = $this->Admin->getAllData('sale','owners',array('sale_id' => $id));
		if (!empty($getAllUser[0]->owners)) {
			$owners = $getAllUser[0]->owners;
			$data['explode'] = explode('-', $owners);
			$this->load->view('cif/ownerslist',$data);
		}
		else
		{
			echo "No Users Found";
		}

	}
	// getting all Unitss
	function getAllUsers()
	{
		/*$allusers = $this->Admin->DJoin(
			'*',
			'users',
			'countries',
			 array(
			 	'provinces' => 'provinces.province_id = users.province',
			 	'districts' => 'districts.id = users.district'
			 ),
			'users.country = countries.id',
			array('users.type' => 'User', 'users.agent_id' => $this->agent_id)
		);*/
		$con['selection'] = '*';
		if ($this->user_type == 'ccd' || $this->user_type == 'Admin') {
			$con['conditions'] = array(
			    'users.type' => 'User'
			);
		} else {
			$con['conditions'] = array(
			    'users.type' => 'User',
			    'users.agent_id' => $this->agent_id
		 	);
		}
		
		$con['innerJoin'] = array(array(
            'table' => 'countries',
            'condition' =>'users.country = countries.id',
            'joinType' => 'left'
        ),array(
            'table' => 'provinces',
            'condition' =>'provinces.province_id = users.province',
            'joinType' => 'left'
        ),array(
            'table' => 'districts',
            'condition' =>'districts.id = users.district',
            'joinType' => 'left'
        ));
        $con['returnType'] = 'object';
		$allusers = $this->Admin->getRows($con, 'users');
		$allusers = $allusers ? $allusers : array();
		$fetchAllUsers = array();
		foreach ($allusers as $each) {
			$Purchased = $this->Admin->getAllData('sale','',array('user_id' => $each->user_id));
			$Purchase = '';
			if (!empty($Purchased)) {
				$Purchase = count($Purchased);
			}
			else
			{
				$Purchase  = 0 ;
			}

			$Buttons = '<div class="btn-group">';
			$Buttons .= '<a onclick="editCustomer('.$each->user_id.')" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
			<a href="'.base_url().'Cif/userDetails/'.$each->user_id.'" class="btn btn-xs btn-success">See Details</a>
						<a onclick="SaleUnit('.$each->user_id.')" class="btn btn-xs btn-danger">Add Sale Unit</a>
						</div>';
			
			$fetchAllUsers[] = array(
				'1' 		=> $each->title.' '.$each->fullname,
				'5' 		=> $each->phone_login,
				'7' 		=> $each->email_id,
				'2' 		=> $each->country_name,
				'3' 		=> $each->province_name,
				'4' 		=> $each->district_name,
				'6' 		=> $each->city,
				'9' 		=> $Purchase.' Unit',
				'8' 		=> $Buttons,
			);
		}
		$output = array(
             "data" => $fetchAllUsers
        );
        echo json_encode($output);
	}

	function userDetails()
	{
		$this->load->view('cif/user_details');
	}

	function editCustomer()
	{
		$id = $this->input->post('id');
		$data['id'] = $id;
		$this->load->view('cif/editcustomer',$data);
	}

	function UpdateCustomer()
	{
		$data = $_POST;
		$user_id = $_POST['user_id'];
		$relation = array(
			'relationship' => $this->input->post('relationship'),
			'relation_name' => $this->input->post('relation_name')
		);
		unset($data['relationship']);
		unset($data['user_id']);
		unset($data['relation_name']);
		$saveUnits = $this->Admin->UpdateDB('users',array('user_id' => $user_id),$data);
		$relation['user_id'] = $user_id;
		$saveUnits = $this->Admin->UpdateDB('relation',array('user_id' => $user_id),$relation);
		if ($saveUnits) {
			$response = array('success' => true, 'param' => 'success', 'message' => 'User Updated Successfully');
			echo json_encode($response);
		}
		else
		{
			$response = array('success' => false, 'param' => 'danger', 'message' => 'Failed To Update');
			echo json_encode($response);
		}
	}

	function userPurchases()
	{
		$id = $this->uri->segment(3);
		/*$AllPurchases = $this->Admin->DJoin(
						'A.sale_id,A.sale_date,C.project_name,C.project_location,D.unit_type,B.floor_types,D.size_sqft,A.pricesqft',
						'sale as A',
						'basic_floors as B',
						array(
							'project as C' => 'C.project_id = B.project_id',
							'sales_units as D' => 'D.unit_id = A.unit_id'
						),
						'A.floor_id = B.floor_id',
						array(
							'A.user_id' => $id
						),
						'A.sale_date ASC'
					);*/
		$con['selection'] = 'A.sale_id,A.sale_date,C.project_name,C.project_location,D.unit_type,B.floor_types,D.size_sqft,A.pricesqft, A.square_feet, B.type as floor_type';
		$con['conditions'] = array(
			'A.user_id' => $id
		);
		$con['orderBy'] = 'A.sale_date ASC';
		$con['returnType'] = 'object';
		$con['innerJoin'] = array(array(
            'table' => 'basic_floors as B',
            'condition' =>'A.floor_id = B.floor_id',
            'joinType' => 'inner'
        ),array(
            'table' => 'project as C',
            'condition' =>'C.project_id = B.project_id',
            'joinType' => 'inner'
        ),array(
            'table' => 'sales_units as D',
            'condition' =>'D.unit_id = A.unit_id',
            'joinType' => 'left'
        ));
        $AllPurchases = $this->Admin->getRows($con, 'sale as A');
        
		$fetchAllPurchases = array();
		$i = 1;
		foreach ($AllPurchases as $each) {
			
			$Buttons = '<div class="btn-group">';
			if ($each->floor_type == 'space') {
				$purchase_url = base_url().'Cif/spacePurchaseDetails/'.$each->sale_id.'/'.$id;
			} else {
				$purchase_url = base_url().'Cif/purchaseDetails/'.$each->sale_id.'/'.$id;
			}
			$Buttons .= '<a href="'.$purchase_url.'" class="btn btn-xs btn-success">View Details</a>
			<a href="'.base_url().'Cif/manyUsers/'.$each->sale_id.'/'.$id.'" class="btn btn-xs btn-danger">Add Members</a>
			<a href="'.base_url().'Cif/AddMoreFiles/'.$each->sale_id.'/'.$id.'" class="btn btn-xs btn-primary">Add Files</a>';
			
			$fetchAllPurchases[] = array(
				'9' 		=> $i,
				'1' 		=> $each->project_name,
				'5' 		=> $each->project_location,
				'7' 		=> $each->floor_type == 'space' ? 'space' : $each->unit_type,
				'2' 		=> $each->floor_types,
				'3' 		=> $each->size_sqft == '' ? $each->square_feet : $each->size_sqft,
				'4' 		=> $each->size_sqft == '' ? $each->square_feet * $each->pricesqft : $each->size_sqft * $each->pricesqft,
				'6' 		=> date("d M Y",strtotime($each->sale_date)),
				'8' 		=> $Buttons,
			);
			$i++;
		}
		$output = array(
             "data" => $fetchAllPurchases
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
					'change_in_price'  => $pre->price_sqft,
					'change_in_tprice'  => $pre->total_price,
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
						'*',
						'sales_units',
						'basic_floors',
						array('project' => 'project.project_id = basic_floors.project_id'),
						'sales_units.floor_id = basic_floors.floor_id',
						"sales_units.unit_id ='$ReportId'"
					);
		$Json = json_encode($AllUnits);
		$this->load->view('units/view-unit',array('getUnits' => $Json));
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
		$this->load->view('unit-changes/unit-change-report',array('getUnits' => $Json));
	}

	function AddMoreFiles()
	{
		$this->load->view('cif/more_files');
	}

	function uploadSaleFiles()
	{
		$soldid   = $this->input->post('sold_id');
		$Document = '';
		$type 	  = $this->uri->segment(3);
		
		if ($type == 'Biometric') {
			$Document = 'Biometric';
		}
		else if ($type == "cnic") {
			$Document = 'CNIC';
		}
		else
		{
			$Document = 'Document';
		}

		$FileName = $_FILES['file']['name']; 
		$FileTmp  = $_FILES['file']['tmp_name']; 
		$uploadfile = $this->Admin->fileUpload($FileName,$FileTmp,'SaleUnits');
		
		$planArray = array(
			'orignal' => $uploadfile['orignal'],
			'file' => $uploadfile['filename'],
			'url' => base_url().'/assets/uploads/SaleUnits/',
			'sale_id' => $soldid,
			'document' => $Document,
		);

		$insert = $this->Admin->InsertData('sale_documents',$planArray);
		if ($insert) {
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
		$this->load->view('unit-changes/unit_authorize_files',array('files' => $getFiles,'id' => $id));
	}

	// Provinces 
	function getProvinces()
	{
		$id =$this->input->post('id');
		$getProvince = $this->Admin->getAllData('provinces','',array('ct_id' => $id)); ?>
			<div class="col-md-6">
			<div class="form-group">                                        
			<label class="col-md-12 col-xs-12 control-label"><br>Province</label>
			<div class="col-md-12 col-xs-12">								
			<select name="province" id="" class="form-control" onchange="getDistrict($(this).val())">
				<option> Select Province </option>
				<?php if (!empty($getProvince)): ?>
					<?php foreach ($getProvince as $province): ?>
						<option value="<?php echo $province->province_id;?>"><?php echo $province->province_name; ?></option>
					<?php endforeach ?>
				<?php endif ?>
			</select></div></div></div>
		<?php 
 	}

 	function SaveOwners()
	{
		$saleid = $_POST['saleid'];
		$data = $_POST;
		$data['status'] = 1;
		$data['type'] = 'Owners';
		$data['password'] = '';
		$data['created_at'] = date("Y-m-d");
		$relation = array(
			'relationship' => $this->input->post('relationship'),
			'relation_name' => $this->input->post('relation_name')
		);
		unset($data['relationship']);
		unset($data['saleid']);
		unset($data['relation_name']);
		$saveUnits = $this->Admin->InsertData('users',$data);
		$userid = $this->db->insert_id();
		$relation['user_id'] = $userid;
		// Saving Data To sales 
		$getOwner = $this->Admin->getAllData('sale','owners',array('sale_id' => $saleid));
		if (!empty($getOwner[0]->owners)) {
			$getOWner = $getOwner[0]->owners.'-'.$userid;
			$this->Admin->UpdateDB('sale',array('sale_id' => $saleid),array('owners' => $getOWner));
		}
		else
		{
			$this->Admin->UpdateDB('sale',array('sale_id' => $saleid),array('owners' => $userid));
		}
		// End Data
		if (!empty($relation)) {
			$saveUnits = $this->Admin->InsertData('relation',$relation);
		}
		if ($saveUnits) {
			$response = array('success' => true, 'param' => 'success', 'message' => 'User Added Successfully');
			echo json_encode($response);
		}
		else
		{
			$response = array('success' => false, 'param' => 'danger', 'message' => 'Failed To Add User');
			echo json_encode($response);
		}
	}
	// Districts 
	function getDistrict()
	{
		$id =$this->input->post('id');
		$getDistrict = $this->Admin->getAllData('districts','',array('province_id' => $id)); ?>
			<div class="col-md-6">
			<div class="form-group">                                        
			<label class="col-md-12 col-xs-12 control-label"><br>Districts</label>
			<div class="col-md-12 col-xs-12">								
			<select name="district" id="" class="form-control">
				<option> Select District </option>
				<?php if (!empty($getDistrict)): ?>
					<?php foreach ($getDistrict as $district): ?>
						<option value="<?php echo $district->id;?>"><?php echo $district->district_name; ?></option>
					<?php endforeach ?>
				<?php endif ?>
			</select></div></div></div>
		<?php 
 	}

 	// Search Unit Area
 	function SearchUnit()
 	{
 		$floor = $this->input->post('floor');
 		$project = $this->input->post('project');
 		$con['selection'] = 'basic_floors.*, sum(sale.square_feet) as free_space';
 		$con['conditions'] = array(
 			'basic_floors.floor_id' => $floor
 		);
 		$con['returnType'] = 'single';
 		$con['innerJoin'] = array(array(
            'table' => 'sale',
            'condition' =>'sale.floor_id = basic_floors.floor_id',
            'joinType' => 'left'
        ));
 		$result = $this->Admin->getRows($con, 'basic_floors');
 		if ($result['type'] == 'space') {
 			$result['free_space'] = $result['size_sqft'] - $result['free_space'];
 			$this->load->view('cif/floor_search_result',array('floor' => $result));
 		} else {
 			$selectFields 	= 'A.size_sqft,A.price_sqft as shop_price_sqft,A.unit_id,A.sold,A.size_sqft,B.price_sqft,A.unit_type,B.floor_id,B.type';
	 		$firstTable 	= 'sales_units as A';
			$secondTable 	= 'basic_floors as B';
			$onFields		= 'B.floor_id = A.floor_id';
			$whereFields 	= array('B.floor_id' => $floor,'C.project_id' => $project);
	 		$searchResult   = $this->Admin->DJoin($selectFields,$firstTable,$secondTable,array(
	 			'project as C' => 'C.project_id = B.project_id',
	 		),$onFields,$whereFields,'A.sold ASC');


	 		$this->load->view('cif/search_result',array('result' => $searchResult));
 		}
 		
 	
 	}

 	// Search Unit Area for filteration
 	function get_unit_search()
 	{
 		$floor = $this->input->post('floor');
 		$project = $this->input->post('project');
 		$selectFields 	= 'A.size_sqft,A.unit_id,A.sold,A.size_sqft,B.price_sqft,A.unit_type,B.floor_id';
 		$firstTable 	= 'sales_units as A';
		$secondTable 	= 'basic_floors as B';
		$onFields		= 'B.floor_id = A.floor_id';
		$whereFields 	= array('B.floor_id' => $floor,'C.project_id' => $project);
 		$searchResult   = $this->Admin->DJoin($selectFields,$firstTable,$secondTable,array(
 			'project as C' => 'C.project_id = B.project_id',
 		),$onFields,$whereFields,'A.sold ASC');
 		$this->load->view('cif/search_result',array('result' => $searchResult));
 	}

 	// Installments
 	function Installments()
 	{
 		$totalPayment = $this->input->post('totalPayment');
 		$tokenMoney   = $this->input->post('tokenmoney');
 		$downPayment  = $this->input->post('downpayment');
 		$totalYears   = $this->input->post('totalyears');
 		$discount     = $this->input->post('discount');
 		$price   	  = $this->input->post('price');
 		$size   	  = $this->input->post('size');
 		$square_feet   	  = $this->input->post('square_feet');

 		$TotalPayment = '';
 		if (!empty($discount)) {
 			$prices = $price;
 			if ($square_feet == 0) {
 				$totalprice = $prices * $size - $discount;
 			} else {
 				$totalprice = $prices * $square_feet - $discount;
 			}
 			
 			$TotalPayment = $totalprice;
 		}
 		else
 		{
 			$TotalPayment = $totalPayment;
 		}
 		$allInstallments = [];
 		$getFinalAmount = '';
 		if (!empty($totalYears)) {
 			// Getting Months
 			// Getting  installments for Each Month
			$totalToPay 	= ((float)$downPayment+(float)$tokenMoney);
			$amountToBePaid = ((float)$TotalPayment-(float)$totalToPay); 
			$getFinalAmount = $amountToBePaid / $totalYears;
 			// Making Array Of Installments
 			for ($i=0; $i < $totalYears ; $i++) { 
 				$allInstallments[] = array(
 					'date' => date("F|Y",strtotime('+'.$i.' month')),
 					'Installment' => round($getFinalAmount)
 				);		
 			}
 			$this->load->view('cif/installments',array('installments' => $allInstallments));
 		}
 		else
 		{
 			echo "Please Fill The Fields";
 		}
 	}

 	// Getting User Lists
 	function getUserslist()
 	{
 		$get = $this->input->post('geto');
 		$getUsers = $this->Admin->getAllData('users','',"email_id LIKE '%$get%' OR phone_login LIKE '%$get%' OR phone LIKE '%$get%' OR fullname LIKE '%$get%'");
 		$this->load->view('cif/get_users',array('users' => $getUsers));
 	}

 	function saveUserInstallments()
 	{
 		$totalPayment = $this->input->post('totalPayment');
 		$tokenMoney   = $this->input->post('tokenmoney');
 		$downPayment  = $this->input->post('downpayment');
 		$totalYears   = $this->input->post('totalyears');
 		$unitid   	  = $this->input->post('unitid');
 		$floorid      = $this->input->post('floorid');
 		$clientid     = $this->input->post('clientid');
 		$discount     = $this->input->post('discount');
 		$pricepersqft = $this->input->post('price');
 		$sizeSqft     = $this->input->post('size');
 		$square_feet     = $this->input->post('square_feet');
 		$TotalMoney   = '';
 		$Discount 	  = '';
 		// Updating Prices With Discounts if Any 
 		if (!empty($discount)) {
 			if ($square_feet == 0) {
 				$totalMoneyAfter = $sizeSqft * $pricepersqft - $discount;
 			} else {
 				$totalMoneyAfter = $square_feet * $pricepersqft - $discount;
 			}
 			
 			$TotalMoney = $totalMoneyAfter;
 			$Discount = $discount;
 		}
 		else
 		{
 			$TotalMoney = $totalPayment;
 			$Discount   = 0; 
 		}
 		// $downPayments = $TotalMoney*25/100;
 		$saleArray	  = array(
 			'unit_id' => $unitid,
 			'user_id' => $clientid,
 			'total_payment' => $TotalMoney,
 			'token_money' => $tokenMoney,
 			'down_payment' => $downPayment,
 			'installments' => $totalYears,
 			'floor_id' => $floorid,
 			'sale_date' => date("Y-m-d"),
 			'added_by' => $this->session->userdata('user_id'),
 			'discount' => $Discount,
 			'pricesqft' => $pricepersqft,
 			'square_feet' => $square_feet
 		);


 		// Uploading Sale Unit Sold
 		$sold = $this->Admin->InsertData('sale',$saleArray);
 		$soldid = $this->db->insert_id();
 		// Updating Unit Status
 		if (! $unitid == 0) {
 			$updateUnit = $this->Admin->UpdateDB('sales_units',array('unit_id' => $unitid, 'floor_id' => $floorid),array('sold' => 2,'sale_date' => date("Y-m-d")));
 		}
 		
 		//  Now Uploading Installments for User
 		$getFinalAmount = '';
 		if (!empty($totalYears)) {
			$totalToPay 	= ((float)$downPayment+(float)$tokenMoney);
			$amountToBePaid = ((float)$TotalMoney-(float)$totalToPay); 
			$getFinalAmount = $amountToBePaid / $totalYears;
 			// Making Array Of Installments
 			for ($i=0; $i < $totalYears ; $i++) {
 				$incs = 90 * $i+1; 
 				$incs = date("Y-m-d",strtotime("+$incs days"));
 				$allInstallments = array(
 					'amount' => round($getFinalAmount),
 					'remaining' => round($getFinalAmount),
 					'paid' => 0,
 					'sale_id' => $soldid,
 					'status' => 0,
 					'willberecievedon' => $incs
 				);		
 				$addInstallments = $this->Admin->InsertData('installments',$allInstallments);
 			}
 		}
		if ($addInstallments) {
			$response = array('success' => true, 'param' => 'success','soldid' => $soldid, 'message' => 'Unit Sold');
			echo json_encode($response);
		}
		else
		{
			$response = array('success' => false, 'param' => 'danger', 'message' => 'Unit Sale Failed');
			echo json_encode($response);
		}
 	}

 	// User Details Getting Units 
 	function getUnit()
 	{
 		$userid = $this->input->post('id');
 		$selectFields 	= '*,sales_units.size_sqft as totalarea';
 		$firstTable 	= 'sale';
		$secondTable 	= 'basic_floors';
		$onFields		= 'sale.floor_id = basic_floors.floor_id';
		$whereFields 	= array('sale.user_id' => $userid);
		$whereArray     = array('sales_units' => 'sales_units.unit_id = sale.unit_id',
								'project' => 'basic_floors.project_id = project.project_id' 
								);
 		$searchResult = $this->Admin->DJoin($selectFields,$firstTable,$secondTable,$whereArray,$onFields,$whereFields);
 		$this->load->view('cif/unit_details',array('units' => $searchResult));

 	}

 	// Getting Installments Plan for User
 	function installmentPlan()
 	{
 		$userid = $this->input->post('id');
 		$installments = $this->Admin->getAllData('installments','',array('sale_id' => $userid));
 		$this->load->view('cif/installment_plan',array('plan' => $installments));
 	}

 	// get Unit Documents

 	function unitdocuments()
 	{
 		$id = $this->input->post('id');
 		$installments = $this->Admin->getAllData('installments','',array('sale_id' => $userid));
 		$this->load->view('cif/installment_plan',array('plan' => $installments));
 	}

 	function getsearchUnits()
 	{
 		$units = $this->Admin->getAllData('sales_units','unit_id,unit_type',array('floor_id' => $_POST['floor']));
 		if (empty($units)) {
 			exit(false);
 		}
 	?>
 		<div class="col-md-4" id="search_unit">
			<div class="form-group">                                        
				<label class="control-label">Unit Type</label>
				<select class="form-control select" onchange="show_filter_result()" data-live-search="true" tabindex="1" id="unit_type">
					<option>Select Unit</option>
					<?php if (!empty($units)): ?>
						<?php foreach ($units as $unit_area): ?>
							<option value="<?php echo $unit_area->unit_id;?>"><?php echo $unit_area->unit_type; ?></option>
						<?php endforeach ?>
					<?php endif ?>	
				</select>
			</div>
		</div>
	<?php
 	}

 	function getsearchFloors()
 	{
		$floors = $this->Admin->getAllData('basic_floors','floor_id,floor_types',array('project_id' => $_POST['id']));

	?>
		<div class="col-md-4">
			<div class="form-group">                                        
				<label class="control-label">Floor</label>
				<select class="form-control select" data-live-search="true" tabindex="1" id="floor_type" onchange="SearchUnits($(this).val())">
					<option>Select Floor</option>
					<?php if (!empty($floors)): ?>
						<?php foreach ($floors as $floor_unit): ?>
							<option value="<?php echo $floor_unit->floor_id;?>"><?php echo $floor_unit->floor_types; ?></option>
						<?php endforeach ?>
					<?php endif ?>	
				</select>
			</div>	
		</div>
	<?php
 	}
 	
 	// Purchase Details
 	function purchaseDetails()
 	{
 		$this->load->view('cif/purchaseDetails');
 	}
 	// Space purchase details
 	function spacePurchaseDetails()
 	{
 		$this->load->view('cif/spacePurchaseDetails');
 	}

 	function converCamerImageToFile()
 	{
 		$saleid = $this->input->post('sale');
 		$update = $this->input->post('update');
 		$inputString = $_POST['baseencoded'];
 		$base_to_php = explode(',', $inputString);
		$data = base64_decode($base_to_php[1]);
		$filename = date("Ymdhisa");
		$filepath = "assets/uploads/files/$filename.png"; 

		$planArray = array(
			'orignal' => '',
			'file' => $filename.'.png',
			'url' => base_url().'assets/uploads/files/',
			'sale_id' => $saleid,
			'document' => 'Camera',
		);
		$id = '';
		if (!empty($update)) {
			$insert = $this->Admin->UpdateDB('sale_documents',array('id' => $update),$planArray);
			$id = $update;
 		}
 		else
 		{
			$insert = $this->Admin->InsertData('sale_documents',$planArray);
			$id = $this->db->insert_id();
 		}
		file_put_contents($filepath,$data);
 		echo '<img src="'.base_url().$filepath.'" width="100%"><input type="hidden" value="'.$id.'" id="reassignid">';
 	}


}
?>		