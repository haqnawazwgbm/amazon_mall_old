<table class="table">
	<tr>
		<th>S.No</th>
		<th>Amount</th>
		<th>Remaining</th>
		<th>Paid</th>
		<th>Received Date</th>
		<th>Status</th>
		<th>Receiving Details</th>
		<th>Receive Payment</th>
	</tr>
	<?php if (!empty($installments)): ?>
		<?php 
		$i = 1;
		$paid_amount = 0;
		$remaining_amount = 0;
		$PaidAmount = [];
		foreach ($installments as $oneunit): 
			$remaining_amount = $remaining_amount + $oneunit->remaining;
			$paid_amount = $paid_amount + $oneunit->paid;
		?>
		<tr <?php if($oneunit->status == 1){ echo 'style="background:#f9f9f9"'; } ?>>
			<td><?php echo $i; ?></td>
			<td><?php echo 'Rs: '.$oneunit->amount; ?></td>
			<td><?php 
				if ($oneunit->paid > $oneunit->amount) {
					echo 'Rs: '.$oneunit->remaining.' <span style="font-size:11px; font-weight:bold;color:green">Plus Paid</span>'; 
				}
				elseif($oneunit->paid == 0)
				{
					echo 'Rs.'.$oneunit->remaining; 
				}
				elseif($oneunit->paid < $oneunit->amount){
					echo 'Rs.'.$oneunit->remaining.' <span style="font-size:11px; font-weight:bold;color:red">Less Paid</span>';
				}
				else
				{
					echo 'Rs: '.$oneunit->remaining; 
				}
				?></td>
			<td><?php echo 'Rs: '.$oneunit->paid; $PaidAmount[] = $oneunit->paid; ?></td>
			<td><?php 
				$date =  date("d M Y",strtotime($oneunit->updated_at)); 
				if ($date == '30 Nov -0001') {
					echo '';
				}
				else
				{
					echo $date;
				}
			?></td>
			<td><?php
			if ($oneunit->status == 0) {
				echo "<span style='color:red; font-weight:bold;'>Not Received</span>";
			}
			else
			{
				echo "<span class='fa fa-check'></span>";
			}
			?></td>
			<td>
				<?php 
					$getNote = $this->Admin->getAllData('payment_methods','',array('column_id' => $oneunit->installment_id,'pay_for'=> 'Installment'));
					if (!empty($getNote[0])) {
						 echo 'Method: '.$getNote[0]->method.'<br>';
						 if (!empty($getNote[0]->note)) {
						 	echo 'Note: '.$getNote[0]->note;
						 }
					}
				?>
			</td>
			<td>
				<?php if($oneunit->status == 1):?>
					<button class="btn btn-success">Received</button>
				<?php else: ?>
				<?php if ($oneunit->amount != '0'): ?>
					<button  data-toggle="modal" data-target="#modal<?php echo $oneunit->installment_id; ?>" class="btn btn-info">Receive Payment</button>
				<?php else: ?>
					<button disabled class="btn btn-info">Receive Payment</button>
				<?php endif ?>

					<div class="modal fade" id="modal<?php echo $oneunit->installment_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Receive Installment</h5>
								</div>
								<div class="modal-body">
									<label for="">Total Installment Amount: Rs.<?php echo $oneunit->amount; ?></label>

									<div class="form-group">
								        <label for="">Payment Method</label>
							          	<select name="paid_by" id="insta_pay" class="form-control" onchange="ShowInstallment($(this).val())" id="" required>
							             	<option value="Cash">Cash</option>
							             	<option value="Bank">Bank</option>
							          	</select>
								    </div>
									<div class="form-group" id="inst_bank" style="display: none;">
								        <label for="">Bank Name</label>
							          	<input type="text"  class="form-control" id="inst_bankname<?php echo $oneunit->installment_id ?>" required>
								    </div>
									<div class="form-group" id="inst_branch"  style="display: none;">
								        <label for="">Bank Branch</label>
							          	<input type="text"  class="form-control" id="inst_bankbranch<?php echo $oneunit->installment_id ?>" required>
								    </div>
									<div class="form-group" id="inst_cheque"  style="display: none;">
								        <label for="">Cheque no</label>
							          	<input type="text" class="form-control" id="inst_chequeno<?php echo $oneunit->installment_id ?>" required>
								    </div>
								    <div class="form-group">
								        <label for="">Notes</label>
								        <textarea class="form-control" name="" id="note<?php echo $oneunit->installment_id ?>" required cols="30" rows="10"></textarea>
								    </div>
									<div class="form-group">
										<label for="">Enter Installment Amount</label>
										<input type="text" class="form-control" id="installmentAmount">
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="button"  onclick="ReceiveInstallment($('#insta_pay').val(),<?php echo $oneunit->installment_id ?>,<?php echo $oneunit->sale_id; ?>,$('#installmentAmount').val(),<?php echo $oneunit->amount;  ?>)" class="btn btn-primary">Receive Installment</button>
								</div>
							</div>
						</div>
					</div><?php endif; ?>
				</td>
			</tr>
		<?php $i++; endforeach ?>
		<input type="hidden" value="<?php echo $paid_amount; ?>" id="paidamount">
		<input type="hidden" value="<?php echo $remaining_amount; ?>" id="remaining_amount">
			<tr>
				<th>Total Amount</th>
				<th id="TotalAmountCalculated">Total Amount</th>
				<th>Paid Amount</th>
				<th id="PaidAmountCalculated">Total Amount</th>
				<th>Remaining Amount</th>
				<th id="RemainingAmountCalculated">Total Amount</th>
			</tr>
	<?php endif ?>
</table>
<script>
	
	setTimeout(function(){
		var paid = $('#paidamount').val();
		var total = $('#TotalPayment').val();
		var token = $('#tokenMoney').text();
		var downpay = $('#Downpayment').text();
		token = parseFloat(token.replace('Rs.',''));
		downpay = parseFloat(downpay.replace('Rs.',''));
		remaingAmount = $('#remaining_amount').val();
		$('#TotalAmountCalculated').text('Rs.'+total);
		$('#PaidAmountCalculated').text((isNaN(paid)) ? 'Rs.'+0 : 'Rs.'+paid);
		if (parseFloat(paid) > parseFloat(total)) 
		{
			$('#RemainingAmountCalculated').text('Rs.0');
		}
		else
		{

			$('#RemainingAmountCalculated').text((isNaN(remaingAmount) ? 'Rs.'+0 : 'Rs.'+remaingAmount));
		}
	},1000);
	function ShowInstallment(id)
	{
		if (id=="Bank") 
		{
			$('#inst_bank').show();
			$('#inst_cheque').show();
			$('#inst_branch').show();
		}	
		else
		{
			$('#inst_bank').hide();
			$('#inst_cheque').hide();
			$('#inst_branch').hide();
		}
	}
</script>