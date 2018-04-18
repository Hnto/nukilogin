<?php
namespace Units\System\Extenders;

use Nuki\Application\Application;
use Nuki\Handlers\Core\Assist;
use \Nuki\Skeletons\{
    Providers\Extender
};

class SetCsrfTokens extends Extender {

    /**
     * Execute method called by the framework
     */
    public function execute(Application $app)
    {
        $token = Assist::randomString(24);
        $userToken = Assist::hash($token);
        $serverToken = Assist::hash($token);

        $app->getService('request-handler')->cookie()->add('serverToken', $serverToken);
        $app->getService('response-handler')
            ->renderer()
            ->addParams([
                'userToken' => $userToken,
            ]);
    }
}
