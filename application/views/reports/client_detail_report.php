<?php $this->load->view('./incs/header.php') ?> 
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
                <div class="row">
                    <div class="col-md-12 mar-2">
                        <!-- START DEFAULT DATATABLE -->
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <!-- Filters -->
                                <form id="Report">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">Search By</label>
                                            <select class="form-control select" onchange="ShowOthers($(this).val())">
                                                <option>Select Filter</option>
                                                <option value="email">Email</option>
                                                <option value="phone">Phone</option>
                                                <option value="name">Name</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2" id="email" style="display: none;">
                                        <div class="form-group">
                                            <label class="control-label">Search By Email</label>
                                            <select class="form-control select" name="email" data-live-search="true">
                                                <option value="1">Select Email</option>
                                                <?php if (!empty($allUsers)): ?>
                                                    <?php foreach ($allUsers as $email): ?>
                                                        <option value="<?php echo $email->email_id; ?>"><?php echo $email->email_id; ?></option>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2" id="phone" style="display: none;">
                                        <div class="form-group">
                                            <label class="control-label">Search By Phone</label>
                                            <select class="form-control select" name="phone" data-live-search="true">
                                                <option value="1">Select Phone</option>
                                                <?php if (!empty($allUsers)): ?>
                                                    <?php foreach ($allUsers as $phone): ?>
                                                        <option value="<?php echo $phone->phone_login; ?>"><?php echo $phone->phone_login; ?></option>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2" id="fullname" style="display: none;">
                                        <div class="form-group">
                                            <label class="control-label">Search By Name</label>
                                            <select class="form-control select" name="fullname" data-live-search="true">
                                                <option value="1">Select Name</option>
                                                <?php if (!empty($allUsers)): ?>
                                                    <?php foreach ($allUsers as $name): ?>
                                                        <option value="<?php echo $name->fullname; ?>"><?php echo $name->fullname; ?></option>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for=""></label>
                                        <input style="margin-top: 20px;" type="submit" class="btn btn-info" value="Filter">
                                    </div>
                                </form>
                                <!-- End Filters -->
                                <div class="clearfix"></div>
                                <div class="clearfix"></div>
                                <div id="resultReports"></div>
                            </div>
                        </div>
                    </div>
                </div>                                
            </div>
            <!-- PAGE CONTENT WRAPPER -->                                     
        </div>            
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END PAGE CONTAINER -->
    <?php $this->load->view('./incs/jquery-footer') ?>  
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>    
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/bootstrap/bootstrap-select.js"></script>
    <script>
        $(document).ready(function (e) {
            $("#Report").on('submit',(function(e) {
              e.preventDefault();
              $.ajax({
                url: "<?php echo base_url(); ?>Reports/ClientDetails",
                type: "POST",             
                data: new FormData(this), 
                contentType: false,       
                cache: false,             
                processData:false,        
                success: function(res)  
                {
                    $('#resultReports').html(res);
                }
            });
          }));
        });
        // Search By Filters
        function ShowOthers(val) {
            if (val == "email"){
                $('#email').show();
                $('#phone').hide();
                $('#fullname').hide();}
            else if(val == "phone"){
                $('#phone').show();
                $('#email').hide();
                $('#fullname').hide();}
            else{
                $('#fullname').show();
                $('#phone').hide();
                $('#email').hide();
            }
        }
    </script>
</body>
</html>






