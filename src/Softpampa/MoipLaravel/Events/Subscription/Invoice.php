<?php namespace Softpampa\MoipLaravel\Events\Subscription;

use Softpampa\MoipLaravel\Models\MoipInvoice;

class Invoice {

    public function onCreated($data)
    {
        $data = $data['resource'];
        $id = $data['id'];

        if (MoipInvoice::byMoipId($id)->count() == 0) {
            MoipInvoice::create($data);            
        }
    }

    public function onStatusUpdated($data)
    {
        $status = $data['resource']['status'];

        MoipInvoice::byMoipId($id)->update([
            'status' => $status
        ]);
    }

}