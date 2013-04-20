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

// watts range in kilowatts.
$min_watts = $_GET["low"] ? $_GET["low"] : 0.0;

$max_watts = $_GET["high"] ? $_GET["high"] : 24000;




//gauge ranges in screen pixels without needle rotation active
$x_low_value = 14.126;
$x_high_value = 115.565;

//screen ranges with needle rotation active

$x_low_value = 25.126;
$x_high_value = 100.565;


//gauge ranges in screen pixels
$rot_low_value = -13.0;
$rot_high_value = 13.0;

//read in watts value
$watts = $_GET["watts"] ? $_GET["watts"] : 0;


//check if old_watts has a value
if (isset ($_GET['old_watts']))
{
$old_watts = $_GET["old_watts"];
}
else{
$old_watts = $watts;
}

echo "<!-- Watts: ", $watts," -->\n";

echo "<!-- Old Watts: ", $old_watts," -->\n";

//limit graphics drawing boundarys

//set current watts value limits
if($watts > $max_watts){
$watts =  $max_watts;
}

if($watts < $min_watts){
$watts =  $min_watts;
}

//set old_watts value limits
if($old_watts > $max_watts){
$old_watts =  $max_watts;
}

if($old_watts < $min_watts){
$old_watts =  $min_watts;
}


//mid watts value
$mid_watts = ($min_watts+$max_watts)/2;


//calculate watt percentage
$watts_percent= ($watts - $min_watts) / ($max_watts-$min_watts);
echo "<!-- Watt Percentage: ", $watts_percent*100, "% -->\n";

//calculate watt percentage
$old_watts_percent= ($old_watts - $min_watts) / ($max_watts-$min_watts);
echo "<!-- Old Watts Percentage: ", $old_watts_percent*100, "% -->\n";



//calculate x-axis needle postion
$gauge_x = $x_low_value + ( ($x_high_value-$x_low_value) * $watts_percent );  
//30 * 1.0
echo "<!-- Gauge x: $gauge_x -->\n";


//calculate x-axis needle postion
$old_gauge_x = $x_low_value + ( ($x_high_value-$x_low_value) * $old_watts_percent );  
echo "<!-- Old Gauge x: $old_gauge_x -->\n";


//calculate gauge needle rotation value
$gauge_rotate = $rot_low_value + ( ($rot_high_value-$rot_low_value) * $watts_percent );  
echo "<!-- Gauge Needle Rotate: $gauge_rotate -->\n";


