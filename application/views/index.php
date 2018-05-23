    <?php $this->load->view('incs/header.php') ?> 
    <style>
        .widget .widget-int {
            font-size: 22px;
        }
    </style>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">

            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <?php $this->load->view('incs/side-bar') ?>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                <!-- START X-NAVIGATION VERTICAL -->
                <?php  $this->load->view('incs/header_topbar'); ?>
                <!-- END X-NAVIGATION VERTICAL -->                     
                <div class="page-content-wrap">
                    <div class="row">
                        <br>
                        <div class="col-md-4">
                            <div class="widget widget-info widget-item-icon">
                                <div class="widget-item-left">
                                    <span class="fa fa-bars"></span>
                                </div>                             
                                <div class="widget-data">
                                    <?php if (!empty($top)): ?>
                                    <div class="widget-int num-count"><?php echo 'Rs.'.number_format($top['cost'],0,'.',','); ?></div>
                                    <?php endif ?>
                                    <div class="widget-title">Total Sales</div>
                                </div>      
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="widget widget-success widget-item-icon" style="background:#ed5454 !important;">
                                <div class="widget-item-left">
                                    <span class="fa fa-bars"></span>
                                </div>                             
                                <div class="widget-data">
                                    <?php if (!empty($top)): ?>
                                    <div class="widget-int num-count"><?php echo 'Rs.'.number_format($top['paid'],0,'.',','); ?></div>
                                    <?php endif ?>
                                    <div class="widget-title">Total Paid</div>
                                </div>      
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="widget widget-default widget-item-icon">
                                <div class="widget-item-left">
                                    <span class="fa fa-bars"></span>
                                </div>                             
                                <div class="widget-data">
                                    <?php if (!empty($top)): ?>
                                    <div class="widget-int num-count"><?php echo 'Rs.'.number_format($top['remaining'],0,'.',','); ?></div>
                                    <?php endif ?>
                                    <div class="widget-title">Remaining Amount</div>
                                </div>      
                            </div>
                        </div>
                        <!-- <div class="col-md-12">
                            <br><br>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title-box">
                                        <h3>Sales</h3>
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
                                    <div class="chart-holder" id="dashboard-line-2" style="height: 200px;"></div>
                                </div>
                            </div>
                        </div> -->
                        <div class="col-md-6">
                            <br><br>
                            <!-- START SALES & EVENTS BLOCK -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title-box">
                                        <h3>Sales</h3>
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
                        <div class="col-md-6">
                            <br><br>
                            <!-- START USERS ACTIVITY BLOCK -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title-box">
                                        <h3>Total Sales Booked</h3>
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
                                    <div class="chart-holder" id="dashboard-bar-2" style="height: 200px;"></div>
                                </div>                                    
                            </div>
                            <!-- END USERS ACTIVITY BLOCK -->
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-md-6">
                        <br><br>
                        <!-- START USERS ACTIVITY BLOCK -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title-box">
                                    <h3>Total Amount Received</h3>
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
                                <div class="chart-holder" id="dashboard-bar-3" style="height: 200px;"></div>
                            </div>                                    
                        </div>
                        <!-- END USERS ACTIVITY BLOCK -->
                    </div>
                    <div class="col-md-6">
                        <br><br>
                        <!-- START USERS ACTIVITY BLOCK -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title-box">
                                    <h3>Total Installments Due Till Date</h3>
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
                                <div class="chart-holder" id="dashboard-bar-4" style="height: 200px;"></div>
                            </div>                                    
                        </div>
                        <!-- END USERS ACTIVITY BLOCK -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <!-- START USERS ACTIVITY BLOCK -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title-box">
                                    <h3>Sales Per Project</h3>
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
                        <!-- END USERS ACTIVITY BLOCK -->
                    </div>
                    <div class="col-md-6">

                        <!-- START VISITORS BLOCK -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title-box">
                                    <h3>Users</h3>
                                    <span>Users (last month)</span>
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
                                <div class="chart-holder" id="dashboard-donut-1" style="height: 200px;"></div>
                            </div>
                        </div>
                        <!-- END VISITORS BLOCK -->
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT WRAPPER -->                                
        </div>            
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END PRELOADS -->                  
    <?php $this->load->view('incs/jquery-footer.php') ?> 
    <!-- END PLUGINS -->
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/plugins/morris/raphael-min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/plugins/morris/morris.min.js"></script>       
    <script>
        Morris.Donut({
            element: 'dashboard-donut-1',
            data: [
            <?php if (!empty($users)): ?>
            <?php foreach ($users as $one): ?>
            {label: "<?php echo $one->type ?>", value: <?php echo $one->id; ?>},
            <?php endforeach ?>
            <?php else: ?>
            {label: "No Users", value: 100}
            <?php endif; ?>
            ],
            colors: ['#33414E', '#1caf9a', '#FEA223','#f00','#999'],
            resize: true
        });

        Morris.Line({
            element: 'dashboard-line-1',
            data: [
            <?php if(!empty($lines)): ?>
            <?php foreach ($lines as $fetch): ?>
            { y: '<?php echo $fetch['Date'] ?>', a: <?php echo $fetch['Sales']; ?>},
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
            yLabelFormat: function(y){return y != Math.round(y)?'':y;},
            xLabels: 'day',
            gridTextSize: '10px',
            lineColors: ['#1caf9a','#33414E','#1caf9a','#33414E','#1cdc9a','#224acE','#133d9a','#3bc4cE'],
            gridLineColor: '#000'
        });   

        Morris.Bar({
            element: 'dashboard-bar-1',
            data: [
            <?php if(!empty($pay)): ?>
            <?php foreach ($pay as $bars): ?>
            { y: '<?php echo $bars['Project'] ?>', a: <?php echo $bars['Sales']; ?>},
            <?php endforeach ?>
            <?php else: ?>
            { y: '2014-10-15', a: 9,b: 12},
            <?php endif; ?>
            ],
            xkey: 'y',
            ykeys: ['a'],
            yLabelFormat: function(y){return y != Math.round(y)?'':y;},
            labels: ['Sales'],
            barColors: ['#607d8b', '#1caf9a','#1caf9a','#33414E','#1cdc9a','#224acE','#133d9a','#3bc4cE'],
            gridTextSize: '10px',
            hideHover: true,
            resize: true,
            gridLineColor: '#000'
        });

            // Total Sales For All Projects

            Morris.Bar({
                element: 'dashboard-bar-2',
                data: [
                <?php if(!empty($totalsale)): ?>
                <?php foreach ($totalsale as $bars): ?>
                { y: '<?php echo $bars['Project'] ?>', a: <?php echo $bars['Sales']; ?>},
                <?php endforeach ?>
                <?php else: ?>
                { y: '2014-10-15', a: 9,b: 12},
                <?php endif; ?>
                ],
                xkey: 'y',
                ykeys: ['a'],
                labels: ['Sales'],
                barColors: ['#ff9800','#1caf9a','#33414E','#1cdc9a','#224acE','#133d9a','#3bc4cE'],
                gridTextSize: '10px',
                hideHover: true,
                resize: true,
                gridLineColor: '#000'
            });
            // Total Amount Recieved 
            Morris.Bar({
                element: 'dashboard-bar-3',
                data: [
                <?php if(!empty($recievedAmount)): ?>
                <?php foreach ($recievedAmount as $bars): ?>
                { y: '<?php echo $bars['Project'] ?>', a: <?php echo $bars['Sales']; ?>},
                <?php endforeach ?>
                <?php else: ?>
                { y: '2014-10-15', a: 9,b: 12},
                <?php endif; ?>
                ],
                xkey: 'y',
                ykeys: ['a'],
                labels: ['Sales'],
                barColors: ['#009688','#1caf9a','#1caf9a','#33414E','#1cdc9a','#224acE','#133d9a','#3bc4cE'],
                gridTextSize: '10px',
                hideHover: true,
                resize: true,
                gridLineColor: '#000'
            });
            // Total Dues 
            Morris.Bar({
                element: 'dashboard-bar-4',
                data: [
                <?php if(!empty($dueinstall)): ?>
                <?php foreach ($dueinstall as $bars): ?>
                { y: '<?php echo $bars['Project'] ?>', a: <?php echo $bars['Dues']; ?>},
                <?php endforeach ?>
                <?php else: ?>
                { y: '2014-10-15', a: 9,b: 12},
                <?php endif; ?>
                ],
                xkey: 'y',
                ykeys: ['a'],
                labels: ['Sales'],
                barColors: ['#F44336', '#1caf9a'],
                gridTextSize: '10px',
                hideHover: true,
                resize: true,
                gridLineColor: '#000'
            });
            // Line Bar
            <?php 
            $alpha = 'a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,';
            $Values = [];
            if(!empty($lines)): 
                foreach($lines as $l): 
                    $Values [] = "'".$l['Project']."'";
                endforeach; 
            endif; 
            $neatArray = $Values;
            $unique = array_unique($Values);
            $count = count($unique)*2;
            $names = implode(',', $unique);
            $labels = '['.$names.']';
            // Getting X Keys;
            $ykeys  = substr($alpha,0,$count);
            // Exploding
            $ketty = [];
            if (!empty($ykeys)) 
            {
                $emplode = explode(',',$ykeys);
                foreach($emplode as $a): 
                    if (!empty($a)):
                    $ketty[] = "'".$a."'";
                    endif;
                endforeach; 
            }
            $Xkeys = implode(',', $ketty);
            $Xkeys = '['.$Xkeys.']';

        ?>


    // Morris.Line({
    //     element: 'dashboard-line-2',
    //     data: [
    //     <?php //if(!empty($lines)): ?>
    //         <?php //$i = 0; foreach ($lines as $val):?>
    //             <?php //foreach ($neatArray as $key): ?>
    //                 <?php //if ($key == $val['Project']): ?>
    //                     {  y: '<?php //echo $val['Date']; ?>',a:'<?php //echo $val['Total']; ?>'},
    //                 <?php //else: ?>
    //                     {  y: '<?php //echo $val['Date']; ?>',b:'<?php //echo $val['Total']; ?>'},
    //                 <?php //endif;?>
    //             <?php //continue; endforeach ?>
    //         <?php //$i++; endforeach ?>
    //     <?php //else: ?>
    //     { y: '2014-10-15', a: 9,b: 12},
    //     <?php //endif; ?>
    //     ],
    //     xkey: 'y',
    //     ykeys: <?php echo $Xkeys; ?>,
    //     labels: <?php echo $labels; ?>,
    //     resize: true,
    //     hideHover: true,
    //     xLabels: 'day',
    //     gridTextSize: '10px',
    //     lineColors: ['#1caf9a','#33414E','#1cdc9a','#224acE','#133d9a','#3bc4cE'],
    //     gridLineColor: '#000'
    // });   
</script>
</body>
</html>






