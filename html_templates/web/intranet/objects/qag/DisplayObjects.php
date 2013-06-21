<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
require_once('QagSessions.php');

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');
require_once ('DefaultPaths.php');

class
QagStandardDisplay extends BaseStandardDisplay
{

	// Set default in the constructor
	function
	QagStandardDisplay()
	{
		$narratives = new BackReferenceField;
		$narratives->RefDatabase = "eevents";
		$narratives->RefField = "ObjAttachedObjectsRef_tab";
		$narratives->ColName = "SummaryData";
		$narratives->Label = "Events";
		$narratives->LinksTo = $GLOBALS['DEFAULT_EXHIBITION_PAGE'];

		$creRole = new Field;
		$creRole->ColName = 'CreRole_tab';
		$creRole->Italics = 1;
		
		$creCreatorRef = new Field;
		$creCreatorRef->ColName = 'CreCreatorRef_tab->eparties->SummaryData';
		$creCreatorRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		
		$creatorTable = new Table;
		$creatorTable->Name = "CREATOR";
		$creatorTable->Columns = array($creRole, $creCreatorRef);

		$note = new Field;
		$note->ColName = 'MulMultiMediaRef:1->emultimedia->NotNotes';
		$note->ValidUsers = "none";

		$right = new Field;
		$right->ColName = 'MulMultiMediaRef:1->emultimedia->DetRights';
		$right->ValidUsers = "none";

		$date = new Table;
		$date->Name = 'Dates';
		$date->Columns = array(
					'ArtArtistRef_tab->eparties->BioBirthDate',
					'ArtArtistRef_tab->eparties->BioDeathDate',
					);

		for($i=1; $i<21; $i++)
		{
			$fld = new Field;
			$fld->Name = 'Creator/Culture';
			$fld->ColName = 'ArtArtistRef:' . $i . '->eparties->SummaryData';
			$fldarr[] = $fld;

			$fld = new Field;
			$fld->Name = 'Role';
			$fld->ColName = 'ArtArtistRole:' . $i; 
			$fldarr[] = $fld;
		
			$fld = new Field;
                        $fld->Name = 'Cultural identity';
                        $fld->ColName = 'ArtArtistRef:' . $i . '->eparties->BioEthnicity';
                        $fldarr[] = $fld;

			$fld = new Field;
			$fld->Name = 'Principal country';
			$fld->ColName = 'ArtArtistRef:' . $i . '->eparties->BioNationality';
			$fldarr[] = $fld;

			$fld = new Field;
			$fld->Name = 'State';
			$fld->ColName = 'ArtArtistRef:' . $i . '->eparties->BioState';
			$fldarr[] = $fld;

			$fld = new Field;
			$fld->Name = 'Born';
			$fld->ColName = 'ArtArtistRef:' . $i . '->eparties->BioBirthDate';
			$fldarr[] = $fld;

			$fld = new Field;
			$fld->Name = 'Died';
			$fld->ColName = 'ArtArtistRef:' . $i . '->eparties->BioDeathDate';
			$fldarr[] = $fld;

			$fld = new Field;
			$fld->Name = '';
			$fld->ColName = 'ArtArtistRef:' . $i;
			$fld->RawDisplay = 1;
			$fldarr[] = $fld;
		}

		$ref = new Field;
		$ref->ColName = 'RefReferences';
		$ref->RawDisplay = 1;

		$rep = new Field;
		$rep->ColName = 'RefReproductions';
		$rep->RawDisplay = 1;

		$exh = new Field;
		$exh->ColName = 'RefExhibitionHistory';
		$exh->RawDisplay = 1;


		$tmp1 = array(
				'SumTitle',
			);
		$tmp2 = array(
				'SumAccessionNumber',
				'SumDate',
				'SumDepartment',
				'SumSearchCat',
				'ArtMediaCategory',
				'SumMedium',
				'SumSupport',
				'ArtEdition',
				'ArtDimensionsA',
				'ArtDimensionsB',
				'ArtCreditLine',
				//'RefExhibitionHistory',
				$exh,
				//'RefReferences',
				$ref,
				//'RefReproductions',
				$rep,
				'RefAdditionalInformation',
				$note,
				$right
				);
		$this->Fields = array_merge($tmp1, $fldarr, $tmp2);
		$this->ImagesPerRow = 12;

		$this->BaseStandardDisplay();
	}

	function
	adjustData($field, $rec, $fielddata)
	{
		//	var_dump($field->ColName);
		if ($field->Label == '' && $field->Name == '' && (strncmp($field->ColName, 'ArtArtistRef', 12) == 0))
		{
			$fielddata = '&nbsp;';
		}
		if ($field->ColName == 'RefReferences' || $field->ColName == 'RefReproductions' || $field->ColName == 'RefExhibitionHistory')
		{
			$fielddata = htmlspecialchars($fielddata);
			$fielddata = preg_replace('/(http:\/\/www)/', 'www', $fielddata);
			$fielddata = preg_replace('/(www.)/', 'http://www.', $fielddata);
			$fielddata = preg_replace('/(http:\/\/.*?)([\s]|&gt;)/', '<a href="${1}" />${1}</a />${2}', $fielddata);
			$fielddata = preg_replace('/\\r?\\n/', "<br />\n", $fielddata);
		}
		return $fielddata;
	}

	function
	DisplayMedia()
	{
		/*  We are displaying teh start of the page. We show the
		**  media on the left and the title info on the right.
		*/
		print "      <table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
		print " 	<tr align=\"center\" valign=\"middle\">\n"; 

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
		if ($this->SuppressImageBorders)
			$image->ShowBorder = 0;
		$image->BorderColor = $this->BorderColor;
		$image->HighLightColor = $this->BorderColor;
		$image->RefIRN = $this->IRN;
		$image->RefTable = $this->Database;
		$image->UseAbsoluteLinks = $this->UseAbsoluteLinks;
		if ($this->ImageDisplayPage != "")
		{
			$image->ImageDisplayPage = 'QagImageDisplay.php';
		}
		elseif($this->Intranet)
		{
			$image->ImageDisplayPage = 'QagImageDisplay.php';
		}	
		else
		{
			$image->ImageDisplayPage = 'QagImageDisplay.php';
		}
		$image->Show();

		/*  The title will appear on the right. The main field is
		**  the first field in the Fields[] array.
		*/
		print "		 </td>\n";
		print "		  <td valign=\"middle\" width=\"65%\">\n";
		print "		    <b>";
		$mainField = $this->Fields[0]; // The main field is the first one
		PPrint($this->record->$mainField, $this->FontFace, $this->HeaderFontSize, $this->BodyTextColor);
		print "	     </b>\n";

		$notes = $this->record->{'MulMultiMediaRef:1->emultimedia->NotNotes'};
		if ($notes != "")
		{
			print "<tr spacing=4><td valign=top align=left><font size=1>";
			PPrint ($notes, $this->FontFace, '1', $this->BodyTextColor, '', 1);
			print "</td></tr>\n";
			print "<tr height=10></tr>\n";
		}

		$rights = $this->record->{'MulMultiMediaRef:1->emultimedia->DetRights'};
		if ($rights != "")
		{
			// As we're inside of an XSL (style) we always use HEX=dec 169.
			print "<tr><td valign=top align=left><font size=1> &#xA9; ";
			// POD

			PPrint ($rights, $this->FontFace, '1', $this->BodyTextColor, '', 1);
		}

		/*  Now close off the table.
		*/
		print "</td>\n";
		print "		</tr>\n";
		print "	      </table>\n"; 
	}

	function
	display()
	{
		$sess = new QagSession;
		$SessionsWorking = $sess->GetVar("SessionsOn");

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
		if ($SessionsWorking)
		{
			$RList = $sess->GetVar("RList");
		}
		print "<table $widthAttrib cellpadding=\"2\" cellspacing=\"0\" border=\"0\">\n";
		print "<tr><td align=\"left\" width=\"60%\">\n";
		$link = $this->QueryPage;

		if ($this->DisplayNewSearchLink)
		{
			print "&nbsp;<a href=\"$link\">";
			PPrint($this->_STRINGS['NEW SEARCH'], $this->FontFace, $this->FontSize, $this->BodyTextColor);
			print "</a>";
			if ($SessionsWorking && $RList != '')
			{
				PPrint(' | ', $this->FontFace, $this->FontSize, $this->BodyTextColor);
				print "<a href=\"$RList\">";
				PPrint($this->_STRINGS['BACKTORESULTS'], $this->FontFace, $this->FontSize, $this->BodyTextColor);
				print "</a>";
			}
		}
		foreach ($this->OtherDisplayPages as $pagename => $pagelink)
		{
			$link = "$pagelink?irn=" . $this->IRN . "&amp;QueryPage=" . urlencode($this->QueryPage);
			PPrint(' | ', $this->FontFace, $this->FontSize, $this->BodyTextColor);
			print "<a href=\"$link\">";
			PPrint($pagename, $this->FontFace, $this->FontSize, $this->BodyTextColor);
			print "</a>";
		}

		print "</td><td align=\"right\" width=\"40%\">\n";
		$link = "&amp;QueryPage=" . urlencode($this->QueryPage);
		$NextURL = "";
		$PrevURL = "";
		$IrnList = array();
		$curIRN = $this->record->irn_1;
		if ($SessionsWorking)
		{
			$IrnList = $sess->GetVar("IrnList");
			if (isset($IrnList))
				$index = array_search($curIRN, $IrnList);
			if ($index !== FALSE)
			{
				if (isset($IrnList[$index+1]))
				{
					$next = $IrnList[$index+1];
					if (is_numeric($next))
						$NextURL = $_SERVER['PHP_SELF'] . "?irn=$next" . "&$link";
					else
						$NextURL = $next;
				}
				if (isset($IrnList[$index-1]))
				{
					$prev = $IrnList[$index-1];
					if (is_numeric($prev))
						$PrevURL = $_SERVER['PHP_SELF'] . "?irn=$prev" . "&$link";
					else
						$PrevURL = $prev;
				}
			}
		}
		//var_dump($RList);
		//var_dump($IrnList);
		if (!empty($PrevURL))
		{
			if (is_numeric($prev))
			{
				print "&nbsp;<a href=\"$PrevURL\">";
				PPrint($this->_STRINGS['PREVRECORD'], $this->FontFace, $this->FontSize, $this->TextColor);
				print "</a>&nbsp;";
			}
			else
			{
				PPrint('<< ', $this->FontFace, $this->FontSize, $this->TextColor);
				print "&nbsp;<a href=\"$PrevURL\">";
				PPrint($this->_STRINGS['PREVIOUS'], $this->FontFace, $this->FontSize, $this->TextColor);
				print "</a>&nbsp;";
			}
		}
		if (!empty($NextURL))
		{
			if (!empty($PrevURL))
				PPrint('|', $this->FontFace, $this->FontSize, $this->TextColor);
			if (is_numeric($next))
			{
				print "&nbsp;<a href=\"$NextURL\">";
				PPrint($this->_STRINGS['NEXTRECORD'], $this->FontFace, $this->FontSize, $this->TextColor);
				print "</a>&nbsp;";
			}
			else
			{
				print "&nbsp;<a href=\"$NextURL\">";
				PPrint($this->_STRINGS['NEXT'], $this->FontFace, $this->FontSize, $this->TextColor);
				print "</a>&nbsp;";
				PPrint('>> ', $this->FontFace, $this->FontSize, $this->TextColor);
			}
		}



		print "</td></tr>\n";
		print "<tr>\n<td bgcolor=$this->BorderColor colspan=2>\n<b><font face=$this->FontFace color=$this->HeaderTextColor>";
		print $this->record->{$this->HeaderField};
		print "</font></b>\n</td>\n</tr>\n";

		print "<tr><td colspan=\"2\">\n";
		$decorator = new HtmlBoxAndTitle;
		$decorator->BorderColor = $this->BorderColor;
		$decorator->BodyColor = $this->BodyColor;
		$decorator->TitleTextColor = $this->HeaderTextColor;
		$decorator->FontFace = $this->FontFace;
		$decorator->Width = "100%";
		//$decorator->Title = $this->record->{$this->HeaderField};
		$decorator->Border = 0;
		$decorator->Open();

		if ($this->DisplayImage)
			$this->DisplayMedia();

		print "       <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">\n";
		print "<!-- Start Field Content -->\n";

		// Foreach loop on each item in the $this->Fields var
		$i = $fieldNum = 0;
		foreach ($this->Fields as $item)
		{
			$fieldNum++;
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
			$this->_loadBackReferenceField($item);

			if (! $this->SuppressEmptyFields || $this->_hasData($item))
			{
				$i++;
				if ($fieldNum == 1)
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
					print "	  <td width=\"160\"><b>";
					print "<font $bodyTextColorAttrib $fontFaceAttrib $fontSizeAttrib>";
					print $label;
					print "</font></b></td>\n"; 
				}
				else
				{
					print "	  <td>&nbsp;</td>\n";
				}


				print "	  <td>\n";
				$this->adjustOutput($item);
				print "</td>\n";
				print "	</tr>\n";
			}
		}

		
		// Print the extra multimedia
		$firstImage = ($this->DisplayImage) ? 2 : 1;
		if ($this->ShowAllImagesBelow == 1)
			$firstImage = 1;
			
		$hasMedia = isset($this->record->{"MulMultiMediaRef:$firstImage"});
		if ($this->DisplayAllMedia && $hasMedia)
		{
			if ($i % 2 == 0)
				print "	<tr align=\"left\" valign=\"top\">\n";
			else
				print "	<tr $highlightColorAttrib align=\"left\" valign=\"top\">\n";

			// Print field name (This will normally be multimedia)
			if ($this->DisplayLabels)
			{
				print "	  <td width=\"160\"><b><font $bodyTextColorAttrib $fontFaceAttrib $fontSizeAttrib>".
						$this->_STRINGS['MEDIA'] . "</font></b></td>\n"; 
			}

			// Display Images
			print "	  <td>\n";
			print "<!-- Start a table of thumbnails -->\n";
			print "<table border=\"0\" cellpadding=\"3\"><tr>\n";
			$i = $firstImage;
			$imgcount = 0;
			$mmField = "MulMultiMediaRef:$i"; 
			$imgirn = $this->record->$mmField;
			while ($imgirn != '')
			{
				if ($this->ImagesPerRow > 0 && ($imgcount % $this->ImagesPerRow == 0))
					print "</tr><tr>";

				print "<td align=\"center\">";
				$image = new MediaImage;
				$image->Intranet = $this->Intranet;
				$image->IRN = $imgirn;
				$image->BorderColor = $this->BorderColor;
				if ($this->SuppressImageBorders)
					$image->ShowBorder = 0;
				$image->HighLightColor = $this->BorderColor;
				$image->RefIRN = $this->IRN;
				$image->RefTable = $this->Database;
				$image->UseAbsoluteLinks = $this->UseAbsoluteLinks;
				$image->KeepAspectRatio = $this->KeepAssociatedImagesAspectRatio;
				$image->Width = 60;
				$image->Height = 60;
				if ($this->ImageDisplayPage != "")
				{
					$image->ImageDisplayPage = 'QagImageDisplay.php';
				}
				elseif($this->Intranet)
				{
					$image->ImageDisplayPage = 'QagImageDisplay.php';
				}	
				else
				{
					$image->ImageDisplayPage = 'QagImageDisplay.php';
				}
				$image->Show();
				$i++;
				$imgcount++;
				$mmField = "MulMultiMediaRef:$i"; 
				$imgirn = $this->record->$mmField;
				print "</td>";
			}

			print "</tr></table>";
			print "</td></tr>\n";
		}
		print "       </table>\n";
		print "<!-- End Field Content -->\n";

		print "<tr><td align=\"left\">\n";
		$link = $this->QueryPage;

		if ($this->DisplayNewSearchLink)
		{
			print "&nbsp;<a href=\"$link\">";
			PPrint($this->_STRINGS['NEW SEARCH'], $this->FontFace, $this->FontSize, $this->BodyTextColor);
			print "</a>";
			if ($SessionsWorking && $RList != '')
			{
				PPrint(' | ', $this->FontFace, $this->FontSize, $this->BodyTextColor);
				print "<a href=\"$RList\">";
				PPrint($this->_STRINGS['BACKTORESULTS'], $this->FontFace, $this->FontSize, $this->BodyTextColor);
				print "</a>";
			}
		}
		foreach ($this->OtherDisplayPages as $pagename => $pagelink)
		{
			$link = "$pagelink?irn=" . $this->IRN . "&amp;QueryPage=" . urlencode($this->QueryPage);
			PPrint(' | ', $this->FontFace, $this->FontSize, $this->BodyTextColor);
			print "<a href=\"$link\">";
			PPrint($pagename, $this->FontFace, $this->FontSize, $this->BodyTextColor);
			print "</a>";
		}
		print "</td><td align=\"right\">";
		if (!empty($PrevURL))
		{
			if (is_numeric($prev))
			{
				print "&nbsp;<a href=\"$PrevURL\">";
				PPrint($this->_STRINGS['PREVRECORD'], $this->FontFace, $this->FontSize, $this->BodyTextColor);
				print "</a>&nbsp;";
			}
			else
			{
				PPrint('<< ', $this->FontFace, $this->FontSize, $this->TextColor);
				print "&nbsp;<a href=\"$PrevURL\">";
				PPrint($this->_STRINGS['PREVIOUS'], $this->FontFace, $this->FontSize, $this->BodyTextColor);
				print "</a>&nbsp;";
			}
		}
		if (!empty($NextURL))
		{
			if (!empty($PrevURL))
				PPrint('|', $this->FontFace, $this->FontSize, $this->TextColor);
			if (is_numeric($next))
			{
				print "&nbsp;<a href=\"$NextURL\">";
				PPrint($this->_STRINGS['NEXTRECORD'], $this->FontFace, $this->FontSize, $this->BodyTextColor);
				print "</a>&nbsp;";
			}
			else
			{
				print "&nbsp;<a href=\"$NextURL\">";
				PPrint($this->_STRINGS['NEXT'], $this->FontFace, $this->FontSize, $this->BodyTextColor);
				print "</a>&nbsp;";
				PPrint('>> ', $this->FontFace, $this->FontSize, $this->TextColor);
			}
		}

		$decorator->Close();
		print "</td></tr>\n";

		print "</td></tr>";
		print "</table>\n";

	}

}


class
QagPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	QagPartyDisplay()
	{
		// Setup Birth and Death Date fields to be shown on
		//	Party records
		$bioBirthDate = new Field;
		$bioBirthDate->ColName = 'BioBirthDate';
		$bioBirthDate->Label = 'Born';
		$bioBirthDate->ShowCondition = 'NamPartyType = Person';

		$bioDeathDate = new Field;
		$bioDeathDate->ColName = 'BioDeathDate';
		$bioDeathDate->Label = 'Died';
		$bioDeathDate->ShowCondition = 'NamPartyType = Person';
		
		$this->Fields = array(
				'SummaryData',
				'NamTitle',
				'NamFirst',
				'NamMiddle',
				'NamLast',
				'BioBirthPlace',
				'BioDeathPlace',
				$bioBirthDate,
				$bioDeathDate,
				'BioEthnicity',
				'NotNotes',
				);
		$this->Database = 'eparties';

		$this->BaseStandardDisplay();
	}
}
?>
