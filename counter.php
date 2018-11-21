<?php
// counter, update a url referrer with an incremented counter for this page.

//$sessioncounter = 
$_GET['counter'] ++ ;

print "<html><head><meta http-equiv=Refresh content=\"10;url=counter.php?counter=" . $_GET['counter'] . "\">";
print "<title>A simple counter</title>";
print "</head><body>Value of counter is now " . $_GET['counter'] . ".</body></html>";

?>
