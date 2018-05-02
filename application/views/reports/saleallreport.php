<br>
<a href="<?php echo base_url('Reports/pdfsaleAllReport'); ?>" class="btn btn-primary">Print PDF</a>
<?php 
foreach ($project as $one):
	echo '<br><br><h3 style="padding-left:0.7em; line-height:36px; background:#f1f1f1;">'.$one->project_name.'</h3>';
	$FilterData =array(
			'C.project_id' => $one->project_id
		);
	$sessionType = $this->session->userdata('user_type');
	if($sessionType == "Agent"):
		$userid = $this->session->userdata('user_id');
		$FilterData['A.added_by'] = $userid;
	endif;
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
	echo '<div class="col-md-12 unit-purchased">';?>
		<table class="table">
			<tr>
				<th width="10%">Floor</th>
				<th>Sale Unit</th>
				<th>Unit Area</th>
				<th>Price/sqft</th>
				<th>Discount</th>
				<th>Price With Discount</th>
				<th>Unit Total Price</th>
				<th>Price With Discount</th>
				<th>Installments Paid</th>
				<th>Token Money</th>
				<th>Down Payment</th>
			</tr>
			<?php			
			if (!empty($purchases)):
				$TotalAmount = [];
				$PaidAmount = [];
				$TokenMoney = [];
				$InstallmentAmounts = [];
				$DownPayment = [];
				foreach ($purchases as $single):?>

				<!-- Getting Installments For The Purchases -->
				<?php  
					$Saleid = $single->sale_id;
					$currentDate = date('Y-m-d');
					$getInstallments = $this->Admin->getAllData('installments','amount',array('status' => 0, 'willberecievedon <=' => $currentDate,'sale_id' => $Saleid));
					$InstallmentAmounts[] = $getInstallments[0]->amount;
				?>
				<!-- End Of Purchases Of The Sales -->
				<tr>
					<td><?php echo $single->floor_types; ?></td>
					<td><?php echo $single->unit_type; ?></td>
					<td><?php echo $single->square; ?></td>
					<td><?php echo 'Rs.'.$single->pricesqft; ?></td>
					<td><?php echo 'Rs.'.$single->discount;?></td>
					<td><?php  $discounted = $single->pricesqft-$single->discount; echo 'Rs.'.$discounted; ?></td>
					<td><?php echo 'Rs.'.$single->square * $single->pricesqft; ?></td>
					<td><?php $totalPriceDiscount = $single->square * $discounted; echo 'Rs.'.$totalPriceDiscount; ?></td>
					<?php  
					if (!empty($totalPriceDiscount)) {
						$TotalAmount[] = $totalPriceDiscount;
					}
					else
					{
						$TotalAmount = $single->total_price;
					}
					?>
					<td><?php 
					$getId = $single->sale_id;
					$Installments = $this->Admin->getAllData('installments','sum(paid) as paidamount',array('sale_id' => $getId,'status' => 1));
					$paidamount = $Installments[0]->paidamount;
					echo 'Rs.'.$paidamount;
					$PaidAmount[] = $paidamount;
					?></td>
					<td><?php 
					if ($single->recieved_token != 0) {
						echo 'Rs.'.$single->token_money; 
						$PaidAmount[] = $single->token_money;
					}
					else
					{
						echo 0;
					}
					?></td>
					<td><?php 
					if ($single->recieved_downpayment != 0) {
						echo 'Rs.'.$single->down_payment;
						$PaidAmount[] = $single->down_payment;
					}
					else
					{
						echo 0;
					}
					?></td>
				</tr>
			<?php endforeach; endif; ?>
			<tr>
				<th>Total Amount</th>
				<td colspan="2"><?php if(!empty($TotalAmount)){ echo 'Rs.'.array_sum($TotalAmount);} ?></td>
				<th colspan="3">Remaining Amount</th>
				<td><?php 
				if (!empty($TotalAmount)) {
					$Total = array_sum($TotalAmount);
				}
				if (!empty($PaidAmount)) {
					$Paids = array_sum($PaidAmount);
				}
				
				if (!empty($Total)) {
					$Remaining = $Total - $Paids;
					if ($PaidAmount > $Total) {
						echo 'Rs.0'; 
					}
					else
					{
						echo 'Rs.'.$Remaining; 
					}
				}
				?></td>
				<th>Paid Amount</th>
				<td>
					<?php 
					if(!empty($PaidAmount))
					{  
						$Paidamount = array_sum($PaidAmount); 
						if ($Paidamount > $Total) {
							echo 'Rs.'.$Total; 
						}
						else
						{
							echo 'Rs.'.$Paidamount; 
						}
					} 
					?>
				</td>
				<th>Due Installments</th>
				<td>
					<?php 
					if(!empty($InstallmentAmounts))
					{  
						$DueInstallments = array_sum($InstallmentAmounts);
						echo 'Rs.'.$DueInstallments; 
					} 
					?>
				</td>
			</tr>
			<?php $Total = ''; $TotalAmount = ''; $PaidAmount = ''; $Remaining = ''; ?>
		</table>
	</div>
<?php endforeach; ?>