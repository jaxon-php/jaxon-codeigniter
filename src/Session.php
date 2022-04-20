<?php

namespace Jaxon\CodeIgniter;

use CodeIgniter\Session\SessionInterface as CodeIgniterSession;
use Jaxon\App\Session\SessionInterface;

use function array_keys;
use function session_id;

class Session implements SessionInterface
{
    /**
     * @var CodeIgniterSession
     */
    protected $xSession;

    /**
     * @param CodeIgniterSession $xSession
     */
    public function __construct(CodeIgniterSession $xSession)
    {
        $this->xSession = $xSession;
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return session_id();
    }

    /**
     * @inheritDoc
     */
    public function newId(bool $bDeleteData = false)
    {
        $this->xSession->regenerate($bDeleteData);
    }

    /**
     * @inheritDoc
     */
    public function set(string $sKey, $xValue)
    {
        $this->xSession->set($sKey, $xValue);
    }

    /**
     * @inheritDoc
     */
    public function has(string $sKey): bool
    {
        return $this->xSession->has($sKey);
    }

    /**
     * @inheritDoc
     */
    public function get(string $sKey, $xDefault = null)
    {
        return $this->has($sKey) ? $this->xSession->get($sKey) : $xDefault;
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->xSession->get();
    }

    /**
     * @inheritDoc
     */
    public function delete(string $sKey)
    {
        $this->xSession->remove($sKey);
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        $this->xSession->remove(array_keys($this->xSession->get()));
    }
}
