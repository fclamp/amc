<?php
include('includes/header.inc');

require_once('../../objects/ram/QueryForms.php');
$query = new RamBasicQueryForm();
$query->BorderColor = '#B6CD35';
$query->Border= '0';
$query->BodyColor = '#D9D9D9';
$query->ResultsListPage = 'ResultsList.php';
$query->Title = 'Search Apollo Catalogue';
?>

Welcome to Apollo - the Academy's Museum Collections Online Catalogue.<br /><br />
There are 3 types of search. Enter a keyword in the box below to do a quick search across the whole catalogue, or refine your search using our <a href="DetailedQuery.php"><b>Detailed</b></a> or <a href="AdvancedQuery.php"><b>Advanced</b></a> search options. For best results please begin with a single word or name.<br /><br />

For more searching tips and guidance, please visit the <a href="Help.php">HELP</a> page. <br /> <br />

<div align="center"><?php $query->Show(); ?></div>
<div align="center"><a class="boldGrey" href="AdvancedQuery.php">Advanced Query</a> | <a class="boldGrey" href="DetailedQuery.php">Detailed Query</a></div>

<h4>Quick Searches</h4>
<ul>
<li><a href="ResultsList.php?quicksearch=paintings">Paintings and Drawings</a></li>
<li><a href="ResultsList.php?quicksearch=archive">Academy Archive Images</a></li>
<li><a href="ResultsList.php?quicksearch=photos">Photographs</a></li>
<li><a href="ResultsList.php?quicksearch=venues">Venues</a></li>
<li><a href="ResultsList.php?quicksearch=playbills">Playbills and Programmes</a></li>
<li><a href="ResultsList.php?quicksearch=prints">Prints</a></li>
<li><a href="ResultsList.php?quicksearch=sculpture">Sculpture</a></li>
<li><a href="ResultsList.php?quicksearch=manuscripts">Manuscripts and Early Printed Music</a></li>
<li><a href="ResultsList.php?quicksearch=opera">Opera</a></li>
<li><a href="ResultsList.php?quicksearch=sheet">Illustrated Sheet Music</a></li>
<li><a href="ResultsList.php?quicksearch=worldmusic">World Music</a></li>
<li><a href="ResultsList.php?quicksearch=instruments">Instruments</a></li>
<li><a href="ResultsList.php?quicksearch=documents">Documents</a></li>

</ul>

Please contact: <a href="mailto:j.snowman@ram.ac.uk">j.snowman@ram.ac.uk</a> for information on Museum Collections and Apollo Catalogue.<br /><br />


<?php
include('includes/footer.inc');
?>
