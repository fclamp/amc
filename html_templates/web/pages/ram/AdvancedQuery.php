<?php
include('includes/header.inc');

require_once('../../objects/ram/QueryForms.php');
$query = new RamAdvancedQueryForm();
$query->BorderColor = '#B6CD35';
$query->BodyColor =  '#D9D9D9';
$query->Border = '0';
$query->Title= 'Search Apollo Catalogue';
?>
<div align="center"><?php $query->Show(); ?></div>
<div align="center"><a class="boldGrey" href="Query.php">Basic Query</a> | <a class="boldGrey" href="DetailedQuery.php">Detailed Query</a></div>
<?php
include('includes/footer.inc');
?>
