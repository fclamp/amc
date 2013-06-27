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
	    $search = new Search();

	    $this->layout->title = 'Australian Museum Collections : Home';

	    $searchData = array('keyWords' => '');

		clean_xss($searchData);

		$results = $search->getNarratives($searchData,8);

	    // print_r($results);

	    $data = array(
		                'results'       => $results,
	                    'KeyWords'      => Input::get('KeyWords'),
	                    'Date'          => Input::get('Date'),
	                    'Location'      => Input::get('Location'),
		                'Registration'  => Input::get('Registration'),
	                    'Collection'    => Input::get('Collection'),
	                    'ImagesOnly'    => Input::get('ImagesOnly'));

		//show form
		$this->layout->dealForm = Input::get('dealForm')=='search' ? Input::get('dealForm') : NULL;
		
	    $this->layout->content = View::make('pages.home', $data);
    }
}