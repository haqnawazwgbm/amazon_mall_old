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
                <ul class="breadcrumb">
                    <li><a href="<?php echo base_url('Master/dashboard');?>">Home</a></li>
                    <li class="active"><a href="<?php echo base_url('Sales') ?>">Sales</a></li>
                </ul>
                <br><br>
                <div class="row">
                    <div class="col-md-12 mar-2">
                        <!-- START DEFAULT DATATABLE -->
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div>
                                    <h3>Payments</h3>
                                    <div id="payment-receiving"></div>
                                </div>  
                                <div class="clearfix"></div>
                                <hr> 
                                <div>
                                    <h3>Installments Plan</h3>
                                    <div id="installments"></div>
                                </div>
                                <div class="clearfix"></div>
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
<?php $this->load->view('./incs/jquery-footer') ?>  
<script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>    
<script>
    installments();
    function installments()
    {
        $.post('<?php echo base_url('Sales/Installments') ?>', {id:<?php echo $this->uri->segment(3) ?>}, function(data, textStatus, xhr) {
            $('#installments').html(data);
        });
    }
    initialpayments();
    function initialpayments()
    {
        $.post('<?php echo base_url('Sales/InitialPayments/space') ?>', {id:<?php echo $this->uri->segment(3) ?>}, function(data, textStatus, xhr) {
            $('#payment-receiving').html(data);
        });
    }
    function ShowOthers(id)
    {
        if (id == "Bank") 
        {
            $('#token_cheque').show();
            $('#token_bank').show();  
            $('#token_branch').show();  
        }
        else
        {
            $('#token_cheque').hide();
            $('#token_bank').hide();  
            $('#token_branch').hide();  
        }
        
    }
     function ShowDown(id)
    {
        if (id == "Bank") 
        {
            $('#down_cheque').show();
            $('#down_bank').show();  
            $('#down_branch').show();  
        }
        else
        {
            $('#down_cheque').hide();
            $('#down_bank').hide();  
            $('#down_branch').hide();  
        }
        
    }
    function Recieve(id,pre,amount,method,state) {
        if (confirm('Are You Sure To Update Information?')) 
        {
            if (state == 'Down') 
            {
                if (method == "Bank") 
                {
                    sendData = {
                        id:id,
                        pre:pre,
                        amount:amount,
                        state:state,
                        method: method,
                        bankname: $('#down_bankname').val(),
                        branch: $('#down_bankbranch').val(),
                        cheque: $('#down_chequeno').val(),
                        note: $('#downnote').val()

                    };
                }
                else
                {
                    sendData = {
                        id:id,
                        pre:pre,
                        amount:amount,
                        state:state,
                        method: method,
                        note: $('#downnote').val()
                    };  
                }
                
            }
            else
            {
                if (method == "Bank") 
                {
                    sendData = {
                        id:id,
                        pre:pre,
                        amount:amount,
                        state:state,
                        method: method,
                        bankname: $('#cash_bankname').val(),
                        branch: $('#cash_bankbranch').val(),
                        cheque: $('#cash_chequeno').val(),
                        note: $('#tokennote').val()
                    };
                }
                else
                {
                    sendData = {
                        id:id,
                        pre:pre,
                        amount:amount,
                        state:state,
                        method: method,
                        note: $('#tokennote').val()
                    };  
                }
            }
             
             $.post('<?php echo base_url('Sales/RecieveToken');?>', sendData, function(response) 
             {
                initialpayments();
                installments();
             });
        }
    }

    function ReceiveInstallment(method,id,saleid,amount,previous) {
        if (confirm('Are You Sure To Update Information?')) 
        {
             if (method == "Bank") 
                {
                    sendData = {
                        id:id,
                        saleid:saleid,
                        amount:amount,
                        previous:previous,
                        method: method,
                        bankname: $('#inst_bankname'+id).val(),
                        branch: $('#inst_bankbranch'+id).val(),
                        cheque: $('#inst_chequeno'+id).val(),
                        note: $('#note'+id).val()
                    };
                }
                else
                {
                    sendData = {
                        id:id,
                        saleid:saleid,
                        amount:amount,
                        previous:previous,
                        method: method,
                        note: $('#note'+id).val()
                    };  
                }
            $.post('<?php echo base_url('Sales/ReceiveInstallment');?>', sendData, function(response) 
            {
                installments();
            });
        }
    }

</script>
</body>
</html>






