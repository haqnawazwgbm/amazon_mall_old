<?php if (!empty($sale)): ?>
  <?php foreach ($sale as $getone): ?>
    <!-- Token Money -->
    <?php if ($getone->recieved_token != 0): ?>
      <label for="">Recieved Token Amount:  <?php echo $getone->token_money; ?></label><br>
    <?php else: ?>
      <div class="col-md-4">
        <div class="form-control">
          <label for="">Payment Method</label>
            <select name="paid_by" id="" required>
             <option value="Cash">Cash</option>
            </select>
        </div>
       <div class="form-group">
         <label for="">Token Money</label>
         <input type="text" value="<?php echo $getone->token_money; ?>" class="form-control" id="token_money">
         <br>
       
         <input type="button" onclick="Recieve(<?php echo $getone->sale_id ?>,<?php echo $getone->token_money ?>,$('#token_money').val(),'Token')" class="btn btn-primary" value="Recieve Token Money">
       </div>
     </div>
   <?php endif ?>
   <!-- Down Payment -->
   <?php if ($getone->recieved_downpayment != 0): ?>
    <label for="">Received Downpayment:  <?php echo $getone->down_payment; ?></label>
  <?php else: ?>
    <div class="col-md-4">
     <div class="form-group">
       <label for="">Down Payment</label>
       <input type="text" value="<?php echo $getone->down_payment; ?>" class="form-control" id="down_payment">
       <br>
       <input type="button" onclick="Recieve(<?php echo $getone->sale_id ?>,<?php echo $getone->token_money ?>,$('#down_payment').val(),'Down')" class="btn btn-primary" value="Recieve Down Payment">
     </div>
   </div>
 <?php endif ?>
<?php endforeach ?>
<?php endif ?>