<table class="table">
	<tr>
		<th>Month</th>
		<th>Year</th>
		<th>Amount</th>
		<th>Remaining</th>
		<th>Paid</th>
		<th>Date</th>
	</tr>
	<?php if (!empty($plan)): ?>
		<?php foreach ($plan as $oneunit): ?>
			<tr>
				<td><?php echo $oneunit->month; ?></td>
				<td><?php echo $oneunit->year; ?></td>
				<td><?php echo $oneunit->amount; ?></td>
				<td><?php echo $oneunit->remaining; ?></td>
				<td><?php echo $oneunit->paid; ?></td>
				<td><?php echo date("d M Y",strtotime($oneunit->created_at)); ?></td>
			</tr>
		<?php endforeach ?>
	<?php endif ?>
	
</table>