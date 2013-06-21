<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'configuredquery.php');
require_once ($LIB_DIR . 'border.php');
require_once ($LIB_DIR . 'common.php');
require_once ($LIB_DIR . 'Security.php');
require_once ($LIB_DIR . 'BaseQueryForm.php');


class
QueryField
{
	var $ColName = '';
	var $ColType = 'text';	// text, date, time, other
	var $ValidUsers = 'all';
	var $IsLower = 0;
	var $IsUpper = 0;
}

class
BaseDetailedQueryForm extends BaseQueryForm
{
	var $Restriction = '';
	var $Title = '';
	var $Width = '650';
	var $FontFace = '';
	var $FontSize = '';
	var $TitleTextColor = '#FFFFFF';
	var $BodyTextColor = '#000000';
	var $BorderColor = '#000000';
	var $BodyColor = '';
	var $SecondSearch = 0;
	var $MaxDropDownLength = 35;
	var $ImagesOnlyOption = 1;
	var $LimitPerPageOptions = array(
		10 => "10 results",
		20 => "20 results",
		30 => "30 results",
		50 => "50 results",
		100 => "100 results");
	var $LimitPerPageSelected = 20;

	//Override in subclass
	var $Fields	= array();	// eg. array('TitMainTitle', 'TitAccessionNo');
	var $Additional	= array();	// eg. array('NotNotes');
	var $Hints	= array();	// eg. ('TitMainTitle' => 'eg. The Cat', 'TitAccessionNo' => 'internal use')
	var $DropDownLists = array();	// eg. ('PhyMedium' => 'Canvis|Timber|Clay')
	var $LookupLists = array();	// eg. ('CreCountry' => 'eluts:Country[1]')
	var $LookupRestrictions = array();	// eg. ('Country' => "(value004='Mammals')")

	var $SecurityTester;

	function
	BaseDetailedQueryForm()
	{
		$this->SecurityTester = new SecurityTester;
		$this->BaseWebObject();
	}

	function
	Show ()
	{
		// Source the strings file
		$this->sourceStrings();
		
		if ($this->Title == '')
		{
			$this->Title = $this->_STRINGS['DEFAULT_QUERY_TITLE'];
		}

		if (count($this->Additional) > 0)
			$this->Fields = array_merge($this->Fields, $this->Additional);
		
		$this->display();
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

			$qry->Texql = "distinct(SELECT $value FROM eluts WHERE Name='$tablename' and Levels=$level and $restriction) {1 to 500}"; 



			$recs = $qry->Fetch();
			print "		   <option></option>\n";
			$hasEntry = 0;
			foreach ($recs as $rec)
			{
				$option = trim($rec->{$value});
				if (strlen($option) > $this->MaxDropDownLength)
					$option = $this->trimOption($option, $this->MaxDropDownLength);
				if ($option != '')
				{
					print "		   <option>\"$option\"</option>\n";
					$hasEntry = 1;
				}
			}
			if (! $hasEntry)
				print "		   <option>--- None Available ---</option>\n";
		}
		else
		{
			foreach (split('\|', $this->DropDownLists[$fld]) as $option)
			{
				print "		   <option>$option</option>\n";
			}
		}

		print "</select>\n";

		// To see this DEBUG message need to open up page source
		if ($GLOBALS['DEBUG'])
		{
			print("<br>" . $qry->Texql);

		}
	}

	function
	trimOption($option, $maxlength)
	{
		/*  We need to trim the option to maximum length by
		**  truncating and adding an ellipsis.
		*/
		$option = substr($option, 0, $maxlength - 3);
		$option = preg_replace('/\w*$/', '...', $option, 1);
		return($option);
	}

	function
	getLookupRestriction($colName)
	{
		if (isset($this->LookupRestrictions[$colName]))
			return($this->LookupRestrictions[$colName]);
		if (preg_match('/(.*?)\[\d*\]$/', $colName, $matches))
		    if (isset($this->LookupRestrictions[$matches[1]]))
			    return($this->LookupRestrictions[$matches[1]]);
		return("");
	}

	function
	display()
	{
		global $ALL_REQUEST;

		// print some JavaScript to assist with lookup list popup
		print "<script langauge=\"JavaScript\">\n";
		print "<!--\n";
		print "function openLookupList(formID, fieldID, LutName, restriction, term)\n";
		print "{\n";
		print "	url = '" . $GLOBALS['LOOKUPLIST_URL'] . "';";
		print "	url = url + '?formid=' + formID + '&fieldid=' + fieldID + '&lname=' + LutName + '&restriction=' + restriction + '&ll=' + term;\n";
		print "	url = url + '&lang=" . $this->LanguageData . "';\n";
    		print "	url = url + '&bodycolor=" . urlencode($this->BodyColor) . "';\n";
    		print "	url = url + '&bodytextcolor=" . urlencode($this->BodyTextColor) . "';\n";
		print '	popupWindow = window.open(url, "popupWindow", "height=500,width=250,location=no,status=no,toolbar=no,scrollbars=yes"); ';
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
		$self = isset($GLOBALS['PHP_SELF']) 
				? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];
