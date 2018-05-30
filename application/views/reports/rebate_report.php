<?php $this->load->view('./incs/header.php') ?> 
<?php //print_R($installments); exit; ?>
<body>
    <style>
        h3, h4 {
        background: #e5e5e5;
        line-height: 40px;
        padding-left: 10px;
    }
    caption {
        background: #e5e5e5;
        line-height: 20px;
        padding-left: 10px;
    }
    .heading-table {
        width: 20%;
    }
    .heading-table > tbody > tr > th,.heading-table > tbody > tr > td {
        border-width: 0px;
    }
    .bottom-table > tbody > tr > th,.bottom-table > tbody > tr > td{
        border-width: 0px;
    }
  
    </style>
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
                            <div class="panel-body">
                            <div class="col-md-12">
                                <!-- START VERTICAL TABS -->
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                
                                <table class="table">
                                <h3 class="text-center">Rebates</h3>  
                                       
                                        <tbody><tr>
                                            <th>Project</th>
                                            <th>Floor</th>
                                            <th>Unit</th>
                                            <th>Client</th>
                                            <th>Agent</th>
                                            <th>Area Size</th>
                                            <th>Total Price</th>
                                            <th>Commission Title</th>
                                            <th>Commission Percentage</th>
                                            <th>From Date</th>
                                            <th>To Date</th>
                                        </tr>
                                        <?php foreach ($rebates as $rebate): ?>
                                            <tr>
                                                <td><?= ucfirst($rebate['project_name']); ?></td>
                                                <td><?= ucfirst($rebate['floor_types']); ?></td>
                                                <td><?= ucfirst($rebate['unit_type']); ?></td>
                                                <td><?= ucfirst($rebate['client']); ?></td>
                                                <td><?= ucfirst($rebate['agent']); ?></td>
                                                <td><?= $rebate['unit_size'] . ' sqft'; ?></td>
                                                <td><?= $rebate['unit_price'] ==  0 ? $rebate['price_sqft'] * $rebate['unit_size'] : $rebate['unit_size'] * $rebate['unit_price']; ?></td>
                                                <td><?= ucfirst($rebate['commission_title']); ?></td>
                                                <td><?= $rebate['commission_percentage'] . ' per'; ?></td>
                                                <td><?= $rebate['from_date']; ?></td>
                                                <td><?= $rebate['to_date']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody></table>
                                </div>
                            </div>
                         
                          
                 

                            </div>
                      
                          
                                <!-- END VERTICAL TABS -->
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
    <?php $this->load->view('./incs/jquery-footer') ?>  

</body>
</html>






