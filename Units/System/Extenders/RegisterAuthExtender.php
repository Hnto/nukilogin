<?php
namespace Units\System\Extenders;

use Nuki\Application\Application;
use Nuki\Handlers\Core\Assist;
use Nuki\Handlers\Http\Session;
use Nuki\Handlers\Process\Authentication;
use \Nuki\Skeletons\{
    Providers\Extender
};
use Units\System\Repositories\UserRepository;

class RegisterAuthExtender extends Extender {

    /**
     * Execute method called by the framework
     */
    public function execute(Application $app, UserRepository $userRepository)
    {
        //If user logged in, create user service
        /** @var Session $sessionHandler */
        $sessionHandler = $app->getService('session-handler');
        if (!empty($sessionHandler->get('userSession'))) {
            /** @var Authentication $authentication */
            $authentication = $app->getService('authentication');

            $userInfoSession = \Units\System\Helpers\Assist::retrieveUserSessionInfo();
            $user = $userRepository->find($userInfoSession->getUserId());

            $authentication->setInput([
                'user' => $user->getUsername(),
                'password' => $user->getPassword()
            ]);

            $user->setPropValue('session', $userInfoSession->getRaw());

            $app->registerService($authentication, 'authentication');
            $app->registerService($user, 'user');

            //Set base params
            $app->getService('response-handler')->renderer()
                ->addParams([
                    'user' => $user,
                ]);
        }
    }
}
