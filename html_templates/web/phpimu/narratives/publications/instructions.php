<?php
require_once(dirname(__FILE__) . "/../common.php");
require_once("$WEB_ROOT/web5-extra/lib/storage.php");
require_once("$WEB_ROOT/rss.php");
require_once("$WEB_ROOT/tables/multimedia.php");
require_once("$WEB_ROOT/narratives/guidedtour.php");

$Storage = new Storage;

class Instructions extends GuidedTour
{
	public function
	Instructions()
	{
		$this->GuidedTour();
		$this->name = 'instructions';
		$this->title = 'Instructions for Self-guided Tour';
	}

    public function
	canPublish($cart)
	{
		return true;
	}

	public function
	publish($index, $cart)
	{
		$this->loadItems($index, $cart);
		$this->loadZones();
		$start = $this->loadStart();

		$multimedia = new MultimediaItems;

		$intro = $start->directions->find("Introduction");
		$media = $intro->getVideo(true);
?>
<div style="text-align: left">

<h3>Introduction</h3>
<p><?php echo $media->description ?></p>
<?php
		$current = $start;
		for (;;)
		{
			$path = $this->findPath($current->irn);
			if (count($path) == 0)
				break;

			$dest = $path[count($path) - 1];

			$direction = $dest->location->directions->find("Next Exhibit");
			$media = $direction->getVideo(true);
?>

<!-- Description of next room -->
<h3><?php echo $dest->location->name ?></h3>
<p><?php echo $media->description ?></p>
<?php
			foreach ($path as $zone)
			{
				$location = $zone->location;
				$directions = $current->directions->findAll("Navigation");
				foreach ($directions as $direction)
					if ($direction->destRef == $location->irn)
						break;
				$media = $direction->getVideo(true);
				$title = "{$current->name} to {$location->name}";
?>

<!-- Direction to next room -->
<h3><?php echo $title ?></h3>
<p><?php echo $media->description ?></p>
<?php
				$current = $location;
			}
			foreach ($dest->items as $item)
			{
				$location = $item->location;
				$direction = $location->directions->find("Orientation");
				$orientation = $direction->getVideo(true);
				$media = $item->media->getVideo(true);
?>

<!-- Object -->
<h3><?php echo $item->narrative->title ?></h3>
<p><?php echo $orientation->description ?></p>
<p><?php echo $item->narrative->narrative ?></p>
<?php
			}
		}

		// last exhibit
		$where = "MulTitle contains '\"Last Exhibit Navigation Instructions\"'";
		$multimedia->fetchWhere($where);
		$media = $multimedia->getVideo(true);
?>

<!-- Last exhibit -->
<h3>Last Exhibit</h3>
<p><?php echo $media->description ?></p>
<?php

		// list of directions back to start
		$path = $this->findPath($current->irn, $start->irn);
		foreach ($path as $zone)
		{
			$location = $zone->location;
			$directions = $current->directions->findAll("Navigation");
			foreach ($directions as $direction)
				if ($direction->destRef == $location->irn)
					break;
			$media = $direction->getVideo(true);
			$title = "{$current->name} to {$location->name}";
?>

<!-- Direction to next room -->
<h3><?php echo $title ?></h3>
<p><?php echo $media->description ?></p>
<?php

			$current = $location;
		}

		// tour finish
		$where = "MulTitle contains '\"Tour Finish Navigation Instructions\"'";
		$multimedia->fetchWhere($where);
		$media = $multimedia->getVideo(true);
?>

<!-- Direction to next room -->
<h3>Tour Finish</h3>
<p><?php echo $media->description ?></p>

</div>
<?php
	}

	protected function
	loadItem($narrative)
	{
		$item = new InstructionsItem($narrative);
		if ($item->media->getVideo(true) == null)
			return null;
		if (! $item->onDisplay)
			return null;
		return $item;
	}
}

class InstructionsItem extends GuidedTourItem
{
	public function
	InstructionsItem($narrative)
	{
		$this->GuidedTourItem($narrative);
	}
}

$Publication = new Instructions;
?>
