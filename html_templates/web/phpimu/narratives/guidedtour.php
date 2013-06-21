<?php
require_once(dirname(__FILE__) . "/common.php");
require_once("$WEB_ROOT/narratives/playlist.php");
require_once("$WEB_ROOT/tables/locations.php");


class GuidedTour extends Playlist
{
	public function
	GuidedTour()
	{
		$this->Playlist();
	}

	protected $zones;

	protected function
	findPath($start, $dest = 0)
	{
		// Not technically correct :-)
		$infinity = 999999;

		// Mark all zones as infinitely far
		foreach ($this->zones as $zone)
		{
			$zone->dist = $infinity;
			unset($zone->prev);
		}

		// The start is zero distance by definition
		$this->zones[$start]->dist = 0;

		// Find the destination zone
		$remaining = $this->zones;
		$zone = null;
		while (count($remaining) > 0)
		{
			// Get zone with minimum distance
			$irn = -1;
			$dist = $infinity;
			foreach ($remaining as $check)
			{
				if ($dist > $check->dist)
				{
					$irn = $check->location->irn;
					$dist = $check->dist;
				}
			}
			if ($irn < 0)
				// None left
				break;
			$zone = $remaining[$irn];

			if ($dest > 0)
			{
				if ($irn == $dest)
					break;
			}
			else
			{
				if (count($zone->items) > 0 && ! $zone->visited)
				{
					$zone->visited = true;
					break;
				}
			}

			foreach ($zone->neighbours as $neighbour)
			{
				if (! isset($remaining[$neighbour]))
					continue;
				$nzone = $remaining[$neighbour];
				$dist = $zone->dist + 1;
				if ($nzone->dist > $dist)
				{
					$nzone->dist = $dist;
					$nzone->prev = $irn;
				}
			}
			unset($remaining[$irn]);
			$zone = null;
		}
	
		$path = array();
		if (! is_null($zone))
		{
			while (isset($zone->prev))
			{
				array_unshift($path, $zone);
				$zone = $this->zones[$zone->prev];
			}
		}
		return $path;
	}

	protected function
	loadStart()
	{
		if (isset($this->start))
			return $this->start;

		$locations = new LocationItems;
		$where = "exists(TouDirectionLabel_tab where TouDirectionLabel = 'Introduction')";
		$locations->fetchWhere($where);
		$this->start = $locations->next();
		return $this->start;
	}

	protected function
	loadZones()
	{
		if (isset($this->zones))
			return $this->zones;

		$this->zones = array();
		$locations = new LocationItems;
		$locations->fetchWhere("TouDisplayType = 'Zone'");
		while ($location = $locations->next())
		{
			$zone = new GuidedTourZone;
			$zone->location = $location;

			$zone->neighbours = array();
			$directions = $location->directions->findAll("Navigation");
			foreach ($directions as $direction)
			for ($i = 0; $i < $location->directions->count; $i++)
				$zone->neighbours[] = $direction->destRef;

			$zone->items = array();
			foreach ($this->items as $item)
				if ($item->location->parentRef == $location->irn)
					$zone->items[] = $item;

			$zone->visited = false;

			$this->zones[$location->irn] = $zone;
		}
		return $this->zones;
	}
}


class GuidedTourItem extends PlaylistItem
{
	public $location;
	public $onDisplay;

	public function
	GuidedTourItem($narrative)
	{
		$this->PlaylistItem($narrative);

		// ... get location information
		$this->location = $narrative->tourLoc();
		if (! is_object($this->location))
			$this->onDisplay = false;
		else
			$this->onDisplay = $this->location->display;
	}
}


class GuidedTourZone
{
	public $dist;
	public $irn;
	public $location;
	public $neighbours;
	public $items;
	public $prev;
	public $visited;
}
?>
