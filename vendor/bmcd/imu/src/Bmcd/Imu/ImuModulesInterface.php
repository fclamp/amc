<?php

/**
 * IMu Modules interface.
 *
 * @author BMCD AP
 * @version 0.1
 */
namespace Bmcd\Imu;

interface ImuModulesInterface
{
	public function __construct($session);
	public function addFetchSet($name, $set);
	public function addFetchSets($sets);
	public function addSearchAlias($name, $set);
	public function addSearchAliases($aliases);
	public function addSortSet($name, $set);
	public function addSortSets($sets);
	public function fetch($flag, $offset, $count, $columns);
	public function findAttachments($table, $column, $key);
	public function findKeys($keys, $include);
	public function findTerms($terms, $include);
	public function getHits($module);
	public function restoreFromFile($file, $module);
	public function restoreFromTemp($file, $module);
	public function setModules($list);
	public function sort($set, $flags);
}
