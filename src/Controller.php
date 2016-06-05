<?php

namespace Jaxon\CI;

class Controller
{
    use \Jaxon\Request\FactoryTrait;

    // Application data
    // These data will be set by the CI Jaxon library when registering the controller
    public $view = null;
    public $ci_jaxon = null; // CI Jaxon library
    public $response = null;

    /**
     * Create a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {}

    /**
     * Initialise the controller.
     *
     * @return void
     */
    public function init()
    {}

    /**
     * Find an Jaxon controller by name
     *
     * @param string $method the name of the method
     * 
     * @return object the Jaxon controller, or null
     */
    public function controller($name)
    {
        // If the class name starts with a dot, then find the class in the same class path as the caller
        if(substr($name, 0, 1) == '.')
        {
            $name = $this->getJaxonClassPath() . $name;
        }
        // The controller namespace is prepended to the class name
        else if(($namespace = $this->getJaxonNamespace()))
        {
            $name = str_replace(array('\\'), array('.'), trim($namespace, '\\')) . '.' . $name;
        }
        return (($this->ci_jaxon) ? $this->ci_jaxon->controller($name) : null);
    }
}
