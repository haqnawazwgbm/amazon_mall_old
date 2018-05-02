<br><br>
<table class="table table-condensed">
	<tr>
		<th>Client Name</th>
		<th>Email</th>
		<th>Phone</th>
		<th>Phone (opt)</th>
		<th>Address</th>
		<th>Country</th>
		<th>Province</th>
		<th>District</th>
		<th>City</th>
		<th>Enrolled Date</th>
	</tr>
	<?php if (!empty($clients)): ?>
		<?php foreach ($clients as $simple): ?>
		<tr>
			<td><?php echo $simple->fullname; ?></td>
			<td><?php echo $simple->email_id; ?></td>
			<td><?php echo $simple->phone_login; ?></td>
			<td><?php echo $simple->phone; ?></td>
			<td><?php echo $simple->address; ?></td>
			<td><?php echo $simple->country_name; ?></td>
			<td><?php echo $simple->province_name; ?></td>
			<td><?php echo $simple->district_name; ?></td>
			<td><?php echo $simple->city; ?></td>
			<td><?php echo date("d F Y",strtotime($simple->created_at)); ?></td>
		</tr>
		<?php endforeach ?>
	<?php else: ?>
		<tr>
			<td colspan="7"> No Results Found</td>
		</tr>
	<?php endif ?>
</table>