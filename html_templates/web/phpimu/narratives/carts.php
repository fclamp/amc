<?php
require_once(dirname(__FILE__) . "/common.php");
require_once("$WEB_ROOT/web5-extra/lib/persistent.php");

class Carts extends Persistent
{
	public $array;
	public $count;
	public $default;
	public $visible;

	// NASTY
	public $showAssocs;
	public $showObjects;

	public function
	Carts()
	{
		$this->array = array();
		$this->count = 0;
		$this->default = 0;
		$this->visible = false;

		$this->showAssocs = true;
		$this->showObjects = false;

		$this->Persistent("carts");

		if (count($this->array) == 0)
			$this->add("My Collection");
	}

	public function
	add($name)
	{
		$found = false;
		foreach ($this->array as $cart)
		{
			if ($cart->name == $name)
			{
				$found = true;
				break;
			}
		}
		if (! $found)
		{
			$this->array[] = new Cart($name);
			$this->count = count($this->array);
			$this->default = $this->count - 1;
		}
	}

	public function
	clear()
	{
		$this->array = array();
		$this->count = 0;
		$this->default = 0;
		$this->visible = false;

		$this->showAssocs = true;
		$this->showObjects = false;

		$this->add("My Collection");
	}

	public function
	get($index)
	{
		if ($index < 0)
			return null;
		if ($index >= count($this->array))
			return null;
		return $this->array[$index];
	}

	public function
	getDefault()
	{
		return $this->get($this->default);
	}

	public function
	remove($index)
	{
		if ($index < 0)
			return;
		if ($index >= count($this->array))
			return;
		array_splice($this->array, $index, 1);
		$this->count = count($this->array);
		if ($this->default == $index)
			$this->default = 0;
		elseif ($this->default > $index)
			$this->default--;
	}

	public function
	setDefault($index)
	{
		if ($index < 0)
			return;
		if ($index >= count($this->array))
			return;
		$this->default = $index;
	}
}

class Cart
{
	public $irns;
	public $name;

	public function
	Cart($name)
	{
		$this->irns = array();
		$this->name = $name;
	}

	public function
	add($irn)
	{
		if (! in_array($irn, $this->irns))
			$this->irns[] = $irn;
	}

	public function
	includes($irn)
	{
		return in_array($irn, $this->irns);
	}

	public function
	remove($irn)
	{
		$index = array_search($irn, $this->irns);
		if ($index !== false)
			array_splice($this->irns, $index, 1);
	}
}
?>
