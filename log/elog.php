<html>
<head>
<title>A quick and dirty Log file updater.</title>
<!--        <style type="text/css">
          form.clock input { font-size: 10pt;
                           background-color:white; 
                           border: none; display:inline; }
          #zulu { width:160px;
                 border-left:1px solid black;
                 border-bottom:1px solid black;
                 border-top:1px solid black;
                 border-right:1px solid black;
                 float:right;
                 padding:5px;
                 margin:0px 0px 5px 5px;
	         background-color:#eeeeee;}
	</style>
									      
	<script type="text/javascript">
	      function DoTick() {
	        var d=new Date();
	        var s = d.toUTCString();
	        s = s.replace(" GMT", "Z");
	        s = s.replace(" UTC", "Z");
		s = s.substring(5);
	        s = s.replace(":",".","g");
	        document.getElementById("clock").zulu.value = s;
	      }
            self.setInterval("DoTick()",1000);
        </script> -->
	<!-- <meta http-equiv=Refresh content="600;url=qlog.php"> -->
</head>
<body>
<!--	<div id-"main">
		<div id="Zulu">
			<form class="clock" id="clock" action="">
				<input name="zulu" type="text"/>
			</form>
		</div>
	</div> -->
<?
function WriteToFile ($Description, $Submitter) {
/* Function WriteToFile takes one argument--Description--which will be written to an external file. */

	$TheFile = "qlog.txt";
	$Open = fopen ($TheFile, "a");
	$timestamp = time();
	$Date = gmdate("Y/m/d H:i:s",$timestamp);
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
/* Function RadFromFile displays all the information stored in an external file. */
	$TheFile = "qlog.txt";
	$Open = fopen ($TheFile, "r");
	if ($Open) {
		// print ("qlog.txt currently reads as:<P>\n");
		print ("qlog.txt log as a table:<table border=1><colgroup><col width=\"200\"><col width=\"800\"></colgroup><tr><th>Timestamp (gmt)<th>Log Entry");
		$Data = file($TheFile);
		for ($n = 0; $n < count($Data); $n++) {
			$GetLine = explode("\t", $Data[$n]);
			print ("<tr><td>$GetLine[0]<td> $GetLine[1]<br>\n");
		}
		fclose($Open);
		print ("</table><hr><p>\n");
	} else {
		print ("Unable to read from qlog.txt!<BR>\n");
	}
}	// end of ReadFromFile Function

function CreateForm() {
/* function CreateForm will display the HTML form. */
	print ("Add a log entry to the log file:\n");
	print ("<FORM ACTION=\"elog.php\" method=post>\n");
	print ("Log Entry <input type=text name=\"LogEntry\" size=60><br>\n");
	print ("Submitter <input type=text name=\"Submitter\" size=20><br>\n");
	print ("<input type=hidden name=\"BeenSubmitted\" value=\"TRUE\">\n");
	print ("<input TYPE=SUBMIT value=\"Submit\">\n</form><p>\n");
} // end of CreateForm function.

function HandleForm() {
$Array[LogEntry] = $_REQUEST['LogEntry'];
$Array[Submitter] = $_REQUEST['Submitter'];

		$CallFunction = WriteToFile($Array[LogEntry], $Array[Submitter]);
		if ($CallFunction) {
			print ("$Array[Submitter] Your Submission--$Array[LogEntry]--has been received!<br>\n");
		} else {
			print ("Your submission was not processed due to a system error!<br>\n");
		}
}

/* This next conditional determines whethr to handle the form, depending upo whether or not $BeenSubmitted is TRUE. */


$BeenSubmitted = $_REQUEST['BeenSubmitted'];


if ($BeenSubmitted) {
	HandleForm();
}
/* ReadFromFile(); */
CreateForm();

?>
</body>
</html>

