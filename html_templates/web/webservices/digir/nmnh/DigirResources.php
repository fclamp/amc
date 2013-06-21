<?php

/* 
**  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (! isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');

class DigirResources
{
	function 
	&getResource($resourceCode)
	{
		switch (strtolower($resourceCode))
		{
			case 'nmnh-botany':
				$resource =& new NmnhBotDigirResource();
				break;
			case 'nmnh-entomology':
				$resource =& new NmnhEntoDigirResource();
				break;
			case 'nmnh-iz':
				$resource =& new NmnhIZDigirResource();
				break;
			case 'nmnh-vzbirds':
				$resource =& new NmnhVZBirdsDigirResource();
				break;
			case 'nmnh-vzfishes':
				$resource =& new NmnhVZFishesDigirResource();
				break;
			case 'nmnh-vzherps':
				$resource =& new NmnhVZHerpsDigirResource();
				break;
			case 'nmnh-vzmammals':
				$resource =& new NmnhVZMammalsDigirResource();
				break;
			default:
				$resource = false;
				break;
		}
		return $resource;
	}

	function
	getResourceCodes()
	{
		$resourceCodes = array();

		GLOBAL $BACKEND_ENV;
		switch (strtolower($BACKEND_ENV))
		{
			case 'bot':
				$resourceCodes[] = 'nmnh-botany';
				break;
			case 'ento':
				$resourceCodes[] = 'nmnh-entomology';
				break;
			case 'iz':
				$resourceCodes[] = 'nmnh-iz';
				break;
			case 'vzbirds':
				$resourceCodes[] = 'nmnh-vzbirds';
				break;
			case 'vzfishes':
				$resourceCodes[] = 'nmnh-vzfishes';
				break;
			case 'vzherps':
				$resourceCodes[] = 'nmnh-vzherps';
				break;
			case 'vzmammals':
				$resourceCodes[] = 'nmnh-vzmammals';
				break;
			default:
				$resourceCodes = false;
				break;
		}

		return $resourceCodes;
	}

	function
	getMetadataName()
	{
		return 'National Museum of Natural History, Smithsonian Institution';
	}

	function
	getMetadataHost()
	{
		return <<<EOT
					<name>National Museum of Natural History</name>
					<code>NMNH</code>
					<relatedInformation>http://www.nmnh.si.edu/</relatedInformation>
					<contact type='Administrative'>
						<name>Tom Orrell</name>
						<title>NMNH Informatics Branch Chief</title>
						<emailAddress>orrellt@si.edu</emailAddress>
						<phone>+1 202 633 2151</phone>
					</contact>
					<contact type='Technical'>
						<name>Dennis Hasch</name>
						<title>NMNH Web Services Branch Chief</title>
						<emailAddress>haschd@si.edu</emailAddress>
						<phone>+1 202 633 0848</phone>
					</contact>
					<abstract>Data provider via EMu/DiGIR</abstract>
EOT;
	}

}

/*
**
** Client Specific Digir Resource
**
** Normally Created by a Factory class
** DigirResources
**
** @package EMuWebServices
**
*/
class NmnhDigirResource extends BaseWebServiceObject
{
	var $serviceName = 'NmnhDigirResource';
	var $serviceDirectory = 'webservices/digir';

	var $server;
	var $department;
	var $baseMediaURL;
	var $baseRecordURL;
	var $baseGUID;
	var $citation;
	var $replicationDate;
	var $objectType;

	function 
	NmnhDigirResource()
	{
		### CALL PARENT CONSTRUCTOR
		$this->{get_parent_class(__CLASS__)}();

		GLOBAL $BACKEND_ENV;
		GLOBAL $MEDIA_URL;
		
		$this->maxSearchResponseRecords = 10000;

		if (isset($BACKEND_ENV))
			$this->department = $BACKEND_ENV;

		if (isset($_SERVER['HTTP_HOST']))
			$this->server = $_SERVER['HTTP_HOST'];

		if (isset($MEDIA_URL))
			$this->baseMediaURL = "http://$this->server/$this->webDirName/pages/nmnh/$BACKEND_ENV/$MEDIA_URL?irn=";
		else
			$this->baseMediaURL = "http://$this->server/$this->webDirName/objects/common/webmedia.php?irn=";

		$this->objectType = array
		(
			'S'	=> array(),
			'P'	=> array(),
			'I'	=> array(),
			'L'	=> array(),
			'O'	=> array()
		);

		if (isset($this->webRoot))
		{
			$path = realpath("{$this->webRoot}/..");
			foreach(glob("$path/.emu_web_env*") as $file)
			{
				$file = basename($file);
				if (preg_match('/^\.emu_web_env-(\d{4})-(\d{2})-(\d{2})-\d{2}-\d{2}$/', $file, $match))
					$this->replicationDate = "$match[2]-$match[3]-$match[1]";
			}
		}

	}

	function 
	describe()
	{
		return "A NMNH Digir Resource is a NMNH client specific Digir Resource\n\n" . parent::describe();
	}

	function 
	getResourceCode()
	{
		return $this->resourceCode;
	}

