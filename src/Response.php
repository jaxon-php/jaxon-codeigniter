<?php

namespace Jaxon\CI;

class Response extends \Jaxon\Response\Response
{
    /**
     * Create a new Response instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Wrap the Jaxon response in a CodeIgniter HTTP response.
     *
     * @param  string  $code
     *
     * @return string  the HTTP response
     */
    public function http($code = '200')
    {
        // Create and return a CodeIgniter HTTP response
        get_instance()->output
            ->set_status_header($code)
            ->set_content_type($this->getContentType(), $this->getCharacterEncoding())
            ->set_output($this->getOutput())
            ->_display();
    }
}
