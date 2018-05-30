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
                                <h3 class="text-center">TODAY SALES</h3>  
                                       
                                        <tbody><tr>
                                            <th>Project</th>
                                            <th>Floor</th>
                                            <th>Unit</th>
                                            <th>Client</th>
                                            <th>Area Size</th>
                                            <th>Total Price</th>
                                        </tr>
                                        <?php foreach ($sales as $sale): ?>
                                            <tr>
                                                <td><?= ucfirst($sale['project_name']); ?></td>
                                                <td><?= ucfirst($sale['floor_types']); ?></td>
                                                <td><?= ucfirst($sale['unit_type']); ?></td>
                                                <td><?= ucfirst($sale['fullname']); ?></td>
                                                <td><?= $sale['unit_size'] . ' sqft'; ?></td>
                                                <td><?= $sale['unit_price'] ==  0 ? $sale['price_sqft'] * $sale['unit_size'] : $sale['unit_size'] * $sale['unit_price']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody></table>
                                </div>
                            </div>
                            <div class="row">
                                <!-- today transactions -->
                                  <div class="col-md-12">
                                    <table class="table half-table">
                                        <h3 class="text-center">
                                            TODAY TRANSACTIONS
                                        </h3>
                                        <tbody>
                                        <tr>
                                            <th>Project</th>
                                            <th>Floor</th>
                                            <th>Unit</th>
                                            <th>Client</th>
                                            <th>Area Size</th>
                                            <th>Pay For</th>
                                            <th>Payment Method</th>
                                            <th>Bank</th>
                                            <th>Check</th>
                                            <th>Branch</th>
                                            <th>Amount</th>
                                        </tr>
                                        <?php foreach ($installments as $installment) : ?>
                                        <tr>
                                            <td><?= ucfirst($installment['project_name']); ?></td>
                                            <td><?= ucfirst($installment['floor_types']); ?></td>
                                            <td><?= ucfirst($installment['unit_type']); ?></td>
                                            <td><?= ucfirst($installment['fullname']); ?></td>
                                            <td><?= $installment['unit_size'] . ' sqft'; ?></td>
                                            <td><?= ucfirst($installment['pay_for']); ?></td>
                                            <td><?= ucfirst($installment['method']); ?></td>
                                            <td><?= ucfirst($installment['bank']); ?></td>
                                            <td><?= ucfirst($installment['check']); ?></td>
                                            <td><?= ucfirst($installment['branck']); ?></td>
                                            <td><?= ucfirst($installment['paid']); ?></td>
                                            
                                        </tr>
                                        <?php endforeach; ?> 
                                        <?php if ( ! empty($token)) : ?>
                                        <tr>
                                            <td><?= ucfirst($token['project_name']); ?></td>
                                            <td><?= ucfirst($token['floor_types']); ?></td>
                                            <td><?= ucfirst($token['unit_type']); ?></td>
                                            <td><?= ucfirst($token['fullname']); ?></td>
                                            <td><?= $token['unit_size'] . ' sqft'; ?></td>
                                            <td><?= ucfirst($token['pay_for']); ?></td>
                                            <td><?= ucfirst($token['method']); ?></td>
                                            <td><?= ucfirst($token['bank']); ?></td>
                                            <td><?= ucfirst($token['check']); ?></td>
                                            <td><?= ucfirst($token['branck']); ?></td>
                                            <td><?= ucfirst($token['token_money']); ?></td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if ( ! empty($downpayment)) : ?>
                                        <tr>
                                            <td><?= ucfirst($downpayment['project_name']); ?></td>
                                            <td><?= ucfirst($downpayment['floor_types']); ?></td>
                                            <td><?= ucfirst($downpayment['unit_type']); ?></td>
                                            <td><?= ucfirst($downpayment['fullname']); ?></td>
                                            <td><?= $downpayment['unit_size'] . ' sqft'; ?></td>
                                            <td><?= ucfirst($downpayment['pay_for']); ?></td>
                                            <td><?= ucfirst($downpayment['method']); ?></td>
                                            <td><?= ucfirst($downpayment['bank']); ?></td>
                                            <td><?= ucfirst($downpayment['check']); ?></td>
                                            <td><?= ucfirst($downpayment['branck']); ?></td>
                                            <td><?= ucfirst($downpayment['down_payment']); ?></td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody></table>
                                </div>
                                <div class="col-md-12">
                                    <table class="table half-table">
                                        <h3 class="text-center">
                                            TODAY TRANSFERED
                                        </h3>
                                        <tbody>
                                        <tr>
                                            <th>Project</th>
                                            <th>Floor</th>
                                            <th>Unit</th>
                                            <th>From Client</th>
                                            <th>To Client</th>
                                            <th>Area Size</th>
                                            <th>Total Price</th>
                                            <th>Transfered Fee</th>
                                        </tr>
                                        <?php foreach ($resales as $resale) : ?>
                                        <tr>
                                            <td><?= ucfirst($resale['project_name']); ?></td>
                                            <td><?= ucfirst($resale['floor_types']); ?></td>
                                            <td><?= ucfirst($resale['unit_type']); ?></td>
                                            <td><?= ucfirst($resale['from_user']); ?></td>
                                            <td><?= ucfirst($resale['to_user']); ?></td>
                                            <td><?= $sale['unit_size'] . ' sqft'; ?></td>
                                            <td><?= $sale['unit_price'] ==  0 ? $sale['price_sqft'] * $sale['unit_size'] : $sale['unit_size'] * $sale['unit_price']; ?></td>
                                            <td><?= ucfirst($resale['transfer_fee']); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody></table>
                                </div>
                                <div class="col-md-12">
                                    <table class="table half-table">
                                        <h3 class="text-center">
                                            TODAY BUY BACKS
                                        </h3>
                                        <tbody>

                                        <tr>
                                            <th>Project</th>
                                            <th>Floor</th>
                                            <th>Unit</th>
                                            <th>From Client</th>
                                            <th>Area Size</th>
                                            <th>Total Price</th>
                                            <th>Amount</th>
                                        </tr>
                                     <?php foreach ($buy_backes as $buy_back) : ?>
                                         <tr>
                                            <td><?= ucfirst($buy_back['project_name']); ?></td>
                                            <td><?= ucfirst($buy_back['floor_types']); ?></td>
                                            <td><?= ucfirst($buy_back['unit_type']); ?></td>
                                            <td><?= ucfirst($buy_back['from_user']); ?></td>
                                            <td><?= $sale['unit_size'] . ' sqft'; ?></td>
                                            <td><?= $sale['unit_price'] ==  0 ? $sale['price_sqft'] * $sale['unit_size'] : $sale['unit_size'] * $sale['unit_price']; ?></td>
                                            <td><?= ucfirst($buy_back['amount']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody></table>
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






