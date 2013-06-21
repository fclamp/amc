<?php
/*
*   Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'MediaImage.php');
require_once ($LIB_DIR . 'common.php');

/*
** ImageDisplay - A class for displaying images, available sizes and zoom controls on a page.
**	Written by Alex
**
** Usage:-
**
**Public Properties:-
**	IRN -			MUST be set either on page or via url. Page dies otherwise.
**	Zoom -			Can be sent to page via url to specify initial zoom level. Selects closest
**				available size. Parameter is removed from URL after first use and replaced
**				with 'size'; should therefore NOT be set on page.
**	ZoomInImage -		Specifies the location of the image used when the Zoom In control is
**				enabled. If unset, the link 'Zoom In' is used instead. Must be set on page.
**	ZoomOutImage -		Specifies the location of the image used when the Zoom Out control is
**				enabled. If unset, the link 'Zoom Out' is used instead. Must be set on
**				page.
**	NoZoomInImage - 	Specifies the location of the image used when the Zoom In control is
**				disabled (i.e. no larger images are available). If empty no image is
**				displayed. Must be set on page.
**	NoZoomOutImage -	Specifies the location of the image used when the Zoom Out control is
**				disabled (i.e. no smaller images are available). If empty no image is
**				displayed. Must be set on page.
**	
**Public Methods:-
**	ImageDisplay() -	(Constructor) Parses URL and sets variables. Initialises MediaImage member.
**	Show() -		Shows the generic page. Constructs a table and calls DisplayNavBar() and
**				DisplayImage().
**	DisplayNavBar() -	Displays the choice of image sizes, the zoom in and zoom out controls.
**				All elements are displayed inside a table with 60% width devoted to image
**				sizes, 20% Zoom In control and 20% Zoom Out. To have more control over the
**				positioning of these controls, use DisplaySizeBox(), DisplayZoomIn() and
**				DisplayZoomOut() seperately.
**	DisplayImage() - 	Displays the image by calling MediaImage::Show().
**	DisplaySizeBox() - 	Displays the drop-down containing the list of available sizes, the 'Go'
**				button and the prompt. Drop down submits automatically via javascript when
**				changed, or submit is via 'Go' button if javascript is not available.
**	DisplayZoomIn( $image="" ) -	Displays the Zoom In control. Control is displayed as text link if property
**				ZoomInImage is not set, displays image otherwise. If no larger images available,
**				displays nothing if NoZoomInImage is not set, or image otherwise. Image
**				location can be optionally supplied as parameter.
**	DisplayZoomOut( $image="" ) -	Displays the Zoom Out control. Usage as DisplayZoomIn().
**	SetImageDisplayPage( $link ) -	Sets the link on the image itself. This defaults to webmedia.php and is set
**				in the constructor. IRN will be appended automatically to the url.
**
**Private/Protected Properties:-
**	width -			Used internally to keep track of width.
**	height -		Used internally to keep track of height.
**	_Image -		MediaImage object. The underlying image.
**
**Private/Protected Methods:-
**	setupImage() -		Must be called before any methods of _Image are called. Synchronises width, height
**				and IRN with _Image. Internals of MediaImage ensure query is only performed once.
**	getUrlParams() - 	Returns array of all parameters in URL.
**	getNextSizeUp() -	Examines list of available sizes as returned by MediaImage::GetAvailableSizes(),
**				matches with current size and returns next size up in format {width}x{height}.
**	getNextSizeDown() - 	As above. Returns next size down.
**	buildSizeSelectArray()- builds and returns an array of strings in the form '<option value="WIDTHxHEIGHT">[Dropdown text]</option>',
**				and adds a 'selected="selected"' to the size that is currently displayed. Array is then walked in
**				DisplaySizeBox(). Override this	to change the available options in the size dropdown.
*/
class
ImageDisplay extends BaseWebObject
{
        var $IRN;
        var $Zoom = 0;
        var $ZoomInImage = '';
        var $NoZoomInImage = '';
        var $ZoomOutImage = '';
        var $NoZoomOutImage = '';
        var $width = 0;
        var $height = 0;
	var $initialWidth = 0;
	var $TableAlign = 'center';
	
	var $_alreadySetup = 0;
        var $_Image;

        function
        ImageDisplay()
        {

                global $ALL_REQUEST;
                
                if (isset($ALL_REQUEST['irn']))
                        $this->IRN = $ALL_REQUEST['irn'];

                if (isset($ALL_REQUEST['size']))
                {
                        preg_match( "/(\d+)x(\d+)/", $ALL_REQUEST['size'], $matches);
                        $this->width = (int) $matches[1];
                        $this->height = (int) $matches[2];
                }
                elseif (isset($ALL_REQUEST['zoom']))
		{
                        $this->Zoom = $ALL_REQUEST['zoom'];
			
		}
		else
		{
			$this->initialWidth = $GLOBALS['INITIAL_IMAGE_WIDTH'];
		}

		$this->ZoomInImage = "/" . $GLOBALS['WEB_DIR_NAME'] . "/objects/images/ZoomIn.jpg";
		$this->ZoomOutImage = "/" . $GLOBALS['WEB_DIR_NAME'] . "/objects/images/ZoomOut.jpg";
		$this->NoZoomInImage = "/" . $GLOBALS['WEB_DIR_NAME'] . "/objects/images/NoZoomIn.jpg";
		$this->NoZoomOutImage = "/" . $GLOBALS['WEB_DIR_NAME'] . "/objects/images/NoZoomOut.jpg";
                
                $this->_Image = new MediaImage();
		$this->_Image->ShowBorder = 0;

		$this->BaseWebObject();
        }

        function
        Show()
        {
		print "<div align=\"" . $this->TableAlign . "\">";
		print "<br />\n<table width=\"100%\" border=\"0\">\n<tr>\n<td width=\"100%\" align=\"center\">\n";
                $this->DisplayImage();
		print "</td>\n</tr>\n<tr>\n<td align=\"center\">\n";
		$notes = $this->Notes;
		print "<br />\n";
		PPrint ($notes, $this->FontFace, '1', $this->BodyTextColor, '', 1);
		print "\n</td>\n</tr>\n";
		if ($this->Intranet == 1)
		{
			print "<tr>\n<td align=\"left\">\n";
			$this->DisplayImageOnlyLink();
			print "\n</td>\n</tr>\n</table>\n";
		}
		else
			print "\n</table>\n";
		print "</div>";
        }
        
        function
        setupImage()
        {
                if ( !is_numeric($this->IRN) )
                {
                        WebDie("Irn must be set in ImageDisplay");
                }

		if ($this->_alreadySetup)
			return;

                $this->_Image->IRN = $this->IRN;
                $this->_Image->Intranet = $this->Intranet;
		if ($this->Intranet)
			$this->_Image->ImageDisplayPage = $GLOBALS['INTRANET_MEDIA_URL'];
		else
			$this->_Image->ImageDisplayPage = $GLOBALS['MEDIA_URL'];

		if( !empty($this->Zoom) )
		{
			$bestsize = $this->_Image->GetClosestSize($this->Zoom);
			preg_match( "/(\d+)x(\d+)/", $bestsize, $matches);
			$this->_Image->Width = $this->width = (int) $matches[1];
                        $this->_Image->Height = $this->height = (int) $matches[2];
		}
                elseif ( !empty($this->width) && !empty($this->height) )
                {
			$origsize = new Size();
 			$origsize->SetSize($this->_Image->GetLargestSize());
			if (empty($origsize->Width))
				WebDie("This image cannot be displayed", "ChaImageWidth of multimedia record is empty, or all sizes are larger than maximum permitted");
			$ratio = ((((int)$this->width) / $origsize->Width) * 100);
			$bestsize = new Size();
			$bestsize->SetSize($this->_Image->GetClosestSize($ratio));
                        $this->_Image->Width = $this->width = $bestsize->Width;
                        $this->_Image->Height = $this->height = $bestsize->Height;
                }
		elseif ( !empty($this->initialWidth) )
		{
			$bestsize = new Size();
			$origsize = new Size();
			$origsize->SetSize($this->_Image->GetLargestSize());
			if (empty($origsize->Width))
				WebDie("This image cannot be displayed", "ChaImageWidth of multimedia record is empty, or all sizes are larger than maximum permitted");
			$neededZoom = ( $this->initialWidth / $origsize->Width ) * 100;
			$bestsize->SetSize( $this->_Image->GetClosestSize($neededZoom) );
			if ( empty($bestsize->Width) || empty($bestsize->Height) )
				$bestsize->SetSize( "300x300" );
			if ($bestsize->Width > $this->initialWidth || $bestsize->Height > $this->initialWidth)
			{
				// Closest Size is larger than that requested in CONFIG, get smaller.
				$this->_Image->Width = $this->width = $bestsize->Width;
				$this->_Image->Height = $this->height = $bestsize->Height;
				$bestsize->SetSize( $this->getNextSizeDown() );
				if ( !empty($bestsize->Width) || !empty($bestsize->Height) )
				{
					// Now set size to smaller
					$this->_Image->Width = $this->width = $bestsize->Width;
					$this->_Image->Height = $this->height = $bestsize->Height;
				}
			}
			else
			{
				$this->_Image->Width = $this->width = $bestsize->Width;
				$this->_Image->Height = $this->height = $bestsize->Height;
			}
			// reject if thumbnail
			if (!$this->_Image->HasSmallerSize())
			{
				if ($this->_Image->HasLargerSize())
				{
					$bestsize = new Size();
					$bestsize->SetSize($this->getNextSizeUp());
					$this->_Image->Width = $this->width = $bestsize->Width;
					$this->_Image->Height = $this->height = $bestsize->Height;
				}
			}
		}
                else
                {
			$origsize = new Size();
                        $origsize->SetSize( $this->_Image->GetLargestSize());
			if (empty($origsize->Width) || empty($origsize->Height))
				WebDie("This image cannot be displayed", "ChaImageWidth or ChaImageHeight of multimedia record is empty, or all sizes are larger than maximum permitted");
                        $this->_Image->Width = $this->width = $origsize->Width;
                        $this->_Image->Height = $this->height = $origsize->Height;
                }

		$this->_alreadySetup = 1;
        }

        function
        DisplayImage()
        {
                $this->setupImage();
                $this->_Image->Show();
        }

        function
        DisplaySizeBox()
        {
                $this->setupImage();        
		$this->sourceStrings();
                
		$sizeprompt = $this->_STRINGS['AVAILABLE SIZES'];
		
                $self = WebSelf();
		print "<div align=\"left\">\n";
                print "$sizeprompt<br />";
                print "<form method=\"post\" action=\"$self\">\n";
                //print "<input type=\"hidden\" name=\"irn\" value=\"" . $this->IRN . "\" />\n";
                
                $UrlParams = $this->getUrlParams();                
                while(list($key, $val) = each($UrlParams))
                { 
                        // Don't pass through empty vars 
                        //  - try to keep url length down
			// Don't pass through 'zoom'
                        if ($val == "")
                                continue;
                        if (/*$key != "irn" &&*/ $key != "size" && $key != "zoom")
                        {
                                print "<input type=\"hidden\" name=\"$key\" value=\"$val\" />\n"; 
                        }
                }
                print "<select name=\"size\" onchange=\"javascript:form.submit()\">\n";

		$selects = $this->buildSizeSelectArray();
		foreach($selects as $select)
		{
			print "$select";
		}
		
                print "</select>\n&nbsp;<button type=\"submit\">Go</button>\n</form>\n</div>\n";
        }

        function
        DisplayZoomIn( $image = "" )
        {
                $this->setupImage();

                if (!$this->_Image->HasLargerSize())
		{
			if ( !empty($this->NoZoomInImage) )
			{
				$img = $this->NoZoomInImage;
				print "<img border=\"0\" src=\"$img\" />\n";
                        }
			return;
                }
                
                $self = WebSelf();
                $urlParams = $this->getUrlParams();

                foreach ($urlParams as $key => $val)
                {
                        if ($key == "size" || $key == "zoom")
				continue;
			$getString .= "&amp;$key=$val";
                }        
		
                $size = $this->getNextSizeUp();
                $getString .= "&amp;size=$size";

		if ( !empty($this->ZoomInImage) )
		{
                	$img = $this->ZoomInImage;
			print "<a href=\"$self?$getString\"><img border=\"0\" alt=\"Zoom In\" src=\"$img\" /></a>";
		}
                elseif ( !empty($image) )
		{
		 	print "<a href=\"$self?$getString\"><img alt=\"Zoom In\" border=\"0\" src=\"$image\" /></a>";
		}
		else
		{
			print "<a href=\"$self?$getString\" alt=\"Zoom In\">Zoom In</a> ";
		}
        }

        function
        DisplayZoomOut($image="")
        {
                $this->setupImage();

                if (!$this->_Image->HasSmallerSize())
		{
			if ( !empty($this->NoZoomOutImage) )
			{
				$img = $this->NoZoomOutImage;
				print "<img border=\"0\" src=\"$img\" />\n";
                        }
			return;
                }
                $self = WebSelf();
                $UrlParams = $this->getUrlParams();

                foreach ($UrlParams as $key => $val)
                {
                        if ($key == "size" || $key == "zoom")
				continue;
                        $getString .= "&amp;$key=$val";
                }  
                $size = $this->getNextSizeDown();
                $getString .= "&amp;size=$size";

		if ( !empty($this->ZoomOutImage) )
		{
			$img = $this->ZoomOutImage;
                	print "<a href=\"$self?$getString\"><img border=\"0\" alt=\"Zoom Out\" src=\"$img\" /></a>";
		}
                elseif ( !empty($image) )
		{
		 	print "<a href=\"$self?$getString\"><img border=\"0\" alt=\"Zoom Out\" src=\"$image\" /></a>";
		}
		else
		{
			print "<a href=\"$self?$getString\" alt=\"Zoom Out\">Zoom Out</a>";
		}
        }

	function
	DisplayNavBar()
	{
		print "<!-- Begin Nav Bar -->\n";
		print "<table border=\"0\" width=\"220\">\n"
 			. "<tr>\n"
                        . "<td width=\"200\" nowrap=\"nowrap\" bordercolor=\"#FFFFFF\" align=\"center\">\n";
	
		$this->DisplaySizeBox();
	
                print   "</td>\n"
                        . "<td bordercolor=\"#FFFFFF\" align=\"center\">\n";

		$this->DisplayZoomIn();

                print   "</td>\n"
                	. "<td bordercolor=\"#FFFFFF\" align=\"center\">\n";

		$this->DisplayZoomOut();

                print   "</td></tr></table>\n";
		print "<!-- End Nav Bar -->";
	}

	function
	DisplayImageOnlyLink()
	{
		if ($this->Intranet)
			print '[ <a href="' . $GLOBALS['INTRANET_MEDIA_URL'] . '?irn=' . $this->IRN . '">Image only</a> ]' . "\n";
		else
			print '[ <a href="' . $GLOBALS['MEDIA_URL'] . '?irn=' . $this->IRN . '">Image only</a> ]' . "\n";
	}

	function
	SetImageDisplayPage($link)
	{
		$this->_Image->ImageDisplayPage = "$link";
	}
	
        function
        getUrlParams()
        {
		$params;
		if (isset($_REQUEST) && is_array($_REQUEST))
		{
			$params = $_REQUEST;
		}
		else
		{
			$params = array_merge(
				$GLOBALS['HTTP_POST_VARS'], 
				$GLOBALS['HTTP_GET_VARS']
				);
		}

                return $params;
        }
        
        function
        getNextSizeUp()
        {
                $thisSize = new Size();
                $thisSize->Width = $this->width;
                $thisSize->Height = $this->height;
                
                $sizes = $this->_Image->GetAvailableSizes();
                
                $cmpSize = new Size();
                $count = count($sizes);
                for ($i = 0; $i < $count; $i++)
                {
                        $cmpSize->SetSize($sizes[$i]);
                        if ( ($cmpSize->Width == $thisSize->Width) && (!empty($sizes[$i-1])) )
                                return $sizes[$i-1];
                }
        }

        function
        getNextSizeDown()
        {
                $thisSize = new Size();
                $thisSize->Width = $this->width;
                $thisSize->Height = $this->height;
                
                $sizes = $this->_Image->GetAvailableSizes();
                
                $cmpSize = new Size();
                $count = count($sizes);
                for ($i = 0; $i < $count; $i++)
                {
                        $cmpSize->SetSize($sizes[$i]);
                        if ( ($cmpSize->Width == $thisSize->Width) && (!empty($sizes[$i+1])) )
                                return $sizes[$i+1];
                }
        }

	function
	buildSizeSelectArray()
	{
		// This function builds and returns an array of strings in the form:
		// 	<option value="NNNxNNN" (selected="selected")>[STRING SHOWN IN DROPDOWN]</option>
		//      and can be overridden to provide an alternative. Care should be taken to correctly set the 'selected="selected"'
		//	attribute on the option that is to be highlighted in the drop-down, as with this implementation
		//	the width of the image must exactly match the width in the dropdown for the select
		//	attribute to be correctly set.
		
		$this->setupImage();
		
		$AvailableSizes = $this->_Image->GetAvailableSizes();
		$origsize = new Size();
		$origsize->SetSize($this->_Image->GetLargestSize());
		if (empty($origsize->Width))
			WebDie("This image cannot be displayed", "ChaImageWidth of multimedia record is empty, or all sizes are larger than maximum permitted");
		$requestedratio =  ((((int)$this->width) / $origsize->Width) * 100);
		$closestsize = new Size();
		$closestsize->SetSize($this->_Image->GetClosestSize($requestedratio));
		$selectarray = array();
		foreach ($AvailableSizes as $size)
		{
			$formatsize = new Size();
			$formatsize->SetSize($size);
			$ratio = (int) ((((int)$formatsize->Width) / $origsize->Width) * 100);
			$select = "\t<option value=\"$size\"";
			if ($formatsize->Width == $closestsize->Width)
				$select .= " selected=\"selected\"";
			$select .= ">$size ($ratio%)</option>\n";
			array_push($selectarray, $select);
		}
		return $selectarray;
	}
}

?>
