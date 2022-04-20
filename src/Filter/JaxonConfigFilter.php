<?php

namespace Jaxon\CodeIgniter\Filter;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Jaxon\CodeIgniter\Jaxon;

class JaxonConfigFilter implements FilterInterface
{
    /**
     * @param RequestInterface $request
     * @param mixed $arguments
     *
     * @return void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        jaxon()->di()->set(AppInterface::class, function() {
            return new Jaxon();
        });

        // Load the config
        jaxon()->app()->setup('');
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param mixed $arguments
     *
     * @return void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {}
}
