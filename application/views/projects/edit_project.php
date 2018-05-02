<?php 
if (!empty($project)) { 
$project =json_decode($project)[0];
?>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modify Project</h5>
    </div>
    <form id="ModifyProject">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">                                        
                        <label class="col-md-6 col-xs-12 control-label">Project Name</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" name="project_name" value="<?php echo $project->project_name; ?>" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">                                        
                        <label class="col-md-6 col-xs-12 control-label"><br>Project Location</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" name="project_location" value="<?php echo $project->project_location; ?>" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">                                        
                        <label class="col-md-6 col-xs-12 control-label"><br>Starting Date</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" name="starting_date" value="<?php echo $project->starting_date; ?>" class="form-control datepicker"/>
                        </div>
                    </div>
                    <div class="form-group">                                        
                        <label class="col-md-6 col-xs-12 control-label"><br>Expected End Date</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" name="expected_end" value="<?php echo $project->expected_end; ?>" class="form-control datepicker"/>
                        </div>
                    </div>
                    <div class="form-group">                                        
                        <label class="col-md-6 col-xs-12 control-label"><br>Size Square Feet</label>
                        <div class="col-md-12 col-xs-12">
                            <input type="text" class="form-control" value="<?php echo $project->size_sqft; ?>" name="size_sqft" />
                        </div>
                        <input type="hidden" name="project_id" value="<?php echo $project->project_id; ?>">
                        <div class="clearfix"></div>
                        <br><br>
                    </div>
                </div>             
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
<?php }?>
<script>
$('.datepicker').datepicker({format: 'yyyy-mm-dd'});

$(document).ready(function (e) {
    $("#ModifyProject").on('submit',(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?php echo base_url(); ?>Projects/ModifyProject",
        type: "POST",             
        data: new FormData(this), 
        contentType: false,       
        cache: false,             
        processData:false,        
        success: function(res)  
        {
            resetTable();
            $('#loadDatas').modal('toggle');
            response = $.parseJSON(res);
            noty({text: response.message, layout: 'topRight', type: response.param});
        }
    });
  }));
});
</script>
