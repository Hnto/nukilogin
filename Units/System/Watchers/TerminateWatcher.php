<?php

namespace Units\System\Watchers;

use Nuki\Skeletons\Actors\Watcher;
use Nuki\Skeletons\Processes\Event;

class TerminateWatcher extends Watcher
{

    public function update(Event $event)
    {
        //Is not possible because the event is framework event type
        $event->stopNotifying();

        //do own logic
        //echo 'text before termination'
    }
}
