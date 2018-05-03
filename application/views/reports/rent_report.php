<?php $this->session->set_userdata('rent_pdf',$filter_data); ?>
<br>
<a style="margin-left:1em;" href="<?php echo base_url('Reports/rent_pdf'); ?>" class="btn btn-primary">Print PDF</a>
<br>
<br>
<table class="table table-condensed">
	<tr>
		<th>Client</th>
		<th>Project</th>
		<th>Floor</th>
		<th>Unit</th>
		<th>Size/sqft</th>
		<th>Rent/sqft</th>
		<th>Rent</th>
		<th>Days</th>
	</tr>
	<?php $total_rent = 0;

		 if (!empty($sales)): ?>
	<?php foreach ($sales as $sale): 
		$total_rent = $total_rent + $sale->total_rent;
		if ($sale->days < 30) {
				$rent = $sale->total_rent / 30;
				$rent = $rent * $sale->days;
			} else {
				$rent = $sale->total_rent;
		}
	?>
	<tr>
		<td><?php echo $sale->fullname; ?></td>
		<td><?php echo $project[0]->project_name; ?></td>
		<td><?php echo $sale->floor_types; ?></td>
		<td><?php echo $sale->unit_type; ?></td>
		<td><?php echo $sale->size_sqft; ?></td>
		<td><?php echo $sale->rent_sqft; ?></td>
		<td><?php echo number_format((float)$rent, 2, '.', ''); ?></td>
		<td><?php if ($sale->days < 30) {
			echo $sale->days == 0 ? 0 : $sale->days; echo ' Days';
		} else {
			echo '1 month';
		 
		}
		?></td>
	</tr>
	<?php endforeach ?>
	<tr>
		<td colspan="5"></td><th>Total Rent:</th><td><?= ((float)$total_rentnumber_format, 2, '.', ''); ?></td>
	</tr>
	<?php else: ?>
	<tr>
		<td colspan="7"> No Results Found</td>
	</tr>
	<?php endif ?>
</table>