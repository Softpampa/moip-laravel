<?php namespace Softpampa\MoipLaravel\Controllers;

use Input;
use Event;

class WebHookController extends \BaseController {

    public function handle() {
        // Fire event
        $eventName = 'MOIP.SUBSCRIPTIONS.' . Input::get('event');
        Event::fire(strtoupper($eventName), [Input::all()]);

        return strtoupper($eventName);
    }

}