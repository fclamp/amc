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
		$this->app ['IMu'] = $this->app->share ( function ($app)
		{
			return new Imu ();
		} );
		
		$this->app ['IMuSession'] = $this->app->share ( function ($app)
		{
			return new IMuSession ();
		} );
		
		$this->app ['IMuModule'] = $this->app->share ( function ($app)
		{
			$config = $app['config']['imu'];
			$module = new IMuModule($config['module_table'],$app['IMuSession']);
			return $module;
		} );
	
	}
	
	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array ('imu' );
	}

}