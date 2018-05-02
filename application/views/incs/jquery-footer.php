<div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="<?php echo base_url('Login/logout') ?>" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/bootstrap/bootstrap.min.js"></script>       
<!-- END PLUGINS -->
<!-- START THIS PAGE PLUGINS-->        
<script type='text/javascript' src='<?php echo base_url()?>assets/js/plugins/icheck/icheck.min.js'></script>        
<script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/scrolltotop/scrolltopcontrol.js"></script>
<script type='text/javascript' src='<?php echo base_url()?>assets/js/plugins/noty/jquery.noty.js'></script>
<script type='text/javascript' src='<?php echo base_url()?>assets/js/plugins/noty/layouts/topCenter.js'></script>
<script type='text/javascript' src='<?php echo base_url()?>assets/js/plugins/noty/layouts/topLeft.js'></script>
<script type='text/javascript' src='<?php echo base_url()?>assets/js/plugins/noty/layouts/topRight.js'></script>            
<script type='text/javascript' src='<?php echo base_url()?>assets/js/plugins/noty/themes/default.js'></script>
<script type='text/javascript' src='<?php echo base_url()?>assets/js/plugins/bootstrap/bootstrap-datepicker.js'></script>                
<script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/daterangepicker/daterangepicker.js"></script>
<!-- END THIS PAGE PLUGINS-->        
<script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/dropzone/dropzone.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins.js"></script>        
<script type="text/javascript" src="<?php echo base_url()?>assets/js/actions.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/bootstrap-select.min.js"></script>
<script>
// Ajax Starts Here................
    $(document).ajaxStart(function() {
        $('#loading-image').show();
    }).ajaxStop(function() {
        $('#loading-image').hide();
    });
// Adding Values...................
</script>
<?php $type = $this->session->userdata('user_type'); ?>
<?php if ($type == "Admin" || $type == "Accountant"): ?>
<script>
    $.get('<?php echo base_url('Sales/getalerts') ?>', function(data) { $('#NewSales').html(data);});
    function Visit(id)
    {
        $.post('<?php echo base_url('Sales/ReadAlert') ?>', {id:id}, function(data, textStatus, xhr) {
            location.href= '<?php echo base_url('Sales') ?>';
        });
    }
    $.get('<?php echo base_url('Sales/getMessagealerts') ?>', function(data) { $('#Messages').html(data);});
    function VisitMessage(id)
    {
        $.post('<?php echo base_url('Sales/ReadMessageAlert') ?>', {id:id}, function(data, textStatus, xhr) {
            location.href= data;
        });
    }
</script>
<?php endif ?>