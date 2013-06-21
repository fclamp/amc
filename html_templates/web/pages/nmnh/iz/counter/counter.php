<?php

 $counterFile = "access.txt";
    if (file_exists($counterFile))
    {
    $fp = fopen($counterFile,"r+");
    $count = fgets($fp,5);
    $count += 1;
    rewind($fp);
    fputs($fp,$count,5);
    fclose($fp);
    
    }
    else
    {
    $fp = fopen($counterFile,"w");
    $count = "1";
    fputs($fp,$count,5);
    fclose($fp);
   
    }
$open = fopen("hits.php","a+");
fputs($open,"<div align='left'><table border='0' cellpadding='0' cellspacing='0' width='92%'><tr><td width='30%'><p align='left'><font face='Verdana' color='#D5E4F2' size='1'><b>$REMOTE_ADDR</b></font></td><td width='70%'><p align='left'><font face='Verdana' color='#D5E4F2' size='1'><b>$HTTP_USER_AGENT</b></font></td></tr></table></div><br>");



?>
