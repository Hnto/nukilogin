<?php
namespace Units\System\Services;

use Nuki\{
    Handlers\Core\Assist, Handlers\Http\Cookie, Handlers\Http\Input\Request, Handlers\Http\Output\Response, Skeletons\Services\Service, Application\Application
};
use Units\System\Repositories\UserRepository;

class Registration extends Service {

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var Response
     */
    private $responseHandler;

    /**
     * Registration constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->userRepository = $app->getService('repository-handler')->buildRepository('UserRepository');
        $this->responseHandler = $app->getService('response-handler');
    }

    public function form(Application $app) {
        $this->responseHandler->send('registration_form');
    }

    public function process(Application $app, Request $requestHandler)
    {
        $username = $requestHandler->post()->get('username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = $requestHandler->post()->get('password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = $requestHandler->post()->get('email', FILTER_SANITIZE_EMAIL);

        $success = '';
        $error = '';

        if (empty($username) || empty($password) || empty($email)) {
            $error = 'Your username, email and password must be filled';
        }

        if ($error === '') {
            if (!empty($this->userRepository->registerUser($username, $password, $email))) {
                $success = 'You have successfully created a new account';
            } else {
                $error = 'Registration failed! Possibly due to an existing username or email. Please try again';
            }
        }

        $this->responseHandler->renderer()->addParams([
            'success' => $success, 'error' => $error,
        ]);
        $this->responseHandler->send('registration_form');
    }
}
