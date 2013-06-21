<?php
/*
**  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (! isset($WEB_ROOT))
{
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
}

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR  . 'BaseQueryForms.php');

$GLOBALS['STRINGS_DIR'] = $WEB_ROOT . "/objects/" . $GLOBALS['BACKEND_TYPE'] . "/" . $GLOBALS['DEPARTMENT'] . "/strings/";

//=====================================================================================================
//=====================================================================================================
class
NmnhBasicQueryForm extends BaseBasicQueryForm
{
	function
	NmnhBasicQueryForm()
	{
		$this->BaseBasicQueryForm();
	}
}
//=====================================================================================================
//=====================================================================================================
class
NmnhAdvancedQueryForm extends BaseAdvancedQueryForm
{
	function
	NmnhAdvancedQueryForm()
	{
		$this->BaseAdvancedQueryForm();
	}
}
//=====================================================================================================
//=====================================================================================================
class
NmnhDetailedQueryForm extends BaseDetailedQueryForm
{
	function
	NmnhDetailedQueryForm()
	{
		$this->BaseDetailedQueryForm();
	}

	function
        generateDropDown($fld, $htmlFieldName)
        {
                print "&nbsp;&nbsp;<select class=\"WebSelect\" name=\"$htmlFieldName\">\n";

                $matches = array();
                if (preg_match('/^eluts:(.*?)\[?(\d*)\]?$/', $this->DropDownLists[$fld], $matches))
                {
                        $tablename = $matches[1];
                        if (isset($matches[2]) && $matches[2] != '')
                                $level = $matches[2];
                        else
                                $level = 1;
                        $value = sprintf('Value%02d0', (int) ($level - 1));
                        $qry = new ConfiguredQuery();
                        $qry->SelectedLanguage = $this->LanguageData;

                        $restriction = $this->getLookupRestriction($tablename);
                        if ($restriction == "")
                        	$restriction = "true";

                        $qry->Texql = "order(SELECT $value FROM eluts WHERE Name='$tablename' and Levels=$level and $restriction) on $value asc";

                        $recs = $qry->Fetch();
                        $dropdownlisttmp = array();
                        foreach ($recs as $rec)
                        {
                                $dropdownitem = preg_replace('/[\?\*\"]/', ' ', $rec->{$value});
                                $dropdownitem = trim($dropdownitem);
                                if ($dropdownitem == '')
                                        continue;
                                array_push($dropdownlisttmp, $dropdownitem);
                        }
                        $dropdownlist = array_unique($dropdownlisttmp);

                        print "            <option></option>\n";
                        $hasEntry = 0;
                        foreach ($dropdownlist as $option)
                        {
                                if (strlen($option) > $this->MaxDropDownLength)
                                        $option = $this->trimOption($option, $this->MaxDropDownLength);
                                if ($option != '')
                                {
                                        print "            <option>$option</option>\n";
                                        $hasEntry = 1;
                                }
                        }
                        if (! $hasEntry)
                                print "            <option>--- None Available ---</option>\n";
                }
                else
                {
                        foreach (split('\|', $this->DropDownLists[$fld]) as $option)
                        {
                                print "            <option>$option</option>\n";
                        }
                }
        }
}
//=====================================================================================================
//=====================================================================================================
?>

