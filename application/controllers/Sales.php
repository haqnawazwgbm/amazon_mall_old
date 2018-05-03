<?php  

/**
*. Sales Controller 
*/

class Sales extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('logged') != true) {
			redirect(base_url().'Login');
		}
		$type = $this->session->userdata('user_type');
		if ($type != "Admin" && $type != 'Accountant' && $type != 'ccd') {
			redirect(base_url().'Login');
		}
	}

	function index()
	{
		$this->load->view('sales/sale');
	}

	function hold()
	{
		$this->load->view('sales/sale');
	}


	function spaces()
	{
		$this->load->view('sales/space');
	}

	function review_sales() {
		$this->load->view('sales/sale');
	}

	function TakeBack()
	{

	}

	// getting all agents
	function getAllSales($type = '')
	{
		/*$selectFields 	= '*,sales_units.size_sqft as totalarea,sale.created_at as recentdate,sales_units.unit_id';
		$firstTable 	= 'sale';
		$secondTable 	= 'basic_floors';
		$onFields		= 'sale.floor_id = basic_floors.floor_id';
		$whereArray     = array('sales_units' => 'sales_units.unit_id = sale.unit_id',
			'project' => 'basic_floors.project_id = project.project_id', 
			'users' => 'sale.user_id = users.user_id'
		);
		if ($type == 'hold') {
			$where = array('sales_units.sold' => 2, 'sale.resale' => 0);
		} else {
			$where = array('sales_units.sold' => 1, 'sale.resale' => 0);
		}
		*/
		$con['selection'] = '*,sales_units.size_sqft as totalarea,sale.created_at as recentdate,sales_units.unit_id';

		if ($type == 'hold') {
			$con['conditions'] = array(
				'sales_units.sold' => 2,
				'sale.resale' => 0
			);
		} elseif ($type == 'review_sales') {
			$con['conditions'] = array(
				'sales_units.sold' => 1,
				'sale.resale' => 0,
				'sale.documents_received' => 0
			);
		} else {
			$con['conditions'] = array(
				'sales_units.sold' => 1,
				'sale.resale' => 0
			);
		}
		
		$con['returnType'] = 'object';
		$con['innerJoin'] = array(array(
            'table' => 'basic_floors',
            'condition' =>'sale.floor_id = basic_floors.floor_id',
            'joinType' => 'inner'
        ),array(
            'table' => 'sales_units',
            'condition' =>'sales_units.unit_id = sale.unit_id',
            'joinType' => 'inner'
        ),array(
            'table' => 'project',
            'condition' =>'basic_floors.project_id = project.project_id',
            'joinType' => 'inner'
        ),array(
            'table' => 'users',
            'condition' =>'sale.user_id = users.user_id',
            'joinType' => 'inner'
        ));
		
		$searchResult = $this->Admin->getRows($con, 'sale');
		$searchResult = $searchResult ? $searchResult : array();
		$fetchAllAgents = array();
		foreach ($searchResult as $each) {
			if ($type == 'hold') {
				$Buttons = '
				<div class="dropdown">
				  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
				  <span class="caret"></span></button>
				  <ul class="dropdown-menu">
				    <li><a onclick="confirm_hold_sale('.$each->unit_id.')">Confirm</a></li>
				     <li><a onclick="deleteSale('.$each->sale_id.','.$each->unit_id.')">Delete</a></li>
				  </ul>
				</div>';
			} elseif ($type == 'review_sales') {
				$Buttons = '
				<a class="btn btn-primary" onclick="approve_sale('.$each->sale_id.')">Reviewed</a>';
			} else {
				$Buttons = '
				<div class="dropdown">
				  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
				  <span class="caret"></span></button>
				  <ul class="dropdown-menu">
				    <li><a href="'.base_url().'Sales/installmentPlan/'.$each->sale_id.'">Payments</a></li>
				    <li><a onclick="ShowTakenback('.$each->sale_id.','.$each->user_id.')">Take Back</a></li>
				    <li><a  onclick="showTransfereFrom('.$each->sale_id.','.$each->user_id.',' . $each->totalarea .')">Resell</a></li>
				    <li><a onclick="deleteSale('.$each->sale_id.','.$each->unit_id.')">Delete</a></li>
				  </ul>
				</div>';
			}
			

			// Finding Over Due Downpayments
			$downpayemnt = '';
			$soldDate    = date("Y-m-d",strtotime($each->sale_date."+2 days"));
			$currentDate = date("Y-m-d");
			if ($each->recieved_downpayment == 0 && $soldDate <= $currentDate) {
				$downpayment = "<b class='text-danger'>Over Due</b>";
			}
			else
			{
				$downpayment = 'Rs.'.$each->down_payment;
			}

			$fetchAllAgents[] = array(
				'11' 	=> date("d M Y",strtotime($each->recentdate)),
				'0' 	=> $each->project_name,
				'1' 	=> $each->project_location,
				'2' 	=> $each->floor_types,
				'3' 	=> $each->unit_type,
				'4'	 	=> $each->fullname,
				'6' 	=> $each->phone_login,
				'7' 	=> $each->totalarea.' sqft',
				'8' 	=> 'Rs: '.$each->totalarea*$each->pricesqft,
				'12'	=> $downpayment,
				'9'	 	=> $Buttons
			);
		}
		$output = array(
			"data" => $fetchAllAgents
		);

		echo json_encode($output); 
	}

	// getting all agents
	function getAllSoledSpaces()
	{
		$selectFields 	= '*,basic_floors.size_sqft as totalarea,sale.created_at as recentdate';
		$firstTable 	= 'sale';
		$secondTable 	= 'basic_floors';
		$onFields		= 'sale.floor_id = basic_floors.floor_id';
		$whereArray     = array(
			'project' => 'basic_floors.project_id = project.project_id', 
			'users' => 'sale.user_id = users.user_id'
		);
		$where = array('sale.resale' => 0, 'sale.unit_id' => 0);
		$searchResult = $this->Admin->DJoin($selectFields,$firstTable,$secondTable,$whereArray,$onFields,$where);
		$fetchAllAgents = array();
		foreach ($searchResult as $each) {
			$Buttons = '<a href="'.base_url().'Sales/spaceInstallmentPlan/'.$each->sale_id.'" class="btn btn-primary btn-xs">Payments</a>
			<a onclick="ShowTakenback('.$each->sale_id.','.$each->user_id.')" class="btn btn-danger btn-xs">Take Back</a>&nbsp;<a onclick="showTransfereFrom('.$each->sale_id.','.$each->user_id.',' . $each->totalarea .')" class="btn btn-danger btn-xs">Resell</a>';

			// Finding Over Due Downpayments
			$downpayemnt = '';
			$soldDate    = date("Y-m-d",strtotime($each->sale_date."+2 days"));
			$currentDate = date("Y-m-d");
			if ($each->recieved_downpayment == 0 && $soldDate <= $currentDate) {
				$downpayment = "<b class='text-danger'>Over Due</b>";
			}
			else
			{
				$downpayment = 'Rs.'.$each->down_payment;
			}

			$fetchAllAgents[] = array(
				'11' 	=> date("d M Y",strtotime($each->recentdate)),
				'0' 	=> $each->project_name,
				'1' 	=> $each->project_location,
				'2' 	=> $each->floor_types,
				'3' 	=> $each->square_feet,
				'4'	 	=> $each->fullname,
				'6' 	=> $each->phone_login,
				'10'	 	=> $each->pricesqft,
				'7' 	=> $each->totalarea.' sqft',
				'8' 	=> 'Rs: '.$each->totalarea*$each->pricesqft,
				'12'	=> $downpayment,
				'9'	 	=> $Buttons
			);
		}
		$output = array(
			"data" => $fetchAllAgents
		);

		echo json_encode($output); 
	}

		// getting all agents
	function getAllResales($project_id, $floor_id, $unit_id)
	{
		/*$selectFields 	= '*,sales_units.size_sqft as totalarea,sale.created_at as recentdate';
		$firstTable 	= 'sale';
		$secondTable 	= 'basic_floors';
		$onFields		= 'sale.floor_id = basic_floors.floor_id';
		$whereArray     = array('sales_units' => 'sales_units.unit_id = sale.unit_id',
			'resales' => 'resales.sale_id = sale.sale_id',
			'project' => 'basic_floors.project_id = project.project_id', 
			'users' => 'resales.from_user_id = users.user_id'
		);
		$where = array('sale.floor_id' => $floor_id, 'sale.unit_id' => $unit_id, 'project.project_id' => $project_id);
		$groupBy = 'resales.id';
		$searchResult = $this->Admin->DJoin($selectFields,$firstTable,$secondTable,$whereArray,$onFields,$where, '', $groupBy);*/

		$con['selection'] = '*,sales_units.size_sqft as totalarea,sale.created_at as recentdate, sale.square_feet, basic_floors.type as floor_type';
		$con['conditions'] = array(
			'sale.floor_id' => $floor_id,
			'sale.unit_id' => $unit_id,
			'project.project_id' => $project_id
		);
		$con['groupBy'] = array('resales.id');
		$con['returnType'] = 'object';
		$con['innerJoin'] = array(array(
            'table' => 'basic_floors',
            'condition' =>'sale.floor_id = basic_floors.floor_id',
            'joinType' => 'inner'
        ),array(
            'table' => 'resales',
            'condition' =>'resales.sale_id = sale.sale_id',
            'joinType' => 'inner'
        ),array(
            'table' => 'project',
            'condition' =>'basic_floors.project_id = project.project_id',
            'joinType' => 'inner'
        ),array(
            'table' => 'users',
            'condition' =>'resales.from_user_id = users.user_id',
            'joinType' => 'inner'
        ),array(
            'table' => 'sales_units',
            'condition' =>'sales_units.unit_id = sale.unit_id',
            'joinType' => 'left'
        ));
        $searchResult = $this->Admin->getRows($con, 'sale');
        $searchResult = $searchResult ? $searchResult : array();
		$fetchAllAgents = array();
		foreach ($searchResult as $each) {
			$Buttons = '<a href="'.base_url().'Sales/installmentPlan/'.$each->sale_id.'" class="btn btn-primary btn-xs">Payments</a>
			<a onclick="ShowTakenback('.$each->sale_id.','.$each->user_id.')" class="btn btn-danger btn-xs">Take Back</a><a onclick="showTransfereFrom('.$each->sale_id.','.$each->user_id.',' . $each->totalarea .')" class="btn btn-danger btn-xs">Resell</a>';

			// Finding Over Due Downpayments
			$downpayemnt = '';
			$soldDate    = date("Y-m-d",strtotime($each->sale_date."+2 days"));
			$currentDate = date("Y-m-d");
			if ($each->recieved_downpayment == 0 && $soldDate <= $currentDate) {
				$downpayment = "<b class='text-danger'>Over Due</b>";
			}
			else
			{
				$downpayment = 'Rs.'.$each->down_payment;
			}
			$each->pricesqft = $each->floor_type == 'space' ? $each->square_feet * $each->pricesqft : $each->totalarea*$each->pricesqft;
			$fetchAllAgents[] = array(
				'11' 	=> date("d M Y",strtotime($each->recentdate)),
				'0' 	=> $each->project_name,
				'1' 	=> $each->project_location,
				'2' 	=> $each->floor_types,
				'3' 	=> $each->floor_type == 'space' ? 'space' : $each->unit_type,
				'4'	 	=> $each->fullname,
				'6' 	=> $each->phone_login,
				'7' 	=> $each->floor_type == 'space' ? $each->square_feet : $each->totalarea.' sqft',
				'8' 	=> 'Rs: '. $each->pricesqft,
				'12'	=> $downpayment,
				'13'	=> $each->transfer_fee
				//'9'	 	=> $Buttons
			);
		}
		$output = array(
			"data" => $fetchAllAgents
		);

		echo json_encode($output); 
	}

	function installmentPlan()
	{
		$this->load->view('sales/installment_plan');
	}

	function spaceInstallmentPlan()
	{
		$this->load->view('sales/space_installment_plan');
	}

	// Inital Payments
	function InitialPayments($sale_type = 'unit')
	{
		$id = $this->input->post('id');
		$sale = $this->Admin->getAllData('sale','', array('sale_id' => $id)); 
		if (!empty($sale)): 
			foreach ($sale as $getone): 
				if ($sale_type == 'space') {
					$getSaleunit = $this->Admin->DJoin('*,basic_floors.price_sqft as price,sale.square_feet as size','sale','basic_floors','','basic_floors.floor_id = sale.floor_id',array('sale.sale_id' => $id));	
				} else {
					$getSaleunit = $this->Admin->DJoin('*,basic_floors.price_sqft as price,sales_units.size_sqft as size','sales_units','basic_floors','','basic_floors.floor_id = sales_units.floor_id',array('sales_units.unit_id' => $getone->unit_id));
				}
			
				?>
				<table class="table">
					<tr>
						<th>Total Payment</th>
						<td><?php  
						echo 'Rs.'.$getone->pricesqft * @$getSaleunit[0]->size;
						?></td>
						<th>Discount</th>
						<td>
							<?php if (!empty($getone->discount)): ?>
								<?php echo 'Rs.'.$getone->discount; ?>
							<?php else: ?>
								0
							<?php endif ?>
						</td>
						<th>Total Money After Discount</th>
						<td>
							<?php if (!empty($getone->discount)): ?>
								<?php 
								$price = $getone->pricesqft;
								$total = $price * @$getSaleunit[0]->size - $getone->discount;
								echo 'Rs.'.$total;
								?>
							<?php else: ?>
								<?php echo 'Rs.'.$getone->total_payment; ?>
							<?php endif ?>
						</td>
					</tr>
				</table>
				<?php 
				echo '<input type="hidden" id="TotalPayment" value="'.$getone->total_payment.'">';
				if ($getone->recieved_token != '0'){ ?>

				<div class="col-md-4">
					<label for="">Token Money: <span id="tokenMoney"><?php echo 'Rs.'.$getone->token_money ?><span></label><br>
						<?php $getmethod = $this->Admin->getAllData('payment_methods','',array('pay_for'=> 'Token','column_id' => $id));  
						if (@$getmethod[0]->method == "Bank"):
							?>
							<label for="">Payment Method: <?php echo @$getmethod[0]->method ?></label><br>
							<label for="">Bank Name: <?php echo @$getmethod[0]->bank ?></label><br>
							<label for="">Bank Branch: <?php echo @$getmethod[0]->branch ?></label><br>
							<label for="">Cheque Number: <?php echo @$getmethod[0]->cheque ?></label>
						<?php else: ?>
							<label for="">Payment Method: <?php echo @$getmethod[0]->method ?></label>
						<?php endif; ?>
					</div>
					<?php }else{ ?>
					<div class="col-md-4">
						<div class="form-group">
							<label for="">Payment Method</label>
							<select name="paid_by" id="token_pay" class="form-control" onchange="ShowOthers($(this).val())" id="" required>
								<option value="Cash">Cash</option>
								<option value="Bank">Bank</option>
							</select>
						</div>
						<div class="form-group" id="token_bank" style="display: none;">
							<label for="">Bank Name</label>
							<input type="text"  class="form-control" id="cash_bankname" required>
						</div>
						<div class="form-group" id="token_branch"  style="display: none;">
							<label for="">Bank Branch</label>
							<input type="text"  class="form-control" id="cash_bankbranch" required>
						</div>
						<div class="form-group" id="token_cheque"  style="display: none;">
							<label for="">Cheque no</label>
							<input type="text" class="form-control" id="cash_chequeno" required>
						</div>
						<div class="form-group">
							<label for="">Notes</label>
							<textarea class="form-control" name="" id="tokennote" required cols="30" rows="4"></textarea>
						</div>
						<div class="form-group">
							<label for="">Token Money</label>
							<input type="text" value="<?php echo $getone->token_money; ?>" class="form-control" id="token_money">
							<br>
							<input type="button" onclick="Recieve(<?php echo $getone->sale_id ?>,<?php echo $getone->token_money ?>,$('#token_money').val(),$('#token_pay').val(),'Token')" class="btn btn-primary" value="Recieve Token Money">
						</div>
					</div>
					<?php 
				}
				if ($getone->recieved_downpayment != '0'){?>
				<div class="col-md-4">
					<label for="">Down Payment Money: <span id="Downpayment"><?php echo 'Rs.'.$getone->down_payment; ?></span></label><br>
					<?php $getmethod = $this->Admin->getAllData('payment_methods','',array('pay_for'=> 'DownPayment','column_id' => $id));  
					if (@$getmethod[0]->method == "Bank"):
						?>
						<label for="">Payment Method: <?php echo @$getmethod[0]->method ?></label><br>
						<label for="">Bank Name: <?php echo @$getmethod[0]->bank ?></label><br>
						<label for="">Bank Branch: <?php echo @$getmethod[0]->branch ?></label><br>
						<label for="">Cheque Number: <?php echo @$getmethod[0]->cheque ?></label>
					<?php else: ?>
						<label for="">Payment Method: <?php echo @$getmethod[0]->method ?></label>
					<?php endif; ?>
				</div>
				<?php }
				else{ ?>
				<div class="col-md-4">
					<div class="form-group">
						<label for="">Payment Method</label>
						<select name="paid_by" id="token_paid" class="form-control" onchange="ShowDown($(this).val())" id="" required>
							<option value="Cash">Cash</option>
							<option value="Bank">Bank</option>
						</select>
					</div>
					<div class="form-group" id="down_bank" style="display: none;">
						<label for="">Bank Name</label>
						<input type="text"  class="form-control" id="down_bankname" required>
					</div>
					<div class="form-group" id="down_branch"  style="display: none;">
						<label for="">Bank Branch</label>
						<input type="text"  class="form-control" id="down_bankbranch" required>
					</div>
					<div class="form-group" id="down_cheque"  style="display: none;">
						<label for="">Cheque no</label>
						<input type="text" class="form-control" id="down_chequeno" required>
					</div>
					<div class="form-group">
						<label for="">Notes</label>
						<textarea class="form-control" name="" id="downnote" required cols="30" rows="4"></textarea>
					</div>
					<div class="form-group">
						<label for="">Down Payment</label>
						<input type="text" value="<?php echo $getone->down_payment; ?>" class="form-control" id="down_payment">
						<br>
						<input type="button" onclick="Recieve(<?php echo $getone->sale_id ?>,<?php echo $getone->token_money ?>,$('#down_payment').val(),$('#token_paid').val(),'Down')" class="btn btn-primary" value="Recieve Down Payment">
					</div>
				</div>
				<?php 
			}
		endforeach; 
	endif; 
}

	// Installments 
