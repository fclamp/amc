<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');
require_once ('DefaultPaths.php');

class
QagBasicQueryForm extends BaseBasicQueryForm
{
	//var $Restriction = "(ArtStatus contains '!u' AND ArtStatus contains '!z') OR (ArtStatus is NULL)";
	var $Restriction = "(ArtStatus contains 'a' OR ArtStatus contains 'b' OR ArtStatus contains 'c' OR ArtStatus contains 'd' OR ArtStatus contains 's') OR (ArtStatus is NULL)";

	var $Options = array(		'Creator/Culture' => 'ArtArtistLocal|ArtCulturalIdentityLocal',
					'Title' => 'SumTitle',
					'Creator/CultureORTitle' => 'ArtArtistLocal|ArtCulturalIdentityLocal|SumTitle',
					'Anywhere' => 'ArtArtistLocal|ArtCulturalIdentityLocal|SumTitle|RefAdditionalInformation',
				);

	function
	display()
	{
		$decorator = new HtmlBoxAndTitle;
		$decorator->BorderColor = $this->BorderColor;
		$decorator->BodyColor = $this->BodyColor;
		$decorator->TitleTextColor = $this->TitleTextColor;
		$decorator->FontFace = $this->FontFace;
		//$decorator->Width = $this->Width;
		$decorator->Title = '';
		$decorator->Border = $this->Border;
		// Dump the HTML
		$decorator->Open();
?>
<form method="post" action="<?php print $this->ResultsListPage ?>">
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
		/*$self = isset($GLOBALS['PHP_SELF']) 
				? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];*/
		$self = isset($GLOBALS['REQUEST_URI']) 
				? $GLOBALS['REQUEST_URI'] : $_SERVER['REQUEST_URI'];
?>
		&nbsp;&nbsp;&nbsp;
	</td></tr>
	<tr align="center"><td valign="top">
		<b><?php PPrint($this->_STRINGS['FIND'], $this->FontFace, $this->FontSize, $this->BodyTextColor) ?></b>
		<input type="hidden" name="QueryName" value="BasicQuery" />
		<input type="hidden" name="QueryPage" value="<?php print $self ?>" />
		<input type="hidden" name="Restriction" value="<?php print $this->Restriction?>" />
		<input type="hidden" name="StartAt" value="1" />
<?php
		$this->printAdditionalTransferVariables();
		// print OptionsFields as hidden so they are passed through
		foreach($this->Options as $option => $fields)
		{
			print "		<input type=\"hidden\" name=\"$option\" value=\"$fields\" />\n";
		}
?>
		<input class="WebInput" type="text" name="QueryTerms" />
<?php
		if (count($this->Options) > 1)
		{
			print "<select name=\"QueryOption\">";
			// Show Options in dropdown
			// The "options" should not contain spaces.  If a space or "special" label is
			// required, define an entry in the strings file with an ID the same name as
			// the option.
			$spaceerror = 0;
			foreach($this->Options as $option => $val)
			{
				if (preg_match("/\s/", $option))
				{
					$spaceerror++;
				}
				$optDisplay = $this->_STRINGS['QUERY_OPTION_' . strtoupper($option)];
				if ($optDisplay == '')
				{
					$optDisplay = $this->_STRINGS[$option];
				}
				if ($optDisplay == '')
				{
					$optDisplay = $option;
				}
				
				print "			<option value=\"$option\">$optDisplay</option>\n";
			}
			print "</select>";
		}
		else
		{
			$option = array_keys($this->Options);
			$option = $option[0];
			print "<input type=\"hidden\" name=\"QueryOption\" value=\"$option\" />";
		}
?>&nbsp;&nbsp;&nbsp;
		<input class="WebInput" type="submit" name="Submit" value="<?php print $this->_STRINGS['SEARCH'] ?>" />
		<?php
		if ($this->ImagesOnlyOption)
		{
			print '<br /><input class="WebInput" type="checkbox" name="ImagesOnly" value="true" />';
			print $this->_STRINGS['ONLY_WITH_IMAGES'];
		}
		?>
	</td></tr>
	</table>
</form>
<?php
		if ($spaceerror)
		{
			WebDie("Space found in objects\client\QueryForms.php Options->array.  If a space is required to show up in the pull down list, please use the strings (english.php) to accomplish this.","");
		}
		$decorator->Close();
	}  

}  // end QagBasicQueryForm class

