<?     
header('Content-type: image/svg+xml');

$width = 256;
$height = 146;

function calculate_median($arr) {
    sort($arr);
    $count = count($arr); //total numbers in array
    $middleval = floor(($count-1)/2); // find the middle value, or the lowest middle value
    if($count % 2) { // odd number, middle is the median
        $median = $arr[$middleval];
    } else { // even number, calculate avg of 2 medians
        $low = $arr[$middleval];
        $high = $arr[$middleval+1];
        $median = (($low+$high)/2);
    }
    return $median;
}



//------------------------------------
// Retreive interval and duration cookies
//------------------------------------


//get the maximum value range 
$max_value= $_GET["high"] ? $_GET["high"] : 8000;

//get the minimum value
$min_value = $_GET["low"] ? $_GET["low"] : 0.0;

//type of data to graph
$gauge_type = $_GET["type"];

//if (   ($gauge_type != "temperature") || ($gauge_type != "watts") ){
//$gauge_type = watts;
//}

//get the gauge name
$gauge_name = $_GET["gauge"] ? $_GET["gauge"] : "Power";


if (isset($_GET['duration'])){
setcookie ('duration', $_GET['duration']);
$duration = $_GET['duration'];
}
else if (isset($_COOKIE['duration'])) {
$duration=$_COOKIE['duration'];
} else {
setcookie ('duration', "24hours");
$duration = "24hours";
//setcookie ('duration', "31days");
//$duration = "31days";
}



//play a click sound effect when changing graphing view modes 
if (isset($_GET['play_sound'])){
$play_sound = $_GET['play_sound'];
}
else{
$play_sound = 0;
}


echo '<?xml version="1.0" standalone="no"?>', "\n";

echo "<!-- \n";
//------------------------------------
// Setting up graph legends
//------------------------------------

//ideal number of samples is around 84 data points
$pachube_preset_intervals = array(0, 30, 60, 300, 900, 3600, 10800, 21600, 43200, 86400 );

$pachube_preset_upper_timescale = array(21600, 43200, 86400, 432000, 1209600, 2678400, 7776000, 15552000, 31622400, 31622400 );



//how many pachube preset intervals exist
$num_of_pachube_intervals = count($pachube_preset_intervals);
echo "num_of_pachube_intervals: $num_of_pachube_intervals\n";


//the maximum number of real data points
$max_real_data_interval = 120;


//graph label text
if($duration == "1hours"){
//1 hour duration
$combined_gauge_name = "1 Hour $gauge_name";

//number of seconds in graphing period
$graph_timescale = 3600;

}
else if($duration == "2days"){
//48 hour duration
$combined_gauge_name = "48 Hour $gauge_name";

//number of seconds in graphing period
$graph_timescale = 172800;

}
else if($duration == "7days"){
// 1 week duration
$combined_gauge_name = "1 Week $gauge_name";

//number of seconds in graphing period
$graph_timescale = 604800;
}
else if($duration == "31days"){
//31 day duration
$combined_gauge_name = "1 Month $gauge_name";

//number of seconds in graphing period
$graph_timescale = 2678400;
}
else if($duration == "90days"){  

//3 month duration
$combined_gauge_name = "3 Month $gauge_name";

//number of seconds in graphing period
$graph_timescale = 7776000;
}
else {
//else if ($duration == "24hours"){
//24 hour duration
$combined_gauge_name = "24 Hour $gauge_name";

//number of seconds in graphing period
$graph_timescale = 86400;

}

//------------------------------------
// Computing optimal pachube interval
//------------------------------------

echo "graph_timescale: $graph_timescale\n";

//how many points we want on the graph
//$desired_number_of_graph_points = 96;
$desired_number_of_graph_points = 96;
echo "desired_number_of_graph_points: $desired_number_of_graph_points\n";

//desired_interval number we will be the target interval used to resample the pachube data
$desired_interval = $graph_timescale / $desired_number_of_graph_points;
echo "desired_interval: $desired_interval seconds\n";

//get 2x interval resolution if available 
$two_times_desired_interval = $desired_interval * 0.5;
echo "2x desired_interval: $two_times_desired_interval seconds\n";

//select pachube's nearest yet smaller interval value
$i=$num_of_pachube_intervals-1;

