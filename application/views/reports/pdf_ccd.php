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
	font-size: 10px !important; 
	line-height: 18px !important;
	text-align: left !important;
}
td{
	padding-left: 10px !important;
	font-size: 10px !important; 
	line-height: 18px !important;
	text-align: left !important;
}
.title{
	font-size: 13px !important;
	background: #f1f1f1;
	line-height: 24px;
	padding-left: 10px;
}
*{
	font-family:Segoe UI;
}
</style>
<?php  $Clientid = $clients[0]->user_id;  ?>
<?php if (!empty($clients)): ?>
	<?php foreach ($clients as $one): ?>
		<div class="col-md-12">
			<?php $this->load->view('reports/header') ?>
			<!-- START VERTICAL TABS -->
			<br>
			<p class="title">Client Information</p>  
			<table style="width: 100% !important;" class="table">
				<tr>
					<th width="15%">Client Name</th>
					<td width="18%"><?php echo $one->title.' '.$one->fullname; ?></td>
					<th width="15%">Email</th>
					<td width="18%"><?php echo $one->email_id; ?></td>
					<th width="15%">Phone</th>
					<td width="18%"><?php echo $one->phone_login; ?></td>
				</tr>
				<tr>
					<th>Phone (Optional)</th>
					<td><?php echo $one->phone; ?></td>
					<th>Nationality</th>
					<td><?php echo $one->country_name; ?></td>
					<th></th>
					<td></td>
				</tr>
				<tr>
					<th>Address</th>
					<td colspan="5"><?php echo $one->address.','.$one->city.' '.$one->district_name.'  '.$one->province_name.','.$one->country_name; ?></td>
				</tr>
			</table>
			<!-- END VERTICAL TABS -->
		</div>
	<?php endforeach ?>
