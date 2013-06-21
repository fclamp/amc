<?php
class RSS
{
	public $category;
	public $copyright;
	public $description;
	public $encoding;
	public $language;
	public $link;
	public $title;

	public function
	RSS()
	{
		$this->category = "";
		$this->copyright = "";
		$this->description = "";
		$this->encoding = "ISO-8859-1";
		$this->language = "";
		$this->link = "";
	}

	public function
	addItem()
	{
		$item = new RSSItem;
		$this->items[] = $item;
		return $item;
	}

	public function
	createXML()
	{
		$extra = "";
		$itunes = 'http://www.itunes.com/dtds/podcast-1.0.dtd';
		$dtd = 'xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"';

		$xml = "<?xml version=\"1.0\" encoding=\"{$this->encoding}\"?>\r\n";
		$xml .= "<rss version=\"2.0\"$extra>\r\n";
		$xml .= "\t<channel>\r\n";
		$xml .= "\t<category>{$this->category}</category>\r\n";
		$xml .= "\t<copyright>{$this->copyright}</copyright>\r\n";
		$xml .= "\t<description><![CDATA[{$this->description}]]></description>\r\n";
		$xml .= "\t<language>{$this->language}</language>\r\n";
		$date = date("r");
		$xml .= "\t<lastBuildDate>$date</lastBuildDate>\r\n";
		$xml .= "\t<link>{$this->link}</link>\r\n";
		$xml .= "\t<pubDate>$date</pubDate>\r\n";
		$xml .= "\t<title>{$this->title}</title>\r\n";
		foreach ($this->items as $item)
			$xml .= $item->createXML();
		$xml .= "\t</channel>\r\n";
		$xml .= "</rss>\r\n";
		return $xml;
	}

	public function
	save($file)
	{
		file_put_contents($file, $this->createXML());
	}

	private $items;
}

class RSSItem
{
	public $author;
	public $category;
	public $description;
	public $length;
	public $link;
	public $mimeType;
	public $pubDate;
	public $title;
	public $url;

	public function
	RSSItem()
	{
		$this->author = "";
		$this->category = "";
		$this->description = "";
		$this->length = "";
		$this->link = "";
		$this->mimeType = "";
		$this->pubDate = "";
		$this->title = "";
		$this->url = "";
	}

	public function
	createXML()
	{
		$xml = "\t<item>\r\n";
		$xml .="\t\t<author>{$this->author}</author>\r\n";
		$xml .= "\t\t<category>{$this->category}</category>\r\n";
		$xml .= "\t\t<description><![CDATA[{$this->description}]]></description>\r\n";
		$xml .= "\t\t<enclosure";
		$xml .= " url=\"{$this->url}\"";
		$xml .= " length=\"{$this->length}\"";
		$xml .= " type=\"{$this->mimeType}\"";
		$xml .= " />\r\n";
		$xml .= "\t\t<guid>{$this->link}</guid>\r\n";
		$xml .= "\t\t<link>{$this->link}</link>\r\n";
		$xml .= "\t\t<pubDate>{$this->pubDate}</pubDate>\r\n";
		$xml .= "\t\t<title>{$this->title}</title>\r\n";
		$xml .= "\t</item>\r\n";
		return $xml;
	}
}
?>
