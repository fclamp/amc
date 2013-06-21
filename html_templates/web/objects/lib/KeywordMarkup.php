<?php
/* 
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'common.php');


/*
*  This class takes a slab of text and marks up the keywords/subjects 
*  defined in narratives as hyperlinks to narrative records.
*/

class KeywordMarkup extends BaseWebObject
{

	var $KeywordArray;	// in form: array('word' => array(1, 2, 34), ..)
	var $CompoundWordArray; // in form: array('word' => 1, ..)
	var $FontFace;
	var $FontColor;
	var $FontSize;

	function
	DisplayText($text)
	{
		$nomarkup = 0;

		if ($text == '')
			return;

		if (!file_exists($GLOBALS['CACHE_DIR'] . '/narrativekeywords.php'))
		{
			$nomarkup++;
		}
		elseif (	!isset($this->KeywordArray)
			|| !isset($this->CompoundWordArray)
			)
		{
			include_once($GLOBALS['CACHE_DIR'] . '/narrativekeywords.php');
			$this->KeywordArray =& $GLOBALS['NARRATIVE_KEYWORDS'];
			$this->CompoundWordArray =& $GLOBALS['NARRATIVE_COMPOUND_WORDS'];
		}

		$face = $this->FontFace;
		$size = $this->FontSize;
		$color = $this->FontColor;
		$face == '' ? $faceAttrib = '' : $faceAttrib = "face=\"$face\"";
		$size == '' ? $sizeAttrib = '' : $sizeAttrib = "size=\"$size\"";
		$color == '' ? $colorAttrib = '' : $colorAttrib = "color=\"$color\"";
		print "<font $faceAttrib $sizeAttrib $colorAttrib>";

		// Split text into words and walk over looking for keywords.
		$text = htmlspecialchars($text);
		$text = preg_replace("/\\r?\\n/", " <br /> ", $text, -1);

		if ($nomarkup)
		{
			print $text;
		}
		else
		{
			$words = preg_split('/\s+/', $text);
			$i = 0;
			while ($i < count($words))
			{
				$match[0] = 1;
				$best = array();
				$lookup = '';
				$pos = $i;

				// get the longest match
				while (isset($match) && $match[0] == 1)
				{
					// Strip out punctuation
					$word = preg_replace("/[^\w]+/", '', $words[$i], -1);
					$lookup = trim($lookup . ' ' . strtolower($word));

					$match = $this->KeywordArray{$lookup};
					if (isset($match[0]))
						$i++;
					if (count($match[1]) > 0)
						$best = $match[1];
				}

				// if we have a match, then markup, else just print it out.
				if (is_numeric($best[0]))
				{
					$text = '';
					for ($j = $pos; $j < $i; $j++)
					{
						$text .= ' ' . $words[$j];
					}

					if (count($best) > 1)
					{
						$where = '';
						$k = 0;
						foreach ($best as $relirn)
						{
							$k++;
							if ($k > 1)
								$where .= ' or ';
							$where .= "irn=$relirn";
						}
						$where = urlencode($where);
						$link = $this->NarrativeResultsList . "?Where=$where";
						print "<a href=\"$link\">$text</a> ";
					}
					else
					{
						$relirn = $best[0];
						global $ALL_REQUEST;
						if ($relirn != $ALL_REQUEST['irn'])
						{
							$link = $this->NarrativeDisplayPage . "?irn=$relirn";
							print "<a href=\"$link\">$text</a> ";
						}
						else
							print "$text "; // dont display link if to the same record
					}
				}
				else
				{
					print $words[$pos];
					print ' ';
					$i = $pos + 1;
				}
			}
		}
		print "</font>\n";
	}
}




?>
