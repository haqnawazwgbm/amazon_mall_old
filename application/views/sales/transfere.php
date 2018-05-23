
                          <div class="col-md-12" id="transfereForm" style="display: none;">
                            <div class="panel panel-danger">
                                <div class="panel-body">
                                    <h4>Resell Money</h4>
                                    <div class="col-md-7">
                                        <div id="resellReport"></div>
                                    </div>
                                    <div class="col-md-5">
                                        <form id="resellMoney" method="POST" action="<?= base_url(); ?>Sales/resale">
                                            <div class="form-group" id="users">
                                                <label for="">Customers</label>
                                              
                                            </div>
                                            <input type="hidden" name="sale_id" id="sale_id" value="">
                                            <input type="hidden" name="from_user_id" id="from_user_id" value="">
                                            <div class="form-group">
                                                <label for="">Transfer Fee</label>
                                                <input type="text" readonly value="" class="form-control" id="transfer_fee" name="transfer_fee" required>
                                                <br>
                                                <input type="submit" class="btn btn-primary" value="Transfere">
                                                <input type="button" id="cancelTransfere" class="btn btn-primary cancel" value="Cancel">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
<script>
    function showTransfereFrom(saleid,userid,area)
    {
        var area = area*50;
        $('#transfer_fee').val(area);
        $('#sale_id').val(saleid);
        $('#from_user_id').val(userid);
        $('#forTackback').hide();
        $('#transfereForm').show();
        $.post('<?php echo base_url('Sales/TackBackRe/transfer') ?>', {sale:saleid,user:userid}, function(data, textStatus, xhr) {
            $('#resellReport').html(data);
        });
        // Get all users
        $.post('<?php echo base_url('Cif/getUsers/') ?>' + userid, {}, function(data, textStatus, xhr) {
            $('#users').find('.bootstrap-select').remove();
            $('#users').children().after(data);
            $('#to_user_id').selectpicker('render');
            
        });
    }
    // Saving User To Database
$(document).ready(function (e) {
    $("#resellMoney").on('submit',(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= base_url(); ?>Sales/resale",
        type: "POST",             
        data: new FormData(this), 
        contentType: false,       
        cache: false,             
        processData:false,        
        success: function(res)  
        {
            resetTable();
            $('#transfereForm').hide();
            $('#FinalUploadArea').show();
            $('#sales').hide();
            $('#from_user_id').val('');
            response = $.parseJSON(res);
            $('input[id="sold_id"]').each(function() {
                $(this).val(response.sale_id);
            });
            noty({text: response.message, layout: 'topRight', type: response.param});
        }
    });
  }));
    // Updating Customer Details End Here

        $('#showVideo').click(function(){
            $('#video,#snap').toggle();
        });
});
// Grab elements, create settings, etc.
var video = document.getElementById('video');
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var video = document.getElementById('video');
// Trigger photo take
document.getElementById("snap").addEventListener("click", function() {
    mengo = context.drawImage(video, 0, 0, 640, 480);
    image = canvas.toDataURL("image/png");
    appendFileAndSubmit(image);
});

function appendFileAndSubmit(image){
    data  = '';
    sale_id = $('#sold_id').val();
    Update = $('#reassignid').val();
    if ( Update == '' || Update == 'undefined') {
        data = { 
            baseencoded:image,
            sale:sale_id
        }
    }
    else
    {
        data = { 
            baseencoded:image,
            sale:sale_id,
            update:Update
        }
    }
    $.ajax({
        url: '<?php echo base_url('Cif/converCamerImageToFile'); ?>',
        type: 'POST',
        data: data,
    })
    .done(function(res) {
        $('#video').hide();
        $('#ImageConverted').html(res);
    });
}


function convertCanvasToImage(canvas) {
    var image = new Image();
    image.src = canvas.toDataURL("image/png");
    return image;
}
// Get access to the camera!
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    // Not adding `{ audio: true }` since we only want video now
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        video.src = window.URL.createObjectURL(stream);
        video.play();
    });
}
else if(navigator.getUserMedia) { 
    navigator.getUserMedia({ video: true }, function(stream) {
        video.src = stream;
        video.play();
    }, errBack);
} else if(navigator.webkitGetUserMedia) { 
    navigator.webkitGetUserMedia({ video: true }, function(stream){
        video.src = window.webkitURL.createObjectURL(stream);
        video.play();
    }, errBack);
} else if(navigator.mozGetUserMedia) { 
    navigator.mozGetUserMedia({ video: true }, function(stream){
        video.src = window.URL.createObjectURL(stream);
        video.play();
    }, errBack);
}
</script>