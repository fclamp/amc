<?php
/*
** Copyright (c) KE Software 2006 - 2007
*/

$EMU_GLOBALS = array();

/*
** The host and port the web objects are to connect to
** i.e. whichever host and port texxmlserver is running on
*/
$EMU_GLOBALS['TEXXMLSERVER_HOST'] = "localhost";
$EMU_GLOBALS['TEXXMLSERVER_PORT'] = 30000;

/*
** The default Internet / Intranet query flags. This default will
** be picked up by the Query and Media classes, but may be overridden
** manually in the Query class only
**	Set to:
**	1 - Query for records marked as publish on the Internet only
**	2 - Intranet records
**	3 - All
**	Anything else - Internet
 */
$EMU_GLOBALS['DEFAULT_VISIBILITY'] = 2;

/*
** DEBUG - set to 1 to provide prints of all texql and additional
** exception information
*/
$EMU_GLOBALS['DEBUG'] = 0;

/*
** PHP error handling - E_ALL is everything except E_STRICT, 0 is off
*/
error_reporting(E_ALL | E_STRICT);

/*
** This is the function used to catch unhandled exceptions.
** It may be customised on a per-installation basis
*/
function
emuweb_exception_handler($e)
{
?>
	<html>
	<body>
		<center><h4>Uncaught Web5 exception:</h4></center>
		<table>
		<tr valign="top">
			<th>Message:</th>
			<td><?php print $e->getMessage(); ?></td>
		</tr>
		<tr valign="top">
			<th>Code:</th>
			<td><?php print $e->getCode(); ?></td>
		</tr>
		<tr valign="top">
			<th>File:</th>
			<td><?php print $e->getFile(); ?></td>
		</tr>
		<tr valign="top">
			<th>Line:</th>
			<td><?php print $e->getLine(); ?></td>
		</tr>
		<tr valign="top">
			<th>Call Stack:</th>
			<td>
				<?php
				$calls = $e->getTrace();
				for ($i=0; $i<count($calls); $i++)
				{
					$call = $calls[$i];
				?>
					<strong>Call <?php print $i;?>:</strong>
					<table>
					<tr>
						<th>File:</th>
						<td><?php print $call['file']; ?></td>
					</tr>
					<tr>
						<th>Line:</th>
						<td><?php print $call['line']; ?></td>
					</tr>
					<tr>
						<th>Function:</th>
						<td><?php print $call['function']; ?></td>
					</tr>
					<tr>
						<th>Class:</th>
						<td><?php print $call['class']; ?></td>
					</tr>
					<tr>
						<th>Type:</th>
						<td><?php print $call['type'];?></td>
					</tr>
					<tr>
						<th>Arguments:</th>
						<td><?php print_r($call['args']); ?></td>
					</tr>
					</table>
					<?php
				}
				?>
			</td>
		</tr>
		</table>
	</body>
	</html>
	<?php
}
set_exception_handler('emuweb_exception_handler');
?>
