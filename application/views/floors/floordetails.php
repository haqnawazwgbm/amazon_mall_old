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
                        <div id="loadData"></div>
                        
                        <!-- START DEFAULT DATATABLE -->
                        <div class="panel panel-default">
                            <div class="panel-heading">                                
                                <h3 class="panel-title">Floor Details</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Floor Name</th>
                                        <th>Floor Size</th>
                                        <th>Project Name</th>
                                        <th>Project Location</th>
                                        <th>Date Added</th>
                                    </tr>
                                    <?php if (!empty($floor)): ?>
                                        <?php foreach ($floor as $sim): ?>
                                            <tr>
                                                <td><?php echo $sim->floor_types; ?></td>
                                                <td><?php echo $sim->one; ?></td>
                                                <td><?php echo $sim->project_name; ?></td>
                                                <td><?php echo $sim->project_location; ?></td>
                                                <td><?php echo date("d M Y h:i a",strtotime($sim->created_at)); ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </table>
                                <br><br>
                                <h4>Floor Sale Units</h4>
                                <div class="col-md-8">
                                    <table id="example" class="display table-striped" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Unit</th>
                                                <th>Unit Size/Square Feet </th>
                                                <th>Price/Square Feet</th>
                                                <th>Total Price</th>
                                            </tr>
                                            <?php if ($units): ?>
                                                <?php $i =1; foreach ($units as $each): ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $each->unit_type; ?></td>
                                                        <td><?php echo $each->size; ?></td>
                                                        <td><?php echo 'Rs.'.number_format($each->one,2,'.',','); ?></td>
                                                        <td><?php  $total = $each->size * $each->one; echo 'Rs.'.number_format($total,2,'.',','); ?></td>
                                                    </tr>
                                                <?php $i++; endforeach ?>
                                            <?php endif ?>
                                            <tr></tr>
                                        </thead>
                                    </table>
                                </div>
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

    <!-- Modal -->
  
    </div>
    <!-- END PRELOADS -->  
    <!-- Performing Edit/ View -->
    <?php $this->load->view('./incs/jquery-footer') ?>  
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>    
   
</body>
</html>






