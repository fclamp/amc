<?php
require_once(dirname(__FILE__) . "/../common.php");
require_once("$WEB_ROOT/narratives/guidedtour.php");
require_once("$WEB_ROOT/tables/multimedia.php");
require_once("$WEB_ROOT/rss.php");
require_once("$WEB_ROOT/web5-extra/lib/storage.php");

$Storage = new Storage;

class NanoTour extends GuidedTour
{
	public function
	NanoTour()
	{
		$this->GuidedTour();
		$this->name = 'nanotour';
		$this->title = 'Self-guided Tour for iPod Nano';
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
		pageTitle("{$cart->name} {$this->title}");
?>
<div class="PublicationList">
	<ol>
<?php
		foreach ($this->items as $item)
		{
			$title = $item->title;
			$url = $item->url;
			$location = $item->location->name;
?>
		<li>
			<a href="<?php echo $url ?>"><?php echo $title ?></a>
			<br />
			<p><?php echo $location ?></p>
		</li>
<?php
		}
?>
	</ol>
</div>

<?php
		$this->loadZones();
		$start = $this->loadStart();
		$time = time();

		$multimedia = new MultimediaItems;

		// Build rss file
		global $urlHost;
		global $urlSelf;
		$rss = new RSS;
		$rss->category = "Educational";
		$rss->copyright = "The National Museum";
		$rss->description = "The National Museum's Self-Guided Tour";
		$rss->language = "en";
		$rss->link = "$urlHost$urlSelf?type={$this->name}&amp;index=$index";
		$rss->pubDate = date("r", $time);
		$rss->title = $cart->name;

		// introduction
		$intro = $start->directions->find("Introduction");
		$media = $intro->getAudio();
		$rssItem = $rss->addItem();
		$rssItem->description = $media->description;
		$rssItem->length = $media->fileSize;
		$rssItem->mimeType = "{$media->mimeType}/{$media->mimeFormat}";
		$rssItem->pubDate = date("r", $time);
		$rssItem->title = "Introduction";
		$rssItem->url = $media->urlMagic;
		$time -= 10;

		$current = $start;
		for (;;)
		{
			$path = $this->findPath($current->irn);
			if (count($path) == 0)
				break;

			$dest = $path[count($path) - 1];

			// description of next room
			$direction = $dest->location->directions->find("Next Exhibit");
			$media = $direction->getAudio();
			$rssItem = $rss->addItem();
			$rssItem->description = $media->description;
			$rssItem->length = $media->fileSize;
			$rssItem->mimeType = "{$media->mimeType}/{$media->mimeFormat}";
			$rssItem->pubDate = date("r", $time);
			$rssItem->title = $dest->location->name;
			$rssItem->url = $media->urlMagic;
			$time -= 10;

			foreach ($path as $zone)
			{
				$location = $zone->location;
				$directions = $current->directions->findAll("Navigation");
				foreach ($directions as $direction)
					if ($direction->destRef == $location->irn)
						break;
				$media = $direction->getAudio();
				$rssItem = $rss->addItem();
				$rssItem->description = $media->description;
				$rssItem->length = $media->fileSize;
				$rssItem->mimeType = "{$media->mimeType}/{$media->mimeFormat}";
				$rssItem->pubDate = date("r", $time);
				$rssItem->title = "{$current->name} to {$location->name}";
				$rssItem->url = $media->urlMagic;
				$time -= 10;

				$current = $location;
			}
			foreach ($dest->items as $item)
			{
				// orientation instructions within the room
				$location = $item->location;
				$direction = $location->directions->find("Orientation");
				$media = $direction->getAudio();
				$rssItem = $rss->addItem();
				$rssItem->description = $media->description;
				$rssItem->length = $media->fileSize;
				$rssItem->mimeType = "{$media->mimeType}/{$media->mimeFormat}";
				$rssItem->pubDate = date("r", $time);
				$rssItem->title = $location->name;
				$rssItem->url = $media->urlMagic;
				$time -= 10;

				// exhibit
				$media = $item->media->getAudio();
				$rssItem = $rss->addItem();
				$rssItem->description = strip_tags($item->narrative->narrative);
				$rssItem->length = $media->fileSize;
				$rssItem->mimeType = "{$media->mimeType}/{$media->mimeFormat}";
				$rssItem->pubDate = date("r", $time);
				$rssItem->title = $item->narrative->title;
				$rssItem->url = $media->urlMagic;
				$time -= 10;
			}
		}

		// last exhibit
		$where = "MulTitle contains '\"Last Exhibit Navigation Instructions\"'";
		$multimedia->fetchWhere($where);
		$media = $multimedia->getAudio();
		$rssItem = $rss->addItem();
		$rssItem->description = $media->description;
		$rssItem->length = $media->fileSize;
		$rssItem->mimeType = "{$media->mimeType}/{$media->mimeFormat}";
		$rssItem->pubDate = date("r", $time);
		$rssItem->title = "Last Exhibit";
		$rssItem->url = $media->urlMagic;
		$time -= 10;

		// list of directions back to start
		$path = $this->findPath($current->irn, $start->irn);
		foreach ($path as $zone)
		{
			$location = $zone->location;
			$directions = $current->directions->findAll("Navigation");
			foreach ($directions as $direction)
				if ($direction->destRef == $location->irn)
					break;
			$media = $direction->getAudio();
			$rssItem = $rss->addItem();
			$rssItem->description = $media->description;
			$rssItem->length = $media->fileSize;
			$rssItem->mimeType = "{$media->mimeType}/{$media->mimeFormat}";
			$rssItem->pubDate = date("r", $time);
			$rssItem->title = "{$current->name} to {$location->name}";
			$rssItem->url = $media->urlMagic;
			$time -= 10;

			$current = $location;
		}

		// tour finish
		$where = "MulTitle contains '\"Tour Finish Navigation Instructions\"'";
		$multimedia->fetchWhere($where);
		$media = $multimedia->getAudio();
		$rssItem = $rss->addItem();
		$rssItem->description = $media->description;
		$rssItem->length = $media->fileSize;
		$rssItem->mimeType = "{$media->mimeType}/{$media->mimeFormat}";
		$rssItem->pubDate = date("r", $time);
		$rssItem->title = "Tour Finish";
		$rssItem->url = $media->urlMagic;
		$time -= 10;

		global $Storage;
		$file = $cart->name . ".xml";
		$full = $Storage->full . "/" . $file;
		$path = $Storage->path . "/" . $file;
		$rss->save($full);

		$this->ShowInstructions($path, $cart->name);
	}

	protected function
	loadItem($narrative)
	{
		$item = new NanoTourItem($narrative);
		if ($item->media->getAudio() == null)
			return null;
		if (! $item->onDisplay)
			return null;
		return $item;
	}
}

class NanoTourItem extends GuidedTourItem
{
	public function
	NanoTourItem($narrative)
	{
		$this->GuidedTourItem($narrative);
	}
}

$Publication = new NanoTour;
?>
