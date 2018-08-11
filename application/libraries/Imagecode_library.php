<?php

	class Imagecode_library 
	{
		private $ci;

		public function __construct() 
		{

		}

		public function write_qrcode($data, $file) 
		{
			include_once dirname(__FILE__) . '/../third_party/phpqrcode/qrlib.php';
			QRcode::png($data, $file , QR_ECLEVEL_L , 10 , 2);
		}

		public function render_qrcode($data) 
		{
			include_once dirname(__FILE__) . '/../third_party/phpqrcode/qrlib.php';
			QRcode::png($data , false , QR_ECLEVEL_L , 10 , 2);
		}

		public function write_barcode($data, $file) 
		{
			include_once dirname(__FILE__) . '/../third_party/phpbarcode/barcode.php';
			draw_barcode($data, $file);
		}

		public function render_barcode($data) 
		{
			include_once dirname(__FILE__) . '/../third_party/phpbarcode/barcode.php';
			draw_barcode($data);
		}
	}
