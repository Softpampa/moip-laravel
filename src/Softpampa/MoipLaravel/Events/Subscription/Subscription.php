<?php namespace Softpampa\MoipLaravel\Events\Subscription;

use Softpampa\MoipLaravel\Models\MoipSubscription;

class Subscription {

    /**
     * When plan was created.
     * 
     * @param  array  $data
     * @return void
     */
    public function onCreated($data)
    {
        $data = $data['resource'];
        $code = $data['code'];

        if (MoipSubscription::byCode($code)->count() == 0) {
            MoipSubscription::create($data);            
        }

    }
}