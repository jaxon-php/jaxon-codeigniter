<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Process extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load the Jaxon library
        $this->load->library('jaxon');
    }

    public function index()
    {
        // Process the Jaxon request
        if($this->jaxon->canProcessRequest())
        {
            $this->jaxon->processRequest();
        }
    }
}
