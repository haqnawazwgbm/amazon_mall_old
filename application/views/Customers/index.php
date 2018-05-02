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
                        <div class="panel panel-default">
                        <div class="panel-heading">                                
                            <h3 class="panel-title">Units Purchased</h3>
                        </div>
                        <div class="panel-body" id="unit-details">
                            <table id="example" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S.no</th>
                                        <th>Project Name</th>
                                        <th>Project Location</th>
                                        <th>Sale Unit</th>
                                        <th>Floor </th>
                                        <th>Size/Sqft</th>
                                        <th>Total Price</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

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

<!-- END PRELOADS -->  
<!-- Performing Edit/ View -->

<?php $this->load->view('./incs/jquery-footer') ?>  
<script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>    
<script>
        <?php $id = $this->uri->segment(3); ?>
        loadDataintoTable();
        function loadDataintoTable()
        {
            $('#example').DataTable({
                "order": [[ 3, "desc" ]],
                "ajax": "<?php echo base_url('Customers/userPurchases/') ?>",
                "columns": [
                { "data": "9" },
                { "data": "1" },
                { "data": "5" },
                { "data": "7" },
                { "data": "2" },
                { "data": "3" },
                { "data": "4" },
                { "data": "6" },
                { "data": "8" }
                ]
            });
        }

        function resetTable()
        {
            $("#example").dataTable().fnDestroy();
            loadDataintoTable();
        }
    </script>
</body>
</html>






5t