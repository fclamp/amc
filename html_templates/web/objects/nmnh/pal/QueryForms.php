<?php
/*
**  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (! isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/' . $GLOBALS['BACKEND_TYPE'] . '/' . ucfirst($GLOBALS['BACKEND_TYPE']) . 'QueryForms.php');

class
NmnhPalBasicQueryForm extends NmnhBasicQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Paleobiology'";

	var $Options = array
	(		
		'any' 		=> 'SummaryData|AdmWebMetadata',
		'taxonomy' 	=> 'IdeTaxonLocal_tab|IdePhylumLocal_tab|IdeClassLocal_tab|IdeOrderLocal_tab|IdeFamilyLocal_tab|IdeCommonNameLocal_tab',
		'place' 	=> 'BioOceanLocal|BioSeaGulfLocal|BioBaySoundLocal|BioCountryLocal|BioDistrictCountyShireLocal|BioProvinceStateLocal',
		'person' 	=> 'BioParticipantLocal_tab|IdeIdentifiedByLocal_tab',
	);
} 
//=====================================================================================================
//=====================================================================================================
class
NmnhPalAdvancedQueryForm extends NmnhAdvancedQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Paleobiology'";

	var $Options = array
	(		
		'any' 		=> 'SummaryData|AdmWebMetadata',
		'taxonomy' 	=> 'IdePhylumLocal_tab|IdeClassLocal_tab|IdeOrderLocal_tab|IdeFamilyLocal_tab',
		'place' 	=> 'BioOceanLocal|BioSeaGulfLocal|BioCountryLocal|BioDistrictCountyShireLocal|BioProvinceStateLocal|BioIslandGroupingLocal|BioIslandNameLocal',
		'person' 	=> 'BioParticipantLocal_tab|IdeIdentifiedByRefLocal_tab',
	);
}
//=====================================================================================================
//=====================================================================================================
class
NmnhPalDetailedQueryForm extends NmnhDetailedQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Paleobiology'";

	function
	NmnhPalDetailedQueryForm()
	{
		$this->NmnhDetailedQueryForm();
		$this->MaxDropDownLength = 100;

		$catNumber = new QueryField;
		$catNumber->ColName = 'CatNumber';
		$catNumber->ColType = 'integer';

                $dateFrom = new QueryField;
                $dateFrom->ColName = 'BioDateVisitedFromLocal';
                $dateFrom->ColType = 'date';

		$this->Fields = array
		(	
			$catNumber,
			'CatCollectionName_tab',
			'IdeKingdomLocal_tab',
			'IdePhylumLocal_tab',
			'IdeClassLocal_tab',
			'IdeOrderLocal_tab',
			'IdeFamilyLocal_tab',
			'IdeCommonNameLocal_tab',
			'IdeFiledAsQualifiedNameWeb',
			'IdeIdentifiedByLocal_tab',
			'IdeFiledAsTypeStatus',
			'IdeFiledAsVoucher',
			'BioParticipantStringLocal',
			$dateFrom,
			'BioOceanLocal',
			'BioSeaGulfLocal',
			'BioBaySoundLocal',
			'BioCountryLocal',
			'BioProvinceStateLocal',
			'BioDistrictCountyShireLocal',
			'BioExpeditionNameLocal',
			'BioVesselNameLocal',
			'BioCruiseNumberLocal',
			'BioSiteNumberLocal',
			'AgeGeologicAgeEra_tab',
			'AgeGeologicAgeSystem_tab',
			'AgeGeologicAgeSeries_tab',
			'AgeGeologicAgeStage_tab',
			'AgeStratigraphyGroup_tab',
			'AgeStratigraphyFormation_tab',
			'AgeStratigraphyMember_tab',
			'PalMorphologyCodes',
		);

		$this->Hints = array
		(	
			'CatNumber'				=> '[USNM Catalog Number, e.g. 123456]',
			'CatCollectionName_tab'			=> '[Select from list]',
			'IdeKingdomLocal_tab' 			=> '[Select from list]',
			'IdePhylumLocal_tab' 			=> '[Select from list]',
			'IdeClassLocal_tab' 			=> '[Select from list]',
			'IdeOrderLocal_tab' 			=> '[Select from list]',
			'IdeFamilyLocal_tab'			=> '[e.g. Tyrannosauridae]',
			'IdeCommonNameLocal_tab' 		=> '[Select from list]',
			'IdeFiledAsQualifiedNameWeb' 		=> '[e.g. Waptia fieldensis Walcott, 1912]',
			'IdeIdentifiedByLocal_tab' 		=> '[e.g. Purdy]',
			'IdeFiledAsTypeStatus' 			=> '[Select from list]',
			'IdeFiledAsVoucher' 			=> '[Select from list]',
			'BioParticipantStringLocal' 		=> '[e.g. Grant]',
			'BioDateVisitedFromLocal' 		=> '[format dd-mmm-yyyy, partial entry works]',
			'BioOceanLocal' 			=> '[Select from list]',
			'BioSeaGulfLocal' 			=> '[Select from list]',
			'BioBaySoundLocal' 			=> '[Select from list]',
			'BioCountryLocal' 			=> '[Select from list]',
			'BioProvinceStateLocal' 		=> '[e.g. North Carolina]',
			'BioDistrictCountyShireLocal' 		=> '[e.g. Beaufort County]',
			'BioExpeditionNameLocal' 		=> '[Select from list]',
			'BioVesselNameLocal' 			=> '[Select from list]',
			'BioCruiseNumberLocal' 			=> '[e.g. 57]',
			'BioSiteNumberLocal' 			=> '[e.g. 7230]',
			'AgeGeologicAgeEra_tab' 		=> '[Select from list]',
			'AgeGeologicAgeSystem_tab' 		=> '[Select from list]',
			'AgeGeologicAgeSeries_tab' 		=> '[Select from list]',
			'AgeGeologicAgeStage_tab' 		=> '[Select from list]',
			'AgeStratigraphyGroup_tab' 		=> '[Select from list]',
			'AgeStratigraphyFormation_tab' 		=> '[Enter value or use lookup button; up to 3 leading characters narrows lookup]',
			'AgeStratigraphyMember_tab' 		=> '[Select from list]',
			'PalMorphologyCodes' 			=> '[e.g. ulna, proximal right humerus]',
		);

		$this->DropDownLists = array
		(	
			'CatCollectionName_tab' 		=> 'eluts:Collection Name[6]',
			'IdeClassLocal_tab' 			=> 'eluts:Taxonomy[6]',
			'IdeOrderLocal_tab' 			=> 'eluts:Taxonomy[9]',
			'IdeFiledAsTypeStatus' 			=> 'eluts:Type Status',
			'IdeFiledAsVoucher' 			=> 'eluts:Secondary Type Status',
			'IdeKingdomLocal_tab' 			=> 'eluts:Taxonomy[2]',
			'IdePhylumLocal_tab' 			=> 'eluts:Taxonomy[3]',
			'IdeCommonNameLocal_tab' 		=> 'eluts:Common Names',
			'CitTypeStatus_tab' 			=> 'eluts:Type Status',
			'CitVoucher_tab' 			=> 'eluts:Secondary Type Status',
			'BioOceanLocal' 			=> 'eluts:Ocean[1]', 
			'BioSeaGulfLocal' 			=> 'eluts:Ocean[2]', 
			'BioBaySoundLocal' 			=> 'eluts:Ocean[3]', 
			'BioCountryLocal' 			=> 'eluts:Continent[2]', 
			'BioExpeditionNameLocal' 		=> 'eluts:Expedition Name', 
			'BioVesselNameLocal' 			=> 'eluts:Vessel Name', 
			'AgeGeologicAgeEra_tab' 		=> 'eluts:Geologic Age[1]', 
			'AgeGeologicAgeSystem_tab' 		=> 'eluts:Geologic Age[2]', 
			'AgeGeologicAgeSeries_tab' 		=> 'eluts:Geologic Age[3]', 
			'AgeGeologicAgeStage_tab' 		=> 'eluts:Geologic Age[4]', 
			'AgeStratigraphyGroup_tab' 		=> 'eluts:Stratigraphy[1]', 
			'AgeStratigraphyMember_tab' 		=> 'eluts:Stratigraphy[3]', 
		);
		
		$this->LookupLists = array
                (
                        'AgeStratigraphyFormation_tab'		=> 'Stratigraphy[2]',
               );
	}

	function
	display()
	{
		global $ALL_REQUEST;

		// print some JavaScript to assist with lookup list popup
		print "<script langauge=\"JavaScript\">\n";
		print "<!--\n";
		print "function openLookupList(formID, fieldID, LutName, restriction, term)\n";
		print "{\n";
		print "	url = '" . $GLOBALS['LOOKUPLIST_URL'] . "';";
		print "	url = url + '?formid=' + formID + '&fieldid=' + fieldID + '&lname=' + LutName + '&restriction=' + restriction + '&ll=' + term;\n";
		print "	url = url + '&lang=" . $this->LanguageData . "';\n";
    		print "	url = url + '&bodycolor=" . urlencode($this->BodyColor) . "';\n";
    		print "	url = url + '&bodytextcolor=" . urlencode($this->BodyTextColor) . "';\n";
		print '	popupWindow = window.open(url, "popupWindow", "height=500,width=250,location=no,status=no,toolbar=no,scrollbars=yes"); ';
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
		$self = isset($GLOBALS['PHP_SELF']) 
				? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];
?>

<form method="<?php print $this->SubmitMethod; ?>" name="dtlquery" action="<?php print $this->ResultsListPage?>">
	<input type="hidden" name="QueryName" value="DetailedQuery" />
	<input type="hidden" name="StartAt" value="1" />
	<input type="hidden" name="QueryPage" value="<?php print $self ?>" />
	<input type="hidden" name="Restriction" value="<?php print $this->Restriction?>" />
	<?php $this->printAdditionalTransferVariables();?>
	<table width="100%" border="0" cellspacing="2" cellpadding="2">
<?php
		// FIXME - This is invalid HTML - can't have content within a table element.
		if ($this->SecondSearch)
		{
			//add a second search and clear button to the top of the page
			print "<br />\n";
			print "&nbsp;&nbsp;<input class=\"WebButton\" type=\"submit\" name=\"Search\" value=\"Search\" />\n";
			print "<input class=\"WebButton\" type=\"reset\" name=\"Rearch\" value=\"Clear\" />\n";
			if ($this->ImagesOnlyOption == 1)
			{
				print "<font color=\"{$this->BodyTextColor}\" size=\"$this->FontSize\" face=\"$this->FontFace\">\n";
				print "&nbsp;&nbsp;<input class=\"WebInput\" type=\"checkbox\" name=\"ImagesOnly\" value=\"true\" />\n";
				print $this->_STRINGS['ONLY_WITH_IMAGES'];
				print "</font>\n";
			}
			print "<br /><br />\n";
		}
		
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
					if ($fld->IsLower)
						$htmlFieldName = 'col_date_lower_' . $fld->ColName;
					elseif ($fld->IsUpper)
						$htmlFieldName = 'col_date_upper_' . $fld->ColName;
					else
						$htmlFieldName = 'col_date_' . $fld->ColName;
					break;
				    case 'float':
					if ($fld->IsLower)
						$htmlFieldName = 'col_float_lower_' . $fld->ColName;
					elseif ($fld->IsUpper)
						$htmlFieldName = 'col_float_upper_' . $fld->ColName;
					else
						$htmlFieldName = 'col_float_' . $fld->ColName;
					break;
				    case 'integer':
					if ($fld->IsLower)
						$htmlFieldName = 'col_int_lower_' . $fld->ColName;
					elseif ($fld->IsUpper)
						$htmlFieldName = 'col_int_upper_' . $fld->ColName;
					else
						$htmlFieldName = 'col_int_' . $fld->ColName;
					break;
				    case 'string':
					$htmlFieldName = 'col_str_' . $fld->ColName;
					break;
				    case 'longitude':
					$htmlFieldName = 'col_long_' . $fld->ColName;
					break;
				    case 'latitude':
					$htmlFieldName = 'col_lat_' . $fld->ColName;
					break;
				    case 'text':
					$htmlFieldName = 'col_' . $fld->ColName;
					break;
				}
			}
			else
				WebDie('Invalid Field Type - Expected QueryField');

	  		print "<tr>\n";
	    		print "<td valign=\"top\" nowrap=\"nowrap\" width=\"25%\">\n";
			print "<font color=\"" . $this->BodyTextColor .'"';
			print " size=" . $this->FontSize . ' face="' . $this->FontFace . "\">\n";
			$promptColName = $fld->ColName;
			if ($fld->IsLower)
				$promptColName .= "Lower";
			elseif ($fld->IsUpper)
				$promptColName .= "Upper";
			if (isset($this->_STRINGS[$promptColName]))
				$label = $this->_STRINGS[$promptColName];
			else
				$label = $fld->ColName;
			print "<b>&nbsp;&nbsp;" .  $label . "</b></font>\n";
	    		print "</td>\n";
	    		print "<td valign=\"top\" nowrap=\"nowrap\" width=\"20%\">\n";
			if (isset($this->DropDownLists[$fld->ColName]))
			{
				$this->generateDropDown($fld->ColName, $htmlFieldName);
			}
			elseif (isset($this->LookupLists[$fld->ColName]))
			{
				$colName = $this->LookupLists[$fld->ColName];
				$restriction = $this->getLookupRestriction($colName);
				$restriction = urlencode($restriction);
				$lookupName = urlencode($colName);

				// print picklist/lookuplist image and link
				print '&nbsp;&nbsp;<input class="WebInput" type="text" value="" name="';
				print $htmlFieldName . "\" size=\"20\" />";
				print '&nbsp;';
				print '<a href="javascript:void(0)" onclick="openLookupList(\'dtlquery\', ';
				print "'$htmlFieldName', '$lookupName', '$restriction', dtlquery['$htmlFieldName'].value)\">";
				$imgPath = $GLOBALS['WEB_PICKLIST_GRAPHIC'];
				print "<img src=\"$imgPath\" border=\"0\" align=\"top\" />";
				print '</a>';
			}
			else
			{
				print '&nbsp;&nbsp;<input class="WebInput" type="text" value="" name="';

				# SOME CUSTOMISATION FOR PALEO
				if ($fld->ColName == "PalMorphologyCodes" || $fld->ColName == "IdeFiledAsQualifiedNameWeb")
				{
					print $htmlFieldName . "\" size=\"40\" />\n";
				}
				else
				{
					print $htmlFieldName . "\" size=\"20\" />\n";
				}
			}
	    		print "</td>\n";
	    		print "<td valign=\"top\" width=\"55%\">\n";
			print "<font color=\"" . $this->BodyTextColor . "\" size=\"" . $this->FontSize . '" face="' . $this->FontFace . "\">\n";
			$hintColName = $fld->ColName;
			if ($fld->IsLower)
				$hintColName .= "Lower";
			elseif ($fld->IsUpper)
				$hintColName .= "Upper";
			print "" . $this->Hints[$hintColName] . "</font>\n";
	    		print "</td>\n";
	  		print "</tr>\n";
		}
?>
		<tr>
		<td valign="top" nowrap="nowrap">
			<font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>">
			<b>&nbsp;&nbsp;<?php print $this->_STRINGS['NUMBER_OF_RECORDS']?></b></font>
		</td>
		<td valign="top" nowrap="nowrap">
			&nbsp;&nbsp;<select class="WebLimitPerPage" name="LimitPerPage">
			<?php
			foreach($this->LimitPerPageOptions as $key => $val)
			{
			?>
				<option value="<?php print $key; ?>" <?php if ($key == $this->LimitPerPageSelected) {?>selected="selected"<?php };?>><?php print htmlentities($val); ?></option>

			<?php
			}
			?>
			</select>
		</td>
		<td valign="top">
		</td>
	</table>
	<p>
	&nbsp;&nbsp;<input class="WebButton" type="submit" name="Search" value="Search" />
	<input class="WebButton" type="reset" name="Rearch" value="Clear" />
	</p>
</form>

<?php
		$decorator->Close();
	} //end display()
} 
//=====================================================================================================
//=====================================================================================================
?>
