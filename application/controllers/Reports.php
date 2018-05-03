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

	function SaleReport()
	{
		$Project = $this->input->post('project');
		$Floor = $this->input->post('floor');
		$From = $this->input->post('from');
		$To = $this->input->post('to');

		// Data For Filteration
		$FilterData = array(
								'C.project_id' => $Project,
								'A.floor_id' => $Floor,
								'A.sale_date >' => $From, 
								'A.sale_date <' => $To,
								'A.recieved_downpayment' => 1,
								'D.sold' => 1,
							);
		// Checking if its Sale Agent
		$sessionType = $this->session->userdata('user_type');

		if($sessionType == "Agent"):
			$userid = $this->session->userdata('user_id');
			$FilterData['A.added_by'] = $userid;
		endif;

		if ($Project !="Select Project" && $Floor!="Select Floor" && !empty($From) && !empty($To)):
			$SaleAdmin = $this->Admin->DJoin(
							'A.sale_id,A.pricesqft,A.sale_date,C.project_name,C.project_location,D.unit_type,B.floor_types,D.size_sqft',
							'sale as A',
							'basic_floors as B',
							array(
								'project as C' => 'C.project_id = B.project_id',
								'sales_units as D' => 'D.unit_id = A.unit_id'
							),
							'A.floor_id = B.floor_id',
							$FilterData,
							'A.sale_date ASC'
						);
			$data['Report'] = $SaleAdmin;
			$data['filterData'] = array(
				'project' => $Project,
				'floor' => $Floor,
				'from' => $From,
				'to' => $To
			);
			$this->load->view('reports/sale',$data);
		elseif(!empty($From) && !empty($To)):
			$data['project'] = $this->Admin->getAllData('project');
			$this->load->view('reports/saleallreport',$data);
		else:
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
							
				$con['selection'] = "sale.sale_id, basic_floors.floor_types, basic_floors.rent_price as rent_sqft, sales_units.unit_type, sales_units.size_sqft, sum(installments.remaining) as remaining, MAX(installments.updated_at) as last_paid, users.fullname, (sales_units.size_sqft * basic_floors.rent_price) as total_rent, DATEDIFF('$current_date',installments.updated_at) as days";
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
		     /*   echo '<pre>';
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

	function rent_pdf() {	
			$data['project'] = $this->Admin->getAllData('project');
				$date = date('Y-m');
				$date = strtotime($date . ' - 1 month');
				$date = date('Y-m',$date);
				$current_date = date('Y-m-d');					
				$con['selection'] = "sale.sale_id, basic_floors.floor_types, basic_floors.rent_price as rent_sqft, sales_units.unit_type, sales_units.size_sqft, sum(installments.remaining) as remaining, MAX(installments.updated_at) as last_paid, users.fullname, (sales_units.size_sqft * basic_floors.rent_price) as total_rent, DATEDIFF('$current_date',installments.updated_at) as days";
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
		        ));
		        $con['groupBy'] = array('sale.sale_id');
		        $con['returnType'] = 'object';
		        $con['having_conditions'] = array(
		        	'remaining <=' => 0
		        );
		        $sales = $this->Admin->getRows($con, 'sale');
		        $data['sales'] = $sales ? $sales : array();

		    	$filename = time()."_order.pdf";
				$html = $this->load->view('reports/pdf_rent_report',$data, true);
				$this->ppdf->pdf->WriteHTML($html);
				$this->ppdf->pdf->Output("assets/uploads/files/".$filename, "D");
			
		
		
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
        	'sale_id' => $sale_id
        );
        $data['installments'] = $this->Admin->getRows($con, 'installments');
                                                
        $this->load->view('reports/payment_report', $data);
	}

	function get_payment_method($installment_id) {
		$con['conditions'] = array(
			'column_id' => $installment_id
		);
		$payments = $this->Admin->getRows($con, 'payment_methods');
		$payments = $payments ? $payments : array();
		return $payments;
	}

}
?>