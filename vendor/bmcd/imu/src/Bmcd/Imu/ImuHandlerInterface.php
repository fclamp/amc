<?php

/**
 * IMu Handler interface.
 *
 * @author BMCD AP
 * @version 0.1
 */
namespace Bmcd\Imu;

interface ImuHandlerInterface
{
	public function __construct($session);
	public function getCreate();
	public function setCreate($create);
	public function getDestroy();
	public function setDestroy($destroy);
	public function getID();
	public function setID($id);
	public function getLanguage();
	public function setLanguage($language);
	public function getName();
	public function setName($name);
	public function getSession();
	public function __get($name);
	public function __set($name, $value);
	public function call($method, $params = null);
	public function request($request);
}
