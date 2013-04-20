#Andrew Hazelden's Solar Dashboard#

email: [andrew@andrewhazelden.com](mailto:andrew@andrewhazelden.com "andrew@andrewhazelden.com")  
web: [www.andrewhazelden.com](http://www.andrewhazelden.com "www.andrewhazelden.com")

**Solar Dashboard  v3.8**  
**Updated July 9, 2011**

## Screenshots ##

![Solar Dashboard](http://www.andrewhazelden.com/blog/wp-content/uploads/2011/07/solar_dashboard.png)

![This is a view of the Solar Dashboard on an iPod Touch.](http://www.andrewhazelden.com/blog/wp-content/uploads/2011/07/Dashboard_on_iPod.png)

## About the Scripts ##
The SVG graphics are created dynamically in PHP by wrapping a few PHP values around an SVG template I created in Adobe Illustrator. The data source for the SVG graphics is a live Pachube feed (Pachube now goes by the name cosm.com). The php scripts "index.php" and "graph.php" require you to write in your pachube login details.

The original sensor data is pushed to Pachube using an Arduino microcontroller. The Arduino is connected to the internet using a modified linksys router running dd-wrt that acts as a serial to ethernet bridge.

The source code is free for non-commercial use. Attribution is required.

This script was made to support the Villa Azul Solar PV and Hot water systems. You can view the live SVG based Solar Dashboard here: 
[http://www.true.mistral.co.uk/dash/](http://www.true.mistral.co.uk/dash/)

For more information on this project check out my blog post:  
 [Monitoring A Solar Hot Water System Over the Internet](http://www.andrewhazelden.com/blog/2011/07/monitoring-a-solar-hot-water-system-over-the-internet/).

I wrote a blog post about the process of using a linksys router as a network serial port:  

[How to use the serial ports on a Linksys WRT54GS with DD-WRT v24](http://www.andrewhazelden.com/blog/2010/01/how-to-use-the-serial-ports-on-a-linksys-wrt54gs-with-dd-wrt-v24/).


Regards,  
Andrew Hazelden