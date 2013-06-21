<?php
require_once('storage.php');

class Persistent
{
	public function
	Persistent($name, $duration = 604800)
	{
		$this->storage = new Storage($duration);
		$this->file = $this->storage->full . "/" . $name . ".serial";
		if (! file_exists($this->file))
			$this->serial = "";
		else
		{
			$this->serial = file_get_contents($this->file);
			if (! $this->serial)
				$this->serial = "";
			else
			{
				$vars = unserialize($this->serial);
				foreach ($vars as $var => $value)
					$this->$var = $value;
			}
		}
	}

	public function
	getStorage()
	{
		return $this->storage;
	}

	public function
	save()
	{
		$array = get_object_vars($this);
		$serial = serialize($array);
		if ($serial != $this->serial)
			file_put_contents($this->file, $serial);
	}

	private $file;
	private $serial;
	private $storage;
}
?>
