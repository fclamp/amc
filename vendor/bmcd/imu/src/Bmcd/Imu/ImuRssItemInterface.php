<?php

/**
 * IMu RSS Item Interface.
 *
 * @author BMCD AP
 * @version 0.1
 */
namespace Bmcd\Imu;

interface ImuRssItemInterface
{
	public function __construct();
	public function createXml($xml);
}
