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
					<li class="active">CIF</li>
				</ul>
				<br><br>
				<div id="AllButtons">
					<button class="btn btn-primary" style="margin-left:1.3em;" id="ShowCifForm"> New Customer</button>
					<button class="btn btn-danger" id="SearchDisplay">Unit Search</button>
				</div>
				<!--  " -->
				<div class="col-md-12" id="editCustomers">
					
				</div>
				<div class="col-md-12" id="AllDataForms">
					<!-- Customer Editing -->
					

					<!-- Customer Editing Done -->
					<div id="discount" style="display: none;">
						<div class="panel panel-default">
							<div class="panel-heading">       
								<h3 class="panel-title">Discount Section</h3>
								<button onclick="BackToStructure()" class="btn btn-success pull-right">Back To Search Unit</button>
							</div>
							<div class="panel-body">
								<div class="col-md-12">
									<div class="col-md-4" style="margin-left: 1.2em !important;">
										<label id="discount_square_feet"></label><br>
										<label>Price Per Square Feet: <span id="PricePerSquareFeet"></span></label><br>
										<label>Total Cost: <span id="totalPriceofTheUnit"></span> </label><br><br>
									</div>
									<div class="clearfix"></div>
									<div class="col-md-4">
										<div class="form-group">                                        
											<label class="col-md-12 col-xs-12 control-label">Discount</label>
											<div class="col-md-12 col-xs-12">
												<input type="text" name="discountpersqft" id="discountpersqft" tabindex="2" class="form-control"  placeholder="Discount" />
											</div>
										</div>
									</div>
									<div class="clearfix"></div>
									<br>
									<div class="col-md-4">
										<div class="form-group" style="margin-left: 1.2em;">                                        
											<button onclick="AddDiscount()" class="btn btn-success">Add Discount</button>
											<button onclick="GoToCalculaterSection()" class="btn btn-success">Continue</button>
										</div>
									</div>		
								</div>
							</div>
						</div>
					</div>

					<div id="calculater" style="display: none;">
						<!-- For Selecte unit -->
						<input type="hidden" id="selectedValue" value="" name="selectedValue">
						<input type="hidden" id="price" value="" name="price">
						<input type="hidden" id="size" value="" name="size">
						<input type="hidden" id="discountinput" value="" name="discountinput">
						<input type="hidden" id="clientid" value="" name="clientid">
						<input type="hidden" id="TotalPrice" value="" name="TotalPrice">
						<input type="hidden" id="unit_get_id" value="" name="unit_get_id">
						<input type="hidden" id="project_get_id" value="" name="project_get_id">
						<input type="hidden" id="floor_get_id" value="" name="floor_get_id">
						<input type="hidden" id="token_get_money" value="" name="token_get_money">
						<input type="hidden" id="downpayment_get_money" value="" name="downpayment_get_money">
						<input type="hidden" id="years_get" value="" name="years_get">
						<input type="hidden" id="sold_id" value="" name="sold_id">
						<input type="hidden" id="square_feet" value="" name="square_feet">
						<!-- Selected Form -->
						<br>
						<div class="panel panel-default">
							<div class="panel-heading">       
								<h3 class="panel-title">Installment Calculater</h3>
								<button onclick="backToDiscount()" class="btn btn-success pull-right">Back To Discount Section</button>
							</div>
							<div class="panel-body">
								<div class="col-md-12">
									<div class="col-md-3">
										<div class="form-group">                                        
											<label class="col-md-12 col-xs-12 control-label">Token Money</label>
											<div class="col-md-12 col-xs-12">
												<input type="text"  id="tokenmoney" placeholder="Token Money" tabindex="1" name="tokenmoney" class="form-control">
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">                                        
											<label class="col-md-12 col-xs-12 control-label">Down Payment</label>
											<div class="col-md-12 col-xs-12">
												<input type="text" name="downpayment" id="downpayment" tabindex="2" class="form-control"  placeholder="Down Payment" />
											</div>
										</div>	
									</div>
									<div class="col-md-3">
										<div class="form-group">                                        
											<label class="col-md-12 col-xs-12 control-label">Total Installments</label>
											<div class="col-md-12 col-xs-12">
												<input type="text" name="totalyears" id="totalyears" tabindex="2" class="form-control"  placeholder="Total Installments" />
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">                                        
											<button class="btn btn-primary" onclick="getInstallments()" style="margin-top: 1.7em;">Get Installments</button>
										</div>
									</div>		
								</div>
								<!-- For Getting Installments -->

								<div class="col-md-12" id="installments" style="padding: 1em;"></div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div id="FinalUploadArea" style="display: none;">
						<div class="col-md-12 general-white">
							<div class="col-md-4">
								<h3>Biometric</h3>
								<div class="panel panel-default">
									<div class="panel-body">
										<form action="<?php echo base_url('Cif/uploadSaleFiles/Biometric') ?>" class="dropzone dropzone-mini">
											<input type="hidden" id="sold_id" value="" name="sold_id">
										</form>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<h3>NIC Photo copy</h3>
								<div class="panel panel-default">
									<div class="panel-body">
										<form action="<?php echo base_url('Cif/uploadSaleFiles/cnic') ?>" class="dropzone dropzone-mini">
											<input type="hidden" id="sold_id" value="" name="sold_id">
										</form>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<h3>Douments</h3>
								<div class="panel panel-default">
									<div class="panel-body">
										<form action="<?php echo base_url('Cif/uploadSaleFiles/documents') ?>" class="dropzone dropzone-mini">
											<input type="hidden" id="sold_id" value="" name="sold_id">
										</form>
									</div>
								</div>
							</div>

							<div class="col-md-4">
								<button class="btn btn-lg btn-primary" id="showVideo">Capture Image</button>
								<video id="video" width="100%" autoplay style="display: none;"></video>
								<canvas id="canvas" width="640" style="display: none;" height="480"></canvas>
								<div id="ImageConverted"></div>
								<div class="clearfix"></div>
								<button id="snap" style="display: none;" class="btn btn-danger"> <i class="fa fa-camera"> </i> Snap Photo</button>
							</div>
							<div class="col-md-12">
								<br><br>
								<button class="btn btn-primary" onclick="location.reload()">Complete Process</button>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div id="getuser" style="display: none;">
						<div class="panel panel-default">
							<div class="panel-heading">                                
								<h3 class="panel-title">Customers</h3>
							</div>
							<div class="panel-body">
								<div class="col-md-4">
									<select class="form-control select" data-live-search="true" tabindex="1" id="getCustomers">
										<option>Select Customer</option>
										<?php foreach($users as $user) : ?>
											<option value="<?= $user['email_id']; ?>"><?= $user['email_id']; ?></option>
										<?php endforeach; ?>
									</select>
