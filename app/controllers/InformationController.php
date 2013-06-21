<?php

/**
 * Information controller.
 *
 * @author BMCD AP
 * @version 0.1
 */
class InformationController extends BaseController
{
	/**
	 * @var string $layout
	 */
	public $layout = 'layouts.master';

	/**
	 * Index action.
	 *
	 * @param string $id
	 * @return \Response
	 * @access public
	 */
	public function index($id = null)
	{
		$id = abs(intval($id));
		
		$search = new Search();
		$result = $search->getNarrativeInfo($id);		
		
		$this->layout->dealForm = Input::get('dealForm')=='search' ? Input::get('dealForm') : NULL;
		
		$this->layout->title = 'Australian Museum Collections : Information';
		
		$data = array(
			'results'=>$result,
		);
		
		$this->layout->content = View::make('pages.information',$data);
	}
}