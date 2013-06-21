<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'configuredquery.php');
require_once ($LIB_DIR . 'border.php');
require_once ($LIB_DIR . 'common.php');
require_once ($LIB_DIR . 'Security.php');

/*
** The BaseBasicQueryForm is an abstract base class
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
?>

		<form name="search" action="<?php print $this->ResultsListPage?>" method="post">
                <input type=hidden name=QueryName value= WarclipCustomQueryForm >
                <input type=hidden name=QueryPage value="<?php print $GLOBALS['PHP_SELF']?>">
      		<input type=hidden name=RelevanceRanking value = WarclipRelevanceRanking >
      		<input type=hidden name=WarclipCounter value = WarclipCounter>
		<input type=hidden name=Restriction value="<?php print $this->Restriction?>">
                <input type=hidden name=StartAt value=1>
		<input type=hidden name=lang value="<?php print $this->LanguageData?>">

                <table border="0" cellspacing="3">
                	<!--<tbody>-->
<?php

	                // print Options as hidden so they are passed through
        	        foreach($this->Options as $option => $fields)
                	{
                        	print "         <input type=hidden name=\"$option\" value=\"$fields\">\n";
                	}
?>
<?php
                	// print Words as hidden so they are passed through
                	foreach($this->Words as $word => $fields)
                	{
                        	print "         <input class=WebInput type=hidden name=\"$fields\" value=\"\">\n";
                	}
?>

		<tr>
			<td align = "left"><INPUT CLASS="WebInput" TYPE="text" 
				NAME="SearchWord" VALUE="" SIZE="25"></td>
		</td></tr>
               <tr>
                        <td align="left"><?php print $this->_STRINGS['LOOK FOR'] ?><br>
                                <select name=QueryWord>
<?php
                                foreach($this->Words as $word => $val)
                                {
                                        $opt1Display = $this->_STRINGS['QUERY_WORD_' . strtoupper($word)];
                                        if ($opt1Display == '')
                                        $opt1Display = $word;
                                        print "                 <option value=$word>$opt1Display</option>\n";
                                }
?>
                                </select>
             
	     	<br><?php print $this->_STRINGS['APPEARING'] ?><br>
                                 <select name=QueryOption>
<?php
                                foreach($this->Options as $option => $val)
                                {
                                        $optDisplay = $this->_STRINGS['QUERY_OPTION_' . strtoupper($option)];
                                        if ($optDisplay == '')
                                                $optDisplay = $option;
                                        print "                 <option value=$option>$optDisplay</option>\n";
                                }
?>
                                </select>
                                </td>
                </tr>
        	<tr>
			<td><input class=WebInput type=submit name=Submit value=<?php print $this->_STRINGS['SEARCH'] ?>>
			</td>
		</tr>
		<tr>
<?php

		if ($this->LanguageData == '0')
		{ 
		
			print '<td><A HREF = "AdvQueryE.php">' . $this->_STRINGS['SEARCH_TITLE'] . '</A></td>'; 

		}
		else
		{
			
			print '<td><A HREF = "AdvQueryF.php">' . $this->_STRINGS['SEARCH_TITLE'] . '</A></td>'; 
		}
?>
		</tr>

                	<!--</tbody>-->
		</table>
        	</form>

<?php
		//$decorator->Close();
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
	var $TitleTextColor = '';
	var $BodyTextColor = '';
	var $BorderColor = '';
	var $BodyColor = '';
	var $ResultsListPage; 

	// Override
	var $Options = array();		// eg. array('any' => 'AdmWebMetadata|DocumentText');
	var $Words = array();		// eg. array('any' => 'AdmWebMetadata|DocumentText');
	var $Month = array();

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


?>

        	<form name="advsearch" action="<?php print $this->ResultsListPage ?>" method="post">
		<input type=hidden name=QueryName value=WarclipAdvancedQuery>
		<input type=hidden name=RelevanceRanking value = AdvancedRelevanceRanking>
		<input type=hidden name=WarclipCounter value = WarclipCounter>
		<input type=hidden name=StartAt value=1>
		<input type=hidden name=QueryPage value="<?php print $GLOBALS['PHP_SELF']?>">
		<input type=hidden name=Restriction value="<?php print $this->Restriction?>">
                <input type=hidden name=lang value="<?php print $this->LanguageData?>">
		
		<table border="0" cellspacing="3" >
                <tr>
                        <td align="left" Colspan="3"><h1><?php print $this->_STRINGS['SEARCH_TITLE']; ?></h1>
			</td>
                </tr> 
<?php
                // print Month as hidden so they are passed through
		foreach($this->Month as $month => $fields)
		{
			print "         <input type=hidden name=\"$month\" value=\"$fields\">\n";
		}
?>
		
<?php
		// print Options as hidden so they are passed through
		foreach($this->Options as $option => $fields)
		{
			print "		<input type=hidden name=\"$option\" value=\"$fields\">\n";
		}
?>
<?php
		// print Words as hidden so they are passed through
//		foreach($this->Words as $word => $fields)
//		{
//			print "		<input class=WebInput type=hidden name=\"$fields\" value=\"\">\n";
//		}
?>

                <tr>
                <td>&nbsp;</td>
                </tr> 
		<tr>
                        <td align="left"><?php print $this->_STRINGS['SEARCH TERMS'] ?> </td><td><INPUT CLASS="WebInput" TYPE="text" NAME="SearchWord1" VALUE="" SIZE="25"></td>

                </tr>
		<tr>
			<td align="left"><?php print $this->_STRINGS['APPEARING'] ?></td><td>
                                 <select name=QueryOption1>
<?php
                                foreach($this->Options as $option => $val)
                                {
                                        $optDisplay = $this->_STRINGS['QUERY_OPTION_' . strtoupper($option)];
                                        if ($optDisplay == '')
                                                $optDisplay = $option;
                                        print "                 <option value=$option>$optDisplay</option>\n";
                                }
?>
                                </select>
                                </td>
		</tr>
		<tr>
                <td colspan = 2><br><?php print $this->_STRINGS['FILTER_STATEMENT'] ?> <br><br></td>
                </tr>
<!-- Filter1 -->
                <tr>
              		<td><input TYPE="RADIO" NAME="filter1" Value= "AND" checked><?php print $this->_STRINGS['QUERY_AND']; ?> <input TYPE="RADIO" NAME="filter1" Value="OR"> <?php print $this->_STRINGS['QUERY_OR']; ?> <input TYPE="RADIO" NAME="filter1" Value="NOT"><?php print $this->_STRINGS['QUERY_NOT']; ?></td>
                </tr>
                
		<tr>
                        <td align="left"><?php print $this->_STRINGS['SEARCH TERMS'] ?> </td><td><INPUT TYPE="text" NAME="SearchWord2" SIZE="25">
                        </td>
                </tr>
		<tr><td align="left"><?php print $this->_STRINGS['APPEARING'] ?></td><td>
                <select name=QueryOption2>
<?php
                foreach($this->Options as $option => $val)
		{
			$opt3Display = $this->_STRINGS['QUERY_OPTION_' . strtoupper($option)];
       	                if ($opt3Display == '')	
				$opt3Display = $option;
                        print "                 <option value=$option>$opt3Display</option>\n";
                }
?>
                </select></td></tr>
		<tr><td>&nbsp;</td></tr>
<!-- End Filter1 -->

<!-- Filter2 -->
                <tr><td><input TYPE="RADIO" NAME="filter2" Value="AND" checked><?php print $this->_STRINGS['QUERY_AND']; ?> <input TYPE="RADIO" NAME="filter2" Value="OR"><?php print $this->_STRINGS['QUERY_OR']; ?> <input TYPE="RADIO" NAME="filter2" Value="NOT"><?php print $this->_STRINGS['QUERY_NOT']; ?></td>
		<tr><td align="left"><?php print $this->_STRINGS['SEARCH TERMS'] ?> </td><td><INPUT TYPE="text" NAME="SearchWord3" SIZE="25"></td>
                </tr>
		<tr>
                        <td align="left"><?php print $this->_STRINGS['APPEARING'] ?></td><td>
                                 <select name=QueryOption3>
<?php
                                foreach($this->Options as $option => $val)
                                {
                                        $opt5Display = $this->_STRINGS['QUERY_OPTION_' . strtoupper($option)];
                                        if ($opt5Display == '')
                                                $opt5Display = $option;
                                        print "                 <option value=$option>$opt5Display</option>\n";
                                }
?>
                                </select>
                        </td>

                </tr>

<!-- End Filter2 -->

                <tr><td colspan="3">&nbsp;</td></tr>

<!-- Start Date Range Selection -->

		<tr>
			<td><?php print $this->_STRINGS['DATE_RANGE'] ?>&nbsp;: </td>
		</tr>
		<tr>
			<td><?php print $this->_STRINGS['DATE_FROM'] ?>&nbsp;:</td>
                        <td>
			
			<select name = BeginYear>
			<option value = '0'><?php print $this->_STRINGS['YEAR'] ?> </option>
			
<?php
			for($year = 1931; $year <= 1952; $year++)
			{
				print "		<option value=$year> $year </option>\n";
			}
?>
			</select>

                        <select name=BeginMonth>
<?php
                        foreach($this->Month as $month => $val)
                        {
                                $monthDisplay = $this->_STRINGS['QUERY_MONTH_' . strtoupper($month)];
                                if ($monthDisplay == '')
                                        $monthDisplay = $month;
                                print "         <option value=$month> $monthDisplay </option>\n";

                        }
?>
                        </select>
			
			<select name = BeginDay>
			<option value = '0' ><?php print $this->_STRINGS['DAY'] ?></option>
<?php
			for($day = 1; $day <= 31; $day++)
			{
				
				print "         <option value=$day> $day </option>\n";
			}
?>
			</select>
                        </td>

		</tr>
		<tr>
			<td><?php print $this->_STRINGS['DATE_TO'] ?>&nbsp;:</td>
                        <td>
                        <select name = EndYear>
			<option value = '0'> <?php print $this->_STRINGS['YEAR'] ?> </option>
<?php
                        for($year = 1931; $year <= 1952; $year++)
                        {
                                print "         <option value=$year> $year </option>\n";
                        }
?>
                        </select>

                        <select name=EndMonth>
<?php
                        foreach($this->Month as $month => $val)
                        {
                                $monthDisplay = $this->_STRINGS['QUERY_MONTH_' . strtoupper($month)];
                                if ($monthDisplay == '')
                                        $monthDisplay = $month;
                                print "         <option value=$month> $monthDisplay </option>\n";

                        }
?>
                        </select>
			<select name = EndDay>
                        <option value = '0' > <?php print $this->_STRINGS['DAY'] ?></option>
<?php
                        for($day = 1; $day <= 31; $day++)
                        {

                                print "         <option value=$day> $day </option>\n";
                        }
?>
                        </select>
                        </td>			
		</tr>

<!-- End Date Range Selection -->
                

<!-- number of results -->

                <tr>
                        <td><?php print $this->_STRINGS['DISPLAY'] ?>&nbsp;<select name="LimitPerPage">
                                <option value="10">10</option>
                                <option value="20" selected>20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                </select>&nbsp;<?php print $this->_STRINGS['RESULT PER PAGE'] ?>
                        </td>
                </tr>
<!-- End number of results -->




		<tr>
                        <td><br><br><input class=WebInput type=submit name=Submit value=<?php print $this->_STRINGS['SEARCH'] ?>>&nbsp;&nbsp;&nbsp;
                        <input type="reset" value=<?php print $this->_STRINGS['CLEAR'] ?>>
                        </td>

                </tr>
                </table>
        </form>

<?php

		//$decorator->Close();
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

<form method=post name='dtlquery' action="<?php print $this->ResultsListPage?>">
	<input type=hidden name=QueryName value=DetailedQuery>
	<input type=hidden name=StartAt value=1>
	<input type=hidden name=QueryPage value="<?php print $GLOBALS['PHP_SELF']?>">
	<input type=hidden name=Restriction value="<?php print $this->Restriction?>">
	<table width=100% border=0 cellspacing=0 cellpadding=2>
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
	    		print "<td nowrap width=25%>\n";
			print "<font color=" . $this->BodyTextColor;
			print " size=" . $this->FontSize . ' face="' . $this->FontFace . "\">\n";
			if (isset($this->_STRINGS[$fld->ColName]))
				$label = $this->_STRINGS[$fld->ColName];
			else
				$label = $fld->ColName;
			print "<b>&nbsp;&nbsp;" .  $label . "</b></font>\n";
	    		print "</td>\n";
	    		print "<td nowrap width=20%>\n";
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
	    		print "<td width=55%>\n";
			print "<font color=" . $this->BodyTextColor . " size=" . $this->FontSize . ' face="' . $this->FontFace . "\">\n";
			print "&nbsp;&nbsp;" . $this->Hints[$fld->ColName] . "</font>\n";
	    		print "</td>\n";
	  		print "</tr>\n";
		}
?>
		<tr>
		<td nowrap>
			<font color=<?php print $this->BodyTextColor?> size=<?php print $this->FontSize?> face="<?php print $this->FontFace?>">
			<b>&nbsp;&nbsp;<?php print $this->_STRINGS['NUMBER_OF_RECORDS']?></b></font>
		</td>
		<td nowrap>
			&nbsp;&nbsp;<select name=LimitPerPage>
			  <option value=10 >10 results</option>
			  <option value=20 selected>20 results</option>
			  <option value=30 >30 results</option>
			  <option value=50 >50 results</option>
			  <option value=100 >100 results</option>
			</select>
		</td>
		<td>
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
