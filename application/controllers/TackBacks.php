<?php  

/**
*. Sales Controller 
*/

class TackBacks extends General_Functions
{
	
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('logged') != true) {
			redirect(base_url().'Login');
		}
		$type = $this->session->userdata('user_type');
		if ($type != "Admin" && $type != 'Accountant' && $type != 'ccd') {
			redirect(base_url().'Login');
		}
	}

	function index()
	{
		$this->load->view('sales/sale');
	}

	function get_tack_backs() {
		$this->load->view('tack/get_tack')
	}


}
?>