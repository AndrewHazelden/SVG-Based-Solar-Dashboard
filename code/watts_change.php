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


//read in watts value
$watts = $_GET["watts"] ? $_GET["watts"] : 0;

// previous watts level from 1 minute before hand.
$old_watts = $_GET["old_watts"] ? $_GET["old_watts"] : 0.0;

//watts_change.php?gauge=Changing%20Power%20Usage=6.5&old_watts=500

//difference in watts between two data readings
$watts_change = $watts - $old_watts;


//percentage of change between two data readings  (B-A)/A * 100
// 100% is recorded as 100 in $watts_change_percent
$watts_change_percent = round( (($watts_change / $watts) * 100.0), 2);

echo "<!-- watts used: $watts W-->\n" ; 
echo "<!-- 1 min old watts used: $old_watts W-->\n" ; 
echo "<!-- watts change: $watts_change W-->\n" ; 
echo "<!-- watts change percent: $watts_change_percent % -->\n" ; 


?>


<svg width="<? echo $width; ?>" height="<? echo $height; ?>" version="1.1"
xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">


<? 


//Gauge Color pallet:

//red
//fill="#FF0000"

//gray
//fill="#808080" 
 
//old blue
//fill="#0055FF" 

//new blue
//fill=" #518bff"


//upper change graphic triangle
$upper_large_change_color = "#808080";
$upper_large_change_color2 = "#808080";

//upper change graphic small rectangle
$upper_small_change_color = "#808080";
$upper_small_change_color2 = "#808080";

//lower change graphic triangle
$lower_large_change_color = "#808080";
$lower_large_change_color2 = "#808080";

//lower change graphic small rectangle
$lower_small_change_color = "#808080";
$lower_small_change_color2 = "#808080"; 

//main change graphic rectangle
$main_change_color = "#808080"; 
$main_change_color2 = "#808080";

// Change the color of the graphic shapes based upon the usage changes
if($watts_change >= 50){
// upwards 50 watts usage change
$main_change_color = "#518bff";
$main_change_color2 = "#4170cc"; //80% brightness of color1


	if($watts_change > 250){
		// upwards 250 watts usage change
		$upper_small_change_color = "#518bff";
		$upper_small_change_color2 = "#4170cc";//80% brightness of color1
		
		if($watts_change > 500){
			// upwards 650 watts usage change
			$upper_large_change_color = "#518bff";
			$upper_large_change_color2 = "#4170cc";//80% brightness of color1
		}	
	}
}


if($watts_change <= -50){
//downwards 50 watts useage change
$main_change_color = "#FF0000";
$main_change_color2 = "#cc0000"; //80% brightness of color1




	if($watts_change < -250){
		//downwards 250 watts useage change
		$lower_small_change_color = "#FF0000";
		$lower_small_change_color2 = "#cc0000";//80% brightness of color1
		
		if($watts_change < -500){
			//downwards 500 watts useage change
			$lower_large_change_color = "#FF0000";
			$lower_large_change_color2 = "#cc0000";//80% brightness of color1
		}	
	}	
}


?>



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
		<path id="arrow_x5F_bg" fill="#4F4F4F" stroke="#A6A6A6" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
		M68.747,25.351c-1.026-0.48-2.706-0.483-3.733-0.005L21.285,45.713c-1.027,0.478-1.868,1.796-1.868,2.93v6.583l11.565,0.023V91.25
		H19.417v7.064c0,1.134,0.84,2.455,1.867,2.935l43.603,20.403c1.025,0.479,2.703,0.479,3.729,0l43.518-20.401
		c1.025-0.481,1.865-1.803,1.865-2.937V91.25h-11.565v-36l11.565-0.023v-6.583c0-1.134-0.838-2.454-1.865-2.936L68.747,25.351z"/>
