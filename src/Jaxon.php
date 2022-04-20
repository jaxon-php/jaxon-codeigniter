<?php

namespace Jaxon\CodeIgniter;

use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\Response;
use Jaxon\App\AppInterface;
use Jaxon\App\Traits\AppTrait;
use Jaxon\Exception\SetupException;

use function config;
use function rtrim;
use function intval;
use function jaxon;

class Jaxon implements AppInterface
{
    use AppTrait;

    /**
     * The class constructor
     */
    public function __construct()
    {
        $this->initApp(jaxon()->di());
    }

    /**
     * @inheritDoc
     * @throws SetupException
     */
    public function setup(string $sConfigFile)
    {
        // Add the view renderer
        $this->addViewRenderer('codeigniter', '', function() {
            return new View();
        });
        // Set the session manager
        $this->setSessionManager(function() {
            return new Session(Services::session(null, true));
        });
        // Set the logger
        $this->setLogger(Services::logger(true));

        // Load Jaxon config settings
        $aJaxonConfig = config('Jaxon');
        $aLibOptions = $aJaxonConfig->lib ?? [];
        $aAppOptions = $aJaxonConfig->app ?? [];

        // Jaxon library default settings
        $bExport = $bMinify = (CI_ENVIRONMENT === 'production');
        $sJsUrl = rtrim(config('App')->baseURL, '/') . '/jaxon/js';
        $sJsDir = rtrim(FCPATH, '/') . '/jaxon/js';

        $this->bootstrap()
            ->lib($aLibOptions)
            ->app($aAppOptions)
            ->asset($bExport, $bMinify, $sJsUrl, $sJsDir)
            ->setup();
    }

    /**
     * @inheritDoc
     */
    public function httpResponse(string $sCode = '200')
    {
        // Create and return a CodeIgniter HTTP response
        $ajaxResponse = $this->ajaxResponse();
        $httpResponse = new Response(config('App'));

        return $httpResponse
            ->setStatusCode(intval($sCode))
            ->setContentType($ajaxResponse->getContentType(), $this->getCharacterEncoding())
            ->setBody($ajaxResponse->getOutput());
    }
}
