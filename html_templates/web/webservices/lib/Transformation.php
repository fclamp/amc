<?php

/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/lib/BaseWebServiceObject.php');

/**
 * 
 * Transformation Factory
 *
 * Factory class to generate transformation objects.
 * Transformation objects take XML and produce
 * a transformed document
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */
class TransformationFactory
{
	function getInstance($type)
	{
		if ($type == "SimpleTransformation")
			return new SimpleTransformation();
		if ($type == "XsltTransformation")
			return new XsltTransformation();
		if ($type == "raw")
			return new Transformation();

		return null;
	}
}

/**
 * 
 * Class Transformation
 *
 * Transformation is for turning XML into HTML for display.  Actual
 * transformation mechanisms include xslt or 'templatted html' 
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */

class Transformation extends BaseWebServiceObject
{
	function describe()
	{
		return	
			"A Transformation is an object that transforms xml\n".
			"into another format (typically HTML)\n\n".
			parent::describe();
	}

	function transform($dataXml, $source)
	{
		return $dataXml;
	}

	function test($clientSpecific=false,$dir='')
	{
		if (isset($_REQUEST['testCall']))
		{
			header("Content-type: text/html",1);
			print $this->transform($_REQUEST['xml'],$_REQUEST['source']);
		}
		else	
		{
			print $this->makeTestPage();
		}
	}

	function makeTestPage()
	{
		parent::test();
	}
}

/**
 * 
 * Class SimpleTransformation
 *
 * simple transformations take an html page with square bracketted
 * 'templates' and substitutes data from the passed xml
 * appropriately into the templated spots
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */
class SimpleTransformation extends Transformation
{

	function describe()
	{
		return	
			"A Simple Transformation is a Transformation object\n".
			"that uses an HTML 'template' to specify the\n".
			"transformation\n\n".
			parent::describe();
	}
	
	function dynamicReplacement($html)
	{
	/* DYNAMIC blocks allow creation of 'constants' in CSS stylesheet that
	 * can be used in further CSS definitions or in javascript etc.
	 * basically some syntactic sugar to make it easier to do consistent
	 * layouts
	 */
		if (preg_match("/<DYNAMIC>(.+)<\/DYNAMIC>/s",$html,$matches))
		{
			$subs = $matches[1];

			$sublist['external_screenwidth'] = 1200;
			$sublist['crosshairs'] = 'on';
			$sublist['clickzoom'] = 'off';

			foreach (preg_split("/\n/",$subs) as $sub)
			{
				$sub = preg_replace("/\s+$|^\s+/",'',$sub);
				if (preg_match("/=/",$sub))
				{
					$sub = preg_replace("/;.*/",'',$sub);
					list ($arg,$val)  = preg_split("/\s*=\s*/",$sub,2);

					while (preg_match("/(\[(.+?)\])/",$val,$slots))
					{
						list ($all,$param) = array($slots[1],$slots[2]);
						if (isset($sublist[$param]))
						{
							$re = preg_quote($all,'/');
							$val = preg_replace("/$re/",$sublist[$param],$val);
						}
						else
						{
							print ("<!-- in template '$val' not parsing - what is  '$param' ??? -->\n");
							$val = '';
						}
						
						# only eval simple arithmetic strings like 1 + 2 etc
						if (preg_match("/^[0-9.\-+*\/ ]+$/",$val))
						{
							$val = eval("return $val;");
						}
					}
					$sublist[$arg] = $val;
				}
			}
			foreach ($sublist as $arg => $value)
			{
				if (! $value)
					$value = '0';
				$html = preg_replace("/\[$arg\]/",$value,$html);
			}
		}
		return $html;
	}

	function substitute($html,$xml)
	{
		$elements = $this->getWantedElements($html);
		foreach ($elements as $element)
		{
			$args = $this->getElement($xml,$element);
			if ($args)
				foreach ($args as $value)
				{
					$re = preg_quote("[$element]",'/');
					if (preg_match("/$re/",$html))
						$html = preg_replace("/$re/",$value,$html,1);
				}
		}
		return $html;
	}

