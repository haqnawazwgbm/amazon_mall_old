<style>
.col-md-12.unit-purchased {
	background: #f9f9f947;
	border: dotted 1px #ccc;
}
h4{

	font-size: 12px !important;
	background: #f1f1f1;
	line-height: 24px;
	padding-left: 10px;
}
th{
	padding-left: 10px !important;
	font-size: 8px !important; 
	line-height: 18px !important;
	text-align: left !important;
}
td{
	padding-left: 10px !important;
	font-size: 8px !important; 
	line-height: 18px !important;
	text-align: left !important;
}
h3{
	font-size: 13px !important;
	background: #f1f1f1;
	line-height: 24px;
	padding-left: 10px;
}
*{
	font-family:Segoe UI;
}
</style>
<?php $this->load->view('reports/header') ?>
<?php 
$total_remaining_amount = 0;
$total_paying_amount = 0;
$total_paid_amount = 0;
foreach ($project as $one):
	echo '<br><br><h3 style="padding-left:0.7em; line-height:36px; background:#f1f1f1;">'.$one->project_name.'</h3>';
	$FilterData = $filterData;
	$sessionType = $this->session->userdata('user_type');
	if($sessionType == "Agent"):
		$userid = $this->session->userdata('user_id');
		$FilterData['A.added_by'] = $userid;
	endif;
	$purchases = $this->Admin->DJoin(
		'A.*,B.*,C.*,D.*,B.size_sqft as square,U.fullname, A.square_feet, B.price_sqft as unit_price',
		'sale as A',
		'sales_units as B',
		array(
			'basic_floors as C' => 'C.floor_id = A.floor_id',
			'project as D' => 'D.project_id = C.project_id',
			'users as U' => 'U.user_id = A.user_id'  
		),
		'A.unit_id = B.unit_id',
		$FilterData
	);
	echo '<div class="col-md-12 unit-purchased">';?>
		<table class="table">
			<tr>
				<th width="10%">Customer</th>
				<th width="10%">Floor</th>
				<th>Sale Unit</th>
				<th>Unit Area</th>
				<th>Price/sqft</th>
				<th>Discount</th>
				<th>Unit Total Price</th>
				<th>Price With Discount</th>
				<th>Token Money</th>
				<th>Down Payment</th>
				<th>Total Paid</th>
				<th>Due Amount</th>
			</tr>
			<?php			
			if (!empty($purchases)):
				$total_payment_ = 0;
				$token_downpayment_paid = 0;
				foreach ($purchases as $single):?>

				<!-- Getting Installments For The Purchases -->
				<?php  
					$Saleid = $single->sale_id;
					$currentDate = date('Y-m-d');
					$con['conditions'] = array(
						'sale_id' => $Saleid,
						'status' => 1
					);
					$con['selection'] = 'sum(installments.paid) as paid';
					$con['returnType'] = 'object';
					$getInstallments = $this->Admin->getRows($con, 'installments');

					$unit_price = $single->unit_price == null ? $single->pricesqft : $single->unit_price;
					$unit_size = $single->square_feet == 0 ? $single->square : $single->square_feet;
					$totalPriceDiscount = $unit_price * $unit_size - $single->discount;
				?>
				<!-- End Of Purchases Of The Sales -->
				<tr>
					<td><?php echo ucfirst($single->fullname); ?></td>
					<td><?php echo $single->floor_types; ?></td>
					<td><?php echo $single->unit_type; ?></td>
					<td><?php echo $unit_size; ?></td>
					<td><?php echo 'Rs.'.$unit_price; ?></td>
					<td><?php echo 'Rs.'.$single->discount;?></td>
					<td><?php echo 'Rs.'.$unit_size * $unit_price; ?></td>
					<td><?php 

					 echo 'Rs.'.$totalPriceDiscount; ?></td>
			
					<td><?php 
					if ($single->recieved_token != 0) {
						echo 'Rs.'.$single->token_money; 
						$token_downpayment_paid = $token_downpayment_paid + $single->token_money;
					}
					else
					{
						echo 0;
						$token_downpayment_paid = $token_downpayment_paid + 0;
					}
					?></td>
					<td><?php 
					if ($single->recieved_downpayment != 0) {
						echo 'Rs.'.$single->down_payment;
						$token_downpayment_paid = $token_downpayment_paid + $single->down_payment;
					}
					else
					{
						echo 0;
						$token_downpayment_paid = $token_downpayment_paid + 0;
					}
					?></td>
					<td><?php 
					echo 'Rs.';
					$paid_amount = $token_downpayment_paid + $getInstallments[0]->paid;
					echo $paid_amount;
					?></td>
					<td>
						<?php 
						
						$total_paid_amount = $total_paid_amount + $paid_amount;
						$total_paying_amount = $total_paying_amount + $totalPriceDiscount;
						$remaining_amount = $totalPriceDiscount - $paid_amount;
						$total_remaining_amount = $total_remaining_amount + $remaining_amount;
						echo $remaining_amount;
						 ?>
					</td>
					
					
				</tr>
			<?php $remaining_amount = 0;
				  $paid_amount = 0;
				  $totalPriceDiscount = 0;
				  $token_downpayment_paid = 0;
			?>
			<?php endforeach; endif; ?>
			<tr>
				<th>Total Amount</th>
				<td colspan="7"><?= $total_paying_amount ?></td>
				<!-- <th colspan="2">Remaining Amount</th>
				<td colspan="2"><?php 
					echo "Rs. $total_remaining_amount"; 

				?></td> -->
				<!-- <th>Paid Amount</th>
				<td colspan="2">
					<?php 
					echo $total_paid_amount; 
					?>
				</td> -->
				<th>Total Paid Amount</th>
				<td>
					<?php 
						echo $total_paid_amount;
					?>
				</td>
				<th>Total Due Amount</th>
				<td>
					<?= $total_remaining_amount; ?>
				</td>
				
			</tr>
		</table>
	</div>
<?php 
$total_remaining_amount = 0;
$total_paying_amount = 0;
$total_paid_amount = 0;
$total_installment_paid = 0;
endforeach; ?>
<?php $this->load->view('reports/footer') ?>