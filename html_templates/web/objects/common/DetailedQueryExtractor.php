<?php
/*
** Copyright (c) 1998-2012 KE Software Pty Ltd
*/
/* DetailedQueryExtractor.php - A class for generating the input boxes necassary
** for a Detailed Query Page. Prompts and Hints are not included.
**	Written by Alex.
**
** For usage example see base of file.
**
**
** Function List (PUBLIC):
**	BeginQueryForm()	- Must be called before any input controls are placed on the page. Creates form header HTML
**				  and Lookup List Javascript.
**	ShowInputField( Column Name(s), Type, Range )
**				- Prints out a standard web editbox. Column Names specifies EMu field names (pipe seperated
**				  or single), Type ('text', 'date', etc.) and Range ('upper', 'lower' or blank). Range
**				  can only be used for date or integer fields.
**	ShowDropdown( Column Name, Type, Contents )
**				- Prints out a standard web dropdown containing 'Contents'. 'Contents' can be either a
**				  static pipe-seperated list or a string in the form 'eluts:{Lookup Name}'.
**	ShowLookupList( Column Name, Lookup Name )
**				- Prints out a web edit box and a lookup icon that when clicked opens the lookup popup.
**				  'Lookup Name' is the name as contained in eluts.
**	ShowLimitPerPage( Contents, Units, Default )
**				- Prints out a dropdown box containing the entries as given in the pipe-seperated list
**				  'Contents'. 'Units' can be anything meaningful, e.g. 'hits', 'results', 'matches'.
**				  'Default' is one of the values contained in Contents which is to be selected by default.
**	ShowSubmit( Label )	- Prints out the submit button with the label 'Label'.
**	ShowReset( Label )	- Prints out the reset button with the label 'Label'.
**	ShowImagesOnlyChk()	- Shows the 'Return only items with images' checkbox.
**	EndQueryForm()		- Closes the HTML Form.
*/
if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once($WEB_ROOT . '/objects/lib/webinit.php');
require_once($LIB_DIR . 'BaseQueryForm.php');
require_once($LIB_DIR . 'configuredquery.php');

