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
                              <ul class="nav nav-tabs bootstrap-tabs">
                                <li><a href="<?= base_url(); ?>Agents/customers">Customers</a></li>
                                <li class="<?= $this->uri->segment(2) == 'users' ? 'active' : ''; ?>"><a href="<?= base_url(); ?>Agents/users">System Users</a></li>
                              </ul>
                        <!-- START DEFAULT DATATABLE -->
                        <div class="panel panel-default">
                            <div class="panel-heading">                                
                                <h3 class="panel-title">Users</h3>
                                <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#exampleModal"> <span class="fa fa-plus"> </span> New User</button>
                            </div>
                            <div class="panel-body">
                                <table id="example" class="display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>User Role</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>City</th>
                                            <th>Country</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>

                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                        
                        <!-- END DEFAULT DATATABLE -->
                    </div>
                </div>                                

            </div>
            <!-- PAGE CONTENT WRAPPER -->                                     
        </div>            
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END PAGE CONTAINER -->

    <!-- Modal -->
<?php include_once('user_form.php'); ?>
<!-- END PRELOADS -->  
<!-- Performing Edit/ View -->
<div class="modal fade" id="loadDatas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
       <div class="modal-content modal-lg" >
            <div id="loadData"></div>
       </div> 
  </div>
</div>
<?php $this->load->view('./incs/jquery-footer') ?>  
<script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>    
<script>
// Saving User To Database
$(document).ready(function (e) {
    $("#SaveAgent").on('submit',(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?php echo base_url(); ?>Agents/UploadAgent",
        type: "POST",             
        data: new FormData(this), 
        contentType: false,       
        cache: false,             
        processData:false,        
        success: function(res)  
        {
            resetTable();
            $('#SaveAgent')[0].reset();
            $('#exampleModal').modal('toggle');
            response = $.parseJSON(res);
            noty({text: response.message, layout: 'topRight', type: response.param});
        }
    });
  }));
});
// Loading Data From Server Via Datatables Pipeline
loadDataintoTable();
function loadDataintoTable()
{
    $('#example').DataTable({
        "ajax": "<?php echo base_url('Agents/getAllAgents/user') ?>",
        "columns": [
        { "data": "11" },
        { "data": "0" },
        { "data": "1" },
        { "data": "2" },
        { "data": "3" },
        { "data": "4" },
        { "data": "5" },
        { "data": "6" }
        ]
    });
}

function resetTable()
{
    $("#example").dataTable().fnDestroy();
    loadDataintoTable();
}

function performAction(Url,Action,ID) {
    if (confirm('Are You Sure?')) {
        $.ajax({
            url: '<?php echo base_url();?>Agents/'+Url,
            type: 'POST',
            data: {status:Action,id:ID},
        })
        .done(function(res) {
            resetTable();
            response = $.parseJSON(res);
            noty({text: response.message, layout: 'topRight', type: response.param});
        })
    }
}

function CheckEmail(val)
{
    $.post('<?php echo base_url('Agents/RecheckEmail'); ?>', {val:val}, function(data, textStatus, xhr) {
        if(data == 0)
        {
            
        }else
        {
            response = $.parseJSON(data);
            noty({text: response.message, layout: 'topRight', type: response.param});
                
        }
    });
}

function doAgentAction(action,id)
{
    if (action == 1) 
    {
        $.ajax({
            url: '<?php echo base_url("Agents/ViewAgent")?>',
            type: 'POST',
            data: {id:id},
        })
        .done(function(res) {
            $('#loadData').html(res);
        })
    }
    else if (action == 2) 
    {
        $.ajax({
            url: '<?php echo base_url("Agents/EditAgent")?>',
            type: 'POST',
            data: {id:id},
        })
        .done(function(res) {
            $('#loadData').html(res);
        })
    }
    else
    {
        if (confirm('Are You Sure to Delete?')) 
        {
            $.ajax({
                url: '<?php echo base_url("Agents/deleteAgent")?>',
                type: 'POST',
                data: {id:id},
            })
            .done(function(res) {
                $("#example").dataTable().fnDestroy();
                loadDataintoTable();
                response = $.parseJSON(res);
                noty({text: response.message, layout: 'topRight', type: response.param});
            })
        }
    }

}
// Get Provines
    function getProvince(id)
    {
        $.ajax({
            url: '<?php echo base_url("Cif/getProvinces"); ?>',
            type: 'POST',
            data: {id:id},
        })
        .done(function(response) {
            $('#provinces').html(response);
        });
    }
    function getDistrict(id) 
    {
        $.ajax({
            url: '<?php echo base_url("Cif/getDistrict"); ?>',
            type: 'POST',
            data: {id:id},
        })
        .done(function(response) {
            $('#districts').html(response);
        });
    }

    function reSendPassword(id)
    {
        if (confirm('Are You Sure To Send New Password?')) {
            $.post('<?php echo base_url('Agents/ResendPassword');?>', {id:id}, function(data, textStatus, xhr) {
                response = $.parseJSON(data);
                noty({text: response.message, layout: 'topRight', type: response.param});
                $('#emailid').html(response.message);
            });
        }
    }
</script>
</body>
</html>






