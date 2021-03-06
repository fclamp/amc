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

/*********************************************************
** The TaxonomyBaseBasicQueryForm is a class
** extending BaseBasicQueryForm
**
** Used as base base class for taxonomy query forms
**
** Overide and provide as per BaseBasicQueryForm Class PLUS
**		->showLevels = array();
**
** showLevels are list of taxonomic levels to display - passed as cgi 
** params to List Mechanism
**
** Makes only a minor mod to 'function display' - passes levels as hidden
** params in html form.  Perhaps BaseBasicQueryForm could be modified to have
** a 'hidden' method that could be used to do same thing more generically and
** would avoid having this in between class... JK
************************************************************/
class
TaxonomyBaseBasicQueryForm extends BaseBasicQueryForm
{
	var $showLevels = array ('ClaScientificName', 'ClaPhylum','ClaClass','ClaOrder','ClaFamily','ClaGenus','ClaSpecies');
	var $showSummary;

	function display()
	{
		$phpSelf = $GLOBALS['PHP_SELF'];

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
<form method="GET" action="<?php print $this->ResultsListPage ?>">
	<input type="hidden" name="QueryName" value="BasicQuery" />
	<input type="hidden" name="QueryPage" value="<?php print $phpSelf ?>" />
	<input type="hidden" name="Restriction" value="<?php print $this->Restriction?>" />
	<input type="hidden" name="StartAt" value="1" />
	<input type="hidden" name="lang" value="<?php print $this->LanguageData?>" />		
	<table width="100%" border="0" cellpadding="0" cellspacing="4">
	<tr align="right"><td valign="top">
<?php
		// Display the help link if required
		if ($this->HelpPage != '')
		{
			$helplink = new WebHelpLink;
			$helplink->HelpPage = $this->HelpPage;
			$helplink->FontFace = $this->FontFace;
			$helplink->FontSize = $this->FontSize;
			$helplink->Show();
		}
?>
		&nbsp;&nbsp;&nbsp;
	</td></tr>
	<tr><td valign="top" nowrap='1'>
<?php
		// print OptionsFields as hidden so they are passed through
		foreach($this->Options as $option => $fields)
		{
			print "		<input type=\"hidden\" name=\"$option\" value=\"$fields\" />\n";
		}
?>
		      <b><?php PPrint($this->_STRINGS['FIND'], $this->FontFace, $this->FontSize, $this->BodyTextColor) ?></b>
		      <input class="WebInput" type="text" name="QueryTerms" />
<?php
		if (count($this->Options) > 1)
		{
			print "<select name=\"QueryOption\">";
			// Show Options in dropdown
			foreach($this->Options as $option => $val)
			{
				$optDisplay = $this->_STRINGS['QUERY_OPTION_' . strtoupper($option)];
				if ($optDisplay == '')
					$optDisplay = $option;

				print "			<option value=\"$option\">$optDisplay</option>\n";
			}
			print "</select>&nbsp;";
                        print "<select name='LimitPerPage'>
                          <option value='50' selected='selected'>50 ".$this->_STRINGS['RESULTS']."</option>
                          <option value='100' >100 ".$this->_STRINGS['RESULTS']."</option>
                          <option value='250' >250 ".$this->_STRINGS['RESULTS']."</option>
                          <option value='500' >500 ".$this->_STRINGS['RESULTS']."</option>
                          <option value='1000' >1000 ".$this->_STRINGS['RESULTS']."</option>
                        </select>\n";
		}
		else
		{
			$option = array_keys($this->Options);
			$option = $option[0];
			print "<input type=\"hidden\" name=\"QueryOption\" value=\"$option\" />";
		}

		print " <input class='WebInput' type='submit' name='Submit' value='".$this->_STRINGS['SEARCH']."' />\n";

		foreach($this->showLevels as $showLevel)
		{
			print "	<input type=\"hidden\" name=\"$showLevel\" value=\"show\" />\n";
		}
		print "<input type='hidden' name='showSummary' value='$this->showSummary' />\n";
?>
	</td></tr>
	<tr>
		<td valign='top'>&nbsp;</td>
	<tr/>
	</table>
</form>
<?php
		$decorator->Close();
	}  

}  // end TaxonomyBaseBasicQueryForm class


