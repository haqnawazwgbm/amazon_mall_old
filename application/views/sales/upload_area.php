<div class="col-md-12" id="AllDataForms">
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
				</div>