class
QagAdvancedQueryForm extends BaseAdvancedQueryForm
{
	//var $Restriction = "(ArtStatus contains '!u' AND ArtStatus contains '!z') OR (ArtStatus is NULL)";
	var $Restriction = "(ArtStatus contains 'a' OR ArtStatus contains 'b' OR ArtStatus contains 'c' OR ArtStatus contains 'd' OR ArtStatus contains 's') OR (ArtStatus is NULL)";

	var $Options = array(		'Creator/Culture' => 'ArtArtistLocal|ArtCulturalIdentityLocal',
					'Title' => 'SumTitle',
					'Creator/CultureORTitle' => 'ArtArtistLocal|ArtCulturalIdentityLocal|SumTitle',
					'Anywhere' => 'ArtArtistLocal|ArtCulturalIdentityLocal|SumTitle|RefAdditionalInformation',
				);

	function
	Show ()
	{
		$this->sourceStrings();
		if ($this->Title == '')
		{
			$this->Title = $this->_STRINGS['DEFAULT_QUERY_TITLE'];
		}
		$this->display();
	}

	function
	display()
	{

		$decorator = new HtmlBoxAndTitle;
		$decorator->BorderColor = $this->BorderColor;
		$decorator->BodyColor = $this->BodyColor;
		$decorator->TitleTextColor = $this->TitleTextColor;
		$decorator->FontFace = $this->FontFace;
		$decorator->Width = $this->Width;
		$decorator->Title = '';
		$decorator->Border = 0;
		// Dump the HTML
		$decorator->Open();
		$self = isset($GLOBALS['PHP_SELF']) 
				? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];

?>
<form method="post" action="<?php print $this->ResultsListPage?>">
	<input type="hidden" name="QueryName" value="AdvancedQuery" />
	<?php
	if ($this->RankCheckbox)
	{
		print '<input type="hidden" name="RankOn" value="AdmWebMetadata" />';
	}
	?>
	<input type="hidden" name="StartAt" value="1" />
	<input type="hidden" name="QueryPage" value="<?php print $self ?>" />
	<input type="hidden" name="Restriction" value="<?php print $this->Restriction?>" />
<?php
		$this->printAdditionalTransferVariables();
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
		// Show Options in dropdown
		// The "options" should not contain spaces.  If a space or "special" label is
		// required, define an entry in the strings file with an ID the same name as
		// the option.
		$spaceerror = 0;
		foreach($this->Options as $option => $val)
		{
			if (preg_match("/\s/", $option))
			{
				$spaceerror++;
			}
			$optDisplay = $this->_STRINGS['QUERY_OPTION_' . strtoupper($option)];
			if ($optDisplay == '')
			{
				$optDisplay = $this->_STRINGS[$option];
			}
			if ($optDisplay == '')
			{
				$optDisplay = $option;
			}
			
			print "			<option value=\"$option\">$optDisplay</option>\n";
		}
		/*
		foreach($this->Options as $option => $val)
		{
			$optDisplay = $this->_STRINGS['QUERY_OPTION_' . strtoupper($option)];
			if ($optDisplay == '')
				$optDisplay = $option;
			print "			<option value=\"$option\">$optDisplay</option>\n";
		}
		*/
?>
                  </select>
                  </font></td>
                    </tr>
		    <tr>
		      <td align="right"> <font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>">Record per page</font>
		      </td>
                      <td valign="top" rowspan="6"><p>
                        <select name="LimitPerPage">
                          <option value="10" >10 <?php print $this->_STRINGS['RESULTS']?></option>
                          <option value="20" selected="selected">20 <?php print $this->_STRINGS['RESULTS']?></option>
                          <option value="30" >30 <?php print $this->_STRINGS['RESULTS']?></option>
                          <option value="50" >50 <?php print $this->_STRINGS['RESULTS']?></option>
                          <option value="100" >100 <?php print $this->_STRINGS['RESULTS']?></option>
                        </select>&nbsp;&nbsp;
		      </td>
                    </tr>
                  </table>
	      <tr>
	        <td></td>
	        <td>
		  <br />
		  <input type="submit" name="Search" value="Search" />
		  <input type="reset" name="Rearch" value="Clear" />
		  <font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>">
		  <input class="WebInput" type="checkbox" name="ImagesOnly" value="true" />
		  <?php print $this->_STRINGS['ONLY_WITH_IMAGES']?>
		  <?php if ($this->RankCheckbox)
		  {?>
		  <br />
		  <input class="WebInput" type="checkbox" name="Rank" value="true" />
		  <?php print $this->_STRINGS['RELEVANCE_RANK'];
		  }?>
		  </font>
                </td>
              </tr>
            </table>
	</form>
<?php
		if ($spaceerror)
		{
			WebDie("Space found in objects\client\QueryForms.php Options->array.  If a space is required to show up in the pull down list, please use the strings (english.php) to accomplish this.","");
		}

		$decorator->Close();
	}

}  // end QagAdvancedQueryForm class
	
