<?php namespace Softpampa\MoipLaravel\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class MoipInvoice extends Eloquent {
    
    /**
     * Mass Assignment
     * 
     * @var array
     */
    protected $fillable = [
        'amount',
        'subscription_code',
        'status'
    ];

    /**
     * Invoices related to the subscription
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(MoipPayment::class, 'code', 'subscription_code');
    }
}
