<?php
/* 
**Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'common.php');
require_once ($LIB_DIR . 'configuredquery.php');
require_once ($LIB_DIR . 'querybuilder.php');
require_once ($WEB_ROOT . '/objects/common/PreConfiguredQuery.php');

class Explorer extends BaseWebObject
{
	var $LeadingLetter = '';
	var $LowerLetter = '';
	var $UpperLetter = '';

	var $LookupListName = '';
	var $Field = '';
	var $MatrixPage = '';
	var $FontSize = '2';
	var $FontFace = '';
	var $TextColor = '';
	var $BodyColor = '#FFFFFF';

	function
	Explorer()
	{
		global $ALL_REQUEST;
		$this->LeadingLetter = $ALL_REQUEST['leadingletter'];
		$this->LowerLetter = $ALL_REQUEST['lowerletter'];
		$this->UpperLetter = $ALL_REQUEST['upperletter'];
		$self = isset($GLOBALS['PHP_SELF'])
				? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];
		$this->MatrixPage = $self;

		$this->BaseWebObject();
	}

	function
	_printLink($letter)
	{
		print '<a href="';
		$self = isset($GLOBALS['PHP_SELF'])
				? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];
		print ($self . "?leadingletter=$letter");
		print '">';
		PPrint($letter, $this->FontFace, $this->FontSize, $this->TextColor);
		print '</a>';
	}

	function
	_printList()
	{
		$matches = array();
		preg_match('/^(.*?)\[?(\d*)\]?$/', $this->LookupListName, $matches);

		$tablename = $matches[1];
		if (isset($matches[2]) && $matches[2] != '')
			$level = $matches[2];
		else
			$level = 1;
		$value = sprintf('Value%02d0', (int) ($level - 1)); 
		$index = sprintf('Index%02d0', (int) ($level - 1)); 

		$search = $this->LeadingLetter;
		$texql = "distinct(SELECT $value FROM eluts WHERE Name='$tablename' and $index contains'$search' and Levels=$level) {1 to 500}";

		$qry = new ConfiguredQuery;
		$qry->Texql = $texql;
		$qry->All = 1;
		$recs = $qry->Fetch();

		print "<table width=\"200\"><tr><td nowrap=\"nowrap\">\r\n";
		if (count($recs) > 0)
		{
			print '<p align="center">';

			PPrint($this->_STRINGS['SELECT_A_TERM'], 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor
				);
			print '</p>';
			print '<p align="left">';
			// Loop through displaying
			foreach($recs as $rec)
			{
				$option = trim($rec->{$value});
				if ($option != '' && strlen($option) < 200)
				{
					print '<a href="';
					$link = $this->ResultsListPage;
					$link .= "?QueryName=DetailedQuery";
					$self = isset($GLOBALS['PHP_SELF']) ? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];
					$page = urlencode($self);
					$link .= "&amp;QueryPage=$page";
					$link .= "&amp;col_" . $this->Field . "=" . urlencode($option);
					print $link;
					print '">';
					print $option;
					print "</a><br />\r\n";
				}
			}
			print '</p>';
		}
		else
		{
			print '<p align="center">';
			PPrint($this->_STRINGS['NO RESULTS'], 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor
				);
			print "</p>\r\n";
		}

		print '<p align="left">';
		$link = $this->MatrixPage;
		print "[ <a href=\"$link\">";
		PPrint($this->_STRINGS['OTHER'], 
			$this->FontFace, 
			$this->FontSize, 
			$this->TextColor
			);
		print '</a> ]';
		print "</p>\r\n";
		print "</td></tr></table>\r\n";
	}

	function
	_printMatrix()
	{
?>
<table cellpadding="2" cellspacing="2" border="1" width="60%" bgcolor="<?php print $this->BodyColor; ?>" align="Center">
  <tbody>
    <tr>
      <td valign="Top" align="Center"><?php print $this->_printLink('A'); ?>
      </td>
      <td valign="Top" align="Center"><?php print $this->_printLink('B'); ?>
      </td>
      <td valign="Top" align="Center"><?php print $this->_printLink('C'); ?>
      </td>
      <td valign="Top" align="Center"><?php print $this->_printLink('D'); ?>
      </td>
      <td valign="Top" align="Center"><?php print $this->_printLink('E'); ?>
      </td>
    </tr>
    <tr>
      <td valign="Top" align="Center"><?php print $this->_printLink('F'); ?>
      </td>
      <td valign="Top" align="Center"><?php print $this->_printLink('G'); ?>
      </td>
      <td valign="Top" align="Center"><?php print $this->_printLink('H'); ?>
      </td>
      <td valign="Top" align="Center"><?php print $this->_printLink('I'); ?>
      </td>
      <td valign="Top" align="Center"><?php print $this->_printLink('J'); ?>
      </td>
    </tr>
    <tr>
      <td valign="Top" align="Center"><?php print $this->_printLink('K'); ?>
      </td>
      <td valign="Top" align="Center"><?php print $this->_printLink('L'); ?>
      </td>
      <td valign="Top" align="Center"><?php print $this->_printLink('M'); ?>
      </td>
      <td valign="Top" align="Center"><?php print $this->_printLink('N'); ?>
      </td>
      <td valign="Top" align="Center"><?php print $this->_printLink('O'); ?>
      </td>
    </tr>
    <tr>
      <td valign="Top" align="Center"><?php print $this->_printLink('P'); ?>
      </td>
      <td valign="Top" align="Center"><?php print $this->_printLink('Q'); ?>
      </td>
      <td valign="Top" align="Center"><?php print $this->_printLink('R'); ?>
      </td>
      <td valign="Top" align="Center"><?php print $this->_printLink('S'); ?>
      </td>
      <td valign="Top" align="Center"><?php print $this->_printLink('T'); ?>
      </td>
    </tr>
    <tr>
      <td valign="Top" align="Center"><?php print $this->_printLink('U'); ?>
      </td>
      <td valign="Top" align="Center"><?php print $this->_printLink('V'); ?>
      </td>
      <td valign="Top" align="Center"><?php print $this->_printLink('W'); ?>
      </td>
      <td valign="Top" align="Center"><?php print $this->_printLink('X'); ?>
      </td>
      <td valign="Top" align="Center"><?php print $this->_printLink('Y'); ?>
      </td>
    </tr>
    <tr>
      <td valign="Top" align="Center"><?php print $this->_printLink('Z'); ?>
      </td>
      <td valign="Top" align="Center">&nbsp;<br />
      </td>
      <td valign="Top" align="Center">&nbsp;<br />
      </td>
      <td valign="Top" align="Center">&nbsp;<br />
      </td>
      <td valign="Top" align="Center">&nbsp;<br />
      </td>
    </tr>
  </tbody>
</table>
<?php

	}


	function
	Show()
	{
		$this->sourceStrings();
		if ($this->LeadingLetter == ''
			&& ($this->LowerLetter == '' && $this->UpperLetter == ''))
		{
			$this->_printMatrix();
		}
		else
		{
			$this->_printList();
		}
	}
}
?>
