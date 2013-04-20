<?

//-----------------------------------------
// Andrew Hazelden's Solar Dashboard v3.8
// Updated July 9, 2011
//-----------------------------------------
// email: andrew@andrewhazelden.com
// web: www.andrewhazelden.com
//-----------------------------------------
// The source code is free for non-commercial use. Attribution is required.
//-----------------------------------------

//------------------------------------
// Pachube Login Settings
//------------------------------------
// Note: Non-Pro pachube users only get the first 100 records!
//
// Make sure to enter your pachube / cosm.com login details in the scripts "index.php"
// and "graph.php".
//------------------------------------

//Type your Pachube username here:
$pachube_username = "";

//Type your Pachube password here:
$pachube_password = "";


//------------------------------------
// Gauge Maximum / Minimum Values
//------------------------------------

//Set the maximum watts for the power gauge
$max_watts = 8000;


$max_temp = 60.0;

$min_temp = 20.0;



//------------------------------------
//Page reload counter
//------------------------------------
if (isset($_COOKIE['reload_counter'])) {
$reload_counter=$_COOKIE['reload_counter'] +1;
setcookie ('reload_counter', $reload_counter);
} else {
setcookie ('reload_counter', '1');
}



$inc = 0;
$row = 1;




//------------------------------------
// Acccess pachube data
//------------------------------------


$request = "http://$pachube_username:$pachube_password@pachube.com/api/24922.csv";

//old local .csv data fetching line:
//if (($handle = fopen("datalog.csv", "r")) !== FALSE) {

if (($handle = fopen($request, "r")) !== FALSE) {
    while (   (($data = fgetcsv($handle, 1000, ",")) !== FALSE)  && ($inc==0)  ) {
    $solar_panel = $data[0];
	$top_of_tank = $data[1];
	$bottom_of_tank = $data[2];
	$jacuzzi_pump = $data[3];
	$watts = $data[4];
	
	
	

	
	
	//Auto scaling gauge maximum value
	//$max_temp = 20.0;
	//if ($solar_panel > $max_temp) $max_temp = floor($solar_panel);
	//if ($top_of_tank > $max_temp) $max_temp = floor($top_of_tank);
	//if ($bottom_of_tank > $max_temp) $max_temp = floor($bottom_of_tank);
	//if ($jacuzzi_pump > $max_temp) $max_temp = floor($jacuzzi_pump);
	
    $inc++;
     }
    fclose($handle);
}

//------------------------------------
//
// Set old_watts cookie
//
//------------------------------------


if (isset($_GET['old_watts'])){
setcookie ('old_watts', $_GET['old_watts']);
//get the old watts value from the url via the get command
$old_watts = $_GET['old_watts'];
}
else if (isset($_COOKIE['old_watts'])) {
//get the old watts value from the cookie
$old_watts=$_COOKIE['old_watts'];

//then set the current watts value to the cookie
setcookie ('old_watts', $watts);
} 
else {
//if the cookie is empty set the current watts value
setcookie ('old_watts', $watts);
$old_watts = $watts;
}


?>
<!-- Andrew Hazelden's Solar Dashboard V3.8 andrewhazelden@gmail.com -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

<!-- Auto-reload the page every 120 seconds -->
<meta http-equiv="refresh" content="120; url=index.php" />

<!-- Scale view for iOS devices -->
<meta name = "viewport" content = "width = device-width" />

<!-- Add custom icons -->
<link rel="apple-touch-icon-precomposed" href="apple-touch-icon.png" />
<link rel="shortcut icon"  href="favicon.ico" />    
     
<title>Villa Azul Dashboard</title>

<style type="text/css"> 
    <!--

	p {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-style: normal;
	font-weight: normal;
	font-size: 10px;
	background-color: transparent;
	color:#000000;  
	}
	
    h1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-style: normal;
	font-weight: normal;
	font-size: 18pt;
	background-color: transparent;
	color:#000000;  
	}

	a:link {text-decoration: none; color: purple;}
	a:visited {text-decoration: none}
	a:active {text-decoration: none}
	a:hover {text-decoration: none; color: red;}

      -->
   </style>

</head>
<body bgcolor="#D4D4D4">
<p>Displaying the <a href="http://www.true.mistral.co.uk/azul">Villa Azul</a> Pachube <a href="http://www.pachube.com/feeds/24922">sensor data.</a></p>

