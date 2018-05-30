<?php  

/**
*  Reports
*/

class Reports extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('Ppdf');
	}
	
	/**
	* Sales Reports
	*/

	function Salesreports()
	{
		$data['project'] = $this->Admin->getAllData('project');
		$data['floor']   = $this->Admin->getAllData('basic_floors');
		$this->load->view('reports/sale_report',$data);
	}

	function receivable_report() {
		$data['projects'] = $this->Admin->getAllData('project');
		$this->load->view('reports/receivable_report',$data);
	}

	function get_receivable_report() {
		$Project = $this->input->post('project');
		$From = $this->input->post('from');
		$To = $this->input->post('to');

		if ($Project !="Select Project" && !empty($From) && !empty($To)):

			$data['filterData'] = array(
				'C.project_id' => $Project,
				'A.sale_date >' => $From, 
				'A.sale_date <' => $To,
				'B.sold' => 1,
			);
			$con['conditions'] = array(
				'project.project_id' => $Project
			);
			$con['returnType'] = 'object';
			$data['project'] = $this->Admin->getRows($con, 'project');
			$this->load->view('reports/list_receivable_report',$data);
		elseif ($Project != "Select Project" && empty($From) && empty($To)) :
			$data['filterData'] = array(
				'C.project_id' => $Project,
				'B.sold' => 1,
			);
			$con['conditions'] = array(
				'project.project_id' => $Project
			);
			$con['returnType'] = 'object';
			$data['project'] = $this->Admin->getRows($con, 'project');
			$this->load->view('reports/list_receivable_report',$data);
		elseif ($Project != "Select Project" && empty($From) && empty($To)) :
			$data['filterData'] = array(
				'C.project_id' => $Project,
				'B.sold' => 1,
			);
			$con['conditions'] = array(
				'project.project_id' => $Project
			);
			$con['returnType'] = 'object';
			$data['project'] = $this->Admin->getRows($con, 'project');
			$this->load->view('reports/list_receivable_report',$data);
		elseif(!empty($From) && !empty($To)):
			$data['filterData'] = array(
				'A.sale_date >' => $From, 
				'A.sale_date <' => $To,
				'B.sold' => 1,
			);
			$data['project'] = $this->Admin->getAllData('project');
			$this->load->view('reports/list_receivable_report',$data);
		else:
			$data['filterData'] = array(
				'A.recieved_downpayment' => 1,
				'B.sold' => 1,
			);
			$data['project'] = $this->Admin->getAllData('project');
			$this->load->view('reports/list_receivable_report',$data);
		endif;
	}

	function SaleReport()
	{
		$Project = $this->input->post('project');
		$Floor = $this->input->post('floor');
		$From = $this->input->post('from');
		$To = $this->input->post('to');


		// Checking if its Sale Agent
		$sessionType = $this->session->userdata('user_type');

		if($sessionType == "Agent"):
			$userid = $this->session->userdata('user_id');
			$FilterData['A.added_by'] = $userid;
		endif;

		if ($Project !="Select Project" && $Floor!="Select Floor" && !empty($From) && !empty($To)):

			$data['filterData'] = array(
				'C.project_id' => $Project,
				'A.floor_id' => $Floor,
				'A.sale_date >' => $From, 
				'A.sale_date <' => $To,
				'A.recieved_downpayment' => 1,
				'B.sold' => 1,
			);
			$con['conditions'] = array(
				'project.project_id' => $Project
			);
			$con['returnType'] = 'object';
			$data['project'] = $this->Admin->getRows($con, 'project');
			$this->load->view('reports/saleallreport',$data);
		elseif ($Project != "Select Project" && $Floor=="Select Floor" && empty($From) && empty($To)) :
			$data['filterData'] = array(
				'C.project_id' => $Project,
				'A.recieved_downpayment' => 1,
				'B.sold' => 1,
			);
			$con['conditions'] = array(
				'project.project_id' => $Project
			);
			$con['returnType'] = 'object';
			$data['project'] = $this->Admin->getRows($con, 'project');
			$this->load->view('reports/saleallreport',$data);
		elseif ($Project != "Select Project" && $Floor!="Select Floor" && empty($From) && empty($To)) :
			$data['filterData'] = array(
				'C.project_id' => $Project,
				'C.floor_id' => $Floor,
				'A.recieved_downpayment' => 1,
				'B.sold' => 1,
			);
			$con['conditions'] = array(
				'project.project_id' => $Project
			);
			$con['returnType'] = 'object';
			$data['project'] = $this->Admin->getRows($con, 'project');
			$this->load->view('reports/saleallreport',$data);
		elseif(!empty($From) && !empty($To)):
			$data['filterData'] = array(
				'A.sale_date >' => $From, 
				'A.sale_date <' => $To,
				'A.recieved_downpayment' => 1,
				'B.sold' => 1,
			);
			$data['project'] = $this->Admin->getAllData('project');
			$this->load->view('reports/saleallreport',$data);
		else:
			$data['filterData'] = array(
				'A.recieved_downpayment' => 1,
				'B.sold' => 1,
			);
			$data['project'] = $this->Admin->getAllData('project');
			$this->load->view('reports/saleallreport',$data);
		endif;
	}
	// PDF Print

	function SaleReportPDF()
	{
		
		$filename = time()."_order.pdf";
		$Session = $this->session->userdata('salepdf');
		$SaleAdmin = $this->Admin->DJoin(
						'D.total_price,A.sale_date,C.project_name,C.project_location,D.unit_type,B.floor_types,D.size_sqft',
						'sale as A',
						'basic_floors as B',
						array(
							'project as C' => 'C.project_id = B.project_id',
							'sales_units as D' => 'D.unit_id = A.unit_id'
						),
						'A.floor_id = B.floor_id',
						array(
							'C.project_id' => $Session['project'],
							'A.floor_id' => $Session['floor'],
							'A.sale_date >' => $Session['from'], 
							'A.sale_date <' => $Session['to'],
							'A.recieved_downpayment' => 1,
							'D.sold' => 1,
						),
						'A.sale_date ASC'
					);
		$data['Report'] = $SaleAdmin;
		$html = $this->load->view('reports/salepdf',$data,TRUE);
		$this->ppdf->pdf->WriteHTML($html);
		$this->ppdf->pdf->Output("assets/uploads/files/".$filename, "D");
	}

	/**
	* Agent Sales Reports
	*/

	function AgentReport()
	{
		$data['agent']   = $this->Admin->getAllData('users','user_id,fullname','type = "Admin" OR type = "Agent"');
		$this->load->view('reports/agent_report',$data);
	}

	function agentReports()
	{
		$Agent = $this->input->post('agent');
		$From = $this->input->post('from');
		$To = $this->input->post('to');
		if ($Agent !="Select Agent" && !empty($From) && !empty($To)) {
			$SaleAdmin = $this->Admin->DJoin(
				'A.pricesqft,A.sale_date,E.fullname,C.project_name,C.project_location,D.unit_type,B.floor_types,D.size_sqft',
				'sale as A',
				'basic_floors as B',
				array(
					'project as C' => 'C.project_id = B.project_id',
					'sales_units as D' => 'D.unit_id = A.unit_id',
					'users as E' => 'E.user_id = A.added_by'
				),
				'A.floor_id = B.floor_id',
				array(
					'A.added_by' => $Agent,
					'A.sale_date >' => $From, 
					'A.sale_date <' => $To,
					'A.recieved_downpayment' => 1,
					'D.sold' => 1,
				),
				'A.sale_date ASC'
			);
		}
		elseif($Agent !="Select Agent" && empty($From) && empty($To))
		{
			$SaleAdmin = $this->Admin->DJoin(
				'A.pricesqft,A.sale_date,E.fullname,C.project_name,C.project_location,D.unit_type,B.floor_types,D.size_sqft',
				'sale as A',
				'basic_floors as B',
				array(
					'project as C' => 'C.project_id = B.project_id',
					'sales_units as D' => 'D.unit_id = A.unit_id',
					'users as E' => 'E.user_id = A.added_by'
				),
				'A.floor_id = B.floor_id',
				array(
					'A.added_by' => $Agent,
					'A.recieved_downpayment' => 1,
					'D.sold' => 1,
				),
				'A.sale_date ASC'
			);
		}
		elseif(!empty($From) && !empty($To))
		{
			$SaleAdmin = $this->Admin->DJoin(
				'A.pricesqft,A.sale_date,E.fullname,C.project_name,C.project_location,D.unit_type,B.floor_types,D.size_sqft',
				'sale as A',
				'basic_floors as B',
				array(
					'project as C' => 'C.project_id = B.project_id',
					'sales_units as D' => 'D.unit_id = A.unit_id',
					'users as E' => 'E.user_id = A.added_by'
				),
				'A.floor_id = B.floor_id',
				array(
					'A.added_by' => $Agent,
					'A.sale_date >' => $From, 
					'A.sale_date <' => $To,
					'A.recieved_downpayment' => 1,
					'D.sold' => 1,
				),
				'A.sale_date ASC'
			);
		}
		else
		{
			$SaleAdmin = $this->Admin->DJoin(
				'A.pricesqft,A.sale_date,E.fullname,C.project_name,C.project_location,D.unit_type,B.floor_types,D.size_sqft',
				'sale as A',
				'basic_floors as B',
				array(
					'project as C' => 'C.project_id = B.project_id',
					'sales_units as D' => 'D.unit_id = A.unit_id',
					'users as E' => 'E.user_id = A.added_by'
				),
				'A.floor_id = B.floor_id',
				array(
					'A.recieved_downpayment' => 1,
					'D.sold' => 1,
				),
				'A.sale_date ASC'
			);
		}
		$data['Report'] = $SaleAdmin;
		$this->load->view('reports/agent',$data);
	}

	/**
	* Agents Sales Reports
	*/

	function AgentsReport()
	{
		$this->load->view('reports/agents_report');
	}

	function agentsReports()
	{
		$From = $this->input->post('from');
		$To = $this->input->post('to');
		if (!empty($From) && !empty($To)) {
			$SaleAdmin = $this->Admin->DJoin(
				'count(A.sale_id) as TotalSales,sum(A.total_payment) as total,B.fullname,B.email_id,B.phone_login',
				'sale as A',
				'users as B',
				array(
					'sales_units as D' => 'D.unit_id = A.unit_id',
				),
				'B.user_id = A.added_by',
				array(
					'A.sale_date >' => $From, 
					'A.sale_date <' => $To,
					'A.recieved_downpayment' => 1,
					'D.sold' => 1,
				),
				'A.sale_date ASC',
				'B.fullname'
			);
		}
		else
		{
			$SaleAdmin = $this->Admin->DJoin(
				'count(A.sale_id) as TotalSales,B.fullname,sum(A.total_payment) as total,B.email_id,B.phone_login',
				'sale as A',
				'users as B',
				array(
					'sales_units as D' => 'D.unit_id = A.unit_id',
				),
				'B.user_id = A.added_by',
				array(
					'A.recieved_downpayment' => 1,
					'D.sold' => 1,
				),
				'A.sale_date ASC',
				'B.fullname'
			);
		}
		$data['From'] = date("d F Y",strtotime($From));
		$data['To'] = date("d F Y",strtotime($To));
		$data['Report'] = $SaleAdmin;
		$this->load->view('reports/agents',$data);
	}

	/**
	* Client Sales Reports
	*/

	function ClientReport()
	{
		$this->load->view('reports/client_report');
	}

	function clientReports()
	{
		$FilterBy  = $this->input->post('filterby');
		$From = $this->input->post('from');
		$To = $this->input->post('to');
		$SaleAdmin = '';
		if ($FilterBy == 1):
			if (!empty($From) && !empty($To)) {
				$SaleAdmin = $this->Admin->DJoin(
					'A.fullname,A.email_id,A.phone_login,A.phone,A.created_at,C.country_name,D.province_name,E.district_name,A.city,A.address',
					'users as A',
					'sale as B',
					array(
						'countries as C' => 'C.id = A.country',
						'provinces as D' => 'D.province_id = A.province', 
						'districts as E' => 'E.id = A.district'
					),
					'A.user_id = B.user_id',
					array(
						'A.created_at >' => $From, 
						'A.created_at <' => $To,
						'A.type' => 'User',
					),
					'A.created_at DESC',
					'A.user_id'
				);
			}
			else
			{
				$SaleAdmin = $this->Admin->DJoin(
					'A.fullname,A.email_id,A.phone_login,A.phone,A.created_at,C.country_name,D.province_name,E.district_name,A.city,A.address',
					'users as A',
					'sale as B',
					array(
						'countries as C' => 'C.id = A.country',
						'provinces as D' => 'D.province_id = A.province', 
						'districts as E' => 'E.id = A.district'
					),
					'A.user_id = B.user_id',
					array(
						'A.type' => 'User',
					),
					'A.created_at DESC',
					'A.user_id'
				);
			}
			$data['clients'] = $SaleAdmin;
			$this->load->view('reports/purchased_clients',$data);
		else:
			if (!empty($From) && !empty($To)) {
				$SaleAdmin = $this->Admin->DJoin(
					'A.fullname,A.email_id,A.phone_login,A.phone,A.created_at,C.country_name,D.province_name,E.district_name,A.city,A.address',
					'users as A',
					'sale as B',
					array(
						'countries as C' => 'C.id = A.country',
						'provinces as D' => 'D.province_id = A.province', 
						'districts as E' => 'E.id = A.district'
					),
					'A.user_id != B.user_id',
					array(
						'A.created_at >' => $From, 
						'A.created_at <' => $To,
						'A.type' => 'User'
					),
					'A.created_at DESC',
					'A.user_id'
				);
			}
			else
			{
				$SaleAdmin = $this->Admin->DJoin(
					'A.fullname,A.email_id,A.phone_login,A.phone,A.created_at,C.country_name,D.province_name,E.district_name,A.city,A.address',
					'users as A',
					'sale as B',
					array(
						'countries as C' => 'C.id = A.country',
						'provinces as D' => 'D.province_id = A.province', 
						'districts as E' => 'E.id = A.district'
					),
					'A.user_id != B.user_id',
					array(
						'A.type' => 'User'
					),
					'A.created_at DESC',
					'A.user_id'
				);
			}
			$data['clients'] = $SaleAdmin;
			$this->load->view('reports/registerd_clients',$data);
		endif;
	}

	/**
	* Client Detail Report
	*/

	function ClientDetailReport()
	{
		$data['allUsers'] = $this->Admin->getAllData('users','fullname,email_id,phone_login',array('type' => 'User'));
		$this->load->view('reports/client_detail_report',$data);
	}

	function ClientDetails()
	{
		$Phone = $this->input->post('phone');
		$Email = $this->input->post('email');
		$Fullname = $this->input->post('fullname');
		$getUser = '';
		$getPrint = '';
		if ($Phone != '1') {
			$getUser = $this->Admin->DJoin(
				'*',
				'users',
				'countries',
				 array(
				 	'provinces' => 'provinces.province_id = users.province',
				 	'districts' => 'districts.id = users.district'
				 ),
				'users.country = countries.id',
				array('phone_login' => $Phone)
			);
			$getPrint = $Phone.'|phone_login';
		}
		else if($Email != '1')
		{
			$getUser = $this->Admin->DJoin(
				'*',
				'users',
				'countries',
				 array(
				 	'provinces' => 'provinces.province_id = users.province',
				 	'districts' => 'districts.id = users.district'
				 ),
				'users.country = countries.id',
				array('email_id' => $Email)
			);
			$getPrint = $Email.'|email_id';
		}
		else if($Fullname != '1')
		{
			$getUser = $this->Admin->DJoin(
				'*',
				'users',
				'countries',
				 array(
				 	'provinces' => 'provinces.province_id = users.province',
				 	'districts' => 'districts.id = users.district'
				 ),
				'users.country = countries.id',
				array('fullname' => $Fullname)
			);
			$getPrint = $Fullname.'|fullname';
		}
		$data['clients'] = $getUser;
		$data['option'] = $getPrint;
		$this->load->view('reports/clientCompleteDetails',$data);
	}

	function pdf_ClientCompleteReport()
	{
		$filename = time()."_order.pdf";
		$render = $this->session->userdata('print');
		$explode = explode('|', $render);
		$getUser = $this->Admin->DJoin(
			'*',
			'users',
			'countries',
			 array(
			 	'provinces' => 'provinces.province_id = users.province',
			 	'districts' => 'districts.id = users.district'
			 ),
			'users.country = countries.id',
			array($explode[1] => $explode[0])
		);
		$data['clients'] = $getUser;
		$html = $this->load->view('reports/pdf_ccd',$data,TRUE);
		$this->ppdf->pdf->WriteHTML($html);
		$this->ppdf->pdf->Output("assets/uploads/files/".$filename, "D");
	}

	function pdfsaleAllReport()
	{
		$filename = time().".pdf";
		$data['project'] = $this->Admin->getAllData('project');
		$html = $this->load->view('reports/pdfsaleallreport',$data,TRUE);
		$this->ppdf->pdf->WriteHTML($html);
		$this->ppdf->pdf->Output("assets/uploads/files/".$filename, "D");
	}

	function pdf_receivable_report() {
		$filename = time().".pdf";
		$data['project'] = $this->Admin->getAllData('project');
		$html = $this->load->view('reports/pdf_receivable_report',$data,TRUE);
		$this->ppdf->pdf->WriteHTML($html);
		$this->ppdf->pdf->Output("assets/uploads/files/".$filename, "D");
	}

	function InventoryReport()
	{
		$data['project'] = $this->Admin->getAllData('project');
		$this->load->view('reports/inventory',$data);
	}

	function inventoryReports()
	{
		$id = $this->input->post('project');
		if (!empty($id) && $id !='-1') {
			$data['project'] = $this->Admin->getAllData('project','',array('project_id' => $id));
			$this->load->view('reports/inventoryReport',$data);
 		}
		else
		{
			$data['project'] = $this->Admin->getAllData('project');
			$this->load->view('reports/inventoryReport',$data);
		}
	}

	function printinventory()
	{
		$filename = time().".pdf";
		$data['project'] = $this->Admin->getAllData('project');
		$html = $this->load->view('reports/pdfinventoryReport',$data,TRUE);
		$this->ppdf->pdf->WriteHTML($html);
		$this->ppdf->pdf->Output("assets/uploads/files/".$filename, "D");
	}


	function InventorywithReport()
	{
		$data['project'] = $this->Admin->getAllData('project');
		$this->load->view('reports/inventorywith',$data);
	}

	function inventorywithReports()
	{
		$id = $this->input->post('project');
		if (!empty($id) && $id !='-1') {
			$data['project'] = $this->Admin->getAllData('project','',array('project_id' => $id));
			$this->load->view('reports/inventoryReportwith',$data);
 		}
		else
		{
			$data['project'] = $this->Admin->getAllData('project');
			$this->load->view('reports/inventoryReportwith',$data);
		}
	}

	function printwithinventory()
	{
		$filename = time().".pdf";
		$data['project'] = $this->Admin->getAllData('project');
		$html = $this->load->view('reports/pdfinventoryReportwith',$data,TRUE);
		$this->ppdf->pdf->WriteHTML($html);
		$this->ppdf->pdf->Output("assets/uploads/files/".$filename, "D");
	}

	/*
		Installments Reports Which Are Due
	*/

	function installments()
	{
		$data['project'] = $this->Admin->getAllData('project');
		$this->load->view('reports/installments',$data);
	}

	function installmentsresult()
	{
		$id = $this->input->post('project');
		if (!empty($id) && $id !='-1') {
			$data['project'] = $this->Admin->getAllData('project','',array('project_id' => $id));
			$this->load->view('reports/installmentsresult',$data);
 		}
		else
		{
			$data['project'] = $this->Admin->getAllData('project');
			$this->load->view('reports/installmentsresult',$data);
		}
	}

	function installmentpdf()
	{
		$filename = time().".pdf";
		$data['project'] = $this->Admin->getAllData('project');
		$html = $this->load->view('reports/pdfinventoryReportwith',$data,TRUE);
		$this->ppdf->pdf->WriteHTML($html);
		$this->ppdf->pdf->Output("assets/uploads/files/".$filename, "D");
	}
	function resold() {
		$data['units']   = $this->Admin->getAllData('sales_units','unit_id,unit_type');
		$data['floors']  = $this->Admin->getAllData('basic_floors','floor_id,floor_types');
		$data['project']  = $this->Admin->getAllData('project','project_id,project_name');
		$this->load->view('reports/resold_reports.php', $data);
	}

	function rent($action = '') {	
		$data['project'] = $this->Admin->getAllData('project');
		if ($action == 'get') {
			$project_id = $this->input->post('project_id');
			$date = date('Y-m');
			$date = strtotime($date . ' - 1 month');
			$date = date('Y-m',$date);
			$current_date = date('Y-m-d');
			if ($project !="Select Project"):
							
				$con['selection'] = "sale.sale_id, basic_floors.floor_types, basic_floors.rent_price as rent_sqft, sales_units.unit_type, sales_units.size_sqft, sum(installments.remaining) as remaining, MAX(installments.updated_at) as last_paid, users.fullname, (sales_units.size_sqft * basic_floors.rent_price) as total_rent, DATEDIFF('$current_date',installments.updated_at) as installment_days, DATEDIFF('$current_date', sale.updated_at) as sale_days, project.project_name";
				$con['conditions'] = array(
					'sale.resale' => 0,
					'basic_floors.project_id' => $project_id 
				);
				$con['innerJoin'] = array(array(
		            'table' => 'basic_floors',
		            'condition' =>'sale.floor_id = basic_floors.floor_id',
		            'joinType' => 'inner'
		        ),array(
		            'table' => 'users',
		            'condition' =>'sale.user_id = users.user_id',
		            'joinType' => 'inner'
		        ),array(
		            'table' => 'sales_units',
		            'condition' =>'sale.unit_id = sales_units.unit_id',
		            'joinType' => 'inner'
		        ),array(
		            'table' => 'installments',
		            'condition' =>'sale.sale_id = installments.sale_id',
		            'joinType' => 'inner'
		        ),array(
		            'table' => 'project',
		            'condition' =>'basic_floors.project_id = project.project_id',
		            'joinType' => 'inner'
		        ));
		        $con['groupBy'] = array('sale.sale_id');
		        $con['returnType'] = 'object';
		        $con['having_conditions'] = array(
		        	'remaining <=' => 0
		        );
		        $sales = $this->Admin->getRows($con, 'sale');
		        $data['sales'] = $sales ? $sales : array();
		        $data['filter_data'] = array(
					'sale.resale' => 0,
					'basic_floors.project_id' => $project_id 
				);
		      /*  echo '<pre>';
		        print_r($data); exit;*/
		    	$this->load->view('reports/rent_report',$data);
			
			elseif(!empty($from) && !empty($to)):
				
				$this->load->view('reports/rent_report',$data);
			else:
				$data['project'] = $this->Admin->getAllData('project');
			endif;

		}  else {
			$data['project'] = $this->Admin->getAllData('project');
			$this->load->view('reports/rent_report_form.php', $data);
		}
		
	}

	function rent_pdf($type) {	
			$data['project'] = $this->Admin->getAllData('project');
				$date = date('Y-m');
				$date = strtotime($date . ' - 1 month');
				$date = date('Y-m',$date);
				$current_date = date('Y-m-d');					
				$con['selection'] = "sale.sale_id, basic_floors.floor_types, basic_floors.rent_price as rent_sqft, sales_units.unit_type, sales_units.size_sqft, sum(installments.remaining) as remaining, MAX(installments.updated_at) as last_paid, users.fullname, (sales_units.size_sqft * basic_floors.rent_price) as total_rent, DATEDIFF('$current_date',installments.updated_at) as installment_days, DATEDIFF('$current_date', sale.updated_at) as sale_days, project.project_name";
				$con['conditions'] = $this->session->userdata('filter_data');
				$con['innerJoin'] = array(array(
		            'table' => 'basic_floors',
		            'condition' =>'sale.floor_id = basic_floors.floor_id',
		            'joinType' => 'inner'
		        ),array(
		            'table' => 'users',
		            'condition' =>'sale.user_id = users.user_id',
		            'joinType' => 'inner'
		        ),array(
		            'table' => 'sales_units',
		            'condition' =>'sale.unit_id = sales_units.unit_id',
		            'joinType' => 'inner'
		        ),array(
		            'table' => 'installments',
		            'condition' =>'sale.sale_id = installments.sale_id',
		            'joinType' => 'inner'
		        ),array(
		            'table' => 'project',
		            'condition' =>'basic_floors.project_id = project.project_id',
		            'joinType' => 'inner'
		        ));
		        $con['groupBy'] = array('sale.sale_id');
		      // /  $con['returnType'] = 'object';
		        $con['having_conditions'] = array(
		        	'remaining <=' => 0
		        );
		        $sales = $this->Admin->getRows($con, 'sale');
		        $data['sales'] = $sales ? $sales : array();
		        if ($type == 'excel') {
		        	$filename = time()."_order.xls";

					$sheet = $this->xls->spreadsheet->getActiveSheet();
					/*$this->xls->spreadsheet->getProperties()
					    ->setCreator("Maarten Balliauw")
					    ->setLastModifiedBy("Maarten Balliauw")
					    ->setTitle("Office 2007 XLSX Test Document")
					    ->setSubject("Office 2007 XLSX Test Document")
					    ->setDescription(
					        "Test document for Office 2007 XLSX, generated using PHP classes."
					    )
					    ->setKeywords("office 2007 openxml php")
					    ->setCategory("Test result file");
					$this->xls->spreadsheet->setActiveSheetIndex(0);
					foreach ($sales as $sale): 
						
						if ($sale->installment_days < 30 && $sale->installment_days != '') {
								$rent = $sale->total_rent / 30;
								$rent = $rent * $sale->installment_days;
								$days = $sale->installment_days;
							} elseif ($sale->sale_days < 30 && $sale->installment_days == '') {
								$rent = $sale->total_rent / 30;
								$rent = $rent * $sale->sale_days;
								$days = $sale->sale_days;
							} elseif ($sale->sale_days > 30 && $sale->installment_days == '') {
								$rent = $sale->total_rent;
								$days = $sale->sale_days;
							} else {
								$rent = $sale->total_rent;
								$days = $sale->installment_days;
						}
						$total_rent = $total_rent + $rent;
					
					endforeach; */
					$sheet->setCellValue('A1', 'Hello World !');
					$writer = $this->xls->excel;
					$writer->save($filename);

		        } else {
		        	$filename = time()."_order.pdf";
					$html = $this->load->view('reports/pdf_rent_report',$data, true);
					$this->ppdf->pdf->WriteHTML($html);
					$this->ppdf->pdf->Output("assets/uploads/files/".$filename, "D");
		        }
		    	
			
		
		
	}

	function get_resales() {
		print_r($_POST); exit;
		$this->load->view('sales/resales');
	}

	function payment_report($sale_id) {
		$con['selection'] = 'sale.*, client.fullname as client, basic_floors.*, sales_units.shopID,sales_units.size_sqft, sales_units.price_sqft as shop_price_sqft';
		$con['conditions'] = array(
			'sale.sale_id' => $sale_id
		);
		$con['innerJoin'] = array(array(
            'table' => 'basic_floors',
            'condition' =>'sale.floor_id = basic_floors.floor_id',
            'joinType' => 'inner'
        ),array(
            'table' => 'installments',
            'condition' =>'installments.sale_id = sale.sale_id',
            'joinType' => 'left'
        ),array(
            'table' => 'users as client',
            'condition' =>'sale.user_id = client.user_id',
            'joinType' => 'inner'
        ),array(
            'table' => 'sales_units',
            'condition' =>'sale.unit_id = sales_units.unit_id',
            'joinType' => 'left'
        ));
        $con['returnType'] = 'single';
        $sale = $this->Admin->getRows($con, 'sale');
        $data['sale'] = $sale ? $sale : array();

        $con = array();
        $con['selection'] = 'sum(installments.paid) as total_paid, sum(installments.amount) as total_installment_amount';
        $con['conditions'] = array(
        	'installments.sale_id' => $sale_id
        );
        $con['returnType'] = 'single';
        $installment = $this->Admin->getRows($con, 'installments');
        $data['sale']['total_paid'] = $installment['total_paid'];
        $data['sale']['total_installment_amount'] = $installment['total_installment_amount'];

        $con = array();
        $con['conditions'] = array(
        	'installments.sale_id' => $sale_id,
        	'installments.status' => 1,
        	'payment_methods.pay_for' => 'Installment'
        );
        $con['innerJoin'] = array(array(
			'table' => 'payment_methods',
			'condition' => 'payment_methods.column_id = installments.installment_id',
			'joinType' => 'inner'
		));
        $data['installments'] = $this->Admin->getRows($con, 'installments');
        $this->load->view('reports/payment_report', $data);
	}

	function get_payment_method($sale_id) {
		
		$con['string_conditions'] = "payment_methods.column_id = $sale_id and payment_methods.pay_for = 'DownPayment'
									or payment_methods.column_id = $sale_id and payment_methods.pay_for = 'Token'"; 
		$con['innerJoin'] = array(array(
			'table' => 'sale',
			'condition' => 'sale.sale_id = payment_methods.column_id',
			'joinType' => 'inner'
		));
		$con['orderBy'] = 'payment_methods.pay_for asc';
		$payments = $this->Admin->getRows($con, 'payment_methods');
		$payments = $payments ? $payments : array();
	
		return $payments;
	}

	function daily_progress_report() {
		$today = date('Y-m-d');
		// query for sale
		$con['selection'] = 'project.project_name, basic_floors.floor_types, sales_units.size_sqft as unit_size, basic_floors.price_sqft, sales_units.price_sqft as unit_price, sales_units.unit_type, users.fullname';
		$con['conditions'] = array(
			'sale.sale_date' => $today,
			'sale.resale' => 0
		);
		$con['innerJoin'] = array(
				array(
		            'table' => 'basic_floors',
		            'condition' =>'sale.floor_id = basic_floors.floor_id',
		            'joinType' => 'inner'
		        ),array(
		            'table' => 'users',
		            'condition' =>'sale.user_id = users.user_id',
		            'joinType' => 'inner'
		        ),array(
		            'table' => 'sales_units',
		            'condition' =>'sale.unit_id = sales_units.unit_id',
		            'joinType' => 'inner'
		        ),array(
		            'table' => 'project',
		            'condition' =>'basic_floors.project_id = project.project_id',
		            'joinType' => 'inner'
		    ));
		$sales = $this->Admin->getRows($con, 'sale');
		$data['sales'] = $sales ? $sales : array();

		// query for payment transactions.
		$con = array();
		$con['selection'] = 'project.project_name, basic_floors.floor_types, sales_units.unit_type, sales_units.size_sqft as unit_size, basic_floors.price_sqft, sales_units.price_sqft as unit_price, users.fullname, sale.token_money, sale.down_payment, payment_methods.*, sale.sale_id';
		$con['conditions'] = array(
			'payment_methods.date' => $today,
			'payment_methods.pay_for' => 'Token'
		);
		$con['orderBy'] = 'payment_methods.pay_for asc';
		$con['innerJoin'] = array(array(
			'table' => 'sale',
			'condition' => 'sale.sale_id = payment_methods.column_id',
			'joinType' => 'inner'
		),array(
			'table' => 'users',
			'condition' => 'sale.user_id = users.user_id',
			'joinType' => 'inner'
		),array(
		    'table' => 'basic_floors',
		    'condition' =>'sale.floor_id = basic_floors.floor_id',
		    'joinType' => 'inner'
		 ),array(
		    'table' => 'project',
		    'condition' =>'basic_floors.project_id = project.project_id',
		    'joinType' => 'inner'
		),array(
		    'table' => 'sales_units',
		    'condition' =>'sale.unit_id = sales_units.unit_id',
		    'joinType' => 'inner'
		));
		$con['returnType'] = 'single';
			// Query for token money transaction.
		$token = $this->Admin->getRows($con, 'payment_methods');
		$data['token'] = $token ? $token : array();
			// Query for down payment transaction
		$con['conditions'] = array(
			'payment_methods.date' => $today,
			'payment_methods.pay_for' => 'DownPayment'
		);
		$con['returnType'] = 'single'; 
		$downpayment = $this->Admin->getRows($con, 'payment_methods');
		$data['downpayment'] = $downpayment ? $downpayment : array();
			// Query for installment transaction.
		$con['selection'] = $con['selection'] . ', installments.paid';
		$con['conditions'] = array(
			'payment_methods.date' => $today,
			'payment_methods.pay_for' => 'Installment'
		);
		$con['innerJoin'] = array(array(
			'table' => 'installments',
			'condition' => 'installments.installment_id = payment_methods.column_id',
			'joinType' => 'inner'
		),array(
			'table' => 'sale',
			'condition' => 'sale.sale_id = installments.sale_id',
			'joinType' => 'inner'
		),array(
			'table' => 'users',
			'condition' => 'sale.user_id = users.user_id',
			'joinType' => 'inner'
		),array(
		    'table' => 'basic_floors',
		    'condition' =>'sale.floor_id = basic_floors.floor_id',
		    'joinType' => 'inner'
		 ),array(
		    'table' => 'project',
		    'condition' =>'basic_floors.project_id = project.project_id',
		    'joinType' => 'inner'
		),array(
		    'table' => 'sales_units',
		    'condition' =>'sale.unit_id = sales_units.unit_id',
		    'joinType' => 'inner'
		));
		unset($con['returnType']);
		unset($con['orderBy']);
		$installments = $this->Admin->getRows($con, 'payment_methods');
		$data['installments'] = $installments ? $installments : array();

		// query for transfer unit
		$con = array();
		$con['selection'] = 'project.project_name, basic_floors.floor_types, sales_units.unit_type, sales_units.size_sqft as unit_size, basic_floors.price_sqft, sales_units.price_sqft as unit_price, F.fullname as from_user, T.fullname as to_user, resales.*';
		$con['string_conditions'] = array(
			'date(resales.created_at)' => $today
		);
		$con['innerJoin'] = array(array(
			'table' => 'sale',
			'condition' => 'sale.sale_id = resales.sale_id',
			'joinType' => 'inner'
		),array(
			'table' => 'users as F',
			'condition' => 'resales.from_user_id = F.user_id',
			'joinType' => 'inner'
		),array(
			'table' => 'users as T',
			'condition' => 'resales.to_user_id = T.user_id',
			'joinType' => 'inner'
		),array(
		    'table' => 'basic_floors',
		    'condition' =>'sale.floor_id = basic_floors.floor_id',
		    'joinType' => 'inner'
		 ),array(
		    'table' => 'project',
		    'condition' =>'basic_floors.project_id = project.project_id',
		    'joinType' => 'inner'
		),array(
		    'table' => 'sales_units',
		    'condition' =>'sale.unit_id = sales_units.unit_id',
		    'joinType' => 'inner'
		));
		$resales = $this->Admin->getRows($con, 'resales');
		$data['resales'] = $resales ? $resales : array();

		// query for buyback unit
		$con = array();
		$con['selection'] = 'project.project_name, basic_floors.floor_types, sales_units.unit_type, sales_units.size_sqft as unit_size, basic_floors.price_sqft, sales_units.price_sqft as unit_price, users.fullname as from_user, takeback.*';
		$con['string_conditions'] = array(
			'date(takeback.created_at)' => $today
		);
		$con['innerJoin'] = array(array(
			'table' => 'sale',
			'condition' => 'sale.sale_id = takeback.sale_id',
			'joinType' => 'inner'
		),array(
			'table' => 'users',
			'condition' => 'takeback.user_id = users.user_id',
			'joinType' => 'inner'
		),array(
		    'table' => 'basic_floors',
		    'condition' =>'sale.floor_id = basic_floors.floor_id',
		    'joinType' => 'inner'
		 ),array(
		    'table' => 'project',
		    'condition' =>'basic_floors.project_id = project.project_id',
		    'joinType' => 'inner'
		),array(
		    'table' => 'sales_units',
		    'condition' =>'sale.unit_id = sales_units.unit_id',
		    'joinType' => 'inner'
		));
		$buy_backes = $this->Admin->getRows($con, 'takeback');
		$data['buy_backes'] = $buy_backes ? $buy_backes : array();
		
		$this->load->view('reports/daily_progress_report', $data);
	}

	function rebate_report() {
		$con['selection'] = 'project.project_name, basic_floors.floor_types, sales_units.size_sqft as unit_size, basic_floors.price_sqft, sales_units.price_sqft as unit_price, sales_units.unit_type, C.fullname as client, A.fullname as agent, rebates.*';
		$con['conditions'] = array();
		$con['innerJoin'] = array(
				array(
		            'table' => 'sale',
		            'condition' =>'sale.sale_id = rebates.sale_id',
		            'joinType' => 'inner'
		        ),array(
		            'table' => 'basic_floors',
		            'condition' =>'sale.floor_id = basic_floors.floor_id',
		            'joinType' => 'inner'
		        ),array(
		            'table' => 'users as C',
		            'condition' =>'sale.user_id = C.user_id',
		            'joinType' => 'inner'
		        ),array(
		            'table' => 'users as A',
		            'condition' =>'rebates.user_id = A.user_id',
		            'joinType' => 'inner'
		        ),array(
		            'table' => 'sales_units',
		            'condition' =>'sale.unit_id = sales_units.unit_id',
		            'joinType' => 'inner'
		        ),array(
		            'table' => 'project',
		            'condition' =>'basic_floors.project_id = project.project_id',
		            'joinType' => 'inner'
		   	));
		$rebates = $this->Admin->getRows($con, 'rebates');
		$data['rebates'] = $rebates ? $rebates : array();
		$this->load->view('reports/rebate_report', $data);
	}

}
?>