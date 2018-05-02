<br><br>
<table class="table table-condensed">
	<tr>
		<th>Project</th>
		<th>Location</th>
		<th>Floor</th>
		<th>Sale Unit</th>
		<th>Area / Sqft</th>
		<th>Total Price</th>
		<th>Sale Date</th>
	</tr>
	<?php if (!empty($Report)): ?>
		<?php foreach ($Report as $simple): ?>
		<tr>
			<td><?php echo $simple->project_name; ?></td>
			<td><?php echo $simple->project_location; ?></td>
			<td><?php echo $simple->floor_types; ?></td>
			<td><?php echo $simple->unit_type; ?></td>
			<td><?php echo $simple->size_sqft; ?> square feets</td>
			<td class="text-success" style="font-weight: bold;">Rs.<?php echo $simple->total_price; ?></td>
			<td><?php echo date("d F Y",strtotime($simple->sale_date)); ?></td>
		</tr>
		<?php endforeach ?>
	<?php else: ?>
		<tr>
			<td colspan="7"> No Results Found</td>
		</tr>
	<?php endif ?>
</table>