<?php
/*
*   Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'texquery.php');

/*
** MediaImage - A class for placing images on a page.
**	Previously located in common.php
*/
class
MediaImage extends BaseWebObject
{
	var $IRN;
	var $Width = 190;
	var $Height = 190;
	var $BorderColor = '';
	var $BorderWidth = 1;
	var $HighLightColor = '';
	var $KeepAspectRatio = 1;
	var $ShowBorder = 1;
	var $Intranet = 0;
	var $Link = 'DEFAULT';  //Defaults to full image if not set
	var $NewWindow = 0;	// Opens a new browser window if set to 1
	var $RefIRN = '';
	var $RefTable = '';
	var $UseAbsoluteLinks = 0;
	var $WebFormats = "jpeg gif png"; // Allowed formats - edit this to allow others than gif or jpeg
	var $FullSize = 0;      // If 1, shows maximum size available
	var $StyleSize = 0;	// If 1, replace set Width and Height with CSS elements (needs CSS to be written as well!)
	var $AltField = "MulTitle";

	// Private Variables - call helper functions to return these.
	
	// Private array used to store list of available image sizes,
	//	sorted so largest Width element is index 0, elements
	//	are strings formatted as {width}x{height}.
	// - Returned by $this->GetAvailableSizes()
	var $_ImageSizes = array();

	// Result of only query necessary
	// - Returned by $this->getResult()
	var $_Result;
	
	function
	getResult()
	{

		if ( !empty($this->_Result) )
			return $this->_Result;

		$qry = new ConfiguredQuery();
		$qry->Select = array("ChaImageWidth", 
			"ChaImageHeight", 
			"DocWidth_tab", 
			"DocHeight_tab", 
			"DocMimeFormat_tab",
			"MulMimeType",
			"MulMimeFormat",
			$this->AltField,
			"MulDocumentType",
			"MulIdentifier"
			);
		$qry->From = 'emultimedia';
		$qry->Where = "irn=" . $this->IRN;
		$qry->Intranet = $this->Intranet;
		$res = $qry->Fetch();

		if ($qry->Status == 'failed')
		{
			print $qry->Where;
			WebDie ('Query Error - Texxmlserver: ' . 
				$qry->Error , 
				'where: ' . $where);
		}

		$this->_Result = $res[0];

		return $this->_Result;
	}

	function
	GetClosestSize($ZoomPc)
	{
		//$os = $this->GetOriginalSize();
		$origsize = new Size();
		//$origsize->Width = $os["Width"];
		//$origsize->Height = $os["Height"];
		$origsize->SetSize( $this->GetLargestSize() );

		$reqsize = new Size();
		$reqsize->Width = $origsize->Width * ( $ZoomPc / 100. );
		$reqsize->Height = $origsize->Height * ( $ZoomPc / 100. );
		$reqdiag = $reqsize->Diagonal();
		
		$sizes = $this->GetAvailableSizes();
		$numsizes = count($sizes);
		$bestsize = new Size();
		$sz = new Size();
		$bestdiff = 0;
		for( $i = 0; $i <= $numsizes; $i++)
		{
			$sz->SetSize($sizes[$i]);
			$szdiag = $sz->Diagonal();
			$szdiff = abs($szdiag - $reqdiag);

			if ($szdiff < $bestdiff || 0 == $i)
			{
				$bestdiff = $szdiff;
				$bestsize->Width = $sz->Width;
				$bestsize->Height = $sz->Height;
			}
		}

		return $bestsize->GetSize();
	}

	function
	GetOriginalSize()
	{
		$result = $this->getResult();
	
		return array(
			"Width" 	=> $result->{"ChaImageWidth"},
			"Height" 	=> $result->{"ChaImageHeight"}
			);
	}

	function
	GetLargestSize()
	{
		$sizes = $this->GetAvailableSizes();
		return $sizes[0];
	}

	
	function
	GetAvailableSizes()
	{
		if ( empty($this->_ImageSizes) )
		{
			// Build array if not already present
			$result = $this->getResult();
			
			$i = 1;
			$maxside = 0;
			if ($this->Intranet)
			{
				if (isset($GLOBALS["MAX_INTRANET_IMAGE_SIDE"]))
					$maxside = $GLOBALS["MAX_INTRANET_IMAGE_SIDE"];
			}
			else
			{
				if (isset($GLOBALS["MAX_INTERNET_IMAGE_SIDE"]))
					$maxside = $GLOBALS["MAX_INTERNET_IMAGE_SIDE"];
			}
			while (1)
			{
				$height = $result->{"DocHeight:$i"};
				$width	= $result->{"DocWidth:$i"};
				$format = $result->{"DocMimeFormat:$i"};

				if ($height == '')
					break;
				if ($format == '')
					$format = 'unknown';
				$match = strpos( strtolower($this->WebFormats), strtolower($format) );
				if ( $match === false )
				{
					$i++;
					continue;
				}
				if ( $maxside > 0 )
				{
					if ($height > $maxside || $width > $maxside)
					{
						$i++;
						continue;
					}
				}
				array_push($this->_ImageSizes, "$width" . "x" . "$height");
				$i++;
			}
			// Remove duplicate sizes from list - not point having them
			$this->_ImageSizes = array_unique($this->_ImageSizes);
			rsort($this->_ImageSizes, SORT_NUMERIC);
			
			if (empty($this->_ImageSizes))
			{
				// Still empty
				$width = $result->{"ChaImageWidth"};
				$height = $result->{"ChaImageHeight"};

                                // check that maxside is not empty - if it is load singular height and
                                // width so that at least one image can display
                                if (empty($maxside))
                                {
					if (!empty($height) && !empty($width))	
						array_push($this->_ImageSizes, "$width" . "x" . "$height");
                                }
                                else
                                {
					if (!empty($height) && !empty($width) && $width < $maxside && $height < $maxside)
						array_push($this->_ImageSizes, "$width" . "x" . "$height");
				}
			}
		}
		return $this->_ImageSizes;		
	}

	function
	HasLargerSize()
	{
		$sizes = $this->GetAvailableSizes();
		
		foreach ($sizes as $size)
		{
			preg_match( "/(\d+)x(\d+)/", $size, $matches);
			if ( ($matches[1] > $this->Width) || ($matches[2] > $this->Height) )
				return 1;
		}
		return 0;
	}

	function
	HasSmallerSize()
	{
		$sizes = $this->GetAvailableSizes();

		foreach ($sizes as $size)
		{
			preg_match( "/(\d+)x(\d+)/", $size, $matches);
			if ( ($matches[1] < $this->Width) || ($matches[2] < $this->Height) )
				return 1;
		}
		
		return 0;
	}

	function
	IsImage()
	{
		$result = $this->getResult();
		$mimetype = $result->MulMimeType . "/" . $result->MulMimeFormat;
		if ( strpos($mimetype, 'jpg') > 0 || strpos($mimetype, 'jpeg') > 0
			|| strpos($mimetype, 'gif') > 0 || strpos($mimetype, 'png') > 0 )
		{
			return 1;
		}
		else
			return 0;
	}

	function
	HasWebImage()
	{
		$sizes = $this->GetAvailableSizes();
		if (!empty($sizes))
			return 1;
		else
			return 0;
	}

	function
	IsUrl()
	{
		/*
		*  Test for MulDocumentType set to "U" (hard coded in EMu client)
		*/
		$result = $this->getResult();
		return ("U" == $result->MulDocumentType) ? 1 : 0;
	}

	
	function
	Show()
	{
		if ($this->KeepAspectRatio && is_numeric($this->IRN))
		{
			$maxsize = $this->GetLargestSize();
			$maxh = $maxw = "";
			if (preg_match("/(\\d+)x(\\d+)/", $maxsize, $matches))
			{
				$maxw = $matches[1];
				$maxh = $matches[2];
			}
			$height = $width = 0;
			if (! $maxw == "")
			{
				$imageWidth = (float) intval($maxw);
				$imageHeigth = (float) intval($maxh);
				$wscale = $imageWidth/((float) $this->Width);  
				$hscale = $imageHeigth/((float) $this->Height);
				$scaleFactor = ($wscale < $hscale ? $hscale : $wscale);
				/* don't enlarge if already small enough */
				/* FIXME - add this as a property */
				if ($scaleFactor < 1.0)
					$scaleFactor = 1.0;

				if ($this->FullSize)
				{
					$width = $imageWidth;
					$height = $imageHeigth;
				}
				else
				{
					$width = intval($imageWidth / $scaleFactor);
					$height = intval($imageHeigth / $scaleFactor);
				}

			}
			if ($width == 0 || $height == 0)
			{
				$width = intval($this->Width);
				$height = intval($this->Height);
			}
		}
		else
		{
			$width = intval($this->Width);
			$height = intval($this->Height);
		}

		if ($this->ShowBorder)
		{
			$pad = intval(0.10 * ($width < $height ? $width : $height));
			if ($pad < 10) $pad = 10;
			if ($pad > 60) $pad = 60;
		}
		else
			$pad = 0;

		print "<!--START IMAGE-->\n";
		if ($this->ShowBorder)
		{
			print "<table width=\"" . $width . "\" border=\"";
			print $this->BorderWidth;
			print "\" cellspacing=\"0\" cellpadding=\"2\"";
			print " height=\"" . $height . "\" bordercolor=\"" . $this->BorderColor . "\">\n"; 
			print "	  <tr align=\"center\" valign=\"middle\">\n";
		}
		
		if ($this->Intranet)
			$mediaurl = $GLOBALS['INTRANET_MEDIA_URL'];
		else
			$mediaurl = $GLOBALS['MEDIA_URL'];

		$iwidth = $width - $pad;
		$iheight = $height - $pad;

		if (is_numeric($this->IRN))
		{
			$imgsrc = "$mediaurl?irn=" . $this->IRN;
			if ($this->Link == 'DEFAULT' && $this->IsUrl())
			{
				// FIXME - UseAbsoluteLinks will incorrecly prefix this.
				$result = $this->getResult();
				$this->Link = $result->{"MulIdentifier"};
			}
			elseif ($this->Link == 'DEFAULT')
			{
				if (($this->IsImage() || $this->HasWebImage()) && !$GLOBALS['LINK_DIRECT_TO_IMAGE'])
				{
					$imageurl = $this->ImageDisplayPage;
					$this->Link = "$imageurl?irn=" . $this->IRN;
				}
				else
				{
					$this->Link = "$mediaurl?irn=" . $this->IRN;
				}
				if ($this->RefTable != '')
					$this->Link .= '&amp;reftable=' . $this->RefTable;
				if ($this->RefIRN != '')
					$this->Link .= '&amp;refirn=' . $this->RefIRN;
			}

			// Use thumb version if image is small
			if (intval($iwidth) <= 90 && intval($iheight) <= 90)
				$imgsrc .= '&amp;thumb=yes';
			else
			{
				$s = urlencode($iwidth . "x" . $iheight);
				$imgsrc .= "&amp;size=$s&amp;image=yes";
			}
		}
		else
		{
			// Use thumb version if image is small
			if (intval($iwidth) <= 90 && intval($iheight) <= 90)
				$imgsrc = $GLOBALS['WEB_NOIMAGE_THUMB'];
			else
			{
				// Blank out width and height to prevent noimage
				// image being scaled incorrectly
				$iwidth = $iheight = "";
				$imgsrc = $GLOBALS['WEB_NOIMAGE_GRAPHIC'];
			}
			if ($this->Link == 'DEFAULT')
				$this->Link = '';
		}

		$servername = "";
		if ($this->UseAbsoluteLinks)
			$servername = "http://" . $GLOBALS['HTTP_SERVER_VARS']['SERVER_NAME'];

		if ($this->ShowBorder)
		{
			print "	    <td";
			if ($this->HighLightColor != '' && $this->Link != '')
			{
				print ' onmouseover="this.style.background=\'' . $this->HighLightColor .  '\'"';
				print " onmouseout=\"this.style.background=''\"";
			}
			print ">\n";
		}

		if ($this->Link != '')
		{
			if (is_numeric($this->IRN) && $this->IsUrl())
				print '<a target="_blank" href="' . $this->Link . '">';
			elseif ($this->NewWindow == 1)
				print '<a target="_blank" href="' . $servername . $this->Link . '">';
			else
				print '<a href="' . $servername . $this->Link . '">';
		}

		print "<img src=\"$servername$imgsrc\"";
		if ($this->StyleSize == 1)
			print ' style="width:'.($iwidth/10).'em;height:'.($iheight/10).'em;"';
		elseif ($this->StyleSize == 0)
		{
			print ' width="' . $iwidth . '"';
			print ' height="' . $iheight . '"';
		}
		if (! is_numeric($this->IRN))
			print ' alt="' . $this->_STRINGS['NO IMAGE'] . '"'; 
		else
		{
			$result = $this->getResult();
			$field = $this->AltField;
			print ' alt="' . $result->{$field} . '"'; 
		}

		print ' align="middle" border="0" />';

		if ($this->Link != '')
			print "</a>";

		if ($this->ShowBorder)
		{
			print "      </td>\n";
			print "	  </tr>\n";
			print "</table>\n";
		}
		print "<!--END IMAGE-->";
	}
}

class
Size
{
        var $Width;
        var $Height;

        function
        Size( $w = 0, $h = 0)
        {
                $this->Width = $w;
                $this->Height = $h;
        }

        function
        SetSize($size)
        {
                if ( !preg_match( "/(\d+)x(\d+)/", $size, $matches) )
                        return 0;
                $this->Width = (int) $matches[1];
                $this->Height = (int) $matches[2];
                return 1;
        }

        function
        GetSize()
        {
                return $this->Width . "x" . $this->Height;
        }
	
	function
	Diagonal()
	{
		return sqrt( ($this->Width * $this->Width) + ($this->Height * $this->Height) );
	}
}

?>