function Installments()
{
	$id = $this->input->post('id');
	$data['installments'] = $this->Admin->getAllData('installments','',array('sale_id' => $id, 'amount >' => 0));
	$this->load->view('sales/installments',$data);
}

function RecieveToken()
{
	$check 	= $this->input->post('state');
	$saleid 	= $this->input->post('id');
	$previous 	= $this->input->post('pre');
	$amount 	= $this->input->post('amount');
	$note 	= $this->input->post('note');
	$method = $_POST['method'];
	if ($check == 'Token'):
		if ($method == "Cash") {
			$array = array(
				'column_id' 	=> $saleid,
				'method' 	=> $_POST['method'],
				'bank' 		=> '',
				'branch' 	=> '',
				'cheque' 	=> '',
				'date'		=> date("Y-m-d"),
				'pay_for'	=> 'Token',
				'note'		=> $note
			);
			$this->Admin->InsertData('payment_methods',$array);
		}
		else
		{
			$array = array(
				'column_id' 	=> $saleid,
				'method' 	=> $_POST['method'],
				'bank' 		=> $_POST['bankname'],
				'branch' 	=> $_POST['branch'],
				'cheque' 	=> $_POST['cheque'],
				'date'		=> date("Y-m-d"),
				'pay_for'	=> 'Token',
				'note'		=> $note
			);
			$this->Admin->InsertData('payment_methods',$array);
		}
		// checking if the amount is equal
		if ($previous == $amount) {
			// Update Then 
			$updateArray = array(
				'recieved_token ' => 1,
				'recieved_by' => $this->session->userdata('user_id'),
				'updated_at' => date("Y-m-d h:i:s")
			);
			$update = $this->Admin->UpdateDB('sale',array('sale_id' => $saleid),$updateArray);
		}
		else
		{
			// updated Previous with new and also Adjust Installments
			$UpdateToken = array(
				'recieved_token' => 1,
				'recieved_by' => $this->session->userdata('user_id'),
				'token_money' => $amount,
				'updated_at' => date("Y-m-d h:i:s")
			);
			$updateToken = $this->Admin->UpdateDB('sale',array('sale_id' => $saleid),$UpdateToken);
			// Updating Installments
			$getTotal = $this->Admin->getAllData('sale','installments,token_money,down_payment,total_payment',array('sale_id' =>$saleid));
			$getInstallments = $this->Admin->getAllData('installments','installment_id',array('sale_id' =>$saleid));
			if (!empty($getTotal)) {
				$totalPay 	 	= $getTotal[0]->total_payment; 
				$tokenmoney  	= $getTotal[0]->token_money; 
				$downpayment 	= $getTotal[0]->down_payment; 
				$totalyears  	= $getTotal[0]->installments; 
				$totalToPay 	= ((float)$downpayment+(float)$tokenmoney);
				$amountToBePaid = ((float)$totalPay-(float)$totalToPay); 
				$getFinalAmount = $amountToBePaid / $totalyears;
				foreach ($getInstallments as $one) {
					$UpdateInstallment = array(
						'amount'    => $getFinalAmount,
						'remaining' => $getFinalAmount
					);
					$updateInstallment = $this->Admin->UpdateDB('installments',array('installment_id' => $one->installment_id),$UpdateInstallment);
				}
			}
		}
		// Down Payment Receiving 
	else:
		if ($method == "Cash") {
			$array = array(
				'column_id' 	=> $saleid,
				'method' 	=> $_POST['method'],
				'bank' 		=> '',
				'branch' 	=> '',
				'cheque' 	=> '',
				'date'		=> date("Y-m-d"),
				'pay_for'	=> 'DownPayment',
				'note'		=> $note
			);
			$this->Admin->InsertData('payment_methods',$array);
		}
		else
		{
			$array = array(
				'column_id' 	=> $saleid,
				'method' 	=> $_POST['method'],
				'bank' 		=> $_POST['bankname'],
				'branch' 	=> $_POST['branch'],
				'cheque' 	=> $_POST['cheque'],
				'date'		=> date("Y-m-d"),
				'pay_for'	=> 'DownPayment',
				'note'		=> $note
			);
			$this->Admin->InsertData('payment_methods',$array);
		}
			// checking if the amount is equal
		if ($previous == $amount) {
			// Update Then 
			$updateArray = array(
				'recieved_downpayment ' => 1,
				'recieved_by' => $this->session->userdata('user_id'),
				'updated_at' => date("Y-m-d h:i:s")
			);
			$update = $this->Admin->UpdateDB('sale',array('sale_id' => $saleid),$updateArray);
		}
		else
		{
			// updated Previous with new and also Adjust Installments
			$UpdateToken = array(
				'recieved_downpayment' => 1,
				'recieved_by' => $this->session->userdata('user_id'),
				'down_payment' => $amount,
				'updated_at' => date("Y-m-d h:i:s")
			);
			$updateToken = $this->Admin->UpdateDB('sale',array('sale_id' => $saleid),$UpdateToken);
				// Updating Installments
			$getTotal = $this->Admin->getAllData('sale','installments,token_money,down_payment,total_payment',array('sale_id' => $saleid));
			$getInstallments = $this->Admin->getAllData('installments','installment_id',array('sale_id' => $saleid));
			if (!empty($getTotal)) {
				$totalPay 	 	= $getTotal[0]->total_payment; 
				$tokenmoney  	= $getTotal[0]->token_money; 
				$downpayment 	= $getTotal[0]->down_payment; 
				$totalyears  	= $getTotal[0]->installments; 
				$totalToPay 	= ((float)$downpayment+(float)$tokenmoney);
				$amountToBePaid = ((float)$totalPay-(float)$totalToPay); 
				$getFinalAmount = $amountToBePaid / $totalyears;
				foreach ($getInstallments as $one) {
					$UpdateInstallment = array(
						'amount'    => $getFinalAmount,
						'remaining' => $getFinalAmount
					);
					$updateInstallment = $this->Admin->UpdateDB('installments',array('installment_id' => $one->installment_id),$UpdateInstallment);
				}
			}
		}
		// Email Generating
		


	endif;
}

