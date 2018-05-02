<?php 
if (!empty($getAgent)) { 
$profile =json_decode($getAgent)[0];
?>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modify User</h5>
    </div>
    <form id="ModifyAgent">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-6 col-xs-12 control-label">Title</label>
                        <div class="col-md-12 col-xs-12">    
                            <select class="form-control" name="title">
                                <option value="Mr." <?php if ($profile->title == "Mr.") {
                                   echo "selected";
                                } ?>>Mr</option>
                                <option value="Ms." <?php if ($profile->title == "Ms.") {
                                   echo "selected";
                                } ?>>Ms</option>
                                <option value="Miss." <?php if ($profile->title == "Miss.") {
                                   echo "selected";
                                } ?>>Miss</option>
                                <option value="Mrs" <?php if ($profile->title == "Mrs.") {
                                   echo "selected";
                                } ?>>Mrs</option>
                                <option value="Dr" <?php if ($profile->title == "Dr.") {
                                   echo "selected";
                                } ?>>Dr</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">                                        
                        <label class="col-md-6 col-xs-12 control-label"><br>Full Name</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" value="<?php echo $profile->fullname; ?>" name="fullname" class="form-control"/>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">                                        
                        <label class="col-md-6 col-xs-12 control-label"><br>Email</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="email_id" value="<?php echo $profile->email_id    ; ?>" name="email_id" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">                                        
                        <label class="col-md-6 col-xs-12 control-label"><br>Phone</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" value="<?php echo $profile->phone_login; ?>" name="phone_login" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">                                        
                        <label class="col-md-6 col-xs-12 control-label"><br>Type</label>
                        <div class="col-md-12 col-xs-12">
                            <select class="form-control" name="type">
                                <option>Select User Type</option>
                                <option value="Admin" <?php if($profile->type == "Admin"){ echo "selected";} ?>>Admin</option>
                                <option value="Accountant" <?php if($profile->type == "Accountant"){ echo "selected";} ?>>Accountant</option>
                                <option value="Agent" <?php if($profile->type == "Agent"){ echo "selected";} ?>>Agent</option>
                                <option value="User" <?php if($profile->type == "User"){ echo "selected";} ?>>User</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">                                        
                        <label class="col-md-6 col-xs-12 control-label"><br>Phone (Optional)</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" name="phone" value="<?php echo $profile->phone; ?>" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">                                        
                        <label class="col-md-6 col-xs-12 control-label"><br>Nationality</label>
                        <div class="col-md-12 col-xs-12">
                            <select class="form-control" name="nationality">
                                <option>Select Nationality</option>
                                <?php if (!empty($country)): ?>
                                    <?php foreach ($country as $one): ?>
                                        <option <?php if ($one->id == $profile->nationality): ?>
                                            selected
                                        <?php endif ?> value="<?php echo $one->id; ?>"><?php echo $one->country_name; ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div><br>
                    <div class="form-group">
                        <label class="col-md-6 col-xs-12 control-label">Status</label>
                        <div class="col-md-12 col-xs-12">   
                            <label class="check">
                                <input type="checkbox" <?php if($profile->status == 1){ echo "checked";} ?> name="status" class="icheckbox" value="1"/> Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-6 col-xs-12 control-label">Address</label>
                            <div class="col-md-12 col-xs-12">                                            
                                <textarea class="form-control" name="address" rows="5"><?php echo $profile->address; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>CNIC</label>
                            <div class="col-md-12 col-xs-12">
                                <input type="text" value="<?php echo $profile->cnic; ?>" placeholder="1111-1111111-1" name="cnic" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>Country</label>
                            <div class="col-md-12 col-xs-12">
                                <select class="form-control" name="country">
                                    <option>Select Nationality</option>
                                    <?php if (!empty($country)): ?>
                                        <?php foreach ($country as $one): ?>
                                            <option <?php if ($one->id == $profile->country): ?>
                                                selected
                                            <?php endif ?> value="<?php echo $one->id; ?>"><?php echo $one->country_name; ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>Province</label>
                            <div class="col-md-12 col-xs-12">
                                <input type="text" class="form-control" value="<?php echo $profile->province; ?>"  name="province" />
                            </div>
                        </div>
                        <div class="form-group">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>District</label>
                            <div class="col-md-12 col-xs-12">
                                <input type="text" class="form-control" value="<?php echo $profile->district; ?>" name="district" />
                            </div>
                        </div>
                        <div class="form-group">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>City</label>
                            <div class="col-md-12 col-xs-12">
                                <input type="text" value="<?php echo $profile->city;?>" class="form-control" name="city" />
                            </div>
                        </div>
                        <input type="hidden" name="user_id" value="<?php echo $profile->user_id;?>">
                    </div>
                </div>              
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
<?php }?>
<script>
// Saving User To Database
$(document).ready(function (e) {
    $("#ModifyAgent").on('submit',(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?php echo base_url(); ?>Agents/ModifyAgent",
        type: "POST",             
        data: new FormData(this), 
        contentType: false,       
        cache: false,             
        processData:false,        
        success: function(res)  
        {
            resetTable();
            $('#loadDatas').modal('toggle');
            response = $.parseJSON(res);
            noty({text: response.message, layout: 'topRight', type: response.param});
        }
    });
  }));
});
</script>
