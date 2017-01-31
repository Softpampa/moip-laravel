<?php namespace Softpampa\MoipLaravel\models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as Eloquent;

class MoipSubscription extends Eloquent
{
    /**
     * Mass Assignment
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'amount',
        'status',
        'plan_code',
        'customer_code',
        'expiration_date',
        'next_invoice_date',
    ];

    /**
     * Carbon dates
     *
     * @var array
     */
    protected $dates = [
        'next_invoice_date'
    ];

    /**
     * Subscription Customer
     * @return Softpampa\MoipLaravel\Models\MoipCustomer
     */
    public function customer()
    {
        return $this->belongsTo(MoipCustomer::class, 'customer_code', 'code');
    }

    /**
     * Create a new subscription if doesn't exists
     *
     * @param  array  $data
     * @return void
     */
    public static function firstOrCreate(array $data)
    {
        parent::firstOrCreate(self::prepareData($data));
    }

    /**
     * Update a subscription
     *
     * @param  array  $data
     * @return void
     */
    public function update(array $data = [])
    {
        parent::update(self::prepareData($data));
    }

    /**
     * Activate a subscription
     *
     * @return void
     */
    public function active()
    {
        $this->status = 'ACTIVE';
        $this->save();
    }

    /**
     * Suspend a subscription
     *
     * @return void
     */
    public function suspend()
    {
        $this->status = 'SUSPENDED';
        $this->save();
    }

    /**
     * Cancel a subscription
     *
     * @return void
     */
    public function cancel()
    {
        $this->status = 'CANCELED';
        $this->save();
    }

    /**
     * Plan related to the subscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(MoipPlan::class, 'plan_code', 'code');
    }

    /**
     * Invoices related to the subscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany(MoipInvoice::class, 'subscription_code', 'code');
    }

    /**
     * Filter subscription by code
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  int  $code
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeByCode($query, $code)
    {
        return $query->whereCode($code)->first();
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

        $prepared['plan_code'] = $data['plan']['code'];
        $prepared['customer_code'] = $data['customer']['code'];

        if (isset($data['next_invoice_date'])) {
            $prepared['next_invoice_date'] = self::convertMoipDate($data['next_invoice_date']);
        }

        if (isset($data['expiration_date'])) {
            $prepared['expiration_date'] = self::convertMoipDate($data['expiration_date']);
        }

        $prepared['code'] = $data['code'];
        $prepared['amount'] = $data['amount'];
        $prepared['status'] = $data['status'];

        return $prepared;
    }

    protected static function convertMoipDate($date)
    {
        $day = $date['day'];
        $month = $date['month'];
        $year = $date['year'];

        return Carbon::createFromDate($year, $month, $day);
    }
}
