<html>
<head>
<title>Convention Needs.</title>
	<meta http-equiv=Refresh content="600;url=qlog.php">
</head>
<body  Background="Paper3.jpg">
<h1>Con Needs</h1>
<hr>
Please enter things that need immediate attention so that people can see them on the big board at the Volunteers desk. These will be in red print across the top of the screen. Update cycle for the crawl is 2 minutes. Ultimately the pages contents will have a lifetime of 60 minutes from submission.
<p>
<?
function WriteToFile ($Description, $Submitter) {
/* Function WriteToFile takes one argument--Description--which will be written to an external file. */

	$TheFile = "qlog.txt";
	$Open = fopen ($TheFile, "a");
	$timestamp = time();
	$Date = date("Y/m/d H:i:s",$timestamp);
	if ($Open) {
		fwrite ($Open,"$Date\t$Description - $Submitter\n");
		fclose ($Open);
		$Worked = TRUE;
	} else {
		$Worked = FALSE;
	}
	return $Worked;
} // End of WriteToFile Function.

function ReadfromFile() {
/* Function ReadFromFile displays all the information stored in an external file. */
	print ("<FORM ACTION=\"qlog.php\" method=post>\n");
	$TheFile = "qlog.txt";
	$Open = fopen ($TheFile, "r");
	if ($Open) {
		// print ("qlog.txt currently reads as:<P>\n");
		print ("qlog.txt log as a table:<table border=0><colgroup><col width=\"250\"><col width=\"800\"></colgroup><tr><th>Timestamp (gmt)<th>Log Entry");
		$Data = file($TheFile);
		for ($n = 0; $n < count($Data); $n++) {
			$GetLine = explode("\t", $Data[$n]);
			print ("<tr><td style=\"font-family:Comic Sans MS;font-size:110%;color:darkgreen\">$GetLine[0]<input type=\"radio\" name=\"Purge\" value=\"$n\"><td style=\"font-family:Comic Sans MS;font-size:80%;color:darkgreen\"> $GetLine[1]<br>\n");
		}
		fclose($Open);
		print ("</table><hr><p>\n");
	} else {
		print ("Unable to read from qlog.txt!<BR>\n");
	}
}	// end of ReadFromFile Function

function PurgeRecord( $PurgeRecord ) {
/* funciton PurgeRecord takes a record number loads the entire log file, and writes everything back except the record that
   matches */
        $TheFile = "qlog.txt";
        $Open = fopen ($TheFile, "r");
        if ($Open) {
                $Data = file($TheFile);
                fclose($Open);
        } else {
                print ("Unable to read from qlog.txt!<BR>\n");
        }
	$Open = fopen ($TheFile, "w");
	if ($Open) {
		for ($n=0 ; $n<count($Data); $n++) {
			if ( $n <> $PurgeRecord ) { fwrite($Open,$Data[$n]) ; } ;
		};
		fclose ($Open);
	} else {
		print ("unable to write to file!<br>\n");
	}
	print "PurgeRecord - done. \n";
}

function CreateForm() {
/* function CreateForm will display the HTML form. */
	print ("Add a log entry to the log file:\n");
	print ("<FORM ACTION=\"qlog.php\" method=post>\n");
	print ("Log Entry <input type=text name=\"LogEntry\" size=60><br>\n");
	print ("Submitter <input type=text name=\"Submitter\" size=20><br>\n");
	print ("<input type=hidden name=\"BeenSubmitted\" value=\"TRUE\">\n");
	print ("<input TYPE=SUBMIT value=\"Submit\">\n</form><p><a href=\"qlog.php\">reload this page</a>.\n$Array[Purge]");
} // end of CreateForm function.

function HandleForm() {
$Array[LogEntry] = $_REQUEST['LogEntry'];
$Array[Submitter] = $_REQUEST['Submitter'];
$Array[Purge] = $_REQUEST['Purge'];
	if ($Array[Purge] <> "" ) { $CallFunction = PurgeRecord($Array[Purge]); } else {
		$CallFunction = WriteToFile($Array[LogEntry], $Array[Submitter]);
		if ($CallFunction) {
			print ("$Array[Submitter] Your Submission--$Array[LogEntry]--has been received!<br>\n");
		} else {
			print ("Your submission was not processed due to a system error!<br>\n");
		}
	}
}

/* This next conditional determines whethr to handle the form, depending upo whether or not $BeenSubmitted is TRUE. */


$BeenSubmitted = $_REQUEST['BeenSubmitted'];


if ($BeenSubmitted) {
	HandleForm();
}
ReadFromFile();
CreateForm();

?>
</body>
</html>

