<?php namespace Softpampa\MoipLaravel\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as Eloquent;

class MoipSubscription extends Eloquent {
    
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
     * Create a new subscription
     * 
     * @param  array  $data
     * @return void
     */
    public static function create(array $data)
    {
        parent::create(self::prepareData($data));
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
     * Prepare data from Moip POST to database table
     * 
     * @param  array  $data
     * @return array
     */
    protected static function prepareData($data)
    {
        $data['plan_code'] = $data['plan']['code'];
        $data['customer_code'] = $data['customer']['code'];
        $data['next_invoice_date'] = self::convertMoipDate($data['next_invoice_date']);

        if (isset($data['expiration_date'])) {
            $data['expiration_date'] = self::convertMoipDate($data['expiration_date']);
        }

        return $data;
    }

    protected static function convertMoipDate($date)
    {
        $day = $date['day'];
        $month = $date['month'];
        $year = $date['year'];

        return Carbon::createFromDate($year, $month, $day);
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
        return $this->hasMany(MoipInvoice::class, 'code', 'subscription_code');
    }

    /**
     * Filter plans by code
     * 
     * @param  [type] $query
     * @param  [type] $code
     * @return [type]
     */
    public function scopeByCode($query, $code)
    {
        return $query->whereCode($code)->first();
    }

}
