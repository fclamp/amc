<?php
/* KE Software Open Source Licence
** 
** Notice: Copyright (c) 2011  KE SOFTWARE PTY LTD (ACN 006 213 298)
** (the "Owner"). All rights reserved.
** 
** Licence: Permission is hereby granted, free of charge, to any person
** obtaining a copy of this software and associated documentation files
** (the "Software"), to deal with the Software without restriction,
** including without limitation the rights to use, copy, modify, merge,
** publish, distribute, sublicense, and/or sell copies of the Software,
** and to permit persons to whom the Software is furnished to do so,
** subject to the following conditions.
** 
** Conditions: The Software is licensed on condition that:
** 
** (1) Redistributions of source code must retain the above Notice,
**     these Conditions and the following Limitations.
** 
** (2) Redistributions in binary form must reproduce the above Notice,
**     these Conditions and the following Limitations in the
**     documentation and/or other materials provided with the distribution.
** 
** (3) Neither the names of the Owner, nor the names of its contributors
**     may be used to endorse or promote products derived from this
**     Software without specific prior written permission.
** 
** Limitations: Any person exercising any of the permissions in the
** relevant licence will be taken to have accepted the following as
** legally binding terms severally with the Owner and any other
** copyright owners (collectively "Participants"):
** 
** TO THE EXTENT PERMITTED BY LAW, THE SOFTWARE IS PROVIDED "AS IS",
** WITHOUT ANY REPRESENTATION, WARRANTY OR CONDITION OF ANY KIND, EXPRESS
** OR IMPLIED, INCLUDING (WITHOUT LIMITATION) AS TO MERCHANTABILITY,
** FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. TO THE EXTENT
** PERMITTED BY LAW, IN NO EVENT SHALL ANY PARTICIPANT BE LIABLE FOR ANY
** CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
** TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
** SOFTWARE OR THE USE OR OTHER DEALINGS WITH THE SOFTWARE.
** 
** WHERE BY LAW A LIABILITY (ON ANY BASIS) OF ANY PARTICIPANT IN RELATION
** TO THE SOFTWARE CANNOT BE EXCLUDED, THEN TO THE EXTENT PERMITTED BY
** LAW THAT LIABILITY IS LIMITED AT THE OPTION OF THE PARTICIPANT TO THE
** REPLACEMENT, REPAIR OR RESUPPLY OF THE RELEVANT GOODS OR SERVICES
** (INCLUDING BUT NOT LIMITED TO SOFTWARE) OR THE PAYMENT OF THE COST OF SAME.
*/
namespace Bmcd\Imu;
use Bmcd\Imu\ImuHandler;
use Bmcd\Imu\ImuModuleInterface;
use Bmcd\Imu\ImuModuleFetchResult;

