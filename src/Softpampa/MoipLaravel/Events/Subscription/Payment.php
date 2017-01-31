<?php namespace Softpampa\MoipLaravel\Events\Subscription;

use Softpampa\MoipLaravel\Models\MoipPayment;

class Payment
{
    /**
     * When a payment was created
     *
     * @param  array  $data
     * @return void
     */
    public function onCreated($data)
    {
        $data = $data['resource'];
        $id = $data['id'];

        MoipPayment::firstOrCreate($data);
    }

    /**
     * When a payment status was update
     *
     * @param  array  $data
     * @return void
     */
    public function onStatusUpdated($data)
    {
        $id = $data['resource']['id'];
        $status = $data['resource']['status'];

        MoipPayment::byMoipId($id)->update([
            'status' => $status['description']
        ]);
    }
}
