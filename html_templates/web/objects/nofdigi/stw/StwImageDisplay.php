<?php
/*
*   Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'MediaImage.php');
require_once ($LIB_DIR . 'common.php');
require_once ($COMMON_DIR . 'ImageDisplay.php');

class
StwImageDisplay extends ImageDisplay
{
        function
        StwImageDisplay()
        {
		$this->ImageDisplay();
        }

        function
        Show()
        {
		print "<div align=\"center\">";
		print "<table width=\"350\">\n<tr>\n<td align=\"center\">\n";
               	$this->DisplayNavBar();
		print "</td>\n</tr>\n</table><br />";
		print "<table width=\"100%\" border=\"0\">\n<tr>\n<td width=\"100%\" align=\"center\">\n";
                $this->DisplayImage();
		print "</td>\n</tr>\n<tr>\n<td align=\"left\">\n";
		$this->DisplayImageOnlyLink();
		print "\n</td>\n</tr>\n</table>\n";
		print "</div>";
        }
        
        function
        DisplaySizeBox()
        {
                $this->setupImage();        
		$this->sourceStrings();
                
		$sizeprompt = $this->_STRINGS['AVAILABLE SIZES'];
		
                $self = WebSelf();
		print "<div align=\"left\">\n";
                print "<form method=\"post\" action=\"$self\">\n";
                print "$sizeprompt";
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

                $AvailableSizes = $this->_Image->GetAvailableSizes();
                $origsize = $this->_Image->GetOriginalSize();
		$requestedratio =  ((((int)$this->width) / $origsize["Width"]) * 100);
		$closestsize = new Size();
		$closestsize->SetSize($this->_Image->GetClosestSize($requestedratio));
                foreach ($AvailableSizes as $size)
                {
                        $formatsize = new Size();
                        $formatsize->SetSize($size);
                        $ratio = (int) ((((int)$formatsize->Width) / $origsize["Width"]) * 100);
                        print "\t<option value=\"$size\"";
                        if ($formatsize->Width == $closestsize->Width)
                                print " selected=\"selected\"";
                        print ">$ratio%</option>\n";
                }
                print "</select>\n&nbsp;<button type=\"submit\">Go</button>\n</form>\n</div>\n";
		
        }
}

?>
