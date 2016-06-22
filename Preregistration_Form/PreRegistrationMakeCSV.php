<?php
header("Refresh:10; url=index.html");

$date=date("Ymd");
$fullName = $_POST['First_Name']." ".$_POST['Last_Name'];
echo '<body bgcolor="#5d5597">';
echo "<br><br><br><br><font color='gray'><h1 align=center>You have Pre-Registered ".$fullName."!</h1></font> <br> <button align=center onclick=\"window.location.href='index.html'\">Go Back</button>";
$fileName="PreRegistered_Visitor_Data.csv";
$path ="../Display_PreRegistered_Visitors/" . $fileName;
//echo("The Form Name is [" . $_POST['formName'] . "]");
//echo("The Path is [" . $path . "]");

$theFile = $path; //just put it in the same folder for now
//echo "The CSV file is ".$theFile;

$csv_column_names = array();//containers for columns and values, to be dynamically populated
$csv_values = array();
foreach ($_POST as $key => $value) {//loop through the POST results, ignoring the title and any other special fields, to populate the column titles and values
	$fieldTitle = str_replace('_', ' ', $key);//Replace underscores with spaces for friendlier column titles
    $csv_column_names[] = $fieldTitle;
    $csv_values[$fieldTitle] = $value;     
}
$csvData = "";
    foreach ($csv_column_names as $name) {
        $csvData = $csvData . $csv_values[$name] . ",";
    }
    $csvData = $csvData . $date . "\n";
    //$csvData = $csvData . "\n";

//If the file does not exist, write the column headers first
if (file_exists($theFile)) {
	//no need to add column headers
	} else {
        $csvHeader="";
        $date_Placed = TRUE; //Kludge but otherwise there are two date fields
        foreach ($csv_column_names as $name) {
            if ($name == "Date") {
                $date_Placed = TRUE;
            }
            if ($csvHeader != "") {
            	$csvHeader .= ",";
            }
            $csvHeader = $csvHeader . $name;
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