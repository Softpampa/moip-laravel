<?php namespace Softpampa\MoipLaravel\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class MoipPayment extends Eloquent {
    
    /**
     * Mass Assignment
     * 
     * @var array
     */
    protected $fillable = [
        'amount',
        'invoice_id',
        'moip_id',
        'status'
    ];
}
