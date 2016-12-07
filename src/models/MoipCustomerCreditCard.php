<?php namespace Softpampa\MoipLaravel\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class MoipCustomerCreditCard extends Eloquent {

    /**
     * Mass Assignment
     *
     * @var array
     */
    protected $fillable = [
        'customer_code',
        'holder_name',
        'first_six_digits',
        'last_four_digits',
        'brand',
        'vault',
    ];

    public function scopeByVault($query, $code)
    {
        return $query->whereValut($code);
    }
}
