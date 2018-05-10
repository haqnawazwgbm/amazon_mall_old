 <div class="panel panel-default">
    <div class="panel-heading">                                
        <h3 class="panel-title">Sales Units</h3>
        <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#exampleModal"> <span class="fa fa-plus"> </span> Sale Units</button>
    </div>
    <div class="panel-body">
        <div class="col-md-6">
            <form id="ModifySaleUnit">
                <div class="modal-body">
                <?php 
                    if (!empty($getUnits)) { 
                        $UnitDetails =json_decode($getUnits)[0];
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>Sale Unit</label>
                            <div class="col-md-12 col-xs-12">
                                <input type="text" name="unit_type" value="<?php echo $UnitDetails->unit_type; ?>" class="form-control"/>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="col-md-6 col-xs-12 control-label">Project</label>
                            <div class="col-md-12 col-xs-12">    
                                <select class="form-control" onchange="getFloors($(this).val())">
                                    <option> Select Project </option>
                                    <?php if (!empty($project)) {
                                        $decodeUnit = json_decode($project);
                                        foreach ($decodeUnit as $singleUnit) {
                                        echo '<option value="'.$singleUnit->project_id.'" ';
                                        echo '>'.$singleUnit->project_name.'</option>';
                                    }}?>
                                </select>
                            </div>
                        </div>
                        <div id="floors">
                            <div class="form-group">
                                <label class="col-md-6 col-xs-12 control-label">Floor</label>
                                <div class="col-md-12 col-xs-12">    
                                    <select class="form-control" onchange="getFloors($(this).val())">
                                        <option> Select Project </option>
                                        <?php if (!empty($Floors)) {
                                            $decodeFloor = json_decode($Floors);
                                            foreach ($decodeFloor as $singleFloor) {
                                            echo '<option value="'.$singleFloor->floor_id.'" ';
                                            if ($singleFloor->floor_id == $UnitDetails->floor_id) {
                                                echo "selected";
                                            }
                                            echo '>'.$singleFloor->floor_types.'</option>';
                                        }}?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">                                        
                            <label class="col-md-6 col-xs-12 control-label"><br>Unit Size/Square Feet</label>
                            <div class="col-md-12 col-xs-12">
                                <input type="text" id="unitsize" value="<?php echo $UnitDetails->size_sqft; ?>" name="size_sqft" class="form-control"/>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <input type="hidden" name="unit_id" value="<?php echo $UnitDetails->unit_id; ?>">
                        <div class="clearfix"></div>
                        <div class="form-group">  
                            <label class="col-md-6 col-xs-12 control-label"><br>Price/Square Feet</label>
                            <div class="col-md-12 col-xs-12">
                                <input type="number" name="price_sqft" class="form-control" id="price_sqft" value="<?php echo $UnitDetails->price_sqft; ?>">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <br><br>
                    </div>              
                </div>
                <?php }?>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="Reset()">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        
    </div>
</div>
<script>
// Saving User To Database
$(document).ready(function (e) {
    $("#ModifySaleUnit").on('submit',(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?php echo base_url(); ?>Units/ModifyUnits",
        type: "POST",             
        data: new FormData(this), 
        contentType: false,       
        cache: false,             
        processData:false,        
        success: function(res)  
        {
            $('#loadData').html('');
            response = $.parseJSON(res);
            noty({text: response.message, layout: 'topRight', type: response.param});
        }
    });
  }));
});

$('#unitsize').keyup(function() {
    size  = parseFloat($(this).val());
    price = parseFloat($('#persquare').val());
    total = size * price;
    $('#total_price').val(total);
});

$('#persquare').keyup(function() {
    price  = parseFloat($(this).val());
    size = parseFloat($('#unitsize').val());
    total = size * price;
    $('#total_price').val(total);
});

function getFloors(id)
{
    $.ajax({
        url: '<?php echo base_url("Units/getFloors")?>',
        type: 'POST',
        data: {id:id},
    })
    .done(function(res) {
        $('#floors').html(res);
    })
}
</script>
