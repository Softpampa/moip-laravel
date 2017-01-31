<?php namespace Softpampa\MoipLaravel\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class MoipInvoice extends Eloquent
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
        'subscription_code',
    ];

    /**
     * Create a new invoice
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
        $prepared['subscription_code'] = $data['subscription_code'];

        return $prepared;
    }

    /**
     * Invoices related to the subscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(MoipPayment::class, 'invoice_id', 'moip_id');
    }

    /**
     * Filter invoice by Moip id
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
