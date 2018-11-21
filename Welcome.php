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
		if ( $today == $GetLine[0] ) { // The line does reference today at least...
//			$start = strtotime($GetLine[1]);
//			if ( time( $start + 1800 ) > $now ) { // Well, whatever is on the line started less than half an hour ago, or is still in the future, so...
//				$end = strtotime($GetLine[2]);
//				if ( time( $end - (3 * 3600) ) < $now ) { //now that's interesting, the event ends less than 3 hours from now...
					$Interesting[$InterestingCount] = $Data[$n] ; //grab the data
					$InterestingCount ++ ;
//				}
//			}
		}
        }
        fclose($Open);
}

// We now have everything of interst in the variable $Interesting. We're going to only be working with the 'line' that relates to the counter sent to us.
// since it is possible that the counter is greater than the number of results we have in $Interesting, let's revise that...

if (count($Interesting) <> 0 ) {
	$WorkCount = $_GET['count'] % count($Interesting);
	$Working = explode( "\t", $Interesting[$WorkCount]);
	$PanelTitle = $Working[5];
	$PanelDescr = $Working[6];
	$PanelParts = $Working[7];
	$PanelStart = $Working[1];
	$PanelEnd   = $Working[2];
	$PanelRoom  = $Working[3];
	$WorkDelay  = floor( strlen( $PanelDescr ) / 15 );
	if ($WorkDelay < 10 ) { $WorkDelay = 10 ; } ;
	if ($WorkDelay > 30 ) { $WorkDelay = 30 ; } ;
} else {;
 // Here we set some content for the possibility that there are no results.
	$PanelTitle = "Welcome to CONvergence 2009!";
	$PanelDescr = "The Lighter Side of Science Fiction and Fantasy";
	$PanelParts = "Finsied? Of course I haven't Finished! I haven't even Begun. <br> Surely your intelect is dizzying.";
	$PanelStart = "July 2, 2009";
	$PanelEnd   = "July 5, 2009";
	$PanelRoom  = "Shereton - Bloomington";
	$WorkCount = 0; // let's not forget what to do when there's nothing happening...
	$WorkDelay = 300;
}; 
	


 include 'WelcomePreHeader.txt';
 print "$WorkDelay;url=Welcome.php?count=$WorkCount\"></head><body style=\"background-color:black;color:gold;font-family:sans-serif\"> <p style=\"text-align: center;font-size: 200%;\"><strong>";
// include "WelcomeHeaderCloseBodyOpen.txt";
// print "Welcome to Convergence 2008";
 print $PanelTitle;
 print "</p> <hr> <p style=\"text-align: center; italic;\">";
// include 'WelcomeFirstBodySeparator.txt';
// print "4 days to party like it's 1999!";
 print $PanelDescr;
 include 'WelcomeSecondBodySeparator.txt';
// print "Come on people Let's get down and party!";
 print $PanelParts;
 include 'WelcomeFinalBodySeparator.txt';
 print "<table align=center Width=90% border=0><colgroup><col width=\"33%\"></colgroup><tr align=\"center\"><td>Start: $PanelStart </td><td> End: $PanelEnd </td><td> Location: $PanelRoom</td></tr></table>";
 include 'WelcomeFinal.txt';

?>
