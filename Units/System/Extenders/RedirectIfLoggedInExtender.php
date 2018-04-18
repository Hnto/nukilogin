<?php
namespace Units\System\Extenders;

use Nuki\Application\Application;
use Nuki\Handlers\Http\Input\Request;
use Nuki\Handlers\Http\Output\Response;
use Nuki\Handlers\Http\Session;
use \Nuki\Skeletons\{
    Providers\Extender
};

class RedirectIfLoggedInExtender extends Extender {

    /**
     * Execute method called by the framework
     */
    public function execute(Application $app, Request $requestHandler)
    {
        /** @var Response $responseHandler */
        $responseHandler = $app->getService('response-handler');

        /** @var Session $sessionHandler */
        $sessionHandler = $app->getService('session-handler');

        //If user is requesting a protected location
        if (strpos($requestHandler->queryPath(), '/account') !== false) {
            //If not logged in go to login page
            if (empty($sessionHandler->get('userSession')) || null === $sessionHandler->getSessionId()) {
                $responseHandler->redirect('login');
            }

            return;
        }

        //If user if empty or session id is null
        if (empty($sessionHandler->get('userSession')) ||
            null === $sessionHandler->getSessionId()
        ) {
            return;
        }

        $responseHandler->redirect('account/home');
    }
}
