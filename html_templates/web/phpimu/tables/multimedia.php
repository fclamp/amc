<?php
if (! isset($WEB_ROOT))
	$WEB_ROOT = realpath(dirname(__FILE__) . "/..");
require_once("$WEB_ROOT/web5-extra/lib/table.php");
require_once("$WEB_ROOT/globals.php");


class MultimediaItems extends TableItems
{
	public function
	MultimediaItems()
	{
		$this->TableItems("emultimedia");

		// Set default columns
		$this->columns[] = "ChaFileSize";
		$this->columns[] = "MulDescription";
		$this->columns[] = "MulIdentifier";
		$this->columns[] = "MulMimeFormat";
		$this->columns[] = "MulMimeType";
	}

	public function
	getAudio()
	{
		for ($i = 0; $i < $this->count; $i++)
		{
			$item = $this->get($i);
			if ($item->isAudio)
				return $item;
		}
		return null;
	}

	public function
	getVideo($useAudio = false)
	{
		for ($i = 0; $i < $this->count; $i++)
		{
			$item = $this->get($i);
			if ($item->isVideo)
				return $item;
		}
		if ($useAudio)
			return $this->getAudio();
		return null;
	}

	// Protected
	protected function
	createItem()
	{
		return new MultimediaItem();
	}
}


class MultimediaItem extends TableItem
{
	public $description;
	public $extension;
	public $fileSize;
	public $identifier;
	public $isAudio;
	public $isVideo;
	public $mimeType;
	public $mimeFormat;
	public $url;
	public $urlMagic;

	public function
	MultimediaItem()
	{
		$this->TableItem();

		$this->description = "";
		$this->extension = "";
		$this->fileSize = "";
		$this->identifier = "";
		$this->isAudio = false;
		$this->isVideo = false;
		$this->mimeFormat = "";
		$this->mimeType = "";
		$this->url = "";
		$this->urlMagic = "";
	}

	public function
	update($record)
	{
		parent::update($record);

		if (isset($record->MulDescription))
			$this->description = $record->MulDescription;

		if (isset($record->ChaFileSize))
			$this->fileSize = $record->ChaFileSize;

		if (isset($record->MulIdentifier))
		{
			$this->identifier = $record->MulIdentifier;
			$this->extension = preg_replace('/^.*\./', '', $this->identifier);
		}

		if (isset($record->MulMimeFormat))
			$this->mimeFormat = $record->MulMimeFormat;

		if (isset($record->MulMimeType))
			$this->mimeType = $record->MulMimeType;

		// Dunno if this is quite right
		// Should probably be a bit smarter about mime-types and extensions?
		$this->isAudio = $this->mimeType == "audio";
		$this->isVideo = $this->mimeType == "video";

		global $urlHost;
		global $urlMedia;
		$url = $urlHost . $urlMedia;
		$this->url = $url . ".php?irn=" . $this->irn;
		$this->urlMagic = $url . "." . $this->extension ."?irn=" . $this->irn;
	}
}
?>
