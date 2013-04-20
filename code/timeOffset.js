//Andrew Hazelden's DayOffset javascript function v1.0
//Created June 25, 2011

//Usage: monthOffset(3, 3) 
//First define a duration in months.
//Then a graph period ranging from 0 to 4.

//Usage: dayOffset(31, 3) 
//First define a duration in days.
//Then a graph period ranging from 0 to 4.

//Usage: hourOffset(24, 3) 
//First define a duration in hours.
//Then a graph period ranging from 0 to 4.

//Usage: minOffset(60, 3) 
//First define a duration in hours.
//Then a graph period ranging from 0 to 4.
//


function monthOffset(duration, period){

var graph_grid_line_count = 3;

i = period;

var months_offset = Math.floor( ((duration / graph_grid_line_count) * i) );
var previousMonths = Date.today().addMonths(-months_offset);

return (previousMonths.toString('MMM d'));
}



function dayOffset(duration, period){

var graph_grid_line_count = 3;

i = period;

var days_offset = Math.floor( ((duration / graph_grid_line_count) * i) );
var previousDay = Date.today().addDays(-days_offset);

return (previousDay.toString('MMM d'));
}





function hourOffset(duration, period){


var graph_grid_line_count = 3;

i = period;

var hours_offset =  ((duration / graph_grid_line_count) * i);
var previousHour = Date.today().setTimeToNow().addHours(-hours_offset);


if( period == 0  ){
var returnValue = previousHour.toString('[MMM d] h tt');
}
else if( period == 3 ){
var returnValue = previousHour.toString('h tt [MMM d]');
}
else{
var returnValue = previousHour.toString('h tt');
}

return (returnValue);
}



// (60, 0) = 15 *0

function minOffset(duration, period){

var graph_grid_line_count = 3;
i = period;

var mins_offset = Math.floor( ((duration / graph_grid_line_count) * i) );
var previousMin = Date.today().setTimeToNow().addMinutes(-mins_offset);

//return (-mins_offset);
return (previousMin.toString('h:mm tt'));
}