function ReceiveInstallment()
{
	$note = $_POST['note'];
	$method = $_POST['method'];
	if ($method == "Bank") {
		$PaymentMethod = array(
			'column_id' => $_POST['id'],
			'method' 	=> $method,
			'bank' 		=> $_POST['bankname'],
			'branch' 	=> $_POST['branch'],
			'cheque' 	=> $_POST['cheque'],
			'pay_for' 	=> 'Installment',
			'date' 		=> date("Y-m-d"),
			'note'		=> $note
		);
		$this->Admin->InsertData('payment_methods',$PaymentMethod);
	}
	else
	{
		$PaymentMethod = array(
			'column_id' => $_POST['id'],
			'method' 	=> $method,
			'bank' 		=> '',
			'branch' 	=> '',
			'cheque' 	=> '',
			'pay_for' 	=> 'Installment',
			'date' 		=> date("Y-m-d"),
			'note'		=> $note
		);
		$this->Admin->InsertData('payment_methods',$PaymentMethod);
	}

	$id 	  = $this->input->post('id');
	$saleid   = $this->input->post('saleid');
	$amount   = $this->input->post('amount');
	$previous = $this->input->post('previous');

	if ($amount == $previous) {
		$updateAll = array(
			'amount' => $amount,
			'remaining' => 0,
			'paid' => $amount,
			'updated_at' => date("Y-m-d h:i:s"),
			'status' => 1,
			'received_by' => 1
		);
		$update = $this->Admin->UpdateDB('installments',array('sale_id' => $saleid,'installment_id' => $id),$updateAll);
	}
	else 
	{
		$remaining = '';
		if ($amount > $previous) {
			$remaining = ($amount - $previous);
		}
		else
		{
			$remaining = ($previous-$amount);
		}
		$updateAll = array(
			'amount' => $previous,
			'remaining' => $remaining,
			'paid' => $amount,
			'updated_at' => date("Y-m-d h:i:s"),
			'status' => 1,
			'received_by' => 1
		);
		$update = $this->Admin->UpdateDB('installments',array('sale_id' => $saleid,'installment_id' => $id),$updateAll);
		$getTotal = $this->Admin->getAllData('sale','token_money,down_payment,total_payment',array('sale_id' =>$saleid));
		$getpaid = $this->Admin->getAllData('installments','paid',array('status' => 1,'sale_id' => $saleid));
		$paidAmount = '';
		$paidArray  = [];
		if (!empty($getpaid)):
			foreach ($getpaid as $each) {
				$paidArray[] = $each->paid;
			}
			$paidAmount = array_sum($paidArray);
		else:
			$paidAmount = 0;
		endif;
		if (!empty($getTotal)) {
			$getInstallments = $this->Admin->getAllData('installments','installment_id',array('status' => 0,'sale_id' => $saleid));
			$totalPay 	 	= $getTotal[0]->total_payment; 
			$tokenmoney  	= $getTotal[0]->token_money; 
			$downpayment 	= $getTotal[0]->down_payment; 
			$totalToPay 	= ((float)$downpayment+(float)$tokenmoney+(float)$paidAmount);
			$amountToBePaid = ((float)$totalPay-(float)$totalToPay); 
			$countMonth     = count($getInstallments); 
			$getFinalAmount = $amountToBePaid / $countMonth;
			foreach ($getInstallments as $one) {
				$UpdateInstallment = array(
					'amount'    => $getFinalAmount,
					'remaining' => $getFinalAmount
				);
				$updateInstallment = $this->Admin->UpdateDB('installments',array('installment_id' => $one->installment_id),$UpdateInstallment);
			}
		}
	}
}

