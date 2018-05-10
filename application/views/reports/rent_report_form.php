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
                                    <div class="col-md-3">
                                        <label for="#">Project</label>
                                        <select name="project_id" class="form-control select" data-live-search="true">
                                            <option> Select Project</option>
                                             <?php if (!empty($project)): ?>
                                                <?php foreach ($project as $one): ?>
                                                    <option value="<?php echo $one->project_id;?>"><?php echo $one->project_name; ?></option>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </select>
                                    </div>
                                   
                                    <div class="col-md-2">
                                        <label for="#">Year</label>
                                        <input type="text" value="<?= date('Y'); ?>" name="from" readonly class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="#">Month</label>
                                        <input type="text" name="to" value="<?= date('F'); ?>" readonly class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label for=""></label>
                                        <input style="margin-top: 20px;" type="submit" class="btn btn-info" value="Filter">
                                    </div>
                                </form>
                                <!-- End Filters -->
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.12.12/xlsx.core.min.js"></script>
    <script src="https://fastcdn.org/FileSaver.js/1.1.20151003/FileSaver.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/TableExport/5.0.0/js/tableexport.min.js"></script>
    <script>
        $(document).ready(function (e) {
            $("#Report").on('submit',(function(e) {
              e.preventDefault();
              $.ajax({
                url: "<?php echo base_url(); ?>Reports/rent/get",
                type: "POST",             
                data: new FormData(this), 
                contentType: false,       
                cache: false,             
                processData:false,        
                success: function(res)  
                {
                    $('#resultReports').html(res);
                    var tables = $("table").tableExport({
                         formats: ["xls"]
                    });
                    $('table').tableExport().remove();
                }
            });
          }));

        });
    </script>
</body>
</html>