	function transform($dataXml, $source,$setHeader=true)
	{
		/*  Replace element names in [] with value.
		**  and spit out document.
		*/
		if (is_file($source))
		{
			$fh = fopen($source, "r");
			$html = fread($fh, filesize($source));
			fclose($fh);
		}
		else
		{
			// could be a url to file
			$file = $this->webRoot . preg_replace("/$this->webDirName\//",'',$source);
			if (is_file($file))
			{
				$fh = fopen($file, "r");
				$html = fread($fh, filesize($file));
				fclose($fh);
			}
			else
			{
				// could be a template string
				$html = $source;
		 		if (get_magic_quotes_gpc())
		       			$html=stripslashes($html);
				if (! preg_match('/\[.+\]|\<.+\>/',$html))
					$this->errorResponse("Passed source is not existing file ".
						"nor does it appear to be valid template. (source='$html')");
			}
		}
		if ($setHeader)
			header("Content-type: text/html",true);
		$html = $this->_expandRepeatables($html,$dataXml);
		$html = $this->substitute($html,$dataXml);
		$html = preg_replace("/<repeatableBlock>.*?<\/repeatableBlock>/s",'',$html);

		// at some point will need to change next line to
		// isolate any javascript square brackets somehow -
		// currently will mangle these
		$html = $this->dynamicReplacement($html);
		//return preg_replace("/\[.+\]/",'',$html);
		return $html;
		


	}

	function _expandRepeatables($html,$dataXml)
	{
		/* expand repeatable html blocks based on number of elements in
		 * dataXml xml.  This allows html templates to have a structure
		 * like:
		 *
		 * <repeatableBlock foreach='legendEntry'>
		 *		<input type='checkbox' name='layer' value='[legendEntry/layerName]' />
		 *		<img src='[legendEntry/icon]' /> [legendEntry/displayName] 
		 *		<br/>
	 	 * </repeatableBlock>
		 *
		 * which when expanded will repeat this block for every
		 * legendEntry element in the dataXml XML
		 *
		 */
		if (preg_match_all("/<repeatableBlock\s+foreach=.(.+?).\s*>(.*?)<\/repeatableBlock>/s",$html,$matches))
		{
			foreach ($matches[1] as $expandOn)
			{
				$expandOnRe = preg_replace("/\//","\/",$expandOn);
				$count = preg_match_all("/<$expandOnRe>(.+?)<\/$expandOnRe>/s",$dataXml,$cases);
				if (preg_match("/<repeatableBlock\s+foreach=.$expandOnRe.\s*>(.*?)<\/repeatableBlock>/s",$html,$block))
				{
					$sub = array();
					foreach ($cases[0] as $xmlSnippet)
					{
						$sub[] = $this->substitute($block[1],$xmlSnippet);
					}
					$re = preg_quote($block[0] ,'/');
					$html = preg_replace("/$re/s",
							"<!-- start repeated $expandOn -->\n".
							implode("\n",$sub)
							."\n<!-- end repeated $expandOn -->\n", $html);
				}
			}
		}
		return $html;
	}

	function getElement($dataXml,$element)
	{ 
		// if element is in a 'path' - extract nested component
		if (preg_match("/^(.+)\/(.+)/",$element,$matches))
		{
			list ($all,$pre,$post) = $matches;
			if (preg_match_all("/<$pre>.+?<$post>(.*?)<\/$post>/s",$dataXml,$matches))
				return $matches[1];
			else if (preg_match("/<$pre>.+?<$post\/>/s",$dataXml))
				return array('');
			else
				return '';	
		}
			
		if (preg_match_all("/<$element>(.*?)<\/$element>/s",$dataXml,$matches))
			return $matches[1];
		return '';	
	}

	function getWantedElements($source)
	{ 
		// extracts all square braketted terms in document
		if (preg_match_all("/\[(.*?)\]/s",$source,$matches))
			return $matches[1];
		else
			return array();
	}

	function makeTestPage()
	{
		$args = array();
		$args['XML Data'] = "<textarea cols='65' rows='15' name='xml'>".
			"<xml>\n".
				"\t<larry>Hey I saw em first, gimme my four cents</larry>\n".
				"\t<moe>How 'bout I give you five ?</moe>\n".
				"\t<larry>Oh goody a bonus !</larry>\n".
				"\t<moe>(punches larry)</moe>\n\n".
				"\t<moe>Where were you born?</moe>\n".
				"\t<curly>Lake Winnipesaukee.</curly>\n".
				"\t<moe>Lake Winna...How do you spell that?</moe>\n".
				"\t<curly>Make it Lake Erie.  I got an uncle there.</curly>\n\n".
				"\t<ringo>All I got is a photograph</ringo>\n\n".
			"</xml>\n".
			"</textarea>";
		$args['source'] = "<textarea cols='80' rows='15' name='source'>".
				"<html>\n".
				"<head> <title> <xsl:text>Test Page</xsl:text> </title> </head>\n".
				"<body style='background-color: #7f7f9f;'>\n".
				"</body>\n".
				"\t<b>LARRY 1:</b>[larry]<br/>\n".
				"\t<b>LARRY 2:</b>[larry]<br/>\n".
				"\t<b>CURLY 1:</b>[curly]<br/>\n".
				"\t<b>CURLY 2:</b>[curly]<br/>\n".
				"\t<b>RINGO 1:</b>[ringo]<br/>\n".
				"\t<b>MOE 1:</b>[moe]<br/>\n".
				"\t<b>MOE 2:</b>[moe]<br/>\n".
				"\t<b>MOE 3:</b>[moe]<br/>\n".
				"\t<b>MOE 4:</b>[moe]<br/>\n".
				"\t<repeatableBlock foreach='moe'>\n".
				"\t\tMoe: <i>[moe]</i><br/>\n".
				"\t</repeatableBlock>\n".
				"</html>\n".
				"</textarea>";
		$vars = array();
		$vars['class'] = 'SimpleTransformation';
		$vars['test'] = 'true';
		$vars['testCall'] = 'true';
		$submission = "<input type='submit' name='action' value='transform' />";
		return $this->makeDiagnosticPage(
					'Test Simple Templated Transformation',
					'simple test',
					'',
					'./Transformation.php',
					$args,
					$submission,
					$vars,
					$this->describe()
				);
	}

}

