<?php $this->load->view('./incs/header.php');
$type = $this->session->userdata('user_type'); ?> 
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
        <!-- PAGE CONTENT -->
        <div class="page-content">
            <?php $this->load->view('./incs/header_topbar.php'); ?>
      
                        <!-- START DEFAULT DATATABLE -->
                        <div class="panel panel-default" id="sales">
                            <div class="panel-heading">            
                            <button onclick="deleteShop(<?= $this->uri->segment(3); ?>)" class="btn btn-danger pull-right">Confirm detetion</button>                    
                                <h3 class="panel-title">Related Sales</h3>
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

    <?php $this->load->view('./incs/jquery-footer') ?>  
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>    
    <script>
        loadDataintoTable();
        function loadDataintoTable()
        {

            $('#example').DataTable({
                "order": [[ 0, "desc" ]],
                "ajax": "<?php echo base_url('Units/get_sales_by_unit/').$this->uri->segment(3) ?>",
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
        }

        function resetTable()
        {
            $("#example").dataTable().fnDestroy();
            loadDataintoTable();
        }
        function deleteShop(unit_id) {
            if(confirm("Are you sure to delete this shop with related sales?")) {
                 $.post('<?php echo base_url('Units/delete') ?>', {unit_id:unit_id}, function(response, textStatus, xhr) {
                    resetTable();
                    noty({text: response.message, layout: 'topRight', type: response.param});
                });
            }
        }

</script>
</body>
</html>