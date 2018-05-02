<a href="#"><span class="fa fa-comments"></span></a>
<div class="informer informer-danger"><?php echo count($alerts); ?></div>
<div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging ui-draggable">
    <div class="panel-heading ui-draggable-handle">
        <h3 class="panel-title"><span class="fa fa-comments"></span> Messages</h3>                                
        <div class="pull-right">
            <span class="label label-danger"><?php echo count($alerts); ?> new</span>
        </div>
    </div>
    <div class="panel-body list-group list-group-contacts scroll mCustomScrollbar _mCS_2 mCS-autoHide mCS_no_scrollbar" style="height: 200px;"><div id="mCSB_2" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" tabindex="0"><div id="mCSB_2_container" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y" style="position:relative; top:0; left:0;" dir="ltr">
        <?php if (!empty($alerts)): ?>
            <?php foreach ($alerts as $message): ?>
            <a onclick="VisitMessage(<?php echo $message->id; ?>)" style="cursor: pointer;" class="list-group-item">
                <div class="list-group-status status-online"></div>
                <span class="contacts-title"><?php echo $message->fullname; ?></span>
                <p><?php echo $message->title; ?></p>
            </a> 
            <?php endforeach ?>
        <?php endif ?>
    </div><div id="mCSB_2_scrollbar_vertical" class="mCSB_scrollTools mCSB_2_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: none;"><div class="mCSB_draggerContainer"><div id="mCSB_2_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; top: 0px;" oncontextmenu="return false;"><div class="mCSB_dragger_bar" style="line-height: 30px;"></div></div><div class="mCSB_draggerRail"></div></div></div></div></div>     
</div>                        