<h1>Solar Dashboard</h1>

<iframe scrolling="no" frameborder="0" src="temperature.php?gauge=Solar%20Panel&amp;temp=<? echo $solar_panel; ?>&amp;low=<? echo $min_temp; ?>&amp;high=<? echo $max_temp; ?>" width="128" height="146" >If you can see this, your browser can't view an IFRAME.
</iframe> 

<iframe scrolling="no" frameborder="0" src="temperature.php?gauge=Top%20of%20Tank&amp;temp=<? echo $top_of_tank; ?>&amp;low=<? echo $min_temp; ?>&amp;high=<? echo $max_temp; ?>" width="128" height="146" >If you can see this, your browser can't view an IFRAME.
</iframe> 


<iframe scrolling="no" frameborder="0" src="temperature.php?gauge=Bottom%20of%20Tank&amp;temp=<? echo $bottom_of_tank; ?>&amp;low=<? echo $min_temp; ?>&amp;high=<? echo $max_temp; ?>" width="128" height="146" >If you can see this, your browser can't view an IFRAME.
</iframe> 

<iframe scrolling="no" frameborder="0" src="temperature.php?gauge=Jacuzzzi%20Pump&amp;temp=<? echo $jacuzzi_pump; ?>&amp;low=<? echo $min_temp; ?>&amp;high=<? echo $max_temp; ?>" width="128" height="146" >If you can see this, your browser can't view an IFRAME.
</iframe> 
<br />


<!-- Historical graphs -->
<iframe scrolling="no" frameborder="0" src="graph.php?type=temperature&amp;gauge=Solar%20Panel&amp;datastream=0&amp;low=<? echo $min_temp; ?>&amp;high=<? echo $max_temp; ?>" width="256" height="146" >If you can see this, your browser can't view an IFRAME.
</iframe>

<iframe scrolling="no" frameborder="0" src="graph.php?type=temperature&amp;gauge=Top%20of%20Tank&amp;datastream=1&amp;low=<? echo $min_temp; ?>&amp;high=<? echo $max_temp; ?>" width="256" height="146" >If you can see this, your browser can't view an IFRAME.
</iframe><br />

<iframe scrolling="no" frameborder="0" src="graph.php?type=temperature&amp;gauge=Bottom%20of%20Tank&amp;datastream=2&amp;low=<? echo $min_temp; ?>&amp;high=<? echo $max_temp; ?>" width="256" height="146" >If you can see this, your browser can't view an IFRAME.
</iframe>

<iframe scrolling="no" frameborder="0" src="graph.php?type=temperature&amp;gauge=Jacuzzi%20Pump&amp;datastream=3&amp;low=<? echo $min_temp; ?>&amp;high=<? echo $max_temp; ?>" width="256" height="146" >If you can see this, your browser can't view an IFRAME.
</iframe>


<h1>Power Dashboard</h1>
<iframe scrolling="no" frameborder="0" src="watts.php?gauge=Villa%20Power&amp;watts=<? echo $watts; ?>&amp;old_watts=<? echo $old_watts; ?>&amp;low=0&amp;high=<? echo $max_watts; ?>" width="128" height="146" >If you can see this, your browser can't view an IFRAME.
</iframe>

<iframe scrolling="no" frameborder="0" src="watts_change.php?gauge=2%20Min%20Change&amp;watts=<? echo $watts; ?>&amp;old_watts=<? echo $old_watts; ?>" width="128" height="146" >If you can see this, your browser can't view an IFRAME.
</iframe> 

<!-- Historical graphs -->
<iframe scrolling="no" frameborder="0" src="graph.php?type=watts&amp;gauge=Power%20Usage&amp;datastream=4&amp;low=0&amp;high=<? echo $max_watts; ?>" width="256" height="146" >If you can see this, your browser can't view an IFRAME.
</iframe> 



<p>
<!-- Reloads: <? echo $reload_counter; ?> -->
<? 
// Print the old watts value
//echo "old watts: ", $old_watts, "<br>\n";
?>
Dashboard created by <a href="mailto:andrewhazelden@gmail.com">Andrew Hazelden</a>. You can <a href="http://www.andrewhazelden.com/blog/2011/07/monitoring-a-solar-hot-water-system-over-the-internet/">read more about the project's development here.</a>
</p>


</body>
</html>