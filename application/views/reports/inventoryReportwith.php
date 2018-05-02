<br>
<a href="<?php echo base_url('Reports/printwithinventory'); ?>" class="btn btn-primary">Print PDF</a>
<?php foreach ($project as $one):?>
<br><br>
<h3 style="line-height:36px; background:#f4f4f4;"><b>Project: </b><?php echo $one->project_name;?></h3>
<div class="col-md-12">
	<?php $getFloor = $this->Admin->getAllData('basic_floors','',array('project_id' => $one->project_id)); ?>
	<?php foreach ($getFloor as $floor): ?>
		<h4 style="line-height:42px; background:#f1f1f1;"><b>Floor: </b><?php echo $floor->floor_types;?></h4>
		<div class="clearfix"></div>
		<table  width="100%">
			<tr>
				<th>Shop #</th>
				<th>Name</th>
				<th>Total Size [sqft]</th>
				<th>Rate/sqft</th>
				<th>Rent/sqft</th>
				<th>Status</th>
			</tr>
			<?php $getUnit = $this->Admin->getAllData('sales_units','',array('floor_id' => $floor->floor_id)); ?>
			<?php foreach ($getUnit as $shop): ?>
			<tr>
				<td><?php echo $shop->shopID; ?></td>
				<td><?php echo $shop->unit_type; ?></td>
				<td><?php echo $shop->size_sqft; ?></td>
				<td><?php echo 'Rs.'.$floor->price_sqft; ?></td>
				<td><?php echo $floor->rent_price; ?></td>
				<td><?php if($shop->sold == "1"){ echo "Sold"; } else { echo 'Available';} ?></td>
			</tr>
			<?php endforeach ?>
		</table>
	<?php endforeach ?>
</div>
<?php endforeach; ?>