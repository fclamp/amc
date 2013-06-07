<?php
namespace Fclamp\Imu;

use Illuminate\Support\ServiceProvider;

class ImuServiceProvider extends ServiceProvider
{
	
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
		$this->package ( 'fclamp/imu' );
	}
	
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app ['imu'] = $this->app->share ( function ($app)
		{
			return new Imu;
		} );
	}
	
	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		 return array('imu');
	}

}