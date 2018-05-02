<?php $this->load->view('./incs/header.php') ?> 

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
              
                <!-- START CONTENT FRAME -->
                <div class="content-frame">                                    
                   
                    <!-- END CONTENT FRAME LEFT -->
                    <div class="clearfix"></div>
                    <!-- START CONTENT FRAME BODY -->
                    <div class="col-md-12">
                        
                         <div class="block">
                        <form id="SaveUSer" class="form-horizontal col-md-12">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        <button class="btn btn-danger" type="submit"><span class="fa fa-envelope"></span> Send Message</button>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Title:</label>
                                <input type="text" class="form-control" name="title" required />                                
                            </div>
                            <div class="form-group">
                                <label class="control-label">Subject:</label>
                                <input type="text" class="form-control" name="subject" required />         
                            </div>
                            <div class="form-group">
                                <label class="control-label">Department:</label>
                                <select name="department" id="" class="form-control" required>
                                    <option> Select Department</option>
                                    <option value="Accounts">Accounts</option>
                                    <option value="HR">HR</option>
                                    <option value="Admin">Admin</option>
                                </select>        
                            </div>
                            <div class="form-group">
                                <label class="control-label">Urgency:</label>
                                <select name="urgency" id="" class="form-control" required>
                                    <option> Select Urgency</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Urgent">Urgent</option>
                                    <option value="Very Urgent">Very Urgent</option>
                                </select>        
                            </div>
                            <div class="form-group">
                                <label for="">Message</label>
                                <textarea class="summernote_email" name="message"></textarea>                            
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        <button class="btn btn-danger" type="submit"><span class="fa fa-envelope"></span> Send Message</button>
                                    </div>                                    
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                    <!-- END CONTENT FRAME BODY -->
                </div>
                <!-- END CONTENT FRAME -->
                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
        <?php $this->load->view('./incs/jquery-footer') ?>  
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/plugins/summernote/summernote.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/plugins/tagsinput/jquery.tagsinput.min.js"></script>       
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/plugins/bootstrap/bootstrap-select.js"></script>        
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/plugins/bootstrap/bootstrap-file-input.js"></script>
        <script>
            $(document).ready(function (e) {
                $("#SaveUSer").on('submit',(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "<?php echo base_url(); ?>Customers/SendMessage",
                        type: "POST",             
                        data: new FormData(this), 
                        contentType: false,       
                        cache: false,             
                        processData:false,        
                        success: function(res)  
                        {
                           location.href="<?php echo base_url('Customers/Message')?>";
                        }
                    });
                }));
            });
        </script>
    </body>
</html>