<!-- 									<input type="text" class="form-control" id="getCustomers" placeholder="Enter email or Phone or name">
 -->								</div>
								<div class="col-md-4">
									<button class="btn btn-danger" onclick="getUsers()">Get Client</button>
								</div>
								<div id="getUserslist"></div>
							</div>
						</div>
					</div>

					<div id="SearchUnitDisplay" style="margin-top: 1em; display: none;" >
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="col-md-12">
									<h3>Search Unit</h3>
									<form action="">
										<div class="col-md-4">
											<label class="control-label">Project</label>
											<select class="form-control select" data-live-search="true" onchange="getsearchFloors($(this).val())" tabindex="1" id="project_type">
												<option>Select Project</option>
												<?php if (!empty($project)): ?>
													<?php foreach ($project as $pro): ?>
														<option value="<?php echo $pro->project_id;?>"><?php echo $pro->project_name; ?></option>
													<?php endforeach ?>
												<?php endif ?>	
											</select>
										</div>

										<div id="getSearchfloors"></div>
										<div id="getSearchUnits"></div>
										<div class="clearfix"></div>
										<br>
										<!-- Search Result -->
										<div id="searchResult"></div>
										<!-- Search Result End -->
									</form>
								</div>
							</div>
						</div>
					</div>
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
													<input type="text" name="fullname" tabindex="2" class="form-control"  placeholder="John Doe" />
												</div>
											</div>	
										</div>
										<div class="col-md-12">
											<div class="form-group">                                        
												<label class="col-md-12 col-xs-12 control-label"><br>Address</label>
												<div class="col-md-12 col-xs-12">
													<textarea name="address" id="" tabindex="3" cols="30" rows="7" class="form-control" placeholder="Please Address Here" ></textarea>
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
													<input type="text" tabindex="8" name="phone_login" placeholder="03438992212" class="form-control" />
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
													<input type="text" tabindex="10" name="email_id" placeholder="johndoe@gmail.com" class="form-control" />
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">                                        
												<label class="col-md-12 col-xs-12 control-label"><br>CNIC</label>
												<div class="col-md-12 col-xs-12">
													<input type="text" name="cnic" placeholder="11111-1111111-1" class="form-control" />
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">                                        
												<label class="col-md-12 col-xs-12 control-label"><br>Date Of Birth</label>
												<div class="col-md-12 col-xs-12">
													<input type="text" name="date_of_birth" placeholder="Date of birth" class="form-control datepicker" />
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
										
										<div class="col-md-6">
											<div class="form-group">                                        
												<label class="col-md-12 col-xs-12 control-label"><br>Relation/Next Of Kin</label>
												<div class="col-md-12 col-xs-12">
													<select name="relationship" id="" class="form-control">
														<option>Select Relationship</option>
														<option value="Friends">Friends</option>
														
														<option value="Busniess Partner">Busniess Partner</option>
														<option value="Wife">Wife</option>
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
												<label class="col-md-12 col-xs-12 control-label"><br>Relation Name/Next Of Kin</label>
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
													<input type="text" tabindex="17" name="city" class="form-control" />
												</div>
											</div>
										</div>
										<div class="clearfix"></div>
										<br><br>
										<div class="col-md-6 col-md-offset-6">
											<button type="submit" class="btn btn-info " tabindex="18" > Save Information </button>
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
							<h3 class="panel-title">Customers</h3>
						</div>
						<div class="panel-body">
							<table id="example" class="display" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Full Name</th>
										<th>Phone</th>
										<th>Email</th>
										<th>Country </th>
										<th>Provine</th>
										<th>District</th>
										<th>City</th>
										<th>Purchases</th>
										<th>Action</th>
									</tr>
								</thead>
							</table>

							<div class="clearfix"></div>
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
		function editCustomer(id)
		{
			$('#AllButtons').hide();
			$('#AllDataForms').hide();
			$('#editCustomers').show();
			$.post('<?php echo base_url('Cif/editCustomer') ?>', {id:id}, function(data, textStatus, xhr) {
				/*optional stuff to do after success */
				$('#editCustomers').html(data);
				$('.datepicker').datepicker({ format: 'yyyy-mm-dd' });
			});
		}

		

		// Updating Customer Details End Here

		$('#showVideo').click(function(){
			$('#video,#snap').toggle();
		});
		function getUsers() {
			inputValue = $('#getCustomers').val();
			$.ajax({
				url: '<?php echo base_url("Cif/getUserslist") ?>',
				type: 'POST',
				data: {geto:inputValue},
			})
			.done(function(response) {
				$('#getUserslist').html(response);
			});
		}
	// Selecting Structure
	function SelectStructure() 
	{
		if (confirm('Are You Sure To Select Structure?')) 
		{
			clientid = $('#clientid').val();
			if (clientid.length === 0) 
			{
				// get client
				$('#cifForm').hide();
				$('#getuser,#calculater,#usersTable').toggle();
			}
			else
			{
				$('#FinalUploadArea').show();
				$('#calculater').hide();
				$('#usersTable').hide();
				// Getting Data
				saveInstallments();
			}
		}
	}
	function saveInstallments()
	{
		installmentData = {
			totalPayment: $('#TotalPrice').val(),
			tokenmoney:   $('#tokenmoney').val(),
			downpayment:  $('#downpayment').val(),
			unitid:  	  $('#unit_get_id').val(),
			floorid:      $('#floor_get_id').val(),
			project_id:      $('#project_get_id').val(),
			clientid:     $('#clientid').val(),
			totalyears:   $('#totalyears').val(),
			discount:     $('#discountinput').val(),
			price: 		  $('#price').val(),
			size: 		  $('#size').val(),
			square_feet:  $('#square_feet').val()
		}
		$.ajax({
			url: '<?php echo base_url("Cif/saveUserInstallments");?>',
			type: 'POST',
			data: installmentData,
		})
		.done(function(res) {
			response = $.parseJSON(res);
			$('input[id="sold_id"]').each(function() {
				$(this).val(response.soldid);
			});

			noty({text: response.message, layout: 'topCenter', type: response.param});
		});
	}
	// Getting All Installments
	function getInstallments() {
		
		totalYears = $('#totalyears').val();
		tokenmoney = $('#tokenmoney').val();
		TotalPrice = $('#TotalPrice').val();
		discount   = $('#discountinput').val();
		price   	= $('#price').val();
		size   		= $('#size').val();
		downpayment = $('#downpayment').val();
		square_feet = $('#square_feet').val();
		$('#years_get').val(totalYears);
		$('#token_get_money').val(tokenmoney);
		$('#downpayment_get_money').val(downpayment);
		$('#TotalPrice').val(TotalPrice);
		installmentData = {
			totalPayment: TotalPrice,
			tokenmoney:   tokenmoney,
			downpayment:  downpayment,
			totalyears:   totalYears,
			discount: discount,
			price: price,
			size:size,
			square_feet: square_feet
		}
		$.ajax({
			url: '<?php echo base_url("Cif/Installments") ?>',
			type: 'POST',
			data: installmentData,
		})
		.done(function(response) {
			$('#installments').html(response);
		});
		$().attr('attribute', 'value');
	}
	// Show Customer Information Form
	$('#ShowCifForm').click(function() {
		$('#cifForm').toggle('fast');
	});
	// On Search Select 
	function selectUnit(id,project_id,floor,total,size,price) {
		$('#discount_square_feet').html('Size Per Square Feet: <span>' + size + '</span>');
		$('#unit_get_id').val(id);
		$('#totalPriceofTheUnit').html('Rs.'+total);
		$('#PricePerSquareFeet').html('Rs.'+price);
		$('#floor_get_id').val(floor);
		$('#project_get_id').val(project_id);
		$('#size').val(size);
		$('#price').val(price);
		$('#discount').show();
		$('#cifForm').hide();
		$('#SearchUnitDisplay').hide();
		$('#selectedValue').val(id);
		$('#TotalPrice').val(total);
	}


	function GoToCalculaterSection()
	{
		$('#calculater').toggle();
		$('#discount').toggle();
	}
	// calculater
	// calculater
	// Back to Seach Unit
	
	function backToDiscount()
	{
		$('#calculater').toggle();
		$('#discount').toggle();
	}

	function AddDiscount()
	{
		var discount = $('#discountpersqft').val();
		$('#discountinput').val(discount);
		$('#calculater').toggle();
		$('#discount').toggle();
	}

	function BackToStructure() {
		$('#discount').toggle();
		$('#cifForm').toggle();
		$('#SearchUnitDisplay').toggle();
	}

	function SaleUnit(id) {
		$('#clientid').val(id);
		$('#SearchUnitDisplay').toggle();	
	}
	// Search Unit Result
	function SearchUnits(floor) {
		project = $('#project_type').val();
		$.ajax({
			url: '<?php echo base_url("Cif/SearchUnit") ?>',
			type: 'POST',
			data: {floor:floor,project:project},
		})
		.done(function(response) {
			$('#searchResult').html(response);
		});
	}
	// Get Provines
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

	// Saving User To Database
	$(document).ready(function (e) {
		$("#SaveUSer").on('submit',(function(e) {
			e.preventDefault();
			$.ajax({
				url: "<?php echo base_url(); ?>Cif/saveUser",
				type: "POST",             
				data: new FormData(this), 
				contentType: false,       
				cache: false,             
				processData:false,        
				success: function(res)  
				{
					resetTable();
					$('#SaveUSer')[0].reset();
					response = $.parseJSON(res);
					$('#clientid').val(response.userid);
					noty({text: response.message, layout: 'topRight', type: response.param});
				}
			});
		}));
	});
	// Loading Data From Server Via Datatables Pipeline
	loadDataintoTable();
	function loadDataintoTable()
	{
		$('#example').DataTable({
			"order": [[ 3, "desc" ]],
			"ajax": "<?php echo base_url('Cif/getAllUsers') ?>",
			"columns": [
			{ "data": "1" },
			{ "data": "5" },
			{ "data": "7" },
			{ "data": "2" },
			{ "data": "3" },
			{ "data": "4" },
			{ "data": "6" },
			{ "data": "9" },
			{ "data": "8" }
			]
		});
	}

	function resetTable()
	{
		$("#example").dataTable().fnDestroy();
		loadDataintoTable();
	}

	function getFloors(id)
	{
		console.log(id);
		$.ajax({
			url: '<?php echo base_url("Units/getFloors")?>',
			type: 'POST',
			data: {id:id},
		})
		.done(function(res) {
			$('#floors').html(res);
		})
	}
	$('#SearchDisplay').click(function() {
		$('#SearchUnitDisplay').toggle();
	});

	function getsearchFloors(id)
	{
		$.post('<?php echo base_url('Cif/getsearchFloors') ?>', {id:id}, function(data, textStatus, xhr) {
			$('#getSearchfloors').html(data);
		});
	}
	function getsearchUnits(id)
	{
		$.post('<?php echo base_url('Cif/getsearchUnits') ?>', {id:id}, function(data, textStatus, xhr) {
			$('#getSearchUnits').html(data);
		});
	}

		// On Search Select 
	function selectSpace(floor_id, size, price) {
		var max_space = $('#free_space').attr('max');
		var space = $('#free_space').val();	
		var total = price*space;
		if (parseInt(space) > parseInt(max_space)) {
			alert('Input can not be increased on free space');
			return false;
		}
		if (parseInt(space) <= 0) {
			alert('Input can not be less or equal to zero');
			return false;
		}
		$('#discount_square_feet').html('Space To Be Sold: <span>' + space + '</span>');
		$('#unit_get_id').val(0);
		$('#totalPriceofTheUnit').html('Rs.'+total);
		$('#PricePerSquareFeet').html('Rs.'+price);
		$('#floor_get_id').val(floor_id);
		$('#size').val(size);
		$('#price').val(price);
		$('#discount').show();
		$('#cifForm').hide();
		$('#SearchUnitDisplay').hide();
		$('#selectedValue').val(0);
		$('#TotalPrice').val(total);
		$('#square_feet').val(space);
	}


