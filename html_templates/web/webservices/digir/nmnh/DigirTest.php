<?php

/* 
**  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (! isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/digir/DigirTest.php');

class NmnhDigirTest extends DigirTest
{
	var $serviceName = 'NmnhDigirTest';
	var $serviceDirectory = 'webservices/digir';

	function 
	describe()
	{
		return "An NmnhDigirTest is a rudimentary client-specific testing platform for digir requests\n\n" . parent::describe();
	}

	function 
	buildRequest()
	{
		GLOBAL $BACKEND_ENV;
		if (isset($BACKEND_ENV))
			$type = $BACKEND_ENV;
		else if (isset($_REQUEST['resource']))
			$type = $_REQUEST['resource'];
		else
			return;

		switch (strtolower($type))
		{
			case 'bot':
			case 'nmnh-botany':
				$this->resourceCode = 'NMNH-Botany';
				$this->testQueryField = 'Species';
				$this->testQueryValue = 'reticularis';
				break;
			case 'ento':
			case 'nmnh-entomology':
				$this->resourceCode = 'NMNH-Entomology';
				$this->testQueryField = 'Species';
				$this->testQueryValue = 'abbotti';
				break;
			case 'iz':
			case 'nmnh-iz':
				$this->resourceCode = 'NMNH-IZ';
				$this->testQueryField = 'Species';
				$this->testQueryValue = 'latidactylus';
				break;
			case 'vzbirds':
			case 'nmnh-vzbirds':
				$this->resourceCode = 'NMNH-VZBirds';
				$this->testQueryField = 'Species';
				$this->testQueryValue = 'minullus';
				break;
			case 'vzfishes':
			case 'nmnh-vzfishes':
				$this->resourceCode = 'NMNH-VZFishes';
				$this->testQueryField = 'Species';
				$this->testQueryValue = 'alpinus';
				break;
			case 'vzherps':
			case 'nmnh-vzherps':
				$this->resourceCode = 'NMNH-VZHerps';
				$this->testQueryField = 'Species';
				$this->testQueryValue = 'nebulosus';
				break;
			case 'vzmammals':
			case 'nmnh-vzmammals':
				$this->resourceCode = 'NMNH-VZMammals';
				$this->testQueryField = 'Species';
				$this->testQueryValue = 'aerosus';
				break;
			default:
				return;
				break;
		}

                $this->request['DiGIR All Metadata Request'] = '';

                $this->request['DiGIR Metadata Request'] = <<<EOT
<request xmlns='http://www.namespaceTBD.org/digir'
	 xmlns:xsd='http://www.w3.org/2001/XMLSchema'
	 xmlns:darwin='http://digir.net/schema/conceptual/darwin/2003/1.0'
	 xmlns:dwc='http://digir.net/schema/conceptual/darwin/2003/1.0'>
	<header>
		<version>1.0.0</version>
		<sendTime>1970-01-01 10:00:00.00Z</sendTime>
		<source>si.edu</source>
		<destination resource='$this->resourceCode'>$this->accessPoint</destination>
		<type>metadata</type>
	</header>
</request>
EOT;

                $this->request['DiGIR Search Request'] = <<<EOT
<request xmlns='http://www.namespaceTBD.org/digir'
	 xmlns:xsd='http://www.w3.org/2001/XMLSchema'
	 xmlns:darwin='http://digir.net/schema/conceptual/darwin/2003/1.0'
	 xmlns:dwc='http://digir.net/schema/conceptual/darwin/2003/1.0'>
	<header>
		<version>1.0.0</version>
		<sendTime>1970-01-01 10:00:00.00Z</sendTime>
		<source>si.edu</source>
		<destination resource='$this->resourceCode'>$this->accessPoint</destination>
		<type>search</type>
	</header>
	<search>
		<filter>
			<equals>
				<darwin:$this->testQueryField>$this->testQueryValue</darwin:$this->testQueryField>
			</equals>
		</filter>
		<records start='0' limit='100'>
			<structure schemaLocation='http://$this->server/$this->webDirName/webservices/digir/style/darwin.xsd'/>
		</records>
	</search>
</request>
EOT;

                $this->request['DiGIR Inventory Request'] = <<<EOT
<request xmlns='http://www.namespaceTBD.org/digir'
	 xmlns:xsd='http://www.w3.org/2001/XMLSchema'
	 xmlns:darwin='http://digir.net/schema/conceptual/darwin/2003/1.0'
	 xmlns:dwc='http://digir.net/schema/conceptual/darwin/2003/1.0'>
	<header>
		<version>1.0.0</version>
		<sendTime>1970-01-01 10:00:00.00Z</sendTime>
		<source>si.edu</source>
		<destination resource='$this->resourceCode'>$this->accessPoint</destination>
		<type>inventory</type>
	</header>
	<inventory>
		<filter>
			<equals>
				<darwin:$this->testQueryField>$this->testQueryValue</darwin:$this->testQueryField>
			</equals>
		</filter>
		<darwin:ScientificName/>
		<count>true</count>
	</inventory>
</request>
EOT;

                $this->request['DiGIR Inventory (Unfiltered) Request'] = <<<EOT
<request xmlns='http://www.namespaceTBD.org/digir'
	 xmlns:xsd='http://www.w3.org/2001/XMLSchema'
	 xmlns:darwin='http://digir.net/schema/conceptual/darwin/2003/1.0'
	 xmlns:dwc='http://digir.net/schema/conceptual/darwin/2003/1.0'>
	<header>
		<version>1.0.0</version>
		<sendTime>1970-01-01 10:00:00.00Z</sendTime>
		<source>si.edu</source>
		<destination resource='$this->resourceCode'>$this->accessPoint</destination>
		<type>inventory</type>
	</header>
	<inventory>
		<darwin:$this->testQueryField/>
		<count>true</count>
	</inventory>
</request>
EOT;
	}
}

$webservice = new NmnhDigirTest();
$webservice->buildRequest();
$webservice->testPage();
?>