function TackBackPayment()
{
	$method = $_POST['paid_by'];
	$token  = $_POST['token_money'];
	$userid = $_POST['userid'];
	$saleid = $_POST['saleid'];
	$note   = $_POST['note'];
	$SaleUnit = $this->Admin->getAllData('sale','',array('sale_id' => $saleid));
	$SaleDocs = $this->Admin->getAllData('sale_documents','',array('sale_id' => $saleid));
	$SaleInst = $this->Admin->getAllData('installments','',array('sale_id' => $saleid));
	$PayMetho = $this->Admin->getAllData('payment_methods','',array('column_id' => $saleid));
		// Saving Log 
	$TakeBack = array(
		'sale_id' => $saleid,
		'user_id' => $userid,
		'amount' => $token,
	);
	$this->Admin->InsertData('takeback',$TakeBack);
	$takebackid = $this->db->insert_id();
	$LogArray = array(
		'Unit' 			=> $SaleUnit,
		'Documents' 	=> $SaleDocs,
		'Installments' 	=> $SaleInst,
		'Payment' 		=> $PayMetho,
	);
	$saveLog = $this->Admin->InsertData('logs',array('column_id' => $takebackid, 'type' => 'TakeBack','data' => json_encode($LogArray)));

	$ColumnId = $this->db->insert_id();
	if ($saveLog) {
		
		$saleids = $this->Admin->getAllData('sale','unit_id',array('sale_id' => $saleid));
		$SaleDocs = $this->Admin->DeleteDB('sale',array('sale_id' => $saleid));
		$SaleDocs = $this->Admin->DeleteDB('sale_documents',array('sale_id' => $saleid));
		$SaleInst = $this->Admin->DeleteDB('installments',array('sale_id' => $saleid));
		$PayMetho = $this->Admin->DeleteDB('payment_methods',array('column_id' => $saleid));
			// Update Sales Units
		$Unitid = $saleids[0]->unit_id;
		$Update = $this->Admin->UpdateDB('sales_units',array('unit_id' => $Unitid),array('sold' => 0));	
			// DeleteData 
		if ($method == "Bank") {
			$Method = array(
				'method' 	=> $method,
				'bank' 		=> $_POST['bankname'],
				'cheque' 	=> $_POST['chequeno'],
				'branch' 	=> $_POST['bankbranch'],
				'pay_for' 	=> 'TakeBack',
				'date' 		=> date("Y-m-d"),
				'column_id' => $ColumnId,
				'note'		=> $note
			);
			$this->Admin->InsertData('payment_methods',$Method);
		}
		else
		{
			$Method = array(
				'method' 	=> $method,
				'bank' 		=> '',
				'cheque' 	=> '',
				'branch' 	=> '',
				'pay_for' 	=> 'TakeBack',
				'date' 		=> date("Y-m-d"),
				'column_id' => $ColumnId,
				'note'		=> $note
			);
			$this->Admin->InsertData('payment_methods',$Method);
		}
		$response = array('success' => true, 'param' => 'success', 'message' => 'User Added Successfully');
		echo json_encode($response);
	}
	else
	{
		$response = array('success' => true, 'param' => 'danger', 'message' => 'User Added Successfully');
		echo json_encode($response);
	}

}

