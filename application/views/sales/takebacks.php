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
            <?php $this->load->view('./incs/header_topbar.php') ?>
            <?php include_once('upload_area.php'); ?>
            <div class="page-content-wrap">                
                <div class="row">
                    <div class="col-md-12 mar-2">
                     
                       

                        <!-- for transfere -->
                        <!-- end transfere form -->
                        <!-- START DEFAULT DATATABLE -->
                        <div class="panel panel-default" id="sales">
                            <div class="panel-heading">                                
                                <h3 class="panel-title">Buy Backs</h3>
                            </div>
                            <div class="panel-body">
                                <div class="clearfix"></div>
                                <table id="example" class="display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Buyback Date</th>
                                            <th>Buyback Amount</th>
                                            <th>Project</th>
                                            <th>Location</th>
                                            <th>Floor</th>
                                            <th>Sale Unit</th>
                                            <th>Client</th>
                                            <th>Contact #</th>
                                            <th>Area Size</th>
                                            <th>Total Price</th>
                                            <th>Downpayment</th>
                                        </tr>
                                        <?php foreach ($takebacks as $takeback) : ?>
                                            <tr>
                                                <td><?= date('Y-m-d', strtotime($takeback['created_at'])); ?></td>
                                                <td><?= $takeback['amount']; ?></td>
                                                <td><?= $takeback['project_name']; ?></td>
                                                <td><?= $takeback['project_location']; ?></td>
                                                <td><?= $takeback['floor_types']; ?></td>
                                                <td><?= $takeback['unit_type']; ?></td>
                                                <td><?= $takeback['fullname']; ?></td>
                                                <td><?= $takeback['phone']; ?></td>
                                                <td><?= $takeback['totalarea'].'sqft'; ?></td>
                                                <td><?= 'Rs: '.$takeback['totalarea'] * $takeback['pricesqft']; ?></td>
                                                <td><?= $takeback['down_payment']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
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
   <div id="load_sale_form"></div>
   <div id="load_installment_form"></div>
    <?php $this->load->view('./incs/jquery-footer') ?>  
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>    

</body>
</html>