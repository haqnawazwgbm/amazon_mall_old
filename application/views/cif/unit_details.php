<table class="table">
	<tr>
		<th>Project</th>
		<th>Project Location</th>
		<th>Floor</th>
		<th>Unit</th>
		<th>Unit Size</th>
		<th>Unit Price</th>
	</tr>
	<?php if (!empty($units)): ?>
		<?php foreach ($units as $oneunit): ?>
			<tr>
				<td><?php echo $oneunit->project_name; ?></td>
				<td><?php echo $oneunit->project_location; ?></td>
				<td><?php echo $oneunit->floor_types; ?></td>
				<td><?php echo $oneunit->unit_type; ?></td>
				<td><?php echo $oneunit->totalarea; ?></td>
				<td><?php echo 'Rs: '.$oneunit->total_price; ?></td>
			</tr>
		<?php endforeach ?>
	<?php endif ?>

</table>