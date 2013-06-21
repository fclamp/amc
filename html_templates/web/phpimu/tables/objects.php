<?php
if (! isset($WEB_ROOT))
	$WEB_ROOT = realpath(dirname(__FILE__) . "/..");
require_once("$WEB_ROOT/web5-extra/lib/table.php");
require_once("$WEB_ROOT/globals.php");
require_once("$WEB_ROOT/tables/locations.php");
require_once("$WEB_ROOT/tables/multimedia.php");

class ObjectItems extends TableItems
{
	public function
	ObjectItems()
	{
		$this->TableItems("ecatalogue");

		// Set default columns
		$this->columns[] = "CreCreationPlace1_tab";
		$this->columns[] = "CreCreationPlace2_tab";
		$this->columns[] = "CreCreationPlace3_tab";
		$this->columns[] = "CreCreationPlace4_tab";
		$this->columns[] = "CreCreationPlace5_tab";
		$this->columns[] = "CreDateCreated";
		$this->columns[] = "CreCreatorRef_tab->eparties->NamFullName";
		$this->columns[] = "CreRole_tab";
		$this->columns[] = "LocCurrentLocationRef->elocations->TouDisplayName";
		$this->columns[] = "MulMultiMediaRef_tab->emultimedia->SummaryData";
		$this->columns[] = "PhyDepth_tab";
		$this->columns[] = "PhyDescription";
		$this->columns[] = "PhyHeight_tab";
		$this->columns[] = "PhyMedium_tab";
		$this->columns[] = "PhyTechnique_tab";
		$this->columns[] = "PhyType_tab";
		$this->columns[] = "PhyUnitLength_tab";
		$this->columns[] = "PhyWidth_tab";
		$this->columns[] = "SummaryData";
		$this->columns[] = "TitAccessionDate";
		$this->columns[] = "TitAccessionNo";
		$this->columns[] = "TitMainTitle";
		$this->columns[] = "TitObjectCategory";
	}

	// Protected
	protected function
	createItem()
	{
		return new ObjectItem();
	}
}

class ObjectItem extends TableItem
{
	public $accessionDate;
	public $accessionNo;
	public $category;
	public $creationDate;
	public $creationPlaces;
	public $creators;
	public $description;
	public $imageRef;
	public $imageAlt;
	public $location;
	public $measurements;
	public $medium;
	public $summary;
	public $technique;
	public $title;

	public function
	ObjectItem()
	{
		$this->TableItem();

		$this->accessionDate = "";
		$this->accessionNo = "";
		$this->category = "";
		$this->creationDate = "";
		$this->creationPlaces = array();
		$this->creators = array();
		$this->description = "";
		$this->imageRef = "";
		$this->imageAlt = "";
		$this->location = "";
		$this->measurements = array();
		$this->medium = array();
		$this->summary = "";
		$this->technique = array();
		$this->title = "";
	}

	public function
	imageURL($args)
	{
		global $urlMedia;
		$url = $urlMedia . ".php?irn=" . $this->imageRef;
		if (! empty($args))
			$url .= "&amp;" . $args;
		return $url;
	}