	function 
	getResourceRestrictions()
	{
		return $this->resourceRestrictions;
	}

	function 
	getMaxSearchResponseRecords()
	{
		return $this->maxSearchResponseRecords;
	}

	function 
	getMappings($map)
	{
		###
		### SET HANDLERS FOR POST PROCESSED FIELDS
		###

		### BasisOfRecord
		$code = 
		'
			if ($operator == \'=\' || 
			    $operator == \'<>\')
			{
				if (strtolower($value) == \'s\' && ! empty($data[\'S\']))
					$query = "CatObjectType $operator \'" .  implode("\' OR CatObjectType $operator \'", $data[\'S\']) . "\'";
				else if (strtolower($value) == \'p\' && ! empty($data[\'P\']))
					$query = "CatObjectType $operator \'" . implode("\' OR CatObjectType $operator \'", $data[\'P\']) . "\'"; 
				else if (strtolower($value) == \'i\' && ! empty($data[\'I\']))
					$query = "CatObjectType $operator \'" . implode("\' OR CatObjectType $operator \'", $data[\'I\']) . "\'";
				else if (strtolower($value) == \'l\' && ! empty($data[\'L\']))
					$query = "CatObjectType $operator \'" . implode("\' OR CatObjectType $operator \'", $data[\'L\']) . "\'";
				else if (strtolower($value) == \'o\' && ! empty($data[\'O\']))
					$query = "CatObjectType $operator \'" . implode("\' OR CatObjectType $operator \'", $data[\'O\']) . "\'";
			}
			else
			{
				return null;
			}
			if (! isset($query))
				$query = \'FALSE\';
			return $query;
		';
		$map->setTexqlHandler('BasisOfRecord', 'CatObjectType', $code, $this->objectType);

		$code = 
		'
			if (empty($record[\'CatObjectType\']))
				return \'\';
			
			if (in_array(strtolower($record[\'CatObjectType\']), array_map(\'strtolower\', $data[\'S\'])))
				return \'S\';
			else if (in_array(strtolower($record[\'CatObjectType\']), array_map(\'strtolower\', $data[\'P\'])))
				return \'P\';
			else if (in_array(strtolower($record[\'CatObjectType\']), array_map(\'strtolower\', $data[\'I\'])))
				return \'I\';
			else if (in_array(strtolower($record[\'CatObjectType\']), array_map(\'strtolower\', $data[\'L\'])))
				return \'L\';
			else if (in_array(strtolower($record[\'CatObjectType\']), array_map(\'strtolower\', $data[\'O\'])))
				return \'O\';

			return \'\';
		';
		$map->setValueHandler('BasisOfRecord', $code, $this->objectType);

		### Citation
		$code = 
		'
			if ($operator == \'=\')
			{
				if ($value == $data)
					return \'TRUE\';
			}
			else if ($operator == \'<>\')
			{
				if ($value != $data)
					return \'TRUE\';
			}
			else
			{
				return null;
			}
			return \'FALSE\';
		';
		$map->setTexqlHandler('Citation', null, $code, $this->citation);

		$code = 'return $data;';
		$map->setValueHandler('Citation', $code, $this->citation);

		### GlobalUniqueIdentifier
		$code = 
		'
			if ($operator == \'=\')
			{
				if (preg_match("/^$data(\d+\.\d+)$/", $value, $match))
					return "DarGlobalUniqueIdentifier $operator \'$match[1]\'";
			}
			else if ($operator == \'<>\')
			{
				if (preg_match("/^$data(\d+\.\d+)$/", $value, $match))
					return "DarGlobalUniqueIdentifier $operator \'$match[1]\'";
				else
					return \'DarGlobalUniqueIdentifier is not null\';
			}
			else
			{
				return null;
			}
			return \'FALSE\';
		';
		$map->setTexqlHandler('GlobalUniqueIdentifier', 'DarGlobalUniqueIdentifier', $code, $this->baseGUID);
	
		$code = 
		'
			if (empty($record[\'DarGlobalUniqueIdentifier\']))
				return \'\';
			return $data . $record[\'DarGlobalUniqueIdentifier\'];
		';
		$map->setValueHandler('GlobalUniqueIdentifier', $code, $this->baseGUID);
	
		### ImageURL
		$code = 
		'
			if ($operator == \'=\')
			{
				if (preg_match("/^$data(\d+)$/", $value, $match))
					return "DarImageURL contains \'$match[1]\'";
				else
					return \'FALSE\';
			}
			else if ($operator == \'<>\')
			{
				if (preg_match("/^$data(\d+)$/", $value, $match))
					return "DarImageURL contains \'!$match[1]\'";
				else
					return \'DarImageURL is not null\';
			}
			else
			{
				return null;
			}
			return \'FALSE\';
		';
		$map->setTexqlHandler('ImageURL', 'DarImageURL', $code, $this->baseMediaURL);

		$code = 
		'
			if (empty($record[\'DarImageURL\']))
				return \'\';

			$value = \'\';
			foreach (explode(\'; \', $record[\'DarImageURL\']) as $irn)
			{
				if (! empty($value))	
					$value .= \'; \';
				$value .= $data . $irn;
			}
			return $value;
		';
		$map->setValueHandler('ImageURL', $code, $this->baseMediaURL);

		### RecordURL
		$code = 
		'
			if ($operator == \'=\')
			{
				if (preg_match("/^$data(\d+)$/", $value, $match))
					return "irn $operator $match[1]";
			}
			else if ($operator == \'<>\')
			{
				if (preg_match("/^$data(\d+)$/", $value, $match))
					return "irn $operator $match[1]";
				else
					return \'TRUE\';
			}
			else
			{
				return null;
			}
			return \'FALSE\';
		';
		$map->setTexqlHandler('RecordURL', 'irn_1', $code, $this->baseRecordURL);

		$code = 
		'
			if (empty($record[\'irn_1\']))
				return \'\';
			return $data . $record[\'irn_1\'];
		';
	
		$map->setValueHandler('RecordURL', $code, $this->baseRecordURL);
	
		### RelatedCatalogedItems
		$code = 
		'
			$texql = \'\';
			if ($operator == \'=\')
			{
				foreach (explode(\'; \', $value) as $related)
				{
					if (preg_match("/^$data(.+)$/", $related, $match))
					{
						if (! empty($texql))
							$texql .= \' AND \';
						$texql .= "RelRelatedObjectGUIDLocal $operator \'$match[1]\'";
					}
					else
					{
						return \'FALSE\';
					}
				}
			}
			else if ($operator == \'<>\')
			{
				foreach (explode(\'; \', $value) as $related)
				{
					if (preg_match("/^$data(.+)$/", $related, $match))
					{
						if (! empty($texql))
							$texql .= \' AND \';
						$texql .= "RelRelatedObjectGUIDLocal $operator \'$match[1]\'";
					}
					else
					{
						if (! empty($texql))
							$texql .= \' AND \';
						$texql .= \'TRUE\';
					}
				}
			}
			else if (strtolower($operator) == \'like\')
			{
				foreach (explode(\'; \', $value) as $related)
				{
						if (! empty($texql))
							$texql .= \' AND \';
						$texql .= "RelRelatedObjectGUIDLocal $operator \'$related\'";
				}
			}
			else
			{
				return null;
			}
			if (! empty($texql))
				return "RelRelatedObjectGUIDLocal_tab <> [] AND EXISTS(RelRelatedObjectGUIDLocal_tab where $texql)";
			return \'FALSE\';
		';
		$map->setTexqlHandler('RelatedCatalogedItems', 'RelRelatedObjectGUIDLocal_tab', $code, $this->baseGUID);

		$code = 
		'
			if (empty($record[\'RelRelatedObjectGUIDLocal_tab\']))
				return \'\';

			$value = \'\';
			foreach (explode(\'; \', $record[\'RelRelatedObjectGUIDLocal_tab\']) as $item)
			{
				if (! empty($value))	
					$value .= \'; \';
				$value .= $data . $item;
			}
			return $value;
		';
		$map->setValueHandler('RelatedCatalogedItems', $code, $this->baseGUID);

		###
		### RESET FIELDS THAT HAVE CHANGED NAMES
		### - SOME FIELDS CONTAIN THE SAME DATA BUT HAVE CHANGED NAMES BETWEEN
		###   DARWIN CORE VERSIONS. SET THE NEW FIELD TO POINT TO THE OLD FIELD
		###   MAPPING
		### DO THIS LAST - AFTER WE HAVE SET ALL OTHER MAPPING STUFF
		###
		$map->setMappingRef('DayOfYear', 'JulianDay');
		$map->setMappingRef('EarliestDateCollected', 'StartYearCollected');
		$map->setMappingRef('GeoreferenceProtocol', 'GeorefMethod');
		$map->setMappingRef('GeoreferenceRemarks', 'LatLongComments');
		$map->setMappingRef('InfraSpecificEpithet', 'Subspecies');
		$map->setMappingRef('LatestDateCollected', 'EndYearCollected');
		$map->setMappingRef('VerbatimCoordinateSystem', 'OriginalCoordinateSystem');

		return $map;
	}
}

#####################################
### DEPARTMENT SPECIFIC PROVIDERS ###
#####################################

class NmnhBotDigirResource extends NmnhDigirResource
{
	function 
	NmnhBotDigirResource()
	{
		### CALL PARENT CONSTRUCTOR
		$this->{get_parent_class(__CLASS__)}();

		$this->resourceCode = 'NMNH-Botany';
		$this->resourceRestrictions[] = "CatDepartment = 'Botany'";

		$this->baseRecordURL = "http://$this->server/$this->webDirName/pages/$this->backendType/$this->department/Display.php?irn=";
		$this->baseGUID = 'urn:lsid:nmnh.si.edu:Botany:';
		$this->citation = 'Department of Botany, Research and Collections Information System, NMNH, Smithsonian Institution. See: http://www.mnh.si.edu/rc/db/collection_db_policy1.html';
		if (isset($this->replicationDate))
			$this->citation .= ', ' . $this->replicationDate;

		$this->objectType['S'] = array
		(
			'bulky fruit', 'bulky specimen', 'discarded bulky specimen', 'leaf', 'liquid preserved', 'microslide', 'microslide',
			'microslide', 'packet', 'part bulky specimen', 'part bulky specimen', 'part discarded bulky specimen', 'specimen',
			'pressed specimen', 'pressed specimen', 'seed', 'seedlings', 'sem stub', 'tissue culture', 'unknown part', 'unknown whole',
			'unmounted  material', 'wet lot', 'wood specimen'
		);
		$this->objectType['P'] = array('mounted literature');
		$this->objectType['I'] = array('photo', 'sem micrograph');
		$this->objectType['L'] = array
		(
			'bulb', 'cutting & seed', 'cutting; seed', 'cutting', 'plant', 'propagules', 'rhizome; seed', 'rhizome', 'rhizomes',
			'seed', 'seeds', 'tuber'
		);

	}

	function 
	getMetadataResource($num, $date, $maxSearch, $maxInv)
	{
		return <<<EOT
					<name>NMNH Botany Collections</name>
					<code>$this->resourceCode</code>
					<relatedInformation>http://www.nmnh.si.edu/botany</relatedInformation>
					<contact type='Administrative'>
						<name>Rusty Russell</name>
						<title>NMNH Botany, Collections Manager</title>
						<emailAddress>russellr@si.edu</emailAddress>
						<phone>+1 202 633 0943</phone>
					</contact>
					<contact type='Administrative'>
						<name>Chris Tuccinardi</name>
						<title>NMNH Botany, Data Manager</title>
						<emailAddress>tuccinar@si.edu</emailAddress>
						<phone>+1 202 633 0900</phone>
					</contact>
					<abstract>NMNH Botany Collections records, records currently represent approximately 17% of actual specimen holdings</abstract>
					<keywords>Botany, Smithsonian, NMNH, Museum, Herbarium, Specimen, Taxonomy, Algae, Lichens, Bryophytes, Ferns, Gymnosperms, Angiosperms</keywords>
					<citation>Department of Botany, Research and Collections Information System, NMNH, Smithsonian Institution. See: http://www.mnh.si.edu/rc/db/collection_db_policy1.html</citation>
					<useRestrictions>See: http://www.mnh.si.edu/rc/db/2data_access_policy.html</useRestrictions>
					<conceptualSchema schemaLocation='http://bnhm.berkeley.edu/DwC/bnhm_dc2_schema.xsd'>http://digir.net/schema/conceptual/darwin/2003/1.0</conceptualSchema>
					<recordIdentifier>USNM</recordIdentifier>
					<recordBasis>voucher</recordBasis>
					<numberOfRecords>$num</numberOfRecords>
					<dateLastUpdated>$date</dateLastUpdated>
					<minQueryTermLength>0</minQueryTermLength>
					<maxSearchResponseRecords>$maxSearch</maxSearchResponseRecords>
					<maxInventoryResponseRecords>$maxInv</maxInventoryResponseRecords>
EOT;
	}
}
//===========================================================================================================================
//===========================================================================================================================
class NmnhEntoDigirResource extends NmnhDigirResource
{
	function 
	NmnhEntoDigirResource()
	{
		### CALL PARENT CONSTRUCTOR
		$this->{get_parent_class(__CLASS__)}();

		$this->resourceCode = 'NMNH-Entomology';
		$this->resourceRestrictions[] = "CatDepartment = 'Entomology'";

		$this->baseRecordURL = "http://$this->server/$this->webDirName/pages/$this->backendType/$this->department/Display.php?irn=";
		$this->baseGUID = 'urn:lsid:nmnh.si.edu:Entomology:';
		$this->citation = 'Department of Entomology, Research and Collections Information System, NMNH, Smithsonian Institution. See: http://www.mnh.si.edu/rc/db/collection_db_policy1.html';
		if (isset($this->replicationDate))
			$this->citation .= ', ' . $this->replicationDate;

		$this->objectType['S'] = array('specimen/lot');
		$this->objectType['I'] = array('illustration');
	}

	function 
	getMetadataResource($num, $date, $maxSearch, $maxInv)
	{
		return <<<EOT
					<name>NMNH Entomology Collections</name>
					<code>$this->resourceCode</code>
					<relatedInformation>http://entomology.si.edu</relatedInformation>
					<contact type='Administrative'>
						<name>Jerry Louton</name>
						<title>NMNH Entomology, ?</title>
						<emailAddress>loutonj@si.edu</emailAddress>
						<phone>+1 202 633 0991</phone>
					</contact>
					<abstract>NMNH Entomology Collections data currently represent less than 1% of actual specimen holdings. Current offerings include Odonata speicimen data and Hymenoptera (bee) type data. Entomological illustration archive records and images are also available</abstract>
					<keywords>Entomology, Smithsonian, NMNH, Museum, Specimen, Illustration, Biodiversity, Taxonomy, Insecta, Arachnida, Chilopoda, Diplopoda, Pauropoda, Symphyla, Odonata, Hymenoptera</keywords>
					<citation>Department of Entomology, Research and Collections Information System, NMNH, Smithsonian Institution. See: http://www.mnh.si.edu/rc/db/collection_db_policy1.html</citation>
					<useRestrictions>See: http://www.mnh.si.edu/rc/db/2data_access_policy.html</useRestrictions>
					<conceptualSchema schemaLocation='http://bnhm.berkeley.edu/DwC/bnhm_dc2_schema.xsd'>http://digir.net/schema/conceptual/darwin/2003/1.0</conceptualSchema>
					<recordIdentifier>USNM</recordIdentifier>
					<recordBasis>voucher</recordBasis>
					<numberOfRecords>$num</numberOfRecords>
					<dateLastUpdated>$date</dateLastUpdated>
					<minQueryTermLength>0</minQueryTermLength>
					<maxSearchResponseRecords>$maxSearch</maxSearchResponseRecords>
					<maxInventoryResponseRecords>$maxInv</maxInventoryResponseRecords>
EOT;
	}
}
//===========================================================================================================================
//===========================================================================================================================
class NmnhIZDigirResource extends NmnhDigirResource
{
	function 
	NmnhIZDigirResource()
	{
		### CALL PARENT CONSTRUCTOR
		$this->{get_parent_class(__CLASS__)}();

		$this->resourceCode = 'NMNH-IZ';
		$this->resourceRestrictions[] = "CatDepartment = 'Invertebrate Zoology'";

		$this->baseRecordURL = "http://$this->server/$this->webDirName/pages/$this->backendType/$this->department/Display.php?irn=";
		$this->baseGUID = 'urn:lsid:nmnh.si.edu:Invertebrate_Zoology:';
		$this->citation = 'Department of Invertebrate Zoology, Research and Collections Information System, NMNH, Smithsonian Institution. See: http://www.mnh.si.edu/rc/db/collection_db_policy1.html';
		if (isset($this->replicationDate))
			$this->citation .= ', ' . $this->replicationDate;
		
		$this->objectType['S'] = array('specimen/lot');
		$this->objectType['I'] = array('image');

	}

	function 
	getMetadataResource($num, $date, $maxSearch, $maxInv)
	{
		return <<<EOT
					<name>NMNH Invertebrate Zoology Collections</name>
					<code>$this->resourceCode</code>
					<relatedInformation>http://www.nmnh.si.edu/iz</relatedInformation>
					<contact type='Administrative'>
						<name>Cheryl Bright</name>
						<title>NMNH Invertebrate Zoology, Collections Manager</title>
						<emailAddress>brightc@si.edu</emailAddress>
						<phone>+1 202 633 0661</phone>
					</contact>
					<contact type='Administrative'>
						<name>Linda Ward</name>
						<title>NMNH Invertebrate Zoology, Data Manager</title>
						<emailAddress>wardl@si.edu</emailAddress>
						<phone>+1 202 633 1779</phone>
					</contact>
					<abstract>NMNH Invertebrate Zoology Collections records, 8784 Bryozoa, 68401 Coelenterates, 220965 Crustacea, 75012 Echinoderms, 196851 Mollusks, 28853 Porifera, 16466 Tunicates, 171401 Worms, 93268 General, records currently represent approximately 33% of actual specimen holdings, as of 10 May 2007</abstract>
					<keywords>Invertebrate Zoology, Smithsonian, NMNH, Museum, specimen, taxonomy, Bryozoa, Coelenterates, Crustacea, Echinoderms, Mollusks, Porifera, Tunicates, Worms, Corals</keywords>
					<citation>Department of Invertebrate Zoology, Research and Collections Information System, NMNH, Smithsonian Institution. See: http://www.mnh.si.edu/rc/db/collection_db_policy1.html</citation>
					<useRestrictions>See: http://www.mnh.si.edu/rc/db/2data_access_policy.html</useRestrictions>
					<conceptualSchema schemaLocation='http://bnhm.berkeley.edu/DwC/bnhm_dc2_schema.xsd'>http://digir.net/schema/conceptual/darwin/2003/1.0</conceptualSchema>
					<recordIdentifier>USNM</recordIdentifier>
					<recordBasis>voucher</recordBasis>
					<numberOfRecords>$num</numberOfRecords>
					<dateLastUpdated>$date</dateLastUpdated>
					<minQueryTermLength>0</minQueryTermLength>
					<maxSearchResponseRecords>$maxSearch</maxSearchResponseRecords>
					<maxInventoryResponseRecords>$maxInv</maxInventoryResponseRecords>
EOT;
	}
}
//===========================================================================================================================
//===========================================================================================================================
class NmnhPalDigirResource extends NmnhDigirResource
{
	function 
	NmnhPalDigirResource()
	{
		### CALL PARENT CONSTRUCTOR
		$this->{get_parent_class(__CLASS__)}();

		$this->resourceCode = 'NMNH-Paleo';
		$this->resourceRestrictions[] = "CatDepartment = 'Paleobiology'";

		$this->baseRecordURL = "http://$this->server/$this->webDirName/pages/$this->backendType/$this->department/Display.php?irn=";
		$this->baseGUID = 'urn:lsid:nmnh.si.edu:Paleobiology:';
		$this->citation = 'Department of Paleobiology, Research and Collections Information System, NMNH, Smithsonian Institution. See: http://www.mnh.si.edu/rc/db/collection_db_policy1.html';
		if (isset($this->replicationDate))
			$this->citation .= ', ' . $this->replicationDate;

		$this->objectType['S'] = array('specimen/lot', 'specimen');

	}

	function 
	getMetadataResource($num, $date, $maxSearch, $maxInv)
	{
		return <<<EOT
					<name>NMNH Paleobiology Collections</name>
					<code>$this->resourceCode</code>
					<relatedInformation>http://paleobiology.si.edu/</relatedInformation>
					<contact type='Administrative'>
						<name>Jann Thompson</name>
						<title>NMNH Paleobiology, Collections Manager</title>
						<emailAddress>thompson@si.edu</emailAddress>
						<phone>+1 202 633 1357</phone>
					</contact>
					<abstract>NMNH Paleobiology Collections records, records currently represent approximately % of actual specimen holdings</abstract>
					<keywords>Paleobiology, Smithsonian, NMNH, Museum, specimen, taxonomy, paleontology, evolution, geologic time</keywords>
					<citation>Department of Paleobiology, Research and Collections Information System, NMNH, Smithsonian Institution. See: http://www.mnh.si.edu/rc/db/collection_db_policy1.html</citation>
					<useRestrictions>See: http://www.mnh.si.edu/rc/db/2data_access_policy.html</useRestrictions>
					<conceptualSchema schemaLocation='http://bnhm.berkeley.edu/DwC/bnhm_dc2_schema.xsd'>http://digir.net/schema/conceptual/darwin/2003/1.0</conceptualSchema>
					<recordIdentifier>USNM</recordIdentifier>
					<recordBasis>voucher</recordBasis>
					<numberOfRecords>$num</numberOfRecords>
					<dateLastUpdated>$date</dateLastUpdated>
					<minQueryTermLength>0</minQueryTermLength>
					<maxSearchResponseRecords>$maxSearch</maxSearchResponseRecords>
					<maxInventoryResponseRecords>$maxInv</maxInventoryResponseRecords>
EOT;
	}
}
//===========================================================================================================================
//===========================================================================================================================
class NmnhVZBirdsDigirResource extends NmnhDigirResource
{
	function 
	NmnhVZBirdsDigirResource()
	{
		### CALL PARENT CONSTRUCTOR
		$this->{get_parent_class(__CLASS__)}();

		$this->resourceCode = 'NMNH-VZBirds';

		$this->department = 'vz';
		$this->resourceRestrictions[] = "CatDepartment = 'Vertebrate Zoology'";
		$this->resourceRestrictions[] = "CatDivision = 'Birds'";

		$this->baseRecordURL = "http://$this->server/$this->webDirName/pages/$this->backendType/$this->department/DisplayBirds.php?irn=";
		$this->baseGUID = 'urn:lsid:nmnh.si.edu:Vertebrate_Zoology.Birds:';
		$this->citation = 'Division of Birds, Research and Collections Information System, NMNH, Smithsonian Institution. See: http://www.mnh.si.edu/rc/db/collection_db_policy1.html';
		if (isset($this->replicationDate))
			$this->citation .= ', ' . $this->replicationDate;
		
		$this->objectType['S'] = array('specimen/lot');

	}

	function 
	getMetadataResource($num, $date, $maxSearch, $maxInv)
	{
		return <<<EOT
					<name>NMNH Vertebrate Zoology Birds Collections</name>
					<code>$this->resourceCode</code>
					<relatedInformation>http://www.nmnh.si.edu/vert</relatedInformation>
					<contact type='Administrative'>
						<name>James P. Dean</name>
						<title>NMNH Vertebrate Zoology Birds, Collections Manager</title>
						<emailAddress>deanj@si.edu</emailAddress>
						<phone>+1 202 633 0786</phone>
					</contact>
					<contact type='Administrative'>
						<name>Craig A. Ludwig</name>
						<title>NMNH Vertebrate Zoology Birds, Scientific Data Manager</title>
						<emailAddress>ludwigc@si.edu</emailAddress>
						<phone>+1 202 633 1255</phone>
					</contact>
					<abstract>NMNH Vertebrate Zoology BirdsCollections records, records currently represent approximately 65% of actual specimen holdings</abstract>
					<keywords>Vertebrate Zoology, Birds, Smithsonian, NMNH, Museum, specimen, taxonomy, ornithology</keywords>
					<citation>Division of Birds, Research and Collections Information System, NMNH, Smithsonian Institution. See: http://www.mnh.si.edu/rc/db/collection_db_policy1.html</citation>
					<useRestrictions>See: http://www.mnh.si.edu/rc/db/2data_access_policy.html</useRestrictions>
					<conceptualSchema schemaLocation='http://bnhm.berkeley.edu/DwC/bnhm_dc2_schema.xsd'>http://digir.net/schema/conceptual/darwin/2003/1.0</conceptualSchema>
					<recordIdentifier>USNM</recordIdentifier>
					<recordBasis>voucher</recordBasis>
					<numberOfRecords>$num</numberOfRecords>
					<dateLastUpdated>$date</dateLastUpdated>
					<minQueryTermLength>0</minQueryTermLength>
					<maxSearchResponseRecords>$maxSearch</maxSearchResponseRecords>
					<maxInventoryResponseRecords>$maxInv</maxInventoryResponseRecords>
EOT;
	}
}
//===========================================================================================================================
//===========================================================================================================================
class NmnhVZFishesDigirResource extends NmnhDigirResource
{
	function 
	NmnhVZFishesDigirResource()
	{
		### CALL PARENT CONSTRUCTOR
		$this->{get_parent_class(__CLASS__)}();

		$this->resourceCode = 'NMNH-VZFishes';

		$this->department = 'vz';
		$this->resourceRestrictions[] = "CatDepartment = 'Vertebrate Zoology'";
		$this->resourceRestrictions[] = "CatDivision = 'Fishes'";

		$this->baseRecordURL = "http://$this->server/$this->webDirName/pages/$this->backendType/$this->department/DisplayFishes.php?irn=";
		$this->baseGUID = 'urn:lsid:nmnh.si.edu:Vertebrate_Zoology.Fishes:';
		$this->citation = 'Division of Fishes, Research and Collections Information System, NMNH, Smithsonian Institution. See: http://www.mnh.si.edu/rc/db/collection_db_policy1.html';
		if (isset($this->replicationDate))
			$this->citation .= ', ' . $this->replicationDate;

		$this->objectType['S'] = array('specimen/lot');
	}

	function 
	getMetadataResource($num, $date, $maxSearch, $maxInv)
	{
		return <<<EOT
					<name>NMNH Vertebrate Zoology Fishes Collections</name>
					<code>$this->resourceCode</code>
					<relatedInformation>http://www.nmnh.si.edu/vert</relatedInformation>
					<contact type='Administrative'>
						<name>Jeffrey T. Williams</name>
						<title>NMNH Vertebrate Zoology Fishes, Collections Manager</title>
						<emailAddress>williamsjt@si.edu</emailAddress>
						<phone>+1 202 633 1223</phone>
					</contact>
					<abstract>NMNH Vertebrate Zoology Fishes Collection records, records currently represent approximately 55% of actual specimen holdings</abstract>
					<keywords>Vertebrate Zoology, Fishes, Smithsonian, NMNH, Museum, specimen, taxonomy, ichthyology</keywords>
					<citation>Division of Fishes, Research and Collections Information System, NMNH, Smithsonian Institution. See: http://www.mnh.si.edu/rc/db/collection_db_policy1.html</citation>
					<useRestrictions>See: http://www.mnh.si.edu/rc/db/2data_access_policy.html</useRestrictions>
					<conceptualSchema schemaLocation='http://bnhm.berkeley.edu/DwC/bnhm_dc2_schema.xsd'>http://digir.net/schema/conceptual/darwin/2003/1.0</conceptualSchema>
					<recordIdentifier>USNM</recordIdentifier>
					<recordBasis>voucher</recordBasis>
					<numberOfRecords>$num</numberOfRecords>
					<dateLastUpdated>$date</dateLastUpdated>
					<minQueryTermLength>0</minQueryTermLength>
					<maxSearchResponseRecords>$maxSearch</maxSearchResponseRecords>
					<maxInventoryResponseRecords>$maxInv</maxInventoryResponseRecords>
EOT;
	}
}
//===========================================================================================================================
//===========================================================================================================================
class NmnhVZHerpsDigirResource extends NmnhDigirResource
{
	function 
	NmnhVZHerpsDigirResource()
	{
		### CALL PARENT CONSTRUCTOR
		$this->{get_parent_class(__CLASS__)}();

		$this->resourceCode = 'NMNH-VZHerps';
		$this->department = 'vz';
		$this->resourceRestrictions[] = "CatDepartment = 'Vertebrate Zoology'";
		$this->resourceRestrictions[] = "CatDivision = 'Amphibians & Reptiles'";

		$this->baseRecordURL = "http://$this->server/$this->webDirName/pages/$this->backendType/$this->department/DisplayHerps.php?irn=";
		$this->baseGUID = 'urn:lsid:nmnh.si.edu:Vertebrate_Zoology.Herps:';
		$this->citation = 'Division of Amphibians and Reptiles, Research and Collections Information System, NMNH, Smithsonian Institution. See: http://www.mnh.si.edu/rc/db/collection_db_policy1.html';
		if (isset($this->replicationDate))
			$this->citation .= ', ' . $this->replicationDate;
		
		$this->objectType['S'] = array('specimen/lot', 'specimen', 'lot');

	}

	function 
	getMetadataResource($num, $date, $maxSearch, $maxInv)
	{
		return <<<EOT
					<name>NMNH Vertebrate Zoology Herpetology Collections</name>
					<code>$this->resourceCode</code>
					<relatedInformation>http://www.nmnh.si.edu/vert</relatedInformation>
					<contact type='Administrative'>
						<name>Ken Tighe</name>
						<title>NMNH Vertebrate Zoology Herpetology, Data Manager</title>
						<emailAddress>tighek@si.edu</emailAddress>
						<phone>+1 202 633 0735</phone>
					</contact>
					<abstract>NMNH Vertebrate Zoology Herpetology Collections records, records currently represent approximately 99% of actual specimen holdings</abstract>
					<keywords>Vertebrate Zoology, Herpetology, Smithsonian, NMNH, Museum, specimen, taxonomy, reptiles, amphibians</keywords>
					<citation>Division of Amphibians and Reptiles, Research and Collections Information System, NMNH, Smithsonian Institution. See: http://www.mnh.si.edu/rc/db/collection_db_policy1.html</citation>
					<useRestrictions>See: http://www.mnh.si.edu/rc/db/2data_access_policy.html</useRestrictions>
					<conceptualSchema schemaLocation='http://bnhm.berkeley.edu/DwC/bnhm_dc2_schema.xsd'>http://digir.net/schema/conceptual/darwin/2003/1.0</conceptualSchema>
					<recordIdentifier>USNM</recordIdentifier>
					<recordBasis>voucher</recordBasis>
					<numberOfRecords>$num</numberOfRecords>
					<dateLastUpdated>$date</dateLastUpdated>
					<minQueryTermLength>0</minQueryTermLength>
					<maxSearchResponseRecords>$maxSearch</maxSearchResponseRecords>
					<maxInventoryResponseRecords>$maxInv</maxInventoryResponseRecords>
EOT;
	}
}
//===========================================================================================================================
//===========================================================================================================================
class NmnhVZMammalsDigirResource extends NmnhDigirResource
{
	function 
	NmnhVZMammalsDigirResource()
	{
		### CALL PARENT CONSTRUCTOR
		$this->{get_parent_class(__CLASS__)}();

		$this->resourceCode = 'NMNH-VZMammals';
		$this->department = 'vz';
		$this->resourceRestrictions[] = "CatDepartment = 'Vertebrate Zoology'";
		$this->resourceRestrictions[] = "CatDivision = 'Mammals'";

		$this->baseRecordURL = "http://$this->server/$this->webDirName/pages/$this->backendType/$this->department/DisplayMammals.php?irn=";
		$this->baseGUID = 'urn:lsid:nmnh.si.edu:Vertebrate_Zoology.Mammals:';

		$this->citation = 'Division of Mammals, Research and Collections Information System, NMNH, Smithsonian Institution. See: http://www.mnh.si.edu/rc/db/collection_db_policy1.html';
		if (isset($this->replicationDate))
			$this->citation .= ', ' . $this->replicationDate;

		$this->objectType['S'] = array('specimen/lot', 'uncataloged specimen', 'vertebrate paleontology specimen');
		$this->objectType['P'] = array('literature of file reference');
		$this->objectType['O'] = array('observation');

	}

	function 
	getMetadataResource($num, $date, $maxSearch, $maxInv)
	{
		return <<<EOT
					<name>NMNH Vertebrate Zoology Mammals Collections</name>
					<code>$this->resourceCode</code>
					<relatedInformation>http://www.nmnh.si.edu/vert</relatedInformation>
					<contact type='Administrative'>
						<name>Linda K. Gordon</name>
						<title>NMNH Vertebrate Zoology Mammals, Collections Manager</title>
						<emailAddress>gordonl@si.edu</emailAddress>
						<phone>+1 202 633 1251</phone>
					</contact>
					<contact type='Administrative'>
						<name>Craig A. Ludwig</name>
						<title>NMNH Vertebrate Zoology Mammals, Data Manager</title>
						<emailAddress>ludwigc@si.edu</emailAddress>
						<phone>+1 202 633 1255</phone>
					</contact>
					<abstract>NMNH Vertebrate Zoology Mammals Collections records, records currently completely or partially represent all actual specimen holdings</abstract>
					<keywords>Vertebrate Zoology, Mammals, Smithsonian, NMNH, Museum, specimen, taxonomy, marine mammals, mammalogy, whales</keywords>
					<citation>Division of Mammals, Research and Collections Information System, NMNH, Smithsonian Institution. See: http://www.mnh.si.edu/rc/db/collection_db_policy1.html</citation>
					<useRestrictions>See: http://www.mnh.si.edu/rc/db/2data_access_policy.html</useRestrictions>
					<conceptualSchema schemaLocation='http://bnhm.berkeley.edu/DwC/bnhm_dc2_schema.xsd'>http://digir.net/schema/conceptual/darwin/2003/1.0</conceptualSchema>
					<recordIdentifier>USNM</recordIdentifier>
					<recordBasis>voucher</recordBasis>
					<numberOfRecords>$num</numberOfRecords>
					<dateLastUpdated>$date</dateLastUpdated>
					<minQueryTermLength>0</minQueryTermLength>
					<maxSearchResponseRecords>$maxSearch</maxSearchResponseRecords>
					<maxInventoryResponseRecords>$maxInv</maxInventoryResponseRecords>
EOT;
	}
}
?>
