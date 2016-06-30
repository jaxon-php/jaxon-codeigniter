<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jaxon
{
    use \Jaxon\Framework\JaxonTrait;

    /**
     * Create a new Jaxon instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->jaxon = \Jaxon\Jaxon::getInstance();
        $this->validator = \Jaxon\Utils\Container::getInstance()->getValidator();
        $this->response = new \Jaxon\CI\Response();
        $this->view = new \Jaxon\CI\View();
    }

    /**
     * Initialise the Jaxon library.
     *
     * @return void
     */
    public function setup()
    {
        // This function should be called only once
        if(($this->setupCalled))
        {
            return;
        }
        $this->setupCalled = true;

        // Load Jaxon config settings
        $ci = get_instance();
        $ci->config->load('jaxon', true);
        // Jaxon application settings
        $appConfig = $ci->config->item('app', 'jaxon');
        $controllerDir = (array_key_exists('dir', $appConfig) ? $appConfig['dir'] : APPPATH . 'jaxon');
        $namespace = (array_key_exists('namespace', $appConfig) ? $appConfig['namespace'] : '\\Jaxon\\App');

        $excluded = (array_key_exists('excluded', $appConfig) ? $appConfig['excluded'] : array());
        // The public methods of the Controller base class must not be exported to javascript
        $controllerClass = new \ReflectionClass('\\Jaxon\\CI\\Controller');
        foreach ($controllerClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $xMethod)
        {
            $excluded[] = $xMethod->getShortName();
        }
        // Use the Composer autoloader
        $this->jaxon->useComposerAutoloader();
        // Jaxon library default options
        $this->jaxon->setOptions(array(
            'js.app.extern' => !$ci->config->item('debug'),
            'js.app.minify' => !$ci->config->item('debug'),
            'js.app.uri' => $ci->config->item('base_url') . 'jaxon/js',
            'js.app.dir' => FCPATH . 'jaxon/js',
        ));
        // Jaxon library settings
        $libConfig = $ci->config->item('lib', 'jaxon');
        \Jaxon\Config\Config::setOptions($libConfig);
        // Set the request URI
        if(!$this->jaxon->getOption('core.request.uri'))
        {
            $this->jaxon->setOption('core.request.uri', 'jaxon');
        }
        // Register the default Jaxon class directory
        $this->jaxon->addClassDir($controllerDir, $namespace, $excluded);
    }
}