class
DetailedQueryExtractor extends BaseQueryForm
{
	var $formOpened = 0;
	var $Restriction = '';
	var $MaxDropDownLength = 35;
	
	function
	DetailedQueryExtractor()
	{
		$this->BaseWebObject();
		$this->AdditionalTransferVariables = $this->getUrlParams();
	}
	
        function
        getUrlParams()
        {
                $params = array_merge(
			$GLOBALS['HTTP_POST_VARS'], 
                        $GLOBALS['HTTP_GET_VARS']
			);

                return $params;
        }

	function
	BeginQueryForm()
	{
		print "<script langauge=\"JavaScript\">\n";
		print "<!--\n";
		print "function openLookupList(formID, fieldID, LutName, term)\n";
		print "{\n";
		print "	url = '" . $GLOBALS['LOOKUPLIST_URL'] . "';";
		print "	url = url + '?formid=' + formID + '&fieldid=' + fieldID + '&lname=' + LutName + '&ll=' + term;\n";
		print "	url = url + '&bodycolor=" . urlencode($this->BodyColor) . "';\n";
		print "	url = url + '&bodytextcolor=" . urlencode($this->BodyColor) . "';\n";
		print "	url = url + '&lang=" . $this->LanguageData . "';\n";
		print '	popupWindow = window.open(url, "popupWindow", "height=350,width=250,location=no,status=no,toolbar=no,scrollbars=yes"); ';
		print "	popupWindow.focus();\n";
		print "}\n";
		print "//-->\n";
		print "</script>\n";

		print '<form method="post" name="dtlquery" action="' . $this->ResultsListPage . "\">\n";
		print '<input type="hidden" name="QueryName" value="DetailedQuery" />' ."\n";
		print '<input type="hidden" name="StartAt" value="1" />' . "\n";		print '<input type="hidden" name="QueryPage" value="' . WebSelf() . "\" />\n";
		print '<input type="hidden" name="Restriction" value="' . $this->Restriction . "\" />\n";
		$this->printAdditionalTransferVariables();
		
		$this->formOpened = 1;
	}
	
	function
	ShowInputField( $FieldName = '', $Type = 'text', $Range = '' )
	{
		$Type = strtolower($Type);
		
		if (empty($FieldName))
			WebDie('No Field Name specified for ShowInputField()');

		if (empty($Type))
			WebDie('No Field Type specified for ShowInputField()');

		if ($this->formOpened != 1)
			WebDie('Cannot print Field without first opening Form');

		$IsLower = 0;
		$IsUpper = 0;
		if (strtolower($Range) == 'upper')
			$IsUpper = 1;
		elseif (strtolower($Range) == 'lower')
			$IsLower = 1;
		
		$FieldName = $this->generateColumnName($FieldName, $Type, $IsLower, $IsUpper);

		print '<input class="WebInput" type="text" value="" name="' . $FieldName . "\" />\n";
	}

	function
	ShowDropdown( $FieldName = '', $Type = 'text', $Contents = '' )
	{
		$Type = strtolower($Type);

		if (empty($FieldName))
			WebDie('No Field Name specified for ShowDropdown()');
	
		if (empty($Type))
			WebDie('No Field Type specified for ShowDropdown()');

		if (empty($Contents))
			WebDie("No Contents specified for DropDown $FieldName in ShowDropdown()");
		
		if ($this->formOpened != 1)
			WebDie('Cannot print Field without first opening Form');

		$FieldName = $this->generateColumnName($FieldName, $Type);
		
		print "<select name=\"$FieldName\">\n";
		
		$matches = array();
		if (preg_match('/^eluts:(.*?)\[?(\d*)\]?$/', $Contents, $matches))
		{
			$tablename = $matches[1];
			if (isset($matches[2]) && $matches[2] != '')
				$level = $matches[2];
			else
				$level = 1;
			$value = sprintf('Value%02d0', (int) ($level - 1)); 
			$qry = new ConfiguredQuery();
			$qry->SelectedLanguage = $this->LanguageData;
			$qry->Texql = "distinct(SELECT $value FROM eluts WHERE Name='$tablename' and Levels=$level) {1 to 500}"; 
			$recs = $qry->Fetch();
			print "		   <option></option>\n";
			$hasEntry = 0;
			foreach ($recs as $rec)
			{
				$option = trim($rec->{$value});
				if (strlen($option) > $this->MaxDropDownLength)
				{
					/*  We need to trim the option to maximum length by
					**  truncating and adding an ellipsis.
					*/
					$option = substr($option, 0, $this->MaxDropDownLength - 3);
					$option = preg_replace('/\w*$/', '...', $option, 1);
				}
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
			foreach (split('\|', $Contents) as $option)
			{
				print "		   <option>$option</option>\n";
			}
		}
		print "</select>\n";
	}

	function
	ShowLimitPerPage( $Contents, $Units, $Selected )
	{
		if (empty($Contents))
			WebDie("No Contents specified in ShowLimitPerPage()");

		if (empty($Units))
			WebDie("No Units specified in ShowLimitPerPage()");

		print "<select name=\"LimitPerPage\">\n";

		foreach (split('\|', $Contents) as $option)
		{
			print "		   <option value=\"$option\"";
			if ($option == $Selected)
				print ' selected="selected"';
			print ">$option $Units</option>\n";
		}

		print "</select>\n";
	}
			
	function
	ShowLookupList( $FieldName = '', $LookupName = '' )
	{
		if (empty($FieldName))
			WebDie('No Field Name specified for ShowLookupList()');
			
		if (empty($LookupName))
			WebDie('No Lookup Name specified for ShowLookupList()');
		
		$FieldName = $this->generateColumnName( $FieldName, 'text' );
		$LookupName = urlencode($LookupName);

		print '<input class="WebInput" type="text" value="" name="';
		print $FieldName . "\" size=\"20\" />";
		// print picklist/lookuplist image and link
		print '&nbsp;';
		print '<a href="javascript:void(0)" onclick="openLookupList(\'dtlquery\', ';
		print "'$FieldName', '$LookupName', dtlquery['$FieldName'].value)\">";
		$imgPath = $GLOBALS['WEB_PICKLIST_GRAPHIC'];
		print "<img src=\"$imgPath\" border=\"0\" align=\"top\" />";
		print '</a>';
	}

	function
	ShowSubmit( $Label )
	{
		print "<input class=\"WebInput\" type=\"submit\" name=\"$Label\" value=\"$Label\" />\n";
	}

	function
	ShowReset( $Label )
	{
		print "<input type=\"reset\" name=\"$Label\" value=\"$Label\" />\n";
	}

	function
	ShowImagesOnlyChk()
	{
		print '<input class="WebInput" type="checkbox" name="ImagesOnly" value="true" />' . "\n";
	}

	function
	generateColumnName( $FieldName = '', $Type = '', $IsLower = 0, $IsUpper = 0 )
	{
		if ( empty($FieldName) || empty($Type) )
			WebDie('FieldName and Type must both be set in generateColumnName()');

		switch($Type)
		{
		    case 'date':
			if ($IsLower)
				$FieldName = 'col_date_lower_' . $FieldName;
			elseif ($IsUpper)
				$FieldName = 'col_date_upper_' . $FieldName;
			else
				$FieldName = 'col_date_' . $FieldName;
			break;
		    case 'integer':
			if ($IsLower)
				$FieldName = 'col_int_lower_' . $FieldName;
			elseif ($IsUpper)
				$FieldName = 'col_int_upper_' . $FieldName;
			else
				$FieldName = 'col_int_' . $FieldName;
			break;
		    case 'string':
			$FieldName = 'col_str_' . $FieldName;
			break;
		    case 'text':
			$FieldName = 'col_' . $FieldName;
			break;
		    default:
		    	WebDie('Unknown field Type specified in generateColumnName()');
			break;
		}

		return $FieldName;
	}

	function
	EndQueryForm()
	{
		print "</form>\n";
		$this->formOpened = 0;
	}
}

/* USAGE: (as used on HTML page). Object creates HTML objects necassary for input on a
** Detailed Query Form. Prompts and Hints are left to the page designer.

<?php
require_once('../mcgweb/objects/common/DetailedQueryExtractor.php');
$gen = new DetailedQueryExtractor();
$gen->ResultsListPage = 'ResultsList.php';
$gen->AdvancedQueryPage = 'AdvQuery.php';
$gen->DetailedQueryPage = 'DtlQuery.php';

$gen->BeginQueryForm();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
	<tr valign="bottom" height="35">
		<td nowrap="nowrap" width="10%">
			<font color="#000000" size=1 face="Verdana, Arial">
			<b>&nbsp;&nbsp;Collection Group</b></font>
		</td>
		<td nowrap="nowrap" width="20%">
			<?php $gen->ShowDropdown('TitCollectionGroup_tab', 'text', 'eluts:Collection Group'); ?>
		</td>
	</tr>
	<tr valign="bottom" height="35">
		<td nowrap="nowrap" width="10%">
			<font color="#000000" size=1 face="Verdana, Arial">
			<b>&nbsp;&nbsp;Object Type</b></font>
		</td>
		<td nowrap="nowrap" width="20%">
			<?php $gen->ShowInputField("TitObjectCategory", 'text'); ?>
		</td>
	</tr>
	<tr valign="bottom" height="35">
		<td nowrap="nowrap" width="10%">
			<font color="#000000" size=1 face="Verdana, Arial">
			<b>&nbsp;&nbsp;Title</b></font>
		</td>
		<td nowrap="nowrap" width="20%">
			<?php $gen->ShowInputField('TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitAlternateTitles_tab', 'text'); ?>
		</td>
	</tr>
	<tr valign="bottom" height="35">
		<td nowrap="nowrap" width="10%">
			<font color="#000000" size=1 face="Verdana, Arial">
			<b>&nbsp;&nbsp;Date Made (earliest)</b></font>
		</td>
		<td nowrap="nowrap" width="20%">
			<?php $gen->ShowInputField('CreEarliestDate', 'date', 'lower'); ?>
		</td>
	</tr>
	<tr valign="bottom" height="35">
		<td nowrap="nowrap" width="10%">
			<font color="#000000" size=1 face="Verdana, Arial">
			<b>&nbsp;&nbsp;Date Made (latest)</b></font>
		</td>
		<td nowrap="nowrap" width="20%">
			<?php $gen->ShowInputField('CreLatestDate', 'date', 'upper'); ?>
		</td>
	</tr>
		<tr valign="bottom" height="35">
		<td nowrap="nowrap" width="10%">
			<font color="#000000" size=1 face="Verdana, Arial">
			<b>&nbsp;&nbsp;Subject Classification</b></font>
		</td>
		<td nowrap="nowrap" width="20%">
			<?php $gen->ShowLookupList('CreSubjectClassification_tab', 'Subject Classification'); ?>
		</td>
	</tr>
	<tr valign="bottom" height="35">
		<td nowrap="nowrap">
			<font color="#000000" size="1" face="Verdana, Arial">
			<b>&nbsp;&nbsp;Records per page</b></font>
		</td>
		<td nowrap="nowrap">
			<?php $gen->ShowLimitPerPage("10|20|30|50|100", 'results', 20); ?>
		</td>
	</tr>
</table>
	<p>
	&nbsp;&nbsp;<?php $gen->ShowSubmit('Search'); ?>
	<?php $gen->ShowReset('Reset'); ?>
	<font color="#000000" size="1" face="Verdana, Arial">
	&nbsp;&nbsp; <?php $gen->ShowImagesOnlyChk(); ?>
	List works only with images	</font>
	</p>
<?php $gen->EndQueryForm(); ?>
*/

?>
