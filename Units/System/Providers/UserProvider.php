<?php
namespace Units\System\Providers;

use Nuki\Handlers\Database\PDO;
use Nuki\Skeletons\{
    Handlers\StorageHandler,
    Providers\Storage
};

class UserProvider implements Storage {    
    /**
     * Contains the storage handler
     * 
     * @var PDO $storageHandler
     */
    private $storageHandler;

    public function __construct(StorageHandler $storageHandler) {
        $this->storageHandler = $storageHandler;
    }

    public function insert(array $data)
    {
        return $this->storageHandler
            ->insert(
                'insert into users (`username`, `password`, `email`) values (:username, :password, :email)',
                [
                    ':username' => $data['username'],
                    ':password' => $data['password'],
                    ':email' => $data['email']
                ]
            );
    }

    public function findBy($key, $value)
    {
        $sql = vsprintf('select * from users where %1$s = :value', [$key]);

        return ($this->storageHandler
            ->findOne(
                $sql,
                [
                    ':value' => $value
                ]
            ));
    }

    /**
     * @param $password
     * @param $email
     * @param $id
     * @return int
     */
    public function saveInfo($password, $email, $id)
    {
        return $this->storageHandler
            ->update(
                'update users set email = :email, password = :password where id = :id ',
                [
                    ':email' => $email,
                    ':password' => $password,
                    ':id' => $id
                ]
            );
    }
}