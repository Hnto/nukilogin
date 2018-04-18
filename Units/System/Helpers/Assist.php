<?php

namespace Units\System\Helpers;

class Assist extends \Nuki\Handlers\Core\Assist
{

    /**
     * Retrieve user session info
     *
     * @return \Units\System\Models\UserSessionInfo
     */
    public static function retrieveUserSessionInfo() : \Units\System\Models\UserSessionInfo
    {
        $container = \Nuki\Application\Application::getContainer();

        $userSession = $container->offsetGet('session-handler')->get('userSession');
        $userInfo = explode('.', Assist::decrypt($userSession));

        $userData = [];
        if (isset($userInfo[0]) && isset($userInfo[1])) {
            $userData = [
                'raw' => $userSession,
                'userId' => $userInfo[1],
                'sessionId' => $userInfo[0]
            ];
        }

        return new \Units\System\Models\UserSessionInfo($userData);
    }

    /**
     * Set the user session
     * in the session by
     * sessionId and userId
     *
     * @param string $sessionId
     * @param int $userId
     */
    public static function setUserSession(string $sessionId, int $userId)
    {
        $userSession = Assist::encrypt($sessionId . '.' . $userId);
        $container = \Nuki\Application\Application::getContainer();

        $container->offsetGet('session-handler')->set('userSession', $userSession->get());
    }
}
