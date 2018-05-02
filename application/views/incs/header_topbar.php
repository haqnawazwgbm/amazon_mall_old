
<ul class="x-navigation x-navigation-horizontal x-navigation-panel">
    <!-- TOGGLE NAVIGATION -->
    <li class="xn-icon-button">
        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
    </li>
    <!-- END TOGGLE NAVIGATION -->
    <!-- SEARCH -->

    <!-- END SEARCH -->
    <!-- SIGN OUT -->
    <li class="xn-icon-button pull-right mg-right">
        <a href="#" class="mb-control" data-box="#mb-signout">Logout</a>                        
    </li> 
    <!-- END SIGN OUT -->
    <!-- MESSAGES -->
    <?php $user = $this->session->userdata('user_type'); 
    if ($user == "Admin" || $user == "Accountant"):
        ?>
        <!-- TASKS -->
        <li class="xn-icon-button pull-right" id="NewSales"></li>
        <li class="xn-icon-button pull-right" id="Messages"></li>
    <?php endif; ?>
    <!-- END TASKS -->
</ul>