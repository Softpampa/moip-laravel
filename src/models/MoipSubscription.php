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
        'amount',
        'code',
        'customer_code',
        'expiration_date',
        'link',
        'next_invoice_date',
        'payment_method',
        'plan_code',
        'status',
        'email_sended',
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
     * @return Softpampa\MoipLaravel\models\MoipCustomer
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
        $subscription = parent::whereCode($data['code'])->first();
        if (isset($data['code']) and $subscription) {
            $subscription->update(self::prepareData($data));
        } else {
            $subscription = parent::firstOrCreate(self::prepareData($data));
        }

        return $subscription;
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

        if (isset($data['plan']) and isset($data['plan']['code'])) {
            $prepared['plan_code'] = $data['plan']['code'];
        }

        if (isset($data['customer']) and isset($data['customer']['code'])) {
            $prepared['customer_code'] = $data['customer']['code'];
        }

        if (isset($data['next_invoice_date'])) {
            if (is_array($data['next_invoice_date'])) {
                $prepared['next_invoice_date'] = self::convertMoipDate($data['next_invoice_date']);
            } else {
                $prepared['next_invoice_date'] = $data['next_invoice_date'];
            }
        }

        if (isset($data['expiration_date'])) {
            if (is_array($data['expiration_date'])) {
                $prepared['expiration_date'] = self::convertMoipDate($data['expiration_date']);
            } else {
                $prepared['expiration_date'] = $data['expiration_date'];
            }
        }

        $prepared['code'] = $data['code'];
        $prepared['amount'] = $data['amount'];
        $prepared['status'] = $data['status'];
        $prepared['payment_method'] = $data['payment_method'];

        if ($data['payment_method'] == 'BOLETO') {
            if (isset($data['_links'])) {
                $prepared['link'] = $data['_links']['boleto']['redirect_href'];
            } elseif (isset($data['link'])) {
                $prepared['link'] = $data['link'];
            }
        }

        return $prepared;
    }

    protected static function convertMoipDate($date)
    {
        $day = $date['day'];
        $month = $date['month'];
        $year = $date['year'];

        return Carbon::createFromDate($year, $month, $day)->format('Y-m-d');
    }
}
