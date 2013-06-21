<?php
include('header.inc');
?>

<p><a href="ResultsList.php?browse=artist&QueryPage=Query.php">Browse the collection by title</a></p>

<?php
require_once('../../objects/acni/QueryForms.php');

$queryform = new AcniBasicQueryForm;
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#5e5e5e';
$queryform->BorderColor = '#ccccc3';
$queryform->BodyColor = '#ffffff';
$queryform->Show();
?>
<p><a href="AdvQuery.php">Advanced search</a> | <a href="DtlQuery.php">Detailed search</a></p>
<?php
include('footer.inc');
?>

