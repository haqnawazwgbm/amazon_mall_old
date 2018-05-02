<style>
.col-md-12.unit-purchased {
	background: #f9f9f947;
	border: dotted 1px #ccc;
}
h4{

	font-size: 12px !important;
	background: #f1f1f1;
	line-height: 24px;
	padding-left: 10px;
}
th{
	padding-left: 10px !important;
	font-size: 8px !important; 
	line-height: 18px !important;
	text-align: left !important;
}
td{
	padding-left: 10px !important;
	font-size: 8px !important; 
	line-height: 18px !important;
	text-align: left !important;
}
h3{
	font-size: 13px !important;
	background: #f1f1f1;
	line-height: 24px;
	padding-left: 10px;
}
*{
	font-family:Segoe UI;
}
</style>
<?php $this->load->view('reports/header') ?>
<?php 
foreach ($project as $one):
echo '<br><br><h3 style="padding-left:0.7em; line-height:36px; background:#f1f1f1;">'.$one->project_name.'</h3>';
$purchases = $this->Admin->DJoin(
	'A.*,B.*,C.*,D.*,B.size_sqft as square',
	'sale as A',
	'sales_units as B',
	array(
		'basic_floors as C' => 'C.floor_id = A.floor_id',
		'project as D' => 'D.project_id = C.project_id', 
	),
	'A.unit_id = B.unit_id',
	array(
		'C.project_id' => $one->project_id
	)
);
echo '<div class="col-md-12 unit-purchased">';?>
<table class="table" style="width: 100% !important;">
			<tr>
				<th style="width:80px !important;">Floor</th>
				<th>Sale Unit</th>
				<th>Square Feet</th>
				<th>Price/sqft</th>
				<th>Discount</th>
				<th>Price/sqft</th>
				<th>Total Price</th>
				<th>Discount</th>
				<th>Token</th>
				<th>Down Payment</th>
			</tr>
<?php			
if (!empty($purchases)):
	foreach ($purchases as $single):?>

		
			<tr>
				<td><?php echo $single->floor_types; ?></td>
				<td><?php echo $single->unit_type; ?></td>
				<td><?php echo $single->square; ?></td>
				<td><?php echo 'Rs.'.$single->price_sqft; ?></td>
				<td><?php echo 'Rs.'.$single->discount;?></td>
				<td><?php  $discounted = $single->price_sqft-$single->discount; echo 'Rs.'.$discounted; ?></td>
				<td><?php echo 'Rs.'.$single->total_price; ?></td>
				<td><?php $totalPriceDiscount = $single->square*$discounted; echo 'Rs.'.$totalPriceDiscount; ?></td>
				<td><?php 
					if ($single->recieved_tokenmoney != 0 ) {
						echo 'Rs.'.$single->token_money; 
					}
					else
					{
						echo 0;
					}
				?></td>
				<td><?php 
					if ($single->recieved_downpayment != 0 ) {
						echo 'Rs.'.$single->down_payment; 
					}
					else
					{
						echo 0;
					}
				?></td>
			</tr>
		
<?php endforeach; endif; ?>
</table>
</div>
<?php endforeach; ?>
<?php $this->load->view('reports/footer') ?>