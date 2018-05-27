<?php
namespace Dialect\Internetx;

use Illuminate\Support\ServiceProvider;

class InternetxServiceProvider extends ServiceProvider
{
	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
			__DIR__.'/../config/internetx.php' => config_path('internetx.php'),
		], 'config');

	}

	/**
	 * Register any package services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('internetx', Internetx::class);
	}
}
