<?php $agent = $this->Admin->getAllData('users','',array('user_id' => $id)); ?>
<?php $relation = $this->Admin->getAllData('relation','',array('user_id' => $id)); ?>
<?php $country = $this->Admin->getAllData('countries');?>
<?php $nation = $this->Admin->getAllData('countries');?>
<?php if (!empty($agent)): ?>
<div id="cifForm">
	<div class="panel panel-default">
		<div class="panel-heading">                                
			<h3 class="panel-title">Update Customer Information</h3>
		</div>
		<div class="panel-body">
			<form id="UpdateCustomer">
				<div class="col-md-6">
					<div class="col-md-4">
						<div class="form-group">                                        
							<label class="col-md-12 col-xs-12 control-label">Applicant Title</label>
							<div class="col-md-12 col-xs-12">
								<select class="form-control" tabindex="1" name="title">
									<option value="Mr." <?php if($agent[0]->title == "Mr.") { echo "selected"; } ?>>Mr</option>
									<option value="Ms." <?php if($agent[0]->title == "Ms.") { echo "selected"; } ?>>Ms</option>
									<option value="Miss." <?php if($agent[0]->title == "Miss.") { echo "selected"; } ?>>Miss</option>
									<option value="Mrs." <?php if($agent[0]->title == "Mrs.") { echo "selected"; } ?>>Mrs</option>
									<option value="Dr." <?php if($agent[0]->title == "Dr.") { echo "selected"; } ?>>Dr</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-8">
						<div class="form-group">                                        
							<label class="col-md-12 col-xs-12 control-label">Applicant Name</label>
							<div class="col-md-12 col-xs-12">
								<input type="text" name="fullname" value="<?php echo $agent[0]->fullname; ?>" tabindex="2" class="form-control" required placeholder="John Doe" />
							</div>
						</div>	
					</div>
					<div class="col-md-12">
						<div class="form-group">                                        
							<label class="col-md-12 col-xs-12 control-label"><br>Address</label>
							<div class="col-md-12 col-xs-12">
								<textarea name="address" id="" tabindex="3" cols="30" rows="7" class="form-control" placeholder="Please Address Here" required><?php echo $agent[0]->address; ?></textarea>
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
											<option value="<?php echo $list->id;?>" <?php if($list->id == $agent[0]->country){ echo "selected"; }; ?>><?php echo $list->country_name; ?></option>
										<?php endforeach ?>
									<?php endif ?>
								</select>
							</div>
						</div>
					</div>
					<div id="provinces">
						<?php $country  = $agent[0]->country; ?>
						<?php $province = $agent[0]->province; ?>
						<?php $getAllProvinces = $this->Admin->getAllData('provinces','',array('ct_id' => $country)); ?>
						<div class="col-md-6">
							<br>
							<div class="form-group">
								<label for="">Province</label>
								<select name="province" id="" class="form-control">
									<?php if(!empty($getAllProvinces)): ?>
										<?php foreach ($getAllProvinces as $one): ?>
											<option value="<?php echo $one->province_id; ?>" <?php if($one->province_id == $province){ echo "selected";} ?>><?php echo $one->province_name;	 ?></option>
										<?php endforeach ?>
									<?php endif; ?>
								</select>
							</div>
						</div>	
					</div>	
				</div>
				<div class="col-md-6">

					<div class="col-md-6">
						<div class="form-group">                                        
							<label class="col-md-12 col-xs-12 control-label"><br>Phone (Account Login)</label>
							<div class="col-md-12 col-xs-12">
								<input type="text" tabindex="8" value="<?php echo $agent[0]->phone_login; ?>" name="phone_login" placeholder="03438992212" class="form-control" required/>
							</div>
						</div>	
					</div>
					<div class="col-md-6">
						<div class="form-group">                                        
							<label class="col-md-12 col-xs-12 control-label"><br>Phone (Optional)</label>
							<div class="col-md-12 col-xs-12">
								<input type="text" tabindex="9" name="phone" value="<?php echo $agent[0]->phone; ?>" placeholder="03438992212" class="form-control"/>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">                                        
							<label class="col-md-12 col-xs-12 control-label"><br>Email ID</label>
							<div class="col-md-12 col-xs-12">
								<input type="text" tabindex="10" value="<?php echo $agent[0]->email_id; ?>" name="email_id" placeholder="johndoe@gmail.com" class="form-control" required/>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">                                        
							<label class="col-md-12 col-xs-12 control-label"><br>CNIC</label>
							<div class="col-md-12 col-xs-12">
								<input type="text" value="<?php echo $agent[0]->cnic; ?>" name="cnic" placeholder="11111-1111111-1" class="form-control" required/>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">                                        
							<label class="col-md-12 col-xs-12 control-label"><br>Date Of Birth</label>
							<div class="col-md-12 col-xs-12">
								<input type="text" value="<?php echo $agent[0]->date_of_birth; ?>" name="date_of_birth" placeholder="Date of birth" class="form-control datepicker" required/>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">                                        
							<label class="col-md-12 col-xs-12 control-label"><br>Nationality</label>
							<div class="col-md-12 col-xs-12">
								<select name="nationality" id="" class="form-control">
									<option> Select Country </option>
									<?php if (!empty($nation)): ?>
										<?php foreach ($nation as $natio): ?>
											<option value="<?php echo $natio->country_name;?>" <?php if($agent[0]->nationality == $natio->country_name) { echo "selected";} ?>><?php echo $natio->country_name; ?></option>
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
									<option value="Friends" <?php if($relation[0]->relationship == "Friends"){ echo "selected";}; ?>>Friends</option>
									<option value="Busniess Partner" <?php if($relation[0]->relationship == "Busniess Partner"){ echo "selected";}; ?>>Busniess Partner</option>
									<option value="Wife"  <?php if($relation[0]->relationship == "Wife"){ echo "selected";}; ?>>Wife</option>
									<option value="Brother" <?php if($relation[0]->relationship == "Brother"){ echo "selected";}; ?>>Brother</option>
									<option value="Sister" <?php if($relation[0]->relationship == "Sister"){ echo "selected";}; ?>>Sister</option>
									<option value="Father" <?php if($relation[0]->relationship == "Father"){ echo "selected";}; ?>>Father</option>
									<option value="Son" <?php if($relation[0]->relationship == "Son"){ echo "selected";}; ?>>Son</option>
									<option value="Husband" <?php if($relation[0]->relationship == "Husband"){ echo "selected";}; ?>>Husband</option>
									<option value="Daughter" <?php if($relation[0]->relationship == "Daughter"){ echo "selected";}; ?>>Daughter</option>
									<option value="Mother" <?php if($relation[0]->relationship == "Mother"){ echo "selected";}; ?>>Mother</option>
									<option value="Cousin" <?php if($relation[0]->relationship == "Cousin"){ echo "selected";}; ?>>Cousin</option>
									<option value="Nephew" <?php if($relation[0]->relationship == "Nephew"){ echo "selected";}; ?>>Nephew</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">                                        
							<label class="col-md-12 col-xs-12 control-label"><br>Relation Name/Next Of Kin</label>
							<div class="col-md-12 col-xs-12">
								<input type="text" tabindex="13" value="<?php echo $relation[0]->relation_name; ?>" name="relation_name" class="form-control"/>
							</div>
						</div>
					</div>
					<div id="districts">
						<?php $province = $agent[0]->province; ?>
						<?php $district = $agent[0]->district; ?>
						<?php $getAllDistricts = $this->Admin->getAllData('districts','',array('province_id' => $province)); ?>
						<div class="col-md-6">
							<br>
							<div class="form-group">
								<label for="">District</label>
								<select name="district" id="" class="form-control">
									<?php if(!empty($getAllDistricts)): ?>
										<?php foreach ($getAllDistricts as $one): ?>
											<option value="<?php echo $one->id; ?>" <?php if($one->id == $district){ echo "selected";} ?>><?php echo $one->district_name;	 ?></option>
										<?php endforeach ?>
									<?php endif; ?>
								</select>
							</div>
						</div>	
					</div>
					<input type="hidden" name="user_id" value="<?php echo $id; ?>">
					<div class="col-md-6">
						<div class="form-group">                                        
							<label class="col-md-12 col-xs-12 control-label"><br>City</label>
							<div class="col-md-12 col-xs-12">
								<input type="text" tabindex="17" value="<?php echo $agent[0]->city; ?>" name="city" class="form-control" required/>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<br><br>
					<div class="col-md-8 col-md-offset-4">
						<button type="submit" class="btn btn-info " tabindex="18" > Update Information </button>
						<button type="button" onclick="location.reload()" class="btn btn-default"> Cancel </button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php else: ?>
	Sorry 
<?php endif ?>
<script>
	$(document).ready(function (e) {
		$("#UpdateCustomer").on('submit',(function(e) {
			e.preventDefault();
			$.ajax({
				url: "<?php echo base_url(); ?>Cif/UpdateCustomer",
				type: "POST",             
				data: new FormData(this), 
				contentType: false,       
				cache: false,             
				processData:false,        
				success: function(res)  
				{
					resetTable();
					$('#UpdateCustomer')[0].reset();
					$('#AllDataForms').show();
					$('#AllButtons').show();
					$('#editCustomers').hide();
					response = $.parseJSON(res);
					noty({text: response.message, layout: 'topRight', type: response.param});
				}
			});
		}));
		});
</script>