/*********************************************************
** The TaxonomyBaseAdvancedQueryForm is a class
** extending BaseAdvancedQueryForm
**
** Used as base base class for taxonomy query forms
**
** Overide and provide as per BaseAdvancedQueryForm Class PLUS
**		->showLevels = array();
**
** showLevels are list of taxonomic levels to display - passed as cgi 
** params to List Mechanism
**
** Makes only a minor mod to 'function display' - passes levels as hidden
** params in html form.  Perhaps BaseAdvancedQueryForm could be modified to have
** a 'hidden' method that could be used to do same thing more generically and
** would avoid having this in between class... JK
************************************************************/
class
TaxonomyBaseAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $showLevels = array ('ClaScientificName', 'ClaPhylum','ClaClass','ClaOrder','ClaFamily','ClaGenus','ClaSpecies');
	var $showSummary;

	function display()
	{
		$phpSelf = $GLOBALS['PHP_SELF'];

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
<form method="GET" action="<?php print $this->ResultsListPage?>">
	<input type="hidden" name="QueryName" value="AdvancedQuery" />
	<input type="hidden" name="StartAt" value="1" />
	<input type="hidden" name="QueryPage" value="<?php print $phpSelf ?>" />
	<input type="hidden" name="Restriction" value="<?php print $this->Restriction?>" />
	<input type="hidden" name="lang" value="<?php print $this->LanguageData?>" />		
<?php
		// print Options as hidden so they are passed through
		foreach($this->Options as $option => $fields)
		{
			print "		<input type=\"hidden\" name=\"$option\" value=\"$fields\" />\n";
		}
?>
	<table width="100%" cellspacing="0" cellpadding="2" border="0">
              <tr>
                <td valign="top" width="15%"><font color="<?php print $this->BodyTextColor?>" face="<?php print $this->FontFace?>" size="<?php print $this->FontSize?>">
		  <br />
                  <b><?php print $this->_STRINGS['FIND_RESULTS'] ?> </b></font></td>
                <td valign="top" width="85%">
                  <table width="100%" cellpadding="2" border="0" cellspacing="0">
                    <tr>
                      <td valign="top"><font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>"><?php print $this->_STRINGS['WITH_ALL_WORDS'] ?></font></td>
                      <td valign="top">
                        <input class="WebInput" type="text" value="" name="AllWords" size="25" />
                      </td>
                      <td valign="top" rowspan="6"><p>
                        <select name="LimitPerPage">
                          <option value="50" selected="selected">50 <?php print $this->_STRINGS['RESULTS']?></option>
                          <option value="100" >100 <?php print $this->_STRINGS['RESULTS']?></option>
                          <option value="250" >250 <?php print $this->_STRINGS['RESULTS']?></option>
                          <option value="500" >500 <?php print $this->_STRINGS['RESULTS']?></option>
                          <option value="1000" >1000 <?php print $this->_STRINGS['RESULTS']?></option>
                        </select>&nbsp;&nbsp;
                        <input type="submit" name="Search" value="Search" />
                        </p>
			<font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>">
			<input class="WebInput" type="checkbox" name="ImagesOnly" value="true" />
			<?php print $this->_STRINGS['ONLY_WITH_IMAGES']?>
			</font>
		      </td>
                    </tr>
                    <tr>
                      <td valign="top" nowrap="nowrap"><font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>"><?php print $this->_STRINGS['WITH_EXACT_PHRASE'] ?></font></td>
                      <td valign="top">
                        <input class="WebInput" type="text" size="25" value="" name="Phrase" />
                      </td>
                    </tr>
                    <tr>
                      <td valign="top" nowrap="nowrap"><font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>"><?php print $this->_STRINGS['WITH_ANY_WORDS'] ?></font>
		      </td>
                      <td valign="top">
                        <input class="WebInput" type="text" size="25" value="" name="AnyWords" />
                      </td>
                    </tr>
                    <tr>
                      <td valign="top" nowrap="nowrap"><font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>">
		      <?php print $this->_STRINGS['WITHOUT_THE_WORDS'] ?>
		      </font></td>
                      <td valign="top">
                        <input class="WebInput" type="text" size="25" value="" name="WithoutWords" />
                      </td>
                    </tr>
                    <tr>
                      <td valign="top" nowrap="nowrap"><font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>">
		        <?php print $this->_STRINGS['SOUNDS_LIKE_THE_WORDS'] ?>
                        </font></td>
                      <td valign="top">
                        <input class="WebInput" type="text" size="25" value="" name="SoundsLikeWords" />
                      </td>
                    </tr>
                    <tr>
		      <td valign="top" nowrap="nowrap" width="40%"><font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>">
		      	<?php print $this->_STRINGS['RESULTS_WHERE']?></font></td>
                <td valign="top"><font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>">
                  <select name="QueryOption">
<?php
		foreach($this->Options as $option => $val)
		{
			$optDisplay = $this->_STRINGS['QUERY_OPTION_' . strtoupper($option)];
			if ($optDisplay == '')
				$optDisplay = $option;
			print "			<option value=\"$option\">$optDisplay</option>\n";
		}
		
		print "<input type='hidden' name='showSummary' value='$this->showSummary' />\n";
?>
                  </select>
                  </font></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>

<?php
		foreach($this->showLevels as $showLevel)
		{
			print "	<input type=\"hidden\" name=\"$showLevel\" value=\"show\" />\n";
		}
		print "</form>\n";

		$decorator->Close();
	}  

}

class
TaxonomyBaseDetailedQueryForm extends BaseDetailedQueryForm 
{
	var $showLevels = array ('ClaScientificName', 'ClaPhylum','ClaClass','ClaOrder','ClaFamily','ClaGenus','ClaSpecies');
	var $Fields = array ( 	'ClaPhylum',
				'ClaClass',
				'ClaOrder',
				'ClaFamily',
				'ClaGenus',
				'ClaSpecies',
				'ComName_tab',
				'ClaScientificName',);
	var $showSummary;


	function display()
	{
		$phpSelf = $GLOBALS['PHP_SELF'];

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
	<input type="hidden" name="QueryPage" value="<?php print $phpSelf ?>" />
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
<?php
	foreach($this->showLevels as $showLevel)
	{
		print "		<input type=\"hidden\" name=\"$showLevel\" value=\"show\" />\n";
	}
	print "<input type='hidden' name='showSummary' value='$this->showSummary' />\n";
?>		
</form>

<?php
		$decorator->Close();
	} //end display()

}

?>
