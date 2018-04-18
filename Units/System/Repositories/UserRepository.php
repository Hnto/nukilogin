<?php
namespace Units\System\Repositories;

use Nuki\Handlers\Core\Assist;
use Nuki\Handlers\Process\Authentication;
use Nuki\Skeletons\Providers\Repository;
use Units\System\Models\User;
use Units\System\Providers\UserProvider;

class UserRepository extends Repository {

    /**
     * @var UserProvider
     */
    private $userProvider;

    public function __construct()
    {
        parent::__construct();

        $this->userProvider = $this->getProvider('user');
    }

    public function registerUser($username, $password, $email)
    {
        $user = $this->findByUsername($username);
        if (null !== $user->getId()) {
            return false;
        }

        $user = $this->findByEmail($email);
        if (null !== $user->getId()) {
            return false;
        }

        return $this->userProvider
            ->insert([
                'username' => $username,
                'password' => Assist::hash($password),
                'email' => $email
            ]);
    }

    /**
     * @param $email
     * @return User
     */
    public function findByEmail($email)
    {
        $userData = $this->userProvider
            ->findBy('email', $email);

        return new User((array)$userData);
    }

    /**
     * @param $username
     * @return User
     */
    public function findByUsername($username)
    {
        $userData = $this->userProvider
            ->findBy('username', $username);

        return new User((array)$userData);
    }

    public function find(int $id)
    {
        $userData = $this->userProvider
            ->findBy('id', $id);

        return new User((array)$userData);
    }

    public function save(User $user)
    {
        return $this->userProvider
            ->saveInfo(
                $user->getPassword(),
                $user->getEmail(),
                $user->getId()
            );
    }
}
