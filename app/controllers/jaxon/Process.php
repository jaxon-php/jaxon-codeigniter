<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(__DIR__ . '/../Jaxon_Controller.php');

class Process extends Jaxon_Controller
{
    public function __construct()
    {
        parent::__construct();
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
