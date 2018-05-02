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

                        <!-- START DEFAULT DATATABLE -->
                        <div class="panel panel-default">
                            <div class="panel-heading">                                
                                <h3 class="panel-title">Files</h3>
                            </div>
                            <div class="panel-body">
                              <div class="col-md-6">
                                 <div class="authorized">
                                    <label for=""> Click Or Drop Files To Upload</label>
                                    <form action="<?php echo base_url('Projects/UploadFiles') ?>" class="dropzone dropzone-mini">
                                        <input type="hidden" id="id" value="<?php echo $id; ?>" name="id">
                                    </form>
                                    <small lang="en" class="info">Upload Files. (Multi/Single) </small>
                                </div>
                              </div>
                              <div class="clearfix"></div>
                              <br><br>
                              <div id="files"></div>
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

    <!-- Modal -->

<?php $this->load->view('./incs/jquery-footer') ?>  
<script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>    
<script>
// Saving User To Database
getAllfiles();
function getAllfiles()
{
    $.ajax({
        url: '<?php echo base_url("Projects/getAllFiles") ?>',
        type: 'POST',
        data: {id:<?php echo $id; ?>},
    })
    .done(function(res) {
        $('#files').html(res);
    });
}
function deleteFile(id)
{
    if (confirm('Are You Sure To Delete')) 
    {
        $.post('<?php echo base_url('Projects/deletefile') ?>', {id:id}, function(data, textStatus, xhr) {
            getAllfiles();
        });
    }
}
</script>
</body>
</html>






