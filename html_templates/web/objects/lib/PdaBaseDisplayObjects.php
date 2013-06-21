<?php
/*
*  Copyright (c) 2001 - KE Software Pty Ltd
*
*	TODO - Should refactor all these classes. It's getting messy.
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'configuredquery.php');
require_once ($LIB_DIR . 'common.php');
require_once ($LIB_DIR . 'border.php');
require_once ($LIB_DIR . 'Security.php');
require_once ($LIB_DIR . 'KeywordMarkup.php');


class
Field
{
	var $ColName	= '';
	var $Label	= '';
	var $Name	= '';		// Use for lookup in strings file for label
	var $Font	= '';
	var $FontSize	= '';
	var $FontColor	= '';
	var $Bold	= 0;
	var $Italics	= 0;
	var $LinksTo	= '';

	var $Filter	= '';		// Basic Filter (printers match group 1 from regex match)
	var $FilterPatt	= '';		// Advanced filter.  Matches Patt and replaces with
	var $FilterReplace = '';	// FilterReplace.  Uses the preg_replace() call.

	var $MarkupKeywords = 0;	// Markup narrative keywords/subjects as hyperlinks.

	var $ValidUsers = 'all';	// string of valid users

	var $_Data;

	// Constructor
	function
	Field($colname='', $label='')
	{
		$this->ColName	= $colname;
		$this->Label	= $label;
	}
}

class
FormatField extends Field
{
	var $Label = '';
	var $Format = '';
}

class
Table
{
	var $Headings	= array();
	var $Columns	= array();
	var $Name	= '';
	var $Label	= '';
}

/* 
** This object can be used in place of a field object to extract back references
**	from tables such as loans and narratives.
*/
class BackReferenceField extends Field
{
	var $RefDatabase	= '';	// eg. "enarratives" 
	var $RefField	= '';	// eg. "ObjObjectsRef_tab"
	var $ColName		= '';
}

/*
** Used internaly by the BackReferenceField for storing back reference matches
*/
class BackReferenceStore
{
	var $Data;
	var $IRN;
}


