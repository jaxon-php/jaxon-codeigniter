<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require (APPPATH . '../vendor/autoload.php');

use Xajax\Xajax;

class Xajax_Controller extends CI_Controller
{
	protected $xajax = null;

	public function __construct()
	{
		parent::__construct();
		// Setup the Xajax library
		$this->xajax = $this->load->library('xajax');
		$this->xajax->setup();
	}

	// Default method of the CI controllers
	public function index()
	{
		// Process the Xajax request
		if($this->xajax->canProcessRequest())
		{
			$this->xajax->processRequest();
		}
	}
}