//calculate gauge needle rotation value
$old_gauge_rotate = $rot_low_value + ( ($rot_high_value-$rot_low_value) * $old_watts_percent );  
echo "<!-- Old Gauge Needle Rotate: $old_gauge_rotate -->\n";

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

	<g id="Power_Dial_1_">
		<path id="blue_2_" fill="none" stroke="#0055FF" stroke-width="4" stroke-miterlimit="10" d="M9.375,70
			c16.375-3.875,38.083-7.333,55.458-7.333"/>
		<path id="green" fill="none" stroke="#43FF00" stroke-width="4" stroke-miterlimit="10" d="M64.833,62.667
			c7.871,0,17.858,0.479,25.542,1.208"/>
		<path id="red" fill="none" stroke="#FF0000" stroke-width="4" stroke-miterlimit="10" d="M90.375,63.875
			c9.271,0.881,17.312,2.359,26.25,4.25"/>
		
			<line id="line_x5F_0" fill="none" stroke="#0055FF" stroke-width="4" stroke-miterlimit="10" x1="11.163" y1="69.04" x2="8.487" y2="56.013"/>
		
			<line id="line_x5F_1" fill="none" stroke="#0055FF" stroke-width="3" stroke-miterlimit="10" x1="24.149" y1="65.782" x2="22.49" y2="56.925"/>
		
			<line id="line_x5F_2" fill="none" stroke="#0055FF" stroke-width="4" stroke-miterlimit="10" x1="36.965" y1="64.158" x2="35.5" y2="51"/>
		
			<line id="line_x5F_3" fill="none" stroke="#0055FF" stroke-width="3" stroke-miterlimit="10" x1="49.965" y1="63.416" x2="49.458" y2="54.583"/>
		
			<line id="line_x5F_4" fill="none" stroke="#0055FF" stroke-width="4" stroke-miterlimit="10" x1="62.794" y1="62.977" x2="62.794" y2="49.678"/>
		
			<line id="line_x5F_5" fill="none" stroke="#43FF00" stroke-width="4" stroke-miterlimit="10" x1="75.825" y1="62.732" x2="76.333" y2="53.75"/>
		
			<line id="line_x5F_6" fill="none" stroke="#43FF00" stroke-width="4" stroke-miterlimit="10" x1="88.5" y1="63.583" x2="90" y2="50.333"/>
		
			<line id="line_x5F_7" fill="none" stroke="#FF0000" stroke-width="4" stroke-miterlimit="10" x1="101.689" y1="65.262" x2="103.125" y2="56.344"/>
		
			<line id="line_x5F_8" fill="none" stroke="#FF0000" stroke-width="4" stroke-miterlimit="10" x1="114.646" y1="67.558" x2="117.416" y2="54.521"/>
	</g>
	
		<text id="label_x5F_text" transform="matrix(1 0 0 1 25 94.5986)" fill="#2B2B2B" font-family="'Verdana'"  font-size="18">KiloWatts</text>

	<g id="needle_x5F_group">
		<g transform="rotate(<? echo $gauge_rotate; ?> 65.45 124.209)">
			<animateTransform attributeName="transform" id="animate_rotation" type="rotate" from="<? echo $old_gauge_rotate; ?>  65.45 124.209" to="<? echo $gauge_rotate; ?>  65.45 124.209" dur="8s"/>
			
			<line id="needle_1_" fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10" x1="<? echo $gauge_x; ?>" x2="<? echo $gauge_x; ?>" y1="50.267" y2="134.75">
			
			<animate id="animate_translate_x1" attributeName="x1" from="<? echo $old_gauge_x; ?>" to="<? echo $gauge_x; ?>" dur="8s"/>
			<animate id="animate_translate_x2" attributeName="x2" from="<? echo $old_gauge_x; ?>" to="<? echo $gauge_x; ?>" dur="8s"/>
			</line>
		</g>
	</g>
	
	<g id="name_x5F_plack_1_">
		<path fill="#808080" d="M1.167,125.25H126.75v13.875c0,3.3-2.649,6-5.887,6H7.054c-3.237,0-5.887-2.7-5.887-6V125.25z"/>
	</g>

</g>

<g id="watts_Dial">
</g>

<g id="Watts_1_">
	<text transform="matrix(1 0 0 1 9 52.1221)" font-family="'Verdana'" font-size="8" text-anchor="middle"><? echo floor($min_watts * .001); ?></text>
	<text id="_x31_0_1_" transform="matrix(1 0 0 1 62 47.5918)" font-family="'Verdana'" font-size="8" text-anchor="middle"><? echo floor($mid_watts * .001) ; ?></text>
	<text transform="matrix(1 0 0 1 118 50.8311)" font-family="'Verdana'" font-size="8" text-anchor="middle"><? echo floor($max_watts * .001); ?></text>
	
	<text transform="matrix(1 0 0 1 64 141.25)" font-family="Verdana" font-size="12" text-anchor="middle"><? echo $gauge_name; ?></text>
</g>

<g id="Status">
	<g id="status_x5F_text_x5F_bg">
		<path fill="#A6A6A6" d="M80,8.625c0-1.65,1.35-3,3-3h34c1.65,0,3,1.35,3,3V22.5c0,1.65-1.35,3-3,3H83c-1.65,0-3-1.35-3-3V8.625z"
			/>
	</g>
<text id="status_x5F_text" transform="matrix(1 0 0 1 100 20.3125)" font-family="'Verdana'"  font-size="10" text-anchor="middle"><? echo (floor($watts * .01))*0.1; ?> KW</text>
</g>
 
</svg>