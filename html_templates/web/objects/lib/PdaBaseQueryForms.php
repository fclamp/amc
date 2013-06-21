<?php
/*
*  Copyright (c) KE Software Pty Ltd - 2001
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'texquery.php');
require_once ($LIB_DIR . 'border.php');
require_once ($LIB_DIR . 'common.php');
require_once ($LIB_DIR . 'Security.php');

/*
** The PdaBaseBasicQueryForm is an abstract base class
**	Overide and provide:
**		->Options = array();
**
**	Options appear in the dropdown.  The text that displayes in the
**	options box is either the Options itself or a string from the
**	strings file with the key:  (QUERY_OPTION_{option in upper case} )
*/
class
BaseBasicQueryForm extends BaseWebObject
{
	var $Restriction = '';
	var $Title = '';
	var $Width = '460';
	var $FontFace = '';
	var $FontSize = '';
	var $TitleTextColor = '#FFFFFF';
	var $BodyTextColor = '#000000';
	var $BorderColor = '#000000';
	var $BodyColor = '';
	var $HelpPage = '';

	// Override
	var $Options = array();	// eg. array('any' => 'AdmWebMetadata|SummaryData');

	function
	Show ()
	{
		$this->sourceStrings();
		if ($this->Title == '')
			$this->Title = $this->_STRINGS['DEFAULT_QUERY_TITLE'];
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
		$decorator->Title = $this->Title;
		// Dump the HTML
		$decorator->Open();
?>
<form method=post action="<?php print $this->PdaResultsListPage ?>">
	<table width=100% border=0 cellpadding=0 cellspacing=2>
	<tr align=right><td valign=top>
		&nbsp;
	</td></tr>
	<tr align=center><td valign=top>
		<b><?php PPrint($this->_STRINGS['FIND'], $this->FontFace, $this->FontSize, $this->BodyTextColor) ?></b>
		<input type=hidden name=QueryName value=BasicQuery>
		<input type=hidden name=QueryPage value="<?php print $GLOBALS['PHP_SELF']?>">
		<input type=hidden name=Restriction value="<?php print $this->Restriction?>">
		<input type=hidden name=StartAt value=1>
<?php
		// print OptionsFields as hidden so they are passed through
		foreach($this->Options as $option => $fields)
		{
			print "		<input type=hidden name=\"$option\" value=\"$fields\">\n";
		}
?>
		<input class=WebInput type=text name=QueryTerms>
<?php
		if (count($this->Options) > 1)
		{
			print "<select name=QueryOption>";
			// Show Options in dropdown
			foreach($this->Options as $option => $val)
			{
				$optDisplay = $this->_STRINGS['QUERY_OPTION_' . strtoupper($option)];
				if ($optDisplay == '')
					$optDisplay = $option;

				print "			<option value=\"$option\">$optDisplay</option>\n";
			}
			print "</select>";
		}
		else
		{
			$option = array_keys($this->Options);
			$option = $option[0];
			print "<input type=hidden name=QueryOption value=\"$option\">";
		}
?>&nbsp;&nbsp;&nbsp;
		<input class=WebInput type=submit name=Submit value=<?php print $this->_STRINGS['SEARCH'] ?>>
	</td></tr>
	</table>
</form>
<?php
		$decorator->Close();
	}  

}  // end BaseBasicQueryForm class


