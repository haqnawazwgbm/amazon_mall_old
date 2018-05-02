<a href="#"><span class="fa fa-tasks"></span></a>
<div class="informer informer-warning"><?php echo count($alerts); ?></div>
<div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging ui-draggable">
    <div class="panel-heading ui-draggable-handle">
        <h3 class="panel-title"><span class="fa fa-tasks"></span> Sales</h3>                                
        <div class="pull-right">
            <span class="label label-warning"><?php echo count($alerts).' Sales'; ?></span>
        </div>
    </div>
    <div class="panel-body list-group scroll mCustomScrollbar _mCS_3 mCS-autoHide mCS_no_scrollbar" style="height: 200px;"><div id="mCSB_3" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" tabindex="0"><div id="mCSB_3_container" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y" style="position:relative; top:0; left:0;" dir="ltr">
    <?php if (!empty($alerts)): ?>
        <?php foreach ($alerts as $find): ?>
            <a class="list-group-item" onclick="Visit(<?php echo $find->sale_id ?>)" style="cursor:pointer !important;">
                <strong>Sale of <?php echo $find->unit_type; ?> at <?php echo $find->floor_types; ?> in <?php echo $find->project_name; ?> <small class="text-muted pull-right">Date: <?php echo $find->sale_date; ?></small></strong>
           </a>
            <div class="clearfix"></div>
        <?php endforeach ?>
    <?php endif ?>                      
                               
    </div><div id="mCSB_3_scrollbar_vertical" class="mCSB_scrollTools mCSB_3_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: none;"><div class="mCSB_draggerContainer"><div id="mCSB_3_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; top: 0px;" oncontextmenu="return false;"><div class="mCSB_dragger_bar" style="line-height: 30px;"></div></div><div class="mCSB_draggerRail"></div></div></div></div></div>     
    <div class="panel-footer text-center">
        <a href="pages-tasks.html">Show all Sales</a>
    </div>                            
</div>                   