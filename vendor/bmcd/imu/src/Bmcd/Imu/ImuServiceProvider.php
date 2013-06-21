<?php

/**
 * IMU service provider.
 *
 * @author BMCD AP
 * @version 0.1
 */
namespace Bmcd\Imu;

use Illuminate\Support\ServiceProvider;

class ImuServiceProvider extends ServiceProvider
{
	/**
	 * @var bool $defer
	 */
	protected $defer = false;
	
	/**
	 * Bootstrap the application events.
	 *
	 * @param void
	 * @return void
	 * @access public
	 */
	public function boot()
	{
		$this->package ('bmcd/imu');
	}
	
	/**
	 * Register the service provider.
	 *
	 * @param void
	 * @return void
	 * @access public
	 */
	public function register()
	{
		$this->app ['Imu'] = $this->app->share (function($app)
		{
			return new Imu();
		} );
		
		$this->app ['ImuSession'] = $this->app->share (function($app)
		{
			return new ImuSession();
		});
		
		
		$this->app->bind('ImuModule',function($app){
			
			$config = $app['config']['imu'];
			$module = new ImuModule($config['module_table'],$app['ImuSession']);
			return $module;		
			
		});
		
	}
	
	/**
	 * Get the services provided by the provider.
	 *
	 * @param void
	 * @return array
	 * @access public
	 */
	public function provides()
	{
		return array ('imu');
	}
}