class
BaseAdvancedQueryForm extends BaseWebObject
{
	var $Restriction = '';
	var $Title = '';
	var $Width = '750';
	var $FontFace = '';
	var $FontSize = '';
	var $TitleTextColor = '#FFFFFF';
	var $BodyTextColor = '#000000';
	var $BorderColor = '#000000';
	var $BodyColor = '';
	var $ResultsListPage; 

	// Override
	var $Options = array();	// eg. array('any' => 'AdmWebMetadata|SummaryData');

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
		$decorator->Title = $this->Title;
		// Dump the HTML
		$decorator->Open();

?>
<form method=post action="<?php print $this->PdaResultsListPage?>">
	<input type=hidden name=QueryName value=AdvancedQuery>
	<input type=hidden name=StartAt value=1>
	<input type=hidden name=QueryPage value="<?php print $GLOBALS['PHP_SELF']?>">
	<input type=hidden name=Restriction value="<?php print $this->Restriction?>">
<?php
		// print Options as hidden so they are passed through
		foreach($this->Options as $option => $fields)
		{
			print "		<input type=hidden name=\"$option\" value=\"$fields\">\n";
		}
?>
	<table width=100% cellspacing=0 cellpadding=2 border=0>
              <tr>
                <td valign=top width=15%><font color=<?php print $this->BodyTextColor?> face=<?php print $this->FontFace?> size=<?php print $this->FontSize?>>
		  <br>
                  <b><?php print $this->_STRINGS['FIND_RESULTS'] ?> </b></font></td>
                <td valign=top width=85%>
                  <table width=100% cellpadding=2 border=0 cellspacing=0>
                    <tr>
                      <td valign=top><font color=<?php print $this->BodyTextColor?> size=<?php print $this->FontSize?> face=<?php print $this->FontFace?>><?php print $this->_STRINGS['WITH_ALL_WORDS'] ?></font></td>
                      <td valign=top>
                        <input class=WebInput type=text value="" name=AllWords size=25>
                      </td>
                      <td valign=top rowspan=6><p>
                        <select name=LimitPerPage>
                          <option value=10 >10 results</option>
                          <option value=20 selected>20 results</option>
                          <option value=30 >30 results</option>
                          <option value=50 >50 results</option>
                          <option value=100 >100 results</option>
                        </select>&nbsp;&nbsp;
                        <input type=submit name=Search value="Search">
                        </p>
			<font color=<?php print $this->BodyTextColor?> size=<?php print $this->FontSize?> face=<?php print $this->FontFace?>>
			<input class=WebInput type=checkbox name=ImagesOnly value=true>
			<?php print $this->_STRINGS['ONLY_WITH_IMAGES']?>
			</font>
		      </td>
                    </tr>
                    <tr>
                      <td valign=top nowrap><font color=<?php print $this->BodyTextColor?> size=<?php print $this->FontSize?> face=<?php print $this->FontFace?>><?php print $this->_STRINGS['WITH_EXACT_PHRASE'] ?></font></td>
                      <td valign=top>
                        <input class=WebInput type=text size=25 value="" name=Phrase>
                      </td>
                    </tr>
                    <tr>
                      <td valign=top nowrap><font color=<?php print $this->BodyTextColor?> size=<?php print $this->FontSize?> face=<?php print $this->FontFace?>><?php print $this->_STRINGS['WITH_ANY_WORDS'] ?></font>
		      </td>
                      <td valign=top>
                        <input class=WebInput type=text size=25 value="" name=AnyWords>
                      </td>
                    </tr>
                    <tr>
                      <td valign=top nowrap><font color=<?php print $this->BodyTextColor?> size=<?php print $this->FontSize?> face=<?php print $this->FontFace?>>
		      <?php print $this->_STRINGS['WITHOUT_THE_WORDS'] ?>
		      </font></td>
                      <td valign=top>
                        <input class=WebInput type=text size=25 value="" name=WithoutWords>
                      </td>
                    </tr>
                    <tr>
                      <td valign=top nowrap><font color=<?php print $this->BodyTextColor?> size=<?php print $this->FontSize?> face=<?php print $this->FontFace?>>
		        <?php print $this->_STRINGS['SOUNDS_LIKE_THE_WORDS'] ?>
                        </font></td>
                      <td valign=top>
                        <input class=WebInput type=text size=25 value="" name=SoundsLikeWords>
                      </td>
                    </tr>
                    <tr>
		      <td valign=top nowrap width=40%><font color=<?php print $this->BodyTextColor?> size=<?php print $this->FontSize?> face=<?php print $this->FontFace?>>
		      	Return 
                  	results where my terms occur</font></td>
                <td valign=top><font color=<?php print $this->BodyTextColor?> size=<?php print $this->FontSize?> face=<?php print $this->FontFace?>>
                  <select name=QueryOption>
<?php
		foreach($this->Options as $option => $val)
		{
			$optDisplay = $this->_STRINGS['QUERY_OPTION_' . strtoupper($option)];
			if ($optDisplay == '')
				$optDisplay = $option;
			print "			<option value=$option>$optDisplay</option>\n";
		}
?>
                  </select>
                  </font></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
	</form>
<?php

		$decorator->Close();
	}

}  // End BaseAdvancedQueryForm class



class
QueryField
{
	var $ColName = '';
	var $ColType = 'text';	// text, date, time, other
	var $ValidUsers = 'all';
}

