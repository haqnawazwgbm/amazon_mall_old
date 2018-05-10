<?php $this->load->view('./incs/header.php') ?> 
<!-- overriding styles -->
<style type="text/css">
.dropzone a.dz-remove, .dropzone-previews a.dz-remove{
    display: none !important;
}
.file-type{
    padding: 1em 2em;
    float: left;
    background: #E91E63;
    margin-right: 12px;
}
.file-type h3{
    float: left;
}
h3{
    padding: 20px 0px;
}
</style>
<!-- end of style -->
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
                <ul class="breadcrumb">
                    <li><a href="<?php echo base_url('Master/dashboard');?>">Home</a></li>
                    <li class="active"><a href="<?php echo base_url('Units');?>">Sales Unit</a></li>
                </ul>
                <br><br>
                
                <div class="col-md-10 col-md-offset-1">
                    <?php 
                    $code = json_decode($getUnits);
                    foreach ($code as $unit):        
                        ?>
                        <br>
                        <h3 class="title"><?php echo $unit->unit_type; ?> Unit Details. <a href="<?php echo base_url('Units');?>" class="pull-right btn btn-link">Back To Sales Unit</a></h3>
                        <hr>
                        <div class="col-md-7 general-white">
                            <br>
                            <h4>Information:</h4>
                            <table class="table custom-table">
                                <tr>
                                    <th>Sale Unit:</th>
                                    <td><?php echo $unit->unit_type; ?></td>
                                </tr>
                                <tr>
                                    <th>Floor:</th>
                                    <td><?php echo $unit->floor_types; ?></td>
                                </tr>
                                <tr>
                                    <th>Area Size (Square Feet)</th>
                                    <td><?php echo $unit->size; ?></td>
                                </tr>
                                <tr>
                                    <th>Price Per Square Feet</th>
                                    <td><?php echo 'Rs.'.$unit->price_sqft; ?></td>
                                </tr>
                                <tr>
                                    <th>Total Price:</th>
                                    <td><?php echo 'Rs.'.$unit->size * $unit->price_sqft; ?></td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-4 col-md-offset-1 general-white">
                            <br>
                            <h4>Project Information:</h4>
                            <table class="table custom-table">
                                <tr>
                                    <th>Project Name:</th>
                                    <td><?php echo $unit->project_name; ?></td>
                                </tr>
                                <tr>
                                    <th>Project Location:</th>
                                    <td><?php echo $unit->project_location; ?></td>
                                </tr>
                                <tr>
                                    <th>Project Start Date</th>
                                    <td><?php echo date("d M Y",strtotime($unit->starting_date)); ?></td>
                                </tr>
                                <tr>
                                    <th>Project End Date (Expected):</th>
                                    <td><?php echo date("d M Y",strtotime($unit->expected_end)); ?></td>
                                </tr>
                            </table>
                        </div>
                    <?php endforeach; ?>  
                </div>                
            </div>
        </div>
    </div>
    <!-- END PRELOADS -->  
    <!-- Performing Edit/ View -->
    <?php $this->load->view('./incs/jquery-footer') ?>  
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>   

    <script>
    // Upload Area For Architeture Files Uploading
    $('#uploadMapFiles').hide();
    function ShowUploadArea()
    {
        $('#uploadMapFiles').toggle();
    }
    // 
    $('#unitsize').keyup(function() {
        size  = parseFloat($(this).val());
        price = parseFloat($('#persquare').val());
        total = size * 24 * price;
        $('#total_price').val(total);
    });

    $('#persquare').keyup(function() {
        price  = parseFloat($(this).val());
        size = parseFloat($('#unitsize').val());
        total = size * 24 * price;
        $('#total_price').val(total);
    });

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
        "ajax": "<?php echo base_url('Units/getAllUnits') ?>",
        "columns": [
        { "data": "1" },
        { "data": "2" },
        { "data": "7" },
        { "data": "3" },
        { "data": "4" },
        { "data": "5" },
        { "data": "8" },
        { "data": "9" }
        ]
    });
}

function resetTable()
{
    $("#example").dataTable().fnDestroy();
    loadDataintoTable();
}

function getFloors(id)
{
    console.log(id);
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
</script>
</body>
</html>






