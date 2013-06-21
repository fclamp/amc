<?php

/* 
**  Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (! isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/lib/BaseWebServiceObject.php');

class DigirTest extends BaseWebServiceObject
{
	var $serviceName = 'DigirTest';
	var $serviceDirectory = 'webservices/digir';

	var $accessPoint;
	var $webDirName;
	var $server;

	var $request = array();

	function 
	DigirTest()
	{
		### CALL PARENT CONSTRUCTOR
		$this->{get_parent_class(__CLASS__)}();

		$this->server = $_SERVER['SERVER_NAME'];
		$this->accessPoint = "http://$this->server/$this->webDirName/webservices/digir.php";
	}

	function 
	describe()
	{
		return "A Digir test is a rudimentary testing platform for sending digir request to a digir provider\n\n" . parent::describe();
	}

	function 
	testPage()
        {
		$title = "KE EMu $this->serviceName";
                if ($this->emuwebRunning())
                        $status = "<span style='color:green'>EMuWeb Running</span>";
                else
                        $status = "<span style='color:red'><b>WARNING - EMuWeb IS NOT RUNNING !</b></span>";

                echo <<<HTML
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <head>
                <title>$title</title>

		<script language='javascript'> 
			function shrink(id)
			{
				var element = document.getElementById(id);
				element.style.display = "none";
			}

			function grow(id)
			{
				var element = document.getElementById(id);
				element.style.display = "block";
			}
		</script> 
        </head>
        <body>
		<center>
		<div style='font-size: 120%;'>$title</div>
		<div style='font-size: 110%;'>NB this system will fail if emuweb not running</div>
		<div style='font-size: 110%;'>$status</div>
		<br/>
HTML;

		if (count($this->request))
		{
			$n = 0;
			foreach ($this->request as $heading => $value)
			{
				$rows = count(preg_split("/\n/", $value)) - 1;
				
				echo <<<HTML
<form method='get' action='/$this->webDirName/webservices/digir.php' >
	<table border='1' cellspacing='0'>
		<tr bgcolor='#eeeeee'>
			<td align='center'>$heading</td>
		</tr>
		<tr bgcolor='#ffffff'>
			<td align='center'>
				<textarea id='text$n' cols='150' rows='$rows' name='doc' wrap='off'>$value</textarea>
			</td>
		</tr>
		<tr>
			<th bgcolor='#eeeeee'>
				<input type='submit' name='action' value='Request'/>
				<input type="button" onClick="shrink('text$n')" value="-">
				<input type="button" onClick="grow('text$n')" value="+">
			</th>
		</tr>
	</table>
	<br>
	<input type='hidden' name='test' value='true'/>
	<input type='hidden' name='testCall' value='true'/>
	<input type='hidden' name='class' id='class' value='SimpleTransformation'/>
	<script language='javascript'> 
		shrink('text$n');
	</script> 
</form>
HTML;
				$n++;
			}
		}
		else
		{

			echo <<<HTML
<form method='get' action='/$this->webDirName/webservices/digir.php'>
	<table border='1' cellspacing='0'>
		<tr bgcolor='#eeeeee'>
			<td align='center'>
				<textarea cols='150' rows='20' name='doc'><!-- YOUR DiGIR REQUEST HERE --></textarea>		
			</td>
		</tr>
		<tr>
			<th bgcolor='#eeeeee'>
				<input type='submit' name='action' value='Request'/>
			</th>
		</tr>
	</table>
	<input type='hidden' name='test' value='true'/>
	<input type='hidden' name='testCall' value='true'/>
	<input type='hidden' name='class' id='class' value='SimpleTransformation'/>
</form>
HTML;
		}

		echo <<<HTML
		<center>
			<div id='message'></div>
			<p>
				<img border="0" alt='KE EMu' src="../../images/productlogo.gif" width="134" height="48">
				<img border='0'alt="KE Software" src="../../images/companylogo.gif"  width="60" height="50">
				<br/>
				(C) 2000-2008 KE Software
			</p>
		</center>
        </body>
</html>
HTML;
        }
}
?>
