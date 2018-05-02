<?php $this->load->view('./incs/header.php') ?> 
<style>
  .mail-item{
        border-left-width: 10px !important;
    }
</style>
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
              
                <!-- START CONTENT FRAME -->
                <div class="content-frame">                                    
                   
                    <!-- START CONTENT FRAME LEFT -->
                    <div class="col-md-3">
                        <div class="block">
                            <a href="<?php echo base_url('Customers/WriteMessage'); ?>" class="btn btn-danger btn-block btn-lg"><span class="fa fa-edit"></span> COMPOSE</a>
                        </div>
                    </div>
                    <!-- END CONTENT FRAME LEFT -->
                    <div class="clearfix"></div>
                    <!-- START CONTENT FRAME BODY -->
                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $print): ?>
                        <div class="col-md-12">
                            
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="pull-left">
                                        <h3 class="panel-title"><?php echo $print->fullname; ?> <small><?php echo $print->email_id; ?></small></h3>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <label for="">Title: </label> <?php echo $print->title; ?><br><br>
                                    <label for="">Subject: </label> <?php echo $print->subject; ?><br><br>
                                    <label for="">Message: </label><?php echo $print->message; ?>
                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-success pull-right"><span class="fa fa-mail-reply"></span> Post Reply</button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach ?>
                    <?php endif ?>
                    <!-- END CONTENT FRAME BODY -->
                </div>
                <!-- END CONTENT FRAME -->
                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
        <?php $this->load->view('./incs/jquery-footer') ?>  

    </body>
</html>






