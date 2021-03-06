<?php
$STRINGS = array(
	"LANGUAGE"		=> "English",

// Override some of the build in strings
	'NOT_STATED'		=> '',
	// Advanced query form
	'FIND_RESULTS'		=> 'Find records which include:',
	'WITH_ALL_WORDS'	=> '<b>all</b> of the words entered to the right',
	'WITH_EXACT_PHRASE'	=> 'the <b>exact phrase</b> entered to the right',
	'WITH_ANY_WORDS'	=> '<b>any</b> of the words entered to the right',
	'WITHOUT_THE_WORDS'	=> '<b>without</b> the words entered to the right',
	'SOUNDS_LIKE_THE_WORDS'	=> 'words that <b>sounds like</b> the words entered',



// Catalogue Field Names
	"SummaryData" 								=> "Summary Data",
	"CatBarcode"            						=> "Barcode",
	"CatCatalog"            						=> "Catalog",
	"IdeFiledAsRef->etaxonomy->ClaDivision" 				=> "Division",
	"IdeFiledAsRef->etaxonomy->ClaPhylum" 					=> "Division",
	"IdeFiledAsRef->etaxonomy->ClaOrder"    				=> "Order",
	"IdeFiledAsRef->etaxonomy->ClaFamily"   				=> "Family",
	"IdeFiledAsRef->etaxonomy->ClaSubfamily"        			=> "Subfamily",
	"IdeFiledAsRef->etaxonomy->ComName_tab"					=> "Common Name",
	"IdeFiledAsRef->etaxonomy->GeoStatus_tab"				=> "Status",
	"IdeFiledAsRef->etaxonomy->CitVerificationDegree_tab"			=> "Verification Degree",
        "IdeFiledAsRef->etaxonomy->GeoAuthorityRef_tab->eparties->SummaryData" 	=> "Authority",
	"IdeQualifiedName_tab"  						=> "Qualified Name",
	"ColCollectionEventRef->ecollectionevents->ColParticipant_tab"  	=> "Participants",
	"BioEventSiteRef->ecollectionevents->ColParticipantLocal_tab"  		=> "Participants",
	"ColCollectionEventRef->ecollectionevents->ColParticipantString"  	=> "Participants",
	"BioEventSiteRef->ecollectionevents->ColParticipantRole_tab"   		=> "Participants' Role",
	"ColCollectionEventRef->ecollectionevents->ColDateVisitedFrom"   	=> "Date Visited From",
	"ColCollectionEventRef->ecollectionevents->ColDateVisitedTo"   		=> "Date Visited To",
	"BioDateVisitedFromLocal"					   	=> "Collection Date",
	"BioDateVisitedToLocal" 				  		=> "Date Visited To",
	"BioPrimaryCollNumber"  						=> "Primary Coll. Number",
	"BioPublishLocalityUser"						=> "Publish Locality",
	"BioEventSiteRef->ecollectionevents->LocBiogeographicalRegion"     	=> "Biogeographical Region",
	"BioEventSiteRef->ecollectionevents->LocCountry"    			=> "Country",
	"BioEventSiteRef->ecollectionevents->LocProvinceStateTerritory"     	=> "Province/State/Territory",
	"BioEventSiteRef->ecollectionevents->LocDistrictCountyShire"        	=> "District/County",
	"BioEventSiteRef->ecollectionevents->LocIslandName"        		=> "Island Name",
	"BioEventSiteRef->ecollectionevents->ColParticipant_tab" 		=> "Participants",
	"BioEventSiteRef->ecollectionevents->ColParticipantString"		=> "Participant(s)",
	"BioEventSiteRef->ecollectionevents->ColParticipantRole_tab" 		=> "Participants Role",
	"BioParticipantRoleLocal_tab"				 		=> "Participants Role",
	"ColCollectionEventRef->ecollectionevents->ColPrimaryParticipantLocal"  => "Primary Collector",
	"BioEventSiteRef->ecollectionevents->ColPrimaryParticipantLocal"  	=> "Primary Collector",
	"BioEventSiteRef->ecollectionevents->ColDateVisitedConjunction"		=> "Date Conjunction",
	"BioEventSiteRef->ecollectionevents->ColDateVisitedFrom"		=> "Date Visited From",
	"BioEventSiteRef->ecollectionevents->ColDateVisitedTo"			=> "Date Visited To",
	"BioEventSiteRef->ecollectionevents->ColCollectionMethod"		=> "Collection Method",
	"BioEventSiteRef->ecollectionevents->LocCountryMain"    		=> "Country",
	"BioEventSiteRef->ecollectionevents->LocBiogeographicalRegion"     	=> "Biogeographical Region",
	"BioEventSiteRef->ecollectionevents->LocProvinceStateTerritoryMain"     => "Province/State/Territory",
	"BioEventSiteRef->ecollectionevents->LocDistrictCountyShireMain"        => "District/County/Shire",
	"BioEventSiteRef->ecollectionevents->LocIslandName"        		=> "Island Name",
	"BioEventSiteRef->ecollectionevents->LocPreciseLocation"        	=> "Precise Location",
	"BioEventSiteRef->ecollectionevents->LocGeographicFeatures"		=> "Geographic Features",
	"BioEventSiteRef->ecollectionevents->LatPreferredCentroidLatitude"	=> "Preferred Centroid Latitude",
	"BioEventSiteRef->ecollectionevents->LatPreferredCentroidLongitude"	=> "Preferred Centroid Longitude",
	"NotNmnhText0"								=> "Notes",


	"IdeFiledAsName|MinName" 			=> "Name",
	"IdeQualifiedName:1"				=> "Qualified Name",
	"IdeQualifiedName_tab"				=> "Taxonomic Name",
	"CatPrefix"					=> "Catalog Number Prefix",
	"CatSuffix"					=> "Catalog Number Suffix",
	"CatNumber"					=> "Catalog Number",
	"IdeFiledAsName"				=> "Scientific Name",
	"IdeFiledAsDateIdentified" 			=> "Date Identified",
	"IdeFiledAsFamily"				=> "Family",
	"IdeFiledAsOrder"				=> "Order",
	"IdeFiledAsClass"				=> "Class",
	"IdeFiledAsPhylum"				=> "Phylum",
	"IdeFiledAsGenus"				=> "Genus",
	"IdeFiledAsSubGenus"				=> "Sub Genus",
	"IdeFiledAsSpecies"				=> "Species",
	"IdeFiledAsSubSpecies"				=> "Sub Species",
	"IdeFiledAsQualifiedNameWeb"			=> "Qualified Name",
	"IdeFiledAsQualifiedName"			=> "Taxonomic name (as filed)",
	"IdeFiledAs_tab"				=> "Filed As",
	"IdeTypeStatus_tab"				=> "Type Status",
	"IdeFiledAsTypeStatus"				=> "Filed As Type Status",
	"IdeOtherQualifiedName_tab" 			=> "Other Identifications",
	"IdeScientificNameLocal_tab" 			=> "Scientific Name",
	"IdePhylumLocal_tab"				=> "Division",
	"IdeClassLocal_tab"				=> "Class",
	"IdeOrderLocal_tab"				=> "Order",
	"IdeFamilyLocal_tab"				=> "Family",
	"IdeSubfamilyLocal_tab"				=> "Subfamily",
	"IdeGenusLocal_tab"				=> "Genus",
	"IdeSubGenusLocal_tab"				=> "Sub Genus",
	"IdeSpeciesLocal_tab"				=> "Species",
	"IdeSubSpeciesLocal_tab"			=> "Sub Species",
	"IdeTaxonRef_tab->etaxonomy->AutCombAuthorString" => "Combined Authors",
	"CitTaxonRefLocal_tab"				=> "Type Specimen Name",
	"CitTypeStatus_tab"				=> "Type Status",
	"IdeIdentifiedByRefLocal:1"			=> "Identified By",
	"IdeIdentifiedByRefLocal_tab"			=> "Identified By",
	"IdeIdentifiedByRef_tab->eparties->SummaryData"	=> "Identified By",
	"IdeIdentifiedByRef_tab->eparties->NamBriefName"=> "Identified By",
	"IdeIdentifiedByLocal_tab"			=> "Identified By",
	"IdeDateIdentified0"				=> "Identification Date",
	"ClaPhylum_tab"					=> "Phylum",
	"ClaClass_tab"					=> "Class",
	"ClaOrder_tab"					=> "Order",
	"ClaFamily_tab"					=> "Family",
	"ComName_tab"					=> "Common Name",
	"CatSpecimenCount"				=> "Number of Specimens",
	"SitSiteNumber"					=> "Site/Station Number",
	"ZooPreparation"				=> "Preparation",
	"BioOceanLocal"					=> "Ocean",
	"BioOceanLocal:1"				=> "Ocean",
	"BioCountryLocal"				=> "Country",
	"MinCountry"					=> "Country",
	"BioSeaGulfLocal"				=> "Sea/Gulf",
	"BioDistrictCountyShireLocal"			=> "District/County",
	"BioProvinceStateLocal"				=> "Province/State/Territory",
	"MinState"					=> "Province/State",
	"BioProvinceStateLocal:1"			=> "Province/State",
	"BioIslandGroupingLocal"			=> "Island Grouping",
	"BioIslandNameLocal"				=> "Island Name",
	"BioBiogeographicalRegionLocal"			=> "Biogeographical Region",
	"BioPreciseLocationLocal"			=> "Precise Location",
	"ColCollectionMethod"				=> "Collection Method",
	"BioPrimaryCollNumber"				=> "Collection Number",
	"ExpExpeditionName"				=> "Expedition Name",
	"ExpStartDate"					=> "Collection Date",
	"BioVesselNameLocal"				=> "Vessel Name",
	"BioCruiseNumberLocal"				=> "Cruise Number",
	"BioRiverBasinLocal"				=> "River Basin",
	"ColParticipantRefLocal_tab"			=> "Collection Participant",
	"ZooPreparation_tab"				=> "Preparation",
	"ZooSex_tab"					=> "Sex",
	"ZooStage_tab"					=> "Stage",
	"ZooTemperatureVerbatim"			=> "Verbatim Temp",
	"ZooTemperatureMinC"				=> "Minimum C",
	"ZooTemperatureMaxC"				=> "Maximum C",
	"CatCollectionName_tab"				=> "Special Collections",
	"BioPreferredCentroidLatitude"			=> "Latitude",
	"BioPreferredCentroidLongitude"			=> "Longitude",
	"BioParticipantRef_tab->eparties->SummaryData"	=> "Participants",
	"BioParticipantStringLocal"			=> "Participants",
	"BioParticipantLocal_tab"			=> "Any Participant",
	"BioPrimaryCollectorLocal"			=> "Primary Collector",
	"BioVerbatimLocality"				=> "Verbatim Locality",
	"BioLiveSpecimen"				=> "Specimen Description",
	"BioMicrohabitatDescription"			=> "Microhabitat Description",
	"BioSubstrate"					=> "Substrate",
	"BioEthnobioUsedPart"				=> "Ethnobio Used Part",
	"BioEthnobioUse"				=> "Ethnobio Use",
	"BioChromosomeCount"				=> "Chromosome Count",
	"BioCountByRef->eparties->NamBriefName"		=> "Count By",
	"BioLiveAtCapture"				=> "Live At Capture",
	"BioExpeditionNameLocal"			=> "Expedition Name",
	"BioSiteNumberLocal"				=> "Site Number",
	"VerStomachContents"				=> "Stomach Contents",
	"VerCollectionMethod"				=> "Collection Method",
	"BibBibliographyRef_tab->ebibliography->SummaryData"	=> "Published",
	"CatOtherNumbersType_tab"			=> "Other Numbers Type",
	"CatOtherNumbersValue_tab"			=> "Other Numbers Value",

// predefined table and field array names - across all diciplines

	"CollParticipants" 	=> "Collection Participants",
	"TypeCitations" 	=> "Type Citations",
	"SexAndStage" 		=> "Sex and Stage",
	"SpecCount" 		=> "Specimen Count",
	"SpecDates" 		=> "Specimen Dates",
	"Depth(m)" 		=> "Depth (m)",
	"DateCollected" 	=> "Date Collected",
	"BotPrepDetails" 	=> "Preparation Details",
	"zooPrepDetails"	=> "Preparation Details",
	"ErupDetails" 		=> "Eruption Details",
	"FlowTephraDetails" 	=> "Flow/Tephra Details",
	"GeoAgeDetails"		=> "Geologic Age Details",
	"StratDetails"		=> "StratDetails",
	"IdeList"		=> "Identification List",
	"Age"			=> "Age",
	"ReprodCondition"	=> "Reprod. Condition",
	"BirdReprodCondition"	=> "Bird - Reprod. Condition",
	"ProgDetails"		=> "Progeny Details",
	"Bursa"			=> "Bird - Bursa",
	"MoltDesc"		=> "Bird - Molt Description",
	"Softparts"		=> "Bird - Softparts Details",
	"HerParasites|MamParasite"	=> "Amphibians & Reptiles - Parasite",
	"IdeComments_tab"	=> "Id Comments",
	"OtherTerms"		=> "Other Terms",
	"Materials"		=> "Materials",
	"Color"			=> "Color",
	"SubjectPeople"		=> "Subject People",
	"SubjectOther"		=> "Subject Other",
	"CultureList"		=> "Culture List",
	"CulComment_tab"	=> "Culture Comments",
	"Creators"		=> "Creators",
	"AssEvents"		=> "Associated Events",
	"AssIndividuals"	=> "Associated Individuals",
	"ObjectDate"		=> "Object Date",
	"SiteProvDetails"	=> "Site Provenance Details",
	"SiteClassDetails"	=> "Site Classification Details",
	"SpecDetails"		=> "Specimen Details",
	"AgeStage"		=> "Age/Stage",
	"DesObjectDescription_tab"	=> "Object Description",
	"DesManufactTechniques_tab"	=> "Man. Techniques",
	"IdeObjectName"			=> "Object Name",
	"DesObjectDescription:1"	=> "Object Description",
	"CulCultureLocal:1" 		=> "Culture",
	"IdeClassIndex_tab|IdeIndexTerm_tab|IdeSubType_tab|IdeVariety_tab" 	=> "Identification Details",
	"IdeObjectName|DesObjectDescription_tab" 				=> "Object",
	"DesMaterial_tab|DesPrimaryMat_tab|DesSpecificMaterial_tab" 		=> "Materials",
	"DesColor_tab" 		=> "Color",
	"CulCultureLocal_tab" 	=> "Culture",
	"ProEvent_tab" 		=> "Associated Events",
	"ArcObjectDateKind_tab|ArcObjectDate_tab|ArcObjectDateModifier_tab|ArcObjectDateVerbatim_tab" 	=> "Object Date",
	"ArcProvenience1_tab|ArcProvenience2_tab|ArcProvenience3_tab|ArcProvenience4_tab" 		=> "Site Provenance",
	"ArcClassification1_tab|ArcClassification2_tab|ArcClassification3_tab|ArcClassification4_tab" 	=> "Site Classification",
	"PhySpecimenClass_tab|PhySpecimenPartName_tab" 				=> "Specimen Details",
	"PhyStage_tab|PhySource_tab|PhyComments_tab" 				=> "Age/Stage",
	"PhyPathologyKind_tab|PhyPathologyDiagnosis_tab|PhyPathologyComment_tab"=> "Pathology Details",
	"PhyCauseofDeath_tab|PhyCauseofDeathSource_tab" 			=> "Cause Of Death",
	"PhyPathCondition_tab|PhyPathConditionSource_tab" 			=> "Pathalogical Conditions",

// Bot fields

	"AgeGeologicAgeSystem_tab"	=> "Geologic Age System",
	"AgeGeologicAgeSeries_tab"	=> "Geologic Age Series",
	"AgeStratigraphyFormation_tab"	=> "Stratigraphy Formation",
	"BotHabit"		=> "Habit",
	"BotPhenology"		=> "Phenology",
	"BotAssociatedFlora"	=> "Associated Flora",
	"BotRecentFossil"	=> "Recent/Fossil",
	"BotCultivated"		=> "Cultivated",
	"BotCultivated"		=> "Cultivated",

// Mammals fields

	"MamInjury"		=> "Injury",
	"MamParasite"		=> "Parasite",
	"MamSexualMaturity"	=> "Sexual Maturity",
	"MamPhysicalMaturity"	=> "Physical Maturity",
	"MamSpecimenCondition"	=> "Specimen Condition",

// Bird fields
	"BirSkull"			=> "Bird - Skull",
	"BirFat"			=> "Bird - Fat",
	"BirPlumage"			=> "Bird - Plumage",
	"BirTreatment"			=> "Bird - Treatment",
	"BirBursaDescription_tab"	=> "Bird - Bursa",
	"BirSoftpartsPart_tab"		=> "Bird - Softparts - Parts",
	"BirSoftpartsColor_tab"		=> "Bird - Softparts - Color",

	
// Herps fields

	"HerColor"			=> "Amphibians & Reptiles - Color",
	"HerReproductionDescription"	=> "Amphibians & Reptiles - Reprod. Description",
	"HerMorphologicalData"		=> "Amphibians & Reptiles - Morphological Data",
	"HerBehavioralObservation"	=> "Amphibians & Reptiles - Behavior",
	"HerGrowthData"			=> "Amphibians & Reptiles - Growth Data",
	"HerParasites"			=> "Amphibians & Reptiles - Parasites",

// Min fields
	"MinColor"			=> "Color",
	"MinCut"			=> "Cut",
	"MinName"			=> "Name",
	"MinCountry"			=> "Country",
	"MinState"			=> "State",
	"MinSynonyms_tab"		=> "Synonyms",
	"MinAssociatedMinerals_tab" 	=> "Associated Minerals",
	"MinMineName"			=> "Mine Name",
	"MinWeight"			=> "Weight",
	"MinJeweleryType"		=> "Jewelery Type",
	"MinCutByRef->eparties->SummaryData"	=> "Cut By",
	"MinMakerRef->eparties->SummaryData"	=> "Made By",
	"MinMicroprobed"		=> "Microprobed",
	"MinXRayed"			=> "X-Rayed",
	"MinSynthetic"			=> "Synthetic",
	"MinChemicalModifier"		=> "Chemical Modifier",
	"MinDescribedFigured_tab"	=> "Described",


// Meteorite Fields
	"MetMeteoriteType"	=> "Meteorite Type",
	"MetMeteoriteName"	=> "Meteorite Name",
	"MetRecordNumber"	=> "Record Number",
	"MetFindFall"		=> "Find/Fall",
	"MinSiteRef->esites->SummaryData"	=> "Locality",
	"MetConditionDetermination"		=> "Condition Determination",
	"MetSynonym"		=> "Synonym",

// Petrology and Volcanology Fields
	"PetLavaSource"		=> "Lava Source",
	"PetFlowTephra"		=> "Flow/Tephra",
	"PetEruptionDate"	=> "Eruption Date",
	"PetFlowTephraDate"	=> "Flow/Tephra Date",
	"PetCommodityMetal_tab"	=> "Commodity Metal",

// Party Field Names
	"NamTitle"		=> "Title",
	"NamFirst"		=> "First Name",
	"NamLast"		=> "Last Name",
	"NamMiddle"		=> "Middle Name",
	"BioBirthPlace"		=> "Birth Place",
	"BioDeathPalce"		=> "Death Place",
	"BioEthnicity"		=> "Ethenicity",


// Query Form Strings
	"QUERY_OPTION_ANY"	=> "anywhere",
	"QUERY_OPTION_TAXONOMY"	=> "in taxonomy",
	"QUERY_OPTION_PLACE"	=> "in locations",
	"QUERY_OPTION_PERSON"	=> "in people",
	"NUMBER_OF_RECORDS"	=> "Records per page",
	"ONLY_WITH_IMAGES"	=> "List items only with images",

// Display Strings
	"CREATOR"		=> "Creator",
	);
?>
