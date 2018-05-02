
            //   Morris.Bar({
            //     element: 'dashboard-bar-1',
            //     data: [
            //     <?php if(!empty($pay['Unit'])): ?>
            //         <?php 
            //         print_r($pay['Unit']);
            //         die;
            //         foreach ($pay as $bars):
            //             foreach ($bars as $one): ?>
            //                 { y: '<?php echo $one->price_sqft; ?>', a: <?php echo $one->change_in_price; ?>},
            //             <?php endforeach ?>
            //         <?php endforeach ?>
            //     <?php else: ?>
            //     { y: '2014-10-15', a: 9,b: 12},
            //     <?php endif; ?>
            //     ],
            //     xkey: 'y',
            //     ykeys: ['a'],
            //     labels: ['Sales'],
            //     barColors: ['#33414E', '#1caf9a'],
            //     gridTextSize: '10px',
            //     hideHover: true,
            //     resize: true,
            //     gridLineColor: '#E5E5E5'
            // });