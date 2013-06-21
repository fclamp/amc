<hr noshade size=2 width=814 align=left>
<font face="Tahoma, Helvetica, sans-serif" size="2" color="#013567">
<?
        $EMU_ROOT = dirname(dirname(dirname(dirname(dirname(realpath(__FILE__))))));
        $dir_handle = @opendir($EMU_ROOT) or die("Unable to open file");
        while ($file = readdir($dir_handle))
        {
                if (ereg ("^.emu_web_env-num_recs-([0-9]{1,9})", $file, $records))
                {
                        $myrecords = number_format($records[1],0);
                }
                if (ereg ("^.emu_web_env-([0-9]{4})\-([0-9]{2})\-([0-9]{2})", $file, $date))
                {
                        $mydate = $date[1] . "-" . $date[2] . "-" . $date[3];
                        $mydate = strtotime($mydate);
                        $my_realdate = date("d-F-Y", $mydate);
                }

        }
        print $myrecords . " records; data current as of " . $my_realdate;
        closedir($dir_handle);
?>
</font>
