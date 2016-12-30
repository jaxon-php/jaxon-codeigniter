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
    protected function jaxonSetup()
    {
        // Load Jaxon config settings
        $ci = get_instance();
        $ci->config->load('jaxon', true);
        $libConfig = $ci->config->item('lib', 'jaxon');
        $appConfig = $ci->config->item('app', 'jaxon');

        // Jaxon library settings
        $jaxon = jaxon();
        $jaxon->setOptions($libConfig);

        // Jaxon application settings
        $this->appConfig = new \Jaxon\Utils\Config();
        $this->appConfig->setOptions($appConfig);

        // Jaxon library default settings
        $isDebug = $ci->config->item('debug');
        $baseUrl = rtrim($ci->config->item('base_url'), '/') ;
        $baseDir = rtrim(FCPATH, '/');
        $this->setLibraryOptions(!$isDebug, !$isDebug, $baseUrl . '/jaxon/js', $baseDir . '/jaxon/js');

        // Jaxon application default settings
        $this->setApplicationOptions(rtrim(APPPATH, '/') . '/jaxon/controllers', '\\Jaxon\\App');

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
    protected function jaxonCheck()
    {
        // Todo: check the mandatory options
    }

    /**
     * Return the view renderer.
     *
     * @return void
     */
    protected function jaxonView()
    {
        if($this->jaxonViewRenderer == null)
        {
            $this->jaxonViewRenderer = new \Jaxon\CI\View();
        }
        return $this->jaxonViewRenderer;
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
            ->set_content_type($this->jaxonResponse->getContentType(), $this->jaxonResponse->getCharacterEncoding())
            ->set_output($this->jaxonResponse->getOutput())
            ->_display();
    }
}
