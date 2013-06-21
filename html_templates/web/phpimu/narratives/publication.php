<?php
require_once(dirname(__FILE__) . "/common.php");
require_once("$WEB_ROOT/tables/narratives.php");
require_once("$WEB_ROOT/narratives/common.php");

class Publication
{
	public $title;

	public function
	Publication()
	{
	}

	public function
	canPublish($cart)
	{
		return false;
	}

	public function
	publish($index, $cart)
	{
		// place holder
	}

	protected $cart;
	protected $index;
	protected $items;

	protected function
	loadItem($narrative)
	{
		// place holder
	}

	protected function
	loadItems($index, $cart)
	{
		$this->index = $index;
		$this->cart = $cart;
		$this->items = array();
		$narratives = new NarrativeItems;
		$narratives->fetchList($cart->irns);
		for ($i = 0; $i < $narratives->count; $i++)
		{
			$narrative = $narratives->get($i);
			$item = $this->loadItem($narrative);
			if (is_object($item))
				$this->items[] = $item;
		}
	}
}

class PublicationItem
{
	public $narrative;

	public $media;
	public $title;
	public $url;

	public function
	PublicationItem($narrative)
	{
		$this->narrative = $narrative;

		$this->media = $narrative->tourMedia();
		$this->title = $narrative->title;

		global $urlRoot;
		$this->url = $urlRoot . "/narratives/details.php?irn=" . $narrative->irn;
	}
}
?>
