<br><br>
<table class="table table-condensed">
	<tr>
		<th>Agent</th>
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
			<td><?php echo $simple->fullname; ?></td>
			<td><?php echo $simple->project_name; ?></td>
			<td><?php echo $simple->project_location; ?></td>
			<td><?php echo $simple->floor_types; ?></td>
			<td><?php echo $simple->unit_type; ?></td>
			<td><?php echo $simple->size_sqft; ?></td>
			<td><?php echo 'Rs.'.$simple->size_sqft * $simple->pricesqft; ?></td>
			<td><?php echo $simple->sale_date; ?></td>
		</tr>
		<?php endforeach ?>
	<?php else: ?>
		<tr>
			<td colspan="7"> No Results Found</td>
		</tr>
	<?php endif ?>
</table>