function TackBackRe()
{
	$user = $_POST['user'];
	$sale = $_POST['sale'];

	$selectFields 	= '*';
	$firstTable 	= 'sale';
	$where = array('sale.sale_id' => $sale, 'sale.user_id' => $user);
	$sales = $this->Admin->DJoin($selectFields,$firstTable,'users','','sale.user_id = users.user_id',$where);
	
	//$sales = $this->Admin->getAllData('sale','recieved_downpayment,recieved_token,total_payment,token_money,down_payment',array('sale_id' => $sale,'user_id' => $user));
	$inst = $this->Admin->getAllData('installments','paid',array('sale_id' => $sale,'status' =>'1'));
	$Data = [];
	$tol = $sales[0];
	$Data['Total'] = $tol->total_payment;
	$paid = [];
	if ($tol->recieved_token !='0') {
		$paid[] = $tol->token_money; 
	}
	if ($tol->recieved_downpayment !='0') {
		$paid[] = $tol->down_payment; 
	}
	if (!empty($inst)) {
		foreach ($inst as $one) {
			$paid[] = $one->paid;
		}
	}
	$sum = array_sum($paid);
	$Data['Paid'] = $sum;
	$Data['sale'] = $sales;
	$Data['insta'] = $inst;
	$this->load->view('sales/takeback',$Data);
}

