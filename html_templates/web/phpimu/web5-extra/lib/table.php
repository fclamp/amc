<?php
require_once(dirname(__FILE__) . '/../../../php5/query.php');

class TableItems
{
	public $columns;
	public $count;
	public $matches;
	public $table;

	public function
	TableItems($table)
	{
		$this->columns = array();
		$this->table = $table;

		$this->reset();
	}

	public function
	fetchIRN($irn)
	{
		$this->fetchWhere("irn = $irn");
		return $this->get(0);
	}

	public function
	fetchList($list)
	{
		$where = "false";
		foreach ($list as $irn)
		{
			if (! empty($irn))
				$where .= " or irn = $irn";
		}
		$this->fetchWhere($where);
	}

	public function
	fetchWhere($where, $from = 0, $to = 0)
	{
		$this->reset();

		$query = new Query;
		$query->Table = $this->table;
		$query->Select("irn_1");
		foreach ($this->columns as $column)
			$query->Select($column);
		$query->TexqlTerm($where);
		if ($from > 0 && $to > 0 && $from <= $to)
		{
			$query->StartRec = $from;
			$query->EndRec = $to;
		}

		$this->records = $query->Fetch();
		$this->matches = $query->Matches;
		$this->count = count($this->records);
		$this->index = -1;
	}

	public function
	first()
	{
		return $this->get(0);
	}

	public function
	get($index)
	{
		if ($index < 0)
			return false;
		if ($index >= $this->count)
			return false;
		if ($index >= count($this->items))
			$new = true;
		elseif (! isset($this->items[$index]))
			$new = true;
		else
			$new = false;
		if ($new)
		{
			$record = $this->records[$index];
			$item = $this->createItem();
			$item->update($record);
			$this->items[$index] = $item;
		}
		$this->index = $index;
		return $this->items[$index];
	}

	public function
	last()
	{
		return $this->get($this->count - 1);
	}

	public function
	next()
	{
		return $this->get($this->index + 1);
	}

	public function
	prev()
	{
		return $this->get($this->index - 1);
	}

	public function
	reset()
	{
		$this->count = 0;

		$this->fetched = array();
		$this->irns = array();
		$this->items = array();
		$this->records = array();
	}

	// Protected
	protected $fetched;
	protected $index;
	protected $irns;
	protected $items;
	protected $records;
	protected $where;
}

class TableItem 
{
	public $record;
	public $irn;

	public function
	TableItem()
	{
	}

	public function
	update($record)
	{
		// Hack until I can work out why some records are not objects
		// See "Added by AB" comments in php5/query.php
		if (! is_object($record))
			return;

		$this->record = $record;
		$this->irn = $record->irn_1;
	}
}
?>
