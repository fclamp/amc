<?php
/*****************************************************
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 *****************************************************/


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/lib/BaseResultsLists.php');

/**************************************************************
 *
 * LocatorResultsList extends BaseStandardResultsList
 *
 * Overwritten Methods:
 * --------------------
 *
 * display()
 *
 * User interface for Object Locator:
 * ----------------------------------
 *
 * - AllowLocator (default = 1): for switching the locator functionality on and off (not sure if this will be useful)
 * 		
 * - RadioButtonLabel : the label for the heading column for the radio buttons 
 *
 * - LocatorLabel : the label for the link to the locator
 *
 * - AllowSelectAll (default = 1): if this is on it gives the RadioButtonLabel the ability to select and deselect all the checkboxes on the page 
 *
 * Setup:
 * ------
 *
 * You need to reference the object in your ResultsList.php in the pages directory
 *
 * <?php
 * require_once('../../objects/clientname/ResultsLists.php');
 *
 * $resultlist = new GalleryLocatorStandardResultsList;
 *
 * $resultlist->AllowLocator = 1;
 * $resultlist->RadioButtonLabel = 'Select';
 * $resultlist->LocatorLabel = 'Map Locator';
 * $resultlist->AllowSelectAll = 1;
 *
 * $resultlist->Width = '80%';
 * $resultlist->BodyColor = '#FFFFE8';
 * $resultlist->HighlightColor = '#FFFFFF';
 * $resultlist->HighlightTextColor = '#DDDDDD';
 * $resultlist->FontFace = 'Tahoma';
 * $resultlist->FontSize = '2';
 * $resultlist->TextColor = '#336699';
 * $resultlist->HeaderColor = '#336699';
 * $resultlist->BorderColor = '#336699';
 * $resultlist->HeaderTextColor = '#FFFFE8';
 * $resultlist->Show();
 * 
 * ?>
 *
 * And you will need to create the GalleryLocatorStandardResultsList object in the 
 * ../../objects/clientname/ResultsLists.php file
 *
 * require_once ($WEB_ROOT . '/objects/common/LocatorResultsList.php');
 *
 * class
 * GalleryLocatorStandardResultsList extends LocatorResultsList
 * {
 *	var $KeepImageAspectRatio = 1;
 *      var $Fields = array(    'TitMainTitle',
 *                               'TitAccessionNo',
 *                               'CreCreatorLocal:1',
 *                               'CreDateCreated',
 *                               'ValAnnualRental',
 *      );
 *
 * } 
 *
 **************************************************************/

