<?php

/**
 * IMu Module interface.
 *
 * @author BMCD AP
 * @version 0.1
 */
namespace Bmcd\Imu;

interface ImuModuleInterface
{
	public function __construct($table, $session);
	public function getTable();
	public function __get($name);
	public function addFetchSet($name, $columns);
	public function addFetchSets($sets);
	public function addSearchAlias($name, $columns);
	public function addSearchAliases($aliases);
	public function addSortSet($name, $columns);
	public function addSortSets($sets);
	public function fetch($flag, $offset, $count, $columns);
	public function findKey($key);
	public function findKeys($keys);
	public function findTerms($terms);
	public function findWhere($where);
	public function insert($values, $columns);
	public function remove($flag, $offset, $count);
	public function restoreFromFile($file);
	public function restoreFromTemp($file);
	public function sort($columns, $flags);
	public function update($flag, $offset, $count, $values, $columns);
}
