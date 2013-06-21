Martin Jujou added on 5/2/2004

Interface for barcode/rfid/infrared/bluetooth scanner where 
a barcode number is found and the related object can be queried 

File: reader.php

At the moment the page continually checks the position of the mouse.
This is going to have to be changed to continally check the value of the scanner.

You would probably put somesort of php code in to do this instead of the 
current javascript.

Also the field is searching "SummaryData", this will have to be replaced to 
search a field where barcode/id's are kept. 


