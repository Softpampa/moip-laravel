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

	/**
	 * Filter credit card by valut
	 * 
	 * @param  \Illuminate\Database\Query\Builder  $query
	 * @param  string  $valut
	 * @return \Illuminate\Database\Query\Builder
	 */
	public function scopeByVault($query, $valut)
	{
		return $query->whereValut($valut);
	}
}
