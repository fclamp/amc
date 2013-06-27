<?php

/**
 * Object controller.
 *
 * @author BMCD AP
 * @version 0.1
 */
class ObjectController extends BaseController
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
	public function index($id = null,$imgId=null)
	{
		$id = abs(intval($id));
		$imgId = abs(intval($imgId));

		$search = new Search();
		$result = $search->getObjectInfo($id,$imgId);
		
		$this->layout->dealForm = Input::get('dealForm')=='search' ? Input::get('dealForm') : NULL;

		$this->layout->title = 'Australian Museum Collections : Object : ' . $id;

		$data = array(
			'results'=>$result,
		);

		$this->layout->content = View::make('pages.object', $data);
	}
}