<html>
  <head>
	<!--  Copyright (c) 1998-2012 KE Software Pty Ltd
   	<title>
	<?php print $GLOBALS['PAGE_TITLE']?>
	</title>
	<LINK href="objectlocator.css" rel="stylesheet" type="text/css">
  </head>

  <body class="main">
<div class="PageShadow">
	<div class="PageCentre">
		<div class="PageHeader">
			<div class="PageMenu">
			</div>
			<div class="PageBanner">
				<img border="0" src="images/banner.gif" >
			</div>
		</div>

	<br>
	<div class="PageTitle">
		<span class="title">
  		<b>
			<?php
				if($_GET['report'] != '')
				{
					print $GLOBALS['PAGE_TITLE'] . " Report"; 
				}
				else
				{
					print $GLOBALS['PAGE_TITLE'];
				}
			?>
  		</b>
		</span>	
	</div>

	<br>

		<span class="description">
			<?php print $GLOBALS['PAGE_DESCRIPTION']?>
		</span>

	<br>

	<object
	classid = "clsid:8AD9C840-044E-11D1-B3E9-00805F499D93"
	codebase = "http://java.sun.com/update/1.5.0/jinstall-1_5-windows-i586.cab#Version=5,0,0,5"
	WIDTH = "<?php print $GLOBALS['PAGE_WIDTH']?>" HEIGHT = "<?php print $GLOBALS['PAGE_HEIGHT']?>" >
	<PARAM NAME = CODE VALUE = "<?php print $GLOBALS['CODE']?>" >
	<PARAM NAME="cache_option" VALUE="Plugin">
	<PARAM NAME="cache_archive" VALUE="<?php print $GLOBALS['ARCHIVE']?>">
	<PARAM NAME="cache_version" VALUE="<?php print $GLOBALS['LOCATOR_VERSION']?>">
	<PARAM NAME = "type" value = "application/x-java-applet;version=1.5">
	<PARAM NAME = "scriptable" value = "false">
	<PARAM NAME = "plans" VALUE="<?php print $GLOBALS['PLANS']?>">
	<PARAM NAME = "planLocation" VALUE="<?php print $GLOBALS['PLANS_DIR_NAME']?>">
	<PARAM NAME = "imageLocation" VALUE="<?php print $GLOBALS['IMAGE_DIR_NAME']?>">
	<PARAM NAME = "locatorWebService" VALUE="<?php print $GLOBALS['LOCATOR_WEB_SERVICE']?>">
	<PARAM NAME = "locationTable" VALUE="<?php print $GLOBALS['LOCATION_TABLE']?>">
	<PARAM NAME = "locationField" VALUE="<?php print $GLOBALS['LOCATION_FIELD']?>">
	<PARAM NAME = "backendType" VALUE="<?php print $GLOBALS['BACKEND_TYPE']?>">

	<!-- the following params are not needed and are optional -->
	<PARAM NAME = "searchMedia" VALUE="<?php print $GLOBALS['SEARCH_MEDIA']?>">
	<PARAM NAME = "linkField" VALUE="<?php print $GLOBALS['LINK_FIELD']?>">
	<PARAM NAME = "mediaLink" VALUE="<?php print $GLOBALS['MEDIA_LINK']?>">
	<PARAM NAME = "dotSize" VALUE="<?php print $GLOBALS['DOT_SIZE']?>">
	<PARAM NAME = "decimalPlaces" VALUE="<?php print $GLOBALS['DECIMAL_PLACES']?>">
	<PARAM NAME = "dotShape" VALUE="<?php print $GLOBALS['DOT_SHAPE']?>">
	<PARAM NAME = "webObjectPage" VALUE="<?php print $GLOBALS['PHP_DISPLAY_PAGE']?>">
	<PARAM NAME = "mediaPage" VALUE="<?php print $GLOBALS['MEDIA_SERVICE']?>">
	<PARAM NAME = "zoomStep" VALUE="<?php print $GLOBALS['ZOOM_STEP']?>">
	<PARAM NAME = "pointerColour" VALUE="<?php print $GLOBALS['POINTER_COLOR']?>">
	<PARAM NAME = "pointerBorderColour" VALUE="<?php print $GLOBALS['POINTER_BORDER_COLOR']?>">
	<PARAM NAME = "dotFillColour" VALUE="<?php print $GLOBALS['DOT_FILL_COLOR']?>">
	<PARAM NAME = "dotBorderColour" VALUE="<?php print $GLOBALS['DOT_BORDER_COLOR']?>">
	<PARAM NAME = "dotHighlightFillColour" VALUE="<?php print $GLOBALS['DOT_HIGHLIGHT_FILL_COLOR']?>">
	<PARAM NAME = "dotHighlightBorderColour" VALUE="<?php print $GLOBALS['DOT_HIGHLIGHT_BORDER_COLOR']?>">
	<PARAM NAME = "normalBackgroundColour" VALUE="<?php print $GLOBALS['BACKGROUND_COLOR']?>">
	<PARAM NAME = "fadedTextColour" VALUE="<?php print $GLOBALS['FADED_TEXT_COLOR']?>">
	<PARAM NAME = "highlightTextColour" VALUE="<?php print $GLOBALS['HIGHLIGHT_TEXT_COLOR']?>">
	<PARAM NAME = "dataName" VALUE="<?php print $GLOBALS['DATA_NAME']?>">
	<PARAM NAME = "returnFields" VALUE="<?php print $GLOBALS['CATALOGUE_RETURN_FIELDS']?>">
	<PARAM NAME = "locationReturnFields" VALUE="<?php print $GLOBALS['LOCATION_RETURN_FIELDS']?>">
	<PARAM NAME = "locationDotFillColor" VALUE="<?php print $GLOBALS['LOC_DOT_FILL_COLOR']?>">
	<PARAM NAME = "locationDotBorderColor" VALUE="<?php print $GLOBALS['LOC_DOT_BORDER_COLOR']?>">
	<PARAM NAME = "locationDotHighlightFillColor" VALUE="<?php print $GLOBALS['LOC_DOT_HIGHLIGHT_FILL_COLOR']?>">
	<PARAM NAME = "locationDotHighlightBorderColor" VALUE="<?php print $GLOBALS['LOC_DOT_HIGHLIGHT_BORDER_COLOR']?>">
	<PARAM NAME = "locationRangeQuery" VALUE="<?php print $GLOBALS['LOC_RANGE_QUERY']?>">
	<PARAM NAME = "autoPopup" VALUE="<?php print $GLOBALS['AUTO_POPUP']?>">
	<PARAM NAME = "disableUpdate" VALUE="<?php print $GLOBALS['DISABLE_UPDATE']?>">
	<PARAM NAME = "webStatusField" VALUE="<?php print $GLOBALS['WEB_STATUS_FIELD']?>">

	<?php
		if($_GET['irn'] != '')
		{
			print "<!-- this is used to query on an object based on irn from the EMu web objects directly -->";
			print "<param name='queryIrn' value='" . $_GET['irn'] . "' />";
		}

		if($_GET['report'] != '')
		{
			print "<!-- this is used to goto report view where the left and right hand pane do not show and results are on the bottom -->";
			print "<param name='report' value='" . $_GET['report'] . "' />";
		}
	?>

    	<comment>
	<embed
	type = "application/x-java-applet;version=1.5" \
	CODE = "<?php print $GLOBALS['CODE']?>" \
	cache_option = "Plugin" \
	cache_archive = "<?php print $GLOBALS['ARCHIVE']?>" \
	cache_version = "<?php print $GLOBALS['LOCATOR_VERSION']?>" \
	WIDTH = "<?php print $GLOBALS['PAGE_WIDTH']?>" \
	HEIGHT = "<?php print $GLOBALS['PAGE_HEIGHT']?>" \
	plans ="<?php print $GLOBALS['PLANS']?>" \
	planLocation ="<?php print $GLOBALS['PLANS_DIR_NAME']?>" \
	locatorWebService ="<?php print $GLOBALS['LOCATOR_WEB_SERVICE']?>" \
	imageLocation ="<?php print $GLOBALS['IMAGE_DIR_NAME']?>" \
	searchMedia ="<?php print $GLOBALS['SEARCH_MEDIA']?>" \
	linkField ="<?php print $GLOBALS['LINK_FIELD']?>" \
	mediaLink ="<?php print $GLOBALS['MEDIA_LINK']?>" \
	dotSize ="<?php print $GLOBALS['DOT_SIZE']?>" \
	decimalPlaces ="<?php print $GLOBALS['DECIMAL_PLACES']?>" \
	dotShape ="<?php print $GLOBALS['DOT_SHAPE']?>" \
	webObjectPage ="<?php print $GLOBALS['PHP_DISPLAY_PAGE']?>" \
	mediaPage ="<?php print $GLOBALS['MEDIA_SERVICE']?>" \
	zoomStep ="<?php print $GLOBALS['ZOOM_STEP']?>" \
	pointerColour ="<?php print $GLOBALS['POINTER_COLOR']?>" \
	pointerBorderColour ="<?php print $GLOBALS['POINTER_BORDER_COLOR']?>" \
	dotFillColour ="<?php print $GLOBALS['DOT_FILL_COLOR']?>" \
	dotBorderColour ="<?php print $GLOBALS['DOT_BORDER_COLOR']?>" \
	dotHighlightFillColour ="<?php print $GLOBALS['DOT_HIGHLIGHT_FILL_COLOR']?>" \
	dotHighlightBorderColour ="<?php print $GLOBALS['DOT_HIGHLIGHT_BORDER_COLOR']?>" \
	normalBackgroundColour ="<?php print $GLOBALS['BACKGROUND_COLOR']?>" \
	fadedTextColour ="<?php print $GLOBALS['FADED_TEXT_COLOR']?>" \
	highlightTextColour ="<?php print $GLOBALS['HIGHLIGHT_TEXT_COLOR']?>" \
	dataName ="<?php print $GLOBALS['DATA_NAME']?>" \
	returnFields ="<?php print $GLOBALS['CATALOGUE_RETURN_FIELDS']?>" \
	locationReturnFields ="<?php print $GLOBALS['LOCATION_RETURN_FIELDS']?>" \
	locationDotFillColor ="<?php print $GLOBALS['LOC_DOT_FILL_COLOR']?>" \
	locationDotBorderColor ="<?php print $GLOBALS['LOC_DOT_BORDER_COLOR']?>" \
	locationDotHighlightFillColor ="<?php print $GLOBALS['LOC_DOT_HIGHLIGHT_FILL_COLOR']?>" \
	locationDotHighlightBorderColor ="<?php print $GLOBALS['LOC_DOT_HIGHLIGHT_BORDER_COLOR']?>" \
	locationRangeQuery ="<?php print $GLOBALS['LOC_RANGE_QUERY']?>" \
	autoPopup ="<?php print $GLOBALS['AUTO_POPUP']?>" \
	disableUpdate ="<?php print $GLOBALS['DISABLE_UPDATE']?>" \
	backendType ="<?php print $GLOBALS['BACKEND_TYPE']?>" \
	<?php
		if($_GET['irn'] != '')
		{
			print "queryIrn =" . $_GET['irn'] . " \\\n";
		}

		if($_GET['report'] != '')
		{
			print "report =" . $_GET['report'] . " \\\n";
		}
	?>
	scriptable = false \
	pluginspage = "http://java.sun.com/products/plugin/index.html#download">
	<noembed>
        </noembed>
	</embed>
	</comment>
	</object>

	<br>

	<?php
		$field = "";
		$module = "";
		$findModule = "";
		$findField = "";
		$label = "";
		$numberOfValidLocations = 0;

		if($_GET['report'] != '')
		{
			printResults();
		}

		function 
		getLabel($module, $field)
		{
			global $findModule;
			global $findField;
			global $label;

			$field = trim($field);
			$findModule = $module;
			$findField = $field;
			$label = "";

			$xml_parser = xml_parser_create();
			xml_set_element_handler($xml_parser, "startElement", "endElement");
			xml_set_character_data_handler($xml_parser, "characterData");

			if (!($fp = fopen("objectlocator.xml", "r"))) 
			{
				die("could not open XML input");
			}

			while ($data = fread($fp, 4096)) 
			{
				if (!xml_parse($xml_parser, $data, feof($fp))) 
				{
					die(sprintf("XML error: %s at line %d",
					xml_error_string(xml_get_error_code($xml_parser)),
					xml_get_current_line_number($xml_parser)));
				}
			}
			xml_parser_free($xml_parser);

			return trim($label);
		}

		function 
		startElement($parser, $name, $attrs) 
		{
			global $field;
			global $module;

			if(strtolower($name) == "module")
			{
				foreach ($attrs as $k => $v) 
				{
					if(strtolower($k) == "name")
					{
						$module = $v;
					}
				}
			}

			if(strtolower($name) == "field")
			{
				foreach ($attrs as $k => $v) 
				{
					if(strtolower($k) == "name")
					{
						$field = $v;
					}
				}
			}
		}

		function 
		endElement($parser, $name) 
		{
			global $field;
			global $module;

			if(strtolower($name) == "module")
			{
				$module = "";
			}

			if(strtolower($name) == "field")
			{
				$field = "";
			}
		}

		function 
		characterData($parser, $data) 
		{
			global $field;
			global $module;
			global $findModule;
			global $findField;
			global $label;

			if( (strtolower($module) == strtolower($findModule)) && (strtolower($field) == strtolower($findField)) )
			{
				$label .= $data;
			}
		}

		function
		printResults()
		{
			if( ($GLOBALS['CATALOGUE_RETURN_FIELDS'] == '') || ($GLOBALS['LOCATION_RETURN_FIELDS'] == '') )
			{
				print "<table width='80%' border='0' cellspacing='1' cellpadding='4' class='reportTable'>";
				print "<tr class='headings'>";
				print "<td class='heading' align='center'>";
				print "No fields set in config.php!";
				print "</td>";
				print "</tr>";
				print "</table>";
				return;
			}

			$fields = explode(",", $GLOBALS['CATALOGUE_RETURN_FIELDS']);
			$locFields = explode(",", $GLOBALS['LOCATION_RETURN_FIELDS']);
			$irns = explode(",", $_GET['irn']);
			$irnList = array();
			$key = "";
			$printLocationRef = 0;
			$locationSet = 0;

			// add the location ref if needed to the query
			if(!in_array($GLOBALS['LOCATION_FIELD'], $fields))
			{
				$printLocationRef = 0;	
				array_push($fields, $GLOBALS['LOCATION_FIELD']);
			}
			else
			{
				$printLocationRef = 1;
			}

			foreach ($irns as $irn)
			{
				array_push($irnList, "irn = $irn");
			}

			// print headings 
			print "<table width='80%' border='0' cellspacing='1' cellpadding='4' class='reportTable'>";
			print "<tr class='headings'>";
			$numberOfColumns = 0;

			if($GLOBALS['SEARCH_MEDIA'] == "true")
			{
				print "<td class='heading' align='center'>";
				print "Image";
				print "</td>";
				$numberOfColumns++;
			}
		
			foreach ($fields as $field)
			{
				if( ($field != $GLOBALS['LOCATION_FIELD']) || ($field == $GLOBALS['LOCATION_FIELD'] && $printLocationRef == 1) )
				{
					print "<td class='heading' align='center'>";
					print getLabel("ecatalogue", $field);
					print "</td>";

					// also trim the field
					$field = trim(field);
					$numberOfColumns++;
				}
			}

			foreach ($locFields as $field)
			{
				print "<td class='heading' align='center'>";
				print getLabel($GLOBALS['LOCATION_TABLE'], $field);
				print "</td>";

				// also trim the field
				$field = trim(field);
				$numberOfColumns++;
			}

			print "</tr>";
			$color = 1;
			$numberOfCatRecords = 0;

			// print each record (one by one)
			foreach ($irnList as $irn)
			{
				// now print the results 
				$records = new RecordExtractor;
				$records->DisplayPage = $GLOBALS['PHP_DISPLAY_PAGE'];
				$records->Database = "ecatalogue";
				$records->Where = $irn;
				$records->ExtractFields($fields);

				if(strcmp($records->FieldAsValue("irn_1"), "") == 0)
					continue;

				print "<tr>\n";
				$key = "";
				$locationSet = 0;

				if($GLOBALS['SEARCH_MEDIA'] == "true")
				{
					if(($color%2) == 0)
					{
						print "<td align='center' class='lightRecord'>\n";
					}
					else
					{
						print "<td align='center' class='darkRecord'>\n";
					}

					print $records->PrintImage(50, 50, 1);
					print "</td>";
				}
				
				foreach ($fields as $field)
				{
					if( ($field != $GLOBALS['LOCATION_FIELD']) || ($field == $GLOBALS['LOCATION_FIELD'] && $printLocationRef == 1) )
					{
						if(($color%2) == 0)
						{
							print "<td align='left' class='lightRecord'>\n";
						}
						else
						{
							print "<td align='left' class='darkRecord'>\n";
						}

						$field = trim($field);

						if(strcmp($field, "irn") == 0)
						{
							$field = "irn_1";
						}

						$records->PrintField(trim($field));
						print "</td>";
					}

					if($field == $GLOBALS['LOCATION_FIELD'])
					{
						$key = $records->FieldAsValue(trim($field));
						$locationSet = 1;
					}
				}

				if($locationSet == 1)
				{
					printLocation($key, $color);
				}

				print "</tr>\n";

				$color++;
				$numberOfCatRecords++;
			}

			print "<tr><td class='heading' align='center' colspan='" . $numberOfColumns . "'>";
			print "Number of Valid Catalogue Records Found: " . 
			$numberOfCatRecords . "</td></tr>";

			global $numberOfValidLocations;

			print "<tr><td class='heading' align='center' colspan='" . $numberOfColumns . "'>";
			print "Number of Valid Location Records Found: " . 
			$numberOfValidLocations . "</td></tr>";

			print "</table>\n";
		}

		function 
		printLocation($key, $color)
		{
			global $numberOfValidLocations;

			$fields = explode(",", $GLOBALS['LOCATION_RETURN_FIELDS']);

			if($key == '')
			{
				// print blanks 
				foreach ($fields as $field)
				{
					if(($color%2) == 0)
					{
						print "<td align='left' class='lightRecord'>\n";
					}
					else
					{
						print "<td align='left' class='darkRecord'>\n";
					}

					print "&nbsp;\n";
					print "</td>\n";
				}
				return;	
			}

			// now print the location result 
			$locRecord = new RecordExtractor;
			$locRecord->DisplayPage = $GLOBALS['PHP_DISPLAY_PAGE'];
			$locRecord->Database = $GLOBALS['LOCATION_TABLE'];
			$locRecord->Where = "irn = $key";
			$locRecord->ExtractFields($fields);

			// if no location record
			if(strcmp($locRecord->FieldAsValue("irn_1"), "") == 0)
			{
				// print blanks 
				foreach ($fields as $field)
				{
					if(($color%2) == 0)
					{
						print "<td align='left' class='lightRecord'>\n";
					}
					else
					{
						print "<td align='left' class='darkRecord'>\n";
					}

					print "&nbsp;\n";
					print "</td>\n";
				}
			}
			else
			{
				// should only be one record
				foreach ($fields as $field)
				{
					if(($color%2) == 0)
					{
						print "<td align='left' class='lightRecord'>\n";
					}
					else
					{
						print "<td align='left' class='darkRecord'>\n";
					}

					$field = trim($field);

					if(strcmp($field, "irn") == 0)
					{
						$field = "irn_1";
					}

					$locRecord->PrintField(trim($field));
					print "</td>\n";
				}

				$numberOfValidLocations++;
			}

		}
	?>

	<br>
	<table border="0" width="100%" cellspacing="0" cellpadding="4">
  	<tr>
    		<td width="10%" align="center">
		</td>

    		<td width="40%" valign="middle" align="center">
			<span class="company">
			Powered by:&nbsp;&nbsp;
			<img border="0" src="<?php print $GLOBALS['IMAGE_WEB_DIR_NAME']?>/productlogo.gif" 
			align="absmiddle" width="134" height="48">
			</span>
		</td>

    		<td width="40%" valign="middle">
      			<p align="center">

			<span class="copyright">
				<a href="http://www.kesoftware.com/">
				<img alt="KE Software" src="<?php print $GLOBALS['IMAGE_WEB_DIR_NAME']?>/companylogo.gif" 
				border="0" align="absmiddle" width="60" height="50"></a>
			</span>
		</td>

    		<td width="10%">
		</td>
  	</tr>
	</table>

	<div class="footer">
		<div class="menu2">
		</div>			
		<div class="copyright">
			&copy; 2007 The National Museum, All Rights Reserved
		</div>
	</div>
  </div>
  </div>
  </body>
</html>
