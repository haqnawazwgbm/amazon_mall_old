 <?php $type = $this->session->userdata('user_type');?>

 <ul class="x-navigation">
    <li class="xn-logo">
        <a href="<?php echo base_url() ?>Master/dashboard">Amazon</a>
        <a href="#" class="x-navigation-control"></a>
    </li>
    <li class="xn-profile">
        <div class="profile">
            <div class="profile-data">
                <div class="profile-data-name"><?php echo $this->session->userdata('fullname'); ?></div>
                <div class="profile-data-title"><?php echo $this->session->userdata('user_type'); ?></div>
            </div>
            <div class="clearfix"></div>
        </div>                                                                        
    </li>
    <li class="xn-title"></li>
    <?php if ($type == "Admin" || $type == 'ccd'): ?>
        <li class="active">
            <a href="<?php echo base_url() ?>Master/dashboard">
                <span class="fa fa-desktop"></span> 
                <span class="xn-text">Dashboard</span>
            </a>                        
        </li>  
    <?php endif ?>
    <?php if ($type == "Admin" || $type == "Agent" || $type == 'ccd'): ?>
        <li>
            <a href="<?php echo base_url() ?>Cif">
                <span class="fa fa-desktop"></span> 
                <span class="xn-text">Customer (CIF)</span>
            </a>                        
        </li>          
    <?php endif ?>
    <?php if ($type == "Admin" || $type == "Accountant" || $type == 'ccd'): ?>
        
          <li class="xn-openable">
            <a href="<?php echo base_url();?>Sales">
                <span class="fa fa-file-o"></span> 
                <span class="xn-text">Sales</span>
            </a>
            <ul>
                <li>
                    <a href="<?php echo base_url() ?>Sales">
                        <span class="fa fa-desktop"></span> 
                        <span class="xn-text">Unit Sales</span>
                    </a>                        
                </li>
                <?php if ($type == 'ccd' || $type == 'Admin') : ?>
                    <li>
                    <a href="<?php echo base_url() ?>Sales/review_sales">
                        <span class="fa fa-desktop"></span> 
                        <span class="xn-text">Review Sale Documents</span>
                    </a>                        
                </li>
                <?php endif; ?>
                
                 <li>
                    <a href="<?php echo base_url() ?>Sales/spaces">
                        <span class="fa fa-desktop"></span> 
                        <span class="xn-text">Space Sales</span>
                    </a>                        
                </li>
        
            </ul>
        </li>   
        <li>
            <a href="<?php echo base_url() ?>Sales/Dues">
                <span class="fa fa-desktop"></span> 
                <span class="xn-text">Installment Dues</span>
            </a>                        
        </li>   
        <li>
            <a href="<?php echo base_url() ?>Sales/TackBacks">
                <span class="fa fa-desktop"></span> 
                <span class="xn-text">Take Backs</span>
            </a>                        
        </li>  
        <li>
            <a href="<?php echo base_url() ?>Sales/Message">
                <span class="fa fa-desktop"></span> 
                <span class="xn-text">User Messages</span>
            </a>                        
        </li> 
    <?php endif ?>
    <?php if ($type == "Accountant"): ?>
        <li>
            <a href="<?php echo base_url();?>Reports/installments">
                <span class="fa fa-desktop"></span> 
                <span class="xn-text">Installments Due Report</span>
            </a>
        </li>
      <!--   <li><a href="<?php echo base_url();?>Reports/rent"><span class="fa fa-desktop"></span> 
                <span class="xn-text">Rent Report</span></a></li> -->
    <?php endif ?>
    <?php if ($type == "Admin" || $type == 'ccd'): ?>
        <li>
            <a href="<?php echo base_url() ?>Agents/customers">
                <span class="fa fa-desktop"></span> 
                <span class="xn-text">Manage Users</span>
            </a>                        
        </li>    
    <?php endif ?>
    <?php if ($type == "Admin" || $type == 'ccd'): ?>
        <li>
            <a href="<?php echo base_url() ?>Units">
                <span class="fa fa-desktop"></span> 
                <span class="xn-text">Sale Units</span>
            </a>                        
        </li>     
    <?php endif ?>
    <?php if ($type == "Admin" || $type == 'ccd'): ?>
        <li>
            <a href="<?php echo base_url() ?>Floors/Floors">
                <span class="fa fa-file-o"></span>Floors
            </a>
        </li>
    <?php endif ?>
    <?php if ($type == "Agent"): ?>
        <li>
            <a href="<?php echo base_url();?>Reports/InventorywithReport">
                <span class="fa fa-desktop"></span> 
                <span class="xn-text">Inventory Report</span>
            </a>
        </li>
     <!--    <li>
            <a href="<?php echo base_url();?>Reports/Salesreports">
                <span class="fa fa-desktop"></span> 
                <span class="xn-text">Sales Report</span>
            </a>
        </li> -->
    <?php endif; ?>   
    <?php if ($type == "Admin" || $type == 'ccd' || $type == 'Accountant'): ?>
        <li class="xn-openable">
            <a href="<?php echo base_url();?>Reports">
                <span class="fa fa-file-o"></span> 
                <span class="xn-text">General Reports</span>
            </a>
            <ul>
                <li><a href="<?php echo base_url();?>Reports/ClientDetailReport">Client Detail Report</a></li>
                <li><a href="<?php echo base_url();?>Reports/installments">Installments Due Report</a></li>
                <li><a href="<?php echo base_url();?>Reports/InventoryReport">Inventory Sales</a></li>
                <li><a href="<?php echo base_url();?>Reports/InventorywithReport">Inventory Report</a></li>
                <li><a href="<?php echo base_url();?>Reports/Salesreports">Sale Report</a></li>
                <li><a href="<?php echo base_url();?>Reports/AgentReport">Agent Sale Report</a></li>
                <li><a href="<?php echo base_url();?>Reports/AgentsReport">Agents Sales Report</a></li>
                <li><a href="<?php echo base_url();?>Reports/ClientReport">Clients Report</a></li>
                <li><a href="<?php echo base_url();?>Reports/resold">Resold Report</a></li>
                <?php if ($type == "Admin" || $type == 'Accountant'): ?>
                <li><a href="<?php echo base_url();?>Reports/rent">Rent Report</a></li>
                <?php endif; ?>
            </ul>
        </li>  
        <?php if ($type == "Accountant" || $type == "Admin"): ?>
          <li class="xn-openable">
            <a href="<?php echo base_url();?>Reports">
                <span class="fa fa-file-o"></span> 
                <span class="xn-text">Accounts Reports</span>
            </a>
            <ul>
                <li><a href="<?php echo base_url();?>Reports/receivable_report">Receivable Summary Report</a></li>
                <li><a href="<?php echo base_url();?>Reports/Salesreports">Sale Summary Report</a></li>
                <li><a href="<?php echo base_url();?>Reports/installments">Installments Due Report</a></li>
                <li><a href="<?php echo base_url();?>Reports/rebate_report">Rebate Report</a></li>
                <li><a href="<?php echo base_url();?>Reports/daily_progress_report">Daily Progress Report</a></li>
              
            </ul>
        </li> 
     <?php endif; ?>
        <li>
            <a href="<?php echo base_url() ?>Projects">
                <span class="fa fa-file-o"></span>Projects
            </a>
        </li>                 
    <?php endif ?>
    <?php if ($type == "User"): ?>
        <li class="active">
            <a href="<?php echo base_url() ?>Customers">
                <span class="fa fa-desktop"></span> 
                <span class="xn-text">Dashboard</span>
            </a>                        
        </li>  
        <li>
            <a href="<?php echo base_url() ?>Customers/dashboard">
                <span class="fa fa-desktop"></span> 
                <span class="xn-text">Purchases</span>
            </a>                        
        </li> 
        <li>
            <a href="<?php echo base_url() ?>Customers/Message">
                <span class="fa fa-desktop"></span> 
                <span class="xn-text">Messages</span>
            </a>                        
        </li> 
    <?php endif ?>
    <li>
        <a href="<?php echo base_url() ?>Password">
            <span class="fa fa-file-o"></span>
            <span class="xn-text">Change Password</span>
        </a>
    </li>
    <li>
        <a href="<?php echo base_url() ?>Backup">
            <span class="fa fa-file-o"></span>
            <span class="xn-text">Back Up</span>
        </a>
    </li>
</ul>