//which pachube preset index number was selected
$selected_pachube_interval_index = 0;

//scan array until we reach index 0
while ( $i >= 0 ) {


//select nearest pachube_preset_interval
if($pachube_preset_intervals[$i] < $two_times_desired_interval){
	$selected_pachube_interval = $pachube_preset_intervals[$i];
	
	$selected_pachube_interval_index = $i;
	
	//break when we have the correct value
	break;
}

$i--;

} //end for loop


echo "selected_pachube_interval_index: $selected_pachube_interval_index\n";
echo "selected_pachube_interval: $selected_pachube_interval seconds\n";

$pachube_query_limit = $pachube_preset_upper_timescale[$selected_pachube_interval_index];

echo "\n\n";

//check for pachube
if( $graph_timescale > $pachube_preset_upper_timescale[$selected_pachube_interval_index]){
echo "We have exceded the query limit for this pachube interval value.\n";
echo "We requested: $graph_timescale but the limit is: $pachube_query_limit\n";
}
else{
echo "We are within the pachube the query limit for the interval value.\n";
echo "We requested a timescale of: $graph_timescale and the limit is: $pachube_query_limit\n";
}


$interval = $selected_pachube_interval;

//how many data points there should be if no data is missing. 
if($selected_pachube_interval == 0){
$expected_data_records = $graph_timescale / $max_real_data_interval;
}
else{
$expected_data_records = $graph_timescale /  $selected_pachube_interval;
}

//defines plotting step interval factor
$interval_scaling_factor = 1.0 / ($desired_number_of_graph_points / $expected_data_records);

//1 hour plotting limit
//don't go below 1 step resolution per graph point
if($interval_scaling_factor < 1){
$interval_scaling_factor = 1;
}

echo "\n\n";
echo "interval_scaling_factor: $interval_scaling_factor\n";
echo "expected_data_records: $expected_data_records\n";

echo "-->\n";


//------------------------------------
echo "<!-- \n";

echo "Gauge Type: $gauge_type\n";
echo "Gauge Name: $gauge_name\n";
echo "Combined Gauge Name: $combined_gauge_name\n";
echo "Gauge high: $max_value\n";
echo "Gauge min: $min_value\n";
echo "\n";

echo "Stored Cookie -> Duration: ", $_COOKIE["duration"], "\n";
echo "--> \n";



//plot window height
$graph_plot_area_height = 116;
 
//plot window width
$graph_plot_area_width = 221;


//offset starting y-axis plot position
$starting_y_offset = 4;

//offset starting x-axis plot position
$x_border_frame_offset = 5;





//------------------------------------
//
// Access Pachube Historic Data
//
//------------------------------------


//get watts datastream (#4) from pachube
$pachube_data_stream= $_GET["datastream"];
//$pachube_data_stream = 4;



//------------------------------------
// Retreive pachube login data
//------------------------------------


//Type your Pachube username here:
$pachube_username = "";

//Type your Pachube password here:
$pachube_password = "";




$request = "http://$pachube_username:$pachube_password@api.pachube.com/v2/feeds/24922/datastreams/$pachube_data_stream.csv?duration=$duration&per_page=1000&interval=$interval";

// Debugging info for pachube request URL
// **** Disable this or your pachube user data will be visible in the SVG file! ****
//echo "<!-- $request -->\n";

//catch fopen errors in comment wrapper
echo "<!-- Loading data stream: ";

$inc = 0;

if (($handle = fopen($request, "r")) !== FALSE) {
    while (   (($data = fgetcsv($handle, 2000, ",")) !== FALSE)  ) {
    
    $the_date[$inc] = $data[0];
	$sample_value[$inc] = $data[1];

    $inc++;
     }
    fclose($handle);
}



//number of data records
$data_records = $inc;

//end catch fopen errors in comment wrapper
echo "\n\nLoaded: ", $data_records, " of ", $expected_data_records, " expected data samples.\n";

echo "-->\n";


