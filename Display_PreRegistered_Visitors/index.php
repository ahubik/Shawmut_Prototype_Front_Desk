<!DOCTYPE html>
<html lang="en">
  <head>
	<!-- <meta http-equiv="refresh" content="300; URL='index.php'" /> -->

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Welcome to Shawmut</title>
    
    <!-- JS -->
    <script src='../jquery-2.2.4.min.js'></script>
    <script src='../bootstrap-3.3.6-dist/js/bootstrap.min.js'></script>

    <!-- Bootstrap Core CSS -->
    <!-- <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/3.3.6/css/bootstrap-combined.min.css" rel="stylesheet"> -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
<!--     <link href="../dist/css/sb-admin-2.css" rel="stylesheet"> -->
    <link href="table.css" rel="stylesheet">

    <!-- Custom Fonts -->
<!--     <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> -->
    <link href="cover.css" rel="stylesheet">
    <link href="shawmut.css" rel="stylesheet">

    <!-- Date Time Picker -->
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen"
     href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">    


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!-- [if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
     <![endif] -->
    
    <link href="../global.css" rel="stylesheet">
    
    <script>
    //alert('The event handler assginment script runs test how alerts deal with long strings aaaadsfasdfsdfasaaaaaaaaaaaaaaaaaaaaaa');
    jQuery(document).ready(function($) {
    	//alert('Jquery statements work');
    	//$("#confirm-registration").modal();
    	
        $(".clickable-element").click(function() {
            //alert('a click was registered, href=' + $(this).data("href"));
            //window.document.location = $(this).data("href");
            finalDestination = $(this).data("href");//the URL to be called after removing the line
            //and now, build the call to the script (kludge, make this more elegant if this project continues) that removes the line
            target = "Remove_Item_From_PreRegistered_List_Kludge.php?destination=" + encodeURIComponent(finalDestination);//call the script and add the final destination
            target += "&remove=" + $(this).data("row");//tell it which row to delete
            
            $("#confirmation-modal-body-text").text("Are you " + $(this).data("first") + " " + $(this).data("last") + " from " + $(this).data("company") + "?";//(Row #" + $(this).data("row") + ")?");
            $("#confirmation-modal-yes-button").click(function() {
            	window.document.location = target;
            });
            $("#confirm-registration").modal();
        });
    });
    </script>
  </head>

<body>

    <div id="wrapper">
        <div id="page-wrapper" class="span10">
			<div class="row">
                <div class="col-lg-12">
                    <a href="../signin/index.html"><img src="img/shawmut-logo.png" alt="Shawmut" max-height="100%" max-width="100%"></a>
                    <!-- h1 class="page-header">Pre-Registered visitors</h1>-->
				</div><!-- /.col-lg-12 -->
            </div> <!-- /.row -->
            <br><br><br><!-- Replace these with a bootstrap solution -->
            <div class="row">
                <div class="col-lg-12"><!-- a /div has been removed, because it seemed like it shouldn't be closed here, and I close it at the bottom of the page -->
                    <div class="panel panel-shawmut" style="border:none">
<!--                         <div class="panel-heading"></div> -->
                        <div class="panel-body panel-shawmut" style="border:none">
                            <div class="row">
                            	<div class="col-lg-1"></div>
                                <div class="col-lg-5" style="border:none; width=100%">
		                        	<div class="lightBG center-block infoBox">
		                            	Preregistered guests please click your name to sign in.  If your name is not on the list, please click on the "Register" button to the right.
		                            </div><!-- .lightBG .center-block .infobox -->
		                        </div><!-- col-lg-5 -->
		                        <div class="col-lg-1"></div>
		                        <div class="col-lg-5" style="border:none;">
	                                <div class="round-button pull-left">
		                                <div class="round-button-circle">
			                                <a href="../Front_Desk_Check_In" class="round-button">Register</a>
		                                </div><!-- /.round-button-circle -->
	                                </div><!-- /.round-button .pull-left -->
	                            </div><!-- /.col-lg-5 -->
	                        </div><!-- /row (containing info blurb and button) -->
	                        <br><br><!-- use bootstrap solution -->
	                        <div class="row">
	                         	<div class="col-lg-12 center-block container">
	                                <table class="table" style="margin: 0 auto; font-size: 20px;"><!-- Slightly kludgey but it works -->
	                                <?php 
	                                echo"<thead>";
	                                
	                                $path = "PreRegistered_Visitor_Data.csv";
	                                if (file_exists($path)) {
	                                	$pointer = fopen($path, 'r');
	                                } else {
	                                	echo "<p>There are no preregistered visitors right now</p>";
	                                	exit(0);
	                                }
									
									
									//echo "<br>"; //Debugging
									
									$keys = "";
									//$firstLine = True;
									//$oddRow = True;
									$rowCount = 0;
									$classStr = "";
									
									while(!feof($pointer))
	  								{
										$line = fgets($pointer);
										
										if (strlen(trim($line)) == 0){
											continue;
										}
										
										$items = explode(',', $line);
										//echo "[".implode("|", $items)."] <br>";
										
										$clickableString = "";//only populated for lines other than ther header (so that including it in the header generation just concats an empty string to it.
										
										if ($rowCount == 0) { //If it's the column titles
											$keys = $line;//save them as the keys
											$clickableString = " class='headerRow'";//Variable name misused for kludge but this is the easiest way to make it dark as appropriate
											
										} else {//otherwise it's a data row
											$classStr = "";
											if ($rowCount%2 != 0){
												$classStr .= " oddRow";
											} else {
												$classStr .= " evenRow";
											}
											$clickableString = " class='clickable-element".$classStr."' data-href='RecordVisitor.php?data=".urlencode($line)."&keys=".urlencode($keys)."'";//so add code to make them clickable
											$clickableString .= " data-first='".$items[1]."' data-last='".$items[2]."' data-company='".$items[3]."' data-row='".$rowCount."'";
											//$oddRow = ! $oddRow; this is now handled by incrementing $rowCount
										}
										echo "<tr" . $clickableString . ">\n";
										//echo "<td>$rowCount</td>";
																			
										
										$count = 0;
										
										$rowString = "";
										reset($items);
										foreach ($items as $item) {
											if ($count != 0 && $count !=7 && $count !=8){//Skip the form name and, for now, image fields as they're of no interest to anyone
												$rowString .= "<td>" . $item . "</td>\n";
											}
											$count += 1;
										}
										echo $rowString;
										
										//echo "</a>";
										echo "</tr>\n";
	
										if ($rowCount == 0) {
											echo "</thead>";
											//$firstLine = False;//and indicate that we've processes the firstline
										}
										$rowCount += 1;
	  								}
	  								
									fclose($pointer);
									
	                                ?>
	                                </table>                 
                                </div><!-- /col-lg-12 containing table -->
                            </div><!-- /row (nested 1nd deg., containing table)-->
                    	</div><!-- /.panel-body .panel-shawmut-->
                	</div> <!-- /.panel .panel-shawmut-->
            	</div><!-- /.col-lg-12 -->
        	</div><!-- /.row -->
    	</div><!-- /#page-wrapper .span-10-->
	</div><!-- /#wrapper -->

    <!-- jQuery -->
<!--     <script src="../bower_components/jquery/dist/jquery.min.js"></script> -->

    <!-- Bootstrap Core JavaScript -->
<!--     <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->

    <!-- Metis Menu Plugin JavaScript -->
<!--     <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script> -->

    <!-- Custom Theme JavaScript -->
<!--     <script src="../dist/js/sb-admin-2.js"></script> -->
<!-- This stuff is commented because the source as I (Alexander Hubik) recieved it does not contain the files referenced -->



	<div class="modal fade" id="confirm-registration" tabindex="-1" role="dialog"><!-- aria-labelledby="myModalLabel" aria-hidden="true" -->
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h2 id="confirmation-modal-header-text">Confirm Registration</h2>
				</div><!-- .modal-header -->
				<div class="modal-body">
					<p id="confirmation-modal-body-text">This field has not populated correctly.  Please contact the system administrator.</p>
				</div><!-- .modal-body -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<a id="confirmation-modal-yes-button" class="btn btn-danger btn-ok">Register</a>
				</div><!-- .modal-footer -->
			</div><!-- .modal-content -->
		</div><!-- .modal-dialog -->
	</div><!-- .modal .fade #confirm-registration-->
	
</body>

</html>