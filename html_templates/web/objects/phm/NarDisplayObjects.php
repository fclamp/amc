<?php

/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

/** 
 * Created By: Martin Jujou
 * Creation Date: 09/12/2004
 */


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/phm/phmconfiguredquery.php');
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');
require_once ($WEB_ROOT . '/objects/common/PreConfiguredQuery.php');


// displays narrative information
class
NarPhmMasterDisplay extends BaseStandardDisplay
{

	// Set default in the constructor
	function
	NarPhmMasterDisplay()
	{
		// links to associated objects
		$objects = new Field;
		$objects->Database = "enarratives";
		$objects->Field = "SpecialObjectLink";
		$objects->ColName = "irn_1";
		$objects->LinksTo = "NarDisplayObject.php";

		// object table
		$objTable = new Table();
		$objTable->Name = "Associated Objects:";
		$objTable->Columns = array($objects);

		// sub narratives
		$sub = new Field;
		$sub->Database = "enarratives";
		$sub->Field = "SummaryData";
		$sub->ColName = "irn_1"; 

		// narrative table
		$narTable = new Table();
		$narTable->Name = "Sub Narratives:";
		$narTable->Columns = array($sub);

		

		$this->Fields = array(

				'NarTitle',
				'NarNarrative',
				$narTable,
				$objTable,

				);


		$this->HeaderField = 'SummaryData';
		$this->BaseStandardDisplay();
		$this->Database = 'enarratives';

	}


	


	function
	_printTable($table)
	{
		if (strtolower(get_class($table)) != 'table')
			return;
		elseIf( ! $this->_tableHasData($table, 1) )
			return;

		$flag = 1;
		$row = 1;
		$search = "";
		$masterIrn = "";
		$searchType = "";

		while(1)
		{
			if (! $this->_tableHasData($table, $row))
				break;
			if ($row == 1)
			{
				for($i = 0; $i < count($table->Columns); $i++)
				{
					if (isset($table->Headings[$i]))
						$heading = $table->Headings[$i];
					else
						$heading = $this->_STRINGS[$table->Columns[$i]->ColName];


				}
			}

			foreach ($table->Columns as $col)
			{

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

					
					if($col->ColName == "irn_1")
					{
						if($col->ColName == "irn_1" && $col->Field == "SpecialObjectLink")
						{
							$searchType = "object";
							$fielddata = $this->record->{$col->ColName};
							$masterIrn = $fielddata;
						}
						else
						{  
							$searchType = "narrative";
							$fielddata = $this->record->{$col->ColName};
							$search .= "(AssMasterNarrativeRef = " . $fielddata . ")";
						}
						
					}
					break;
				    case 'table':
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
					break;
				}

			}


			$row++;
		}

		if($searchType == "object")
		{

			$link = new PreConfiguredQueryLink;
			$link->LimitPerPage = 20;
			$link->LinkText = 'Click here to list all Objects attached to Sub Narratives';
			$link->ResultsListPage = "NarResultsListNarrativeObjects.php";
			$link->Where = 'AssMasterNarrativeRef=' . $masterIrn;
			
			print '<a href="' . $link->generateRef() . '&narTitle=' . 
			urlencode($this->record->{NarTitle}) . '&theMasterIrn=' . urlencode($masterIrn) . '">';
			print '<font color="#666666" face="Verdana" size="' . $this->FontSize . '">';
			print $link->LinkText;
			print '</font></a>';
		

		}
		elseif($searchType == "narrative")
		{
			$link = new PreConfiguredQueryLink;
			$link->LimitPerPage = 20;
			$link->LinkText = 'Click here to list Sub Narratives';
			$link->ResultsListPage = "NarResultsList.php";
			$link->Where = $search; 

			print '<a href="' . $link->generateRef() . '">';
			print '<font color="#666666" face="Verdana" size="' . $this->FontSize . '">';
			print $link->LinkText;
			print '</font></a>';
		}

	}
	
}


