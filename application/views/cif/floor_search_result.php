<div class="col-md-12">
	<h4 style="background: #e2d555; padding:5px;">Search Result</h4>
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Total Space</th>
				<th>Sold Space</th>
				<th>Free Space</th>
				<th>Sale Space</th>
				<th>Price/sqft</th>
				<th>Total Price</th>
				<th>Action</th>
			</tr>
			<?php if (!empty($floor)): ?>
					<tr>
						<td><?php echo $floor['size_sqft']; ?></td>
						<td><?php echo $floor['size_sqft'] - $floor['free_space']; ?></td>
						<td><?php echo $floor['free_space']; ?></td>
						<td><input type="number" id="free_space" value="" max="<?php echo $floor['free_space']; ?>"></td>
						<td><?php echo $floor['price_sqft']; ?></td>
						<td><?php echo $floor['free_space'] * $floor['price_sqft']; ?></td>
				
						 <td>
							<?php if ($floor['size_sqft'] > 0): ?>
							<a type="submit" onclick="selectSpace(<?php echo $floor['floor_id']; ?>,<?php echo $floor['size_sqft']; ?>, <?= $floor['price_sqft']; ?>)" class="btn btn-sm btn-info">Next</a>
							<?php else: ?>
							<a disabled class="btn btn-sm btn-info">Next</a>
							<?php endif ?>
						</td> 
					</tr>
			<?php endif ?>
		</thead>
	</table>
</div>