<?php endif ?>
<?php  
$purchases = $this->Admin->DJoin(
	'A.*,B.*,C.*,D.*,B.size_sqft as square',
	'sale as A',
	'sales_units as B',
	array(
		'basic_floors as C' => 'C.floor_id = A.floor_id',
		'project as D' => 'D.project_id = C.project_id', 
	),
	'A.unit_id = B.unit_id',
	array(
		'A.user_id' => $Clientid, 
	)
);
if (!empty($purchases)):
	foreach ($purchases as $single):?>
	

	<div class="col-md-12 unit-purchased">
		<br>
		<?php
		$owners = $single->owners;
		if (!empty($owners)):
			echo '<p class="title">Other Owners</p>';
			$explode = explode('-', $owners);
			foreach ($explode as $getO): 
				$GetUser = $getUser = $this->Admin->DJoin(
					'*',
					'users',
					'countries',
					array(
						'provinces' => 'provinces.province_id = users.province',
						'districts' => 'districts.id = users.district'
					),
					'users.country = countries.id',
					array('users.user_id' => $getO)
				);
				?>
				<table style="width: 100% !important;" class="table">
					<tr>
						<th>Client Name</th>
						<td><?php echo $GetUser[0]->title.' '.$GetUser[0]->fullname; ?></td>
						<th>Email</th>
						<td><?php echo $GetUser[0]->email_id; ?></td>
						<th>Phone</th>
						<td><?php echo $GetUser[0]->phone_login; ?></td>
					</tr>
					<tr>
						<th>Phone (Optional)</th>
						<td><?php echo $GetUser[0]->phone; ?></td>
						<th>Nationality</th>
						<td><?php echo $GetUser[0]->country_name; ?></td>
						<th></th>
						<td></td>
					</tr>
					<tr>
						<th>Address</th>
						<td colspan="5"><?php echo $GetUser[0]->address.','.$GetUser[0]->city.' '.$GetUser[0]->district_name.'  '.$GetUser[0]->province_name.','.$GetUser[0]->country_name; ?></td>
					</tr>
				</table>
			<?php endforeach;
		endif;
		?>
		<br>
		<p class="title">Units Purchased</p>  
		<table style="width: 100% !important;" class="table">
			<tr>
				<th>Project</th>
				<td><?php echo $single->project_name; ?></td>
				<th>Project Location</th>
				<td><?php echo $single->project_location; ?></td>
				<th>Floor</th>
				<td><?php echo $single->floor_types; ?></td>
			</tr>
			<tr>
				<th>Sale Unit</th>
				<td><?php echo $single->unit_type; ?></td>
				<th>Unit Area</th>
				<td><?php echo $single->square; ?></td>
				<th>Price/sqft</th>
				<td><?php echo 'Rs.'.$single->pricesqft; ?></td>
			</tr>
			<tr>
				<th>Discount</th>
				<td><?php 
				echo 'Rs.'.$single->discount;
				?></td>
				<th>Price Per Square Feet After Discount</th>
				<td><?php 
				$discounted = $single->pricesqft-$single->discount; 
				echo 'Rs.'.$discounted; 
				?></td>
			</tr>
		</table>
		<br>
		<p class="title">Payment Information</p>
		<table style="width: 100% !important;" class="table">
			<tr>
				<th>Unit Total Price</th>
				<td><?php echo 'Rs.'.$single->pricesqft * $single->square; ?></td>
				<th>Token Money</th>
				<td><?php echo 'Rs.'.$single->token_money; ?></td>
				<th>Down Payment</th>
				<td><?php echo 'Rs.'.$single->down_payment; ?></td>
			</tr>
			<tr>
				<th>Unit Price After Discount</th>
				<td><?php 
				$totalPriceDiscount = $single->square*$discounted;
				echo '<b>Rs.'.$totalPriceDiscount.'</b>';
				?></td>
			</tr>
		</table>
		<p class="title">Payments Paid</p>
		<table style="width: 100% !important;" class="table">
			<tr>
				<th>Token Money</th>
				<td><?php  
				if ($single->recieved_token != "0") {
					echo 'Rs.'.$single->token_money;
				}
				else
				{
					echo "Not Paid";
				}
				?></td>
				<th>Down Payment</th>
				<td><?php  
				if ($single->recieved_downpayment != "0") {
					echo 'Rs.'.$single->down_payment;
				}
				else
				{
					echo "Not Paid";
				}
				?></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<?php  
					$method = $this->Admin->getAllData('payment_methods','',array('column_id' => $single->sale_id,'pay_for' => 'Token'));
					foreach ($method as $one) {
						if ($one->method == "Bank") {
							echo "Method: ".$one->method.'<br>';
							echo "Bank: ".$one->bank.'<br>';
							echo "Branch: ".$one->branch.'<br>';
							echo "Cheque#: ".$one->cheque.'<br>';
						}
						else
						{
							echo "Method: ".$one->method.'<br>';
						}
					}
					?>
				</td>
				<td></td>
				<td>
					
					<?php  
					$method = $this->Admin->getAllData('payment_methods','',array('column_id' => $single->sale_id,'pay_for' => 'DownPayment'));
					foreach ($method as $one) {
						if ($one->method == "Bank") {
							echo "Method: ".$one->method.'<br>';
							echo "Bank: ".$one->bank.'<br>';
							echo "Branch: ".$one->branch.'<br>';
							echo "Cheque#: ".$one->cheque.'<br>';
						}
						else
						{
							echo "Method: ".$one->method.'<br>';
						}
					}
					?>
				</td>
			</tr>
		</table>
		<p class="title">Installments</p>
		<?php 
		$totalInstallments = '';
		$installments = $this->Admin->DJoin(
			'A.*,B.method',
			'installments as A',
			'payment_methods as B',
			'',
			'A.installment_id = B.column_id',
			array(
				'A.sale_id' => $single->sale_id, 
			),
			'updated_at ASC'
		);
		if (!empty($installments)) {
			$totalInstallments = $installments;
		}
		else
		{
			$totalInstallments = $this->Admin->getAllData('installments','',array('sale_id' => $single->sale_id),'created_at DESC'); 
		}
		?>
		<table style="width: 100% !important;" class="table">
			<tr>
				<th>S.No</th>
				<th>Amount</th>
				<th>Remaining</th>
				<th>Paid</th>
				<th>Payment Method</th>
				<th>Staus</th>
				<th>Recieved Date</th>
			</tr>
			<?php 
			$PaidAmount   = [];
			$i = 1; foreach ($totalInstallments as $each): ?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo 'Rs.'.$each->amount; ?></td>
				<td><?php 
						if ($each->remaining > $each->amount) {
							echo 'Rs.'.$each->remaining.' Extra Paid';
						}
						else if($each->remaining < $each->amount)
						{
							echo 'Rs.'.$each->remaining.' Less Paid';
						}
						else
						{
							echo 'Rs.'.$each->remaining;
						}
				 ?></td>
				<td><?php echo 'Rs.'.$each->paid; $PaidAmount[] = $each->paid;?></td>
				<td><?php if (!empty($each->method)) { echo $each->method;} ?></td>
				<td>
					<?php 
					if ($each->status == '1') {
						echo "Recieved";
					} 
					else
					{
						echo "Not Recieved";
					}
					?></td>
					<td><?php 
					$date = date("d M Y H:i:s",strtotime($each->updated_at)); 
					if ($date == "30 Nov -0001 00:00:00") {
						echo "";
					}
					else
					{
						echo $date;
					}
					?></td>
				</tr>
				<?php $i++; endforeach ?>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="background: #f9f9f9 !important; line-height: 40px !important;">
					<th>Total Amount</th>
					<td><?php  
					if (empty($single->discount)) {
						echo 'Rs.'.$single->total_price;
					}
					else
					{
						echo 'Rs.'.$totalPriceDiscount;
					}
					?></td>

					<th>Paid Amount</th>
					<td><?php 
					$paid =  array_sum($PaidAmount); 
					if ($single->recieved_token != '0') {
						$token = $single->token_money;
					}
					else
					{
						$token = 0;
					}
					if ($single->recieved_downpayment != '0') {
						$down = $single->down_payment;
					}
					else
					{
						$down = 0;
					}
					$totalPaid = $paid+$token+$down;
					echo 'Rs.'.$totalPaid;
					?></td>
					<th>Remaining Amount</th>
					<td><?php 
					if (!empty($single->discount)) {
						 $sum = $totalPriceDiscount - $totalPaid;
						echo 'Rs.'.$sum;
					}
					else
					{
						$remain = $single->total_price - $totalPaid; 
						echo 'Rs.'.$remain;
					}
					?></td>
				</tr>
			</table>
			<br>
		</div>
	<?php endforeach; endif; ?>
			<?php $this->load->view('reports/footer') ?>
	