function TackBacks()
{
	$data['tackback'] = $this->Admin->DJoin('*','takeback','logs','','takeback.id=logs.column_id');
	$this->load->view('sales/takebacks',$data);
}

function getalerts()
{
	$data['alerts'] =  $this->Admin->DJoin(
		'A.sale_id,A.sale_date,
		C.project_name,C.project_location,
		D.unit_type,B.floor_types,D.size_sqft',
		'sale as A',
		'basic_floors as B',
		array(
			'project as C' => 'C.project_id = B.project_id',
			'sales_units as D' => 'D.unit_id = A.unit_id'
		),
		'A.floor_id = B.floor_id',
		array(
			'A.status' => 0
		),
		'A.sale_date ASC'
	);
	$this->load->view('incs/alerts',$data);
}

function ReadAlert()
{
	$this->Admin->UpdateDB('sale',array('sale_id' => $_POST['id']),array('status' => 1));
}


function Message()
{
	$type = '';
	$check = $this->session->userdata('user_type');
	if ($check == "Admin") {
		$data['messages'] = $this->Admin->DJoin('messages.title,messages.status,messages.subject,messages.created_at,users.fullname,messages.id,messages.urgency','messages','users','','messages.sent_by = users.user_id','','messages.created_at DESC');
	}
	else
	{
		$data['messages'] = $this->Admin->DJoin('messages.title,messages.status,messages.subject,messages.created_at,users.fullname,messages.id,messages.urgency','messages','users','','messages.sent_by = users.user_id',array('messages.department' => "Accounts"),'messages.created_at DESC');
	}
	$this->load->view('sales/inbox',$data);
}

