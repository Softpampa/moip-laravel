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
	public static function firstOrCreate(array $data)
	{
		parent::firstOrCreate(self::prepareData($data));
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
		$prepared = [];

		if (isset($data['trial'])) {
			$trial = $data['trial'];

			$prepared['trial_enable'] = $trial['enabled'];
			$prepared['trial_days'] = $trial['days'];
			$prepared['trial_hold_setup_fee'] = $trial['hold_setup_fee'];
		}

		if (isset($data['interval'])) {
			$interval = $data['interval'];

			$prepared['interval_length'] = $interval['length'];
			$prepared['interval_unit'] = $interval['unit'];
		}

		$prepared['code'] = $data['code'];
		$prepared['name'] = $data['name'];
		$prepared['description'] = $data['description'];
		$prepared['amount'] = $data['amount'];
		$prepared['max_qty'] = $data['max_qty'];
		$prepared['billing_cycles'] = $data['billing_cycles'];
		$prepared['setup_fee'] = $data['setup_fee'];
		$prepared['status'] = $data['status'];

		return $prepared;
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
	 * @param  \Illuminate\Database\Query\Builder  $query
	 * @param  string  $code
	 * @return \Illuminate\Database\Query\Builder
	 */
	public function scopeByCode($query, $code)
	{
		return $query->whereCode($code)->first();
	}

}