//check for divide by zero
if(  ($data_records-1) && ($graph_plot_area_width) && ($expected_data_records) ){

	//check if 1 month or 3 month graphing perdiods are present. 
	//If doing a long term graph check for missing samples and scale graph shorter 
	//if( ($duration == "90days") || ($duration == "31days")){
	//scale the view based upon how many real records should exist for a longer time period
	// eg. 3 month   x axis scale value = 1.3687 = 245 / (180) should be 29
	
	$x_axis_scale = ($graph_plot_area_width) / ($expected_data_records-1);
	//}
	//else{
	//Assume all samples are present for a short time period
	//$x_axis_scale = ($graph_plot_area_width) / ($data_records-1);
	//}

}

echo "<!-- Duration value: $duration -->\n";
echo "<!-- x-axis scale value: $x_axis_scale -->\n";


echo "<!-- read in $inc lines of data. -->\n";

//uncomment the next 3 lines to see the debugging info for each data record
for($i = 0;$i<$inc; $i++){
//echo "<!-- ", $i, "\t",$the_date[$i],"\t", $sample_value[$i], " -->\n";
}


//echo "<!-- \n the_date array:\n";
//print_r($the_date);
//echo "--> \n";

//echo "<!-- \n sample_value array:\n";
//print_r($sample_value);
//echo "--> \n";

?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN"
"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd"> 
<svg width="<? echo $width; ?>" height="<? echo $height; ?>" version="1.1" baseProfile="tiny"
xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" onload="init()">

<?

//play a click sound effect when changing graphing view modes 
if ($play_sound == 1){
 echo "<audio xlink:href=\"click.ogg\" audio-level=\"0.7\" type=\"application/ogg\"
        begin=\"0s\" repeatCount=\"0\"/>\n";

}

?>

<script xlink:href="date.js" type="text/javascript" />
<script xlink:href="timeOffset.js" type="text/javascript" />
<script xlink:href="valueRange.js" type="text/javascript" />

<script type="text/javascript">
<![CDATA[	
var text, textnode

function init()
{
	
	var printLine = "";
	<? 
	
	if ($duration == "7days"){
	echo "var timePeriod =  \"days\";\n";
	echo "\tvar label_interval =  7;\n";
	}
	else if ($duration == "31days"){
	echo "var timePeriod =  \"days\";\n";
	echo "\tvar label_interval = 31;\n";
	}
	else if ($duration == "90days"){
	echo "var timePeriod =  \"months\";\n";
	echo "\tvar label_interval =  3;\n";
	}
	else if ($duration == "1hours"){
	echo "var timePeriod =  \"mins\";\n";
	echo "\tvar label_interval =  60;\n";
	}
	else if ($duration == "2days") {
	echo "var timePeriod =  \"hours\";\n";
	echo "\tvar label_interval =  48;\n";
	}
	else {
	//else if ($duration == "24hours"){
	echo "var timePeriod =  \"hours\";\n";
	echo "\tvar label_interval =  24;\n";
	}
	
	
	
	?> 
	
	
	
	
	//array of label element id's
	var labelArray=new Array(4);
	labelArray[0]="label1";
	labelArray[1]="label2";
	labelArray[2]="label3";
	labelArray[3]="label4";
	
	
	if (timePeriod == "months"){
	//scan through text element id's
		var j=0;
		for (j=0;j<=3;j++){
		current_element_id = labelArray[j];
		textnode = document.getElementById(current_element_id);
		printLine =  monthOffset(label_interval, j);
		textnode.textContent = printLine + "\n"
		} //end for loop
	}
	else if (timePeriod == "days"){
	//scan through text element id's
		var j=0;
		for (j=0;j<=3;j++){
		current_element_id = labelArray[j];
		textnode = document.getElementById(current_element_id);
		printLine =  dayOffset(label_interval, j);
		textnode.textContent = printLine + "\n"
		} //end for loop
	}
	else if (timePeriod == "mins"){
	//scan through text element id's
		var j=0;
		for (j=0;j<=3;j++){
		current_element_id = labelArray[j];
		textnode = document.getElementById(current_element_id);
		printLine =  minOffset(label_interval, j);
		textnode.textContent = printLine + "\n"
		} //end for loop
	}
	else if (timePeriod == "hours"){
	//scan through text element id's
		var j=0;
		for (j=0;j<=3;j++){
		current_element_id = labelArray[j];
		textnode = document.getElementById(current_element_id);
		printLine =  hourOffset(label_interval, j);
		textnode.textContent = printLine + "\n"
		} //end for loop
	}




	//array of range element id's
	var rangeArray=new Array(5);
	rangeArray[0]="range1";
	rangeArray[1]="range2";
	rangeArray[2]="range3";
	rangeArray[3]="range4";
	rangeArray[4]="range5";

	//scan through text element id's
		var j=0;
		for (j=0;j<=4;j++){
		current_element_id = rangeArray[j];
		textnode = document.getElementById(current_element_id);
		printLine =  valueRange("<? echo $gauge_type; ?>", <? echo $max_value; ?>, <? echo $min_value ?>, j );
		textnode.textContent = printLine + "\n"
		} //end for loop


} //end init function

]]>
</script>

