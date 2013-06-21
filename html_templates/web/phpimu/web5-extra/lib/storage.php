<?php
class Storage
{
	public $full;
	public $ident;
	public $path;

	public function
	Storage($duration = 604800)
	{
		$this->duration = $duration;

		// This cookie name is just the base web directory name
		$self = $_SERVER['PHP_SELF'];
		$this->name = preg_replace('/^\/([^\/]*)\/.*$/', '$1', $self);

		// Check cookie
		if (isset($_COOKIE[$this->name]))
			$this->cookie = $_COOKIE[$this->name];
		else
			$this->cookie = date("YmdHisu");

		// Set/refresh the cookie
		$expire = time() + $duration;
		setcookie($this->name, $this->cookie, $expire);

		// Create identifier
		$this->ident = $_SERVER['REMOTE_ADDR'] . "-" . $this->cookie;

		// Create path
		$this->path = "/" . $this->name;
		$this->full = realpath(dirname(__FILE__) . "/../../..");
		$this->addDir("tmp");
		$this->addDir("storage");
		$this->addDir($this->ident);
	}

	private $cookie;
	private $duration;
	private $name;

	private function
	addDir($dir)
	{
		$this->path .= "/" . $dir;
		$this->full .= "/" . $dir;
		if (is_dir($this->full))
			return;
		if (mkdir($this->full, 0777))
			return;
		throw new Exception("Can't make storage directory: " . $this->full);
	}
}
?>
