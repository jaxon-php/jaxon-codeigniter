<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jaxon
{
    use \Jaxon\Module\Traits\Module;

    /**
     * Set the module specific options for the Jaxon library.
     *
     * @return void
     */
    protected function setup()
    {
        // Load Jaxon config settings
        $ci = get_instance();
        $ci->config->load('jaxon', true);
        $libConfig = $ci->config->item('lib', 'jaxon');
        $appConfig = $ci->config->item('app', 'jaxon');

        // Jaxon library settings
        $jaxon = jaxon();
        $jaxon->setOptions($libConfig);
        // Default values
        if(!$jaxon->hasOption('js.app.extern'))
        {
            $jaxon->setOption('js.app.extern', !$ci->config->item('debug'));
        }
        if(!$jaxon->hasOption('js.app.minify'))
        {
            $jaxon->setOption('js.app.minify', !$ci->config->item('debug'));
        }
        if(!$jaxon->hasOption('js.app.uri'))
        {
            $jaxon->setOption('js.app.uri', $ci->config->item('base_url') . 'jaxon/js');
        }
        if(!$jaxon->hasOption('js.app.dir'))
        {
            $jaxon->setOption('js.app.dir', FCPATH . 'jaxon/js');
        }

        // Jaxon application settings
        $this->appConfig = new \Jaxon\Utils\Config();
        $this->appConfig->setOptions($appConfig);
        // Default values
        if(!$this->appConfig->hasOption('controllers.directory'))
        {
            $this->appConfig->setOption('controllers.directory', APPPATH . 'jaxon');
        }
        if(!$this->appConfig->hasOption('controllers.namespace'))
        {
            $this->appConfig->setOption('controllers.namespace', '\\Jaxon\\App');
        }
        if(!$this->appConfig->hasOption('controllers.protected') || !is_array($this->appConfig->getOption('protected')))
        {
            $this->appConfig->setOption('controllers.protected', array());
        }
        // Jaxon controller class
        $this->setControllerClass('\\Jaxon\\CI\\Controller');
    }

    /**
     * Set the module specific options for the Jaxon library.
     *
     * This method needs to set at least the Jaxon request URI.
     *
     * @return void
     */
    protected function check()
    {
        // Todo: check the mandatory options
    }

    /**
     * Return the view renderer.
     *
     * @return void
     */
    protected function view()
    {
        if($this->viewRenderer == null)
        {
            $this->viewRenderer = new \Jaxon\CI\View();
        }
        return $this->viewRenderer;
    }

    /**
     * Wrap the Jaxon response into an HTTP response.
     *
     * @param  $code        The HTTP Response code
     *
     * @return HTTP Response
     */
    public function httpResponse($code = '200')
    {
        // Create and return a CodeIgniter HTTP response
        get_instance()->output
            ->set_status_header($code)
            ->set_content_type($this->response->getContentType(), $this->response->getCharacterEncoding())
            ->set_output($this->response->getOutput())
            ->_display();
    }
}
