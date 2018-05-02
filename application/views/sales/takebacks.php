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
                    <div class="col-md-12 mar-2">

                        <!-- START DEFAULT DATATABLE -->
                        <div class="panel panel-default">
                            <div class="panel-heading">                                
                                <h3 class="panel-title">Take Backs</h3>
                            </div>
                            <div class="panel-body">
                                <table id="example" class="display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>View Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach ($tackback as $one): ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $one->type; ?></td>
                                            <td><?php echo $one->amount; ?></td>
                                            <td><?php echo $one->created_at;?></td>
                                            <td><a href="#" class="btn btn-success">View Details</a></td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
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
</div>
<!-- END PRELOADS -->  
<?php $this->load->view('incs/jquery-footer') ?>  
<script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>    
</body>
</html>






