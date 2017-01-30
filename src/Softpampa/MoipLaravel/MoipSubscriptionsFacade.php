<?php

namespace Softpampa\MoipLaravel;

use Illuminate\Support\Facades\Facade;

class MoipSubscriptionsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'moip-subscriptions';
    }
}
