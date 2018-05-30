<div class="col-md-12">
	<h4 style="background: #e2d555; padding:5px;">Search Result</h4>
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Sale Unit</th>
				<th>Size</th>
				<th>Price/sqft</th>
				<th>Total Price</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
			<?php if (!empty($result)): ?>
				<?php foreach ($result as $value): 
				?>
				<tr>
					<td><?php echo $value->unit_type; ?></td>
					<td><?php echo $value->size_sqft; ?></td>
					<td><?php echo $value->shop_price_sqft == '' ? $value->price_sqft : $value->shop_price_sqft; ?></td>
					<td><?php echo $value->shop_price_sqft == '' ? $value->size_sqft * $value->price_sqft : $value->size_sqft * $value->shop_price_sqft; ?></td>
					<td><?php 
						if ($value->sold == 1) {
							echo '<span style="color:red; font-weight:bold;">Sold</span>';
						}
						elseif ($value->sold == 2)
						{
							echo '<span style="color:yellow; font-weight:bold;">Hold</span>';
						} else {
							echo '<span style="color:green; font-weight:bold;">Available</span>';
						}
					?></td>
					<td>
						<?php if ($value->sold != 1): ?>
						<a onclick="selectUnit(<?php echo $value->unit_id; ?>,<?= $value->project_id; ?>,<?php echo $value->floor_id; ?>,<?php echo $value->shop_price_sqft == '' ? $value->size_sqft * $value->price_sqft : $value->size_sqft * $value->shop_price_sqft; ?>,<?php echo $value->size_sqft; ?>,<?php echo $value->shop_price_sqft == '' ? $value->price_sqft : $value->shop_price_sqft; ?>)" class="btn btn-sm btn-info">Select</a>
						<?php else: ?>
						<a disabled class="btn btn-sm btn-info">Select</a>
						<?php endif ?>
					</td>
				</tr>
				<?php endforeach ?>
			<?php endif ?>
		</thead>
	</table>
</div>