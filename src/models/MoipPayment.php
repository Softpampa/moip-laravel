<?php namespace Softpampa\MoipLaravel\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class MoipPayment extends Eloquent
{
    /**
     * Mass Assignment
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'status',
        'moip_id',
        'invoice_id',
        'moip_trans_id',
    ];

    /**
     * Create a new payment if doesn't exists
     *
     * @param  array  $data
     * @return void
     */
    public static function firstOrCreate(array $data)
    {
        parent::firstOrCreate(self::prepareData($data));
    }

    /**
     * Prepare data from Moip POST to database table
     *
     * @param  array  $data
     * @return array
     */
    protected static function prepareData($data)
    {
        $prepared = [];

        $prepared['moip_id'] = $data['id'];
        $prepared['status'] = $data['status']['description'];
        $prepared['amount'] = $data['amount'];
        $prepared['invoice_id'] = $data['invoice_id'];

        if ($data['payment_method']['code'] == 1) {
            // Cartão de crédito
            $prepared['moip_trans_id'] = $data['moip_id'];
        } else {
            // Boleto
        }

        return $prepared;
    }

    /**
     * Filter payment by Moip id
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  int  $id
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeByMoipId($query, $id)
    {
        return $query->whereMoipId($id)->first();
    }
}
