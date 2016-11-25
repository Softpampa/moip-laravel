<?php namespace Softpampa\MoipLaravel\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class MoipPlan extends Eloquent {
	
    /**
     * Mass Assignment
     * 
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'amount',
        'max_qty',
        'billing_cycles',
        'setup_fee',
        'status',
        'trial_days',
        'trial_enable',
        'trial_hold_setup_fee',
        'interval_length',
        'interval_unit',
    ];

    /**
     * Create a new plan
     * 
     * @param  array  $data
     * @return void
     */
    public static function create(array $data)
    {
        parent::create(self::prepareData($data));
    }

    /**
     * Update a plan
     * 
     * @param  array  $data
     * @return void
     */
    public function update(array $data = [])
    {
        parent::update(self::prepareData($data));
    }

    /**
     * Prepare data from Moip POST to database table
     * 
     * @param  array  $data
     * @return array
     */
    protected static function prepareData($data)
    {
        $data['trial_enable'] = $data['trial']['enabled'];
        $data['trial_days'] = $data['trial']['days'];
        $data['trial_hold_setup_fee'] = $data['trial']['hold_setup_fee'];
        $data['interval_length'] = $data['interval']['length'];
        $data['interval_unit'] = $data['interval']['unit'];

        return $data;
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