<g id="background">
	<rect id="webpage_x5F_color_x5F_bg" fill="#D4D4D4" width="256" height="146"/>
	<g id="frame_1_">
		
			<linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="484.085" y1="646.75" x2="484.085" y2="773.25" gradientTransform="matrix(1 0 0 1 -356 -645)">
			<stop  offset="0" style="stop-color:#C1C1C0"/>
			<stop  offset="0.2745" style="stop-color:#B9B9B9"/>
			<stop  offset="0.5686" style="stop-color:#A9A8A8"/>
			<stop  offset="0.8039" style="stop-color:#888888"/>
			<stop  offset="1" style="stop-color:#808080"/>
		</linearGradient>
		<path fill="url(#SVGID_1_)" stroke="#808080" stroke-width="3" stroke-miterlimit="10" d="M253.404,128.25H2.762V7.812
			c0-3.334,2.708-6.062,6.02-6.062h238.604c3.311,0,6.021,2.728,6.021,6.062L253.404,128.25L253.404,128.25z"/>
	</g>
	<g id="name_x5F_plack_1_">
		<path fill="#808080" d="M1.167,125.25H255v13.875c0,3.3-2.648,6-5.887,6H7.054c-3.237,0-5.887-2.7-5.887-6V125.25L1.167,125.25z"
			/>
			
			
		<text transform="matrix(1 0 0 1 124 141.25)" font-family="Verdana" font-size="10" text-anchor="middle"><? echo $combined_gauge_name; ?></text>

	</g>
</g>
<g id="grid">
	<g id="Markings">
		<g id="horizontal_x5F_line_3_">
			
				<line fill="none" stroke="#353535" stroke-miterlimit="10" stroke-dasharray="2.9839,2.9839" x1="4.264" y1="88.417" x2="226.877" y2="88.417"/>
		</g>
		<g id="horizontal_x5F_line_2_">
			
				<line fill="none" stroke="#353535" stroke-miterlimit="10" stroke-dasharray="2.9839,2.9839" x1="4.264" y1="60.001" x2="226.877" y2="60.001"/>
		</g>
		<g id="horizontal_x5F_line_1_">
			
				<line fill="none" stroke="#353535" stroke-miterlimit="10" stroke-dasharray="2.9839,2.9839" x1="4.264" y1="31.584" x2="226.877" y2="31.584"/>
		</g>
		<g id="center_x5F_line_6_">
			
				<line fill="none" stroke="#353535" stroke-miterlimit="10" stroke-dasharray="3.0513,3.0513" x1="78.778" y1="3.217" x2="78.778" y2="116.646"/>
		</g>
		<g id="main_x5F_center_x5F_line">
			
				<line fill="none" stroke="#353535" stroke-linejoin="bevel" stroke-dasharray="3.0513,3.0513" x1="152.89" y1="3.878" x2="152.89" y2="117.308"/>
		</g>
	</g>
	<path id="graph_x5F_frame" fill="none" stroke="#353535" stroke-miterlimit="10" d="M226.667,3v113.333l-222,0.625
		c0,0-0.229-108.208-0.229-109.062c0.083-1.5,0.729-2.667,1.688-3.521C7.583,3.25,9.25,3,10.375,3S226.667,3,226.667,3z"/>
