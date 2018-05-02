<?php $this->load->view('incs/header.php') ?> 
<style>
.mar-2{
    margin-top: 2em;
}
td, th {
    padding: 10px 0px;
    border-bottom: thin solid rgba(0,0,0,0.2);
}
</style>
<body>
    <!-- START PAGE CONTAINER -->
    <div class="page-container">

        <!-- START PAGE SIDEBAR -->
        <div class="page-sidebar">
            <!-- START X-NAVIGATION -->
            <?php $this->load->view('incs/side-bar') ?>
            <!-- END X-NAVIGATION -->
        </div>
        <!-- END PAGE SIDEBAR -->
        
        <!-- PAGE CONTENT -->
        <div class="page-content">

            <!-- START X-NAVIGATION VERTICAL -->
            <?php $this->load->view('incs/header_topbar.php') ?>
            <!-- END X-NAVIGATION VERTICAL -->                     

            <!-- PAGE CONTENT WRAPPER -->
            <div class="page-content-wrap">                

                <div class="row">
                    <div class="col-md-6 mar-2">
                        <!-- START DEFAULT DATATABLE -->
                        <div class="panel panel-default">
                            <div class="panel-heading">                                
                                <h3 class="panel-title">Change Password</h3>
                            </div>
                            <div class="panel-body">
                             <form id="SaveUnitDetails">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="clearfix"></div>
                                            <div class="form-group">                                        
                                                <label class="control-label"><br>Enter Old Password</label>
                                                <input type="text" id="persquare" name="old" class="form-control" required />
                                            </div>
                                            <div class="form-group">                                        
                                                <label class="control-label"><br>Enter New Password</label>
                                                <input type="text" id="total_price" name="new" class="form-control" required />
                                            </div>
                                            <div class="clearfix"></div>
                                            <br> <br>
                                        </div>              
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update Password</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>                                

            </div>
            <!-- PAGE CONTENT WRAPPER -->                                     
        </div>            
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END PRELOADS -->  
    <!-- Performing Edit/ View -->
    <?php $this->load->view('incs/jquery-footer') ?>  
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>    
    <script>

// Saving User To Database
$(document).ready(function (e) {
    $("#SaveUnitDetails").on('submit',(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?php echo base_url(); ?>Password/changePassword",
        type: "POST",             
        data: new FormData(this), 
        contentType: false,       
        cache: false,             
        processData:false,        
        success: function(res)  
        {
            response = $.parseJSON(res);
            noty({text: response.message, layout: 'topRight', type: response.param});
            if (reponse.clear == 1) 
            {
                $('SaveUnitDetails')[0].clear();
            }
        }
    });
  }));
});
</script>
</body>
</html>






