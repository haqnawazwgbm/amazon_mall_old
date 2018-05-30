<br>
<a href="<?php echo base_url('Reports/printwithinventory'); ?>" class="btn btn-primary">Print PDF</a>
<?php foreach ($project as $one):?>
	<?php  
		$currentDate = date("Y-m-d");
		$payments = $this->Admin->DJoin(
			'*',
			'sale as A',
			'basic_floors as B',
			array(
				'project as C' => 'C.project_id = B.project_id',
				'sales_units as D' => 'D.unit_id = A.unit_id',
				'users as E' => 'E.user_id = A.user_id',
				'installments as F' => 'F.sale_id = A.sale_id'
			),
			'A.floor_id = B.floor_id',
			array(
				'F.status' => 0,
				'F.willberecievedon <=' => $currentDate,
				'C.project_id' => $one->project_id,
				'E.type' => 'User'
			)
		);
	?>
	<br><br>
	<h3 style="line-height:36px;"><b>Project: </b><?php echo $one->project_name;?></h3>
	<div class="col-md-12">
		<table id="example" class="display" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Floor</th>
					<th>Sale Unit</th>
					<th>Client</th>
					<th>Email</th>
					<th>Contact #</th>
					<th>Installment Amount</th>
					<th>Installment Date</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!empty($payments)): ?>
					<?php foreach ($payments as $overdue): ?>
						<tr>
							<td><?php echo $overdue->floor_types; ?></td>
							<td><?php echo $overdue->unit_type; ?></td>
							<td class="text-primary"><b><?php echo $overdue->fullname; ?></b></td>
							<td><?php echo (!empty($overdue->email_id) ? $overdue->email_id : $overdue->phone_login); ?></td>
							<td><?php echo '0'.$overdue->phone; ?></td>
							<td class="text-info"><b><?php echo 'Rs.'.$overdue->amount;?></b></td>
							<td class="text-danger"><b><?php echo date("d M Y",strtotime($overdue->willberecievedon)); ?></b></td>
						</tr>
					<?php endforeach ?>
				<?php endif ?>
			</tbody>
		</table>
	</div>
<?php endforeach; ?>