</script>
<script type="text/javascript">
// Grab elements, create settings, etc.
var video = document.getElementById('video');
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var video = document.getElementById('video');

// Trigger photo take
document.getElementById("snap").addEventListener("click", function() {
	mengo = context.drawImage(video, 0, 0, 640, 480);
	image = canvas.toDataURL("image/png");
	appendFileAndSubmit(image);
});

function appendFileAndSubmit(image){
	data  = '';
	sale_id = $('#sold_id').val();
	Update = $('#reassignid').val();
	if ( Update == '' || Update == 'undefined') {
		data = { 
			baseencoded:image,
			sale:sale_id
		}
	}
	else
	{
		data = { 
			baseencoded:image,
			sale:sale_id,
			update:Update
		}
	}
	$.ajax({
		url: '<?php echo base_url('Cif/converCamerImageToFile'); ?>',
		type: 'POST',
		data: data,
	})
	.done(function(res) {
		$('#video').hide();
		$('#ImageConverted').html(res);
	});
}


function convertCanvasToImage(canvas) {
	var image = new Image();
	image.src = canvas.toDataURL("image/png");
	return image;
}

function delete_user(user_id, units) {
	if (units > 0) {
		alert('This user purchased units can not be deleted');
	} else if (confirm("Are you sure to delete this record")) {
			$.ajax({
                url: '<?php echo base_url("Cif/delete_user")?>',
                type: 'POST',
                data: {user_id:user_id},
            })
            .done(function(res) {
                $("#example").dataTable().fnDestroy();
                loadDataintoTable();
                noty({text: res.message, layout: 'topRight', type: res.param});
            })
	}
}
// Get access to the camera!
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    // Not adding `{ audio: true }` since we only want video now
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
    	video.src = window.URL.createObjectURL(stream);
    	video.play();
    });
}
else if(navigator.getUserMedia) { 
	navigator.getUserMedia({ video: true }, function(stream) {
		video.src = stream;
		video.play();
	}, errBack);
} else if(navigator.webkitGetUserMedia) { 
	navigator.webkitGetUserMedia({ video: true }, function(stream){
		video.src = window.webkitURL.createObjectURL(stream);
		video.play();
	}, errBack);
} else if(navigator.mozGetUserMedia) { 
	navigator.mozGetUserMedia({ video: true }, function(stream){
		video.src = window.URL.createObjectURL(stream);
		video.play();
	}, errBack);
}

</script>
</body>
</html>






