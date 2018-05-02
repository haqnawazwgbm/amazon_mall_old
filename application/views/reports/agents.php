<br><br>
<table class="table table-condensed">
	<tr>
		<th>Agent Name</th>
		<th>Email</th>
		<th>Phone</th>
		<th>Total Sales</th>
		<th>Total Payment</th>
		<th>From Date</th>
		<th>To Date</th>
	</tr>
	<?php if (!empty($Report)): ?>
		<?php foreach ($Report as $simple): ?>
		<tr>
			<td><?php echo $simple->fullname; ?></td>
			<td><?php echo $simple->email_id; ?></td>
			<td><?php echo $simple->phone_login; ?></td>
			<td class="text-success text-center" style="font-weight: bold;"><?php echo $simple->TotalSales; ?></td>
			<td class="text-success" style="font-weight: bold;">Rs.<?php echo $simple->total; ?></td>
			<td><?php echo $From; ?></td>
			<td><?php echo $To; ?></td>
		</tr>
		<?php endforeach ?>
	<?php else: ?>
		<tr>
			<td colspan="7"> No Results Found</td>
		</tr>
	<?php endif ?>
</table>