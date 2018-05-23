<table class="table">
    <tr>
        <th>Token Money</th>
        <td><?php if(!empty($sale)){ echo 'Rs.'.$sale[0]->token_money;} ?></td>
        <th>Client</th>
        <td><?= ucfirst($sale[0]->fullname); ?></td>
    </tr>
    <tr>
        <th>Down Payment</th>
        <td><?php if(!empty($sale)){ echo 'Rs.'.$sale[0]->down_payment;} ?></td>
    </tr>
    <?php $i=1; foreach ($insta as $one): ?>
    <tr>
        <th>Installment <?php echo $i; ?></th>
        <td><?php echo 'Rs.'.$one->paid; ?></td>
    </tr>
    <?php $i++; endforeach ?>
    <tr>
        <th>Total Amount</th>
        <td><?php if(!empty($Total)){ echo 'Rs.'.$Total;} ?></td>
        
    </tr>
    <tr>
        <th>Received Amount</th>
        <td><?php if(!empty($Paid)){ echo 'Rs.'.$Paid;} ?></td>
    </tr>
    <tr>
        <th>Remaining Amount</th>
        <td><?php $sum = $Total-$Paid; echo 'Rs.'.$sum; ?></td>
    </tr>
</table>