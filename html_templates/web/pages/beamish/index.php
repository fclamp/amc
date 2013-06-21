<?php
include('./includes/header.inc');
?>
<h4>Keyword search</h4>
<p>Enter simple keywords below, or click <a href="advquery.php">advanced search</a> for further search options</p>
<form method="get" action="results.php">
	<input type="text" name="Keywords" />
	<input type="submit" value="Search" />
</form>
<?php
include('./includes/footer.inc');
?>
