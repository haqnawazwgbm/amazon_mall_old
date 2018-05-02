<div class="col-md-12 general-white">
 <?php  
    $archi_plans = json_decode($files[0]->authorized_files);
    $count = count($archi_plans);
    if (!empty($count) && $count!= 0) { ?>
    <div class="list-group border-bottom">
    <?php foreach ($archi_plans as $each_plan) {?>
        <a href="<?php echo $each_plan->url; ?>/<?php echo $each_plan->filename; ?>" class="list-group-item"><?php echo $each_plan->orignal; ?></a>
    <?php }
    echo "</div>";
    }
    else
    {
       echo   'No Plans Found. Add Plans!'; 
    }
?>
</div>