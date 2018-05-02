<style>
	table{
		width: 100% !important;
	}
	th{
		font-size: 15px !important;
		font-weight: bold;
	}
	td{
		font-size: 15px !important;
	}
</style>
<table class="table table-condensed">
	<tr style="background: #f1f1f1;">
		<th style="font-size: 13px !important; text-align:left; font-family: sans-serif;">Project</th>
		<th style="font-size: 13px !important; text-align:left; font-family: sans-serif;">Location</th>
		<th style="font-size: 13px !important; text-align:left; font-family: sans-serif;">Floor</th>
		<th style="font-size: 13px !important; text-align:left; font-family: sans-serif;">Sale Unit</th>
		<th style="font-size: 13px !important; text-align:left; font-family: sans-serif;">Area / Sqft</th>
		<th style="font-size: 13px !important; text-align:left; font-family: sans-serif;">Total Price</th>
		<th style="font-size: 13px !important; text-align:left; font-family: sans-serif;">Sale Date</th>
	</tr>
	<?php if (!empty($Report)): ?>
		<?php foreach ($Report as $simple): ?>
		<tr>
			<td style="font-size: 11px !important; padding:10px 0px !important; font-family: sans-serif;"><?php echo $simple->project_name; ?></td>
			<td style="font-size: 11px !important; padding:10px 0px !important; font-family: sans-serif;"><?php echo $simple->project_location; ?></td>
			<td style="font-size: 11px !important; padding:10px 0px !important; font-family: sans-serif;"><?php echo $simple->floor_types; ?></td>
			<td style="font-size: 11px !important; padding:10px 0px !important; font-family: sans-serif;"><?php echo $simple->unit_type; ?></td>
			<td style="font-size: 11px !important; padding:10px 0px !important; font-family: sans-serif;"><?php echo $simple->size_sqft; ?> square feets</td>
			<td class="text-success" style="font-weight: bold;font-size: 11px !important; padding:10px 0px !important; font-family: sans-serif;">Rs.<?php echo $simple->total_price; ?></td>
			<td style="font-size: 11px !important; padding:10px 0px !important; font-family: sans-serif;"><?php echo date("d F Y",strtotime($simple->sale_date)); ?></td>
		</tr>
		<?php endforeach ?>
	<?php else: ?>
		<tr>
			<td colspan="7"> No Results Found</td>
		</tr>
	<?php endif ?>
</table>