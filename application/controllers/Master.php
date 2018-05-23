<?php  

/**
*  Master Admin Class
*/

class Master extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('logged') != true) {
			redirect(base_url().'Login');
		}
		$type = $this->session->userdata('user_type');
		if ($type != "Admin" && $type != 'ccd' ) {
			redirect(base_url().'Login');
		}
	}

	/**
	*  Main Dahboard 
	**/

	function dashboard()
	{
		// Finding Total Sales, Paid & Remaining etc
		$allProjects = $this->Admin->getAllData('project');
		
		$AllProjectCost = [];
		$PaidAmount     = [];

		foreach ($allProjects as $eachProject) {

			$FilterData =array('C.project_id' => $eachProject->project_id);
			
			$purchases = $this->Admin->DJoin(

				'A.*,B.*,C.*,D.*,B.size_sqft as square',
				'sale as A',
				'sales_units as B',
				array(
					'basic_floors as C' => 'C.floor_id = A.floor_id',
					'project as D' => 'D.project_id = C.project_id', 
				),
				'A.unit_id = B.unit_id',
				$FilterData
			);

			foreach ($purchases as $list) {

				$AllProjectCost[] = $list->total_payment;
				
				if ($list->recieved_token == 1) {
					$PaidAmount[] = $list->token_money;
				}

				if ($list->recieved_downpayment == 1) {
					$PaidAmount[] = $list->down_payment;
				}

				$getId = $list->sale_id;

				$Installments = $this->Admin->getAllData('installments','paid',array('sale_id' => $getId,'status' => 1));
				foreach ($Installments as $getone) {
					$paidamount = $getone->paid;
					$PaidAmount[] = $paidamount;
				}
				
			
			}

		}

		$totalsale  = array_sum($AllProjectCost);

		$paidamount = array_sum($PaidAmount);

		$remaining  = $totalsale-$paidamount;

		$data['top'] = array('cost' => $totalsale , 'paid' => $paidamount , 'remaining' => $remaining );
		// End Of Finding Details

		$data['lines'] = $this->linecharts();
		$data['sales'] = $this->linebar();
		$data['users'] = $this->donut();
		$data['pay']   = $this->bars();
		$data['totalsale'] = $this->totalSales();
		$data['recievedAmount'] = $this->totalAmountRecieved();
		$data['dueinstall'] = $this->dueInstallments();
		$this->load->view('index',$data);
	}


	// Charts Statistics
	
	function linebar()
	{
		$From = date("Y-m-d",strtotime("-80 days"));
		$To = date("Y-m-d",strtotime("+15 days"));
		$Sale = $this->Admin->getAllData('sale','count(sale_id) as sales,sale_date',
										 array('sale_date >' => $From,'sale_date <' => $To,'recieved_downpayment' => 1),'','','sale_date');
		return $Sale;
	}

	function donut()
	{
		$From = date("Y-m-d",strtotime("-30 days"));
		$To = date("Y-m-d",strtotime("+15 days"));
		$Sale = $this->Admin->getAllData('users','count(user_id) as id,type,created_at',
										 array('created_at >' => $From,'created_at <' => $To),'','','created_at');
		return $Sale;
	}

	function bars()
	{
		$project = $this->Admin->getAllData('project');
		$BarData = [];
		foreach ($project as $data){
			$Sale = $allusers = $this->Admin->DJoin(
				'*',
				'basic_floors',
				'sales_units',
				'',
				'basic_floors.floor_id = sales_units.floor_id',
				array('basic_floors.project_id' => $data->project_id, 'sales_units.sold' => 1)
			);
			$Count = count($Sale);
			$BarData[] = array(
				'Project' => $data->project_name,
				'Sales'   => $Count
			);
		}
		return $BarData;
	}

	// Total Sales 
	function totalSales()
	{
		$project = $this->Admin->getAllData('project');
		$BarData = [];
		foreach ($project as $data){
			$purchases = 
				$this->Admin->DJoin(
					'B.size_sqft as size,A.discount,A.pricesqft as price,D.project_name',
					'sale as A',
					'sales_units as B',
					array(
						'basic_floors as C' => 'C.floor_id = A.floor_id',
						'project as D' => 'D.project_id = C.project_id', 
					),
					'A.unit_id = B.unit_id',
					array(
						'D.project_id' =>$data->project_id, 
					)
				);
			$TotalAmount = [];
			foreach ($purchases as $one) {
				$TotalAmount[] =  $one->size * $one->price - $one->discount;
			}
			$BarData[] = array(
				'Project' => $data->project_name,
				'Sales'   => array_sum($TotalAmount)
			);
		}
		return $BarData;
	}


	// Total Amount Recieved 
	function totalAmountRecieved()
	{
		$project = $this->Admin->getAllData('project');
		$BarData = [];
		foreach ($project as $data){
			$purchases = 
				$this->Admin->DJoin(
					'A.sale_id,A.recieved_token,A.recieved_downpayment,A.token_money,A.down_payment,B.size_sqft as size,A.pricesqft as price,D.project_name',
					'sale as A',
					'sales_units as B',
					array(
						'basic_floors as C' => 'C.floor_id = A.floor_id',
						'project as D' => 'D.project_id = C.project_id', 
					),
					'A.unit_id = B.unit_id',
					array(
						'D.project_id' =>$data->project_id,
					)
				);

			$TotalAmount = [];
			
			foreach ($purchases as $one) 
			{
				if ($one->recieved_token != 0) {
					$TotalAmount[] = $one->token_money;
				}
				if ($one->recieved_downpayment != 0) {
					$TotalAmount[] = $one->down_payment;
				}
			}

			foreach ($purchases as $one) {
				$getInstallments = $this->Admin->getAllData('installments','paid',array('status' => 1,'sale_id' => $one->sale_id));
				if (!empty($getInstallments)) {
					foreach ($getInstallments as $insta) {
						$TotalAmount[] = $insta->paid;
					}
				}
			}

			$BarData[] = array(
				'Project' => $data->project_name,
				'Sales'   => array_sum($TotalAmount)
			);
		}
		return $BarData;
	}

	// Due Installments Not Recieved Yet
	function dueInstallments()
	{
		$project = $this->Admin->getAllData('project');
		$BarData = [];
		foreach ($project as $data){
			$purchases = 
				$this->Admin->DJoin(
					'A.sale_id,D.project_name',
					'sale as A',
					'sales_units as B',
					array(
						'basic_floors as C' => 'C.floor_id = A.floor_id',
						'project as D' => 'D.project_id = C.project_id', 
					),
					'A.unit_id = B.unit_id',
					array(
						'D.project_id' =>$data->project_id,
					)
				);
			$TotalAmount = [];

			foreach ($purchases as $one) {
				$getInstallments = $this->Admin->getAllData('installments','paid',array('status' => 0,'willberecievedon <=' => date("Y-m-d"),'sale_id' => $one->sale_id));

				if (!empty($getInstallments)) {
					foreach ($getInstallments as $insta) {
						$TotalAmount[] = $insta->paid;
					}
				}
			}
			$BarData[] = array(
				'Project' => $data->project_name,
				'Dues'   => array_sum($TotalAmount)
			);
		}
		return $BarData;
	}

	// Line Chart
	function linecharts()
	{
		$project = $this->Admin->getAllData('project');
		$BarData = [];
		foreach ($project as $data){
			$purchases = 
				$this->Admin->DJoin
				(
					'A.sale_date as Date,count(A.sale_id) as sales,
					 D.project_name as Project',
					'sale as A',
					'sales_units as B',
					array
					(
						'basic_floors as C' => 'C.floor_id = A.floor_id',
						'project as D' => 'D.project_id = C.project_id', 
					),
					'A.unit_id = B.unit_id',
					array
					(
						'D.project_id' =>$data->project_id,
					),
					'',
					'A.sale_date'
				);
			foreach ($purchases as $one) {
				$BarData[] = array(
					'Project' => $one->Project,
					'Date'    => $one->Date,
					'Sales'   => $one->sales
				);
			}
		}
		return $BarData;
	}

}
?>		