function messageDetails()
{
	$id = $this->uri->segment(3);
	$this->Admin->UpdateDB('messages',array('id' => $id),array('status' => 1));
	$data['messages'] = $this->Admin->DJoin('messages.title,messages.status,messages.subject,messages.created_at,users.fullname,messages.id,messages.urgency,messages.department,messages.message,users.email_id','messages','users','','messages.sent_by = users.user_id');
	$this->load->view('sales/message',$data);
}

function getMessagealerts()
{
	$type = '';
	$check = $this->session->userdata('user_type');
	if ($check == "Admin") {
		$data['alerts'] = $this->Admin->DJoin('messages.title,messages.status,messages.subject,messages.created_at,users.fullname,messages.id,messages.urgency','messages','users','','messages.sent_by = users.user_id',array('messages.status' => 0),'messages.created_at DESC');
	}
	else
	{
		$data['alerts'] = $this->Admin->DJoin('messages.title,messages.status,messages.subject,messages.created_at,users.fullname,messages.id,messages.urgency','messages','users','','messages.sent_by = users.user_id',array('messages.status' => 0,'messages.department' => "Accounts"),'messages.created_at DESC');
	}
	$this->load->view('incs/messages',$data);
}

function ReadMessageAlert()
{
	echo base_url().'Sales/messageDetails/'.$_POST['id'];
}

