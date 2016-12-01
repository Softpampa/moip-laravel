<?php namespace Softpampa\MoipLaravel\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class MoipCustomer extends Eloquent {

	/**
	 * Mass Assignment
	 *
	 * @var array
	 */
	protected $fillable = [
		'code'
	];

	/**
	 * Related subscriptions
	 *
	 * @return void
	 */
	public function subscriptions()
	{
		return $this->hasMany(MoipSubscription::class, 'customer_code', 'code');
	}
}
