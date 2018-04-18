<?php

namespace Units\System\Models;

use Units\System\Traits\DataPropExtender;
use Units\System\Traits\FillByConstructor;

class User
{

    use FillByConstructor;
    use DataPropExtender;

    protected $id;

    protected $username;

    protected $password;

    protected $email;

    protected $session;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }
}
