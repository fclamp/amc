<?php
if (! isset($WEB_ROOT))
	$WEB_ROOT = dirname(__FILE__);
require("$WEB_ROOT/common.php");

$show = "objects";
if (isset($_REQUEST['show']))
	$show = $_REQUEST['show'];

$audience = "";
if (isset($_REQUEST['audience']))
	$audience = $_REQUEST['audience'];

$authors = "";
if (isset($_REQUEST['authors']))
	$authors = $_REQUEST['authors'];

$category = "";
if (isset($_REQUEST['category']))
	$category = $_REQUEST['category'];

$description = "";
if (isset($_REQUEST['description']))
	$description = $_REQUEST['description'];

$keywords = "";
if (isset($_REQUEST['keywords']))
	$keywords = $_REQUEST['keywords'];

$medium = "";
if (isset($_REQUEST['medium']))
	$medium = $_REQUEST['medium'];

$narrative = "";
if (isset($_REQUEST['narrative']))
	$narrative = $_REQUEST['narrative'];

$subjects = "";
if (isset($_REQUEST['subjects']))
	$subjects = $_REQUEST['subjects'];

$technique = "";
if (isset($_REQUEST['technique']))
	$technique = $_REQUEST['technique'];

$title = "";
if (isset($_REQUEST['title']))
	$title = $_REQUEST['title'];

$pageTitle = "Search our Collections";
pageHeader($pageTitle);

?>

<div id="imagebar">
<div id="wideimageleft"><h1><img src="<?php print $urlRoot; ?>/images/search/leftwide.jpg" alt="The National Museum" /></h1>
  </div>
  <div id="wideimageright"><img src="<?php print $urlRoot; ?>/images/search/rightwide.jpg" alt="The National Museum" />
  </div>
</div>

<div id="SearchTabs">
  <ul>
		<li id="tab1" class="SearchActive">
			<a href="javascript:SwitchSearchTabs('objects');">Objects</a>
		</li>

		<li id="tab2">
			<a href="javascript:SwitchSearchTabs('narratives');">Narratives</a>
		</li>
	</ul>

  <div class="SearchArea" id="objectsearch">
		<form id="objectSearch" action="objects/results.php">
		<table>
		<tr>
			<th>Keywords:</th>
			<th>Main Title:</th>
      <th>Category:</th>
    </tr>
      <tr>
      
      <td>
				<input name="keywords" value="<?php echo $keywords ?>" />
			</td>
		   <td>
				<input name="title" value="<?php echo $title ?>" />
				</td>
			<td>
				<input name="category" value="<?php echo $category ?>" />
			</td>
      
    <tr>
			</tr>
		<tr>
		
			<th>Description:</th>
			<th>Technique:</th>
      <th>Medium:</th>
    </tr>
      <tr>
      <td>
				<input name="description" value="<?php echo $description ?>" />
			</td>
		<td>
				<input name="technique" value="<?php echo $technique ?>" />
			</td>
    <td>
				<input name="medium" value="<?php echo $medium ?>" />
			</td>
    </tr>
	
		</table>



	
		
		<input type="submit" value="Search" />


<!--
		<input type="reset" value="Clear" />
-->
		</form>
	</div>

	<div class="SearchArea" id="narrativesearch">
		<form id="narrativeSearch" action="narratives/results.php">
		<table>

		<tr>
			<th>Title:</th>
			<th>Narrative text:</th>
			<th>Audience:</th>
    </tr>
    <tr>
      <td>
				<input name="title" value="<?php echo $title ?>" />
			</td>	
			<td>
				<input name="narrative" value="<?php echo $narrative ?>" />
			</td>			
			<td>
				<input name="audience" value="<?php echo $audience ?>" />
			</td>
	
  
    </div>
  
  
  </tr>
		<tr>
			<th>Authors:</th>
			<th>Subjects/Keywords:</th>
    </tr>
      <tr>
      
      
      
      <td>
				<input name="authors" value="<?php echo $authors ?>" />
			</td>
		
	
			
			<td>
				<input name="subjects" value="<?php echo $subjects ?>" />
			</td>
			<td colspan="2">
			</td>
		</tr>
		</table>
		
		
    <input type="submit" value="Search" />
<!--
		<input type="reset" value="Clear" />
-->
		</form>
	

</div>

<script type="text/javascript">
	SwitchSearchTabs('<?php echo $show ?>');
</script>

<div id="copylogo">
  <div id="copy">
    <h6>&copy; The National Museum, All Rights Reserved |<a href="#">Copyright Information</a> | <a href="#">Linking Policy</a></h6>
  </div>
  <div id="logo">
    <a href="http://www.kesoftware.com/"><img src="images/structure/NB2.png" alt="KE Software" width="250" height="31" border="0" /></a>  </div>
  </div>


<?php
pageFooter();
?>
