<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends Xajax_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	// Default method of the CI controllers
	public function index()
	{
		// Register Xajax classes
		$this->xajax->register();

		// Print the page
		$this->load->view('my_view');
	}
}
