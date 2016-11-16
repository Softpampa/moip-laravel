<?php namespace Softpampa\MoipLaravel\Events;

use Softpampa\MoipLaravel\Models\MoipPlan;

class Subscriptions {

    protected $listeners = [
        'PLAN.CREATED' => 'onPlanCreated',
        'PLAN.UPDATED' => 'onPlanUpdate',
        'PLAN.ACTIVATED' => 'onPlanActivated',
        'PLAN.INACTIVATED' => 'onPlanInactivated',
        'SUBSCRIPTION.CREATED' => 'onSubscriptionCreated',
        'SUBSCRIPTION.UPDATED' => 'onSubscriptionCreated',
        'SUBSCRIPTION.SUSPENDED' => 'onSubscriptionSuspended',
        'SUBSCRIPTION.ACTIVATED' => 'onSubscriptionActivated',
        'SUBSCRIPTION.CANCELED' => 'onSubscriptionCanceled',
        'INVOICE.CREATED' => 'onSubscriptionCanceled',
        'INVOICE.STATUS_UPDATED' => 'onSubscriptionCanceled',
        'PAYMENT.CREATED' => 'onSubscriptionCanceled',
        'PAYMENT.STATUS_UPDATED' => 'onSubscriptionCanceled',
    ];

    public function onPlanCreated($data)
    {
        MoipPlan::create($data['resource']);
    }

    public function onPlanUpdate($data)
    {
        $code = $data['resource']['code'];

        MoipPlan::byCode($code)->update($data['resource']);
    }

    public function onPlanInactivated($data)
    {
        $code = $data['resource']['code'];

        MoipPlan::byCode($code)->update([
            'status' => 'INACTIVE'
        ]);
    }

    public function onPlanActivated($data)
    {
        $code = $data['resource']['code'];
        
        MoipPlan::byCode($code)->update([
            'status' => 'ACTIVE'
        ]);
    }


    public function subscribe($events)
    {
        foreach ($this->listeners as $listen => $method) {
            $eventName = 'MOIP.SUBSCRIPTIONS.' . $listen;
            $handler = '\Softpampa\MoipLaravel\Events\Subscriptions@' . $method;
            
            // Add event listener
            $events->listen($eventName, $handler);
        }
    }

}