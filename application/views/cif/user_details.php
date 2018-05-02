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
		<input type="hidden" id="userid" value="<?php echo $this->uri->segment(3); ?>">
		<!-- END PAGE SIDEBAR -->
		<!-- PAGE CONTENT -->
		<div class="page-content">
			<!-- START X-NAVIGATION VERTICAL -->
			<?php $this->load->view('./incs/header_topbar.php') ?>
			<!-- END X-NAVIGATION VERTICAL -->                     
			<div class="page-content-wrap">
				<ul class="breadcrumb">
					<li><a href="<?php echo base_url('Master/dashboard');?>">Home</a></li>
					<li class="active"><a href="<?php echo base_url('Cif') ?>">CIF</a></li>
				</ul>
				<br><br>
				<!--  style="display: none;" -->
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">                                
							<h3 class="panel-title">Units Purchased</h3>
						</div>
						<div class="panel-body" id="unit-details">
							<table id="example" class="display" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>S.no</th>
										<th>Project Name</th>
										<th>Project Location</th>
										<th>Sale Unit</th>
										<th>Floor </th>
										<th>Size/Sqft</th>
										<th>Total Price</th>
										<th>Date</th>
										<th>Action</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>                
			</div>
		</div>
	</div>
	<!-- END PRELOADS -->  
	<!-- Performing Edit/ View -->
	<?php $this->load->view('./incs/jquery-footer') ?>  
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>   
	<script>
		<?php $id = $this->uri->segment(3); ?>
		loadDataintoTable();
		function loadDataintoTable()
		{
			$('#example').DataTable({
				"order": [[ 7, "desc" ]],
				"ajax": "<?php echo base_url('Cif/userPurchases/'.$id) ?>",
				"columns": [
				{ "data": "9" },
				{ "data": "1" },
				{ "data": "5" },
				{ "data": "7" },
				{ "data": "2" },
				{ "data": "3" },
				{ "data": "4" },
				{ "data": "6" },
				{ "data": "8" }
				]
			});
		}

		function resetTable()
		{
			$("#example").dataTable().fnDestroy();
			loadDataintoTable();
		}
	</script>
</body>
</html>