	public function
	update($record)
	{
		parent::update($record);

		if (! empty($record->CreCreatorRef_tab))
		{
			$creators = $record->CreCreatorRef_tab;
			$roles = $record->CreRole_tab;
			$this->creators = array();
			for ($i = 0; $i < count($creators); $i++)
			{
				if (! is_object($creators[$i]))
					continue;

				$creator = new ObjectCreator;
				$creator->name = $creators[$i]->NamFullName;
				$creator->role = "";
				if (is_array($roles) && $i < count($roles))
					$creator->role = $roles[$i];

				$this->creators[] = $creator;
			}
		}

		if (! empty($record->CreDateCreated))
			$this->creationDate = $record->CreDateCreated;

		if (! empty($record->LocCurrentLocationRef))
			$this->location = $record->LocCurrentLocationRef->TouDisplayName;

		if (! empty($record->MulMultiMediaRef_tab))
		{
			$media = $record->MulMultiMediaRef_tab[0];
			if (is_object($media))
			{
				$this->imageRef = $media->irn_1;
				$this->imageAlt = $media->SummaryData;
			}
		}

		if (! empty($record->PhyDescription))
			$this->description = $record->PhyDescription;

		if (! empty($record->PhyMedium_tab))
		{
			$this->medium = array();
			foreach ($record->PhyMedium_tab as $medium)
				$this->medium[] = $medium;
		}

		if (! empty($record->PhyTechnique_tab))
		{
			$this->technique = array();
			foreach ($record->PhyTechnique_tab as $technique)
				$this->technique[] = $technique;
		}

		if (! empty($record->SummaryData))
			$this->summary = $record->SummaryData;

		if (! empty($record->TitAccessionDate))
			$this->accessionDate = $record->TitAccessionDate;

		if (! empty($record->TitAccessionNo))
			$this->accessionNo = $record->TitAccessionNo;

		if (! empty($record->TitMainTitle))
			$this->title = $record->TitMainTitle;

		if (! empty($record->TitObjectCategory))
			$this->category = $record->TitObjectCategory;

		// Place of Creation is messy
		$max = 0;
		if (! empty($record->CreCreationPlace1_tab))
			if ($max < count($record->CreCreationPlace1_tab))
				$max = count($record->CreCreationPlace1_tab);
		if (! empty($record->CreCreationPlace2_tab))
			if ($max < count($record->CreCreationPlace2_tab))
				$max = count($record->CreCreationPlace2_tab);
		if (! empty($record->CreCreationPlace3_tab))
			if ($max < count($record->CreCreationPlace3_tab))
				$max = count($record->CreCreationPlace3_tab);
		if (! empty($record->CreCreationPlace4_tab))
			if ($max < count($record->CreCreationPlace4_tab))
				$max = count($record->CreCreationPlace4_tab);
		if (! empty($record->CreCreationPlace5_tab))
			if ($max < count($record->CreCreationPlace5_tab))
				$max = count($record->CreCreationPlace5_tab);
		if ($max > 0)
		{
			$level1 = $record->CreCreationPlace1_tab;
			$level2 = $record->CreCreationPlace2_tab;
			$level3 = $record->CreCreationPlace3_tab;
			$level4 = $record->CreCreationPlace4_tab;
			$level5 = $record->CreCreationPlace5_tab;
			$this->creationPlaces = array();
			for ($i = 0; $i < $max; $i++)
			{
				$place = new ObjectPlace;
				$place->level1 = "";
				if (is_array($level1) && $i < count($level1))
					$place->level1 = $level1[$i];
				$place->level2 = "";
				if (is_array($level2) && $i < count($level2))
					$place->level2 = $level2[$i];
				$place->level3 = "";
				if (is_array($level3) && $i < count($level3))
					$place->level3 = $level3[$i];
				$place->level4 = "";
				if (is_array($level4) && $i < count($level4))
					$place->level4 = $level4[$i];
				$place->level5 = "";
				if (is_array($level5) && $i < count($level5))
					$place->level5 = $level5[$i];

				$text = "";
				if ($place->level5 != "")
				{
					if ($text != "")
						$text .= ", ";
					$text .= $place->level5;
				}
				if ($place->level4 != "")
				{
					if ($text != "")
						$text .= ", ";
					$text .= $place->level4;
				}
				if ($place->level3 != "")
				{
					if ($text != "")
						$text .= ", ";
					$text .= $place->level3;
				}
				if ($place->level2 != "")
				{
					if ($text != "")
						$text .= ", ";
					$text .= $place->level2;
				}
				if ($place->level1 != "")
				{
					if ($text != "")
						$text .= ", ";
					$text .= $place->level1;
				}
				$place->text = $text;

				$this->creationPlaces[] = $place;
			}
		}

		// Measurements are *really* messy
		$max = 0;
		if (! empty($record->PhyDepth_tab))
			if ($max < count($record->PhyDepth_tab))
				$max = count($record->PhyDepth_tab);
		if (! empty($record->PhyHeight_tab))
			if ($max < count($record->PhyHeight_tab))
				$max = count($record->PhyHeight_tab);
		if (! empty($record->PhyType_tab))
			if ($max < count($record->PhyType_tab))
				$max = count($record->PhyType_tab);
		if (! empty($record->PhyUnitLength_tab))
			if ($max < count($record->PhyUnitLength_tab))
				$max = count($record->PhyUnitLength_tab);
		if (! empty($record->PhyWidth_tab))
			if ($max < count($record->PhyWidth_tab))
				$max = count($record->PhyWidth_tab);
		if ($max > 0)
		{
			$depths = $record->PhyDepth_tab;
			$heights = $record->PhyHeight_tab;
			$types = $record->PhyType_tab;
			$units = $record->PhyUnitLength_tab;
			$widths = $record->PhyWidth_tab;
			$this->measurements = array();
			for ($i = 0; $i < $max; $i++)
			{
				$measurement = new ObjectMeasurement;
				$measurement->depth = "";
				if (is_array($depths) && $i < count($depths))
					$measurement->depth = $depths[$i];
				$measurement->height = "";
				if (is_array($heights) && $i < count($heights))
					$measurement->height = $heights[$i];
				$measurement->type = "";
				if (is_array($types) && $i < count($types))
					$measurement->type = $types[$i];
				$measurement->unit = "";
				if (is_array($units) && $i < count($units))
					$measurement->unit = $units[$i];
				$measurement->width = "";
				if (is_array($widths) && $i < count($widths))
					$measurement->width = $widths[$i];

				$text = "";
				if ($measurement->type != "")
					$text = $measurement->type . ": ";
				$join = "";
				if ($measurement->width != "")
				{
					$text .= $join;
					$text .= $measurement->width;
					if ($measurement->unit != "")
						$text .= " " . $measurement->unit;
					$text .= " (w)";
					$join = " x ";
				}
				if ($measurement->height != "")
				{
					$text .= $join;
					$text .= $measurement->height;
					if ($measurement->unit != "")
						$text .= " " . $measurement->unit;
					$text .= " (h)";
					$join = " x ";
				}
				if ($measurement->depth != "")
				{
					$text .= $join;
					$text .= $measurement->depth;
					if ($measurement->unit != "")
						$text .= " " . $measurement->unit;
					$text .= " (d)";
					$join = " x ";
				}
				$measurement->text = $text;

				$this->measurements[] = $measurement;
			}
		}
	}
}

class ObjectCreator
{
	public $name;
	public $role;
}

class ObjectMeasurement
{
	public $depth;
	public $height;
	public $type;
	public $unit;
	public $width;

	public $text;
}

class ObjectPlace
{
	public $level1;
	public $level2;
	public $level3;
	public $level4;
	public $level5;

	public $text;
}
?>
