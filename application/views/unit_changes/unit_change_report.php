<?php $this->load->view('./incs/header.php') ?> 
<!-- overriding styles -->
<style type="text/css">
.dropzone a.dz-remove, .dropzone-previews a.dz-remove{
  display: none !important;
}
.file-type{
    padding: 1em 2em;
    float: left;
    background: #E91E63;
    margin-right: 12px;
}
.file-type h3{
    float: left;
}
</style>
<!-- end of style -->
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
                    <li class="active"><a href="<?php echo base_url('Units');?>">Sales Unit</a></li>
                </ul>
                <br><br>
                <div class="col-md-12">
                    <div id="showFiles"></div>
                    <div class="authorized" style="display: none;">
                        <div class="col-md-12 general-white">
                            <div class="col-md-12" id="uploadMapFiles">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <form action="<?php echo base_url('Units/uploadAuthorizeFiles') ?>" class="dropzone dropzone-mini">
                                            <input type="hidden" id="saleunit" value="" name="saleunit">
                                        </form>
                                        <small lang="en" class="info">Upload Files. (Multi/Single) </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="panel panel-default">
                    <div class="panel-heading">                                
                        <h3 class="panel-title">Changes Report</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <?php  
                            if (!empty($getUnits)) {
                                $decodeData = json_decode($getUnits); 
                                ?>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Unit Type</th>
                                        <th>Size / Square Feet</th>
                                        <th>Price / Square Feet</th>
                                        <th>Total Amount</th>
                                        <th>Files</th>
                                        <th>Created at</th>
                                        <th>Authotized</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php 
                                    foreach ($decodeData as $each) { 
                                        $files = json_decode($each->authorized_files);
                                        ?>
                                        <tr>
                                            <td><?php echo $each->unit_type; ?></td>
                                            <td><?php echo $each->change_in_size.' square feets'; ?></td>
                                            <td><?php echo $each->change_in_price.' /sqft'; ?></td>
                                            <td><?php echo 'Rs/- '.$each->change_in_tprice; ?></td>
                                            <td><?php echo count($files).' files'; ?></td>
                                            <td><?php echo date("d M Y h:i:s a",strtotime($each->created_at)); ?></td>
                                            <td>
                                                <?php  
                                                if (!empty($files)) {
                                                    echo "Authorized";
                                                }
                                                else
                                                {
                                                    echo "Not Authorized";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary" onclick="GetUploadArea(<?php echo $each->unit_change_id; ?>)" >Add Files</a>
                                                <a class="btn btn-info" onclick="getAllFiles(<?php echo $each->unit_change_id; ?>)" >View Files</a>
                                            </td>
                                     </tr>    
                                     <?php } ?>
                                 </table>
                                 <?php } ?>  
                             </div>
                         </div>
                     </div>   
                 </div>                
             </div>
         </div>
     </div>
     <!-- END PRELOADS -->  
     <!-- Performing Edit/ View -->
     <?php $this->load->view('./incs/jquery-footer') ?>  
     <script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
     <script type="text/javascript">
        function GetUploadArea(id) {
            $('#saleunit').val(id);
            $('.authorized').toggle('slow');
        }
        function getAllFiles(id) {
            $.ajax({
                url: '<?php echo base_url("Units/AuthorizedFiles") ?>',
                type: 'POST',
                data: {id:id},
            })
            .done(function(response) {
                $('#showFiles').html(response);
            });
        }
    </script>
</body>
</html>