</g>
<g id="vertical_text">

	<text id="range5" transform="matrix(1 0 0 1 228.333 10.416)" fill="#353535" font-family="'Verdana'" font-size="8"></text>
	
	<text id="range4" transform="matrix(1 0 0 1 228.333 34.166)" fill="#353535" font-family="'Verdana'" font-size="8"></text>

	<text id="range3" transform="matrix(1 0 0 1 228.333 62.749)" fill="#353535" font-family="'Verdana'" font-size="8"></text>
	
	<text id="range2" transform="matrix(1 0 0 1 229 90.5)" fill="#353535" font-family="'Verdana'" font-size="8"></text>

	<text id="range1" transform="matrix(1 0 0 1 228.499 116.582)" fill="#353535" font-family="'Verdana'" font-size="8"></text>
	
	
</g>
<g id="horizontal_text">
	<text id="label1" text-anchor="end" transform="matrix(1 0 0 1 227 125.084)" fill="#353535" font-family="'Verdana'" font-size="8"></text>
	<text id="label2" transform="matrix(1 0 0 1 139.334 125.0859)" fill="#353535" font-family="'Verdana'" font-size="8"></text>
	<text id="label3" transform="matrix(1 0 0 1 64.6665 125.084)" fill="#353535" font-family="'Verdana'" font-size="8"></text>
	<text id="label4" transform="matrix(1 0 0 1 4 125.084)" fill="#353535" font-family="'Verdana'" font-size="8"></text>
</g>

<g id="graph">

	<polyline fill="none" stroke="#0055FF" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="<?
	
	
	/// step value to resample points
	$step_value = $interval_scaling_factor;
	$index_offset = 0;
	//plot a new data point
	for ($i=0;$i<$data_records-1;$i=floor($i+$step_value)){
		
		//---------------------------------------------
		// y-axis position testing code
		//---------------------------------------------
		//$current_value = 4000;
		//---------------------------------------------
		
		
		
		
		//---------------------------------------------
		// data point value averaging
		//---------------------------------------------
		
		//Note: use floor(0) to convert array index scanning variables to integer values
		
		
		//clear median array
		$sample_median_array = array();
		
		
		//average if the step value is two or higher
		if($step_value >=2){
			$sample_average_bin = 0;
			for($avg_inc=0;$avg_inc<=floor($step_value-1) && ($index_offset<$data_records-1);$avg_inc++){
			$index_offset = floor($i+$avg_inc);
			
			//add values to array
			$sample_median_array[$avg_inc] = $sample_value[$index_offset];

			//debug array incrementers
			//echo "i=$i, step_value=$step_value, index_offset=$index_offset\n";
			}
			
			
			$current_value = calculate_median($sample_median_array);
			
			//debug printing array values
			//print_r($sample_median_array);
		}
		else{
			//no data averaging
			$current_value = $sample_value[floor($i)] ;
		}
		
		
		
		
		
		
		//limit the lowest plotted value to stop at the bottom of the graph
		//based upon the low threshold of $min_value
		if ($current_value < $min_value){
		$current_value = $min_value;
		}
		
		//limit the highest plotted value to stop at the top of the graph
		//based upon the high threshold of $max_value
		if ($current_value > $max_value){
		$current_value = $max_value;
		}
		
		
		$plot_percent= ($current_value - $min_value) / ($max_value-$min_value);
		$plot_height = ($graph_plot_area_height-$starting_y_offset) * $plot_percent ; 
		
		
		//y-axis point location
		$y = $graph_plot_area_height-$plot_height;
	
		
		//x-axis point location
		$x = ($i*$x_axis_scale);
		
		
		//calculate how many pixels wide the real data takes to plot with the current x-axis scale
		$plotted_data_width = (($data_records-1)*$x_axis_scale);
		
		
		
		//draw chart left to right
		echo $x_border_frame_offset + $x + ($graph_plot_area_width-$plotted_data_width), ",", $y, " ";
		
		
		//print a newline every 10 points to line break x,y points list 
		if($i % 5 == 0){
			echo "\n";
		}

		
	}
	
	
	
	?>"/>
 </g>