</g>
<g id="Power_Dial">
	<path id="down_x5F_triangle" fill="<? echo $lower_large_change_color; ?>" d="M108.58,95.979c-0.348,0.012-19.381-0.047-39.46-0.045
		c-21.219,0.002-43.293,0.039-43.995,0.021c-0.559,0-0.979,0.625-0.875,1.084c0.142,0.621,0.917,1,1.521,1.271
		c0.604,0.271,38.224,17.67,39.485,18.375c1.258,0.703,2.043,0.75,3.442,0.008c1.401-0.74,37.804-17.836,38.929-18.289
		c0.953-0.422,1.875-0.812,1.781-1.688C109.365,96.307,108.9,95.979,108.58,95.979z">
		
		<animate attributeType="CSS" id="down_2" attributeName="fill" values="<? echo $lower_large_change_color; ?>; <? echo $lower_large_change_color2; ?>; <? echo $lower_large_change_color; ?>" calcMode="linear" dur="5s" repeatCount='indefinite'/>
		</path>
		
		
		
	<path id="small_x5F_lower_x5F_box" fill="<? echo $lower_small_change_color; ?>" d="M35.5,84.419c0-0.438,0.329-0.799,0.731-0.799h60.947
		c0.401,0,0.73,0.358,0.73,0.799v7.531c0,0.438-0.329,0.799-0.73,0.799H36.231c-0.402,0-0.731-0.358-0.731-0.799V84.419z">
		
		<animate attributeType="CSS" id="down_1" attributeName="fill" values="<? echo $lower_small_change_color2; ?>; <? echo $lower_small_change_color; ?>; <? echo $lower_small_change_color2; ?>" calcMode="linear" dur="4s" repeatCount='indefinite'/>
		
		</path>
		
		
	<path id="main_x5F_box" fill="<? echo $main_change_color ?>" d="M35.591,67.717c0-0.44,0.329-0.8,0.731-0.8h60.946c0.402,0,0.731,0.36,0.731,0.8v12.07
		c0,0.439-0.329,0.801-0.731,0.801H36.322c-0.402,0-0.731-0.361-0.731-0.801V67.717z">
		<animate attributeType="CSS" id="main" attributeName="fill" values="<? echo $main_change_color; ?>; <? echo $main_change_color2; ?>; <? echo $main_change_color; ?>" calcMode="linear" dur="3s" repeatCount='indefinite'/>
		</path>
		
		
		
	<path id="small_x5F_upper_x5F_box" fill="<? echo $upper_small_change_color; ?>" d="M35.5,54.967c0-0.44,0.329-0.8,0.731-0.8h60.947c0.401,0,0.73,0.36,0.73,0.8
		v7.309c0,0.439-0.329,0.8-0.73,0.8H36.231c-0.402,0-0.731-0.36-0.731-0.8V54.967z"><animate attributeType="CSS" id="upper_1" attributeName="fill" values="<? echo $upper_small_change_color2; ?>; <? echo $upper_small_change_color; ?>; <? echo $upper_small_change_color2; ?>" calcMode="linear" dur="4s" repeatCount='indefinite'/>
		</path>
		
		
	<path id="up_x5F_triangle_2_" fill="<? echo $upper_large_change_color; ?>" d="M109.408,50.281c0.094-0.875-0.828-1.266-1.781-1.688
		C106.502,48.14,70.1,31.046,68.698,30.304c-1.399-0.742-2.185-0.696-3.442,0.009c-1.261,0.704-38.881,18.103-39.485,18.374
		s-1.379,0.65-1.521,1.271c-0.104,0.458,0.316,1.083,0.875,1.083c0.702-0.022,22.776,0.015,43.995,0.018
		c20.079,0.002,39.112-0.054,39.46-0.044C108.9,51.016,109.365,50.688,109.408,50.281z"><animate attributeType="CSS" id="upper_2" attributeName="fill" values="<? echo $upper_large_change_color; ?>; <? echo $upper_large_change_color2; ?>; <? echo $upper_large_change_color; ?>" calcMode="linear" dur="5s" repeatCount='indefinite' />
		</path>
</g>
<g id="Usage_x5F_Change">
	<text id="change_x5F_text" transform="matrix(1 0 0 1 67 76.2588)" font-family="'Verdana'" font-size="8" text-anchor="middle"><? 
		
	//write kilowattage change text in main box
	//check for more than a 5 watt change 
	
	if($watts_change > 2){
		echo "Up ", (floor($watts_change * .01) )*0.1, " KW";  
	}
	else if($watts_change < -2){
		echo "Down ", (floor($watts_change * .01) )*0.1, " KW";  
	}
	else{
		echo "No Change" ; 
	}
	
	?></text>
	<text transform="matrix(1 0 0 1 64 141.25)" font-family="Verdana" font-size="12" text-anchor="middle"><? echo $gauge_name; ?></text>
</g>
<g id="Status_1_">
	<g id="status_x5F_text_x5F_bg">
		<path fill="#A6A6A6" d="M80,8.625c0-1.65,1.35-3,3-3h34c1.65,0,3,1.35,3,3V22.5c0,1.65-1.35,3-3,3H83c-1.65,0-3-1.35-3-3V8.625z"
			/>
	</g>
<text id="status_x5F_text" transform="matrix(1 0 0 1 102 20.3125)" font-family="'Verdana'"  font-size="10" text-anchor="middle"><? echo floor($watts_change_percent), "%"; ?></text>
</g>
</svg>