class ImuModule extends ImuHandler
	implements ImuModuleInterface
{
	/**
	 * @var mixed $_table
	 */
	protected $_table;

	/**
	 * Class constructor.
	 *
	 * @param mixed $table
	 * @param mixed $session
	 * @return \ImuModule
	 */
	public function __construct($table, $session = null)
	{
		parent::__construct($session);

		$this->_name = 'Module';
		$this->_create = $table;

		$this->_table = $table;
	}

	/**
	 * Get table.
	 *
	 * @param void
	 * @return mixed
	 * @access public
	 */
	public function getTable()
	{
		return $this->_table;
	}

	/**
	 * Magic getter.
	 *
	 * @param string $name
	 * @return mixed
	 * @access public
	 */
	public function __get($name)
	{
		switch ($name)
		{
		  case 'table':
		  	return $this->getTable();
		  default:
		  	return parent::__get($name);
		}
	}

	/**
	 * Add fetch set.
	 *
	 * @param string $name
	 * @param string $columns
	 * @return mixed
	 * @access public
	 */
	public function addFetchSet($name, $columns)
	{
		$args = array();
		$args['name'] = $name;
		$args['columns'] = $columns;
		return $this->call('addFetchSet', $args) + 0;
	}

	/**
	 * Add fetch sets.
	 *
	 * @param mixed $sets
	 * @return mixed
	 * @access public
	 */
	public function addFetchSets($sets)
	{
		return $this->call('addFetchSets', $sets) + 0;
	}

	/**
	 * Add a search alias.
	 *
	 * @param string $name
	 * @param string $columns
	 * @return mixed
	 * @access public
	 */
	public function addSearchAlias($name, $columns)
	{
		$args = array();
		$args['name'] = $name;
		$args['columns'] = $columns;
		return $this->call('addSearchAlias', $args) + 0;
	}

	/**
	 * Add multiple search aliases.
	 *
	 * @param mixed $alias
	 * @return mixed
	 * @access public
	 */
	public function addSearchAliases($aliases)
	{
		return $this->call('addSearchAliases', $aliases) + 0;
	}

	/**
	 * Add sort set.
	 *
	 * @param string $name
	 * @param string $columns
	 * @return mixed
	 * @access public
	 */
	public function addSortSet($name, $columns)
	{
		$args = array();
		$args['name'] = $name;
		$args['columns'] = $columns;
		return $this->call('addSortSet', $args) + 0;
	}

	/**
	 * Add sort sets.
	 *
	 * @param mixed $sets
	 * @return mixed
	 * @access public
	 */
	public function addSortSets($sets)
	{
		return $this->call('addSortSets', $sets) + 0;
	}

	/**
	 * Fetch.
	 *
	 * @param string $flag
	 * @param int $offset
	 * @param int $count
	 * @param mixed $columns
	 * @return ImuModuleFetchResult
	 * @access public
	 */
	public function fetch($flag, $offset, $count, $columns = null)
	{
		$args = array();
		$args['flag'] = $flag;
		$args['offset'] = $offset;
		$args['count'] = $count;
		if ($columns != null)
			$args['columns'] = $columns;
		return $this->makeResult($this->call('fetch', $args));
	}

	/**
	 * Find a key.
	 *
	 * @param string $key
	 * @return mixed
	 * @access public
	 */
	public function findKey($key)
	{
		return $this->call('findKey', $key) + 0;
	}

	/**
	 * Find multiple keys.
	 *
	 * @param mixed $keys
	 * @return mixed
	 * @access public
	 */
	public function findKeys($keys)
	{
		return $this->call('findKeys', $keys) + 0;
	}

	/**
	 * Find terms.
	 *
	 * @param mixed $terms
	 * @return mixed
	 * @access public
	 */
	public function findTerms($terms)
	{
		return $this->call('findTerms', $terms) + 0;
	}

	/**
	 * Find where.
	 *
	 * @param mixed $where
	 * @return mixed
	 * @access public
	 */
	public function findWhere($where)
	{
		return $this->call('findWhere', $where) + 0;
	}

	/**
	 * Insert.
	 *
	 * @param mixed $values
	 * @param mixed $columns
	 * @return mixed
	 * @access public
	 */
	public function insert($values, $columns = null)
	{
		$args = array();
		$args['values'] = $values;
		if ($columns != null)
			$args['columns'] = $columns;
		return $this->call('insert', $args);
	}

	/**
	 * Remove.
	 *
	 * @param string $flag
	 * @param int $offset
	 * @param int $count
	 * @return mixed
	 * @access public
	 */
	public function remove($flag, $offset, $count = null)
	{
		$args = array();
		$args['flag'] = $flag;
		$args['offset'] = $offset;
		if ($count != null)
			$args['count'] = $count;
		return $this->call('remove', $args) + 0;
	}

	/**
	 * Restore from file.
	 *
	 * @param string $file
	 * @return mixed
	 * @access public
	 */
	public function restoreFromFile($file)
	{
		$args = array();
		$args['file'] = $file;
		return $this->call('restoreFromFile', $args) + 0;
	}

	/**
	 * Restore from Temp.
	 *
	 * @param string $file
	 * @return mixed
	 * @access public
	 */
	public function restoreFromTemp($file)
	{
		$args = array();
		$args['file'] = $file;
		return $this->call('restoreFromTemp', $args) + 0;
	}

	/**
	 * Sort.
	 *
	 * @param mixed $columns
	 * @param string $flags
	 * @return mixed
	 * @access public
	 */
	public function sort($columns, $flags = null)
	{
		$args = array();
		$args['columns'] = $columns;
		if ($flags != null)
			$args['flags'] = $flags;
		return $this->call('sort', $args);
	}

	/**
	 * Update.
	 *
	 * @param string $flag
	 * @param int $offset
	 * @param int $count
	 * @param mixed $values
	 * @param mixed $columns
	 * @return \ImuModuleFetchResult
	 * @access public
	 */
	public function update($flag, $offset, $count, $values, $columns = null)
	{
		$args = array();
		$args['flag'] = $flag;
		$args['offset'] = $offset;
		$args['count'] = $count;
		$args['values'] = $values;
		if ($columns != null)
			$args['columns'] = $columns;
		return $this->makeResult($this->call('update', $args));
	}

	/**
	 * Make result.
	 *
	 * @param array $data
	 * @return \ImuModuleFetchResult
	 * @access protected
	 */
	protected function makeResult($data)
	{
		$result = new IMuModuleFetchResult;
		$result->hits = $data['hits'];
		$result->rows = $data['rows'];
		$result->count = count($result->rows);
		return $result;
	}
}