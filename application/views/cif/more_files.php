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
				<!--  style="display: none;" -->
				<div class="col-md-12">
					<div id="FinalUploadArea">
						<div class="col-md-12 general-white">
							<br><br>
							<div class="col-md-4">
								<h3>Documents</h3>
								<div class="panel panel-default">
									<div class="panel-body">
										<form action="<?php echo base_url('Cif/uploadSaleFiles/documents') ?>" class="dropzone dropzone-mini">
											<input type="hidden" id="sold_id" value="<?php echo $this->uri->segment(3); ?>" name="sold_id">
										</form>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<h3>Biometric</h3>
								<div class="panel panel-default">
									<div class="panel-body">
										<form action="<?php echo base_url('Cif/uploadSaleFiles/Biometric') ?>" class="dropzone dropzone-mini">
											<input type="hidden" id="sold_id" value="<?php echo $this->uri->segment(3); ?>" name="sold_id">
										</form>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<h3>NIC Photo copy</h3>
								<div class="panel panel-default">
									<div class="panel-body">
										<form action="<?php echo base_url('Cif/uploadSaleFiles/cnic') ?>" class="dropzone dropzone-mini">
											<input type="hidden" id="sold_id" value="<?php echo $this->uri->segment(3); ?>" name="sold_id">
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
						</div>
					</div>
				</div>                
			</div>
		</div>
	</div>
	<!-- END PRELOADS -->  
	<!-- Performing Edit/ View -->
	<?php $this->load->view('./incs/jquery-footer') ?>  
	<script>
		$('#showVideo').click(function(){
			$('#video,#snap').toggle();
		});

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
			sale_id = <?php echo $this->uri->segment(3); ?>;
			Update = $('#reassignid').val();
			console.log(sale_id,Update);
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






