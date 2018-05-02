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
                    <div class="col-md-6 mar-2">
                        <div id="MainUnit"></div>
                        <form class="form-horizontal" id="BasicFloors">
                            <div class="panel panel-success">
                                <div class="panel-body"> 
                                    <h3>New Floor</h3>
                                    <br><br>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Project Name</label>
                                        <div class="col-md-9">                                
                                            <div class="input-group">
                                               <span class="input-group-addon"></span>
                                               <select name="project_id" id="" class="form-control" required> 
                                                <option> Select Project </option>
                                                <?php  
                                                if (!empty($Projects)) {
                                                    $decodeProjects = json_decode($Projects);
                                                    foreach ($decodeProjects as $project) {
                                                       echo '<option value="'.$project->project_id.'">'.$project->project_name.'</option>';
                                                   }
                                               }
                                               ?>
                                           </select>
                                       </div>                                            
                                   </div>
                               </div>
                               <div class="form-group">
                                <label class="col-md-3 control-label">Floor Type</label>
                                <div class="col-md-9">                                
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <input type="text" placeholder="e.g First Floor" name="floor_types" class="form-control" required>
                                    </div>                                            
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Size in Square Feets (Optional)</label>
                                <div class="col-md-9">                                
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <input type="text" placeholder="e.g 400" id="unitsize" name="size_sqft" class="form-control">
                                    </div>                                            
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Price / Square feet</label>
                                <div class="col-md-9">                                
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <input type="text" placeholder="e.g 300" id="persquare" name="price_sqft" class="form-control">
                                    </div>                                            
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Rent Per Sqft</label>
                                <div class="col-md-9">                                
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <input type="text" placeholder="e.g 100" id="rent_price" name="rent_price" class="form-control">
                                    </div>                                            
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Space Type</label>
                                <div class="col-md-9">                                
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <select name="type" class="form-control" required>
                                            <option value="shop">Shops</option>
                                            <option value="space">Spaces</option>
                                        </select>
                                    </div>                                            
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button class="btn btn-primary pull-right" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
                <!-- END DEFAULT DATATABLE -->
            </div>
            <div class="col-md-12 mar-2">
                <div class="panel panel-success">
                    <div class="panel-heading">                                
                        <h3 class="panel-title">Floors</h3>
                        <button class="btn btn-info pull-right" id="AddNew">Add Floor</button>
                    </div>
                    <div class="panel-body">
                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Floor Type</th>
                                    <th>Project Name</th>
                                    <th>Floor Size</th>
                                    <th>Price / Sqft</th>
                                    <th>Rent Price</th>
                                    <th>Created</th>
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

<?php $this->load->view('./incs/jquery-footer') ?>  
<script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>    
<script>
// Saving User To Database
$(document).ready(function (e) {
    $("#BasicFloors").on('submit',(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?php echo base_url(); ?>Floors/saveFloor",
        type: "POST",             
        data: new FormData(this), 
        contentType: false,       
        cache: false,             
        processData:false,        
        success: function(res)  
        {
            resetTable();
            $('#BasicFloors')[0].reset();
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
        "ajax": "<?php echo base_url('Floors/getAllFloors') ?>",
        "columns": [
        { "data": "1" },
        { "data": "2" },
        { "data": "3" },
        { "data": "4" },
        { "data": "7" },
        { "data": "8" },
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

function doFloorAction(action,id)
{
    if (action == 2) 
    {
        $('#BasicFloors').hide();
        $.ajax({
            url: '<?php echo base_url("Floors/EditFloors")?>',
            type: 'POST',
            data: {id:id},
        })
        .done(function(res) {
            $('#MainUnit').html(res);
        })
    }
}
function Reset() {
    $('#BasicFloors').show();
    $('#ModifyUnit').hide();
}
// Form To Show Hide
$('#BasicFloors').hide();
$('#AddNew').click(function() {
    $('#BasicFloors').toggle('slow');
});

</script>
</body>
</html>






