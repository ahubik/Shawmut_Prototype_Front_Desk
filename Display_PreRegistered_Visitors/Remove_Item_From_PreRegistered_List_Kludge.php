<?php
//This is a temporary, stop-gap kludge and should be replaced with a better system, such as a discrete visitor list management system that can be called.

//get the neccesary data
$rowToBeRemovedRaw = $_GET["remove"];
$rowToBeRemoved = intval($rowToBeRemovedRaw);
//echo "Removing row #".strval($rowToBeRemoved);//if this is not commented there will be a bug.

//Code to remove row.  Not only is the general solution of creating a separate script to delete the line a bad, spaghetti-y kludge in and of itself,
//but this particular method of looping through the entire file, storing all of the lines I *don't* want to delete in memory at the same time,
//and the writing them back into the file is horribly inefficient and would fail drastically on large files.

//loop through and collect all the lines we want to keep
$path = "PreRegistered_Visitor_Data.csv";
if (file_exists($path)) {
	$pointer = fopen($path, 'r');
} else {//this would be pretty wierd but hey in theory it might happen.
	echo "There doesn't appear to be a Pre-Registered visitors file anymore.  This is a serious problem, contact your administrator.";
	exit(0);
}

$out = array();//create an empty array to store lines to go back into the file

$rowCount = 0;
	
while(!feof($pointer))
{
	$line = fgets($pointer);

	if ($rowCount != $rowToBeRemoved) { //Unless it's the line we're deleting
		$out[] = $line;//add it to the array of things that will be put in again.
	}
	$rowCount +=1;
}
	
fclose($pointer);

//put the lines we're keeping into the file
$pointer = fopen($path, "w+");
foreach($out as $line) {
    fwrite($pointer, $line);
}
flock($pointer, LOCK_UN);
fclose($pointer);  

//redirect 
header("Location: ".$_GET["destination"]);
//echo "<a href=".$_GET["destination"].">Move along</a>";//for testing only, should be commented out
die();
?>