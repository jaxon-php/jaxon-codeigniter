<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Process extends CI_Controller
{
    /**
     * Load the Jaxon and Session libraries.
     */
    public function __construct()
    {
        parent::__construct();
        // Load the Jaxon library
        $this->load->library('jaxon');
        // Load the session library
        $this->load->library('session');
    }

    /**
     * Process a Jaxon request.
     *
     * The HTTP response is automatically sent back to the browser
     *
     * @return void
     */
    public function index()
    {
        $this->jaxon->callback()->before(function ($target, &$bEndRequest) {
            /*
            if($target->isFunction())
            {
                $function = $target->getFunctionName();
            }
            elseif($target->isClass())
            {
                $class = $target->getClassName();
                $method = $target->getMethodName();
                // $instance = $this->jaxon->instance($class);
            }
            */
        });
        $this->jaxon->callback()->after(function ($target, $bEndRequest) {
            /*
            if($target->isFunction())
            {
                $function = $target->getFunctionName();
            }
            elseif($target->isClass())
            {
                $class = $target->getClassName();
                $method = $target->getMethodName();
            }
            */
        });

        // Process the Jaxon request
        if($this->jaxon->canProcessRequest())
        {
            $this->jaxon->processRequest();
            $this->jaxon->httpResponse();
        }
    }
}