/**
 * 
 * Class XsltTransformation
 *
 * xslt transformations use XSLT to do transformation
 * OK - I know that is obvious
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */
class XsltTransformation extends Transformation
{

	function xslt_error_handler($handler, $errno, $level, $info)
	{
		$array = func_get_args();
	    $this->_debug('xmlerr',$array,1);
	}

	function transform($dataXml, $source, $handleErrors=true)
	{
		/*  Run XSLT processor with $source passing $dataXml as
		**  elements as parameters. The stylesheet is in 
		**  $_REQUEST['stylesheet'].
		*/

		$re = preg_quote($this->webDirName,'/');
		$source = preg_replace("/^\/$re/",$this->webRoot,$source);

		$arguments = Array ( '/_xml' => $dataXml);
	
		// test for actual xsl string in variable if not a file name
		if (! is_file($source))
		{
			if (preg_match('/stylesheet>/',$source))
			{
				$arguments['/_xsl'] = $source;
				$source =  'arg:/_xsl';
			}
			else
			{
				return "<!-- FAIL\nXsltTransformation\nCannot find stylesheet: '$source' -->\n".
				$dataXml;
			}	
		}
			

		$xh = xslt_create();
		if ($handleErrors)
			xslt_set_error_handler($xh, array($this, xslt_error_handler));
		xslt_set_log($xh, false);
		xslt_set_log($xh, '/tmp/myfile.log');
			
		if (! $html = xslt_process($xh, 'arg:/_xml', $source, null, $arguments))
		{
			$html =  "<!-- FAIL\nXsltTransformation\n".
				"Error: ". xslt_error($xh) . "\n".
				"Code: " . xslt_errno($xh) ."\n-->";
		}
	
		xslt_free($xh);
		return $html;
	}

	function describe()
	{
		return	
			"A XsltTransformation is a Transformation object\n".
			"that uses an XSLT stylesheet to specify the\n".
			"transformation\n\n".
			parent::describe();
	}

	function makeTestPage()
	{
		$args = array();
		$args['XML Data'] = "<textarea cols='65' rows='15' name='xml'>".
			"<xml>\n".
				"\t<larry>Hey I saw em first, gimme my four cents</larry>\n".
				"\t<moe>How bout I give you five ?</moe>\n".
				"\t<larry>Oh goody a bonus !</larry>\n".
				"\t<moe>(punches larry)</moe>\n\n".
				"\t<moe>Where were you born?</moe>\n".
				"\t<curly>Lake Winnipesaukee.</curly>\n".
				"\t<moe>Lake Winna...How do you spell that?</moe>\n".
				"\t<curly>Make it Lake Erie.  I got an uncle there.</curly>\n\n".
				"\t<ringo>All I got is a photograph</ringo>\n\n".
			"</xml>\n".
			"</textarea>";
		$args['source'] = '<input type="text" name="source" size="40" value="'. $this->webRoot .'/webservices/lib/test.xsl" />';
		$vars = array();
		$vars['class'] = 'XsltTransformation';
		$vars['test'] = 'true';
		$vars['testCall'] = 'true';
		$submission = "<input type='submit' name='action' value='transform' />";
		return $this->makeDiagnosticPage(
					'Test XSLT Transformation',
					'simple test',
					'',
					'./Transformation.php',
					$args,
					$submission,
					$vars,
					$this->describe()
				);
	}
}

if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'Transformation.php')
	{
		if ($_REQUEST["class"] == 'Transformation')
			$_REQUEST["class"] = 'SimpleTransformation';

		$transformationFactory = new TransformationFactory();
		$transformer = $transformationFactory->getInstance($_REQUEST["class"]);

		if ($transformer)
			print $transformer->test();
		else
			BaseWebServiceObject::errorResponse("Cannot create instance of ".$_REQUEST["class"]. " in Transformation.php");
	}	
}

?>
