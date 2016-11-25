<?php namespace Softpampa\MoipLaravel\Events\Subscription;

use Softpampa\MoipLaravel\Models\MoipPayment;

class Payment {

    public function onCreated($data)
    {
        $data = $data['resource'];
        $id = $data['id'];

        if (MoipPayment::byMoipId($id)->count() == 0) {
            MoipPayment::create($data);            
        }
    }

    public function onStatusUpdated($data)
    {
        $id = $data['resource']['id'];
        $status = $data['resource']['status'];

        MoipPayment::byMoipId($id)->update([
            'status' => $status['description']
        ]);
    }

}