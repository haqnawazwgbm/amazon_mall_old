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
                        <div id="loadData"></div>
                        
                        <!-- START DEFAULT DATATABLE -->
                        <div class="panel panel-default">
                            <div class="panel-heading">                                
                                <h3 class="panel-title">Database Backup</h3>
                            </div>
                            <div class="panel-body">
                            <div class="message_box">
                                <?php
                                if (isset($success) && strlen($success)) {
                                    echo '<div class="success">';
                                    echo '<p>' . $success . '</p>';
                                    echo '</div>';
                                }

                                if (isset($errors) && strlen($errors)) {
                                    echo '<div class="error">';
                                    echo '<p>' . $errors . '</p>';
                                    echo '</div>';
                                }

                                if (validation_errors()) {
                                    echo validation_errors('<div class="error">', '</div>');
                                }
                                ?>
                            </div>
                            <?php
                            $back_url = $this->uri->uri_string();
                            $key = 'referrer_url_key';
                            $this->session->set_flashdata($key, $back_url);
                            ?>
                            <div class="body body-s">
                                <?php
                                echo form_open($this->uri->uri_string());
                                ?>
                                <fieldset>
                                    <section>
                                        <label>Backup Type</label>
                                        <label>
                                            <select name="backup_type">
                                                <option value="" selected disabled>Backup Type</option>
                                                <option value="1" <?php echo (isset($success) && strlen($success) ? '' : (set_value('backup_type') == '1' ? 'selected' : '')) ?>>DB Backup</option>
                                                <!-- <option value="2" <?php// echo (isset($success) && strlen($success) ? '' : (set_value('backup_type') == '2' ? 'selected' : '')) ?>>Site Backup</option> -->
                                            </select>
                                        </label>
                                    </section>

                                    <section>
                                        <label>File Type</label>
                                        <label>
                                            <select name="file_type">
                                                <option value="" selected disabled>File Type</option>
                                                <option value="1" <?php echo (isset($success) && strlen($success) ? '' : (set_value('file_type') == 1 ? 'selected' : '')) ?>>ZIP</option>
                                                <option value="2" <?php echo (isset($success) && strlen($success) ? '' : (set_value('file_type') == 2 ? 'selected' : '')) ?>>GZIP</option>
                                            </select>
                                        </label>
                                    </section>
                                </fieldset>

                                <footer>
                                    <button type="submit" name="backup" value="backup" class="button">Get Backup</button>
                                </footer>
                                <?php
                                echo form_close();
                                ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                       <div class="col-md-12">
                            <table class="table">
                            <tr>
                                <th>#</th>
                                <th>Backup Name</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            <?php  
                                $backup = $this->Admin->getAllData('backup');
                                if (!empty($backup)):
                                    $i =1 ;
                                    foreach ($backup as $one):
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $one->backup_name; ?></td>
                                <td><?php echo $one->backup_location; ?></td>
                                <td><?php echo date("D M Y",strtotime($one->created_date)); ?></td>
                                <td><a class="btn btn-success" href="<?php echo base_url()?><?php echo $one->backup_location; ?><?php echo $one->backup_name; ?>" download> Download</a></td>
                            </tr>
                        <?php $i++; endforeach; endif; ?>
                        </table>
                       </div>
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


<!-- Performing Edit/ View -->
<?php $this->load->view('./incs/jquery-footer') ?>  

</body>
</html>






