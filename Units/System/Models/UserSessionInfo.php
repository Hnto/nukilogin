<?php

namespace Units\System\Models;

use Units\System\Traits\DataPropExtender;
use Units\System\Traits\FillByConstructor;

class UserSessionInfo
{

    use FillByConstructor;
    use DataPropExtender;

    /**
     * @var int
     */
    protected $userId;

    /**
     * @var string
     */
    protected $sessionId;

    /**
     * @var string
     */
    protected $raw;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    /**
     * @return string
     */
    public function getRaw() : string
    {
        return $this->raw;
    }
}
