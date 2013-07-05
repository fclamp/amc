<?php

/**
 * Search controller.
 *
 * @author BMCD AP
 * @version 0.1
 */
class SearchController extends BaseController
{
	/**
	 * @var string $layout
	 */
	public $layout = 'layouts.master';

	/**
	 * Render the Search Results.
	 *
	 * @param string $id
	 * @return \Response
	 * @access public
	 */
	public function results($query = null)
	{
		$search = new Search();

		// Get the search data.
		$searchData = array(
						'keyWords'      => Input::get('KeyWords'),
						'date'          => Input::get('Date'),
						'location'      => Input::get('Location'),
						'registration'  => Input::get('Registration'),
						'collection'    => Input::get('Collection'),
						'imagesOnly'    => Input::get('ImagesOnly')
		);
		
		//clean xss
		clean_xss($searchData);
		
		// go fising
		$result = $search->lookup($searchData);

		$this->layout->title = 'Australian Museum Collections : Search Results';
		//show form
		$this->layout->dealForm = Input::get('dealForm')=='search' ? Input::get('dealForm') : NULL;
		
		#$this->layout->results = $result;
		$term = implode(',',$searchData);
		
		$searchData['dealForm'] = 'search';
		$RefineSearch = sprintf('%s?%s',URL::to('/'),http_build_query($searchData));
		$NewSearch = sprintf('%s?%s',URL::to('/'),'dealForm=search');
		
		$data = array('term'=>$term,
			'results'=>$result,
			'NewSearch'=>$NewSearch,
			'RefineSearch'=>$RefineSearch
		);

		Session::put('search_offset', 30);

		$this->layout->content = View::make('pages.results',$data);
	}

	/**
	 * Continuous scroll search.
	 *
	 * @param string
	 * @return array
	 */
	public function ajaxsearch()
	{
		
		$parsed = array();
		$queryString = preg_replace('/^\?/', '', Input::get('qs'));
		$queryString = explode('&', $queryString);
		foreach ($queryString as $item)
		{
			$tempItem = explode('=', $item);
			$parsed[$tempItem[0]] = $tempItem[1];
		}

		$search = new Search();

		// Get the search data.
		$searchData = array(
			'keyWords'      => $parsed['KeyWords'],
			'date'          => $parsed['Date'],
			'location'      => $parsed['Location'],
			'registration'  => $parsed['Registration'],
			'collection'    => $parsed['Collection'],
			//'imagesOnly'	=> $parsed['ImagesOnly'],
		);

		//clean xss
		clean_xss($searchData);

		// go fising
		//$result = $search->lookup($searchData, 30, Session::get('search_offset') + 30);
		$result = $search->getNarratives($searchData,30,Session::get('search_offset') + 30);

		// update session count
		Session::put('search_offset', Session::get('search_offset') + 30);

		return Response::json($result);
	}
}