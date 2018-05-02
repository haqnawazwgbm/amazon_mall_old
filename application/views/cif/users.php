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
					<li class="active"><a href="<?php echo base_url('Cif');?>">CIF</a></li>
					<li class="active"><a href="<?php echo base_url('Cif/userDetails');?>/<?php echo $this->uri->segment(4) ?>">Units Purchased</a></li>
				</ul>
				<br><br>
				<button class="btn btn-primary" style="margin-left:1.3em;" id="ShowCifForm"> Add Owners</button>
				<!--  style="display: none;" -->
				<div class="col-md-12">

					<div id="cifForm"  style="display: none;">
						<div class="panel panel-default">
							<div class="panel-heading">                                
								<h3 class="panel-title">Customer Information Form</h3>
							</div>
							<div class="panel-body">
								<form id="SaveUSer">
									<div class="col-md-6">
										<div class="col-md-4">
											<div class="form-group">                                        
												<label class="col-md-12 col-xs-12 control-label">Applicant Title</label>
												<div class="col-md-12 col-xs-12">
													<select class="form-control" tabindex="1" name="title">
														<option value="Mr.">Mr</option>
														<option value="Ms.">Ms</option>
														<option value="Miss.">Miss</option>
														<option value="Mrs.">Mrs</option>
														<option value="Dr.">Dr</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-8">
											<div class="form-group">                                        
												<label class="col-md-12 col-xs-12 control-label">Applicant Name</label>
												<div class="col-md-12 col-xs-12">
													<input type="text" name="fullname" tabindex="2" class="form-control" required placeholder="John Doe" />
												</div>
											</div>	
										</div>
										<div class="col-md-12">
											<div class="form-group">                                        
												<label class="col-md-12 col-xs-12 control-label"><br>Address</label>
												<div class="col-md-12 col-xs-12">
													<textarea name="address" id="" tabindex="3" cols="30" rows="7" class="form-control" placeholder="Please Address Here" required></textarea>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">                                        
												<label class="col-md-12 col-xs-12 control-label"><br>Country</label>
												<div class="col-md-12 col-xs-12">
													<select name="country" id="" class="form-control" onchange="getProvince($(this).val())">
														<option> Select Country </option>
														<?php if (!empty($country)): ?>
															<?php foreach ($country as $list): ?>
																<option value="<?php echo $list->id;?>"><?php echo $list->country_name; ?></option>
															<?php endforeach ?>
														<?php endif ?>
													</select>
												</div>
											</div>
										</div>
										<div id="provinces"></div>	
									</div>
									<div class="col-md-6">
										
										<div class="col-md-6">
											<div class="form-group">                                        
												<label class="col-md-12 col-xs-12 control-label"><br>Phone (Account Login)</label>
												<div class="col-md-12 col-xs-12">
													<input type="text" tabindex="8" name="phone_login" placeholder="03438992212" class="form-control" required/>
												</div>
											</div>	
										</div>
										<div class="col-md-6">
											<div class="form-group">                                        
												<label class="col-md-12 col-xs-12 control-label"><br>Phone (Optional)</label>
												<div class="col-md-12 col-xs-12">
													<input type="text" tabindex="9" name="phone" placeholder="03438992212" class="form-control"/>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">                                        
												<label class="col-md-12 col-xs-12 control-label"><br>Email ID</label>
												<div class="col-md-12 col-xs-12">
													<input type="text" tabindex="10" name="email_id" placeholder="johndoe@gmail.com" class="form-control" required/>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">                                        
												<label class="col-md-12 col-xs-12 control-label"><br>Nationality</label>
												<div class="col-md-12 col-xs-12">
													<select name="nationality" id="" class="form-control">
														<option> Select Country </option>
														<?php if (!empty($country)): ?>
															<?php foreach ($country as $list): ?>
																<option value="<?php echo $list->country_name;?>"><?php echo $list->country_name; ?></option>
															<?php endforeach ?>
														<?php endif ?>
													</select>
												</div>
											</div>
										</div>
										<input type="hidden" name="saleid" value="<?php echo $this->uri->segment(3); ?>">
										
										<div class="col-md-6">
											<div class="form-group">                                        
												<label class="col-md-12 col-xs-12 control-label"><br>Relation</label>
												<div class="col-md-12 col-xs-12">
													<select name="relationship" id="" class="form-control">
														<option>Select Relationship</option>
														<option value="Brother">Brother</option>
														<option value="Sister">Sister</option>
														<option value="Father">Father</option>
														<option value="Son">Son</option>
														<option value="Husband">Husband</option>
														<option value="Daughter">Daughter</option>
														<option value="Mother">Mother</option>
														<option value="Cousin">Cousin</option>
														<option value="Nephew">Nephew</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">                                        
												<label class="col-md-12 col-xs-12 control-label"><br>Relation Name</label>
												<div class="col-md-12 col-xs-12">
													<input type="text" tabindex="13" name="relation_name" class="form-control"/>
												</div>
											</div>
										</div>
										<div id="districts"></div>
										<div class="col-md-6">
											<div class="form-group">                                        
												<label class="col-md-12 col-xs-12 control-label"><br>City</label>
												<div class="col-md-12 col-xs-12">
													<input type="text" tabindex="17" name="city" class="form-control" required/>
												</div>
											</div>
										</div>
										<div class="clearfix"></div>
										<br><br>
										<div class="col-md-6 col-md-offset-6">
											<button type="submit" class="btn btn-info " tabindex="18" > Save Owner </button>
											<button type="button" class="btn btn-default"> Cancel </button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="panel panel-default" id="usersTable">
						<div class="panel-heading">                                
							<h3 class="panel-title">Owners</h3>
						</div>
						<div class="panel-body">
							<div id="users"></div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>                
			</div>
		</div>
	</div>
	<!-- END PRELOADS -->  
	<!-- Performing Edit/ View -->
	<?php $this->load->view('./incs/jquery-footer') ?>  
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>   
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/bootstrap/bootstrap-select.js"></script>
	<script>
	// Saving User To Database
	$(document).ready(function (e) {
		$("#SaveUSer").on('submit',(function(e) {
			e.preventDefault();
			$.ajax({
				url: "<?php echo base_url(); ?>Cif/SaveOwners",
				type: "POST",             
				data: new FormData(this), 
				contentType: false,       
				cache: false,             
				processData:false,        
				success: function(res)  
				{
					getAllOwners();
					$('#SaveUSer')[0].reset();
					response = $.parseJSON(res);
					noty({text: response.message, layout: 'topRight', type: response.param});
				}
			});
		}));
	});

getAllOwners();
function getAllOwners()
{
	$.ajax({
		url: '<?php echo base_url("Cif/getAllOWners"); ?>',
		type: 'POST',
		data: {id:<?php echo $this->uri->segment(3); ?>},
	})
	.done(function(response) {
		$('#users').html(response);
	});
}
$('#ShowCifForm').click(function() {
	$('#cifForm').toggle();
});
function getProvince(id)
{
	$.ajax({
		url: '<?php echo base_url("Cif/getProvinces"); ?>',
		type: 'POST',
		data: {id:id},
	})
	.done(function(response) {
		$('#provinces').html(response);
	});
}
function getDistrict(id) 
{
	$.ajax({
		url: '<?php echo base_url("Cif/getDistrict"); ?>',
		type: 'POST',
		data: {id:id},
	})
	.done(function(response) {
		$('#districts').html(response);
	});
}
</script>
</body>
</html>






