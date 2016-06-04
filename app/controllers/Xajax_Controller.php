<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jaxon_Controller extends CI_Controller
{
    public $jaxon = null;

    public function __construct()
    {
        parent::__construct();
        // Setup the Jaxon library
        $this->load->library('jaxon');
        $this->jaxon->setup();
    }
}
