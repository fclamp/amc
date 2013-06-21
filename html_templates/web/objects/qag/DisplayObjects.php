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
		for($i=1; $i<21; $i++)
		{
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->NamFirst';
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->NamLast';
			$fldarr[] = 'ArtArtistRole:' . $i;
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->BioEthnicity';
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->BioNationality';
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->BioBirthDate';
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->BioDeathDate';
		}

		$tmp1 = array(	'SumTitle',
				'SumDate',
				'SumMedium',
				'SumSupport',
				'ArtEdition',
				'ArtDimensionsA',
				'ArtDimensionsB',
				'SumAccessionNumber',
				'ArtCreditLine',
				'RefExhibitionHistory',
				'RefReferences',
				'RefAdditionalInformation',
				'MulMultiMediaRef:1->emultimedia->DetRights',
				'MulMultiMediaRef:1->emultimedia->NotNotes'
			);

		$this->Fields = array_merge($fldarr, $tmp1);
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
		$view = $_GET['view'];

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

		$notes = $this->record->{'MulMultiMediaRef:1->emultimedia->NotNotes'};
		if ($notes != "")
		{
			print "<font size=1>";
                        PPrint ($notes, $this->FontFace, '1', $this->BodyTextColor, '', 1);
			print "<br /><br />";
		}

		$rights = $this->record->{'MulMultiMediaRef:1->emultimedia->DetRights'};
		if ($rights != "")
		{
			print "<font size=1> &#xA9;&nbsp;";
			PPrint ($rights, $this->FontFace, '1', $this->BodyTextColor, '', 1);
		}

		/*  The title will appear on the right. The main field is
		**  the first field in the Fields[] array.
		*/
		print "		 </td>\n";
		print "		  <td valign=\"middle\" width=\"65%\">\n";

		$rec = $this->record;
		$hasTitle = 0;
		$hasMedium = 0;

		// Find out how many coloums (one extra for image coloum)
		$numcol = count($this->Fields) + 1;

			print "<!--START RECORD-->\n";

			// Display Other Fields
			for ($j = 0; $j < $numcol - 1; $j++)
			{
				$fieldData = '';

				if (is_string($this->Fields[$j]))
				{
					$fieldData = $rec->{$this->Fields[$j]};
				}
				elseif (strtolower(get_class($this->Fields[$j])) == 'formatfield')
				{
					$field = $this->Fields[$j]->Format;
					$fieldData = preg_replace('/{([{^}]*)}/e', ' $rec->{"\\1"}', $field);
				}
				$fieldData = $this->adjustData($this->Fields[$j], $rec, $fieldData);

				$printstring = '';
				if (preg_match('/NamLast/', $this->Fields[$j]) == 1)
				{
					$last = $j;
					$first = $j-1;
					$printstring = $rec->{$this->Fields[$last]};
					if ($rec->{$this->Fields[$first]} != '')
					{
						if ($printstring != '')
						{
							$printstring .= ', ';
						}
						$printstring .= $rec->{$this->Fields[$first]};
					}
					$fieldData = $printstring;
				}
				elseif (preg_match('/BioDeathDate/', $this->Fields[$j]) == 1)
				{
					$deathdate = $j;
					$birthdate = $j-1;
					$nationality = $j-2;

					if ($rec->{$this->Fields[$nationality]} != '')
					{
						$printstring = $rec->{$this->Fields[$nationality]} . '&nbsp;';
					}
					if ($rec->{$this->Fields[$birthdate]} != '')
					{
						if ($printstring != '')
						{
							$printstring .= '&nbsp;';
						}
						$printstring .= 'b.' . $rec->{$this->Fields[$birthdate]};
					}
					if ($rec->{$this->Fields[$deathdate]} != '')
					{
						if ($printstring != '')
						{
							$printstring .= '&nbsp;';
						}
						$printstring .= 'd.' . $rec->{$this->Fields[$deathdate]};
					}
					$fieldData = $printstring;
				}
				elseif (preg_match('/RefAdditionalInformation/', $this->Fields[$j]) ==1)
				{
					if ($view == 'More')
					{
						$query = new Query;
						$query->Texql = "select NarNarrative " .
							"from enarratives where exists(ObjObjectsRef_tab where (ObjObjectsRef = $this->IRN))" .
							"and AdmPublishWebNoPassword contains 'Yes'";
						$result = $query->Fetch();
						$size = sizeof($result);

						if ($size > 0)
						{
							print "<br \>\n";
							print "<b>Additional information</b>";

							for ($k = 0; $k < $size; $k++)
							{
								$fieldData = $result[$k]->{"NarNarrative"};
								$fieldData = preg_replace('/<[Ff].*?>|<\/[Ff].*?>|<SPAN.*?>|<\/SPAN.*?>/', "", $fieldData);

								if ($fieldData != '')
								{
									print "<br \>\n";
									print "$fieldData";
								}
							}
						}
						else
						{
							$fieldData = '';
						}
					}
					else
					{
						$fieldData = '';
					}
				}
				elseif ($fieldData == '' 
					|| (preg_match('/BioNationality/', $this->Fields[$j]) == 1) 
					|| (preg_match('/NamFirst/', $this->Fields[$j]) == 1) 
					|| (preg_match('/BioBirthDate/', $this->Fields[$j]) == 1)
					|| (preg_match('/MulMultiMedia/', $this->Fields[$j]) == 1)
					|| ($view != 'More' && ((preg_match('/RefExhibitionHistory/', $this->Fields[$j]) == 1)
					|| (preg_match('/RefReferences/', $this->Fields[$j]) == 1)))
					)
				{
					continue;
				}

				if ($fieldData != '')
				{
					$fieldData = preg_replace('/\\r?\\n/', "<br />\n", $fieldData);

					if (preg_match('/SumAccessionNumber/', $this->Fields[$j]) == 1)
					{
						print "<br \>\n";						
						print "Acc. $fieldData";
					}
					elseif (preg_match('/SumTitle/', $this->Fields[$j]) == 1)
					{
						$hasTitle = 1;
						print "<br \>\n";
						print "<i>$fieldData</i>&nbsp;&nbsp;";
					}
					elseif (preg_match('/Nam/', $this->Fields[$j]) ==1)
					{
						print "<br \>\n";
						print "<b>$fieldData</b>";
					}
					elseif (preg_match('/SumMedium/', $this->Fields[$j]) ==1)
					{
						$hasMedium = 1; 
						print "<br \>\n";
						print "$fieldData&nbsp;";
					}
					elseif (preg_match('/SumDate/', $this->Fields[$j]) ==1)
					{
						if ($hasTitle == 1)
						{
							print "$fieldData";
						}
						else
						{
							print "<br \>\n";
							print "$fieldData";
						}
					}
					elseif (preg_match('/SumSupport/', $this->Fields[$j]) ==1)
					{
						If ($hasMedium == 1)
						{
							print "$fieldData";
						}
						else
						{
							print "<br \>\n";
							print "$fieldData";
						}
					}
					elseif (preg_match('/RefExhibitionHistory/', $this->Fields[$j]) ==1)
					{
						print "<br \>\n";
						print "<b>Exhibition history</b>";
						print "<br \>\n";
						print "$fieldData";
					}
					elseif (preg_match('/RefReferences/', $this->Fields[$j]) ==1)
					{
						print "<br \>\n";
						print "<b>References</b>";
						print "<br \>\n";
						print "$fieldData";
					}
					else
					{
						print "<br \>\n";
						print "$fieldData";
					}

					//print "<br \>\n";
				}
			}
			print "<br \>\n";

			print "  <!--END RECORD-->\n";

		/*  Now close off the table.
		*/
		print "	      </table>\n"; 
	}

	function
	display()
	{	
		$view = $_GET['view'];

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

		print "</td><td align=\"right\">\n";
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


		print "</td></tr><tr><td colspan=\"2\">\n";
		$decorator = new HtmlBoxAndTitle;
		$decorator->BorderColor = $this->BorderColor;
		$decorator->BodyColor = $this->BodyColor;
		$decorator->TitleTextColor = $this->HeaderTextColor;
		$decorator->FontFace = $this->FontFace;
		$decorator->Width = "100%";
		//$decorator->Title = $this->record->{$this->HeaderField};
		$decorator->Border = 0;
		$decorator->ImageAlign = "top";
		$decorator->Open();

		print "<br /><br />\n";

		if ($this->DisplayImage)
			$this->DisplayMedia();

		print "       <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">\n";
		print "<!-- Start Field Content -->\n";

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
						/*$this->_STRINGS['MEDIA'] .*/ "</font></b></td>\n"; 
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
		print "</td><td align=\"right\">";

		if ($view == 'More')
		{
			$link = "$pagelink?irn=" . $this->IRN . "&amp;QueryPage=" . urlencode($this->QueryPage);
			print "&nbsp;<a href=\"$link\">";
			PPrint("Less information", $this->FontFace, $this->FontSize, $this->BodyTextColor);
		}
		else
		{
			$link = "$pagelink?irn=" . $this->IRN . "&amp;QueryPage=" . urlencode($this->QueryPage) . "&amp;view=More";
			print "&nbsp;<a href=\"$link\">";
			PPrint("More information", $this->FontFace, $this->FontSize, $this->BodyTextColor);
		}
		print "</a>&nbsp;";

		$hasMultimedia = $this->record->{'MulMultiMediaRef:1'};
		if ($hasMultimedia != '')
		{
			$image = "QagImageDisplay.php?irn=" . $hasMultimedia . "&amp;reftable=" . $this->Database . "&amp;refirn=" . $this->IRN;
			PPrint(' | ', $this->FontFace, $this->FontSize, $this->BodyTextColor);
			print "<a href=\"$image\">";
			PPrint("Enlarge image", $this->FontFace, $this->FontSize, $this->BodyTextColor);
			print "</a>";
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
