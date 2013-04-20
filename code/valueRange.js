//Andrew Hazelden's value range javascript function v1.0
//Created June 25, 2011

//valueRange("Power", 8000, 240, 4)

function valueRange(g_type, high_value, low_value, val){
var graph_grid_line_count = 4;
i = val;


//power gauge
if(g_type == "watts"){
//convert watts to KW
var result = Math.floor( ((high_value / graph_grid_line_count) * (i))) * .001;
//label KW
var g_label = "KW";
}


//solar temperature
if(g_type == "temperature"){
//convert watts to KW
var result = low_value + Math.floor( (((high_value-low_value) / graph_grid_line_count) * (i)));
var g_label = "°C";
}

//add gauge label
return (result.toString() + g_label);
}