class
QagDetailedQueryForm extends BaseDetailedQueryForm
{
	function
	QagDetailedQueryForm()
	{
		$earliest = new QueryField;
                $earliest->ColName = 'SumDateEarliest';
                $earliest->ColType = 'date';
		$earliest->IsLower = 1;

		$latest = new QueryField;
                $latest->ColName = 'SumDateLatest';
                $latest->ColType = 'date';
		$latest->IsUpper = 1;
	
		$this->Fields = array(
			'ArtSurnameLocal',
			'ArtGivenNameLocal',
			'ArtCulturalIdentityLocal',
			'SumTitle',
			'SumDate',
			$earliest,
			$latest,
			'SumAccessionNumber',
			'ArtCreditLine',
			'SumDepartment',
			'SumSearchCat',
			'ArtMediaCategory',
			'SumMedium',
			'SumSupport',
			'ArtPrincipalCountryLocal',
			'ArtStateLocal',
			'ArtGenderLocal',
			'ArtBirthDateLocal',
			'ArtDeathDateLocal',
			'RefReproductions|RefReferences',
			'RefExhibitionHistory',
		);

		$this->Hints = array(	
			'SumDepartment'	=> '[ AA = Australian Art to 1970',
			'SumSearchCat' => 'ASA = Asian Art to 1970', 
			'ArtMediaCategory' => 'CAA = Contemporary Australian Art',
			'SumMedium' => 'CASA = Contemporary Asian Art',
			'SumSupport' => 'IA = International Art ',
			'ArtPrincipalCountryLocal' => 'IAA = Indigenous Australian Art',
			'ArtStateLocal' => 'PAC = Pacific Art ]',
		);

		$this->DropDownLists = array(	
			'ArtGenderLocal' => 'eluts:Parent Sex',
		);
		#$this->LutQryLimit = 20000;

		$this->LookupLists = array (
			'ArtSurnameLocal' => 'Surname',
			'SumDepartment' => 'Department',
			'SumSearchCat' => 'Search Cat.',
			'ArtMediaCategory' => 'Media Category',
			'ArtPrincipalCountryLocal' => 'Nationality',
		);
	 	$this->Restriction = "(ArtStatus contains 'a' OR ArtStatus contains 'b' OR ArtStatus contains 'c' OR ArtStatus contains 'd' OR ArtStatus contains 's') OR (ArtStatus is NULL)";
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
		$decorator->Title = '';
		$decorator->Border = 0;
		// Dump the HTML
		$decorator->Open();
		$self = isset($GLOBALS['PHP_SELF']) 
				? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];
?>

<form method="<?php print $this->SubmitMethod; ?>" name="dtlquery" action="<?php print $this->ResultsListPage?>">
	<input type="hidden" name="QueryName" value="DetailedQuery" />
	<input type="hidden" name="StartAt" value="1" />
	<input type="hidden" name="QueryPage" value="<?php print $self ?>" />
	<input type="hidden" name="Restriction" value="<?php print $this->Restriction?>" />
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
	    		print "<td align=\"right\" valign=\"top\" nowrap=\"nowrap\" width=\"25%\">\n";
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
	    		print "<td valign=\"top\" width=\"55%\" nowrap=\"nowrap\">\n";
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
		<td align="right" valign="top" nowrap="nowrap">
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
		</tr>
		    <tr>
		      <td align="right" valign="top" nowrap="nowrap"> 
		      <font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>">
		      <b>&nbsp;&nbsp;Sort results by</b></font>
		      </td>
                      <td valign="top" nowrap="nowrap">&nbsp;
                        <select name="SortBy">
                          <option value="" ></option>
                          <option value="Title" >Title</option>
                          <option value="Date" >Date</option>
                          <option value="Department" >Department</option>
                          <option value="MediaCategory" >Media Category</option>
                          <option value="PrincipalCountry" >Principal Country</option>
                          <option value="State" >State</option>
                          <option value="MF" >M/F</option>
                          <option value="AccNo" >Acc. no.</option>
                        </select>&nbsp;&nbsp;
		      </td>
		</td>
		<td valign="top">
		      <font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>">
		      Default order is: Surname, Given name/s, Title</font>
                    </tr>
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
	}

} // End QagDetailedQueryForm class
?>
