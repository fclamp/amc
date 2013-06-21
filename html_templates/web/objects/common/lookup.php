<?php
/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'common.php');
require_once ($LIB_DIR . 'texquery.php');

/* This file provides the lookup lists pop-up window content
**
**	lname=[lookup table name]
**	ll=[leading letters for contents]
**	fieldid=[Field Name associated with Lookup List]
*/

class
LookupList extends BaseWebObject
{
	function
	ShowList()
	{
		$this->sourceStrings();
		global $ALL_REQUEST;

		// Use a bit of javascript to out the text back into the query form
?>
<script Language='JavaScript'>
<!-- 

FormField = "<?php print $ALL_REQUEST['fieldid'] ?>";

function putText(anchorObj)
{

	if (anchorObj.innerText)
	{
		// for IE
		str = anchorObj.innerText;
	}
	else if(anchorObj.text)
	{
		// for Netscape
		str = anchorObj.text;
	}
	else
	{
		str = 'error!';
	}
	str = '"' + str + '"'; 

	window.opener.document.forms['<?php print $ALL_REQUEST['formid'] ?>'][FormField].value = '' + str;
	window.close();
}

// -->
</script>
<?php
		preg_match('/^(.*?)\[?(\d*)\]?$/', $ALL_REQUEST['lname'], $matches);

		$tablename = $matches[1];
		if (isset($matches[2]) && $matches[2] != '')
			$level = $matches[2];
		else
			$level = 1;
		$value = sprintf('Value%02d0', (int) ($level - 1)); 

		// Use first 3 charactors
		$search = "^" . substr($ALL_REQUEST['ll'], 0, 3) . "*";

		// Setting restriction/limit on what can be seen on the lookup lists
		$restriction = stripslashes($ALL_REQUEST['restriction']);
		if ($restriction == '')
			$restriction = 'true';
		$texql = "distinct(SELECT $value FROM eluts WHERE Name='$tablename' and $value contains'$search' and Levels=$level and $restriction) {1 to 5000}";

		if ($GLOBALS['DEBUG'])
		{
			print_r($texql);
		}


		$qry = new Query;
		$qry->Texql = $texql;
		$recs = $qry->Fetch();


		if (count($recs) > 0)
		{
			print '<p align="center"><font color="#0000FF">';
			print $this->_STRINGS['SELECT_A_TERM'];
			print '</font></p>';
			// Loop through displaying
			foreach($recs as $rec)
			{
				$option = trim($rec->{$value});
				if ($option != '' && strlen($option) < 100)
				{
					print '<a href="#" onclick="putText(this)">';
					print $option;
					print "</a><br />\r\n";
				}
			}
		}
		else
		{
			print '<p align="center"><font color="#0000FF">';
			print $this->_STRINGS['NO_MATCH'];
			print '</font></p>';
		}
		$self = isset($GLOBALS['PHP_SELF']) ? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];
		$link = $self . 
			'?lname=' . urlencode($ALL_REQUEST['lname']) . 
			'&amp;fieldid=' . urlencode($ALL_REQUEST['fieldid']) . 
			'&amp;formid=' . urlencode($ALL_REQUEST['formid']) . 
			'&amp;bodycolor=' . urlencode($ALL_REQUEST['bodycolor']) .
			'&amp;bodytextcolor=' . urlencode($ALL_REQUEST['bodytextcolor']) .
			'&amp;restriction=' . urlencode(stripslashes($ALL_REQUEST['restriction'])) .
			'&amp;ll=';
		print "<br />\n";
		print "[ <a href=\"$link\">" . $this->_STRINGS['OTHER'] . "</a> ]";
	}

	function
	printLink($leadingletter)
	{
		global $ALL_REQUEST;
		$self = isset($GLOBALS['PHP_SELF']) ? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];
		$link = $self . 
			'?lname=' . urlencode($ALL_REQUEST['lname']) . 
			'&amp;ll=' . urlencode($leadingletter) .
			'&amp;formid=' . urlencode($ALL_REQUEST['formid']) . 
			'&amp;fieldid=' . urlencode($ALL_REQUEST['fieldid']) .
			'&amp;bodycolor=' . urlencode($ALL_REQUEST['bodycolor']) .
			'&amp;bodytextcolor=' . urlencode($ALL_REQUEST['bodytextcolor']) .
			'&amp;restriction=' . urlencode(stripslashes($ALL_REQUEST['restriction']));
		print $link;
	}


	function
	ShowMatrix()
	{
		$this->sourceStrings();

	?>
	<p align="center"><font color="#0000FF"><?php print $this->_STRINGS['SELECT_LEADING_LETTER']; ?></font></p>
	<div align="center">
	  <center>
	  <table border="1" cellpadding="6" cellspacing="0" bordercolordark="#FF0000" bordercolorlight="#FFFFFF">
	    <tr>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('1')?>"><font color="#0000FF" size="2">1</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('2')?>"><font color="#0000FF" size="2">2</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('3')?>"><font color="#0000FF" size="2">3</font></a></td>
	    </tr>
	    <tr>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('4')?>"><font color="#0000FF" size="2">4</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('5')?>"><font color="#0000FF" size="2">5</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('6')?>"><font color="#0000FF" size="2">6</font></a></td>
	    </tr>
	    <tr>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('7')?>"><font color="#0000FF" size="2">7</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('8')?>"><font color="#0000FF" size="2">8</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('9')?>"><font color="#0000FF" size="2">9</font></a></td>
	    </tr>
	    <tr>
	      <td width="40" align="center">&nbsp;</td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('0')?>"><font color="#0000FF" size="2">0</font></a></td>
	      <td width="40" align="center">&nbsp;</td>
	    </tr>
	  </table>
	  <hr width="70%">
	  <table border="1" cellpadding="6" cellspacing="0" bordercolordark="#FF0000" bordercolorlight="#FFFFFF">
	    <tr>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('a')?>"><font color="#0000FF" size="2">A</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('b')?>"><font color="#0000FF" size="2">B</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('c')?>"><font color="#0000FF" size="2">C</font></a></td>
	    </tr>
	    <tr>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('d')?>"><font color="#0000FF" size="2">D</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('e')?>"><font color="#0000FF" size="2">E</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('f')?>"><font color="#0000FF" size="2">F</font></a></td>
	    </tr>
	    <tr>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('g')?>"><font color="#0000FF" size="2">G</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('h')?>"><font color="#0000FF" size="2">H</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('I')?>"><font color="#0000FF" size="2">I</font></a></td>
	    </tr>
	    <tr>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('J')?>"><font color="#0000FF" size="2">J</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('k')?>"><font color="#0000FF" size="2">K</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('l')?>"><font color="#0000FF" size="2">L</font></a></td>
	    </tr>
	    <tr>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('m')?>"><font color="#0000FF" size="2">M</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('n')?>"><font color="#0000FF" size="2">N</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('o')?>"><font color="#0000FF" size="2">O</font></a></td>
	    </tr>
	    <tr>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('p')?>"><font color="#0000FF" size="2">P</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('q')?>"><font color="#0000FF" size="2">Q</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('r')?>"><font color="#0000FF" size="2">R</font></a></td>
	    </tr>
	    <tr>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('s')?>"><font color="#0000FF" size="2">S</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('t')?>"><font color="#0000FF" size="2">T</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('u')?>"><font color="#0000FF" size="2">U</font></a></td>
	    </tr>
	    <tr>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('v')?>"><font color="#0000FF" size="2">V</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('w')?>"><font color="#0000FF" size="2">W</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('x')?>"><font color="#0000FF" size="2">X</font></a></td>
	    </tr>
	    <tr>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('y')?>"><font color="#0000FF" size="2">Y</font></a></td>
	      <td width="40" align="center">
	      <a href="<?php $this->printLink('z')?>"><font color="#0000FF" size="2">Z</font></a></td>
	      <td width="40" align="center">&nbsp;</td>
	    </tr>
	  </table>
	  </center>
	</div>
	<?php


	}
}


?>
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 3.2 Final//EN'>
<html>
<head>
<meta HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=iso-8859-1'>
<title>Select a Term</title>
</head>
<?php
global $ALL_REQUEST;

print "<body ";
if (isset($ALL_REQUEST['bodycolor']))
	print "bgcolor=\"". htmlentities($ALL_REQUEST['bodycolor']) . "\" ";
if (isset($ALL_REQUEST['bodycolor']))
	print "text=\"" . htmlentities($ALL_REQUEST['bodytextcolor']) . "\"";
print ">\n";

// Test for expected vars 
if (	!isset($ALL_REQUEST['lname']) 
	|| !isset($ALL_REQUEST['ll']) 
	|| !isset($ALL_REQUEST['fieldid']) 
	|| !isset($ALL_REQUEST['formid']) )
{
	WebDie('Invalid Options');
}

$lookup = new LookupList;

if (strlen($ALL_REQUEST['ll']) > 0)
{
	$lookup->ShowList();
}
else
{
	$lookup->ShowMatrix();
}

?>
</body>
</html>
