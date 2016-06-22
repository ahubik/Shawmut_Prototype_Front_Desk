<?php
header("Refresh:10; url=../signin/index.html");

//echo "Version: ". phpversion() ."<br>";

$data = $_GET['data'];
$keys = $_GET['keys'];
//echo "Keys: " . $keys ."<br>";
//echo "Data: " . $data ."<br>";
$keysArray = explode(",", $keys);
$rawDataArray = explode(",", $data);
$dataArray = [];
//echo "Raw Data: {".implode("|", $rawDataArray)."}<br>";
//echo "raw keys: {".implode("|", $keysArray)."}<br>";

for ($i = 0; $i < count($keysArray); $i++){//loop through both arrays to populate $dataArray from key-value pairs
	$dataArray[$keysArray[$i]] = $rawDataArray[$i];
	//echo strval($i).": ".$keysArray[$i]." =&gt ".$rawDataArray[$i]."<br>";
}
//echo "Data Array: {" . implode("|", $dataArray) ."}<br>";
//echo "Array Keys: {".implode("|", array_keys($dataArray))."}<br>";
//echo "PHP strval of the data array: "

$date=date("Ymd");
$firstName=$dataArray['First Name'];
echo '<body bgcolor="#5d5597">';
echo "<br><br><br><br><font color='gray'><h1 align=center>Thanks for signing in ".$firstName."!</h1></font> <br>";
$fileName="Visitor_Log_".$date.".csv";
$path ="../" . $fileName;//one level up in top-level folder
//echo("The Form Name is [" . $dataArray['formName'] . "]");
//echo("The Path is [" . $path . "]");

$theFile = $path; //just put it in the same folder for now
//echo "The CSV file is ".$theFile;

$sourcePath = 'PreRegistered_Visitor_Data.csv';

$csv_column_names = array();//containers for columns and values, to be dynamically populated
$csv_values = array();
foreach ($dataArray as $key => $value) {//loop through the POST results, ignoring the title and any other special fields, to populate the column titles and values
	$fieldTitle = str_replace('_', ' ', $key);//Replace underscores with spaces for friendlier column titles
    $csv_column_names[] = $fieldTitle;
    $csv_values[$fieldTitle] = $value;     
}
$csvData = "";
    foreach ($csv_column_names as $name) {
        $csvData = $csvData . $csv_values[$name] . ",";
    }
//    $csvData = $csvData . $date . "\n";

//If the file does not exist, write the column headers first
if (file_exists($theFile)) {
	//no need to add column headers
	} else {
        $csvHeader="";
        $date_Placed = FALSE;
        foreach ($csv_column_names as $name) {
            if ($name == "Date") {
                $date_Placed = TRUE;
            }
            $csvHeader = $csvHeader . $name . ",";
        }
        if (!$date_Placed){//Put the Date at the end
            $csvHeader = $csvHeader . "Date";
        }
        $csvHeader = $csvHeader . "\n";
	$fp = fopen($theFile,"a"); // $fp is now the file pointer to file $filename

    if($fp){
        fwrite($fp,$csvHeader); // Write information to the file
        fclose($fp); // Close the file
    }
}

//write the data
//echo("The csvData is [" .$csvData. "]<p>");

$fp = fopen($theFile,"a"); // $fp is now the file pointer to file $filename

    if($fp){
        fwrite($fp,$csvData); // Write information to the file
        fclose($fp); // Close the file
    }
?>