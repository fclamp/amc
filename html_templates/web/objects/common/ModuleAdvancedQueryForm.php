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
** The ModuleBaseAdvancedQueryForm is a class
** extending BaseAdvancedQueryForm
**
** Used as base base class for taxonomy query forms
**
** Overide and provide as per BaseAdvancedQueryForm Class PLUS
**		->showLevels = array();
**
** showLevels are list of taxonomic levels to display - passed as cgi 
** params to List Mechanism
**
** Makes only a minor mod to 'function display' - passes levels as hidden
** params in html form.  Perhaps BaseAdvancedQueryForm could be modified to have
** a 'hidden' method that could be used to do same thing more generically and
** would avoid having this in between class... JK
************************************************************/
class
ModuleBaseAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $showLevels = array ();
	var $showSummary;
	var $phpSelf;

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
<form method="GET" action="<?php print $this->ResultsListPage?>">
	<input type="hidden" name="QueryName" value="AdvancedQuery" />
	<input type="hidden" name="StartAt" value="1" />
	<input type="hidden" name="QueryPage" value="<?php print $this->phpSelf ?>" />
	<input type="hidden" name="Restriction" value="<?php print $this->Restriction?>" />
	<input type="hidden" name="lang" value="<?php print $this->LanguageData?>" />		
<?php
		// print Options as hidden so they are passed through
		foreach($this->Options as $option => $fields)
		{
			print "		<input type=\"hidden\" name=\"$option\" value=\"$fields\" />\n";
		}
?>
	<table width="100%" cellspacing="0" cellpadding="2" border="0">
              <tr>
                <td valign="top" width="15%"><font color="<?php print $this->BodyTextColor?>" face="<?php print $this->FontFace?>" size="<?php print $this->FontSize?>">
		  <br />
                  <b><?php print $this->_STRINGS['FIND_RESULTS'] ?> </b></font></td>
                <td valign="top" width="85%">
                  <table width="100%" cellpadding="2" border="0" cellspacing="0">
                    <tr>
                      <td valign="top"><font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>"><?php print $this->_STRINGS['WITH_ALL_WORDS'] ?></font></td>
                      <td valign="top">
                        <input class="WebInput" type="text" value="" name="AllWords" size="25" />
                      </td>
                      <td valign="top" rowspan="6"><p>
                        <select name="LimitPerPage">
                          <option value="50" selected="selected">50 <?php print $this->_STRINGS['RESULTS']?></option>
                          <option value="100" >100 <?php print $this->_STRINGS['RESULTS']?></option>
                          <option value="250" >250 <?php print $this->_STRINGS['RESULTS']?></option>
                          <option value="500" >500 <?php print $this->_STRINGS['RESULTS']?></option>
                          <option value="1000" >1000 <?php print $this->_STRINGS['RESULTS']?></option>
                        </select>&nbsp;&nbsp;
                        <input type="submit" name="Search" value="Search" />
			</p>
			<p>
			<font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>">
			<input class="WebInput" type="checkbox" name="ImagesOnly" value="true" />
			<?php print $this->_STRINGS['ONLY_WITH_IMAGES']?>
			</font>
			</p>
		      </td>
                    </tr>
                    <tr>
                      <td valign="top" nowrap="nowrap"><font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>"><?php print $this->_STRINGS['WITH_EXACT_PHRASE'] ?></font></td>
                      <td valign="top">
                        <input class="WebInput" type="text" size="25" value="" name="Phrase" />
                      </td>
                    </tr>
                    <tr>
                      <td valign="top" nowrap="nowrap"><font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>"><?php print $this->_STRINGS['WITH_ANY_WORDS'] ?></font>
		      </td>
                      <td valign="top">
                        <input class="WebInput" type="text" size="25" value="" name="AnyWords" />
                      </td>
                    </tr>
                    <tr>
                      <td valign="top" nowrap="nowrap"><font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>">
		      <?php print $this->_STRINGS['WITHOUT_THE_WORDS'] ?>
		      </font></td>
                      <td valign="top">
                        <input class="WebInput" type="text" size="25" value="" name="WithoutWords" />
                      </td>
                    </tr>
                    <tr>
                      <td valign="top" nowrap="nowrap"><font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>">
		        <?php print $this->_STRINGS['SOUNDS_LIKE_THE_WORDS'] ?>
                        </font></td>
                      <td valign="top">
                        <input class="WebInput" type="text" size="25" value="" name="SoundsLikeWords" />
                      </td>
                    </tr>
                    <tr>
		      <td valign="top" nowrap="nowrap" width="40%"><font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>">
		      	<?php print $this->_STRINGS['RESULTS_WHERE']?></font></td>
                <td valign="top"><font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>">
                  <select name="QueryOption">
<?php
		foreach($this->Options as $option => $val)
		{
			$optDisplay = $this->_STRINGS['QUERY_OPTION_' . strtoupper($option)];
			if ($optDisplay == '')
				$optDisplay = $option;
			print "			<option value=\"$option\">$optDisplay</option>\n";
		}
		
		print "<input type='hidden' name='showSummary' value='$this->showSummary' />\n";
?>
                  </select>
                  </font></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>

<?php
		print "</form>\n";

		$decorator->Close();
	}  

}
