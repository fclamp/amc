<?php
/*******************************************************
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 *******************************************************/


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');
require_once ($LIB_DIR . 'configuredquery.php');
require_once ($LIB_DIR . 'border.php');
require_once ($LIB_DIR . 'common.php');
require_once ($LIB_DIR . 'Security.php');


class
ModuleBaseDetailedQueryForm extends BaseDetailedQueryForm 
{
	var $showLevels = array ();
	var $Fields = array ();
	var $showSummary;
	var $phpSelf;

	function display()
	{
		// print some JavaScript to assist with lookup list popup
		print "<script langauge=\"JavaScript\">\n";
		print "<!--\n";
		print "function openLookupList(formID, fieldID, LutName, restriction, term)\n";
		print "{\n";
		print "	url = '" . $GLOBALS['LOOKUPLIST_URL'] . "';";
		print "	url = url + '?formid=' + formID + '&fieldid=' + fieldID + '&lname=' + LutName + '&restriction=' + restriction + '&ll=' + term;\n";
		print "	url = url + '&bodycolor=" . urlencode($this->BodyColor) . "';\n";
		print "	url = url + '&bodytextcolor=" . urlencode($this->BodyColor) . "';\n";
		print "	url = url + '&lang=" . $this->LanguageData . "';\n";
		print '	popupWindow = window.open(url, "popupWindow", "height=350,width=250,location=no,status=no,toolbar=no,scrollbars=yes"); ';
		print "	popupWindow.focus();\n";
		print "}\n";
		print "//-->\n";
		print "</script>\n";

		$decorator = new HtmlBoxAndTitle;
		$decorator->BorderColor = $this->BorderColor;
		$decorator->BodyColor = $this->BodyColor;
		$decorator->TitleTextColor = $this->TitleTextColor;
		$decorator->FontFace = $this->FontFace;
		$decorator->Width = $this->Width;
		$decorator->Title = $this->Title;
		// Dump the HTML
		$decorator->Open();
?>

<form method="GET" name="dtlquery" action="<?php print $this->ResultsListPage?>">
	<input type="hidden" name="QueryName" value="DetailedQuery" />
	<input type="hidden" name="StartAt" value="1" />
	<input type="hidden" name="QueryPage" value="<?php print $this->phpSelf ?>" />
	<input type="hidden" name="Restriction" value="<?php print $this->Restriction?>" />
	<input type="hidden" name="lang" value="<?php print $this->LanguageData?>" />		
	<table width="100%" border="0" cellspacing="2" cellpadding="2">
<?php
		if($this->SecondSearch)
		{
			//add a second search and clear button to the top of the page
			print "<br />\n";
			print "&nbsp;&nbsp;<input class=\"WebInput\" type=\"submit\" name=\"Search\" value=\"Search\" />\n";
			print "<input type=\"reset\" name=\"Rearch\" value=\"Clear\" />\n";
			print "<font color=\"{$this->BodyTextColor}\" size=\"$this->FontSize\" face=\"$this->FontFace\">\n";
			print "&nbsp;&nbsp;<input class=\"WebInput\" type=\"checkbox\" name=\"ImagesOnly\" value=\"true\" />\n";
			print $this->_STRINGS['ONLY_WITH_IMAGES'];
			print "</font>\n";
			print "<br /><br />\n";
		}
		
		foreach ($this->Fields as $fld)
		{
			// Convert string fields to QueryField objects
			if (is_string($fld))
			{
				$fieldObject = new QueryField;
				$fieldObject->ColName = $fld;
				$fld = $fieldObject;
			}

			// Security
			if (strtolower($fld->ValidUsers) != 'all')
			{
				if (! $this->SecurityTester->UserIsValid($fld->ValidUsers))
					continue;
			}


			if (strtolower(get_class($fld)) == 'queryfield')
			{
				switch (strtolower($fld->ColType))
				{
				    case 'date':
					if ($fld->IsLower)
						$htmlFieldName = 'col_date_lower_' . $fld->ColName;
					elseif ($fld->IsUpper)
						$htmlFieldName = 'col_date_upper_' . $fld->ColName;
					else
						$htmlFieldName = 'col_date_' . $fld->ColName;
					break;
				    case 'integer':
					if ($fld->IsLower)
						$htmlFieldName = 'col_int_lower_' . $fld->ColName;
					elseif ($fld->IsUpper)
						$htmlFieldName = 'col_int_upper_' . $fld->ColName;
					else
						$htmlFieldName = 'col_int_' . $fld->ColName;
					break;
				    case 'string':
					$htmlFieldName = 'col_str_' . $fld->ColName;
					break;
				    case 'text':
					$htmlFieldName = 'col_' . $fld->ColName;
					break;
				}
			}
			else
				WebDie('Invalid Field Type - Expected QueryField');

	  		print "<tr>\n";
	    		print "<td valign=\"top\" nowrap=\"nowrap\" width=\"25%\">\n";
			print "<font color=\"" . $this->BodyTextColor .'"';
			print " size=" . $this->FontSize . ' face="' . $this->FontFace . "\">\n";
			if (isset($this->_STRINGS[$fld->ColName]))
				$label = $this->_STRINGS[$fld->ColName];
			else
				$label = $fld->ColName;
			print "<b>&nbsp;&nbsp;" .  $label . "</b></font>\n";
	    		print "</td>\n";
	    		print "<td valign=\"top\" nowrap=\"nowrap\" width=\"20%\">\n";
			if (isset($this->DropDownLists[$fld->ColName]))
			{
				$this->generateDropDown($fld->ColName, $htmlFieldName);
			}
			elseif (isset($this->LookupLists[$fld->ColName]))
			{
				$colName = $this->LookupLists[$fld->ColName];
				$restriction = $this->getLookupRestriction($colName);
				$restriction = urlencode($restriction);
				$lookupName = urlencode($colName);

				// print picklist/lookuplist image and link
				print '&nbsp;&nbsp;<input class="WebInput" type="text" value="" name="';
				print $htmlFieldName . "\" size=\"20\" />";
				print '&nbsp;';
				print '<a href="javascript:void(0)" onclick="openLookupList(\'dtlquery\', ';
				print "'$htmlFieldName', '$lookupName', '$restriction', dtlquery['$htmlFieldName'].value)\">";
				$imgPath = $GLOBALS['WEB_PICKLIST_GRAPHIC'];
				print "<img src=\"$imgPath\" border=\"0\" align=\"top\" />";
				print '</a>';
			}
			else
			{
				print '&nbsp;&nbsp;<input class="WebInput" type="text" value="" name="';
				print $htmlFieldName . "\" size=\"20\" />\n";
			}
	    		print "</td>\n";
	    		print "<td valign=\"top\" width=\"55%\">\n";
			print "<font color=\"" . $this->BodyTextColor . "\" size=\"" . $this->FontSize . '" face="' . $this->FontFace . "\">\n";
			print "" . $this->Hints[$fld->ColName] . "</font>\n";
	    		print "</td>\n";
	  		print "</tr>\n";
		}
?>
		<tr>
		<td valign="top" nowrap="nowrap">
			<font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>">
			<b>&nbsp;&nbsp;<?php print $this->_STRINGS['NUMBER_OF_RECORDS']?></b></font>
		</td>
		<td valign="top" nowrap="nowrap">
			&nbsp;
                        <select name="LimitPerPage">
                          <option value="50" selected="selected">50 <?php print $this->_STRINGS['RESULTS']?></option>
                          <option value="100" >100 <?php print $this->_STRINGS['RESULTS']?></option>
                          <option value="250" >250 <?php print $this->_STRINGS['RESULTS']?></option>
                          <option value="500" >500 <?php print $this->_STRINGS['RESULTS']?></option>
                          <option value="1000" >1000 <?php print $this->_STRINGS['RESULTS']?></option>
                        </select>&nbsp;&nbsp;
		</td>
		<td valign="top">
		</td>
	</table>
	<p>
	&nbsp;&nbsp;<input class="WebInput" type="submit" name="Search" value="Search" />
	<input type="reset" name="Rearch" value="Clear" />
	<font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>">
	&nbsp;&nbsp;<input class="WebInput" type="checkbox" name="ImagesOnly" value="true" />
	<?php print $this->_STRINGS['ONLY_WITH_IMAGES']?>
	</font>
	</p>		
</form>

<?php
		$decorator->Close();
	} //end display()

}

?>
