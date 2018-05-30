<?php $this->load->view('./incs/header.php') ?> 
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
                            <div class="panel-heading">                                
                                <h3 class="panel-title">Projects</h3>
                                <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#exampleModal"> <span class="fa fa-plus"> </span> New Project</button>
                            </div>
                            <div class="panel-body">
                                <table id="example" class="display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Project Name</th>
                                            <th>Project Location</th>
                                            <th>Starting Date</th>
                                            <th>Expected End</th>
                                            <th>Area Size</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <!-- END DEFAULT DATATABLE -->
                    </div>
                </div>                                

            </div>
            <!-- PAGE CONTENT WRAPPER -->                                     
        </div>            
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END PAGE CONTAINER -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Project Details</h5>
            </div>
            <form id="Projects">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                             <h4>
                                Project Details
                            </h4><hr>
                            <div class="form-group">                                        
                                <label class="col-md-6 col-xs-12 control-label">Project Name</label>
                                <div class="col-md-12 col-xs-12">
                                    <input type="text" name="project_name" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">                                        
                                <label class="col-md-6 col-xs-12 control-label"><br>Project Location</label>
                                <div class="col-md-12 col-xs-12">
                                    <input type="text" name="project_location" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">                                        
                                <label class="col-md-6 col-xs-12 control-label"><br>Starting Date</label>
                                <div class="col-md-12 col-xs-12">
                                    <input type="text" name="starting_date" class="form-control datepicker"/>
                                </div>
                            </div>
                            <div class="form-group">                                        
                                <label class="col-md-6 col-xs-12 control-label"><br>Expected End Date</label>
                                <div class="col-md-12 col-xs-12">
                                    <input type="text" name="expected_end" class="form-control datepicker"/>
                                </div>
                            </div>
                            <div class="form-group">                                        
                                <label class="col-md-6 col-xs-12 control-label"><br>Size Square Feet</label>
                                <div class="col-md-12 col-xs-12">
                                    <input type="text" class="form-control" name="size_sqft" />
                                </div>
                            </div>
                        </div>
                         <div class="col-md-6">
                            <h4>
                                Commission Details
                            </h4><hr>
                            <div class="form-group">                                        
                                <label class="col-md-6 col-xs-12 control-label">Commission Title</label>
                                <div class="col-md-12 col-xs-12">
                                    <input type="text" class="form-control" value="<?php //echo $project->size_sqft; ?>" name="commission_title" id="commission_title" />
                                </div>
                               
                            </div>
                            <div class="form-group">                                        
                                <label class="col-md-6 col-xs-12 control-label"><br>Commission Percentage</label>
                                <div class="col-md-12 col-xs-12">
                                    <input type="number" class="form-control" id="commission_percentage" value="<?php //echo $project->size_sqft; ?>" name="commission_percentage" />
                                </div>
                             
                            </div>
                            <div class="form-group">                                        
                                <label class="col-md-6 col-xs-12 control-label"><br>From Date</label>
                                <div class="col-md-12 col-xs-12">
                                    <input type="text" class="form-control datepicker" value="<?php //echo $project->size_sqft; ?>" id="from_date" name="from_date" />
                                </div>
                             
                            </div>
                            <div class="form-group">                                        
                                <label class="col-md-6 col-xs-12 control-label"><br>To Date</label>
                                <div class="col-md-12 col-xs-12">
                                    <input type="text" class="form-control datepicker" value="<?php // echo $project->size_sqft; ?>" id="to_date" name="to_date" />
                                </div>
                               
                            </div>
                         </div>
                    </div>              
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Project</button>
                </div>
            </form>
        </div> 
    </div>
</div>
<!-- END PRELOADS -->  
<!-- Performing Edit/ View -->
<div class="modal fade" id="loadDatas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" >
            <div id="givedata"></div>
        </div> 
    </div>
</div>

<?php $this->load->view('./incs/jquery-footer') ?>  
<script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>    
<script>
// Saving User To Database
$(document).ready(function (e) {
    $("#Projects").on('submit',(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?php echo base_url(); ?>Projects/UploadProject",
        type: "POST",             
        data: new FormData(this), 
        contentType: false,       
        cache: false,             
        processData:false,        
        success: function(res)  
        {
            resetTable();
            $('#Projects')[0].reset();
            $('#exampleModal').modal('toggle');
            response = $.parseJSON(res);
            noty({text: response.message, layout: 'topRight', type: response.param});
        }
    });
  }));
});
// Loading Data From Server Via Datatables Pipeline
loadDataintoTable();
function loadDataintoTable()
{
    $('#example').DataTable({
        "ajax": "<?php echo base_url('Projects/getAllProjects') ?>",
        "columns": [
        { "data": "1" },
        { "data": "2" },
        { "data": "3" },
        { "data": "4" },
        { "data": "5" },
        { "data": "6" }
        ]
    });
}

function resetTable()
{
    $("#example").dataTable().fnDestroy();
    loadDataintoTable();
}

function doAgentAction(id)
{
    if (confirm('Are You Sure To Edit?')) 
    {
        $.ajax({
            url: '<?php echo base_url("Projects/EditProject")?>',
            type: 'POST',
            data: {id:id},
        })
        .done(function(res) {
            $('#givedata').html(res);
        });
    }
}
</script>
</body>
</html>






