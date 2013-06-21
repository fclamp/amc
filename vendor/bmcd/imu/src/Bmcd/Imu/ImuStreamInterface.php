<?php

/**
 * IMu Stream Interface.
 *
 * @author BMCD AP
 * @version 0.1
 */
namespace Bmcd\Imu;

interface ImuStreamInterface
{
	public static function getBlockSize();
	public static function setBlockSize(int $size);
	public function __construct($socket);
	public function get();
	public function put($what);
}
