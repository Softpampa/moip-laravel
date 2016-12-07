<?php namespace Softpampa\MoipLaravel\Commands;

use Illuminate\Console\Command;

class MoipSetupCommand extends Command {

	/**
	 * Command name
	 * 
	 * @var string
	 */
	protected $name = 'moip:setup';

	/**
	 * Command description
	 * 
	 * @var string
	 */
	protected $description = 'Setup Moip SDK';

	/**
	 * Fire command
	 * 
	 * @var void
	 */
	public function fire()
	{
		$this->info('Setting up Moip Subscription Webook');

		$custom = $this->ask('URL:');
		$this->setUserPreferences($custom);
	}

	/**
	 * Set user preferences
	 * 
	 * @var void
	 */
	protected function setUserPreferences($custom)
	{
		$preferences = app('moip-subscriptions')->preferences();
		$preferences->setWebHook(! empty($custom) ? $custom : route('webhook.moip.subscriptions'));
		$preferences->save();

		$this->info('Done!');
	}

}