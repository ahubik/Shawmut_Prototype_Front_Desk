<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="refresh" content="300; URL='index.html'" />

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Welcome to Shawmut</title>

    <!-- Bootstrap Core CSS -->
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="table.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="cover.css" rel="stylesheet">
    <link href="shawmut.css" rel="stylesheet">

    <!-- Date Time Picker -->
    <link href="css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" media="screen"
     href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">    


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!-- [if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
     <![endif] -->
    
    <script src='../jquery-3.0.0.min.js'></script>
    <script>
    //alert('The event handler assginment script runs test how alerts deal with long strings aaaadsfasdfsdfasaaaaaaaaaaaaaaaaaaaaaa');
    jQuery(document).ready(function($) {
    	//alert('Jquery statements work');
        $(".clickable-element").click(function() {
            //alert('a click was registered, href=' + $(this).data("href"));
            window.document.location = $(this).data("href");
        });
    });
    </script>
  </head>

<body>
<style type="text/css">
   body { background: #5d5597 !important; }
</style>
    <div id="wrapper">
        <div id="page-wrapper" class="span10">
            <div class="row">
                <div class="col-lg-12">
                    <a href="../signin/index.html"><img src="img/shawmut-logo.png" alt="Shawmut" max-height="100%" max-width="100%"></a>
                    <!-- h1 class="page-header">Pre-Registered visitors</h1>-->
				</div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <br><br><br>
            <div class="row">
                <div class="col-lg-12"></div>
                    <div class="panel panel-shawmut" style="border:none">
<!--                         <div class="panel-heading"> -->
<!--                         </div> -->
                        <div class="panel-body panel-shawmut" style="border:none">
                            <div class="row">
                            	<div class="col-lg-1"></div>
                                <div class="col-lg-5" style="border:none; width=100%">
		                        	<div class="lightBG center-block infoBox">
		                            	Preregistered guests please click your name to sign in.  If your name is not on the list, please click on the "Register" button to the right.
		                            </div>
		                        </div>
		                        <div class="col-lg-1"></div>
		                        <div class="col-lg-5" style="border:none;">
		                        
	                                <div class="round-button pull-left">
		                                <div class="round-button-circle">
			                                <a href="../Front_Desk_Check_In" class="round-button">Register</a>
		                                </div>
	                                </div>
	                                
	                             </div>
	                         </div>
	                         <br><br>
	                         <div class="row">
	                         	<div class="col-lg-12 center-block container">
	                                <table class="table" style="margin: 0 auto; font-size: 20px;"><!-- Slightly kludgey but it works -->
	                                <thead> <!-- /thead-->
	                                <?php 
	                                
	                                $path = "PreRegistered_Visitor_Data.csv";
	                                if (file_exists($path)) {
	                                	$pointer = fopen($path, 'r');
	                                } else {
	                                	echo "<p>There are no preregistered visitors right now</p>";
	                                	exit(0);
	                                }
									
									
									//echo "<br>"; //Debugging
									
									$keys = "";
									$firstLine = True;
									$oddRow = True;
									$classStr = "";
									while(!feof($pointer))
	  								{
										$line = fgets($pointer);
										$clickableString = "";//only populated for lines other than ther header (so that including it in the header generation just concats an empty string to it.
										
										if ($firstLine) { //If it's the column titles
											$keys = $line;//save them as the keys
											$clickableString = " class='headerRow'";//Variable name misused for kludge but it makes it dark as appropriate
											
										} else {//otherwise it's a data row
											$classStr = "";
											if ($oddRow){
												$classStr .= " oddRow";
											} else {
												$classStr .= " evenRow";
											}
											$clickableString = " class='clickable-element".$classStr."' data-href='RecordVisitor.php?data=".urlencode($line)."&keys=".urlencode($keys)."'";//so add code to make them clickable
											$oddRow = ! $oddRow;
										}
										echo "<tr" . $clickableString . ">\n";
										//echo "<a href='RecordVisitor.php'>";//Ineffective
																			
										$items = explode(',', $line);
										//echo "[".implode("|", $items)."] <br>";
										$count = 0; //debug
										
										$rowString = "";
										reset($items);
										foreach ($items as $item) {
											//echo "<td>" . $item ." (no. ". $count . ")</td>";
											if ($count != 0 && $count !=7 && $count !=8){//Skip the form name and, for now, image fields as they're of no interest to anyone
												$rowString .= "<td>" . $item . "</td>\n";
											}
											$count += 1;
										}
										echo $rowString;
										
										//echo "</a>";
										echo "</tr>\n";
	
										if ($firstLine) {
											echo "</thead>";
											$firstLine = False;//and indicate that we've processes the firstline
										}
	  								}
	  								
									fclose($pointer);
									
	                                ?>
	                                </table>                 
                                </div>
                                </div>
                                
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
<!--     <script src="../bower_components/jquery/dist/jquery.min.js"></script> -->

    <!-- Bootstrap Core JavaScript -->
<!--     <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->

    <!-- Metis Menu Plugin JavaScript -->
<!--     <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script> -->

    <!-- Custom Theme JavaScript -->
<!--     <script src="../dist/js/sb-admin-2.js"></script> -->
<!-- This stuff is commented because the source as I (Alexander Hubik) recieved it does not contain the files referenced -->

</body>

</html>