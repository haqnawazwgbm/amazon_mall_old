<br>
<a href="<?php echo base_url('Reports/pdfsaleAllReport'); ?>" class="btn btn-primary">Print PDF</a>
<button style="margin-left:1em;" tableexport-id="396a47fc-xls" href="#" class="btn btn-primary xls">Print Excel</button>
<?php 
$total_remaining_amount = 0;
$total_paying_amount = 0;
$total_paid_amount = 0;
$total_installment_paid = 0;
foreach ($project as $one):
	echo '<br><br><h3 style="padding-left:0.7em; line-height:36px; background:#f1f1f1;">'.$one->project_name.'</h3>';
	$FilterData = $filterData;
	$sessionType = $this->session->userdata('user_type');
	if($sessionType == "Agent"):
		$userid = $this->session->userdata('user_id');
		$FilterData['A.added_by'] = $userid;
	endif;
	$purchases = $this->Admin->DJoin(
		'A.*,B.*,C.*,D.*,B.size_sqft as square,U.fullname',
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
				<th>Installments Paid</th>
				<th>Remaining Amount</th>
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
					$getInstallments = $this->Admin->getAllData('installments','amount',array('status' => 0, 'willberecievedon <=' => $currentDate,'sale_id' => $Saleid));
					$total_installment_paid = $total_installment_paid + $getInstallments[0]->amount;
				?>
				<!-- End Of Purchases Of The Sales -->
				<tr>
					<td><?php echo ucfirst($single->fullname); ?></td>
					<td><?php echo $single->floor_types; ?></td>
					<td><?php echo $single->unit_type; ?></td>
					<td><?php echo $single->square; ?></td>
					<td><?php echo 'Rs.'.$single->pricesqft; ?></td>
					<td><?php echo 'Rs.'.$single->discount;?></td>
					<td><?php echo 'Rs.'.$single->square * $single->pricesqft; ?></td>
					<td><?php $totalPriceDiscount = $single->square * $single->pricesqft - $single->discount; echo 'Rs.'.$totalPriceDiscount; ?></td>
			
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
					$getId = $single->sale_id;
					$Installments = $this->Admin->getAllData('installments','sum(paid) as paidamount',array('sale_id' => $getId,'status' => 1));
					echo 'Rs.';
					echo $Installments[0]->paidamount === NULL ? '0' : $Installments[0]->paidamount;
					?></td>
					<td>
						<?php 
						$paid_amount = $token_downpayment_paid + $Installments[0]->paidamount;
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
				<td colspan="2"><?= $total_paying_amount ?></td>
				<th colspan="2">Remaining Amount</th>
				<td colspan="2"><?php 
					echo "Rs. $total_remaining_amount"; 

				?></td>
				<th>Paid Amount</th>
				<td colspan="2">
					<?php 
					echo $total_paid_amount; 
					?>
				</td>
				<th>Due Installments</th>
				<td>
					<?php 
						echo $total_installment_paid;
					?>
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