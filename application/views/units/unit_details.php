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
                    <div class="col-lg-12">
                         <form id="unit_filter_form">
                                    <div class="col-md-3">
                                        <label for="#">Project</label>
                                         <select class="form-control " onchange="getsearchFloors($(this).val())" tabindex="1" name="project" id="project_type">
                                                <option>Select Project</option>
                                                    <?php $project = json_decode($project); if (!empty($project)): ?>
                                                    <?php foreach ($project as $pro): ?>
                                                        <option value="<?php echo $pro->project_id;?>"><?php echo $pro->project_name; ?></option>
                                                    <?php endforeach ?>
                                                <?php endif ?>  
                                        </select>
                                    </div>
                                   <div id="getSearchfloors"></div>
                                
                                    <div class="col-md-2">
                                        <label for=""></label>
                                        <input style="margin-top: 20px;" type="submit" class="btn btn-info" value="Filter">
                                    </div>
                                </form>
                    </div>
                    <div class="col-md-12 mar-2">
                        <div id="loadData"></div>
                        
                        <!-- START DEFAULT DATATABLE -->
                        <div class="panel panel-default">
                            <div class="panel-heading">                                
                                <h3 class="panel-title">Sales Units</h3>
                                <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#exampleModal"> <span class="fa fa-plus"> </span> Sale Units</button>
                            </div>
                            <style>
                                td:nth-child(1) {  
                                  display:none;
                                }
                                th:nth-child(1) {  
                                  display:none;
                                }
                            </style>
                            <div class="panel-body">
                                <table id="example" class="display customise" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Unit ID</th>
                                            <th>Unit</th>
                                            <th>Floor</th>
                                            <th>Project</th>
                                            <th>Unit Size/Square Feet </th>
                                            <th>Price/Square Feet</th>
                                            <th>Total Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>

                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                        
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Sale Unit</h5>
            </div>
            <form id="SaveUnitDetails">
                <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>Sale Unit</label>
                            <div class="col-md-12 col-xs-12">
                                <input type="text" name="unit_type" class="form-control"/>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="col-md-6 col-xs-12 control-label">Project</label>
                            <div class="col-md-12 col-xs-12">    
                                <select class="form-control" id="textproject" onchange="getFloors($(this).val())">
                                    <option> Select Project </option>
                                    <?php  
                                    if (!empty($project)) {
                                        foreach ($project as $singleUnit) {
                                            echo '<option value="'.$singleUnit->project_id.'">'.$singleUnit->project_name.'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div id="floors"></div>
                        <div class="form-group">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>Unit Size/Square Feet</label>
                            <div class="col-md-12 col-xs-12">
                                <input type="text" id="unitsize" onblur="getID()" name="size_sqft" class="form-control"/>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>Unit ID</label>
                            <div class="col-md-12 col-xs-12">
                                <input type="text" id="unitid" readonly value="" name="shopID" class="form-control"/>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>Price/Square Feet</label>
                            <div class="col-md-12 col-xs-12">
                                <input type="number" id="price_sqft" min="1" value="" name="price_sqft" class="form-control"/>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <br> <br>
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
    <!-- END PRELOADS -->  
    <!-- Performing Edit/ View -->
    <?php $this->load->view('./incs/jquery-footer') ?>  
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>    
    <script>
     

// Saving User To Database
$(document).ready(function (e) {
    $("#SaveUnitDetails").on('submit',(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?php echo base_url(); ?>Units/saveUnitDetails",
        type: "POST",             
        data: new FormData(this), 
        contentType: false,       
        cache: false,             
        processData:false,        
        success: function(res)  
        {
            resetTable();
            $('#SaveUnitDetails')[0].reset();
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
        "order": [[ 0, "ASC" ]],
        "ajax": "<?php echo base_url('Units/getAllUnits') ?>",
        "columns": [
        { "data": "11" },
        { "data": "0" },
        { "data": "1" },
        { "data": "2" },
        { "data": "7" },
        { "data": "3" },
        { "data": "4" },
        { "data": "5" },
        { "data": "9" }
        ]
    });
}

function getID()
{
    data = {
        project : $('#textproject option:selected').text(),
        floor : $('select[name="floor_id"] option:selected').text(),
        unit : $('input[name="unit_type"]').val(),
    };
    $.post('<?php echo base_url("Units/getID") ?>',data, function(data, textStatus, xhr) {
        $('#unitid').val(data.trim());
    });
}

function resetTable()
{
    $("#example").dataTable().fnDestroy();
    loadDataintoTable();
}

function getFloors(id)
{
    $.ajax({
        url: '<?php echo base_url("Units/getFloors")?>',
        type: 'POST',
        data: {id:id},
    })
    .done(function(res) {
        $('#floors').html(res);
    })
}

function doUnitsAction(action,id)
{
    if (action == 1) 
    {
        $.ajax({
            url: '<?php echo base_url("Units/ViewSalesUnitReport")?>',
            type: 'POST',
            data: {id:id},
        })
        .done(function(res) {
            $('#loadData').html(res);
        })
    }
    else if (action == 2) 
    {
        $.ajax({
            url: '<?php echo base_url("Units/EditUnits")?>',
            type: 'POST',
            data: {id:id},
        })
        .done(function(res) {
            $('#loadData').html(res);
        })
    }
    else
    {
        if (confirm('Are You Sure to Delete?')) 
        {
            $.ajax({
                url: '<?php echo base_url("Units/deleteUnits")?>',
                type: 'POST',
                data: {id:id},
            })
            .done(function(res) {
                $("#example").dataTable().fnDestroy();
                loadDataintoTable();
                response = $.parseJSON(res);
                noty({text: response.message, layout: 'topRight', type: response.param});
            })
        }
    }

}
function Reset() {
    $('#loadData').html('');
}

function getsearchFloors(id)
    {
        $.post('<?php echo base_url('Cif/getsearchFloors') ?>', {id:id}, function(data, textStatus, xhr) {
            $('#getSearchfloors').html(data);
        });
    }
    $( "body" ).delegate( "#unit_filter_form", "submit", function(e) {
        var project_id = $("select[name='project']").val();
        var floor_id = $("select[name='floor']").val();
        e.preventDefault();
        var data = {project_id: project_id, floor_id: floor_id};
        $("#example").dataTable().fnDestroy();
        $('#example').DataTable({
            "order": [[ 0, "ASC" ]],
            "ajax": {
                'url': "<?php echo base_url('Units/getAllUnits/specific') ?>",
                'type': 'POST',
                'data': data
            },
            "columns": [
            { "data": "11" },
            { "data": "0" },
            { "data": "1" },
            { "data": "2" },
            { "data": "7" },
            { "data": "3" },
            { "data": "4" },
            { "data": "5" },
            { "data": "9" }
            ]
        });
    });

</script>
</body>
</html>






