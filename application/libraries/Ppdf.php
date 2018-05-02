<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
 
include_once APPPATH.'/third_party/mpdf-master/mpdf.php';
 
class Ppdf {
 
	public $param;
	public $pdf;
	public function __construct($param = "'c', 'A4-L'")
	{
	    $this->param =$param;
	    $this->pdf = new mPDF($this->param);
	}
}



?>