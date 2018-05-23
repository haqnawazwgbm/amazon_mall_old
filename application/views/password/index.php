<?php $this->load->view('incs/header.php') ?> 
<style>

td, th {
    padding: 10px 0px;
    border-bottom: thin solid rgba(0,0,0,0.2);
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
            <?php $this->load->view('incs/header_topbar.php') ?>
            <!-- END X-NAVIGATION VERTICAL -->                     

            <!-- PAGE CONTENT WRAPPER -->
            <div class="page-content-wrap">                

                <div class="row">
                    <div class="col-md-6">
                        <!-- START DEFAULT DATATABLE -->
                        <div class="panel panel-default">
                            <div class="panel-heading">                                
                                <h3 class="panel-title">Change Password</h3>
                            </div>
                            <div class="panel-body">
                             <form name="aForm" id="SaveUnitDetails">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="clearfix"></div>
                                            <div class="form-group">                                        
                                                <label class="control-label"><br>Enter Old Password</label>
                                                <input type="text" id="old" name="old" class="form-control" required />
                                            </div>
                                            <div class="form-group">                                        
                                                <label class="control-label"><br>Enter New Password</label>
                                                <input type="text" id="new" name="new" class="form-control" required />
                                            </div>
                                            <div class="clearfix"></div>
                                            <br> <br>
                                        </div>              
                                    </div>

                                    <div class="modal-footer">
                                         <input type="button" onclick="GeneratePassword()" class="btn btn-primary" value="Generate Password">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" disabled id="submit" class="btn btn-primary">Update Password</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    </div>

                </div>                                

            </div>
            <!-- PAGE CONTENT WRAPPER -->                                     
        </div>            
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END PRELOADS -->  
    <!-- Performing Edit/ View -->
    <?php $this->load->view('incs/jquery-footer') ?>  
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>    
    <script>

// Saving User To Database
$(document).ready(function (e) {
        $("#SaveUnitDetails").validate({
               rules: {
                   new: { 
                     required: true,
                     pwcheck: true,
                        minlength: 10,
                        maxlength: 15,

                   }

               },
         messages:{
             new: { 
                     required:"the password is required",
                     pwcheck: "the password must consist at least one digit, lowercase and upercase!"

                   }
         }
    });
    $.validator.addMethod("pwcheck", function(value) {
       return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
           && /[a-z]/.test(value) // has a lowercase letter
           && /[A-Z]/.test(value) // has a uppercase leter
           && /\d/.test(value) // has a digit
    });

    $("#SaveUnitDetails").on('submit',(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?php echo base_url(); ?>Password/changePassword",
        type: "POST",             
        data: new FormData(this), 
        contentType: false,       
        cache: false,             
        processData:false,        
        success: function(res)  
        {
            response = $.parseJSON(res);
            noty({text: response.message, layout: 'topRight', type: response.param});
            if (reponse.clear == 1) 
            {
                $('SaveUnitDetails')[0].clear();
            }
        }
    });
  }));
    

    $('#SaveUnitDetails input').bind('keyup blur click', function () { // fires on every keyup & blur
            if ($('#SaveUnitDetails').validate().checkForm()) {                   // checks form for validity
                $('#submit').removeClass('button_disabled').attr('disabled', false); // enables button
            } else {
                $('#submit').addClass('button_disabled').attr('disabled', true);   // disables button
            }
    });
  
});


</script>
<script language="JavaScript">

function GeneratePassword() {
    if (parseInt(navigator.appVersion) <= 3) {
        alert("Sorry this only works in 4.0+ browsers");
        return true;
    }

    var length=10;
    var sPassword = "";

    var noPunction = true;
    var randomLength = false;

    if (randomLength) {
        length = Math.random();

        length = parseInt(length * 100);
        length = (length % 7) + 6
    }


    for (i=0; i < length; i++) {

        numI = getRandomNum();
        if (noPunction) { while (checkPunc(numI)) { numI = getRandomNum(); } }

        sPassword = sPassword + String.fromCharCode(numI);
    }

    document.aForm.new.value = sPassword

    return true;
}

function getRandomNum() {

    // between 0 - 1
    var rndNum = Math.random()

    // rndNum from 0 - 1000
    rndNum = parseInt(rndNum * 1000);

    // rndNum from 33 - 127
    rndNum = (rndNum % 94) + 33;

    return rndNum;
}

function checkPunc(num) {

    if ((num >=33) && (num <=47)) { return true; }
    if ((num >=58) && (num <=64)) { return true; }
    if ((num >=91) && (num <=96)) { return true; }
    if ((num >=123) && (num <=126)) { return true; }

    return false;
}

</script>
</body>
</html>






