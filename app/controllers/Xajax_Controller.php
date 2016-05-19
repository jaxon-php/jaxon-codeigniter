<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Xajax_Controller extends CI_Controller
{
    public $xajax = null;

    public function __construct()
    {
        parent::__construct();
        // Setup the Xajax library
        $this->load->library('xajax');
        $this->xajax->setup();
    }
}
