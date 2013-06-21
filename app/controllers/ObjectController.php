<?php

/**
 * Information controller.
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
	public function index($id = null)
	{
		$this->layout->title = 'Australian Museum Collections : Object';
		$this->layout->content = View::make('pages.object');
	}
}