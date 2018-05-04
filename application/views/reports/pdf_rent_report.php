<style>
    th{
        font-size: 11px !important;
        text-align: left !important;
    }
    td{
        font-size: 11px !important;
    }
</style>
<?php $this->load->view('reports/header'); ?>
<h3 style="padding-left:0.7em; line-height:36px; background:#f4f4f4;"><?php echo $project[0]->project_name;?></h3>
<div class="col-md-12">
        <div class="clearfix"></div>
        <table class="table" style="width: 100% !important;">
         <tr>
        <th>Client</th>
        <th>Project</th>
        <th>Floor</th>
        <th>Unit</th>
        <th>Size/sqft</th>
        <th>Rent/sqft</th>
        <th>Rent</th>
        <th>Days</th>
    </tr>
    <?php $total_rent = 0;
          $days = 0;

         if (!empty($sales)): ?>
    <?php foreach ($sales as $sale): 
        
        if ($sale->installment_days < 30 && $sale->installment_days != '') {
                $rent = $sale->total_rent / 30;
                $rent = $rent * $sale->installment_days;
                $days = $sale->installment_days;
            } elseif ($sale->sale_days < 30 && $sale->installment_days == '') {
                $rent = $sale->total_rent / 30;
                $rent = $rent * $sale->sale_days;
                $days = $sale->sale_days;
            } elseif ($sale->sale_days > 30 && $sale->installment_days == '') {
                $rent = $sale->total_rent;
                $days = $sale->sale_days;
            } else {
                $rent = $sale->total_rent;
                $days = $sale->installment_days;
        }
        $total_rent = $total_rent + $rent;
    ?>
    <tr>
        <td><?php echo $sale->fullname; ?></td>
        <td><?php echo $sale->project_name; ?></td>
        <td><?php echo $sale->floor_types; ?></td>
        <td><?php echo $sale->unit_type; ?></td>
        <td><?php echo $sale->size_sqft; ?></td>
        <td><?php echo $sale->rent_sqft; ?></td>
        <td><?php echo number_format((float)$rent, 2, '.', ''); ?></td>
        <td><?php if ($days < 30) {
            echo $days == 0 ? 0 : $days; echo ' Days';
        } else {
            echo '1 month';
         
        }
        ?></td>
    </tr>
    <?php endforeach ?>
    <tr>
        <td colspan="5"></td><th>Total Rent:</th><td><?php echo number_format((float)$total_rent, 2, '.', ''); ?></td>
    </tr>
    <?php else: ?>
    <tr>
        <td colspan="7"> No Results Found</td>
    </tr>
    <?php endif ?>
        </table>
</div>
<?php $this->load->view('reports/footer'); ?>