// displays narrative information
class
NarPhmStandardDisplay extends BaseStandardDisplay
{

	// Set default in the constructor
	function
	NarPhmStandardDisplay()
	{
		// associated narratives
		/*
		$ass = new BackReferenceField;
		$ass->RefDatabase = "enarratives";
		$ass->RefField = "AssAssociatedWithRef_tab";
		$ass->ColName = "irn_1";
		$ass->Label = "Sub Narratives:";
		$ass->LinksTo = "NarDisplay.php";
		*/

		// links to authors
		$ass = new Field;
		$ass->Database = "enarratives";
		$ass->Field = "SummaryData";
		$ass->ColName = "irn_1";



		// narrative table
		$narTable = new Table();
		$narTable->Name = "Sub Narratives:";
		$narTable->Columns = array($ass);


		// master narrative
		$master = new BackReferenceField;
		$master->RefDatabase = "enarratives";
		$master->RefField = "AssAssociatedWithRef_tab";
		$master->ColName = "SummaryData";
		$master->Label = "Master Narrative:";
		$master->LinksTo = "NarDisplay.php";


		// links to authors
		$authors = new Field;
		$authors->Database = "eparties";
		$authors->Field = "SummaryData";
		$authors->Label = "Related Authors:";
		$authors->ColName = "NarAuthorsRef_tab->eparties->SummaryData";
		$authors->LinksTo = "NarDisplayParty.php";



		// links to parties 
		$parties = new Field;
		$parties->Database = "eparties";
		$parties->Field = "SummaryData";
		$parties->ColName = "ParPartiesRef_tab->eparties->SummaryData";
		$parties->LinksTo = "NarDisplayParty.php";



		// links to associated objects 	
		$objects = new Field;
		$objects->Database = "ecatalogue";
		$objects->Field = "SummaryData";
		$objects->ColName = "ObjObjectsRef_tab->ecatalogue->irn_1";
		$objects->LinksTo = "NarDisplayObject.php";



		// related module table
		$modTable = new Table();
		$modTable->Name = "Associated Modules:";
		$modTable->Headings = array("Related Parties", "Related Objects");
		$modTable->Columns = array($parties, $objects); 


		// object table
		$objTable = new Table();
		$objTable->Name = "Associated Objects:";
		$objTable->Columns = array($objects);



		$this->Fields = array(

				'NarTitle',
				'NarNarrative',
				$master,
				$narTable,
				$objTable,

				);


		$this->HeaderField = 'SummaryData';
		$this->BaseStandardDisplay();
		$this->Database = 'enarratives';

	}


	function
	_printTable($table)
	{
		if (strtolower(get_class($table)) != 'table')
			return;
		elseIf( ! $this->_tableHasData($table, 1) )
			return;

		$flag = 1;
		$row = 1;
		$search = "";
		$searchType = "";

		while(1)
		{
			if (! $this->_tableHasData($table, $row))
				break;
			if ($row == 1)
			{
				for($i = 0; $i < count($table->Columns); $i++)
				{
					if (isset($table->Headings[$i]))
						$heading = $table->Headings[$i];
					else
						$heading = $this->_STRINGS[$table->Columns[$i]->ColName];
				}
			}

			foreach ($table->Columns as $col)
			{

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
                    
					if(preg_match('/ecatalogue->irn_1/', $col->ColName))
					{
						$searchType = "object";
						$fielddata = $this->record->{$col->ColName};

						if($flag == 1)
						{
							$search .= "(irn = " . $fielddata . ")";
							$flag  = 0;
						}
						else
						{
							$search .= " or (irn = " . $fielddata . ")";
						}

					}
					elseif($col->ColName == "irn_1")
					{
						$searchType = "narrative";
						$fielddata = $this->record->{$col->ColName};

						if($flag == 1)
						{
							$search .= 
							"(AssMasterNarrativeRef = " . $fielddata . ")";
						}
						else
						{
							$search .=
							" or (AssMasterNarrativeRef = " . $fielddata . ")"; 
						}
					}
					
					break;
				    case 'table':
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
					break;
				}

			}


			$row++;
		}

		if($searchType == "object")
		{
			$link = new PreConfiguredQueryLink;
			$link->LimitPerPage = 20;
			$link->LinkText = 'Click here to list Objects';
			$link->ResultsListPage = "NarResultsListObject.php";
			$link->Where = $search; 
            
			//print '<a href="' . $link->generateRef() . '&narTitle=' . urlencode($this->record->{NarTitle}) . 
			//'&narIrn=' . urlencode($this->record->{irn_1}) . '" onClick="makeRequest();">Stuff</a> ';

			print '<a href="#" onClick="makeRequest();">'; 
			print '<font color="#666666" face="Verdana" size="' . $this->FontSize . '">';
			print $link->LinkText;
			print '</font></a>';

			$generated = preg_split("/&amp;/", urldecode($link->generateRef()) );
			$generated[0] = str_replace("NarResultsListObject.php?Where=", "", $generated[0]);
			$generated[1] = str_replace("QueryPage=", "", $generated[1]);
			$generated[2] = str_replace("LimitPerPage=", "", $generated[2]);
			
			// print the hidden variable
			print "\n";
			print "<input type='hidden' name='Where' value='" . $generated[0] . "'>\n";
			print "<input type='hidden' name='QueryPage' value='" . $generated[1] . "'>\n";
			print "<input type='hidden' name='LimitPerPage' value='" . $generated[2] . "'>\n";
			print "<input type='hidden' name='narTitle' value='" . $this->record->{NarTitle} . "'>\n";
			print "<input type='hidden' name='narIrn' value='" . $this->record->{irn_1} . "'>\n";
		}
		elseif($searchType == "narrative")
		{
			$link = new PreConfiguredQueryLink;
			$link->LimitPerPage = 20;
			$link->LinkText = 'Click here to list Sub Narratives';
			$link->ResultsListPage = "NarResultsList.php";
			$link->Where = $search; 


			print '<a href="' . $link->generateRef() . '">';
			print '<font color="#666666" face="Verdana" size="' . $this->FontSize . '">';
			print $link->LinkText;
			print '</font></a>';
		}
	}

	// this is needed to be overwritten because we need to add the new form with hidden values 
	// the whole table will be wrapped in a form 
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
		$decorator->Title = $this->record->{$this->HeaderField};
		$decorator->Open();

		if ($this->DisplayImage)
			$this->DisplayMedia();
		
		// this is needed for dynamic javascript functionality 
		//print "<form method=POST action='/emuwebphm/objects/phm/test.php'>\n";
		print "<form method=POST action='NarResultsListObject.php'>\n";

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

		// end the form for javascript 
		print "</form>\n";

		$decorator->Close();
		print "</td></tr>";
		print "</table>\n";

	}

	// this is overwritten because we need to use different version of the texquery.php file 
	// for optimisation purposes (which can be applied to phm only)  
	// the only difference is the fact that its calling a different configured query object
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
			$this->_buildSelectArray(array('irn', 'SummaryData', 'MulMultiMediaRef_tab'));
		}
		$this->_buildSelectArray($this->Fields);
		$this->_buildSelectArray($this->AdditionalFields);

		if (count($this->AdditionalFields) > 0)
		{
			$this->Fields = array_merge($this->Fields, $this->AdditionalFields);
		}

		$qry = new PhmConfiguredQuery;
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


