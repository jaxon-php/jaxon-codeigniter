<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jaxon
{
    use \Jaxon\Sentry\Traits\Armada;

    /**
     * Set the module specific options for the Jaxon library.
     *
     * @return void
     */
    protected function jaxonSetup()
    {
        // Load Jaxon config settings
        $ci = get_instance();
        $ci->config->load('jaxon', true);
        $libConfig = $ci->config->item('lib', 'jaxon');
        $appConfig = $ci->config->item('app', 'jaxon');

        // Jaxon library settings
        $jaxon = jaxon();
        $sentry = jaxon()->sentry();
        $jaxon->setOptions($libConfig);

        // Jaxon application settings
        $this->appConfig = new \Jaxon\Utils\Config();
        $this->appConfig->setOptions($appConfig);

        // Jaxon library default settings
        $isDebug = $ci->config->item('debug');
        $baseUrl = rtrim($ci->config->item('base_url'), '/') ;
        $baseDir = rtrim(FCPATH, '/');
        $sentry->setLibraryOptions(!$isDebug, !$isDebug, $baseUrl . '/jaxon/js', $baseDir . '/jaxon/js');

        // Set the default view namespace
        $sentry->addViewNamespace('default', '', '', 'codeigniter');
        $this->appConfig->setOption('options.views.default', 'default');

        // Add the view renderer
        $sentry->addViewRenderer('codeigniter', function(){
            return new \Jaxon\CI\View();
        });

        // Set the session manager
        $sentry->setSessionManager(function(){
            return new Jaxon\CI\Session();
        });
    }

    /**
     * Set the module specific options for the Jaxon library.
     *
     * This method needs to set at least the Jaxon request URI.
     *
     * @return void
     */
    protected function jaxonCheck()
    {
        // Todo: check the mandatory options
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
            ->set_content_type($this->ajaxResponse()->getContentType(), $this->ajaxResponse()->getCharacterEncoding())
            ->set_output($this->ajaxResponse()->getOutput())
            ->_display();
    }
}
