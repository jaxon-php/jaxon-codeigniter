<?php

namespace Jaxon\CI;

class View
{
    protected $data;
    protected $controller;

    public function __construct()
    {
        $this->data = array();
        $this->controller = get_instance();
    }

    /**
     * Make a piece of data available for all views
     *
     * @param string        $name            The data name
     * @param string        $value            The data value
     * 
     * @return void
     */
    public function share($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Render a template
     *
     * @param string        $template        The template path
     * @param string        $data            The template data
     * 
     * @return mixed        The rendered template
     */
    public function render($template, array $data = array())
    {
        return trim($this->controller->load->view($template, array_merge($this->data, $data), true), "\n");
    }
}
