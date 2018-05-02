<div class="col-md-10" style="margin-top: 1em; margin-left: 1.5em;">
	<button onclick="SelectStructure()" class="btn btn-primary">Select Structure</button>
	<br>
	<br>
	<table class="table table-striped">
		<tr>
			<th>S.no</th>
			<!-- <th>Month</th> -->
			<!-- <th>Year</th> -->
			<th>Amount</th>
		</tr>
		<?php if (!empty($installments)): ?>
			<?php 
				$i = 1 ;foreach ($installments as $eachone => $data): 
				$date = explode('|', $data['date']);
			?>
				<tr>
					<td><?php echo $i; ?></td>
					<!-- <td><?php //echo $date[0]; ?></td> -->
					<!-- <td><?php //echo $date[1]; ?></td> -->
					<td><?php echo 'Rs. '.$data['Installment']; ?></td>
				</tr>
			<?php $i++; endforeach ?>
		<?php endif ?>
	</table>
	<div class="clearfix"></div>
	<button onclick="SelectStructure()" class="btn btn-primary pull-right">Select Structure</button>
</div>