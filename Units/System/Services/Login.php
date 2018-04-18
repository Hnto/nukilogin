<?php
namespace Units\System\Services;

use Nuki\{
    Handlers\Http\Input\Request,
    Handlers\Http\Output\Response,
    Handlers\Http\Session,
    Handlers\Process\Authentication,
    Skeletons\Services\Service,
    Application\Application
};
use Units\System\Helpers\Assist;
use Units\System\Repositories\UserRepository;

class Login extends Service {

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var Response
     */
    private $responseHandler;

    /**
     * @var Session
     */
    private $sessionHandler;

    /**
     * @var Authentication
     */
    private $authentication;

    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->userRepository = $app->getService('repository-handler')->buildRepository('UserRepository');
        $this->responseHandler = $app->getService('response-handler');
        $this->sessionHandler = $app->getService('session-handler');
        $this->authentication = $app->getService('authentication');
    }

    public function form(Application $app)
    {
        $errorMessage = $this->sessionHandler->get('user_login_error_message');
        $this->sessionHandler->remove('user_login_error_message');

        $this->responseHandler->renderer()->addParams([
            'error' => $errorMessage,
        ]);
        $this->responseHandler->send('login_form');
    }

    public function process(Request $requestHandler)
    {
        $user = $this->userRepository->findByUsername(
            $requestHandler->post()->get('username')
        );

        $this->authentication->setInput([
            'username' => $user->getUsername(),
            'password' => $user->getPassword()
        ]);

        if (!$this->authentication->isSuccess()) {
            $this->sessionHandler->add('user_login_error_message', 'Your credentials are invalid, please try again!');
            $this->responseHandler->redirect('login');
        }

        Assist::setUserSession(
            $this->sessionHandler->getSessionId(),
            $user->getId()
        );

        $this->responseHandler->redirect('account/home');
    }
}
