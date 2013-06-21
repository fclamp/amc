<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/common/LanguageSelector2.php');


class
CmccLanguageSelector extends LanguageSelector2
{
        function
        CmccLanguageSelector()
        {
              $this->PageAssociations = array (
                        "English" 	=> "Query.php",
                        "French" 	=> "QueryFrench.php",
			"Yankee"    	=> "QueryAmerican.php",
                        "Spanish"   	=> "QuerySpanish.php",
                        "German"    	=> "QueryGerman.php",
                         );
            // call base constructor
            $this->LanguageSelector2();
        }
}

?>