/**
*  Finding Customer Over Dues Installments
*/
	
function Dues()
{

	$currentDate = date("Y-m-d");
	$data['payments'] = $this->Admin->DJoin(
			'*',
			'sale as A',
			'basic_floors as B',
			array(
				'project as C' => 'C.project_id = B.project_id',
				'sales_units as D' => 'D.unit_id = A.unit_id',
				'users as E' => 'E.user_id = A.user_id',
				'installments as F' => 'F.sale_id = A.sale_id'
			),
			'A.floor_id = B.floor_id',
			array(
				'F.status' => 0,
				'F.contacted' => 0,
				'F.willberecievedon <=' => $currentDate
			)
	);
	$this->load->view('sales/Dues',$data);
}

public function update_dues() {
	$id = $this->input->post('installment_id');
	$contacted = $this->input->post('contacted');
	$data = array(
			'contacted' => $contacted
		);
	$condition = array(
		'installment_id' => $id
	);
	$this->Admin->UpdateDB('installments', $condition, $data);
	$response = array('success' => true, 'param' => 'success','installment_id' => $id, 'message' => 'Overdue approved successfully.');
	$this->output->set_content_type('application/json')->set_output(json_encode($response));
}

public function resale() {
	$from_user_id = $this->input->post('from_user_id');
	$to_user_id = $this->input->post('to_user_id');
	$sale_id = $this->input->post('sale_id');

	$con['conditions'] = array(
		'sale_id' => $sale_id
	);
	$con['returnType'] = 'single';
	$saleData = $this->Admin->getRows($con, 'sale');
	unset($saleData['sale_id']);
	$saleData['status'] = 1;
	$saleData['user_id'] = $to_user_id;
	$this->Admin->InsertData('sale',$saleData);

	$this->Admin->UpdateDB('sale',array('sale_id' => $sale_id),array('resale' => 1));

	$data = array(
		'sale_id' => $sale_id,
		'from_user_id' => $from_user_id,
		'to_user_id' => $to_user_id,
		'transfer_fee' => $this->input->post('transfer_fee'),
		'status' => 1
	);

	$this->Admin->InsertData('resales',$data);
	$response = array('success' => true, 'param' => 'success','sale_id' => $sale_id, 'message' => 'Unit Resale Successfully. Upload customer documents');
	exit(json_encode($response));
}

	function get_resales()
	{
		$this->load->view('sales/resales');
	}
	function delete() {
		$sale_id = $this->input->post('sale_id');
		$unit_id = $this->input->post('unit_id');
		$condition = array(
			'sale_id' => $sale_id
		);
		$this->Admin->DeleteDB('sale', $condition);
		$this->Admin->DeleteDB('installments', $condition);

		$condition = array(
			'unit_id' => $unit_id
		);
		$data = array(
			'sold' => 0
		);
		$this->Admin->UpdateDB('sales_units', $condition, $data);
		$response = array('success' => true, 'param' => 'success','sale_id' => $sale_id, 'message' => 'Sale deleted successfully.');
		$this->output->set_content_type('application/json')
            ->set_output(json_encode($response));
	}
	function update_unit() {
		$unit_id = $this->input->post('unit_id');
		$sold = $this->input->post('sold');

		$data = array(
			'sold' => $sold
		);
		$condition = array(
			'unit_id' => $unit_id
		);
		$this->Admin->UpdateDB('sales_units', $condition, $data);
		$response = array('success' => true, 'param' => 'success','unit_id' => $unit_id, 'message' => 'Sale confirm successfully.');
		$this->output->set_content_type('application/json')
            ->set_output(json_encode($response));
	}

	function update_sale() {
		$sale_id = $this->input->post('sale_id');
		$documents_received = $this->input->post('documents_received');

		$data = array(
			'documents_received' => $documents_received
		);
		$condition = array(
			'sale_id' => $sale_id
		);
		$this->Admin->UpdateDB('sale', $condition, $data);
		$response = array('success' => true, 'param' => 'success','sale_id' => $sale_id, 'message' => 'Sale approve successfully.');
		$this->output->set_content_type('application/json')
            ->set_output(json_encode($response));
	}

}?>