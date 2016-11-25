<?php namespace Softpampa\MoipLaravel\Controllers;

use Lang;
use Input;
use Event;
use Response;

class WebHookController extends \BaseController {

    public function handle() {
        $eventName = 'MOIP.SUBSCRIPTIONS.' . Input::get('event');

        // Fire event
        Event::fire(strtoupper($eventName), [Input::all()]);

        return Response::make(trans('moip-laravel::moip.response', ['event' => $eventName]), 200);
    }

}