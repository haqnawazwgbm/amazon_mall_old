<?php 
if (!empty($Floors)) { 
    $floors =json_decode($Floors)[0];
    ?>
    <form class="form-horizontal" id="ModifyUnit">

        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3>Modify Floor</h3>
            </div>
            <div class="panel-body"> 
                <br><br>
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Project Name</label>
                        <div class="col-md-9">                                
                            <div class="input-group">
                                <span class="input-group-addon"></span>
                                <select name="project_id" id="" class="form-control" required> 
                                    <option> Select Project </option>
                                    <?php  
                                    if (!empty($Projects)) {
                                        $decodeProjects = json_decode($Projects);
                                        foreach ($decodeProjects as $project) {
                                           echo '<option value="'.$project->project_id.'"';
                                        if ($floors->project_id == $project->project_id) {
                                            echo "selected";
                                        }
                                           echo '>'.$project->project_name.'</option>';
                                       }
                                   }
                                   ?>
                               </select>
                           </div>                                            
                       </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Floor Name</label>
                        <div class="col-md-9">                                
                            <div class="input-group">
                                <span class="input-group-addon"></span>
                                <input type="text" value="<?php echo $floors->floor_types; ?>" name="floor_types" class="form-control" required>
                                <input type="hidden" name="floor_id" value="<?php echo $floors->floor_id;?>">
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Size in Square Feets (Optional)</label>
                        <div class="col-md-9">                                
                            <div class="input-group">
                                <span class="input-group-addon"></span>
                                <input type="text" placeholder="e.g 400" value="<?php echo $floors->size_sqft;?>" name="size_sqft" class="form-control">
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Price / Square Feet</label>
                        <div class="col-md-9">                                
                            <div class="input-group">
                                <span class="input-group-addon"></span>
                                <input type="text" placeholder="e.g 200" value="<?php echo $floors->price_sqft;?>" name="price_sqft" class="form-control">
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Rent Per Sqft</label>
                        <div class="col-md-9">                                
                            <div class="input-group">
                                <span class="input-group-addon"></span>
                                <input type="text" placeholder="e.g 100" value="<?php echo $floors->rent_price;?>" name="rent_price" class="form-control">
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Space Type</label>
                        <div class="col-md-9">                                
                            <div class="input-group">
                                <span class="input-group-addon"></span>
                                    <select name="type" class="form-control" required>
                                        <option <?= $floors->type == 'shop' ? 'selected' : ''; ?> value="shop">Shops</option>
                                        <option <?= $floors->type == 'space' ? 'selected' : ''; ?> value="space">Spaces</option>
                                    </select>
                            </div>                                            
                         </div>
                    </div>
               </div>
           </div>
           <div class="panel-footer">
            <button type="submit" class="btn btn-primary pull-right">Submit</button>
            <button type="button" class="btn btn-default pull-right" onclick="Reset();">Cancel</button>
        </div>
    </div>
</form>
<?php }?>
<script>

// Saving User To Database
$(document).ready(function (e) {
    $("#ModifyUnit").on('submit',(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?php echo base_url(); ?>Floors/ModifyFloors",
        type: "POST",             
        data: new FormData(this), 
        contentType: false,       
        cache: false,             
        processData:false,        
        success: function(res)  
        {
            resetTable();
            response = $.parseJSON(res);
            noty({text: response.message, layout: 'topRight', type: response.param});
        }
    });
  }));
});
</script>
