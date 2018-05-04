<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
 
include_once APPPATH.'/third_party/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
class Xls {
 
	public $param;
	public $spreadsheet;
	public $excel;
	public $io_factory;
	public function __construct($param = "'A1'")
	{
	    $this->param =$param;
	    $this->spreadsheet = new Spreadsheet();
	    $this->excel = new Xlsx($this->spreadsheet);
	    $this->io_factory = IOFactory::createWriter($this->spreadsheet, 'Ods');
	}
}



?>