<?php

/**
 * Home controller.
 *
 * @author BMCD AP
 * @version 0.1
 */
use Illuminate\Support\Facades\Input;
class HomeController extends BaseController
{
	/**
	 * @var string $layout
	 */
	public $layout = 'layouts.master';

    /**
     * Render the homepage.
     *
     * @param void
     * @return \Response
     * @access public
     */
    public function index()
    {

    	
	    $this->layout->title = 'Australian Museum Collections : Home';
	    $searchData = array(
						'KeyWords'      => Input::get('keyWords'),
						'Date'          => Input::get('date'),
						'Location'      => Input::get('location'),
						'Registration'  => Input::get('registration'),
						'Collection'    => Input::get('collection'),
						'ImagesOnly'    => Input::get('imagesOnly'),
		);
		clean_xss($searchData);
		//show form
		$this->layout->dealForm = Input::get('dealForm')=='search' ? Input::get('dealForm') : NULL;
		
	    $this->layout->content = View::make('pages.home',$searchData);
    }
}