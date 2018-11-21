<?php
// Logic, load the WelcomePreHeader.txt, increment the counter insert the counter, load the Welcomeheaderclosebodyopen.txt, based on 'count' extract a screen from content.csv, paste 'panel title' into stream, insert WelcomeFirstBodySeparator.txt, insert description, insert WelcomeSecondBodySeparator.txt, insert 'panel participants', insert WelcomeFinalBodySeparator.txt, insert line reading start: %start time% \t end: %end time% \t room: %room%, include closer, done

//first increment the counter. We'll be doing interesting things with it later, but adding '1' to it is sufficient for now. Otherwise assign stateful constants.
$_GET['count'] ++;
$now = time();
$today = date("D", $now);
$InterestingCount = 0;

//Now open up the file content.csv, and load it's contents into memory. and dump the lines we are interested in to the array Interesting.

$TheFile = "content.csv";
$Open = fopen ($TheFile, "r");
if ($Open) { //Ok folks, here we go...
	$Data = file($TheFile);
	for ($n = 1; $n < count($Data); $n++) { // Normally we start at 0, but line 0 is a header line, and we're not concerned with that here.
		$GetLine = explode("\t", $Data[$n]); // OK, '$GetLine now has the content of one line in several fields. 
		if ( $today == trim($GetLine[0]) ) { // The line does reference today at least...
			$start = strtotime($GetLine[1]);
			if ( time( $start + 1800 ) > $now ) { // Well, whatever is on the line started less than half an hour ago, or is still in the future, so...
				$end = strtotime($GetLine[2]);
				if ( time( $end - (3 * 3600) ) < $now ) { //now that's interesting, the event ends less than 3 hours from now...
					$Interesting[$InterestingCount ++] = $GetLine ; //grab the data
				}
			}
		}
        }
        fclose($Open);
}

// We now have everything of interst in the variable $Interesting. We're going to only be working with the 'line' that relates to the counter sent to us.
// since it is possible that the counter is greater than the number of results we have in $Interesting, let's revise that...

$WorkCount = $_GET['count'] % count($Data);
// It's possible we got back a negative result...
if ($WorkCount <= 0 ) { // Here we set some content for the possibility that there are no results.
	$PanelTitle = "Welcome to a Simple Information Page!";
	$PanelDescr = "This is ment to be simple. Add content to be shown to content.csv. It gets displayed in the center iframe by iframes.html or iframes2.html. If nothing for today exists, this content will be presented by iframes.html. iframes2.html will work through all of the content.";
	$PanelParts = "This set of pages was initially created for Convergence 2008, so I've included the content.csv file that I had created for that event. There are data";
	$PanelStart = "Start time and or date";
	$PanelEnd   = "End time";
	$PanelRoom  = "Some variety of location";
} else { // OK, this time we get things out of the $Interesting[$WorkCount] entry.
	$Working = explode( "\t", $Data[$WorkCount]);
	$PanelTitle = $Working[5];
	$PanelDescr = $Working[6];
	$PanelParts = $Working[7];
	$PanelStart = $Working[1];
	$PanelEnd   = $Working[2];
	$PanelRoom  = $Working[3];
}

 include 'Welcome1PreHeader.txt';
 print $WorkCount . "\"></head><body style=\"background-color:black;color:gold;font-family:sans-serif\"> <p style=\"text-align: center;font-size: 200%;\"><strong>";
 print $PanelTitle;
 print "</p> <hr> <p style=\"text-align: center; italic;\">";
 print $PanelDescr;
 include 'WelcomeSecondBodySeparator.txt';
 print $PanelParts;
 include 'WelcomeFinalBodySeparator.txt';
 print "<table align=center Width=90% border=0><colgroup><col width=\"33%\"></colgroup><tr align=\"center\"><td>Start: $PanelStart </td><td> End: $PanelEnd </td><td> Location: $PanelRoom</td></tr></table>";
 include 'WelcomeFinal.txt';

?>