/*
** This is an abstract base class.
** 
** Extend this class and provide:
**
**	$this->Fields
**		Set the fields to display in the results list
**
** Dependencies:
**	common.php
*/
class
BaseStandardDisplay extends BaseWebObject
{
	var $IRN;
	var $QueryPage;

	// Public
	var $DisplayImage = 1;
	var $DisplayAllMedia = 1;
	var $DisplayLabels = 1;
	var $Width = '20%';
	var $FontFace = '';
	var $FontSize = '';
	var $HeaderFontSize = '';
	var $HeaderTextColor = '';
	var $BodyTextColor = '';
	var $BodyColor = '';
	var $BorderColor = '';
	var $HighlightColor = '';
	var $OtherDisplayPages = array();
	var $DisplayNewSearchLink = 1;
	var $SuppressEmptyFields = 1;

	// Fields
	var $Fields = array();
	var $HeaderField = 'SummaryData';
	var $Database = 'ecatalogue';
	
	// Provide an easy way of adding additional fields
	var $AdditionalFields = array();

	// Security Tester Object
	var $SecurityTester;

	// Private (vertual)
	var $record;
	var $selectArray = array();
	
	// Constructor
	function
	BaseStandardDisplay()
	{
		global $ALL_REQUEST;
		$this->BaseWebObject();
		$this->IRN 		= $ALL_REQUEST['irn'];
		$this->QueryPage	= $ALL_REQUEST['QueryPage'];
		$this->PartyDisplayPage = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		$this->SecurityTester	= new SecurityTester;
		if ($this->QueryPage == '')
			$this->QueryPage = $this->QueryFormPage;
	}

	/*
	** Support methods
	*/
	function
	_hasData($item)
	{
		if (is_string($item))
			$item = new Field($item, $this->_STRINGS[$item]);

		switch(strtolower(get_class($item)))
		{
		    case 'field':
			if (preg_match('/_tab/', $item->ColName))
			{
				$colname = preg_replace('/_tab/', ':1', $item->ColName);
				return($this->record->{$colname} != '');
			}
			else
			{
				return($this->record->{$item->ColName} != '');
			}
			break;

		    case 'formatfield':
			// format in the form "{ColName1} {ColName2}"
			preg_match_all('/{([^}]*)}/', $item->Format, $matches);
			foreach ($matches[1] as $colName)
			{
				if ($this->_hasData($colName)) 
					return(1);
				else
					return(0);
			}
			break;

		    case 'table':
		    	return($this->_tableHasData($item));
			break;
			
		    case 'backreferencefield':
		    	return(count($item->_Data) > 0);
			break;
		}
		return(0);
	}

	function
	_tableHasData($table, $row=1)
	{
		if (count($table->Columns) < 1)
			return (0);
		foreach ($table->Columns as $col)
		{
			if (is_string($col))
				$col = new Field($col, $this->_STRINGS[$col]);
			elseif(strtolower(get_class($col)) == 'table' && $this->_tableHasData($col))
				return(1);

			if (preg_match('/_tab/', $col->ColName))
			{
				$colname = preg_replace('/_tab/', ":$row", $col->ColName);
			}
			elseif(preg_match('/[^:\d]0$/', $col->ColName))
			{
				// A atom table in format FieldID0
				$colname = preg_replace('/0$/', ":$row", $col->ColName);
			}
			else
			{
				if ($row > 1)
					return(0);  // Not a nested table so must be no more data 
				$colname = $col->ColName;
			}

			if ($this->record->{$colname} != '')
				return(1);
		}
		return(0);
	}

	function
	_printField($field)
	{
		if (strtolower(get_class($field)) != 'field')
			return;

		if ($field->Bold)
			print "<b>";
		if ($field->Italics)
			print "<i>";

		$fielddata = $this->record->{$field->ColName};

		if ($field->LinksTo != '')
		{
			$sections = split('->', $field->ColName);
			$fieldName = $sections[0];
			$querypage = urlencode($this->QueryPage);
			$link = $field->LinksTo 
				. '?irn=' 
				. $this->record->$fieldName 
				. "&amp;QueryPage=$querypage";
			print "<a href=\"$link\">";
			$this->_displayData($field, $fielddata);
			print "</a>";
		}
		else
		{
			$this->_displayData($field, $fielddata);
		}
			
		if ($field->Italics)
			print "</i>";
		if ($field->Bold)
			print "</b>";
	}

	function
	_printFormatField($field)
	{
		if (strtolower(get_class($field)) != 'formatfield')
			return;

		$fielddata = preg_replace('/{([^}]*)}/e', ' $this->record->{"\\1"}', $field->Format);
		$this->_displayData($field, $fielddata);
	}

	function
	_printBackReferenceField($field)
	{
		if (strtolower(get_class($field)) != 'backreferencefield')
			return;

		$i = 0;
		foreach($field->_Data as $backref)
		{
			if ($i > 0)
				print "<br />\n";
			$i++;
			if ($field->LinksTo != '')
			{
				$querypage = urlencode($this->QueryPage);
				$link = $field->LinksTo 
					. '?irn=' 
					. $backref->IRN
					. "&amp;QueryPage=$querypage";

				print "<a href=\"$link\">";
				$this->_displayData($field, $backref->Data);
				print "</a>";
			}
			else
				$this->_displayData($field, $backref->Data);
		}
	}

	function
	_loadBackReferenceField(&$field)
	{
		/*
		** This method fetches any backreference data and loads in into the Data
		**  property
		*/
		if (strtolower(get_class($field)) != 'backreferencefield')
			return;

		if (	$field->RefDatabase == ''
			|| $field->RefField == '')
		{
			WebDie('BackReferenceFields mush have the RefDatabase and RefField set.',
				'BackReferenceField - Show()');
		}

		$qry = new ConfiguredQuery();
		$qry->SelectedLanguage = $this->LanguageData;
		$qry->Intranet = $this->Intranet;
		$qry->Select = array("irn", $field->ColName);
		$qry->From = $field->RefDatabase;
		$matches = array();
		if (preg_match('/^(.+?)_tab$/', $field->RefField, $matches))
		{
			$subcol = $matches[1];
			$fld = $field->RefField;
			$qry->Where = "EXISTS($fld WHERE $subcol=" . $this->IRN . ")";
		}
		else
			$qry->Where =  $field->RefField . "=" . $this->IRN;

		$records = $qry->Fetch();
		$field->_Data = array();
		foreach ($records as $record)
		{
			$backref = new BackReferenceStore;
			$backref->IRN = $record->{irn_1};
			$backref->Data = $record->{$field->ColName};
			array_push($field->_Data, $backref);
		}
	}

	function
	_displayData($field, $fielddata)
	{
		/* 
		** This function is the final call before displaying data.
		** do filtering and security here.
		*/

		// Security
		if (strtolower($field->ValidUsers) != 'all')
		{
			if (! $this->SecurityTester->UserIsValid($field->ValidUsers))
				return;
		}

		// Filter
		if ($field->Filter != '')
		{
			$matches = array();
			preg_match($field->Filter, $fielddata, $matches); 
			$fielddata = $matches[1];
		}
		elseif ($field->FilterPatt != '')
		{
			$fielddata = preg_replace($field->FilterPatt, 
						$field->FilterReplace, 
						$fielddata);
		}

		// Narrative Keyword Markup
		if ($field->MarkupKeywords)
		{
			$kw = new KeywordMarkup;
			$kw->FontFace 	= $this->FontFace;
			$kw->FontColor 	= $this->BodyTextColor;
			$kw->FontSize 	= $this->FontSize;
			$kw->NarrativesDisplayPage = $this->NarrativesDisplayPage;
			$kw->NarrativesResultsList = $this->NarrativesResultsList;

			$kw->DisplayText($fielddata);
		}
		else
		{
			PPrint(	$fielddata, 
				$this->FontFace, 
				$this->FontSize, 
				$this->BodyTextColor);
		}
	}


	function
	_printTabField($field)
	{
		if (strtolower(get_class($field)) != 'field')
			return;

		$row = 1;
		while(1)
		{
			$origName = $field->ColName;
			if (preg_match('/_tab/', $field->ColName))
			{
				$field->ColName = preg_replace('/_tab/', ":$row", $field->ColName);
			}
			elseif(preg_match('/[^:\d]0$/', $field->ColName))
			{
				$field->ColName = preg_replace('/0$/', ":$row", $field->ColName);
			}

			if ($this->record->{$field->ColName} == '')
			{
				$field->ColName = $origName;
				break;
			}
			$this->_printField($field);
			print "<br />\n";
			$field->ColName = $origName;
			$row++;
		}
	}

	function
	_printTable($table)
	{
		if (strtolower(get_class($table)) != 'table')
			return;
		elseIf( ! $this->_tableHasData($table, 1) )
			return;

		$row = 1;
		while(1)
		{
			if (! $this->_tableHasData($table, $row))
				break;
			if ($row == 1)
			{
				// TODO - dont print if not set.
				print "<!-- Start Sub Table -->\n";
				print "<table border=\"0\" cellpadding=\"1\" cellspacing=\"0\" width=\"100%\">\n";
				print "<tr>\n";
				for($i = 0; $i < count($table->Columns); $i++)
				{
					if (isset($table->Headings[$i]))
						$heading = $table->Headings[$i];
					else
						$heading = $this->_STRINGS[$table->Columns[$i]->ColName];
					print "<td><b>";
					PPrint($heading, $this->FontFace, $this->FontSize, $this->BodyTextColor);
					print "</b></td>\n";
				}
				print "</tr>\n";
			}

			print "<tr>\n";
			foreach ($table->Columns as $col)
			{
				print "<td>";
				if (is_string($col))
					$col = new Field($col, $this->_STRINGS[$col]);

				switch (strtolower(get_class($col)))
				{
				    case 'field':
					if (preg_match('/_tab/', $col->ColName))
					{
						$col->ColName = preg_replace('/_tab/', ":$row", $col->ColName);
					}
					elseif (preg_match('/[^:\d]0$/', $col->ColName))
					{
						$col->ColName = preg_replace('/0$/', ":$row", $col->ColName);
					}
					$this->_printField($col);
					break;
				    case 'table':
				    	$this->_printTable($col);
					break;
				    case 'formatfield':
					if (preg_match('/_tab/', $col->Format))
					{
						$col->Format = preg_replace('/_tab/', ":$row", $col->Format);
					}
					elseif (preg_match('/[^:\d]0$/', $col->Format))
					{
						$col->Format = preg_replace('/[^:\d]0$/', ":$row", $col->Format);
					}
				    	$this->_printFormatField($col);
					break;
				}
				print "</td>\n";
			}
			print "</tr>\n";
			$row++;
		}
		print "</table>\n";
		print "<!-- End Sub Table -->\n";
	}
		
	function
	_printItem($item)
	{
		// If String definition then turn to a field item
		if (is_string($item))
			$field = new Field($item, $this->_STRINGS[$item]);

		switch(strtolower(get_class($item)))
		{
		    case 'field':
			if (preg_match('/_tab/', $item->ColName) 
				|| preg_match('/[^:\d]0$/', $item->ColName) )
			{
				$this->_printTabField($item);
			}
			else
			{
				$this->_printField($item);
			}
			break;

		    case 'table':
		    	$this->_printTable($item);
			break;

		    case 'formatfield':
		    	$this->_printFormatField($item);
			break;
		    case 'backreferencefield':
		    	$this->_printBackReferenceField($item);
			break;
		}
	}

	function
	_buildSelectArray($itemArray)
	{
		if (count($itemArray) < 1)
			return;
		foreach($itemArray as $item)
		{
			if (is_string($item))
			{
				array_push($this->selectArray, $item);
			}
			elseif (strtolower(get_class($item)) == 'field')
			{
				array_push($this->selectArray, $item->ColName);
			}
			elseif (strtolower(get_class($item)) == 'table')
			{
				$this->_buildSelectArray($item->Columns);
			}
			elseif (strtolower(get_class($item)) == 'formatfield')
			{
				// format in the form "{ColName1} {ColName2}"
				preg_match_all('/{([^}]*)}/', $item->Format, $matches);
				foreach ($matches[1] as $colName)
				{
					array_push($this->selectArray, $colName);
				}
			}
			elseif (strtolower(get_class($item)) == 'backreferencefield')
			{
				// Ignore
				continue;
			}
		}
	}

        function
        printNavLinks()
        {
                // Print summary (i.e 10 to 20 of 234)
                /*if ($this->Matches > 0)
                {
                        $upper = $this->StartAt + $this->LimitPerPage - 1;
                        if ($upper > $this->Matches)
                                $upper = $this->Matches;

                        $summary = sprintf($this->_STRINGS['RESULTS SUMMARY'],
                                        $this->StartAt,
                                        $upper,
                                        $this->Matches);
                }
                else
                {
                        $summary = sprintf(
                                $this->_STRINGS['BRIEF RESULTS SUMMARY'],
                                $this->StartAt,
                                $this->StartAt + $this->LimitPerPage -1);
                }
                PPrint( $summary,
                        $this->FontFace,
                        $this->FontSize,
                        $this->TextColor);

                print '&nbsp;&nbsp;';*/

                // Pass all post/get vars through except 'StartAt'
                // increment 'StartAt' by the page limit ($this->LimitPerPage)

                // Note: This should be phased out in the future and changed to:
                //      array_merge($_POST', $_GET);
                $perams = array_merge($GLOBALS['HTTP_POST_VARS'],
                        $GLOBALS['HTTP_GET_VARS']);

                while(list($key, $val) = each($perams))
                {
                        // Don't pass through empty vars
                        // try to keep url length down
			$key = urlencode(stripslashes($key));
                        $val = urlencode(stripslashes($val));
                        $getString .= "$key=$val&amp;";
                }

                $thisPage = isset($GLOBALS['PHP_SELF'])
                        ? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];

        }


	function
	display()
	{

		$widthAttrib = '';
		if ($this->Width != '')
			$widthAttrib 	= 'width="' . $this->Width . '"' ;
		$bodyColorAttrib = '';
		if ($this->BodyColor != '')
			$bodyColorAttrib	= 'bgcolor=' . $this->BodyColor;
		$bodyTextColorAttrib = '';
		if ($this->BodyTextColor != '')
			$bodyTextColorAttrib	= 'color=' . $this->BodyTextColor;
		$highlightColorAttrib = '';
		if ($this->HighlightColor != '')
			$highlightColorAttrib	= 'bgcolor=' . $this->HighlightColor ;
		$headerTextColorAttrib = '';
		if ($this->HeaderTextColor != '')
			$headerTextColorAttrib= 'color=' . $this->HeaderTextColor;
		$borderColorAttrib = '';
		$headerColorAttrib = '';
		if ($this->BorderColor != '')
		{
			$borderColorAttrib= 'bordercolor=' . $this->BorderColor;
			$headerColorAttrib= 'bgcolor=' . $this->BorderColor;
		}
		$fontFaceAttrib = '';
		if ($this->FontFace != '')
			$fontFaceAttrib= 'face="' . $this->FontFace . '"';
		$fontSizeAttrib = '';
		if ($this->FontSize != '')
			$fontSizeAttrib= 'size="' . $this->FontSize . '"';
		if ($this->HeaderFontSize == '')
		{
			if ($this->FontSize != '')
				$this->HeaderFontSize = $this->FontSize + 1;
			else
				$this->HeaderFontSize = '+1';
		}

		print "<table $widthAttrib cellpadding=\"2\" cellspacing=\"0\" border=\"0\">\n";
		print "<tr><td align=\"left\">\n";
		$link = $this->QueryPage;

		if ($this->DisplayNewSearchLink)
		{
			print "&nbsp;<a href=\"$link\">";
			PPrint($this->_STRINGS['NEW SEARCH'], $this->FontFace, $this->FontSize, $this->BodyTextColor);
			print "</a>";
		}
		foreach ($this->OtherDisplayPages as $pagename => $pagelink)
		{
			$link = "$pagelink?irn=" . $this->IRN . "&amp;QueryPage=" . urlencode($this->QueryPage);
			PPrint(' | ', $this->FontFace, $this->FontSize, $this->BodyTextColor);
			print "<a href=\"$link\">";
			PPrint($pagename, $this->FontFace, $this->FontSize, $this->BodyTextColor);
			print "</a>";
		}

		print "</td>";
		//print "<td width=\"35%\" align=right>\n";
		print "<td width=\"35%\">\n";
		$this->printNavLinks();
		print "</td></tr><tr><td colspan=\"2\">\n";
		$decorator = new HtmlBoxAndTitle;
		$decorator->BorderColor = $this->BorderColor;
		$decorator->BodyColor = $this->BodyColor;
		$decorator->TitleTextColor = $this->HeaderTextColor;
		$decorator->FontFace = $this->FontFace;
		$decorator->Width = "20%";
		$decorator->Title = $this->record->{$this->HeaderField};
		$decorator->Open();

		if ($this->DisplayImage)
			$this->DisplayMedia();

		print "       <table width=\"10%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">\n";
		print "<!-- Start Field Content -->\n";

		// Foreach loop on each item in the $this->Fields var
		$i = 0;
		foreach ($this->Fields as $item)
		{
			if (is_string($item))
			{
				if (isset($this->_STRINGS[$item]))
					$item = new Field($item, $this->_STRINGS[$item]);
				else
					$item = new Field($item, $item);
			}

			// Don't display if fields security doesn't allow
			if (isset($item->ValidUsers) 
				&& strtolower($item->ValidUsers) != 'all')
			{
				if (! $this->SecurityTester->UserIsValid($item->ValidUsers))
					continue;
			}

			// If it's a backreference item, then load data
			if (strtolower(get_class($item)) == 'backreferencefield')
				$this->_loadBackReferenceField($item);

			if (! $this->SuppressEmptyFields || $this->_hasData($item))
			{
				$i++;
				if ($i == 1)
					continue; // ignore first field as it's used in heading
				if ($i % 2 == 0)
					print "	<tr $highlightColorAttrib align=\"left\" valign=\"top\">\n";
				else
					print "	<tr align=\"left\" valign=\"top\">\n";

				// Print field name
				if ($item->Label != '')
					$label = $item->Label;
				elseif ($item->Name != '')
				{
					if (isset($this->_STRINGS[$item->Name]))
						$label = $this->_STRINGS[$item->Name];
					else
						$label = $item->Name;
				}
				else
				{
					if (isset($this->_STRINGS[$item->ColName]))
						$label = $this->_STRINGS[$item->ColName];
					else
						$label = $this->ColName;
				}

				if ($this->DisplayLabels)
				{
					print "	  <td width=\"25\"><b>";
					print "<font $bodyTextColorAttrib $fontFaceAttrib $fontSizeAttrib>";
					print $label;
					print "</font></b></td>\n"; 
				}
				else
				{
					print "	  <td>&nbsp;</td>\n";
				}


				print "	  <td>\n";
				$this->_printItem($item);
				print "</td>\n";
				print "	</tr>\n";
			}
		}
		
		// Print the extra multimedia
		if ($this->DisplayImage)
			$firstImage = 2;
		else
			$firstImage = 1;
			
		$hasMedia = isset($this->record->{"MulMultiMediaRef:$firstImage"});
		if ($this->DisplayAllMedia && $hasMedia)
		{
			if ($i % 2 == 0)
				print "	<tr align=\"left\" valign=\"top\">\n";
			else
				print "	<tr $highlightColorAttrib align=\"left\" valign=\"top\">\n";

			// Print field name
			if ($this->DisplayLabels)
			{
				print "	  <td width=\"35\"><b><font $bodyTextColorAttrib $fontFaceAttrib $fontSizeAttrib>".
						$this->_STRINGS['MEDIA'] . "</font></b></td>\n"; 
			}

			// Display Images
			print "	  <td>\n";

			$i = $firstImage;
			$mmField = "MulMultiMediaRef:$i"; 
			$imgirn = $this->record->$mmField;
			while ($imgirn != '')
			{
				if ($this->Intranet)
				{
					$mediaURL = 
						$GLOBALS['INTRANET_MEDIA_URL'];
				}
				else
				{
					$mediaURL = $GLOBALS['MEDIA_URL'];
				}
				print '<a href="' . $mediaURL 
					. '?irn=' .  $imgirn . '">';
				print '<img src="' . $mediaURL 
					. '?thumb=yes&amp;irn=' . $imgirn
					. '&amp;reftable=' . $this->Database
					. '&amp;refirn=' . $this->IRN . '"';
				print ' width="55" height="55" vspace="4" hspace="4" align="top" border="2" /></a>' . "\n";
				$i++;
				$mmField = "MulMultiMediaRef:$i"; 
				$imgirn = $this->record->$mmField;
			}

			print "</td></tr>\n";
		}
		print "       </table>\n";
		print "<!-- End Field Content -->\n";

		$decorator->Close();
		print "</td></tr>";
		print "</table>\n";

	}

	function
	DisplayMedia()
	{
		/*  We are displaying teh start of the page. We show the
		**  media on the left and the title info on the right.
		*/
		print "      <table width=\"100%\" height=\"200\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">\n";
		print " 	<tr align=\"center\" valign=\"middle\">\n"; 
		print "		  <td width=\"50%\">\n";

		/*  Now we have the table set up show the image on the left.
		*/
		$image = new MediaImage;
		$image->Intranet = $this->Intranet;
		if ($this->Database == "emultimedia")
		{
			$image->IRN = $this->record->{'irn_1'};
		}
		else
		{
			$image->IRN = $this->record->{'MulMultiMediaRef:1'};
		}
		$image->BorderColor = $this->BorderColor;
		$image->HighLightColor = $this->BorderColor;
		$image->RefIRN = $this->IRN;
		$image->RefTable = $this->Database;
		$image->ShowBorder = "";

		$image->Show();

		/*  The title will appear on the right. The main field is
		**  the first field in the Fields[] array.
		*/
		$mainField = $this->Fields[0]; // The main field is the first one
		print "		  </td>\n";
		/* Don't worry about this
		print "		  <td valign=\"middle\" width=\"65%\">\n";
		print "		    <b>";
		PPrint($this->record->$mainField, $this->FontFace, $this->HeaderFontSize, $this->BodyTextColor);
		print "             </b>\n";
		*/

		/*  Now close off the table.
		*/
		/*print "		  </td>\n";*/
		print "		</tr>\n";
		print "	      </table>\n"; 
	}

	/*
	*  A convenience function for fetching an already defined field
	*	eg.  	$namField = $display->FetchFieldByName("NamFirst");
	*		$namField->Bold = 1;
	*/
	function
	&FetchFieldByName($field)
	{
		if (! is_string($field))
			return;
		for ($i = 0; $i < count($this->Fields); $i++)
		{
			if (is_string($this->Fields[$i]))
			{
				if ($field == $this->Fields[$i])
				{
					$returnField = new Field($this->Fields[$i]);
					$this->Fields[$i] = $returnField;
					return $this->Fields[$i];
				}
			}
			elseif (strtolower(get_class($this->Fields[$i])) == 'field')
			{
				if ($field == $this->Fields[$i]->ColName)
				{
					$returnField = $this->Fields[$i];
					return($this->Fields[$i]);
				}
			}
			// FIXME - Support Tables
		}
		return;
	}

	function
	Show()
	{
		/*
		**  The Show() method is resposible for sourcing the Language strings
		**  ($this->_STRINGS) and performing the query before calling display().
		*/
		$this->sourceStrings();

		if (!isset($this->IRN))
		{
			WebDie('Invalid IRN', 'BaseDisplayObject');
		}

		// we don't grab the Multimedia ref if we are already in Multimedia
		if ($this->Database == "emultimedia")
		{
			$this->_buildSelectArray(array('irn', 'SummaryData'));
		}
		else
		{
			$this->_buildSelectArray(array('irn', 'SummaryData', 'MulMultiMediaRef_tab'));
		}
		$this->_buildSelectArray($this->Fields);
		$this->_buildSelectArray($this->AdditionalFields);

		if (count($this->AdditionalFields) > 0)
		{
			$this->Fields = array_merge($this->Fields, $this->AdditionalFields);
		}

		$qry = new ConfiguredQuery;
		$qry->SelectedLanguage = $this->LanguageData;
		$qry->Intranet = $this->Intranet;
		$qry->Select = $this->selectArray;
			
		$qry->From = $this->Database;
		$qry->Where = 'irn=' . $this->IRN;
		$result = $qry->Fetch();
		if (!isset($result[0]->irn_1) || $result[0]->irn_1 == '')
		{
			print "<center>";
			print "<h2>";
			PPrint($this->_STRINGS['NO RESULTS'], $this->FontFace, '', $this->BodyTextColor);
			print"</h2>\n";
			print "<h3>";
			PPrint($this->_STRINGS['GO BACK'], $this->FontFace, '', $this->BodyTextColor);
			print "</h3>\n";
			print '<br /></center>';
			return;
		}

		$this->record = $result[0];

		// Now we call the display function
		$this->display();
	}
}


	

?>
