<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Process extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load the Jaxon library
        $this->load->library('jaxon');
        // Load the session library
        $this->load->library('session');
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
