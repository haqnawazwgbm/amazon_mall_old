<table class="table">
	<tr>
		<th>Full Name</th>
		<th>Phone</th>
		<th>Email</th>
		<th>Country </th>
		<th>Province</th>
		<th>District</th>
		<th>City</th>
	</tr>
	<?php if (!empty($explode)): ?>
		<?php foreach ($explode as $list): 
			$getuser = $allusers = $this->Admin->DJoin(
				'*',
				'users',
				'countries',
				 array(
				 	'provinces' => 'provinces.province_id = users.province',
				 	'districts' => 'districts.id = users.district'
				 ),
				'users.country = countries.id',
				array('users.user_id' => $list)
			);
		?>
		<tr>
			<td><?php echo $getuser[0]->fullname; ?></td>
			<td><?php echo $getuser[0]->phone_login; ?></td>
			<td><?php echo $getuser[0]->email_id; ?></td>
			<td><?php echo $getuser[0]->country_name; ?></td>
			<td><?php echo $getuser[0]->province_name; ?></td>
			<td><?php echo $getuser[0]->district_name; ?></td>
			<td><?php echo $getuser[0]->city; ?></td>
		</tr>
		<?php endforeach ?>
	<?php endif ?>
</table>