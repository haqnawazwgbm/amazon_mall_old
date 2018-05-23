 <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Sale Unit</h5>
            </div>
            <div id="edit-installments"></div>
            <form id="sale-edit-form" action="<?= base_url('Sales/show_edit_installments'); ?>">
                <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                         <div class="form-group col-lg-6">
                            <label class="col-md-6 col-xs-12 control-label">Project</label>
                            <div class="col-md-12 col-xs-12">    
                                <select required class="form-control" id="project_id" name="project_id" onchange="get_floors($(this).val())">
                                    <?php  
                                    if (!empty($projects)) {
                                        foreach ($projects as $project) {
                                            if ($project['project_id'] == $sale['project_id']) {
                                                   echo '<option selected value="'.$project['project_id'].'">'.$project['project_name'].'</option>';  
                                            }
                                           

                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                         <div class="form-group col-lg-6">
                            <label class="col-md-6 col-xs-12 control-label">Floor</label>
                            <div class="col-md-12 col-xs-12" id="floor_box">    
                                <select class="form-control" id="floor_id" name="floor_id" onchange="get_units($(this).val())">
                                    <?php  
                                    if (!empty($floors)) {
                                        foreach ($floors as $floor) {
                                            if ($floor['floor_id'] == $sale['floor_id']) {
                                                echo '<option selected value="'.$floor['floor_id'].'">'.$floor['floor_types'].'</option>';
                                            } 
                                            
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group col-lg-6">
                            <label class="col-md-6 col-xs-12 control-label">Units</label>
                            <div class="col-md-12 col-xs-12" id="unit_box">    
                                <select  class="form-control" id="unit_id" name="unit_id">
                                    <?php  
                                    if (!empty($units)) {
                                        foreach ($units as $unit) {
                                            if ($unit['unit_id'] == $sale['unit_id']) {
                                                echo '<option selected value="'.$unit['unit_id'].'">'.$unit['unit_type'].'</option>';
                                            }
                                            
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                         <div class="form-group col-lg-6">
                            <label class="col-md-6 col-xs-12 control-label">Client</label>
                            <div class="col-md-12 col-xs-12">    
                                <select class="form-control" id="user_id" name="user_id">
                                    <?php  
                                    if (!empty($users)) {
                                        foreach ($users as $user) {
                                            if ($user['user_id'] == $sale['user_id']) {
                                                echo '<option selected value="'.$user['user_id'].'">'.ucfirst($user['fullname']).'</option>';
                                            }
                                            
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group col-lg-6">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>Down Payment</label>
                            <div class="col-md-12 col-xs-12">
                                <input type="text" value="<?= $sale['down_payment']; ?>" name="down_payment" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>Token Money</label>
                            <div class="col-md-12 col-xs-12">
                                <input type="text" name="token_money" value="<?= $sale['token_money']; ?>" class="form-control"/>
                            </div>
                        </div>
                        <br>
                        <div class="form-group col-lg-6">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>Discount</label>
                            <div class="col-md-12 col-xs-12">
                                <input type="text" name="discount" value="<?= $sale['discount']; ?>" class="form-control"/>
                            </div>
                        </div>
                       
                        <div class="form-group col-lg-6 invisible">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>Sale Space</label>
                            <div class="col-md-12 col-xs-12">
                                <input type="text" name="square_feet" id="square_feet" value="<?= $sale['square_feet']; ?>" class="form-control"/>
                            </div>
                        </div>
                        <input type="hidden" name="sale_id" value="<?= $sale['sale_id']; ?>" id="sale_id">
                        <input type="hidden" name="size_sqft" id="size_sqft">
                        <input type="hidden" name="price_sqft" id="price_sqft">
                        <input type="hidden" name="installments" id="installments" value="<?= $sale['installments']; ?>" class="form-control"/>
                        <br>
                        
                        <div class="clearfix"></div>
                        <br> <br>
                    </div>              
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Next</button>
                </div>
            </form>
            </div> 
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#sale-edit-form').submit(function(e) {
                 e.preventDefault();
                var url = "<?= base_url('Sales/show_edit_installments'); ?>";
                var data = $(this).serialize();
                 $.post(url, data, function(data, textStatus, xhr) {
                    $('#exampleModal').hide();
                    $('#load_installment_form').html(data);
                    $('#edit-installments-model').modal('show');
                });
               
            })
        })
        function get_floors(project_id) {
            data = {project_id:project_id};
            url = "<?= base_url('Sales/get_floor_dropdown'); ?>";
            $.post(url, data, function(data, textStatus, xhr) {
                    $('#floor_box').find('select').remove();
                    $('#floor_box').append(data);
            });
        }
        function get_units(floor_id) {
            data = {floor_id:floor_id};
            url = "<?= base_url('Sales/get_unit_dropdown'); ?>";
            $.post(url, data, function(data, textStatus, xhr) {
                $('#unit_box').find('select').remove();
                $('#unit_box').append(data);
            });
        }
    </script>