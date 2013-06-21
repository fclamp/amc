<?php
/*******************************************************
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 *******************************************************/


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');
require_once ($LIB_DIR . 'configuredquery.php');
require_once ($LIB_DIR . 'border.php');
require_once ($LIB_DIR . 'common.php');
require_once ($LIB_DIR . 'Security.php');


/*********************************************************
** The ModuleBaseBasicQueryForm is a class
** extending BaseBasicQueryForm
**
** Used as base base class for taxonomy query forms
**
** Overide and provide as per BaseBasicQueryForm Class PLUS
**		->showLevels = array();
**
** showLevels are list of taxonomic levels to display - passed as cgi 
** params to List Mechanism
**
** Makes only a minor mod to 'function display' - passes levels as hidden
** params in html form.  Perhaps BaseBasicQueryForm could be modified to have
** a 'hidden' method that could be used to do same thing more generically and
** would avoid having this in between class... JK
************************************************************/
class
ModuleBaseBasicQueryForm extends BaseBasicQueryForm
{
	var $showLevels = array ();
	var $showSummary;
	var $phpSelf = '';

	function display()
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
<form method="GET" action="<?php print $this->ResultsListPage ?>">
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
?>
		&nbsp;&nbsp;&nbsp;
	</td></tr>
	<tr align="center"><td valign="top">
		<b><?php PPrint($this->_STRINGS['FIND'], $this->FontFace, $this->FontSize) ?></b>
		
		      <input class="WebInput" type="text" name="QueryTerms" />
<?php
		if (count($this->Options) > 1)
		{
			print "<select name=\"QueryOption\">";
			// Show Options in dropdown
			foreach($this->Options as $option => $val)
			{
				$optDisplay = $this->_STRINGS['QUERY_OPTION_' . strtoupper($option)];
				if ($optDisplay == '')
					$optDisplay = $option;

				print "			<option value=\"$option\">$optDisplay</option>\n";
			}
			print "</select>&nbsp;&nbsp;&nbsp;";
		}
		else
		{
			$option = array_keys($this->Options);
			$option = $option[0];
			print "<input type=\"hidden\" name=\"QueryOption\" value=\"$option\" />";
		}

		print " <input class='WebInput' type='submit' name='Submit' value='".$this->_STRINGS['SEARCH']."' />\n";
?>
	</td></tr>
		<input type="hidden" name="QueryName" value="BasicQuery" />
		<input type="hidden" name="QueryPage" value="<?php print $this->phpSelf?>" />
		<input type="hidden" name="Restriction" value="<?php print $this->Restriction?>" />
		<input type="hidden" name="StartAt" value="1" />
		<input type="hidden" name="lang" value="<?php print $this->LanguageData?>" />
<?php
		// print OptionsFields as hidden so they are passed through
		foreach($this->Options as $option => $fields)
		{
			print "		<input type=\"hidden\" name=\"$option\" value=\"$fields\" />\n";
		}
?>
	</table>
</form>
<?php
		$decorator->Close();
	}  

}  // end ModuleBaseBasicQueryForm class
