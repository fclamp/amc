<?php
if (! isset($WEB_ROOT))
	$WEB_ROOT = realpath(dirname(__FILE__) . "/..");
require_once("$WEB_ROOT/web5-extra/lib/table.php");
require_once("$WEB_ROOT/globals.php");
require_once("$WEB_ROOT/tables/multimedia.php");

class LocationItems extends TableItems
{
	public function
	LocationItems()
	{
		$this->TableItems("elocations");

		// Set default columns
		$this->columns[] = "LocParentRef";
		$this->columns[] = "TouDestinationRef_tab";
		$this->columns[] = "TouDirectionLabel_tab";
		$this->columns[] = "TouDisplayLocation";
		$this->columns[] = "TouDisplayName";
		$this->columns[] = "TouDisplayType";
		$this->columns[] = "TouLocationOrder";
		$this->columns[] = "TouLocationOrderSort";
		$this->columns[] = "TouMultimediaRef_nesttab";
		$this->columns[] = "SummaryData";
	}

	// Protected
	protected function
	createItem()
	{
		return new LocationItem();
	}
}

class LocationItem extends TableItem
{
	public $directions;
	public $display;
	public $name;
	public $order;
	public $parentRef;
	public $sortOrder;

	public function
	LocationItem()
	{
		$this->TableItem();

		$this->directions = new LocationDirections;
		$this->display = false;
		$this->name = "";
		$this->order = "";
		$this->parentRef = "";
		$this->sortOrder = "";
	}

	public function
	update($record)
	{
		parent::update($record);

		if (! empty($record->TouDirectionLabel_tab))
		{
			$this->directions = new LocationDirections;

			$label = $record->TouDirectionLabel_tab;
			$dest = $record->TouDestinationRef_tab;
			$media = $record->TouMultimediaRef_nesttab;

			for ($i = 0; $i < count($label); $i++)
			{
				$direction = new LocationDirection;

				$direction->label = $label[$i];
				if (is_array($dest) && $i < count($dest))
					$direction->destRef = $dest[$i];
				if (is_array($media) && $i < count($media))
					$direction->mediaRefs = $media[$i];

				$this->directions->add($direction);
			}
		}

		if (! empty($record->TouDisplayLocation))
		{
			$this->display = false;
			if (strcasecmp($record->TouDisplayLocation, "yes") == 0)
				$this->display = true;
		}

		if (! empty($record->TouDisplayName))
			$this->name = $record->TouDisplayName;

		if (! empty($record->TouLocationOrderSort))
			$this->order = $record->TouLocationOrder;

		if (! empty($record->LocParentRef))
			$this->parentRef = $record->LocParentRef;

		if (! empty($record->TouLocationOrderSort))
			$this->sortOrder = $record->TouLocationOrderSort;
	}
}

class LocationDirections
{
	public $count;

	public function
	LocationDirections()
	{
		$this->array = array();
		$this->count = 0;
	}

	public function
	add($direction)
	{
		$this->array[] = $direction;
		$this->count = count($this->array);
	}

	public function
	find($label)
	{
		foreach ($this->array as $direction)
			if ($direction->label == $label)
				return $direction;
		return null;
	}

	public function
	findAll($label)
	{
		$array = array();
		foreach ($this->array as $direction)
			if ($direction->label == $label)
				$array[] = $direction;
		return $array;
	}

	public function
	get($index)
	{
		if ($index < 0)
			return null;
		if ($index >= $this->count)
			return null;
		return $this->array[$index];
	}

	private $array;
}

class LocationDirection
{
	public $destRef;
	public $label;
	public $mediaRefs;

	public function
	getAudio()
	{
		if (! isset($this->audio))
		{
			$multimedia = $this->getMultimedia();
			$this->audio = $multimedia->getAudio();
		}
		return $this->audio;
	}

	public function
	getVideo($useAudio = false)
	{
		if (! isset($this->video))
		{
			$multimedia = $this->getMultimedia();
			$this->video = $multimedia->getVideo($useAudio);
		}
		return $this->video;
	}

	private $audio;
	private $multimedia;
	private $video;

	private function
	getMultimedia()
	{
		if (! isset($this->multimedia))
		{
			$this->multimedia = new MultimediaItems;
			$this->multimedia->fetchList($this->mediaRefs);
		}
		return $this->multimedia;
	}
}
?>
