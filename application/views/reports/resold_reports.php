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
                    <li class="active">CIF</li>
                </ul>
               
                <div class="col-md-12" id="AllDataForms">
                    <!-- Customer Editing -->
                    
                  
                    <div class="clearfix"></div>
           

                    <div id="SearchUnitDisplay" style="margin-top: 1em;" >
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <h3>Search Unit</h3>
                                    <form id="resale_search_form" action="<?= base_url(); ?>Reports/get_resales">
                                        <div class="col-md-4">
                                            <label class="control-label">Project</label>
                                            <select class="form-control select" data-live-search="true" onchange="getsearchFloors($(this).val())" tabindex="1" id="project_type">
                                                <option>Select Project</option>
                                                <?php if (!empty($project)): ?>
                                                    <?php foreach ($project as $pro): ?>
                                                        <option value="<?php echo $pro->project_id;?>"><?php echo $pro->project_name; ?></option>
                                                    <?php endforeach ?>
                                                <?php endif ?>  
                                            </select>
                                        </div>

                                        <div id="getSearchfloors"></div>
                                        <div id="getSearchUnits"></div>
                                        <div class="clearfix"></div>
                                        <br>
                                        <!-- Search Result -->
                                        <div id="searchResult"></div>
                                        <!-- Search Result End -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
              
            
                </div>  
                  <div class="row" id="resales" style="display: none;">
                    <div class="col-md-12 mar-2">
                 

                        <!-- for transfere -->
                        <!-- end transfere form -->
                        <!-- START DEFAULT DATATABLE -->
                        <div class="panel panel-default" id="sales">
                            <div class="panel-heading">                                
                                <h3 class="panel-title">Resales</h3>
                            </div>
                            <div class="panel-body">
                                <div class="clearfix"></div>
                                <table id="example" class="display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Project</th>
                                            <th>Location</th>
                                            <th>Floor</th>
                                            <th>Sale Unit</th>
                                            <th>Client</th>
                                            <th>Contact #</th>
                                            <th>Area Size</th>
                                            <th>Total Price</th>
                                            <th>Downpayment</th>
                                            <th>Transfered Fee</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <!-- END DEFAULT DATATABLE -->
                    </div>
                </div>               
            </div>
        </div>
    </div>

    <!-- END PRELOADS -->  
    <!-- Performing Edit/ View -->
    <?php $this->load->view('./incs/jquery-footer') ?>  
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>   
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/bootstrap/bootstrap-select.js"></script>
    
    <script>


    function SaleUnit(id) {
        $('#clientid').val(id);
        $('#SearchUnitDisplay').toggle();   
    }

    // Search Unit Result
    function SearchUnits(floor) {
        project = $('#project_type').val();
        $.ajax({
            url: '<?php echo base_url("Cif/getsearchUnits") ?>',
            type: 'POST',
            data: {floor:floor,project:project},
        })
        .done(function(response) {
            if (response == false) {
                show_space_filter_result();
                $('#search_unit').remove();
            } else {
                $('#searchResult').html(response);
                $('#unit_type').selectpicker('render');
            }
            
        });
    }

    // show filter btn for resold
    function show_filter_result() {
        var project_id = $('#project_type').val();
        var floor_id = $('#floor_type').val();
        var unit_id = $('#unit_type').val();
       // $('#filter').remove();
       // $('#searchResult').after('<div class="col-md-2" id="filter"><label for=""></label>' + '<input style="margin-top: 20px;" type="submit" class="btn btn-info" value="Filter"></div>');
        $("#example").dataTable().fnDestroy();
        $('#example').DataTable({
                "order": [[ 0, "desc" ]],
                "ajax": "<?php echo base_url('Sales/getAllResales/') ?>" + project_id + '/' + floor_id + '/' + unit_id,
                "columns": [
                { "data": "11" },
                { "data": "0" },
                { "data": "1" },
                { "data": "2" },
                { "data": "3" },
                { "data": "4" },
                { "data": "6" },
                { "data": "7" },
                { "data": "8" },
                { "data": "12" },
                { "data": "13" }
                ]
            });
        $('#resales').css('display', 'block');
    }

      // show filter btn for resold
    function show_space_filter_result() {
        var project_id = $('#project_type').val();
        var floor_id = $('#floor_type').val();
        var unit_id = $('#unit_type').val();
       // $('#filter').remove();
       // $('#searchResult').after('<div class="col-md-2" id="filter"><label for=""></label>' + '<input style="margin-top: 20px;" type="submit" class="btn btn-info" value="Filter"></div>');
        $("#example").dataTable().fnDestroy();
        $('#example').DataTable({
                "order": [[ 0, "desc" ]],
                "ajax": "<?php echo base_url('Sales/getAllResales/') ?>" + project_id + '/' + floor_id + '/' + 0,
                "columns": [
                { "data": "11" },
                { "data": "0" },
                { "data": "1" },
                { "data": "2" },
                { "data": "3" },
                { "data": "4" },
                { "data": "6" },
                { "data": "7" },
                { "data": "8" },
                { "data": "12" }
                ]
            });
        $('#resales').css('display', 'block');
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
    $('#SearchDisplay').click(function() {
        $('#SearchUnitDisplay').toggle();
    });

    function getsearchFloors(id)
    {
        $.post('<?php echo base_url('Cif/getsearchFloors') ?>', {id:id}, function(data, textStatus, xhr) {
            $('#getSearchfloors').html(data);
            $('#floor_type').selectpicker('render');
        });
        
    }

</script>

</body>
</html>






