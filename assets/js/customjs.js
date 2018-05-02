// Authentication
	 function performAction(Action) {
	 	console.log(Action);
		$.ajax({
			url: '<?php echo base_url();?>Master/',
			type: 'POST',
			data: Action,
		})
		.done(function(response) {
			loadDataintoTable();
			noty({text: response.message, layout: 'topRight', type: response.param});
		})
	}
