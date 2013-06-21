<?php

/**
 * IMu Document interface.
 *
 * @author BMCD AP
 * @version 0.1
 */
namespace Bmcd\Imu;

interface ImuDocumentInterface
{
	public function __construct($encoding);
	public function endDocument();
	public function endElement();
	public function getTagOption($tag, $name, $default);
	public function hasTagOption($tag, $name);
	public function setTagOption($tag, $name, $value);
	public function startElement($name);
	public function writeElement($name, $value);
}
