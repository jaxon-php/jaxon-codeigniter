<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_Controller extends Xajax_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    // Default method of the CI controllers
    public function index()
    {
        // Setup the Xajax library
        $this->setupXajax();
    	// Register Xajax classes
        $this->xajax->register();

        // Print the page
        $this->load->view('my_view');
    }
}
