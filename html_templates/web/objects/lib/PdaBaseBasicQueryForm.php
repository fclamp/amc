<?php
/*
*  Copyright (c) KE Software Pty Ltd - 2001
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'configuredquery.php');
require_once ($LIB_DIR . 'border.php');
require_once ($LIB_DIR . 'common.php');
require_once ($LIB_DIR . 'Security.php');
require_once ($LIB_DIR . 'BaseQueryForm.php');

/*
** The BaseBasicQueryForm is an abstract base class
**	Overide and provide:
**		->Options = array();
**
**	Options appear in the dropdown.  The text that displayes in the
**	options box is either the Options itself or a string from the
**	strings file with the key:  (QUERY_OPTION_{option in upper case} )
*/
class
BaseBasicQueryForm extends BaseQueryForm
{
	var $Restriction = '';
	var $Title = '';
	var $Width = '460';
	var $FontFace = '';
	var $FontSize = '';
	var $TitleTextColor = '#FFFFFF';
	var $BodyTextColor = '#000000';
	var $BorderColor = '#000000';
	var $BodyColor = '';
	var $HelpPage = '';


	// Override
	var $Options = array();	// eg. array('any' => 'AdmWebMetadata|SummaryData');

	function
	Show ()
	{
		$this->sourceStrings();
		if ($this->Title == '')
			$this->Title = $this->_STRINGS['DEFAULT_QUERY_TITLE'];
		$this->display();
	}

	function
	display()
	{
		$decorator = new HtmlBoxAndTitle;
		$decorator->BorderColor = $this->BorderColor;
		$decorator->BodyColor = $this->BodyColor;
		$decorator->TitleTextColor = $this->TitleTextColor;
		$decorator->FontFace = $this->FontFace;
		$decorator->Width = $this->Width;
		$decorator->Title = $this->Title;
		// Dump the HTML
		$decorator->Open();
?>
<form method="post" action="<?php print $this->ResultsListPage ?>">
	<table width="100%" border="0" cellpadding="0" cellspacing="4">
	<tr align="right"><td valign="top">
<?php
		// Display the help link if required
		if ($this->HelpPage != '')
		{
			$helplink = new WebHelpLink;
			$helplink->HelpPage = $this->HelpPage;
			$helplink->FontFace = $this->FontFace;
			$helplink->FontSize = $this->FontSize;
			$helplink->Show();
		}
		/*$self = isset($GLOBALS['PHP_SELF']) 
				? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];*/
		$self = isset($GLOBALS['REQUEST_URI']) 
				? $GLOBALS['REQUEST_URI'] : $_SERVER['REQUEST_URI'];
?>
		&nbsp;&nbsp;&nbsp;
	</td></tr>
	<tr align="center"><td valign="top">
		<b><?php PPrint($this->_STRINGS['FIND'], $this->FontFace, $this->FontSize, $this->BodyTextColor) ?></b>
		<input type="hidden" name="QueryName" value="BasicQuery" />
		<input type="hidden" name="QueryPage" value="<?php print $self ?>" />
		<input type="hidden" name="Restriction" value="<?php print $this->Restriction?>" />
		<input type="hidden" name="StartAt" value="1" />
<?php
		$this->printAdditionalTransferVariables();
		// print OptionsFields as hidden so they are passed through
		foreach($this->Options as $option => $fields)
		{
			print "		<input type=\"hidden\" name=\"$option\" value=\"$fields\" />\n";
		}
?>
		<input class="WebInput" type="text" name="QueryTerms" />
<?php
		if (count($this->Options) > 1)
		{
			print "<select name=\"QueryOption\">";
			// Show Options in dropdown
			// The "options" should not contain spaces.  If a space or "special" label is
			// required, define an entry in the strings file with an ID the same name as
			// the option.
			$spaceerror = 0;
			foreach($this->Options as $option => $val)
			{
				if (preg_match("/\s/", $option))
				{
					$spaceerror++;
				}
				$optDisplay = $this->_STRINGS['QUERY_OPTION_' . strtoupper($option)];
				if ($optDisplay == '')
				{
					$optDisplay = $this->_STRINGS[$option];
				}
				if ($optDisplay == '')
				{
					$optDisplay = $option;
				}
				
				print "			<option value=\"$option\">$optDisplay</option>\n";
			}
			print "</select>";
		}
		else
		{
			$option = array_keys($this->Options);
			$option = $option[0];
			print "<input type=\"hidden\" name=\"QueryOption\" value=\"$option\" />";
		}
?>&nbsp;&nbsp;&nbsp;
		<input class="WebInput" type="submit" name="Submit" value="<?php print $this->_STRINGS['SEARCH'] ?>" />
	</td></tr>
	</table>
</form>
<?php
		if ($spaceerror)
		{
			WebDie("Space found in objects\client\QueryForms.php Options->array.  If a space is required to show up in the pull down list, please use the strings (english.php) to accomplish this.","");
		}
		$decorator->Close();
	}  

}  // end BaseBasicQueryForm class
