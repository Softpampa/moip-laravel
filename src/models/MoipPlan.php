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
        if (isset($data['trial'])) {
            $trial = $data['trial'];

            $data['trial_enable'] = $trial['enabled'];
            $data['trial_days'] = $trial['days'];
            $data['trial_hold_setup_fee'] = $trial['hold_setup_fee'];
        }

        if (isset($data['interval'])) {
            $interval = $data['interval'];

            $data['interval_length'] = $interval['length'];
            $data['interval_unit'] = $interval['unit'];
        }


        return $data;
    }

    /**
     * Inactivate a plan
     * 
     * @return void
     */
    public function inactivate()
    {
        $this->status = 'INACTIVE';
        $this->save();
    }

    /**
     * Activate a plan
     * 
     * @return void
     */
    public function activate()
    {
        $this->status = 'ACTIVE';
        $this->save();
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
