<style>
	th{
		font-size: 11px !important;
		text-align: left !important;
	}
	td{
		font-size: 11px !important;
	}
</style>
<?php $this->load->view('reports/header'); ?>
<?php foreach ($project as $one):?>
<h3 style="padding-left:0.7em; line-height:36px; background:#f4f4f4;"><?php echo $one->project_name;?></h3>
<div class="col-md-12">
	<?php $getFloor = $this->Admin->getAllData('basic_floors','',array('project_id' => $one->project_id)); ?>
	<?php foreach ($getFloor as $floor): ?>
		<h4 style="padding-left:0.7em; line-height:36px; background:#f1f1f1;"><?php echo $floor->floor_types;?></h4>
		<div class="clearfix"></div>
		<table class="table" style="width: 100% !important;">
			<tr>
				<th>Project</th>
				<th>Location</th>
				<th>Shop #</th>
				<th>Name</th>
				<th>Total Size [sqft]</th>
				<th>Rate/sqft</th>
				<th>Status</th>
			</tr>
			<?php $getUnit = $this->Admin->getAllData('sales_units','',array('floor_id' => $floor->floor_id)); ?>
			<?php foreach ($getUnit as $shop): ?>
			<tr>
				<td><?php echo $one->project_name; ?></td>
				<td><?php echo $one->project_location; ?></td>
				<td><?php echo $shop->shopID; ?></td>
				<td><?php echo $shop->unit_type; ?></td>
				<td><?php echo $shop->size_sqft; ?></td>
				<td><?php echo 'Rs.'.$shop->price_sqft; ?></td>
				<td><?php if($shop->sold == "1"){ echo "Sold"; } else { echo 'Available';} ?></td>
			</tr>
			<?php endforeach ?>
		</table>
	<?php endforeach ?>
</div>
<?php endforeach; ?>
<?php $this->load->view('reports/footer'); ?>
