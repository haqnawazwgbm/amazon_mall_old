<?php $this->load->view('./incs/header.php') ?> 
<!-- overriding styles -->
<style type="text/css">
.dropzone a.dz-remove, .dropzone-previews a.dz-remove{
	display: none !important;
}
.file-type{
	padding: 1em 2em;
	float: left;
	background: #E91E63;
	margin-right: 12px;
}
.file-type h3{
	float: left;
}
</style>
<!-- end of style -->
<body>
	<!-- START PAGE CONTAINER -->
	<div class="page-container">

		<!-- START PAGE SIDEBAR -->
		<div class="page-sidebar">
			<!-- START X-NAVIGATION -->
			<?php $this->load->view('./incs/side-bar') ?>
			<!-- END X-NAVIGATION -->
		</div>
		<!-- END PAGE SIDEBAR -->
		<!-- PAGE CONTENT -->
		<div class="page-content">
			<!-- START X-NAVIGATION VERTICAL -->
			<?php $this->load->view('./incs/header_topbar.php') ?>
			<!-- END X-NAVIGATION VERTICAL -->                     

			<!-- PAGE CONTENT WRAPPER -->
			<div class="page-content-wrap">
				<ul class="breadcrumb">
					<li><a href="<?php echo base_url('Master/dashboard');?>">Home</a></li>
					<li class="active"><a href="<?php echo base_url('Customers');?>">Customers</a></li>
					<li class="active"><a href="<?php echo base_url('Customers');?>">Units Purchased</a></li>
				</ul>
				<br><br>
				<!--  style="display: none;" -->
				<div class="col-md-12">
					<div class="panel panel-default" id="usersTable">
						<div class="panel-heading">                                
							<h3 class="panel-title">Purchase Details</h3>
						</div>
						<div class="panel-body">
							<style>
							h3,h4{
								background: #f1f1f1;
								line-height: 40px;
								padding-left: 10px;
							}
							th{
								background: #f9f9f9;
								padding-left: 10px !important;
							}
							td{
								padding-left: 10px !important;
							}
						</style>
						<?php  
						$purchases = $this->Admin->DJoin(
							'A.*,B.*,C.*,D.*,B.size_sqft as size',
							'sale as A',
							'sales_units as B',
							array(
								'basic_floors as C' => 'C.floor_id = A.floor_id',
								'project as D' => 'D.project_id = C.project_id', 
							),
							'A.unit_id = B.unit_id',
							array(
								'A.sale_id' => $this->uri->segment(3), 
							)
						);
						if (!empty($purchases)):
							foreach ($purchases as $single):?>


							<div class="col-md-12 unit-purchased">
								<br>
								<?php
								$owners = $single->owners;
								if (!empty($owners)):
									echo '<h3>Other Owners</h3>';
									$explode = explode('-', $owners);
									foreach ($explode as $getO): 
										$GetUser = $getUser = $this->Admin->DJoin(
											'*',
											'users',
											'countries',
											array(
												'provinces' => 'provinces.province_id = users.province',
												'districts' => 'districts.id = users.district'
											),
											'users.country = countries.id',
											array('users.user_id' => $getO)
										);
										?>
										<table class="table">
											<tr>
												<th>Client Name</th>
												<td><?php echo $GetUser[0]->title.' '.$GetUser[0]->fullname; ?></td>
												<th>Email</th>
												<td><?php echo $GetUser[0]->email_id; ?></td>
												<th>Phone</th>
												<td><?php echo $GetUser[0]->phone_login; ?></td>
											</tr>
											<tr>
												<th>Phone (Optional)</th>
												<td><?php echo $GetUser[0]->phone; ?></td>
												<th>Nationality</th>
												<td><?php echo $GetUser[0]->country_name; ?></td>
												<th></th>
												<td></td>
											</tr>
											<tr>
												<th>Address</th>
												<td colspan="5"><?php echo $GetUser[0]->address.','.$GetUser[0]->city.' '.$GetUser[0]->district_name.'  '.$GetUser[0]->province_name.','.$GetUser[0]->country_name; ?></td>
											</tr>
										</table>
									<?php endforeach;
								endif;
								?>
								<br>
								<h3>Units Purchased</h3>  
								<table class="table">
									<tr>
										<th>Project</th>
										<td><?php echo $single->project_name; ?></td>
										<th>Project Location</th>
										<td><?php echo $single->project_location; ?></td>
										<th>Floor</th>
										<td><?php echo $single->floor_types; ?></td>
									</tr>
									<tr>
										<th>Sale Unit</th>
										<td><?php echo $single->unit_type; ?></td>
										<th>Unit Area</th>
										<td><?php echo $single->size; ?></td>
										<th>Price/sqft</th>
										<td><?php echo 'Rs.'.$single->pricesqft; ?></td>
									</tr>
									<tr>
										<th>Discount</th>
										<td><?php 
										echo 'Rs.'.$single->discount;
										?></td>
										<th>Price Per Square Feet After Discount</th>
										<td><?php 
										$discounted = $single->pricesqft-$single->discount; 
										echo 'Rs.'.$discounted; 
										?></td>
									</tr>
								</table>
								<br>
								<h3>Payment Information</h3>
								<table class="table">
									<tr>
										<th>Unit Total Price</th>
										<td><?php echo 'Rs.'.$single->pricesqft * $single->size; ?></td>
										<th>Token Money</th>
										<td><?php echo 'Rs.'.$single->token_money; ?></td>
										<th>Down Payment</th>
										<td><?php echo 'Rs.'.$single->down_payment; ?></td>
									</tr>
									<tr>
										<th>Unit Price After Discount</th>
										<td><?php 
										$totalPriceDiscount = $single->size*$discounted;
										echo '<b>Rs.'.$totalPriceDiscount.'</b>';
										?></td>
									</tr>
								</table>
								<h4>Payments Paid</h4>
								<table class="table">
									<tr>
										<th>Token Money</th>
										<td><?php  
										if ($single->recieved_token != "0") {
											echo 'Rs.'.$single->token_money;
										}
										else
										{
											echo "Not Paid";
										}
										?></td>
										<th>Down Payment</th>
										<td><?php  
										if ($single->recieved_downpayment != "0") {
											echo 'Rs.'.$single->down_payment;
										}
										else
										{
											echo "Not Paid";
										}
										?></td>
									</tr>
									<tr>
										<td></td>
										<td>
											<?php  
											$method = $this->Admin->getAllData('payment_methods','',array('column_id' => $single->sale_id,'pay_for' => 'Token'));
											foreach ($method as $one) {
												if ($one->method == "Bank") {
													echo "Method: ".$one->method.'<br>';
													echo "Bank: ".$one->bank.'<br>';
													echo "Branch: ".$one->branch.'<br>';
													echo "Cheque#: ".$one->cheque.'<br>';
												}
												else
												{
													echo "Method: ".$one->method.'<br>';
												}
											}
											?>
										</td>
										<td></td>
										<td>

											<?php  
											$method = $this->Admin->getAllData('payment_methods','',array('column_id' => $single->sale_id,'pay_for' => 'DownPayment'));
											foreach ($method as $one) {
												if ($one->method == "Bank") {
													echo "Method: ".$one->method.'<br>';
													echo "Bank: ".$one->bank.'<br>';
													echo "Branch: ".$one->branch.'<br>';
													echo "Cheque#: ".$one->cheque.'<br>';
												}
												else
												{
													echo "Method: ".$one->method.'<br>';
												}
											}
											?>
										</td>
									</tr>
								</table>
								<h4>Installments</h4>
								<?php 
								$totalInstallments = '';
								$installments = $this->Admin->DJoin(
									'A.*,B.method',
									'installments as A',
									'payment_methods as B',
									'',
									'A.installment_id = B.column_id',
									array(
										'A.sale_id' => $single->sale_id, 
									),
									'updated_at ASC'
								);
								if (!empty($installments)) {
									$totalInstallments = $installments;
								}
								else
								{
									$totalInstallments = $this->Admin->getAllData('installments','',array('sale_id' => $single->sale_id),'created_at DESC'); 
								}
								?>
								<table class="table">
									<tr>
										<th>S.No</th>
										<th>Amount</th>
										<th>Remaining</th>
										<th>Paid</th>
										<th>Payment Method</th>
										<th>Staus</th>
										<th>Recieved Date</th>
									</tr>
									<?php 
									$PaidAmount   = [];
									$i = 1; foreach ($totalInstallments as $each): ?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo 'Rs.'.$each->amount; ?></td>
										<td><?php 
										if ($each->paid > $each->amount) {
											echo 'Rs.'.$each->remaining.' Extra Paid';
										}
										else if($each->paid < $each->amount)
										{
											echo 'Rs.'.$each->remaining.' Less Paid';
										}
										else if($each->amount == $each->paid)
										{
											echo 'Rs.'.$each->remaining;
										}
										?></td>
										<td><?php echo 'Rs.'.$each->paid; $PaidAmount[] = $each->paid;?></td>
										<td><?php if (!empty($each->method)) { echo $each->method;} ?></td>
										<td>
											<?php 
											if ($each->status == '1') {
												echo "Recieved";
											} 
											else
											{
												echo "Not Recieved";
											}
											?></td>
											<td><?php 
											$date = date("d M Y H:i:s",strtotime($each->updated_at)); 
											if ($date == "30 Nov -0001 00:00:00") {
												echo "";
											}
											else
											{
												echo $date;
											}
											?></td>
										</tr>
										<?php $i++; endforeach ?>
										<tr>
											<th>Total Amount</th>
											<td><?php  
											if (empty($single->discount)) {
												echo 'Rs.'.$single->total_price;
											}
											else
											{
												echo 'Rs.'.$totalPriceDiscount;
											}
											?></td>

											<th>Paid Amount</th>
											<td><?php 
											$paid =  array_sum($PaidAmount); 
											if ($single->recieved_token != '0') {
												$token = $single->token_money;
											}
											else
											{
												$token = 0;
											}
											if ($single->recieved_downpayment != '0') {
												$down = $single->down_payment;
											}
											else
											{
												$down = 0;
											}
											$totalPaid = $paid+$token+$down;
											echo 'Rs.'.$totalPaid;
											?></td>
											<th>Remaining Amount</th>	
											<td><?php 
											if (!empty($single->discount)) {
												$sum = $totalPriceDiscount - $totalPaid;
												echo 'Rs.'.$sum;
											}
											else
											{
												$remain = $single->total_price - $totalPaid; 
												echo 'Rs.'.$remain;
											}
											?></td>
										</tr>
									</table>
									<style>
									.file{ margin-bottom: 10px; }
									.file p{
										line-height: 26px;
										background: #f9f9f9;
										text-align: left;
										font-weight: bold;
										margin: 0;
										color: #000;
									}
									.btn-group{
										top: 0;
										position: absolute;
										right: 0;
									}
								</style>
								<h3>Client Documents</h3>
								<div class="col-md-12">
									<div class="col-md-4">
										<b style="color:green; margin-bottom: 10px; border-bottom:1px solid #000;">Camera</b>
										<?php 
										$document = $this->Admin->getAllData('sale_documents','',array('sale_id' => $single->sale_id,'document' => 'Camera')); 
										foreach ($document as $one):
											?>
											<div class="col-md-12 file" style="padding: 0;">
												<p><?php echo substr($one->file,0,20); ?></p>
												<div class="btn-group">
													<a href="<?php echo $one->url.'/'.$one->file; ?>" download class="btn btn-success btn-sm"> <i class="fa fa-download"></i></a>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
									<div class="col-md-4">
										<b style="color:green; margin-bottom: 10px; border-bottom:1px solid #000;">Documents</b>
										<?php 
										$document = $this->Admin->getAllData('sale_documents','',array('sale_id' => $single->sale_id,'document' => 'Document')); 
										foreach ($document as $one):
											?>
											<div class="col-md-12 file" style="padding: 0;">
												<p><?php echo substr($one->orignal,0,20); ?></p>
												<div class="btn-group">
													<a href="<?php echo $one->url.'/'.$one->file; ?>" download class="btn btn-success btn-sm"> <i class="fa fa-download"></i></a>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
									<div class="col-md-4">
										<b style="color:green; margin-bottom: 10px; border-bottom:1px solid #000;">Biometrics</b>
										<?php 
										$document = $this->Admin->getAllData('sale_documents','',array('sale_id' => $single->sale_id,'document' => 'Biometric')); 
										foreach ($document as $one):
											?>
											<div class="col-md-12 file" style="padding: 0;">
												<p><?php echo substr($one->orignal,0,20); ?></p>
												<div class="btn-group">
													<a href="<?php echo $one->url.'/'.$one->file; ?>" download class="btn btn-success btn-sm"> <i class="fa fa-download"></i></a>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
									<div class="col-md-4">
										<b style="color:green; margin-bottom: 10px; border-bottom:1px solid #000;">CNIC</b>
										<?php 
										$document = $this->Admin->getAllData('sale_documents','',array('sale_id' => $single->sale_id,'document' => 'CNIC')); 
										foreach ($document as $one):
											?>
											<div class="col-md-12 file" style="padding: 0;">
												<p><?php echo substr($one->orignal,0,20); ?></p>
												<div class="btn-group">
													<a href="<?php echo $one->url.'/'.$one->file; ?>" download class="btn btn-success btn-sm"> <i class="fa fa-download"></i></a>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
						<?php endforeach; endif; ?>


					</div>
				</div>
			</div>      

		</div>
	</div>
</div>
<!-- END PRELOADS -->  
<!-- Performing Edit/ View -->
<?php $this->load->view('./incs/jquery-footer') ?>  
</body>
</html>






