<br>
<a href="<?php echo base_url('Reports/printinventory'); ?>" class="btn btn-primary">Print PDF</a>
<?php foreach ($project as $one):?>
<br><br>
<h3 style="padding-left:0.7em; line-height:36px; background:#f4f4f4;"><?php echo $one->project_name;?></h3>
<div class="col-md-12">
	<?php $getFloor = $this->Admin->getAllData('basic_floors','',array('project_id' => $one->project_id)); ?>
	<?php foreach ($getFloor as $floor): ?>
		<h4 style="padding-left:0.7em; line-height:36px;"><?php echo $floor->floor_types;?></h4>
		<div class="clearfix"></div>
		<table  width="100%">
			<tr>
				<th>Shop #</th>
				<th>Name</th>
				<th>Size sqft</th>
				<th>Rate/sqft</th>
				<th>Status</th>
				<th>Owner</th>
				<th>Owner Contact</th>
			</tr>
			<?php $getUnit = $this->Admin->getAllData('sales_units','',array('floor_id' => $floor->floor_id)); ?>
			<?php foreach ($getUnit as $shop): ?>
			<tr>
				<td><?php echo $shop->shopID; ?></td>
				<td><?php echo $shop->unit_type; ?></td>
				<td><?php echo $shop->size_sqft; ?></td>
				<td><?php echo 'Rs.'.$floor->price_sqft; ?></td>
				<td><?php if($shop->sold == "1"){ echo "Sold"; } else { echo 'Available';} ?></td>
				<?php if ($shop->sold = "1"): ?>
				<?php $getuser = $this->Admin->DJoin('users.fullname,users.phone,users.phone_login','sale','users','','sale.user_id = users.user_id',array('sale.unit_id' => $shop->unit_id));?>
				<td><?php echo $getuser[0]->fullname; ?></td>
				<td><?php if(!empty($getuser[0]->phone)) { echo $getuser[0]->phone; } else { echo $getuser[0]->phone_login; } ?></td>
				<?php else: ?>
				<td> - </td>
				<td> - </td>
				<?php endif ?>
			</tr>
			<?php endforeach ?>
		</table>
	<?php endforeach ?>
</div>
<?php endforeach; ?>