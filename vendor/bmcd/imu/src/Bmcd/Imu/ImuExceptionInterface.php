<?php

/**
 * IMu Exception Interface.
 *
 * @author BMCD AP
 * @version 0.1
 */
namespace Bmcd\Imu;

interface ImuExceptionInterface
{
	public function __construct($id);
	public function getArgs();
	public function setArgs($args);
	public function setCode($code);
	public function getID();
	public function __toString();
}