class
BaseDetailedQueryForm extends BaseWebObject
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

	//Override in subclass
	var $Fields	= array();	// eg. array('TitMainTitle', 'TitAccessionNo');
	var $Additional	= array();	// eg. array('NotNotes');
	var $Hints	= array();	// eg. ('TitMainTitle' => 'eg. The Cat', 'TitAccessionNo' => 'internal use')
	var $DropDownLists = array();	// eg. ('PhyMedium' => 'Canvis|Timber|Clay')
	var $LookupLists = array();	// eg. ('CreCountry' => 'eluts:Country[1]')

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
	generateDropDown($fld)
	{
		$matches = array();
		if (preg_match('/^eluts:(.*?)\[?(\d*)\]?$/', $this->DropDownLists[$fld], $matches))
		{
			$tablename = $matches[1];
			if (isset($matches[2]) && $matches[2] != '')
				$level = $matches[2];
			else
				$level = 1;
			$value = sprintf('Value%02d0', (int) ($level - 1)); 
			$qry = new Query();
			$qry->Texql = "distinct(SELECT $value FROM eluts WHERE Name='$tablename' and Levels=$level) {1 to 500}"; 
			$recs = $qry->Fetch();
			print "		   <option></option>\n";
			$hasEntry = 0;
			foreach ($recs as $rec)
			{
				$option = trim($rec->{$value});
				if ($option != '' && strlen($option) < 35)
				{
					print "		   <option>\"$option\"</option>\n";
					$hasEntry = 1;
				}
			}
			if (! $hasEntry)
				print "		   <option>--- Non Available ---</option>\n";
		}
		else
		{
			foreach (split('\|', $this->DropDownLists[$fld]) as $option)
			{
				print "		   <option>$option</option>\n";
			}
		}
	}

	function
	display()
	{

		// print some JavaScript to assist with lookup list popup
		print "<script langauge=\"JavaScript\">\n";
		print "<!--\n";
		print "function openLookupList(formID, fieldID, LutName, term)\n";
		print "{\n";
		print "	url = '" . $GLOBALS['LOOKUPLIST_URL'] . "';";
		print "	url = url + '?formid=' + formID + '&fieldid=' + fieldID + '&lname=' + LutName + '&ll=' + term;";
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

<form method=post name='dtlquery' action="<?php print $this->PdaResultsListPage?>">
	<input type=hidden name=QueryName value=DetailedQuery>
	<input type=hidden name=StartAt value=1>
	<input type=hidden name=QueryPage value="<?php print $GLOBALS['PHP_SELF']?>">
	<input type=hidden name=Restriction value="<?php print $this->Restriction?>">
	<table width=100% border=0 cellspacing=2 cellpadding=2>
<?php
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
					$htmlFieldName = 'col_date_' . $fld->ColName;
					break;
				    case 'integer':
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
	    		print "<td valign=top nowrap width=25%>\n";
			print "<font color=" . $this->BodyTextColor;
			print " size=" . $this->FontSize . ' face="' . $this->FontFace . "\">\n";
			if (isset($this->_STRINGS[$fld->ColName]))
				$label = $this->_STRINGS[$fld->ColName];
			else
				$label = $fld->ColName;
			print "<b>&nbsp;&nbsp;" .  $label . "</b></font>\n";
	    		print "</td>\n";
	    		print "<td valign=top nowrap width=20%>\n";
			if (isset($this->DropDownLists[$fld->ColName]))
			{
				print "&nbsp;&nbsp;<select name=\"$htmlFieldName\">\n";
				$this->generateDropDown($fld->ColName);
				print "</select>\n";
			}
			elseif (isset($this->LookupLists[$fld->ColName]))
			{
				print '&nbsp;&nbsp;<input class=WebInput type=text value="" name="';
				print $htmlFieldName . "\" size=20>";
				// print picklist/lookuplist image and link
				$lookupName = urlencode($this->LookupLists[$fld->ColName]);
				print '&nbsp;';
				print '<a href="javascript:void(0)" onClick="openLookupList(\'dtlquery\', ';
				print "'$htmlFieldName', '$lookupName', dtlquery['$htmlFieldName'].value)\">";
				$imgPath = $GLOBALS['WEB_PICKLIST_GRAPHIC'];
				print "<img src=\"$imgPath\" border=0 align=top>";
				print '</a>';
			}
			else
			{
				print '&nbsp;&nbsp;<input class=WebInput type=text value="" name="';
				print $htmlFieldName . "\" size=20>\n";
			}
	    		print "</td>\n";
	    		print "<td valign=top width=55%>\n";
			print "<font color=" . $this->BodyTextColor . " size=" . $this->FontSize . ' face="' . $this->FontFace . "\">\n";
			print "" . $this->Hints[$fld->ColName] . "</font>\n";
	    		print "</td>\n";
	  		print "</tr>\n";
		}
?>
		<tr>
		<td valign=top nowrap>
			<font color=<?php print $this->BodyTextColor?> size=<?php print $this->FontSize?> face="<?php print $this->FontFace?>">
			<b>&nbsp;&nbsp;<?php print $this->_STRINGS['NUMBER_OF_RECORDS']?></b></font>
		</td>
		<td valign=top nowrap>
			&nbsp;&nbsp;<select name=LimitPerPage>
			  <option value=10 >10 results</option>
			  <option value=20 selected>20 results</option>
			  <option value=30 >30 results</option>
			  <option value=50 >50 results</option>
			  <option value=100 >100 results</option>
			</select>
		</td>
		<td valign=top>
		</td>
	</table>
	<p>
	&nbsp;&nbsp;<input class=WebInput type=submit name=Search value="Search">
	<input type=reset name=Rearch value="Clear">
	<font color=<?php print $this->BodyTextColor?> size=<?php print $this->FontSize?> face=<?php print $this->FontFace?>>
	&nbsp;&nbsp;<input class=WebInput type=checkbox name=ImagesOnly value=true>
	<?php print $this->_STRINGS['ONLY_WITH_IMAGES']?>
	</font>
	</p>
</form>

<?php
		$decorator->Close();
	} //end display()

} // End GalleryDetailedQueryForm class

?>
