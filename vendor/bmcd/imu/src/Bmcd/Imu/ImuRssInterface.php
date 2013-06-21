<?php

/**
 * IMu RSS Interface.
 *
 * @author BMCD AP
 * @version 0.1
 */
namespace Bmcd\Imu;

interface ImuRssInterface
{
	public function __construct();
	public function addItem();
	public function createXml();
}
