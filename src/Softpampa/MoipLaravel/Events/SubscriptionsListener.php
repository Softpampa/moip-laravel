<?php namespace Softpampa\MoipLaravel\Events;

class SubscriptionsListener
{

    /**
     * Event listener list
     *
     * @var array
     */
    protected $listeners = [
        'CUSTOMER.CREATED',
        'CUSTOMER.UPDATED',
        'PLAN.CREATED',
        'PLAN.UPDATED',
        'PLAN.ACTIVATED',
        'PLAN.INACTIVATED',
        'SUBSCRIPTION.CREATED',
        'SUBSCRIPTION.UPDATED',
        'SUBSCRIPTION.SUSPENDED',
        'SUBSCRIPTION.ACTIVATED',
        'SUBSCRIPTION.CANCELED',
        'INVOICE.CREATED',
        'INVOICE.STATUS_UPDATED',
        'PAYMENT.CREATED',
        'PAYMENT.STATUS_UPDATED',
    ];

    /**
     * Subscribe events
     *
     * @param  Object  $events
     * @return void
     */
    public function subscribe($events)
    {
        foreach ($this->listeners as $listen) {
            $eventName = explode('.', $listen);
            $class = ucfirst(strtolower($eventName[0]));
            $method = ucfirst(strtolower($eventName[1]));

            if (strpos($method, '_')) {
                $tmp = explode('_', $method);
                $method = $tmp[0] . ucfirst($tmp[1]);
            }

            $eventName = 'MOIP.SUBSCRIPTIONS.' . $listen;
            $handler = "\Softpampa\MoipLaravel\Events\Subscription\\{$class}@on{$method}";
            
            // Add event listener
            $events->listen($eventName, $handler);
        }
    }
}
