<?php
require_once(dirname(__FILE__) . "/common.php");
require_once("$WEB_ROOT/narratives/publication.php");


class Playlist extends Publication
{
	public function
	Playlist()
	{
		$this->Publication();
	}

	protected function
	showInstructions($path, $name)
	{
		global $cart;
?>

<div class="PublicationInstructions">
	To add to your iPod:
	<ol>
		<li>
			Start iTunes.
		</li>
		<li>
			Drag this <a href="<?php echo $path?>">Podcast</a> to the
			iTunes window and drop it anywhere.
		</li>
		<li>
			View your podcasts in iTunes and expand
			<b><?php echo $name ?></b>.
		</li>
		<li>
			Select <b>Get All</b>.
		</li>
		<li>
			When iTunes has retrieved all the items, select
			<b>File</b>&nbsp;&gt;&nbsp;<b>New&nbsp;Playlist&nbsp;from&nbsp;Selection</b>.
		</li>
	</ol>
	You're ready to go!
</div>
<?php
	}
}


class PlaylistItem extends PublicationItem
{
	public function
	PlaylistItem($narrative)
	{
		$this->PublicationItem($narrative);
	}
}
?>
