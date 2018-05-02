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
                        <!-- START DEFAULT DATATABLE -->
                        <div class="panel panel-default">
                            <div class="panel-heading">                                
                                <h3 class="panel-title">Payment Dues</h3>
                            </div>
                            <div class="panel-body">
                                <div class="clearfix"></div>
                                <table id="example" class="display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Client</th>
                                            <th>Email</th>
                                            <th>Contact #</th>
                                            <th>Installment Amount</th>
                                            <th>Installment Date</th>
                                            <th>Project</th>
                                            <th>Location</th>
                                            <th>Floor</th>
                                            <th>Sale Unit</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($payments)): ?>
                                        <?php foreach ($payments as $overdue): ?>
                                        <tr>
                                            <td class="text-primary"><b><?php echo $overdue->fullname; ?></b></td>
                                            <td><?php echo (!empty($overdue->email_id) ? $overdue->email_id : $overdue->phone_login); ?></td>
                                            <td><?php echo $overdue->phone; ?></td>
                                            <td class="text-info"><b><?php echo 'Rs.'.$overdue->amount;?></b></td>
                                            <td class="text-danger"><b><?php echo date("d M Y",strtotime($overdue->willberecievedon)); ?></b></td>
                                            <td><?php echo $overdue->project_name; ?></td>
                                            <td><?php echo $overdue->project_location; ?></td>
                                            <td><?php echo $overdue->floor_types; ?></td>
                                            <td><?php echo $overdue->unit_type; ?></td>
                                            <td><a href="#" onclick="approve_installment(<?= $overdue->installment_id; ?>)" class="btn btn-primary">Approve</a></td>
                                        </tr>
                                        <?php endforeach ?>
                                    <?php endif ?>
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

    <?php $this->load->view('./incs/jquery-footer') ?>  
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <script>
        function approve_installment(id) {
           if(confirm('Are you sure to confirm this record?')) {
             $.post('<?php echo base_url('Sales/update_dues') ?>', {installment_id:id,contacted:1}, function(response, textStatus, xhr) {
                noty({text: response.message, layout: 'topRight', type: response.param});
                location.reload();
            });
        }
    }

    </script>    
</body>
</html>