class
LocatorResultsList extends BaseStandardResultsList
{

	var $AllowLocator = 1;
	var $LocatorUrl = '/webservices/objectlocator/index.php';
	var $RadioButtonLabel = 'Select';
	var $LocatorLabel = 'Map Locator';
	var $AllowSelectAll = 1;

	function LocatorResultsList()
	{
		$this->BaseStandardResultsList();
	}

	/**
	 * This function is used to print the javascript for the locator 
	 */
	function
	printLocatorHeader()
	{
		?>
		<script language='javascript'>	
		<!--
			function makeRequest()
			{
				checkboxes = document.getElementsByName('locator'); 	
				irns = "";

				if(checkboxes.length > 0)
				{
					for (n=0;n < checkboxes.length;n++)
					{
						if(checkboxes[n].checked == true)
						{
							if(irns == "")
							{
								irns += checkboxes[n].getAttribute('value');
							}
							else
							{
								irns += ',' + checkboxes[n].getAttribute('value');
							}
					  	}
					} 

					if(irns == "")
					{
						alert('Make sure a checkbox is ticked!');
					}
					else
					{
						document.getElementById('irn').value = irns;
						document.forms[0].submit();
					}
				}
				else
				{
					alert('Make sure a checkbox is ticked!');
				}

			}

			function selectAllCheckboxes()
			{
				checkboxes = document.getElementsByName('locator');
				for(i=0;i < checkboxes.length;i++)
				{
					checkboxes[i].checked = !checkboxes[i].checked;
				}
			}
		-->
		</script>
		<?
	}

	/**
	 * Overwritten method from class BaseStandardResultsList
	 * Adds checkboxes and locator links
	 */
	function
	display()
	{
		$records =& $this->records;

		$widthAttrib = '';
		$backgroundColorAttrib = '';
		$highlightColorAttrib = '';
		if ($this->Width != '')
			$widthAttrib 	= 'width="' . $this->Width . '"' ;
		if ($this->BodyColor != '')
			$backgroundColorAttrib	= 'bgcolor="' . $this->BodyColor . '"';
		if ($this->HighlightColor != '')
			$highlightColorAttrib	= 'bgcolor="' . $this->HighlightColor . '"';
		else
			$highlightColorAttrib	= 'bgcolor="' . $this->BodyColor . '"';
		if ($this->HeaderColor != '')
			$headerColorAttrib= 'bgcolor="' . $this->HeaderColor . '"';
		if ($this->BorderColor != '')
			$borderColorAttrib= 'bgcolor="' . $this->BorderColor . '"';

		// Find out how many coloums (one extra for image coloum)
		$numcol = count($this->Fields) + 1;

		if($this->AllowLocator == 1)
		{
			$this->printLocatorHeader();
			print "<form name='locator_form' method=\"GET\" action=\"/" . $GLOBALS['WEB_DIR_NAME'] . $this->LocatorUrl . "\">\n";
			print "<input type='hidden' name='irn' id='irn'/>\n";
		}

			
		//Print Table header
		print "<!--START OBJECT-->\n";
		print "<table $widthAttrib border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
		print "<tr><td width=\"25%\" align=\"left\" nowrap=\"nowrap\">";
		$this->printBackLink();
		if ($this->ContactSheetPage != '')
		{
			PPrint(' | ', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);

			PPrint(' ', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);

			$this->printRedisplay($this->ContactSheetPage, 
				$this->_STRINGS["CONTACT_SHEET"]);
		}

		if($this->AllowLocator == 1)
		{
			PPrint(' | ', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);

			PPrint(' ', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);

			$fonttag = 
			"<font face=\"" . $this->FontFace . "\" size=\"" . $this->FontSize . "\" color=\"" . $this->TextColor . "\">";
			$link = "<a href='#' onClick='makeRequest()'>" . $fonttag . $this->LocatorLabel . "</font></a>\n";	
			print $link;
		}

		print "</td>";
		print "<td width=\"75%\" align=\"right\">\n";
		$this->printNavLinks();
		print "</td></tr>";
		print "<tr><td colspan=\"2\">\n";
		print "<table $borderColorAttrib width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"4\">\n";
		// Print the Header Row
		print "  <tr $headerColorAttrib>\n";
		if ($this->DisplayThumbnails)
		{
			print "    <td width=\"72\" align=\"center\"><b>";
			PPrint($this->_STRINGS['IMAGE'], 
				$this->FontFace, 
				$this->FontSize, 
				$this->HeaderTextColor);
			print "</b></td>\n";
		}

		// Loop and display the coloum headings
		for ($i = 0; $i < $numcol - 1; $i++)
		{
			$label = '';
			if (is_string($this->Fields[$i]))
			{
				$label = $this->_STRINGS[$this->Fields[$i]];
			}
			elseif (strtolower(get_class($this->Fields[$i])) == 'formatfield')
			{
				$label = $this->Fields[$i]->Label;
			}
			print "    <td align=\"$this->AlignTitle\"><b>";
			if ($label == '')
				print '&nbsp;';
			else
				PPrint(	$label, 
					$this->FontFace, 
					$this->FontSize, 
					$this->HeaderTextColor);
			print "</b></td>\n";
		}

		// print the locator heading
		if($this->AllowLocator == 1)
		{
			print "    <td align=\"$this->AlignTitle\"><b>";

			$fonttag =
                       	"<font face=\"" . $this->FontFace . "\" size=\"" . $this->FontSize . "\" color=\"" . $this->HeaderTextColor . "\">";
                        $link = "<a href='#' onClick='selectAllCheckboxes()'>" . $fonttag . $this->RadioButtonLabel . "</font></a>\n";

			if ($this->RadioButtonLabel == '')
				 print '&nbsp;';
			else if($this->AllowSelectAll == 1)
				print $link;
			else
				PPrint( $this->RadioButtonLabel,
			               $this->FontFace,
			               $this->FontSize,
			               $this->HeaderTextColor);

			print "</b></td>\n";	
		}

		print "</tr>\n";

		// Loop over the results
		$rownum = 1;
		foreach ($records as $rec)
		{
			if ($rownum > $this->LimitPerPage)
				break;

			print "<!--START RECORD-->\n";

			$displaylink = $this->displayPageLink($rec);

			if ($rownum % 2 == 0 && $this->HighlightColor != '')
				print "  <tr $highlightColorAttrib>\n";
			else
				print "  <tr $backgroundColorAttrib>\n";

			if ($this->DisplayThumbnails)
			{
				print "    <td width=\"72\" align=\"center\" valign=\"middle\">" . "\n";
				// Display the thumbnail image
				$image = new MediaImage();
				$image->Intranet = $this->Intranet;
				// if we are on the multimedia module then the image IRN is the
				//  irn of the current record.
				if ($this->Database == "emultimedia")
				{
					$mediairn = $rec->{'irn_1'};
				}
				else
				{
					$mediairn = $rec->{'MulMultiMediaRef:1'};
				}
				$image->IRN = $mediairn;
				$image->BorderColor = $this->HeaderColor;
				$image->HighLightColor = $this->HeaderColor;
				$image->Link = $displaylink;
				$image->Width = 60;
				$image->Height = 60;
				$image->KeepAspectRatio = $this->KeepImageAspectRatio;
				$image->RefIRN = $rec->{'irn_1'};
				$image->RefTable = $this->Database;
				$image->ShowBorder = $this->ShowImageBorders;
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
				print "    </td>\n";
			}

			// Display Other Fields

			for ($j = 0; $j < $numcol - 1; $j++)
			{
				print "    <td align=\"$this->AlignData\">";
				$fieldData = '';

				if (is_string($this->Fields[$j]))
				{
					$fieldData = $rec->{$this->Fields[$j]};
				}
				elseif (strtolower(get_class($this->Fields[$j])) == 'formatfield')
				{
					$field = $this->Fields[$j]->Format;
					$fieldData = preg_replace('/{([^}]*)}/e', ' $rec->{"\\1"}', $field);
				}
				$fieldData = $this->adjustData($this->Fields[$j], $rec, $fieldData);

				if ($fieldData == '')
				{
					$fieldData = $this->_STRINGS['NOT_STATED'];
				}
					
				// First one is a link to display record
				if ($j == 0)
				{
					print "<a href=\"$displaylink\">";
						PPrint($fieldData, 
							$this->FontFace, 
							$this->FontSize,
							$this->TextColor, 
							$this->HighlightTextColor);
					print '</a>';
				}
				elseif ($fieldData != '')
				{
					PPrint($fieldData,
						$this->FontFace, 
						$this->FontSize, 
						$this->TextColor);
				}
				else
				{
					// field is empty so print space to stop netscape complaining
					print '&nbsp;';
				}
				print "</td>\n";
			}

			// print the radio button if locator is enabled
			if($this->AllowLocator == 1)
			{
				print "    <td align=\"$this->AlignData\">";
				print "<input type=\"checkbox\" name=\"locator\" id=\"locator\" value=\"" . $rec->{'irn_1'} . "\">";
				print "</td>\n";	
			}

			print "  </tr>\n<!--END RECORD-->\n";
			$rownum++;
		}

		//End Table
		print "</table>\n";
		print "</td></tr>";
		// Nav Links
		print "<tr><td width=\"25%\" align=\"left\" nowrap=\"nowrap\">";
		$this->printBackLink();
		if ($this->ContactSheetPage != '')
		{
			PPrint(' | ', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);

			PPrint(' ', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);

			$this->printRedisplay($this->ContactSheetPage, $this->_STRINGS["CONTACT_SHEET"]);
		}

		if($this->AllowLocator == 1)
		{
			PPrint(' | ', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);

			PPrint(' ', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);

			$fonttag = 
			"<font face=\"" . $this->FontFace . "\" size=\"" . $this->FontSize . "\" color=\"" . $this->TextColor . "\">";
			$link = "<a href='#' onClick='makeRequest()'>" . $fonttag . $this->LocatorLabel . "</font></a>\n";	
			print $link;
		}


		print "</td>";
		print "<td width=\"75%\" align=\"right\">";
		$this->printNavLinks();
		print "</td></tr>";
		print "</table>\n";
		print "<!--END OBJECT-->\n";

		if($this->AllowLocator == 1)
		{
			print "</form>\n";
		}

	}

} // end the LocatorResultsList class


?>
