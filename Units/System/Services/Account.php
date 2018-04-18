<?php
namespace Units\System\Services;

use Nuki\{
    Handlers\Core\Assist, Handlers\Http\Input\Request, Handlers\Http\Output\Response, Handlers\Http\Session, Skeletons\Services\Service, Application\Application
};
use Units\System\Models\User;
use Units\System\Repositories\UserRepository;

class Account extends Service {

    /**
     * @var Response
     */
    private $responseHandler;

    /**
     * @var User
     */
    private $user;

    public function __construct(Application $app)
    {
        parent::__construct($app);

        //Assign required services
        $this->responseHandler = $app->getService('response-handler');
        $this->user = $app->getService('user');
    }

    public function home(Application $app)
    {

        $this->responseHandler->send('account_home');
    }

    public function settings(Application $app)
    {
        $this->responseHandler->send('account_settings');
    }

    public function save(Request $request, UserRepository $userRepository)
    {
        $change = false;

        $oldPassword = $request->post()->get('oldPassword');
        if (!empty($oldPassword)) {
            if (!Assist::hashVerify(Assist::hash($oldPassword), $this->user->getPassword())) {
                $this->responseHandler->renderer()->addParams(['error' => 'Old password is incorrect']);
                $this->responseHandler->send('account_settings');
                return;
            }

            $newPassword = $request->post()->get('newPassword');
            $newPasswordVerify = $request->post()->get('newPasswordVerify');
            if ($newPassword !== $newPasswordVerify) {
                $this->responseHandler->renderer()->addParams(['error' => 'New password fields do not match']);
                $this->responseHandler->send('account_settings');
                return;
            }

            $newPassword = Assist::hash($newPassword);
            if (Assist::hashVerify($newPassword, $this->user->getPassword())) {
                $this->responseHandler->renderer()->addParams(['error' => 'New password is the same as the old password']);
                $this->responseHandler->send('account_settings');
                return;
            }

            $this->user->setPropValue('password', $newPassword);
            $change = true;
        }

        $emailInput = $request->post()->get('email', FILTER_VALIDATE_EMAIL);
        if ($emailInput !== $this->user->getEmail() && !empty($emailInput)) {
            $this->user->setPropValue('email', $emailInput);
            $change = true;
        }

        if ($change === true) {
            if ($userRepository->save($this->user)) {
                $this->responseHandler->renderer()->addParams(['success' => 'Settings successfully saved!']);
            } else {
                $this->responseHandler->renderer()->addParams(['error' => 'Something went wrong saving your settings']);
            }
        }

        $this->responseHandler->send('account_settings');
    }
}
