<?php namespace Softpampa\MoipLaravel\Events\Subscription;

use Softpampa\MoipLaravel\Models\MoipSubscription;

class Subscription
{

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

        MoipSubscription::firstOrCreate($data);
    }

    /**
     * When subscription was update.
     *
     * @param  array  $data
     * @return void
     */
    public function onUpdated($data)
    {
        $code = $data['resource']['code'];

        MoipSubscription::byCode($code)->update($data['resource']);
    }

    /**
     * When plan was inactivated.
     *
     * @param  array  $data
     * @return void
     */
    public function onActivated($data)
    {
        $code = $data['resource']['code'];

        MoipSubscription::byCode($code)->active();
    }

    /**
     * When plan was inactivated.
     *
     * @param  array  $data
     * @return void
     */
    public function onSuspended($data)
    {
        $code = $data['resource']['code'];

        MoipSubscription::byCode($code)->suspend();
    }

    /**
     * When plan was inactivated.
     *
     * @param  array  $data
     * @return void
     */
    public function onCanceled($data)
    {
        $code = $data['resource']['code'];
        $subscription = MoipSubscription::byCode($code)->cancel();
    }
}
