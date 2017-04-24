<?php

namespace Jaxon\CI;

use Jaxon\Module\View\Store;
use Jaxon\Module\Interfaces\View as ViewRenderer;

class View implements ViewRenderer
{
    protected $controller;

    public function __construct()
    {
        $this->controller = get_instance();
    }

    /**
     * Add a namespace to this view renderer
     *
     * @param string        $sNamespace         The namespace name
     * @param string        $sDirectory         The namespace directory
     * @param string        $sExtension         The extension to append to template names
     *
     * @return void
     */
    public function addNamespace($sNamespace, $sDirectory, $sExtension = '')
    {}

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
        return trim($this->controller->load->view($store->getViewName(), $store->getViewData(), true), " \t\n");
    }
}
