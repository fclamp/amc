	<?php include "header-small.html" ?>
	<body bgcolor="#AAC1C0">
		<h4>
			<font face="Tahoma" color="#013567" size="2">
				<b>Search results </b> in our prototype display...<br>
				Over time more data and images will be made available.<br>
				<br>
       	          		Use the back button on your browser to return to the results list.</font>
			</font>
		</h4>

		<p align=center>
			<?php
				require_once('../../../objects/nmnh/bot/DisplayObjects.php');
				// an example of how to redirect the party display pages
				$GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'] = '/mcs/bot/PartyDisplay.php';
				$display = new NmnhBotanyStandardDisplay;
				$display->FontFace = 'Arial';
				$display->FontSize = '2';
				$display->Width = '90%';
				$display->BodyTextColor = '#013567';
				$display->BorderColor = '#013567';
				$display->HeaderTextColor = '#FFFFFF';
				$display->BodyColor = '#FFF3DE';
				$display->HighlightColor = '#FFFFFF';
				$display->Show();
			?>
		</p>
		<br>
		<?php include "footer.php" ?>
	</body>

</html>
