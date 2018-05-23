<h5><b>Payment: </b><?= $payment_title; ?></h5>
<table class="table">
	<tr>
		<th>Client</th>
		<td><?php if(!empty($sale)){ echo ucfirst($sale[0]->fullname);} ?></td>
	</tr>
	<tr>
		<th>Project</th>
		<td><?php if(!empty($sale)){ echo ucfirst($sale[0]->project_name);} ?></td>
	</tr>
	<tr>
		<th>Floor</th>
		<td><?php if(!empty($sale)){ echo ucfirst($sale[0]->floor_types);} ?></td>
	</tr>
	<tr>
		<th>Unit</th>
		<td><?php if(!empty($sale)){ echo ucfirst($sale[0]->unit_type);} ?></td>
	</tr>
	<tr>
		<th>Token Money</th>
		<td><?php if(!empty($sale)){ echo 'Rs.'.$sale[0]->token_money;} ?></td>
	</tr>
	<tr>
		<th>Token Money</th>
		<td><?php if(!empty($sale)){ echo 'Rs.'.$sale[0]->token_money;} ?></td>
	</tr>
	<tr>
		<th>Down Payment</th>
		<td><?php if(!empty($sale)){ echo 'Rs.'.$sale[0]->down_payment;} ?></td>
	</tr>
	<tr>
		<th>Sale Days</th>
		<td><?= $sale[0]->sale_days; ?></td>
	</tr>
	<tr>
		<th>Price/sqft</th>
		<td><?= $sale[0]->unit_price; ?></td>
	</tr>
	<tr>
		<th>Size/sqft</th>
		<td id="size_sqft"><?= $sale[0]->unit_size; ?></td>
	</tr>
	<?php $i=1; foreach ($insta as $one): ?>
	<tr>
		<th>Installment <?php echo $i; ?></th>
		<td><?php echo 'Rs.'.$one->paid; ?></td>
	</tr>
	<?php $i++; endforeach ?>
	<tr>
		<th>Total Amount</th>
		<td><?php if(!empty($Total)){ echo 'Rs.'.$Total;} ?></td>
		
	</tr>
	<tr>
		<th>Received Amount</th>
		<td><?php if(!empty($Paid)){ echo 'Rs.'.$Paid;} ?></td>
	</tr>
	<tr>
		<th>Remaining Amount</th>
		<td><?php $sum = $Total-$Paid; echo 'Rs.'.$sum; ?></td>
	</tr>
	
</table>

<script type="text/javascript">
	$(document).ready(function() {
		$('#price_sqft').on('change', function() {
			var price_sqft = $(this).val();
			var size_sqft = $('#size_sqft').html();
			$('#amount').val(price_sqft * size_sqft);
		})
	})
</script>