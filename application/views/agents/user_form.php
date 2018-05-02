<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-lg">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">New User</h5>
            </div>
            <form id="SaveAgent">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-6 col-xs-12 control-label">Title</label>
                            <div class="col-md-12 col-xs-12">    
                                <select class="form-control" name="title">
                                    <option value="Mr.">Mr</option>
                                    <option value="Ms.">Ms</option>
                                    <option value="Miss.">Miss</option>
                                    <option value="Mrs.">Mrs</option>
                                    <option value="Dr.">Dr</option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>Full Name</label>
                            <div class="col-md-12 col-xs-12">
                                <input type="text" name="fullname" class="form-control"/>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>Email</label>
                            <div class="col-md-12 col-xs-12">
                                <input type="email" name="email" onblur="CheckEmail($(this).val())" class="form-control"/>
                                <label id="emailid"></label>
                            </div>
                        </div>
                        <div class="form-group">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>Phone</label>
                            <div class="col-md-12 col-xs-12">
                                <input type="text" name="phone" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>Type</label>
                            <div class="col-md-12 col-xs-12">
                                <select class="form-control" name="type">
                                    <option>Select User Type</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Accountant">Accountant</option>
                                    <option value="Agent">Agent</option>
                                    <option value="User">User</option>
                                    <option value="ccd">CCD</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>Phone (Optional)</label>
                            <div class="col-md-12 col-xs-12">
                                <input type="text" name="phone-opt" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>Nationality</label>
                            <div class="col-md-12 col-xs-12">
                                <select class="form-control" name="nationality">
                                    <option>Select Nationality</option>
                                    <?php if (!empty($country)): ?>
                                        <?php foreach ($country as $one): ?>
                                            <option value="<?php echo $one->id; ?>"><?php echo $one->country_name; ?></option>
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
                                    <input type="checkbox" name="status" class="icheckbox" value="1"/> Active</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-6 col-xs-12 control-label">Address</label>
                                <div class="col-md-12 col-xs-12">                                            
                                    <textarea class="form-control" name="address" rows="5"></textarea>
                                </div>
                            </div>
                             <div class="form-group">                                        
                                <label class="col-md-6 col-xs-12 control-label"><br>CNIC</label>
                                <div class="col-md-12 col-xs-12">
                                    <input type="text" placeholder="1111-111111-1" name="cnic" class="form-control"/>
                                    <label id="cnic"></label>
                                </div>
                            </div>
                            <div class="form-group">                                        
                                <label class="col-md-6 col-xs-12 control-label"><br>Country</label>
                                <div class="col-md-12 col-xs-12">
                                    <select class="form-control" name="country" onchange="getProvince($(this).val())">
                                        <option>Select Nationality</option>
                                           <?php if (!empty($country)): ?>
                                                <?php foreach ($country as $one): ?>
                                                    <option value="<?php echo $one->id; ?>"><?php echo $one->country_name; ?></option>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                    </select>
                                </div>
                            </div>
                            <div id="provinces"></div>
                            <div id="districts"></div>
                            <div class="form-group">                                        
                                <label class="col-md-6 col-xs-12 control-label"><br>City</label>
                                <div class="col-md-12 col-xs-12">
                                    <input type="text" class="form-control" name="city" />
                                </div>
                            </div>
                        </div>
                    </div>              
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div> 
    </div>
</div>