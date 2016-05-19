<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(__DIR__ . '/../Xajax_Controller.php');

class Process extends Xajax_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // Process the Xajax request
        if($this->xajax->canProcessRequest())
        {
            $this->xajax->processRequest();
        }
    }
}
