<?php
include('includes/header.inc');

require_once('../../objects/ram/QueryForms.php');
$query = new RamDetailedQueryForm();
$query->BorderColor = '#B6CD35';
$query->Border= '0';
$query->BodyColor = '#D9D9D9';
$query->ResultsListPage = 'ResultsList.php';
$query->Title = 'Search Apollo Catalogue';
?>
<?php $query->Show(); ?>
<div align="center"><a class="boldGrey" href="Query.php">Basic Query</a> | <a class="boldGrey" href="AdvancedQuery.php">Advanced Query</a></div>
<?php
include('includes/footer.inc');
?>
