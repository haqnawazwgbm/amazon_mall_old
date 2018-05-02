<?php 
if (!empty($getAgent)) { 
$profile =json_decode($getAgent)[0];
?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"> <?php echo $profile->title.' '.$profile->fullname; ?> </h5>
</div>
<div class="modal-body">
    <div class="row">
        <table class="table">
            <tr>
                <th>Fullname:</th>
                <td><?php echo $profile->title.' '.$profile->fullname; ?></td>
                <th>Email:</th>
                <td><?php echo $profile->fullname; ?></td>
            </tr>
            <tr>
                <th>Phone:</th>
                <td><?php echo $profile->fullname; ?></td>
                <th>Phone (Optional):</th>
                <td><?php echo $profile->fullname; ?></td>
            </tr>
            <tr>
                <th>Address:</th>
                <td><?php echo $profile->address; ?></td>
                <th>Nationality:</th>
                <td><?php echo $profile->nationality; ?></td>
            </tr>
            <tr>
                <th>Country:</th>
                <td><?php echo $profile->country; ?></td>
                <th>Province:</th>
                <td><?php echo $profile->province; ?></td>
            </tr>
            <tr>
                <th>City:</th>
                <td><?php echo $profile->city; ?></td>
                <th>District:</th>
                <td><?php echo $profile->district; ?></td>
            </tr>
        </table>          
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>
<?php } ?>