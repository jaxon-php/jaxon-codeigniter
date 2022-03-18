<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

use Jaxon\CI\View;
use Jaxon\CI\Session;
use Jaxon\CI\Logger;

use function rtrim;
use function get_instance;
use function jaxon;

class Jaxon
{
    use \Jaxon\App\AppTrait;

    /**
     * The constructor
     */
    public function __construct()
    {
        $this->jaxon = jaxon();
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
        // Set the default view namespace
        $this->addViewNamespace('default', '', '', 'codeigniter');
        // Add the view renderer
        $this->addViewRenderer('codeigniter', function() {
            return new View();
        });
        // Set the session manager
        $this->setSessionManager(function() {
            return new Session();
        });
        // Set the logger
        $this->setLogger(new Logger());

        // Load Jaxon config settings
        $ci = get_instance();
        $ci->config->load('jaxon', true);
        $aLibOptions = $ci->config->item('lib', 'jaxon');
        $aAppOptions = $ci->config->item('app', 'jaxon');

        // Jaxon library default settings
        $bIsDebug = $ci->config->item('debug');
        $sJsUrl = rtrim($ci->config->item('base_url'), '/') . '/jaxon/js';
        $sJsDir = rtrim(FCPATH, '/') . '/jaxon/js';

        $this->bootstrap()
            ->lib($aLibOptions)
            ->app($aAppOptions)
            // ->uri($sUri)
            ->js(!$bIsDebug, $sJsUrl, $sJsDir, !$bIsDebug)
            ->setup();
    }

    /**
     * @inheritDoc
     */
    public function httpResponse(string $sCode = '200')
    {
        // Get the reponse to the request
        $jaxonResponse = $this->jaxon->getResponse();

        // Create and return a CodeIgniter HTTP response
        get_instance()->output
            ->set_status_header($sCode)
            ->set_content_type($jaxonResponse->getContentType(), $this->getCharacterEncoding())
            ->set_output($jaxonResponse->getOutput());
            // ->_display();
    }
}
