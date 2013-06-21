<?php

/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */

// NB this file probably best viewed with tabspace=3 if using 80
// character line terminal



/*  Factory class used to create right instance of 
 *  translator objects.
 */

/* to add new translator:
 * 1. add require_once (translator-source.php)
 * 2. add case matching it in switch statement
 */




if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/common/Mapper.php');
require_once ($WEB_ROOT . '/objects/common/DigirTranslator.php');
require_once ($WEB_ROOT . '/objects/common/EmuTranslator.php');


class TranslatorFactory
{
	function TranslatorFactory($backendType,$webRoot,$webDirName)
	{
		$this->backendType = $backendType;
		$this->webRoot = $webRoot;
		$this->webDirName = $webDirName;
	}

	function getInstance($type='')
	{
		switch ($type)
		{
			case 'Emu'  :
				$translator = new EmuTranslator($this->backendType,$this->webRoot,$this->webDirName);
				break;
			case 'Digir':
				$translator = new DigirTranslator($this->backendType,$this->webRoot,$this->webDirName);
				break;
			default:
				$translator = null;
				break;
		}
		return $translator;
	}
}

?>
