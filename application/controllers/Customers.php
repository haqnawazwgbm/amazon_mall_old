<?php 

/**
* 
*/
class Customers extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('logged') != true) {
			redirect(base_url().'Login');
		}
		$type = $this->session->userdata('user_type');
		if ($type != "Admin" && $type !='User') {
			redirect(base_url().'Login');
		}
	}

	function index()
	{
		$data['sales'] = $this->linebar();
		$data['pay']   = $this->bars();
		$this->load->view('Customers/dashboard',$data);
	}

	function dashboard()
	{
		$id = $this->session->userdata('user_id');
		$getUser = $this->Admin->DJoin(
				'*',
				'users',
				'countries',
				 array(
				 	'provinces' => 'provinces.province_id = users.province',
				 	'districts' => 'districts.id = users.district'
				 ),
				'users.country = countries.id',
				array('users.user_id' => $id)
			);
		$data['clients'] = $getUser;
		$this->load->view('Customers/index',$data);
	}

	function userPurchases()
	{
		$id = $this->session->userdata('user_id');
		$AllPurchases = $this->Admin->DJoin(
						'A.sale_id,A.pricesqft,
						 A.sale_date,C.project_name,
						 C.project_location,D.unit_type,
						 B.floor_types,D.size_sqft',
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
					);
		$fetchAllPurchases = '';
		$i = 1;
		foreach ($AllPurchases as $each) {
			
			$Buttons = '<a href="'.base_url().'Customers/purchaseDetails/'.$each->sale_id.'/'.$id.'" class="btn btn-xs btn-success">View Details</a>
			';
			
			$fetchAllPurchases[] = array(
				'9' 		=> $i,
				'1' 		=> $each->project_name,
				'5' 		=> $each->project_location,
				'7' 		=> $each->unit_type,
				'2' 		=> $each->floor_types,
				'3' 		=> $each->size_sqft,
				'4' 		=> 'Rs.'.$each->size_sqft*$each->pricesqft,
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
	
	function purchaseDetails()
 	{
 		$this->load->view('Customers/purchaseDetails');
 	}

	// Charts Statistics
	function linebar()
	{
		$id = $this->session->userdata('user_id');
		$AllPurchases = $this->Admin->getAllData('sale','sale_date as date,count(sale_id) as count',array('user_id' => $id),'','','date');
		return $AllPurchases;
	}

	function bars()
	{
		$id = $this->session->userdata('user_id');
		$AllPurchases = $this->Admin->DJoin(
			'basic_floors.price_sqft as ourprice,sale.pricesqft as yourprice,sales_units.unit_type as unit',
			'sale',
			'sales_units',
			array('basic_floors' => 'sales_units.floor_id = basic_floors.floor_id'),
			'sale.unit_id = sales_units.unit_id',array('user_id' => $id));
		return $AllPurchases;
	}

	function Message()
	{
		$data['messages'] = $this->Admin->DJoin('messages.title,messages.status,messages.subject,messages.created_at,users.fullname,messages.id,messages.urgency','messages','users','','messages.sent_by = users.user_id',array('sent_by' => $this->session->userdata('user_id')));
		$this->load->view('Customers/inbox',$data);
	}

	function WriteMessage()
	{
		$this->load->view('Customers/compose');
	}

	function SendMessage()
	{
		$data = $_POST;
		$data['sent_by'] = $this->session->userdata('user_id');
		$data['status'] = 0;
		$SendMessage = $this->Admin->InsertData('messages',$data);
		if ($SendMessage) {
			return true;
		}
	}

	function messageDetails()
	{
		$id = $this->uri->segment(3);
		$data['messages'] = $this->Admin->DJoin('messages.title,messages.status,messages.subject,messages.created_at,users.fullname,messages.id,messages.urgency,messages.department,messages.message,users.email_id','messages','users','','messages.sent_by = users.user_id',array('sent_by' => $this->session->userdata('user_id')),'messages.created_at DESC');
		$this->load->view('Customers/message',$data);
	}

}
?>