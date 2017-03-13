<?php

namespace Jaxon\CI;

use Jaxon\Module\View\Store;
use Jaxon\Module\View\Facade;

class View extends Facade
{
    protected $controller;

    public function __construct()
    {
        parent::__construct();
        $this->controller = get_instance();
    }

    /**
     * Render a view
     * 
     * @param Store         $store        A store populated with the view data
     * 
     * @return string        The string representation of the view
     */
    public function make(Store $store)
    {
        // Render the template
        return trim($this->controller->load->view($store->getViewPath(), $store->getViewData(), true), " \t\n");
    }
}
