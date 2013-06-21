<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'configuredquery.php');
require_once ($LIB_DIR . 'border.php');
require_once ($LIB_DIR . 'common.php');
require_once ($LIB_DIR . 'Security.php');
require_once ($LIB_DIR . 'BaseQueryForm.php');

class
BaseAdvancedQueryForm extends BaseQueryForm
{
	var $Restriction = '';
	var $Title = '';
	var $Width = '750';
	var $FontFace = '';
	var $FontSize = '';
	var $TitleTextColor = '#FFFFFF';
	var $BodyTextColor = '#000000';
	var $BorderColor = '#000000';
	var $BodyColor = '';
	var $ResultsListPage; 
	var $RankCheckBox = 1;	// Set to 1 to show a 'Relevance Rank' checkbox
	var $Border = 2;

	// Override
	var $Options = array();	// eg. array('any' => 'AdmWebMetadata|SummaryData');

	function
	Show ()
	{
		$this->sourceStrings();
		if ($this->Title == '')
		{
			$this->Title = $this->_STRINGS['DEFAULT_QUERY_TITLE'];
		}
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
		$decorator->Border = $this->Border;
		// Dump the HTML
		$decorator->Open();
		$self = isset($GLOBALS['PHP_SELF']) 
				? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];

?>
<form method="<?php print $this->SubmitMethod; ?>" action="<?php print $this->ResultsListPage?>">
	<input type="hidden" name="QueryName" value="AdvancedQuery" />
	<?php
	if ($this->RankCheckbox)
	{
		print '<input type="hidden" name="RankOn" value="AdmWebMetadata" />';
	}
	?>
	<input type="hidden" name="StartAt" value="1" />
	<input type="hidden" name="QueryPage" value="<?php print $self ?>" />
	<input type="hidden" name="Restriction" value="<?php print htmlentities($this->Restriction) ?>" />
<?php
		$this->printAdditionalTransferVariables();
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
                          <option value="10" >10 <?php print $this->_STRINGS['RESULTS']?></option>
                          <option value="20" selected="selected">20 <?php print $this->_STRINGS['RESULTS']?></option>
                          <option value="30" >30 <?php print $this->_STRINGS['RESULTS']?></option>
                          <option value="50" >50 <?php print $this->_STRINGS['RESULTS']?></option>
                          <option value="100" >100 <?php print $this->_STRINGS['RESULTS']?></option>
                        </select>&nbsp;&nbsp;
                        <input type="submit" name="Search" value="Search" />
                        </p>
			<font color="<?php print $this->BodyTextColor?>" size="<?php print $this->FontSize?>" face="<?php print $this->FontFace?>">
			<input class="WebInput" type="checkbox" name="ImagesOnly" value="true" />
			<?php print $this->_STRINGS['ONLY_WITH_IMAGES']?>
			<?php if ($this->RankCheckbox)
			{?>
			<br />
			<input class="WebInput" type="checkbox" name="Rank" value="true" />
			<?php print $this->_STRINGS['RELEVANCE_RANK'];
			}?>
			</font>
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
		/*
		foreach($this->Options as $option => $val)
		{
			$optDisplay = $this->_STRINGS['QUERY_OPTION_' . strtoupper($option)];
			if ($optDisplay == '')
				$optDisplay = $option;
			print "			<option value=\"$option\">$optDisplay</option>\n";
		}
		*/
?>
                  </select>
                  </font></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
	</form>
<?php
		if ($spaceerror)
		{
			WebDie("Space found in objects\client\QueryForms.php Options->array.  If a space is required to show up in the pull down list, please use the strings (english.php) to accomplish this.","");
		}

		$decorator->Close();
	}

}  // End BaseAdvancedQueryForm class
