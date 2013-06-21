<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

/*
* This is a decorator class
*/
class
HtmlBoxAndTitle
{
	var $Title;
	var $TitleTextColor = '';
	var $FontFace = '';
	var $BorderColor = '';
	var $BodyColor = '';
	var $Width = '';
	var $Border = 2;
	var $ImageAlign = 'middle';

	function
	Open ()
	{
		$titleTextAttrib = '';
		if (!$this->TitleTextColor == '')
		{
			$titleTextAttrib = 'color="' 
						. $this->TitleTextColor . '"' ;
		}

		$fontAttrib = '';
		if (!$this->FontFace == '')
		{
			$fontAttrib = 'face="' . $this->FontFace . '"';
		}

		$borderColorAttrib = '';
		$titleBackColorAttrib = '';
		if (!$this->BorderColor == '')
		{
			$borderColorAttrib = 'bordercolor="' 
				. $this->BorderColor . '"';
			$titleBackColorAttrib = 'bgcolor="' 
					. $this->BorderColor . '"';
		}

		$bodyColorAttrib = '';
		if (!$this->BodyColor == '')
		{
			$bodyColorAttrib = 'bgcolor="' . $this->BodyColor . '"';
		}

		$widthAttrib = '';
		if (!$this->Width == '')
		{
			$widthAttrib = 'width="' . $this->Width . '"' ;
		}

// BEGIN HTML
?>
<table <?php print $widthAttrib ?> border="<?php print $this->Border; ?>" cellspacing="0" cellpadding="2" <?php print $borderColorAttrib ?>>
  <tr> 
    <td <?php print $titleBackColorAttrib ?>><b><font <?php print "$fontAttrib $titleTextAttrib" ?>>
    <?php print $this->Title ?>
    </font></b></td>
  </tr>
  <tr <?php print $bodyColorAttrib ?>> 
    <td valign="<?php print $this->ImageAlign ?>"> 
<?php
// END HTML
	} // end Open method


	function
	Close ()
	{
		print "</td></tr></table>\n";
	}

} // end HtmlBoxAndTitle class

?>
