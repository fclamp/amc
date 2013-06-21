<?php

/**
 * IMu Session Interface.
 *
 * @author BMCD AP
 * @version 0.1
 */
namespace Bmcd\Imu;

interface ImuSessionInterface
{
	public static function getDefaultHost();
	public static function setDefaultHost($host);
	public static function getDefaultPort();
	public static function setDefaultPort($port);
	public function __construct($host, $port);
	public function getClose();
	public function setClose($close);
	public function getContext();
	public function setContext($context);
	public function getHost();
	public function setHost($host);
	public function getPort();
	public function setPort($port);
	public function getSuspend();
	public function setSuspend($suspend);
	public function __get($name);
	public function __set($name, $value);
	public function connect();
	public function disconnect();
	public function login($login, $password, $spawn);
	public function request($request);
}
