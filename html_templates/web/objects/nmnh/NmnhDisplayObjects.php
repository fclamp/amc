<?php
/*
**  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (! isset($WEB_ROOT))
{
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
}

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/common/RecordExtractor.php');
require_once ($LIB_DIR  . 'BaseDisplayObjects.php');
require_once ($LIB_DIR  . 'texquery.php');
require_once ($LIB_DIR  . 'media.php');

$GLOBALS['STRINGS_DIR'] = $WEB_ROOT . "/objects/" . $GLOBALS['BACKEND_TYPE'] . "/" . $GLOBALS['DEPARTMENT'] . "/strings/";

//=====================================================================================================
//=====================================================================================================
class
NmnhStandardDisplay extends BaseStandardDisplay
{
        var $KeepAssociatedImagesAspectRatio = 1;

	function
	NmnhStandardDisplay()
	{
		$this->BaseStandardDisplay();

		$this->Database = 'enmnh';
		$this->DisplayImage = 0;
		$this->SuppressEmptyFields = 0;
		$this->SuppressImageBorders = 1;

		$this->BioEventSiteRef = get('BioEventSiteRef', 'ecatalogue', $this->IRN);
	}
	//=============================================================================================
	//=============================================================================================
	function
	Show()
	{
		/*
		**  The Show() method is resposible for sourcing the Language strings
		**  ($this->_STRINGS) and performing the query before calling display().
		*/
		$this->sourceStrings();
		$this->setupSchema();

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
			$this->_buildSelectArray(array('irn', 'SummaryData', 'MulMultiMediaRef_tab', 'AdmPublishWebNoPasswordLocal_tab'));
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
	//=============================================================================================
	//=============================================================================================
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

		print "</td>\n";
		print "</tr><tr><td colspan=\"2\">\n";
		$decorator = new HtmlBoxAndTitle;
		$decorator->BorderColor = $this->BorderColor;
		$decorator->BodyColor = $this->BodyColor;
		$decorator->TitleTextColor = $this->HeaderTextColor;
		$decorator->FontFace = $this->FontFace;
		$decorator->Width = "100%";
		if ($this->OtherHeader != '')
			$decorator->Title = $this->OtherHeader;
		else
			$decorator->Title = $this->record->{$this->HeaderField};
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
			if (isset($item->ValidUsers) && strtolower($item->ValidUsers) != 'all')
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
			$publishField = "AdmPublishWebNoPasswordLocal:$i"; 
			$imgirn = $this->record->$mmField;
			$publish = $this->record->$publishField;
			
			while ($imgirn != '')
			{
				if (strtolower($publish) == "yes")
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
					$image->Width = 90;
					$image->Height = 90;
					if ($this->ImageDisplayPage != "")
					{
						$image->ImageDisplayPage = $this->ImageDisplayPage;
					}
					elseif($this->Intranet)
					{
						$image->ImageDisplayPage = $GLOBALS['INTRANET_DEFAULT_IMAGE_DISPLAY_PAGE'];
					}	
					else
					{
						$image->ImageDisplayPage = $GLOBALS['DEFAULT_IMAGE_DISPLAY_PAGE'];
					}
					$image->Show();
					$imgcount++;
					print "</td>";
				}

				$i++;
				$mmField = "MulMultiMediaRef:$i"; 
				$publishField = "AdmPublishWebNoPasswordLocal:$i"; 
				$imgirn = $this->record->$mmField;
				$publish = $this->record->$publishField;
			}

			print "</tr></table>";
			print "</td></tr>\n";
		}
		print "       </table>\n";
		print "<!-- End Field Content -->\n";

		$decorator->Close();

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

                print "</td></tr>\n";

		print "</td></tr>";
		print "</table>\n";

	}
	//=============================================================================================
	//=============================================================================================
	function
	BuildFieldNumberFormat()
	{
		$field_numbers = '';
                $recordExtractor = new RecordExtractor();
                $recordExtractor->ExtractFields(array('CatOtherNumbersType_tab', 'CatOtherNumbersValue_tab'));

                $other_numbers_types  = $recordExtractor->MultivalueFieldAsArray('CatOtherNumbersType_tab');
                $other_numbers_values = $recordExtractor->MultivalueFieldAsArray('CatOtherNumbersValue_tab');

                for ($i = 0;$i < count($other_numbers_types); $i++)
                {
                        if (strtolower($other_numbers_types[$i]) == "field number") 
                        {
				if (isset($other_numbers_values[$i]) &&
				    $other_numbers_values[$i] != '')
				{
					if ($field_numbers == '')
					{
                				$field_numbers = $other_numbers_values[$i];
					}
					else
					{
                				$field_numbers .= ", " . $other_numbers_values[$i];
					}
				}
                        }
                }
		return $field_numbers;
	}
	//=============================================================================================
	//=============================================================================================
	function
	BuildCommonNameFormat()
	{
		$common_name = '';

                $recordExtractor = new RecordExtractor();
                $recordExtractor->ExtractFields(array('IdeCommonNameLocal_tab'));
                $common_names = $recordExtractor->MultivalueFieldAsArray('IdeCommonNameLocal_tab');
		$common_names = array_unique($common_names);

                foreach ($common_names as $name)
                {
			if (! empty($name))
			{
                        	$common_name .= "$name\n";
			}
                }
		return $common_name;
	}
	//=============================================================================================
	//=============================================================================================
	function
	BuildCatalogNumberFormat($prefix_delim = '', $suffix_delim = '-')
	{
		$catalog_number = '';

		if (filled('CatPrefix', 'ecatalogue', $this->IRN))
		{
			$catalog_number .= '{CatPrefix}';
		}
		if (filled('CatNumber', 'ecatalogue', $this->IRN))
		{
			if (! empty($catalog_number))
			{
				$catalog_number .= $prefix_delim . '{CatNumber}';
			}
			else
			{
				$catalog_number .= '{CatNumber}';
			}
		}
		if (filled('CatSuffix', 'ecatalogue', $this->IRN))
		{
			if (! empty($catalog_number))
			{
				$catalog_number .= $suffix_delim . '{CatSuffix}';
			}
			else
			{
				$catalog_number .= '{CatSuffix}';
			}
		}
		return $catalog_number;
	}
	//=============================================================================================
	//=============================================================================================
	function
	BuildDepthFormat()
	{
		$depth = '';

		if (! empty($this->BioEventSiteRef))
		{
			$depth_from_met = '';
			$depth_to_met = '';

			$depth_from_met = get('AquDepthFromMet', 'ecollectionevents', $this->BioEventSiteRef);
			$depth_to_met = get('AquDepthToMet', 'ecollectionevents', $this->BioEventSiteRef);

			if ($depth_from_met != '' || 
			    $depth_to_met != '')
			{
				if ($depth_from_met != '' &&
				    $depth_to_met != '')
				{
					$depth = '{BioEventSiteRef->ecollectionevents->AquDepthFromMet}'; 
					if ($depth_from_met != $depth_to_met)
					{
						$depth .= ' - ';
						$depth .= '{BioEventSiteRef->ecollectionevents->AquDepthToMet}';
					}
				}
				else if ($depth_from_met != '')
				{
					$depth = '{BioEventSiteRef->ecollectionevents->AquDepthFromMet}'; 
				}
				else
				{
					$depth = '{BioEventSiteRef->ecollectionevents->AquDepthToMet}';
				}
			}
		}
		return $depth;
	}
	//=============================================================================================
	//=============================================================================================
	function
	BuildElevationFormat()
	{
		$elevation = '';

		if (! empty($this->BioEventSiteRef))
		{
			$elevation_from_flag = '';
			$elevation_to_flag = '';
			$elevation_from_flag = get('TerElevationFromOrig', 'ecollectionevents', $this->BioEventSiteRef);
			$elevation_to_flag = get('TerElevationToOrig', 'ecollectionevents', $this->BioEventSiteRef);

			if ($elevation_from_flag != '' ||
			    $elevation_to_flag != '')
			{
				$elevation_from = '';
				$elevation_to = '';
				$elevation_unit = '';
				$elevation_from_mod = get('TerElevationFromModifier', 'ecollectionevents', $this->BioEventSiteRef);
				$elevation_to_mod = get('TerElevationToModifier', 'ecollectionevents', $this->BioEventSiteRef);

				if ($elevation_from_flag != '')
				{
					if ($elevation_from_flag)
					{
						$elevation_from = get('TerElevationFromFt', 'ecollectionevents', $this->BioEventSiteRef);
						$elevation_unit = 'ft';	
					}
					else
					{
						$elevation_from = get('TerElevationFromMet', 'ecollectionevents', $this->BioEventSiteRef);
						$elevation_unit = 'm';	
					}

					if ($elevation_from_mod != '')
					{
						$elevation_from = "$elevation_from_mod $elevation_from";
					}
				}

				if ($elevation_to != '')
				{
					if ($elevation_to_flag)
					{
						$elevation_to = get('TerElevationToFt', 'ecollectionevents', $this->BioEventSiteRef);
						if (empty($elevation_unit))
						{
							$elevation_unit = 'ft';
						}
					}
					else
					{
						$elevation_to = get('TerElevationToMet', 'ecollectionevents', $this->BioEventSiteRef);
						if (empty($elevation_unit))
						{
							$elevation_unit = 'm';
						}
					}
					if ($elevation_to_mod != '')
					{
						$elevation_to = "$elevation_to_mod $elevation_to";
					}
				}

				if ($elevation_from == $elevation_to)
				{
					$elevation_to = '';
				}
			
				if (! empty($elevation_from) &&
				    ! empty($elevation_to))
				{
					$elevation = $elevation_from;
					$elevation .= " - ";
					$elevation .= $elevation_to;
					$elevation .= " " . $elevation_unit;
				}
				else if (! empty($elevation_from) &&
				         empty($elevation_to))
				{
					$elevation = $elevation_from;
					$elevation .= " " . $elevation_unit;
				}
				else if (empty($elevation_from) &&
				         ! empty($elevation_to))
				{
					$elevation = $elevation_to;
					$elevation .= " " . $elevation_unit;
				}
			}
		}
		return $elevation;
	}
	//=============================================================================================
	//=============================================================================================
	function
	BuildDateCollectedFormat()
	{
		$format = '';

		if (! empty($this->BioEventSiteRef))
		{
			$dateVisitedFrom = get('ColDateVisitedFrom', 'ecollectionevents', $this->BioEventSiteRef);
			$dateVisitedTo = get('ColDateVisitedTo', 'ecollectionevents', $this->BioEventSiteRef);
			$dateVisitedConj = get('ColDateVisitedConjunction', 'ecollectionevents', $this->BioEventSiteRef);

			if (! empty($dateVisitedFrom))
			{
                		if (! empty($dateVisitedFrom) && 
				    ! empty($dateVisitedTo)   && 
				    ! empty($dateVisitedConj))
                		{
					$format = $dateVisitedFrom;

					if ($dateVisitedFrom != $dateVisitedTo)
					{
						$format .= ' ' . $dateVisitedConj;
						$format .= ' ' . $dateVisitedTo;
					}
				}
				else if (! empty($dateVisitedFrom) &&
				         ! empty($dateVisitedTo))
				{
					$format = $dateVisitedFrom;

					if ($dateVisitedFrom != $dateVisitedTo)
					{
						$format .= ' - ' . $dateVisitedTo;
					}
				}
				else if (! empty($dateVisitedFrom))
				{
					$format = $dateVisitedFrom;
				}
			}
		}
		return $format;
	}
	//=============================================================================================
	//=============================================================================================
	function
	BuildNotesFormat($use_web_flag, $allowed_types, $restricted_types)
	{
		$notes = '';

                $recordExtractor = new RecordExtractor();
                $recordExtractor->ExtractFields(array('NotNmnhText0', 'NotNmnhType_tab', 'NotNmnhWeb_tab'));

                $notes_text = $recordExtractor->MultivalueFieldAsArray('NotNmnhText0');
                $notes_type = $recordExtractor->MultivalueFieldAsArray('NotNmnhType_tab');
                $notes_web = $recordExtractor->MultivalueFieldAsArray('NotNmnhWeb_tab');

		if ($use_web_flag)
		{
			for ($i = 0;$i < count($notes_text); $i++)
			{
				if (strtolower($notes_web[$i]) == 'yes' ||
				    strtolower($notes_type[$i]) == 'web display')
				{
					$notes .= $notes_text[$i] . "\n";
				}
			}
		}
		else
		{
			if (! empty($allowed_types))
			{
				$pattern = implode('|', $allowed_types);

				for ($i = 0;$i < count($notes_text); $i++)
				{
					if (preg_match("/(:?$pattern)/i", $notes_type[$i]))
					{
						$notes .= $notes_text[$i] . "\n";
					}
				}
			}
			else if (! empty($restricted_types))
			{
				$pattern = implode('|', $restricted_types);

				for ($i = 0;$i < count($notes_text); $i++)
				{
					if (! preg_match("/(:?$pattern)/i", $notes_type[$i]))
					{
						$notes .= $notes_text[$i] . "\n";
					}
				}
			}
		}
		return $notes;
	}
	//=============================================================================================
	//=============================================================================================
	function
	BuildRawTypeCitationFormat()
	{
                $recordExtractor = new RecordExtractor();
                $recordExtractor->ExtractFields(array('WebTaxonRef_tab'));

                $webTaxRef = $recordExtractor->MultivalueFieldAsArray('WebTaxonRef_tab');
		$webTaxRefUniq = array_unique($webTaxRef);
		
		$webTaxRefSeen = array();
		$citationArray = array();

		$font = "font face=Arial size=2 color=#013567";

		if (count($webTaxRefUniq) < count($webTaxRef))
		{
			$n = 1;
			$webTaxRefCount = count($webTaxRef);
			for ($i = 1;$i <= $webTaxRefCount; $i++)
			{
				$webTaxRefCurrent = array_shift($webTaxRef);
				$scientificName = get('ClaScientificName', 'etaxonomy', $webTaxRefCurrent);
				$typeStatus = get('WebTypeStatus:' . $i, 'ecatalogue', $this->IRN);

				if (in_array($webTaxRefCurrent, $webTaxRef) ||
				    in_array($webTaxRefCurrent, $webTaxRefSeen))
				{
                        		$citation = get('CitCitedInRef:' . $n . '->ebibliography->SummaryData', 'etaxonomy', $webTaxRefCurrent);
					$citation = "<td><$font>$citation</font></td>";
					$n++;
				}
				else
				{
					$recordExtractor->Database = 'etaxonomy';
					$recordExtractor->Where = 'irn = ' . $webTaxRefCurrent;
                			$recordExtractor->ExtractFields(array('CitCitedInRef_tab->ebibliography->SummaryData'));

					$citArray = $recordExtractor->MultivalueFieldAsArray('CitCitedInRef_tab->ebibliography->SummaryData');
					$citation = '';

					foreach ($citArray as $citValue)
					{
						if (! empty($citation))
						{
							$citation .= "\n</tr>\n<tr>\n\t<td></td>\n\t<td></td>\n\t<td><$font>$citValue</font></td>";
						}
						else
						{
							$citation = "<td><$font>$citValue</font></td>";
						}
					}
				}
				$scientificName = "<td><$font>$scientificName</font></td>";
				$typeStatus = "<td><$font>$typeStatus</font></td>";
				array_push($citationArray, "\n\t$scientificName\n\t$typeStatus\n\t$citation");
				array_push($webTaxRefSeen, $webTaxRefCurrent);
			}
		}
		else
		{
			for ($i = 0;$i < count($webTaxRef); $i++)
			{
				$scientificName = get('ClaScientificName', 'etaxonomy', $webTaxRef[$i]);
				$typeStatus = get('WebTypeStatus:' . ($i + 1), 'ecatalogue', $this->IRN);

				$recordExtractor->Database = 'etaxonomy';
				$recordExtractor->Where = 'irn=' . $webTaxRef[$i];
                		$recordExtractor->ExtractFields(array('CitCitedInRef_tab->ebibliography->SummaryData'));

				$citArray = $recordExtractor->MultivalueFieldAsArray('CitCitedInRef_tab->ebibliography->SummaryData');
				$citation = "";
				foreach ($citArray as $citValue)
				{
					if (! empty($citation))
					{
						$citation .= "\n</tr>\n<tr>\n\t<td></td>\n\t<td></td>\n\t<td><$font>$citValue</font></td>";
					}
					else
					{
						$citation = "<td><$font>$citValue</font></td>";
					}
				}
				$scientificName = "<td><$font>$scientificName</font></td>";
				$typeStatus = "<td><$font>$typeStatus</font></td>";
				array_push($citationArray, "\n\t$scientificName\n\t$typeStatus\n\t$citation");
			}
		}

		$format = '';
		if ($citationArray)
		{
			$format .= "\n<!-- Start Sub Table -->\n";
			$format .= "<table border=0 cellpadding=1 cellspacing=0 width=100%>\n";
			$format .= "<tr>\n";
			$format .= "\t<td></td>\n";
			$format .= "\t<td><b><$font>Type Status</font></b></td>\n";
			$format .= "\t<td><b><$font>Citation</font></b></td>\n";
			$format .= "</tr>\n";
			foreach ($citationArray as $cit)
			{
				$format .= "<tr>$cit\n</tr>\n";
			}
			$format .= "</table>\n";
			$format .= "<!-- End Sub Table -->\n";
		}
		return $format;
	}
}
//=====================================================================================================
//=====================================================================================================
function
filled($column, $db, $irn)
{
        $qry = new ConfiguredQuery();
        $qry->Select = array($column);
        $qry->From = "$db";
        $qry->Where = "irn=" . $irn;
        $records = $qry->Fetch();

        $data = "";
        $data = $records[0]->{"$column"};

        if ($data != "")
                return 1;
        else
                return 0;
}
//=====================================================================================================
//=====================================================================================================
function
get($column, $db, $irn)
{
        $qry = new ConfiguredQuery();
        $qry->Select = array($column);
        $qry->From = "$db";
        $qry->Where = "irn=" . $irn;
        $records = $qry->Fetch();

        $data = $records[0]->{"$column"};
        return $data;
}
//=====================================================================================================
//=====================================================================================================
function
getColArray($column, $db, $irn)
{
        $qry = new ConfiguredQuery();
        $qry->Select = array($column);
        $qry->From = "$db";
        $qry->Where = "irn=" . $irn;
        $records = $qry->Fetch();
	
	if (! isset($records[0]))
	{
		return array();
	}
	return $records[0];
}
//=====================================================================================================
//=====================================================================================================
?>
