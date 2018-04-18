<?php
namespace Units\System\Extenders;

use Nuki\Application\Application;
use Nuki\Handlers\Events\TerminateApplication;
use \Nuki\Skeletons\{
    Providers\Extender
};
use Units\System\Watchers\TerminateWatcher;

class RegisterTerminateWatchers extends Extender {

    /**
     * Execute method called by the framework
     */
    public function execute(Application $application)
    {
        $application->getService('event-handler')
            ->getEvent(TerminateApplication::class)
            ->attach(new TerminateWatcher());
    }
}