<g id="links">
	
		<a xlink:href="graph.php?duration=1hours&amp;type=<? echo $gauge_type; ?>&amp;gauge=<? echo $gauge_name; ?>&amp;datastream=<? echo $pachube_data_stream; ?>&amp;low=<? echo $min_value; ?>&amp;high=<? echo $max_value; ?>&amp;play_sound=1" >
		<g id="_1_Hour">
			<g id="_x31_hour_box">
				
					<linearGradient id="SVGID_2_" gradientUnits="userSpaceOnUse" x1="1486.876" y1="-2200.0317" x2="1486.876" y2="-2183.6978" gradientTransform="matrix(1 0 0 -1 -1246 -2056)">
					<stop  offset="0" style="stop-color:#E0E0E0"/>
					<stop  offset="0.2745" style="stop-color:#B9B9B9"/>
					<stop  offset="0.5686" style="stop-color:#A9A8A8"/>
					<stop  offset="1" style="stop-color:#F2F2F2"/>
				</linearGradient>
				<path fill="url(#SVGID_2_)" d="M232.042,130.698c0-1.65,1.351-3,3-3h11.666c1.649,0,3,1.35,3,3v10.334c0,1.649-1.351,3-3,3
					h-11.666c-1.649,0-3-1.351-3-3V130.698z"/>
			</g>
			<text transform="matrix(1 0 0 1 234.4941 138.6035)" font-family="'Verdana'" font-size="9">1H</text>
		</g>
	</a>
	
		<a xlink:href="graph.php?duration=24hours&amp;type=<? echo $gauge_type; ?>&amp;gauge=<? echo $gauge_name; ?>&amp;datastream=<? echo $pachube_data_stream; ?>&amp;low=<? echo $min_value; ?>&amp;high=<? echo $max_value; ?>&amp;play_sound=1" >
		<g id="_24hours">
			<g id="_24hours_box">
				
					<linearGradient id="SVGID_3_" gradientUnits="userSpaceOnUse" x1="1288.5215" y1="2079.1152" x2="1288.5215" y2="2062.7812" gradientTransform="matrix(1 0 0 1 -1068 -1935)">
					<stop  offset="0" style="stop-color:#E0E0E0"/>
					<stop  offset="0.2745" style="stop-color:#B9B9B9"/>
					<stop  offset="0.5686" style="stop-color:#A9A8A8"/>
					<stop  offset="1" style="stop-color:#F2F2F2"/>
				</linearGradient>
				<path fill="url(#SVGID_3_)" d="M210.084,130.781c0-1.65,1.35-3,3-3h14.875c1.65,0,3,1.35,3,3v10.334c0,1.65-1.35,3-3,3h-14.875
					c-1.65,0-3-1.35-3-3V130.781z"/>
			</g>
			<text transform="matrix(1 0 0 1 211.3555 138.6035)" font-family="'Verdana'" font-size="9">24H</text>
		</g>
	</a>
	
		<a xlink:href="graph.php?duration=2days&amp;type=<? echo $gauge_type; ?>&amp;gauge=<? echo $gauge_name; ?>&amp;datastream=<? echo $pachube_data_stream; ?>&amp;low=<? echo $min_value; ?>&amp;high=<? echo $max_value; ?>&amp;play_sound=1" >
		<g id="_48hours_1_">
			<g id="_48hours_box">
				
					<linearGradient id="SVGID_4_" gradientUnits="userSpaceOnUse" x1="1266.5215" y1="2079.1152" x2="1266.5215" y2="2062.7812" gradientTransform="matrix(1 0 0 1 -1068 -1935)">
					<stop  offset="0" style="stop-color:#E0E0E0"/>
					<stop  offset="0.2745" style="stop-color:#B9B9B9"/>
					<stop  offset="0.5686" style="stop-color:#A9A8A8"/>
					<stop  offset="1" style="stop-color:#F2F2F2"/>
				</linearGradient>
				<path fill="url(#SVGID_4_)" d="M188.084,130.781c0-1.65,1.35-3,3-3h14.875c1.65,0,3,1.35,3,3v10.334c0,1.65-1.35,3-3,3h-14.875
					c-1.65,0-3-1.35-3-3V130.781z"/>
			</g>
			<text transform="matrix(1 0 0 1 189.3555 138.6035)" font-family="'Verdana'" font-size="9">48H</text>
		</g>
	</a>
	
		<a xlink:href="graph.php?duration=7days&amp;type=<? echo $gauge_type; ?>&amp;gauge=<? echo $gauge_name; ?>&amp;datastream=<? echo $pachube_data_stream; ?>&amp;low=<? echo $min_value; ?>&amp;high=<? echo $max_value; ?>&amp;play_sound=1" >
		<g id="_7days">
			<g id="_7days_box">
				
					<linearGradient id="SVGID_5_" gradientUnits="userSpaceOnUse" x1="1298" y1="-2199.7817" x2="1298" y2="-2183.4478" gradientTransform="matrix(1 0 0 -1 -1246 -2056)">
					<stop  offset="0" style="stop-color:#E0E0E0"/>
					<stop  offset="0.2745" style="stop-color:#B9B9B9"/>
					<stop  offset="0.5686" style="stop-color:#A9A8A8"/>
					<stop  offset="1" style="stop-color:#F2F2F2"/>
				</linearGradient>
				<path fill="url(#SVGID_5_)" d="M43.167,130.448c0-1.65,1.35-3,3-3h11.666c1.65,0,3,1.35,3,3v10.334c0,1.649-1.35,3-3,3H46.167
					c-1.65,0-3-1.351-3-3V130.448z"/>
			</g>
			<text transform="matrix(1 0 0 1 44.3467 138.6035)" font-family="'Verdana'" font-size="9">1W</text>
		</g>
	</a>
	
		<a xlink:href="graph.php?duration=31days&amp;type=<? echo $gauge_type; ?>&amp;gauge=<? echo $gauge_name; ?>&amp;datastream=<? echo $pachube_data_stream; ?>&amp;low=<? echo $min_value; ?>&amp;high=<? echo $max_value; ?>&amp;play_sound=1" >
		<g id="_31days">
			<g id="_31days_box">
				
					<linearGradient id="SVGID_6_" gradientUnits="userSpaceOnUse" x1="1278.7217" y1="-2200.1147" x2="1278.7217" y2="-2183.7808" gradientTransform="matrix(1 0 0 -1 -1246 -2056)">
					<stop  offset="0" style="stop-color:#E0E0E0"/>
					<stop  offset="0.2745" style="stop-color:#B9B9B9"/>
					<stop  offset="0.5686" style="stop-color:#A9A8A8"/>
					<stop  offset="1" style="stop-color:#F2F2F2"/>
				</linearGradient>
				<path fill="url(#SVGID_6_)" d="M23.888,130.781c0-1.65,1.351-3,3-3h11.666c1.65,0,3,1.35,3,3v10.334c0,1.65-1.35,3-3,3H26.888
					c-1.649,0-3-1.35-3-3V130.781z"/>
			</g>
			<text transform="matrix(1 0 0 1 26.0674 138.6035)" font-family="'Verdana'" font-size="9">1M</text>
		</g>
	</a>
	
		<a xlink:href="graph.php?duration=90days&amp;type=<? echo $gauge_type; ?>&amp;gauge=<? echo $gauge_name; ?>&amp;datastream=<? echo $pachube_data_stream; ?>&amp;low=<? echo $min_value; ?>&amp;high=<? echo $max_value; ?>&amp;play_sound=1" >
		<g id="_90days">
			<g id="_90days_box">
				
					<linearGradient id="SVGID_7_" gradientUnits="userSpaceOnUse" x1="1259.4424" y1="-2200.1147" x2="1259.4424" y2="-2183.7808" gradientTransform="matrix(1 0 0 -1 -1246 -2056)">
					<stop  offset="0" style="stop-color:#E0E0E0"/>
					<stop  offset="0.2745" style="stop-color:#B9B9B9"/>
					<stop  offset="0.5686" style="stop-color:#A9A8A8"/>
					<stop  offset="1" style="stop-color:#F2F2F2"/>
				</linearGradient>
				<path fill="url(#SVGID_7_)" d="M4.609,130.781c0-1.65,1.35-3,3-3h11.666c1.65,0,3,1.35,3,3v10.334c0,1.65-1.35,3-3,3H7.609
					c-1.65,0-3-1.35-3-3V130.781z"/>
			</g>
			<text transform="matrix(1 0 0 1 6.7891 138.6035)" font-family="'Verdana'" font-size="9">3M</text>
		</g>
	</a>
</g>
 
 
</svg>
