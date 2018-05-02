    <?php $this->load->view('incs/header.php') ?> 

    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">

            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <?php $this->load->view('incs/side-bar') ?>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- PAGE CONTENT -->
            <div class="page-content">
                <!-- START X-NAVIGATION VERTICAL -->
                <?php  $this->load->view('incs/header_topbar'); ?>
                <!-- END X-NAVIGATION VERTICAL -->                     
                <div class="page-content-wrap">
                    <div class="row">
                        <div class="col-md-12">
                            <br><br>
                            <!-- START SALES & EVENTS BLOCK -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title-box">
                                        <h3>Units Purchased</h3>
                                    </div>
                                    <ul class="panel-controls" style="margin-top: 2px;">
                                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>                                        
                                            <ul class="dropdown-menu">
                                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                                            </ul>                                        
                                        </li>                                        
                                    </ul>
                                </div>
                                <div class="panel-body padding-0">
                                    <div class="chart-holder" id="dashboard-line-1" style="height: 200px;"></div>
                                </div>
                            </div>
                            <!-- END SALES & EVENTS BLOCK -->
                        </div>
                    </div>

                <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title-box">
                                        <h3>Projects Sales</h3>
                                    </div>                                    
                                    <ul class="panel-controls" style="margin-top: 2px;">
                                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>                                        
                                            <ul class="dropdown-menu">
                                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                                            </ul>                                        
                                        </li>                                        
                                    </ul>                                    
                                </div>                                
                                <div class="panel-body padding-0">
                                    <div class="chart-holder" id="dashboard-bar-1" style="height: 200px;"></div>
                                </div>                                    
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        <!-- END PRELOADS -->                  
        <?php $this->load->view('incs/jquery-footer.php') ?> 
        <!-- END PLUGINS -->
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/plugins/morris/raphael-min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/plugins/morris/morris.min.js"></script>       
        <script>
           
            Morris.Line({
                element: 'dashboard-line-1',
                data: [
                <?php if(!empty($sales)): ?>
                    <?php foreach ($sales as $fetch): ?>
                        { y: '<?php echo $fetch->date ?>', a: <?php echo $fetch->count; ?>},
                    <?php endforeach ?>
                <?php else: ?>
                { y: '2014-10-15', a: 9,b: 12},
                <?php endif; ?>
                ],
                xkey: 'y',
                ykeys: ['a'],
                labels: ['Sales'],
                resize: true,
                hideHover: true,
                xLabels: 'day',
                gridTextSize: '10px',
                lineColors: ['#1caf9a','#33414E'],
                gridLineColor: '#E5E5E5'
            }); 

            Morris.Bar({
                element: 'dashboard-bar-1',
                data: [
                <?php if(!empty($pay)): ?>
                <?php foreach ($pay as $bars): ?>
                { y: '<?php echo $bars->unit; ?>', a: <?php echo $bars->yourprice; ?>, b:<?php echo $bars->ourprice; ?>},
                <?php endforeach ?>
                <?php else: ?>
                { y: '2014-10-15', a: 9,b: 12},
                <?php endif; ?>
                ],
                xkey: 'y',
                ykeys: ['a','b'],
                labels: ['Purchased Square Feet Price','Per Square Feet Price Of The Floor'],
                barColors: ['#33414E', '#1caf9a'],
                gridTextSize: '12px',
                hideHover: true,
                resize: true,
                gridLineColor: '#E5E5E5'
            });  

        </script>
        <!-- END SCRIPTS -->         
    </body>
    </html>






