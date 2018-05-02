<?php $this->load->view('./incs/header.php') ?> 
<style>
  .mail-item{
        border-left-width: 10px !important;
    }
    .panel-footer{
        visibility: hidden !important;
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
                    <div class="col-md-12">
                        
                        <div class="panel panel-default">
                            <div class="panel-body mail">
                                <?php if (!empty($messages)): ?>
                                    <?php foreach ($messages as $singlemessage): 
                                        $ur = $singlemessage->urgency;
                                    ?>
                                    <div class="mail-item  <?php if($singlemessage->status == 0){ echo "mail-unread "; } ?><?php if($ur == "Normal"){ echo "mail-info"; }elseif($ur == "Urgent"){ echo "mail-success"; } else{ echo "mail-danger";} ?>">
                                        <div class="mail-star <?php if($singlemessage->status != "0"){ echo "starred"; } ?>">
                                            <span class="fa fa-star-o"></span>
                                        </div>                                    

                                        <div class="mail-user"><?php echo $singlemessage->title; ?></div>               
                                        <a href="<?php echo base_url();?>Sales/messageDetails/<?php echo $singlemessage->id; ?>" class="mail-text"><?php echo $singlemessage->subject; ?></a>                                    
                                        <div class="mail-date">Sent: <?php echo date('d M Y',strtotime($singlemessage->created_at)); ?></div>
                                    </div>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
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






