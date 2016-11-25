<?php namespace Softpampa\MoipLaravel\Events\Subscription;

use Softpampa\MoipLaravel\Models\MoipPlan;

class Plan {

    /**
     * When plan was created.
     * 
     * @param  array  $data
     * @return void
     */
    public function onCreated($data)
    {
        MoipPlan::create($data['resource']);
    }

    /**
     * When plan was update.
     * 
     * @param  array  $data
     * @return void
     */
    public function onUpdate($data)
    {
        $code = $data['resource']['code'];

        MoipPlan::byCode($code)->update($data['resource']);
    }

    /**
     * When plan was inactivated.
     * 
     * @param  array  $data
     * @return void
     */
    public function onInactivated($data)
    {
        $code = $data['resource']['code'];

        MoipPlan::byCode($code)->update([
            'status' => 'INACTIVE'
        ]);
    }

    /**
     * When plan was activated.
     * 
     * @param  array  $data
     * @return void
     */
    public function onActivated($data)
    {
        $code = $data['resource']['code'];
        
        MoipPlan::byCode($code)->update([
            'status' => 'ACTIVE'
        ]);
    }
}