?>

<form method="<?php print $this->SubmitMethod; ?>" name="dtlquery" action="<?php print $this->ResultsListPage?>">
	<input type="hidden" name="QueryName" value="DetailedQuery" />
	<input type="hidden" name="StartAt" value="1" />
	<input type="hidden" name="QueryPage" value="<?php print $self ?>" />
	<input type="hidden" name="Restriction" value="<?php print htmlentities($this->Restriction) ?>" />
	<?php $this->printAdditionalTransferVariables();?>
	<table width="100%" border="0" cellspacing="2" cellpadding="2">
<?php
		// FIXME - This is invalid HTML - can't have content within a table element.
		if ($this->SecondSearch)
		{
			//add a second search and clear button to the top of the page
			print "<br />\n";
			print "&nbsp;&nbsp;<input class=\"WebButton\" type=\"submit\" name=\"Search\" value=\"Search\" />\n";
			print "<input class=\"WebButton\" type=\"reset\" name=\"Rearch\" value=\"Clear\" />\n";
			if ($this->ImagesOnlyOption == 1)
			{
				print "<font color=\"{$this->BodyTextColor}\" size=\"$this->FontSize\" face=\"$this->FontFace\">\n";
				print "&nbsp;&nbsp;<input class=\"WebInput\" type=\"checkbox\" name=\"ImagesOnly\" value=\"true\" />\n";
				print $this->_STRINGS['ONLY_WITH_IMAGES'];
				print "</font>\n";
			}
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
				    case 'float':
					if ($fld->IsLower)
						$htmlFieldName = 'col_float_lower_' . $fld->ColName;
					elseif ($fld->IsUpper)
						$htmlFieldName = 'col_float_upper_' . $fld->ColName;
					else
						$htmlFieldName = 'col_float_' . $fld->ColName;
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
				    case 'longitude':
					$htmlFieldName = 'col_long_' . $fld->ColName;
					break;
				    case 'latitude':
					$htmlFieldName = 'col_lat_' . $fld->ColName;
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
			$promptColName = $fld->ColName;
			if ($fld->IsLower)
				$promptColName .= "Lower";
			elseif ($fld->IsUpper)
				$promptColName .= "Upper";
			if (isset($this->_STRINGS[$promptColName]))
				$label = $this->_STRINGS[$promptColName];
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
			$hintColName = $fld->ColName;
			if ($fld->IsLower)
				$hintColName .= "Lower";
			elseif ($fld->IsUpper)
				$hintColName .= "Upper";
			print "" . $this->Hints[$hintColName] . "</font>\n";
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
			&nbsp;&nbsp;<select class="WebLimitPerPage" name="LimitPerPage">
			<?php
			foreach($this->LimitPerPageOptions as $key => $val)
			{
			?>
				<option value="<?php print $key; ?>" <?php if ($key == $this->LimitPerPageSelected) {?>selected="selected"<?php };?>><?php print htmlentities($val); ?></option>

			<?php
			}
			?>
			</select>
		</td>
		<td valign="top">
		</td>
	</table>
	<p>
	&nbsp;&nbsp;<input class="WebButton" type="submit" name="Search" value="Search" />
	<input class="WebButton" type="reset" name="Rearch" value="Clear" />
	<?php
	if ($this->ImagesOnlyOption == 1)
	{
	?>
		<font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>">
		&nbsp;&nbsp;<input class="WebCheckBox" type="checkbox" name="ImagesOnly" value="true" />
		<?php print $this->_STRINGS['ONLY_WITH_IMAGES']?>
		</font>
	<?php
	}
	?>
	</p>
</form>

<?php
		$decorator->Close();
	} //end display()



} // End BaseDetailedQueryForm class

?>
