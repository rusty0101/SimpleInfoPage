<?php
 
 include 'Crawl2head.txt';
 $MyData= "var message = \"".date("D, H:i")." - ";
 $crawl1FileName = "conlog/qlog.txt";
 $fh = fopen($crawl1FileName, 'r') or die("Can't open file $crawl1FileName");
 $theData = fgets($fh);
 $MyData= $MyData.substr($theData,0,strlen($theData)-1)." - ";
 while ($theData <> "") {
	$theData = fgets($fh);
	$theData = substr($theData,0,strlen($theData)-1);
	$MyData=$MyData.$theData." - ";
  };
 fclose($fh);
 echo $MyData." |\""; 
 include 'Crawl2tail.txt';
?>
