<?php
include('header.inc');
?>

<?php
require_once('../../objects/acni/QueryForms.php');
$queryform = new AcniAdvancedQueryForm;
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#5e5e5e';
$queryform->BodyTextColor = '#000000';
$queryform->BorderColor = '#ccccc3';
$queryform->BodyColor = '#ffffff';
$queryform->Show();
?>
<p><a href="Query.php">Simple search</a> | <a href="DtlQuery.php">Detailed search</a></p>
<?php
include('footer.inc');
?>
