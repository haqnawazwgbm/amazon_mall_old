

 <!-- Modal -->
    <div class="modal fade" id="edit-installments-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Sale Unit</h5>
            </div>
            <div id="edit-installments"></div>
                <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                         <div class="col-md-12" style="margin-top: 1em; margin-left: 1.5em;">
						<br>
						<br>
						<table class="table table-striped">
							<tr>
								<th>S.no</th>
								<!-- <th>Month</th> -->
								<!-- <th>Year</th> -->
								<th>Amount</th>
							</tr>
							<?php if (!empty($installments)): ?>
								<?php 
									$i = 1 ;foreach ($installments as $eachone => $data): 
									$date = explode('|', $data['date']);
								?>
									<tr>
										<td><?php echo $i; ?></td>
										<!-- <td><?php //echo $date[0]; ?></td> -->
										<!-- <td><?php //echo $date[1]; ?></td> -->
										<td><?php echo 'Rs. '.$data['Installment']; ?></td>
									</tr>
								<?php $i++; endforeach ?>
							<?php endif ?>
						</table>
                        
                        <div class="clearfix"></div>
                        <br> <br>
                    </div>              
                </div>

                <div class="modal-footer">
                    <div class="clearfix"></div>
						<button onclick="selectEditStructure(<?= $size.','.$price; ?>)" class="btn btn-primary pull-right">Select Structure</button>
					</div>
                </div>
            </div> 
        </div>
    </div>
    <script>
    		function selectEditStructure(size, price) {
    			$('#size_sqft').val(size);
    			$('#price_sqft').val(price);
    			var data = $('#sale-edit-form').serialize();
    			console.log(data);
    			  $.ajax({
		            url: '<?php echo base_url("Sales/update_installments")?>',
		            type: 'POST',
		            data: data,
		        })
		        .done(function(res) {
		            resetTable();
           			noty({text: res.message, layout: 'topRight', type: res.param});
           			$('#edit-installments-model').modal('hide');
		        })
    		}
    
    </script>