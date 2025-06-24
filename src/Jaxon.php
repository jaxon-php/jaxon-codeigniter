<?php

namespace Jaxon\CodeIgniter;

use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\Response;
use Jaxon\App\Ajax\AbstractApp;
use Jaxon\App\Ajax\AppInterface;
use Jaxon\Exception\SetupException;

use function config;
use function rtrim;
use function intval;
use function Jaxon\jaxon;

class Jaxon extends AbstractApp
{
    /**
     * @inheritDoc
     * @throws SetupException
     */
    public function setup(string $_ = ''): void
    {
        // Register this object into the Jaxon container.
        jaxon()->di()->set(AppInterface::class, fn() => $this);

        // Add the view renderer
        $this->addViewRenderer('codeigniter', '', fn() => new View());
        // Set the session manager
        $this->setSessionManager(fn() => new Session(Services::session(null, true)));
        // Set the logger
        $this->setLogger(Services::logger(true));

        // Load Jaxon config settings
        $aJaxonConfig = config(\Config\Jaxon::class);
        $aLibOptions = $aJaxonConfig->lib ?? [];
        $aAppOptions = $aJaxonConfig->app ?? [];

        // Jaxon library default settings
        $bExport = $bMinify = !CI_DEBUG;
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
    public function httpResponse(string $sCode = '200'): mixed
    {
        // Create and return a CodeIgniter HTTP response
        return (new Response(config('App')))
            ->setStatusCode(intval($sCode))
            ->setContentType($this->getContentType(), $this->getCharacterEncoding())
            ->setBody($this->ajaxResponse()->getOutput());
    }
}
