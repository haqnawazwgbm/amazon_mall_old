<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*. Sales Controller 
*/

class Send_sms extends General_Functions
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('Curl');
	
	}

	function index()
	{
		$this->curl->create('http://api.bizsms.pk/api-send-branded-sms.aspx?username=amazonmall@bizsms.pk&pass=81longcourse&text=abc&masking=Amazonmall&destinationnum=923085356405&language=English');
		$this->curl->option('buffersize', 10);
		var_dump($this->curl->execute());
/*		$result = $this->curl->simple_get('http://api.bizsms.pk/api-send-branded-sms.aspx?username=amazonmall@bizsms.pk
&pass=81longcourse&text=abc&masking=Demo&destinationnum=923085356405&language=English', array(CURLOPT_PORT => 8080));
		var_dump($result);*/
		exit;	
	}
}
?>