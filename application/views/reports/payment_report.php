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
                                <h3 class="text-center">RECEIVING REPORT</h3>  
                                       <table class="table heading-table">
                                        <tbody><tr>
                                            <th>Receipt #:</th>
                                            <td>Unknown</td>
                                        </tr>
                                        <tr>
                                                <th>Applicable Date:</th>
                                            <td><?= date('d-F-Y'); ?></td>
                                        </tr>
                                    </tbody></table>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table half-table">
                                        <h3 class="text-center">
                                            PARTICULARS
                                        </h3>
                                        <tbody>
                                        <tr>
                                            <th>Floor #:</th>
                                            <td><?= $sale['floor_types']; ?></td>
                                            <th>Payment Plan:</th>
                                            <td><?= $sale['installments']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Type:</th>
                                            <td><?= ucfirst($sale['type']); ?></td>
                                            <th>Down Payment %age:</th>
                                            <td><?php $down_payment_per = $sale['down_payment'] / $sale['total_payment'] * 100;
                                                        echo number_format($down_payment_per, 3). '%';
                                            ?></td>
                                        </tr>
                                         <tr>
                                            <th>Unit Number:</th>
                                            <td><?= $sale['shopID']; ?></td>
                                            <th>Installment Plan:</th>
                                            <td>Quarterly</td>
                                        </tr>
                                        <tr>
                                            <th>Size (Sq. Ft):</th>
                                            <td><?= $sale['size_sqft']; ?></td>
                                            <th>Down Payment:</th>
                                            <td><?= $sale['down_payment']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Rate (Per Sq. Ft):</th>
                                            <td><?= $sale['shop_price_sqft'] == '' ? $sale['price_sqft'] : $sale['shop_price_sqft']; ?></td>
                                            <th>Token Received:</th>
                                            <td><?= $sale['token_money']; ?></td>
                                        </tr>
                                         <tr>
                                            <th>Total Price:</th>
                                            <td><?= $sale['total_payment']; ?></td>
                                            <th>Full Pyament:</th>
                                            <td><?= $sale['total_paid'] + $sale['down_payment'] + $sale['token_money']; ?></td>
                                        </tr>
                                         <tr>
                                            <th>Applicable Rate (Per Sq. Ft.):</th>
                                            <td><?= $sale['shop_price_sqft'] == '' ? $sale['price_sqft'] : $sale['shop_price_sqft']; ?></td>
                                            <th>Down Payment Received:</th>
                                            <td><?= $sale['recieved_downpayment'] == 0 ? 'Not Received' : 'Received'; ?></td>
                                        </tr>
                                         <tr>
                                            <th></th><td></td>
                                            <th>Applicable Price:</th>
                                            <td><?= $sale['total_payment']; ?></td>
                                            
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <td></td>
                                            <th>Installment Amount:</th>
                                            <td><?= $sale['total_installment_amount']; ?></td>
                                        </tr>
                                        
                                    </tbody></table>
                                </div>
                                <div class="col-md-12">
                                    <table class="table half-table">
                                        <h3 class="text-center">
                                            DISCOUNTS AND FINAL PRICES
                                        </h3>
                                        <tbody>
                                        <tr>
                                            <th colspan="2">DISCOUNT</th><th colspan="2">FINAL PRICES</th>
                                        </tr>
                                        <tr>
                                            <th>Discount To:</th>
                                            <td><?= ucfirst($sale['client']); ?></td>
                                            <th>Total Price:</th>
                                            <td><?= $sale['total_payment']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Discount Category:</th>
                                            <td>Over all</td>
                                            <th>Discount:</th>
                                            <td><?= $sale['discount']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Discount Amount:</th>
                                            <td><?= $sale['discount']; ?></td>
                                            <th>Applicable Price:</th>
                                            <td><?= $sale['total_payment']; ?></td>
                                        </tr>
                                         <tr>
                                            <th>Discount %age:</th>
                                            <td><?php $discount_per = $sale['discount'] / $sale['total_payment'] * 100;
                                                        echo number_format($discount_per, 3). '%';
                                            ?>
                                            </td>
                                            <th>Applicable Rate(Per Sq. Ft.):</th>
                                            <td><?= $sale['pricesqft']; ?></td>
                                        </tr>
                                    </tbody></table>
                                </div>

                            </div>
                            <div class="row">
                                 <div class="col-md-12">
                                    <table class="table">
                                        <h3 class="text-center">
                                            PAYMENT DETAILS
                                        </h3>
                                        <tbody>
                                       
                                        <tr>
                                            <th>Payment for</th>
                                            <th>Mode of Payment</th>
                                            <th>Bank</th>
                                            <th>Cheque. No.</th>
                                            <th>Date</th>
                                            <th>Currency</th>
                                            <th>Amount</th>
                                            <th>Paid</th>
                                            <th>Comments</th>
                                        </tr>
                                      
                                        <?php $CI =& get_instance(); 
                                                $payments = $CI->get_payment_method($sale['sale_id']);
                                            if ($payments[0]) : 
                                        ?>
                                        <tr>
                                            <td><?= ucfirst($payments[0]['pay_for']); ?></td>
                                            <td><?= ucfirst($payments[0]['method']); ?></td>
                                            <td><?= ucfirst($payments[0]['bank']); ?></td>
                                            <td><?= $payments[0]['cheque']; ?></td>
                                            <td><?= date('d-F-Y', strtotime($payment['date'])); ?></td>
                                            <td>PKR</td>
                                            <td><?= $payments[0]['down_payment']; ?></td>
                                            <td><?= $payments[0]['down_payment']; ?></td>
                                            <td><?= $payments[0]['note']; ?></td>
                                        </tr>
                                    <?php endif;
                                            if ($payments[1]) : ?>
                                         <tr>
                                            <td><?= ucfirst($payments[1]['pay_for']); ?></td>
                                            <td><?= ucfirst($payments[1]['method']); ?></td>
                                            <td><?= ucfirst($payments[1]['bank']); ?></td>
                                            <td><?= $payments[1]['cheque']; ?></td>
                                            <td><?= date('d-F-Y', strtotime($payments['date'])); ?></td>
                                            <td>PKR</td>
                                            <td><?= $payments[1]['token_money']; ?></td>
                                            <td><?= $payments[1]['token_money']; ?></td>
                                            <td><?= $payments[1]['note']; ?></td>
                                        </tr>

                                    <?php
                                        endif;

                                        foreach ($installments as $installment) :  
                                       ?>
                                        <tr>
                                            <td><?= ucfirst($installment['pay_for']); ?></td>
                                            <td><?= ucfirst($installment['method']); ?></td>
                                            <td><?= ucfirst($installment['bank']); ?></td>
                                            <td><?= $installment['cheque']; ?></td>
                                            <td><?= date('d-F-Y', strtotime($installment['date'])); ?></td>
                                            <td>PKR</td>
                                            <td><?= $installment['amount']; ?></td>
                                            <td><?= $installment['paid']; ?></td>
                                            <td><?= $installment['note']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    
                                    </tbody></table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table bottom-table">
                      
                                        <tbody>
                                        <tr>
                                            <th>Advisor Name:</th>
                                            <td colspan="2">.............................</td>
                                            <th>Agent Name:</th>
                                            <td colspan="2">.............................</td>
                                            <th>Purchaser Name:</th>
                                            <td><?= ucfirst($sale['client']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Advisor CNIC:</th>
                                            <td colspan="2">............................</td>
                                            <th>Agent CNIC:</th>
                                            <td colspan="2">............................</td>
                                            <th>Purchaser CNIC:</th>
                                            <td>............................</td>
                                        </tr>
                                        <tr>
                                            <th>Advisor Signature:</th>
                                            <td colspan="2">............................</td>
                                            <th>Agent Signature:</th>
                                            <td colspan="2">............................</td>
                                            <th>Purchaser Signature:</th>
                                            <td>............................</td>

                                        </tr>
                                        <tr><td colspan="6"></td>
                                            <th>Seller Name: </th>
                                            <td>............................</td>
                                            
                                        </tr>
                                        <tr><td colspan="6"></td>
                                            <th>Seller CNIC: </th>
                                            <td>............................</td>
                                            
                                        </tr>
                                        <tr><td colspan="6"></td>
                                            <th>Seller Signature: </th>
                                            <td>............................</td>
                                            
                                        </tr>
                                        </tbody>
                                    </table>
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
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>    
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/bootstrap/bootstrap-select.js"></script>
    <script>
        $(document).ready(function (e) {
            $("#Report").on('submit',(function(e) {
              e.preventDefault();
              $.ajax({
                url: "<?php echo base_url(); ?>Reports/ClientDetails",
                type: "POST",             
                data: new FormData(this), 
                contentType: false,       
                cache: false,             
                processData:false,        
                success: function(res)  
                {
                    $('#resultReports').html(res);
                }
            });
          }));
        });
      
    </script>
</body>
</html>