// displays object
class
NarPhmObjectDisplay extends BaseStandardDisplay 
{

	function
	NarPhmObjectDisplay()
	{

		// dimensions height 
		$height = new Field;
		$height->Database = "ecatalogue";
		$height->ColName = "DimHeight_tab";


		// dimensions length
		$length = new Field;
		$length->Database = "ecatalogue";
		$length->ColName = "DimLength_tab";

		// dimensions width 
		$width = new Field;
		$width->Database = "ecatalogue";
		$width->ColName = "DimWidth_tab";

		// dimensions depth 
		$depth = new Field;
		$depth->Database = "ecatalogue";
		$depth->ColName = "DimDepth_tab";

		// dimensions diameter 
		$diameter = new Field;
		$diameter->Database = "ecatalogue";
		$diameter->ColName = "DimDiameter_tab";

		// dimensions unit length 
		$ulength = new Field;
		$ulength->Database = "ecatalogue";
		$ulength->ColName = "DimUnitLength_tab";
		
		// dimensions weight 
		$weight = new Field;
		$weight->Database = "ecatalogue";
		$weight->ColName = "DimWeight_tab";


		// dimensions unit weight 
		$uweight = new Field;
		$uweight->Database = "ecatalogue";
		$uweight->ColName = "DimUnitWeight_tab";


		// dimensions type 
		$type = new Field;
		$type->Database = "ecatalogue";
		$type->ColName = "DimType_tab";

		
		$dimTable = new Table();
		$dimTable->Name = "Dimensions:";
		$dimTable->Headings = array("Height", "Length", "Width", "Depth", "Diameter", 
		"Unit Length", "Weight", "Unit Weight", "Type");
		$dimTable->Columns = array($height, $length, $width, 
		$depth, $diameter, $ulength, $weight, $uweight, $type);


		// associated events 
		$events = new BackReferenceField;
		$events->RefDatabase = "eevents";
		$events->RefField = "ObjAttachedObjectsRef_tab";
		$events->ColName = "SummaryData";
		$events->Label = "Events:";


		$this->Fields = array(

				'DesObjectStatement',
				'SumRegistrationNumber',
				'DesDescription',
				'DesMarks',
				'AccAccessionLotRef->eaccessionlots->AcqCreditLine',
				$dimTable,
				DimNotes, 
				HisHistoryNotes, 
				ProProductionNotes, 
				SigStatement, 
				ArcAdministrativeHistory,
				$events,

				);


		$this->HeaderField = 'SummaryData';
		$this->BaseStandardDisplay();
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
					print "<td size='1'><b>";


					// custom size bit was here


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
}


// displays party information
class
NarPhmPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	NarPhmPartyDisplay()
	{

		// narrative link
		$narrative = new BackReferenceField;
		$narrative->RefDatabase = "enarratives";
		$narrative->RefField = "ParPartiesRef_tab";
		$narrative->ColName = "SummaryData";
		$narrative->Label = "Related Narratives:";
		$narrative->LinksTo = "NarDisplay.php";

		// links to parties 
		$parties = new Field;
		$parties->Database = "eparties";
		$parties->Field = "SummaryData";
		$parties->Label = "Associated Parties:";
		$parties->ColName = "AssAssociationRef_tab->eparties->SummaryData";
		$parties->LinksTo = "NarDisplayParty.php";



		$this->Fields = array(
				'SummaryData',
				'NamTitle',
				'NamFirst',
				'NamMiddle',
				'NamLast',
				'BioBirthDate',
				'BioDeathDate',
				'BioLabel',
				$parties,
				$narrative

				);


		$this->BaseStandardDisplay();
		$this->HeaderField = 'SummaryData';
		$this->Database = 'eparties';


	}
}




?>
