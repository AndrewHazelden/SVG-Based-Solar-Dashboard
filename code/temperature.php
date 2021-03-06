<? //Created by Andrew Hazelden andrewhazelden@gmail.com ?>
<?

header('Content-type: image/svg+xml');
echo '<?xml version="1.0" standalone="no"?>';

?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN"
"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<?

$width = 128;
$height = 146;

$margin = 10;
$textspace = 80;

//gauge text label
$gauge_name = $_GET["gauge"] ? $_GET["gauge"] : "";

// Temperature range in degrees C.
$min_temp = $_GET["low"] ? $_GET["low"] : 0.0;

$max_temp = $_GET["high"] ? $_GET["high"] : 100;

//temperature.php?gauge=Top of Tank&temp=100.0&low=0&high=100


//gauge ranges in screen pixels
$y_low_value = 88.5;
$y_high_value = 58.5;

$height_low_value = 20;
$height_high_value = 80;


//read in temperature value
$temp = $_GET["temp"] ? $_GET["temp"] : 0;


//limit graphics drawing boundarys

if($temp > $max_temp){
$temp =  $max_temp;
}

if($temp < $min_temp){
$temp =  $min_temp;
}




$temperature_percent= ($temp - $min_temp) / ($max_temp-$min_temp);


$gauge_height = ($height_high_value-$height_low_value) * $temperature_percent; 
//60 * 1.0
echo "<!-- Gauge Height: $gauge_height\n -->";

$gauge_y = $y_high_value-$gauge_height+$height_low_value;  
//30 * 1.0
echo "<!-- Gauge Y: $gauge_y\n -->";


?>


<svg width="<? echo $width; ?>" height="<? echo $height; ?>" version="1.1"
xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">

<g id="background_1_">
	<rect id="webpage_x5F_color_x5F_bg" fill="#D4D4D4" width="128" height="146"/>
	<g id="frame">
		
			<linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="241.959" y1="-122.75" x2="241.959" y2="-249.2505" gradientTransform="matrix(1 0 0 -1 -178 -121)">
			<stop  offset="0" style="stop-color:#C1C1C0"/>
			<stop  offset="0.2745" style="stop-color:#B9B9B9"/>
			<stop  offset="0.5686" style="stop-color:#A9A8A8"/>
			<stop  offset="0.8039" style="stop-color:#888888"/>
			<stop  offset="1" style="stop-color:#808080"/>
		</linearGradient>
		<path fill="url(#SVGID_1_)" stroke="#808080" stroke-width="3" stroke-miterlimit="10" d="M125.155,128.25H2.762V7.812
			c0-3.334,2.708-6.062,6.02-6.062h110.355c3.31,0,6.02,2.728,6.02,6.062L125.155,128.25L125.155,128.25z"/>
	</g>
	<g id="name_x5F_plack_1_">
		<path fill="#808080" d="M1.167,125.25H126.75v13.875c0,3.3-2.649,6-5.887,6H7.054c-3.237,0-5.887-2.7-5.887-6V125.25z"/>
	</g>

</g>


<g id="Dials">
	<path fill="#518BFF" stroke="#000000" stroke-miterlimit="10" d="M72,83.428V17.25C72,12.693,67.971,9,63,9
		c-4.971,0-9,3.693-9,8.25v66.178c-5.375,3.113-9,8.913-9,15.572c0,9.941,8.059,18,18,18c9.941,0,18-8.059,18-18
		C81,92.341,77.375,86.541,72,83.428z"/>
	
		<line fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" x1="49.5" y1="18" x2="36.5" y2="18"/>
	<line fill="none" stroke="#000000" stroke-linecap="round" stroke-miterlimit="10" x1="49.5" y1="33" x2="40.75" y2="33"/>
	<line fill="none" stroke="#000000" stroke-linecap="round" stroke-miterlimit="10" x1="49.5" y1="25.5" x2="40.75" y2="25.5"/>
	<line fill="none" stroke="#000000" stroke-linecap="round" stroke-miterlimit="10" x1="49.5" y1="40.5" x2="40.75" y2="40.5"/>
	
		<line fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" x1="49.5" y1="48" x2="36.5" y2="48"/>
	<line fill="none" stroke="#000000" stroke-linecap="round" stroke-miterlimit="10" x1="49.5" y1="63" x2="40.75" y2="63"/>
	<line fill="none" stroke="#000000" stroke-linecap="round" stroke-miterlimit="10" x1="49.5" y1="55.5" x2="40.75" y2="55.5"/>
	<line fill="none" stroke="#000000" stroke-linecap="round" stroke-miterlimit="10" x1="49.5" y1="70.5" x2="40.75" y2="70.5"/>
	
		<line fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" x1="49.5" y1="78" x2="36.5" y2="78"/>
</g>

<g id="Temperature">

	<rect id="temp_x4F_gauge" x="56.25" y="78" fill="#FF0000" width="13.5" height="21"/>
	<rect id="temp_x5F_gauge" x="56.25" y="<? echo $gauge_y ?>" fill="#FF0000" width="13.5" height="<? echo $gauge_height ?>"/>
	<circle id="bulb" fill="#FF0000" cx="63" cy="99" r="13.5"/>	
	
	<text transform="matrix(1 0 0 1 33 82.25)" font-family="Verdana" font-size="8" text-anchor="end"><? echo $min_temp; ?>&#176;C</text>
	<text transform="matrix(1 0 0 1 33 51.75)" font-family="Verdana" font-size="8" text-anchor="end"><? echo floor(($max_temp+$min_temp)/2); ?>&#176;C</text>
	<text transform="matrix(1 0 0 1 33 20.75)" font-family="Verdana" font-size="8" text-anchor="end"><? echo $max_temp; ?>&#176;C</text>
	
	<text transform="matrix(1 0 0 1 64 141.25)" font-family="Verdana" font-size="12" text-anchor="middle"><? echo $gauge_name; ?></text>
	
	
<path id="highlight_2_" opacity="0.45" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
	M68.75,17.252v70.764c0,0,1.327,0.363,3.139,2.16c2.393,2.605,3.611,5.539,3.611,8.637c0,4.469-1.906,7.172-3.453,8.859
	c-2.69,2.935-6.422,3.6-6.422,3.6"/>
	
</g>

<g id="Status">
	<g id="status_x5F_text_x5F_bg">
		<path fill="#A6A6A6" d="M80,8.625c0-1.65,1.35-3,3-3h34c1.65,0,3,1.35,3,3V22.5c0,1.65-1.35,3-3,3H83c-1.65,0-3-1.35-3-3V8.625z"
			/>
	</g>
<text id="status_x5F_text" transform="matrix(1 0 0 1 100 20.3125)" font-family="'Verdana'" font-size="10" text-anchor="middle"><? echo $temp; ?>&#176;C</text>
</g>
 
</svg>