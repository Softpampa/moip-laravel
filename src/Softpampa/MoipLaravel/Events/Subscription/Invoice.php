<?php namespace Softpampa\MoipLaravel\Events\Subscription;

use Softpampa\MoipLaravel\Models\MoipInvoice;

class Invoice
{

    /**
     * When invoice was created
     *
     * @param  array  $data
     * @return void
     */
    public function onCreated($data)
    {
        $data = $data['resource'];

        MoipInvoice::firstOrCreate($data);
    }

    /**
     * When invoices status was update
     *
     * @param  array  $data
     * @return void
     */
    public function onStatusUpdated($data)
    {
        $id = $data['resource']['id'];
        $status = $data['resource']['status'];

        MoipInvoice::byMoipId($id)->update([
            'status' => $status['description']
        ]);
    }
}
