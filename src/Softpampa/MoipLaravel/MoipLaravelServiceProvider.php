<?php namespace Softpampa\MoipLaravel;

use Softpampa\Moip\Moip;
use Softpampa\Moip\MoipBasicAuth;
use Softpampa\MoipLaravel\Events\SubscriptionsListener;
use Illuminate\Support\ServiceProvider;

class MoipLaravelServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('softpampa/moip-laravel');
		$this->commands('\Softpampa\MoipLaravel\Commands\MoipSetupCommand');
		$this->commands('\Softpampa\MoipLaravel\Commands\MoipImportCommand');
		$this->commands('\Softpampa\MoipLaravel\Commands\MoipImportSubscriptionCommand');

		// Include package routes
		include __DIR__.'/../../routes.php';

		$this->app['events']->subscribe(new SubscriptionsListener);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('moip-sdk', function($app) {

			$key = $this->getConfig('config.key');
			$token = $this->getConfig('config.token');
			$env = $this->getConfig('config.env');

			return new Moip(new MoipBasicAuth($key, $token), $env);
		});

		$this->app->singleton('moip-subscriptions', function($app) {
			return $app['moip-sdk']->subscriptions();
		});

		$this->app->singleton('moip-payments', function($app) {
			return $app['moip-sdk']->payments();
		});		
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

	/**
	 * Get package config
	 * 
	 * @param  string  $key
	 * @return mixed
	 */
	public function getConfig($key)
	{
		return $this->app['config']["moip-laravel::{$key}"];
	}
}
