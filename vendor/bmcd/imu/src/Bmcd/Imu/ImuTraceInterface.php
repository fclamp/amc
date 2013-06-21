<?php

/**
 * IMu Trace Interface.
 *
 * @author BMCD AP
 * @version 0.1
 */
namespace Bmcd\Imu;

interface ImuTraceInterface
{
	public static function getFile();
	public static function setFile($file);
	public static function getLevel();
	public static function setLevel($level);
	public static function getPrefix();
	public static function setPrefix($prefix);
	public static function write($level, $format);
	public static function writeArgs($level, $format, $args);

}
