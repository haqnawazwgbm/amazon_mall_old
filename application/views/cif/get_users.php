<div class="col-md-12">
	<br>
	<table class="table table-condensed">
		<tr>
			<th>Full Name</th>
			<th>Email</th>
			<th>Address</th>
			<th>Phone</th>
			<th>Selection</th>
		</tr>
		<?php if (!empty($users)): ?>
			<?php foreach ($users as $simple): ?>
			<tr>
				<td><?php echo $simple->fullname; ?></td>
				<td><?php echo $simple->email_id; ?></td>
				<td><?php echo $simple->address.' '.$simple->district.', '.$simple->city.' '.$simple->province.', '.$simple->country; ?></td>
				<td><?php echo $simple->phone_login.' , '.$simple->phone; ?></td>
				<td><a class="btn btn-info btn-sm" onclick="SelectUserLast(<?php echo $simple->user_id; ?>)">Select User</a></td>
			</tr>
			<?php endforeach ?>
		<?php endif ?>
	</table>
</div>
<script>
	function SelectUserLast(id) {
		if (confirm('Are You Sure About the Client?')) 
		{
			$('#clientid').val(id);
			$('#getuser').toggle();
			saveInstallments()
			$('#FinalUploadArea').toggle();
		}
	}
</script>