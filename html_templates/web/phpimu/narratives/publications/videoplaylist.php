<?php
require_once(dirname(__FILE__) . "/../common.php");
require_once("$WEB_ROOT/narratives/playlist.php");
require_once("$WEB_ROOT/tables/multimedia.php");
require_once("$WEB_ROOT/rss.php");
require_once("$WEB_ROOT/web5-extra/lib/storage.php");

$Storage = new Storage;

class VideoPlaylist extends Playlist
{
	public function
	VideoPlaylist()
	{
		$this->Playlist();
		$this->name = 'videoplaylist';
		$this->title = 'Playlist for Video iPod';
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
?>
		<li>
			<a href="<?php echo $url ?>"><?php echo $title ?></a>
		</li>
<?php
		}
?>
	</ol>
</div>

<?php
		$time = time();

		$multimedia = new MultimediaItems;

		// Build rss file
		global $urlHost;
		global $urlSelf;
		$rss = new RSS;
		$rss->category = "Educational";
		$rss->copyright = "The National Museum";
		$rss->description = "The National Museum's Playlist";
		$rss->language = "en";
		$rss->link = "$urlHost$urlSelf?type={$this->name}&amp;index=$index";
		$rss->pubDate = date("r", $time);
		$rss->title = $cart->name;

		foreach ($this->items as $item)
		{
			$media = $item->media->getVideo(true);
			$rssItem = $rss->addItem();
			$rssItem->description = strip_tags($item->narrative->narrative);
			$rssItem->length = $media->fileSize;
			$rssItem->mimeType = "{$media->mimeType}/{$media->mimeFormat}";
			$rssItem->pubDate = date("r", $time);
			$rssItem->title = $item->narrative->title;
			$rssItem->url = $media->urlMagic;
			$time -= 10;
		}

		global $Storage;
		$file = $cart->name . ".xml";
		$full = $Storage->full . "/" . $file;
		$path = $Storage->path . "/" . $file;
		$rss->save($full);

		$this->showInstructions($path, $cart->name);
	}

	protected function
	loadItem($narrative)
	{
		$item = new VideoPlaylistItem($narrative);
		if ($item->media->getVideo(true) == null)
			return null;
		return $item;
	}
}

class VideoPlaylistItem extends PlaylistItem
{
	public function
	VideoPlaylistItem($narrative)
	{
		$this->PlaylistItem($narrative);
	}
}

$Publication = new VideoPlaylist;
?>
