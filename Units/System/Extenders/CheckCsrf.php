<?php
namespace Units\System\Extenders;

use Nuki\Application\Application;
use Nuki\Handlers\Core\Assist;

use Nuki\Handlers\Http\{
    Input\Request,
    Output\Response
};
use \Nuki\Skeletons\{
    Providers\Extender
};

class CheckCsrf extends Extender {

    /**
     * Execute method called by the framework
     */
    public function execute(Application $app, Request $request)
    {
        if ($request->method() !== 'POST') {
            return;
        }

        $userToken = (string) $request->post()->get('userToken');
        $serverToken = (string) $request->cookie()->get('serverToken');

        /** @var Response $responseHandler */
        $responseHandler = $app->getService('response-handler');

        if (!Assist::hashVerify($userToken, $serverToken)) {
            $responseHandler->renderer()->addParams(['errors' => ['Could not validate form request, please try again!']]);
            $responseHandler->send('error');

            //Send a termination event
            $app->terminate();
        }
    }
}
