<?php
if (! isset($WEB_ROOT))
	$WEB_ROOT = realpath(dirname(__FILE__) . "/..");
require_once("$WEB_ROOT/web5-extra/lib/table.php");
require_once("$WEB_ROOT/globals.php");
require_once("$WEB_ROOT/tables/locations.php");
require_once("$WEB_ROOT/tables/multimedia.php");
require_once("$WEB_ROOT/tables/objects.php");

class NarrativeItems extends TableItems
{
	public function
	NarrativeItems()
	{
		$this->TableItems("enarratives");

		// Set default columns
		$this->columns[] = "AssAssociatedWithComment_tab";
		$this->columns[] = "AssAssociatedWithRef_tab";
		$this->columns[] = "DesType_tab";
		$this->columns[] = "MulMultiMediaRef_tab->emultimedia->SummaryData";
		$this->columns[] = "NarAuthorsRef_tab->eparties->SummaryData";
		$this->columns[] = "NarNarrative";
		$this->columns[] = "NarTitle";
		$this->columns[] = "ObjObjectNotes_tab";
		$this->columns[] = "ObjObjectsRef_tab";
		$this->columns[] = "TouLocationRef";
		$this->columns[] = "TouMultimediaRef_tab";
	}

	public function
	fetchMaster()
	{
		$this->fetchWhere("exists(DesType_tab where DesType = 'master')");
		return $this->get(0);
	}

	// Protected
	protected function
	createItem()
	{
		return new NarrativeItem();
	}
}

class NarrativeItem extends TableItem
{
	public $authors;
	public $imageAlt;
	public $imageRef;
	public $isMaster;
	public $narrative;
	public $title;
	public $types;

	public function
	NarrativeItem()
	{
		$this->TableItem();

		$this->title = "";
		$this->authors = array();
		$this->imageAlt = "";
		$this->imageRef = "";
		$this->isMaster = false;
		$this->narrative = "";
		$this->title = "";
		$this->types = array();
	}

	public function
	associated()
	{
		if (isset($this->associated))
			return $this->associated;

		$refs = $this->record->AssAssociatedWithRef_tab;
		$comments = $this->record->AssAssociatedWithComment_tab;

		$this->associated = array();
		if (empty($refs))
			return $this->associated;

		$irns = array();
		for ($i = 0; $i < count($refs); $i++)
		{
			$assoc = new NarrativeAssociation;
			$assoc->ref = $refs[$i];
			$assoc->comment = "";
			if (is_array($comments) && $i < count($comments))
				$assoc->comment = $comments[$i];

			$this->associated[] = $assoc;

			$irns[] = $assoc->ref;
		}

		$items = new NarrativeItems;
		$items->fetchList($irns);
		for ($i = 0; $i < $items->count; $i++)
		{
			$item = $items->get($i);
			foreach ($this->associated as $assoc)
			{
				if ($assoc->ref == $item->irn)
				{
					$assoc->item = $item;
					break;
				}
			}
		}
		return $this->associated;
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
	objects()
	{
		if (isset($this->objects))
			return $this->objects;

		$refs = $this->record->ObjObjectsRef_tab;
		$notes = $this->record->ObjObjectNotes_tab;

		$this->objects = array();
		if (empty($refs))
			return $this->objects;

		$irns = array();
		for ($i = 0; $i < count($refs); $i++)
		{
			$object = new NarrativeObject;
			$object->ref = $refs[$i];
			$object->note = "";
			if (is_array($notes) && $i < count($notes))
				$object->note = $notes[$i];

			$this->objects[] = $object;

			$irns[] = $object->ref;
		}

		$items = new ObjectItems;
		$items->fetchList($irns);
		for ($i = 0; $i < $items->count; $i++)
		{
			$item = $items->get($i);
			foreach ($this->objects as $object)
			{
				if ($object->ref == $item->irn)
				{
					$object->item = $item;
					break;
				}
			}
		}
		return $this->objects;
	}

	public function
	tourLoc()
	{
		if (isset($this->tourLoc))
			return $this->tourLoc;

		$ref = $this->record->TouLocationRef;

		$this->tourLoc = null;
		if (! isset($ref))
			return $this->tourLoc;

		$items = new LocationItems;
		$items->fetchIRN($ref);
		$this->tourLoc = $items->get(0);

		return $this->tourLoc;
	}


	public function
	tourMedia()
	{
		if (isset($this->tourMedia))
			return $this->tourMedia;

		$refs = $this->record->TouMultimediaRef_tab;

		$this->tourMedia = new MultimediaItems;
		if (empty($refs))
			return $this->tourMedia;

		$this->tourMedia->fetchList($refs);
		return $this->tourMedia;
	}

	public function
	trails()
	{
		if (isset($this->trails))
			return $this->trails;

		$this->trails = array();
		if ($this->isMaster)
			return $this->trails;

		// If the irn is not set we can't do the query
		// This seems to happen because of a bug in web5
		//
		if (! isset($this->irn))
			return $this->trails;

		$items = new NarrativeItems;
		$where = "exists(AssAssociatedWithRef_tab where AssAssociatedWithRef = " . $this->irn . ")";
		$items->fetchWhere($where);
		for ($i = 0; $i < $items->count; $i++)
		{
			$parent = $items->get($i);
			/*
			if (! isset($parent->irn))
				continue;
			*/
			$trails = $parent->trails();
			if (count($trails) == 0)
				$this->trails[] = array($parent);
			else
			{
				foreach ($trails as $trail)
				{
					$trail[] = $parent;
					$this->trails[] = $trail;
				}
			}
		}
		return $this->trails;
	}

	public function
	update($record)
	{
		parent::update($record);

		if (! empty($record->DesType_tab))
		{
			$this->types = array();
			foreach ($record->DesType_tab as $type)
				$this->types[] = $type;
		}

		if (! empty($record->NarTitle))
			$this->title = $record->NarTitle;

		if (! empty($record->NarAuthorsRef_tab))
		{
			$this->authors = array();
			foreach ($record->NarAuthorsRef_tab as $author)
			{
				if (is_object($author))
					$string = $author->SummaryData;
				else
					$string = "(restricted)";
				$this->authors[] = $string;
			}
		}

		if (! empty($record->NarNarrative))
			$this->narrative = $record->NarNarrative;

		if (! empty($record->DesType_tab))
		{
			$this->isMaster = false;
			foreach ($record->DesType_tab as $type)
			{
				if (strcasecmp($type, "master") == 0)
				{
					$this->isMaster = true;
					break;
				}
			}
		}

		if (! empty($record->MulMultiMediaRef_tab))
		{
			$media = $record->MulMultiMediaRef_tab[0];
			if (is_object($media))
			{
				$this->imageRef = $media->irn_1;
				$this->imageAlt = $media->SummaryData;
			}
		}
	}

	private $associated;
	private $objects;
	private $tourLoc;
	private $trails;
}

class NarrativeAssociation
{
	public $ref;
	public $comment;
	public $item;
}

class NarrativeObject
{
	public $ref;
	public $note;
	public $item;
}
?>
