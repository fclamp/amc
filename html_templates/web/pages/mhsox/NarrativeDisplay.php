<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Display</title>
</head>

<body bgcolor="#FFFFFF">
<h3><font face="Tahoma" color="#013567">&nbsp;Our Collection...</font></h3><br>

      <p align=center>
      <?php
      require_once('../../objects/common/NarrativeDisplayObject.php');
      $display = new NarrativeDisplay;
      $display->FontFace = 'Tahoma';
      $display->FontSize = '2';
      $display->BodyTextColor = '#336699';
      $display->BorderColor = '#336699';
      $display->HeaderTextColor = '#FFFFFF';
      $display->BodyColor = '#F2F2F2';
      $display->HighlightColor = '#FFFFFF';
      $display->Title = " ";
      $display->Show();
      ?>
      </p>
      <br>

      </body>

</html>

