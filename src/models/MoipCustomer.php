<?php namespace Softpampa\MoipLaravel\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class MoipCustomer extends Eloquent
{

    /**
     * Mass Assignment
     *
     * @var array
     */
    protected $fillable = [
        'code'
    ];

    /**
     * Customer subscriptions
     *
     * @return void
     */
    public function subscriptions()
    {
        return $this->hasMany(MoipSubscription::class, 'customer_code', 'code');
    }

    /**
     * Customer credit cards
     *
     * @return void
     */
    public function creditCards()
    {
        return $this->hasMany(MoipCustomerCreditCard::class, 'customer_code', 'code');
    }
}
