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
        <!-- PAGE CONTENT -->
        <div class="page-content">
            <?php $this->load->view('./incs/header_topbar.php') ?>
            <div class="page-content-wrap">                
                <div class="row">
                    <div class="col-md-12 mar-2">
                        <div class="col-md-8" id="forTackback" style="display: none;">
                            <div class="panel panel-danger">
                                <div class="panel-body">
                                    <h4>Take Back Money</h4>
                                    <div class="col-md-6">
                                        <div id="TakeBackReport"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <form id="TakeBAckMoney">
                                            <div class="form-group">
                                                <label for="">Payment Method</label>
                                                <select name="paid_by" id="token_pay" class="form-control" onchange="ShowOthers($(this).val())" id="" required>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Bank">Bank</option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="token_bank" style="display: none;">
                                                <label for="">Bank Name</label>
                                                <input type="text"  class="form-control" name="bankname">
                                            </div>
                                            <div class="form-group" id="token_branch"  style="display: none;">
                                                <label for="">Bank Branch</label>
                                                <input type="text"  class="form-control" name="bankbranch">
                                            </div>
                                            <input type="hidden" name="saleid" id="SaleID" value="">
                                            <input type="hidden" name="userid" id="UserID" value="">
                                            <div class="form-group" id="token_cheque"  style="display: none;">
                                                <label for="">Cheque no</label>
                                                <input type="text" class="form-control" name="chequeno">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Notes</label>
                                                <textarea class="form-control" name="note" required cols="30" rows="5"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Amount</label>
                                                <input type="text" value="" class="form-control" name="token_money" required>
                                                <br>
                                                <input type="submit" class="btn btn-primary" value="Pay Amount">
                                                <input type="button" id="cancelTakeBack" class="btn btn-primary cancel" value="Cancel">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- for transfere -->
                        <?php include_once('transfere.php'); ?>
                        <!-- end transfere form -->
                        <!-- START DEFAULT DATATABLE -->
                        <div class="panel panel-default" id="sales">
                            <div class="panel-heading">                                
                                <h3 class="panel-title">Sales</h3>
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
                "ajax": "<?php echo base_url('Sales/getAllResales') ?>",
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



</script>
</body>
</html>