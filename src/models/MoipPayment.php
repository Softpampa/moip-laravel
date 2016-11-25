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
        'status',
        'moip_id',
        'invoice_id',
        'moip_trans_id',
    ];

    /**
     * Create a new payment
     * 
     * @param  array  $data
     * @return void
     */
    public static function create(array $data)
    {
        parent::create(self::prepareData($data));
    }

    /**
     * Prepare data from Moip POST to database table
     * 
     * @param  array  $data
     * @return array
     */
    protected static function prepareData($data)
    {
        $data['moip_id'] = $data['id'];
        $data['moip_trans_id'] = $data['moip_id'];
        $data['status'] = $data['status']['description'];

        return $data;
    }

    public function scopeByMoipId($query, $id)
    {
        return $query->whereMoipId($id)->first();
    }
}
