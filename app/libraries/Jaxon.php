<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Jaxon
{
    use \Jaxon\Features\App;

    public function __construct()
    {
        // Initialize the Jaxon plugin
        $this->setup();
    }

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
        $aLibOptions = $ci->config->item('lib', 'jaxon');
        $aAppOptions = $ci->config->item('app', 'jaxon');

        // Jaxon library default settings
        $bIsDebug = $ci->config->item('debug');
        $sJsUrl = rtrim($ci->config->item('base_url'), '/') . '/jaxon/js';
        $sJsDir = rtrim(FCPATH, '/') . '/jaxon/js';

        $di = jaxon()->di();
        $viewManager = $di->getViewmanager();
        // Set the default view namespace
        $viewManager->addNamespace('default', '', '', 'codeigniter');
        // Add the view renderer
        $viewManager->addRenderer('codeigniter', function () {
            return new \Jaxon\CI\View();
        });

        // Set the session manager
        $di->setSessionManager(function () {
            return new Jaxon\CI\Session();
        });

        $this->bootstrap()
            ->lib($aLibOptions)
            ->app($aAppOptions)
            // ->uri($sUri)
            ->js(!$bIsDebug, $sJsUrl, $sJsDir, !$bIsDebug)
            ->run(false);
    }

    /**
     * Wrap the Jaxon response into an HTTP response.
     *
     * @param  $code        The HTTP Response code
     *
     * @return void
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
