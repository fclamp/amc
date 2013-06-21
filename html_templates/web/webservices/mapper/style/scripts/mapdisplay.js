/*
 * (C)2000-2007 KE Software
 *
 * the following global variables must be 
 * defined and set prior to including this file in the HTML.
 *
 * var MapProjection
 * var MapUnits
 * var Map
 * var ReferenceMap
 * var Scalebar
 * var MapExtent
 * var ImgWidth
 * var ImgHeight
 * var Referer
 * var MapperUrl
 * var Passive
 * var ActionRequested
 * var ReferredArguments
 *
 */


// Global Variables

var hsActive = false;
var Mapfile = null;
var ForceReset = false;


 // smallest box allowed (anything smaller will be inflated to this many pixels
 // square)
 var MinPixelBox = 10;

 // Map Image Position (these will be set during layout initialisation)
 var MapTop = 0;
 var MapLeft = 0;
 var MapHeight = 0;
 var MapWidth = 0;
 var MapBottom = 0;
 var MapRight = 0;

 // global status
 var xHairs = 'on';
 var MouseIsDown = false;
 var RubberBandStatus = 'idle';	//idle, stretching
 var CurrentTool = 'ZoomIn' 	// ZoomIn, ZoomOut, Pan, Query, \
				// Spatial, Redraw

 var RubberBandExtent = new Box(0, 0, 0, 0);

 var UnitsNotSpherical =  MapUnits.match(/MET/);

// Point and Box are useful simple data structures
function Point(x,y)
{
	this.x = x;
	this.y = y;
}

function Box(x1,y1,x2,y2)
{
	this.x1 = x1;
	this.y1 = y1;
	this.x2 = x2;
	this.y2 = y2;
}

function pad(st,length)
{
	// makes a right padded string for formatting
	// (missing sprintf like stuff in javascript)
	var str = '' + st;
	while (str.length < length)
	str = str + ' ';
	return str.replace(/ /g,'&nbsp;');
}

function mouseInHouse(pMouse,p1,p2)
{
	// is point (typically mouse position) within given range
	return (pMouse.x >= p1.x &&
		pMouse.y >= p1.y &&
		pMouse.x <= p2.x &&
		pMouse.y <= p2.y);
}

function mouseOnMap(pMouse)
{
	var p1 = new Point(MapLeft,MapTop);
	var p2 = new Point(MapRight,MapBottom);
	return (pMouse.x >= p1.x &&
		pMouse.y >= p1.y &&
		pMouse.x <= p2.x &&
		pMouse.y <= p2.y);
}

function getMouseEventCoords(userEvent)
{
	// turn mouse event screen coords into coords relative to
	// page relative coords
	var p = new Point();

	if (typeof(userEvent) != 'undefined')
	{
		p.x = userEvent.clientX;
		p.y = userEvent.clientY;
	}
	else
	{
		p.x = event.x;
		p.y = event.y;
	}

	/* account for any scrolling of browser */
	if (document.body.scrollTop)
			p.y += document.body.scrollTop;
	else if (window.pageYOffset)
			p.y += window.pageYOffset;
	if (document.body.scrollLeft)
			p.x += document.body.scrollLeft;
	else if (window.pageXOffset)
			p.x += window.pageXOffset;
	return p;
}

function cosh(x)
{
	return (Math.exp(x) + (1/Math.exp(x)))/2;
}

function sinh(x)
{
	return (Math.exp(x) - (1/Math.exp(x)))/2;
}

function metresToLatLong(x,y)
{
/* some of these quick approximations treating earth as a sphere - hopefully
 * good enough for mouse pos on map display, more accurate conversion too
 * computationally intensive.
 * So far can only do for:
 * - mercator
 * - polar stereographic
 * - miller cylindrical
 * - eckertIV pseudo cylindrical
 * for stuff onother  projections see:
 * libproj4 (there was a user manual (draft) at
 * http://members.verizon.net/~vze2hc4d/proj4/manual.pdf that has a number of
 * projection formulas)
 */

	var rToD = 180/Math.PI;
	var earthRadius = 6378137.0;
	var piDiv2 = Math.PI/2;
	var pi = Math.PI;
	
	var flattening = 1/298.257223563
	//var polarRadius = earthRadius * (1-flattening);

	if (MapProjection.match(/=merc/))
	{
		var temp = (y/earthRadius);
		temp =Math.exp(temp);
		temp = (2 * Math.atan(temp)) - (piDiv2);

		var lat = Math.round(temp * rToD);
		var lon = Math.round(10*(x/earthRadius)* rToD)/10;

		return new Point(lon,lat);
	}
	if (MapProjection.match(/=tmerc/))
	{
		// NB these taken from NZTM data - will only work for NZTM
		var FE    = 10000000;
		var FN    = 1600000;
		var lon_0 = 173 / rToD;
		var k0    = 0.9996;


		var xp    = (x - FN) / (k0 * earthRadius);
		var D     = (y - FE) / (k0 * earthRadius);

		var lat = Math.round(10 * (rToD * Math.asin(Math.sin(D) / cosh(xp)) - 0.2))/10;
		var lon  = (Math.round(10 * rToD * (lon_0 + Math.atan(sinh(xp) / Math.cos(D))))/10);
		
		return new Point(lon,lat);
	}
	else if (MapProjection.match(/=stere/))
	{
		var d2ProjPlane = 2*earthRadius;

		var hypot = Math.sqrt(x*x+y*y);
		var latTan = hypot/d2ProjPlane;

		// if perfect sphere then factor is 2 but experimenting, factor
		// seems to depend on lat of true scale... (JonK)
		//var lat =  2.04*Math.atan(latTan) - piDiv2; // lts = 74N
		var lat =  2.05*Math.atan(latTan) - piDiv2;   // lts = 71S

		var lon = 0;
		if (y != 0)
		{
			lon = Math.atan(x/y);
		}

		if (y < 0)
		{
				lon = pi + lon;
				if (x < 0)
					lon = lon - 2*pi;
		}
		return new Point(Math.round(10*lon*rToD)/10,Math.round(10*lat*rToD)/10);
	}
	else if (MapProjection.match(/=mill/))
	{
		y = (y/earthRadius);

		var lat = 2.5*Math.atan(Math.exp(4*y/5)) - 5*pi/8;

		var lon = x/earthRadius;
		return new Point(Math.round(10*lon*rToD)/10,Math.round(10*lat*rToD)/10);
	}
	else if (MapProjection.match(/=eck4/))
	{
		y = (y/earthRadius);
		x = (x/earthRadius);
		
		var sinTheta = (y/2)*(Math.sqrt((4+pi)/pi));
		var theta = Math.asin(sinTheta);

		var lat = Math.asin((theta + Math.sin(theta)*Math.cos(theta) + 2*Math.sin(theta))/(2+(pi/2)));


		var lon = (((x)*Math.sqrt(pi*(4+pi)))/(2*(1 + Math.cos(theta))) );


		return new Point(Math.round(lon * rToD), Math.round(lat * rToD));
	}
	else if (MapProjection.match(/=wintri/))
	{
	}
	
	// do not transform - return nothing...
	return new Point(" "," ");
}

function ImageXYToLatLong(x,y)
{
	// turn passed x,y page coords to lat/long coords
	// based on map size and extent

	var latLong = new Point(x - MapLeft - 1,y - MapTop - 1);

	mapExt = [0,0,0,0];
	latLong.x = +MapExtent[0] + ((MapExtent[2] - MapExtent[0]) * latLong.x / MapWidth);
	latLong.y = +MapExtent[3] - ((MapExtent[3] - MapExtent[1]) * latLong.y / MapHeight);

	/* aargh no sprintf !
	round lat/longs based on map extent */
	var roundBy = 1;
	var longWidth = Math.abs(+mapExt[2] - +mapExt[0]);
	if (longWidth < 60)
		roundBy = 2;
	if (longWidth < 30)
		roundBy = 5;
	if (longWidth < 15)
		roundBy = 10;
	if (longWidth < 10)
		roundBy = 100;
	if (longWidth < 5)
		roundBy = 500;

	lat = Math.round(latLong.y*roundBy)/roundBy;
	lon = Math.round(latLong.x*roundBy)/roundBy;

	return new Point(lon,lat);
}

function updateXHairs(p)
{
	var h = document.getElementById('xHairH');
	var v = document.getElementById('xHairV');

	h.style.top = p.y + 'px';
	v.style.left = p.x + 'px';

	if ((typeof(xHairs) != "undefined") && xHairs == 'on')
	{
		h.style.visibility = 'visible';
		v.style.visibility = 'visible';
	}
	else
	{
		h.style.visibility = 'hidden';
		v.style.visibility = 'hidden';
	}
}

function rubberBandSmall()
{
	if ((Math.abs(RubberBandExtent.x1 - RubberBandExtent.x2) < MinPixelBox)
		||
	    (Math.abs(RubberBandExtent.y1 - RubberBandExtent.y2) < MinPixelBox))
	    	return true;
	return false;	
}


function hideRubberBand()
{
	var rb = document.getElementById('rubberBand');
	RubberBandStatus = 'idle';
	makeGhostRubberBand(rb);
	rb.style.visibility = 'hidden';
}

function makeGhostRubberBand(realRb)
{
	var ghostDiv = document.createElement("div");
	ghostDiv.style.top = realRb.style.top;
	ghostDiv.style.left = realRb.style.left ;
	ghostDiv.style.zIndex = realRb.style.zIndex ;
	ghostDiv.style.visibility = realRb.style.visibility ;
	ghostDiv.style.width = realRb.style.width ;
	ghostDiv.style.height = realRb.style.height ;
	ghostDiv.style.border = "3px solid #7f7f7f";
	ghostDiv.style.position = realRb.style.position ;
	realRb.appendChild(ghostDiv);
}


function updateRubberBand(p)
{
	if (RubberBandStatus == 'stretching')
	{
		var x1 = RubberBandExtent.x1;
		var y1 = RubberBandExtent.y1;
		var x2 = p.x
		var y2 = p.y
		var flipX = x2 < x1;
		var flipY = y2 < y1;

		if (flipX)
		{
			var tmp = x1;
			x1 = x2;
			x2 = tmp;
		}
		if (flipY)
		{
			var tmp = y1;
			y1 = y2;
			y2 = tmp;
		}


		var width = (x2 - x1);
		var height = (y2 - y1);

		var rb = document.getElementById('rubberBand');
		if (CurrentTool == 'Pan' || CurrentTool == 'ReDraw')
			rb.style.visibility = 'hidden';
		else
			rb.style.visibility = 'visible';

		rb.style.top = y1 + 'px';
		rb.style.left = x1 + 'px';
		rb.style.width = width + 'px';
		rb.style.height = height + 'px';

		if (flipX)
		{
			RubberBandExtent.x1 = x1 + width;
			RubberBandExtent.x2 = x1;
		}
		else
		{
			RubberBandExtent.x1 = x1;
			RubberBandExtent.x2 = x1 + width;
		}

		if (flipY)
		{
			RubberBandExtent.y1 = y1 + height;
			RubberBandExtent.y2 = y1;
		}
		else
		{
			RubberBandExtent.y1 = y1;
			RubberBandExtent.y2 = y1 + height;
		}
	}
	else
	{
		var rb = document.getElementById('rubberBand');
		rb.style.visibility = 'hidden';
		RubberBandExtent.x1 = p.x;
		RubberBandExtent.y1 = p.y;
	}
}

function constrainToSphere(extent, width, height)
{
	// normalise lat/longs to get them within
	// accepted range
	if (UnitsNotSpherical)
		return extent;

	if (width > 360)
		width = 360;
	if (height > 180)
		height = 180;


	if (extent.y1 < -90)
	{
		extent.y1 = -90;
		extent.y2 = extent.y1 + height;
	}
	if (extent.y2 > 90)
	{
		extent.y2 = 90;
		extent.y1 = extent.y2 - height;
	}
	if (extent.x1 < -180)
	{
		extent.x1 = -180;
		extent.x2 = extent.x1 + width;
	}
	if (extent.x2 > 360)
	{
		extent.x2 = 360;
		extent.x1 = extent.x2 - width;
	}
	return new Box(extent.x1, extent.y1, extent.x2, extent.y2);
}

function panToCentreOnPoint(extent,centre)
{

	// adjust lat/longs to centre map on given point

	//  width/height of current map in lat/longs
	var width = +extent.x2 - extent.x1;
	var height = +extent.y2 - extent.y1;

	//  new min/max lat longs of map
	var minLong = +centre.x - 0.5*width;
	var maxLong = +minLong + width;
	var minLat = +centre.y - 0.5*height;
	var maxLat = +minLat + height;

	var newExtent = new Box(minLong,minLat,maxLong,maxLat);

	//  avoid panning outside sphere
	return constrainToSphere(newExtent,width,height);
}

function zoomExtentIn(zoomFactor,centre)
{

	var width = +MapExtent[2] - MapExtent[0];
	var height = +MapExtent[3] - MapExtent[1];

	width /= zoomFactor;
	height /= zoomFactor;

	//  new min/max lat longs of map
	var minLong = +centre.x - 0.5*width;
	var maxLong = +minLong + width;
	var minLat = +centre.y - 0.5*height;
	var maxLat = +minLat + height;

	var newExtent = new Box(minLong,minLat,maxLong,maxLat);

	//  avoid panning outside sphere
	return constrainToSphere(newExtent,width,height);
}
function zoomExtentOut(zoomFactor)
{

 	var width = +MapExtent[2] - MapExtent[0];
 	var height = +MapExtent[3] - MapExtent[1];

	var centreLat = +MapExtent[1] + 0.5*(height);
	var centreLong = +MapExtent[0] + 0.5*(width);

	width *= zoomFactor;
	height *= zoomFactor;

	var minLong = +centreLong - 0.5*width;
	var maxLong = +minLong + width;
	var minLat = +centreLat - 0.5*height;
	var maxLat = +minLat + height;
	var newExtent = new Box(minLong,minLat,maxLong,maxLat);

	//  avoid panning outside sphere
	return constrainToSphere(newExtent,width,height);
}

function compensateForDateLine(requested,view)
{
	// we want to return a rectangle same as requested, however it may be
	// specified as 0 > long < 180 whilst initial map extent may be 0 <
	// long < 360.  Adjust requested to give better fit.
	if (view[2] > 180)
	{

		while (+requested[0] < view[0])
		{
			requested[0] = 360 + +requested[0];
		}
		while (+requested[2] < view[0])
		{
			requested[2] = 360 + +requested[2];
		}

	}
	return requested;		
}

function setLayerParameters(url)
{
	
	var inputs = document.getElementsByTagName('input');

	for (var i=0; i < inputs.length; i++)
	{
		var name =  inputs[i].name;
		var value =  inputs[i].checked;
		var type =  inputs[i].type;
		if (type == 'checkbox')
		{
			if (! value)
				url += "&" + name + "=off";
		}
		else if (type == 'radio')
		{
			if (value)
			{
				// IE will return element by name even
				// if get by id asked for (it will find
				// any element with a  *name* same as
				// the requested id) - can trick it
				// by changing name of radio element
				// sortby to showby but need to reverse
				// trick here

				if (name == 'showby')
					name = 'sortby';
				url += "&" + name + "=" + inputs[i].value;
			}
		}
	}

	return url;
}

function mSubmit(tool)
{
	var start = ImageXYToLatLong(RubberBandExtent.x1,RubberBandExtent.y1);
	var stop = ImageXYToLatLong(RubberBandExtent.x2,RubberBandExtent.y2);
	if (rubberBandSmall())
	{
		var x1 = RubberBandExtent.x1 - MinPixelBox/2;
		var y1 = RubberBandExtent.y1 - MinPixelBox/2;
		start = ImageXYToLatLong(x1,y1);
		stop = ImageXYToLatLong(x1+MinPixelBox,y1+MinPixelBox);
	}

	// arrange lat/longs in ascending order
	if (start.x > stop.x)
	{
		var tmp = start.x;
		start.x = stop.x;
		stop.x = tmp;
	}
	if (start.y > stop.y)
	{
		var tmp = start.y;
		start.y = stop.y;
		stop.y = tmp;
	}


	// build url
	var currentExtent = new Box(MapExtent[0],MapExtent[1],MapExtent[2],MapExtent[3]);

	var url = MapperUrl + "&action=" + CurrentTool;
	if ((getCurrentCheckedProjection() != Mapfile) || ForceReset)
	{
		url += "&layerSetting=default";
	}
	else
	{
		url += "&layerSetting=auto";
	}

	if (Passive)
		url += '&passive=true';

	var form = document.getElementById('form');

	url = setLayerParameters(url);

	switch (tool)
	{
		case 'ZoomIn' :
			hideRubberBand();
			var box = "";
			if (rubberBandSmall())
			{
				// either v small box or double click
				var newExtent = zoomExtentIn(2,start);
				box = "minlong="+ newExtent.x1 
					+"&minlat="+ newExtent.y1 
					+"&maxlong="+ newExtent.x2 
					+"&maxlat="+ newExtent.y2;
			}
			else
				box = "minlong="+ start.x 
					+"&minlat="+ start.y 
					+"&maxlong="+ stop.x 
					+"&maxlat="+ stop.y;
			url += "&"+box+"&projection="+MapProjection;
			diagnostic(box);

			form.setAttribute('action',url);
			form.submit();
			break;
		case 'ZoomOut' :
			hideRubberBand();
			var newExtent = zoomExtentOut(2);
			var box = "minlong="+ newExtent.x1 
				+"&minlat="+ newExtent.y1 
				+"&maxlong="+ newExtent.x2 
				+"&maxlat="+ newExtent.y2;
			url += "&"+box+"&projection="+MapProjection;
			
			form.setAttribute('action',url);
			form.submit();
			break;
		case 'Pan' :
			hideRubberBand();
			var centre = new Point(stop.x,stop.y);
			var newExtent = panToCentreOnPoint(currentExtent,centre);
			var box = "minlong="+ newExtent.x1 
				+"&minlat="+ newExtent.y1 
				+"&maxlong="+ newExtent.x2 
				+"&maxlat="+ newExtent.y2;
			url += "&"+box+"&projection="+MapProjection;
			diagnostic(url);
			
			form.setAttribute('action',url);
			form.submit();
			break;
		case 'Query' :
			hideRubberBand();
			var box = "minlong="+ start.x +"&minlat="+ start.y +"&maxlong="+ stop.x +"&maxlat="+ stop.y;
			url += "&"+box+"&projection="+MapProjection;
			url += "&qstylesheet="+QueryDataStylesheet;
			diagnostic(url);

			form.setAttribute('action',url);
			form.submit();
			break;
		case 'Spatial' :
			hideRubberBand();
			var box = "minlong="+ start.x +"&minlat="+ start.y +"&maxlong="+ stop.x +"&maxlat="+ stop.y;
			url += "&"+box+"&projection="+MapProjection;
			diagnostic(url);
			form.setAttribute('action',url);
			form.submit();
			break;
		case 'Reset' :
			hideRubberBand();
			form.setAttribute('action',url);
			form.submit();
			break;
		case 'Expand' :
			hideRubberBand();
			PointExtents = compensateForDateLine(PointExtents,MapfileExtents);
			url += "&minlong=" +  (+PointExtents[0] - 10) +
				"&minlat=" +  (+PointExtents[1] - 1) +
				"&maxlong=" + (+PointExtents[2] + 10) +
				"&maxlat=" +  (+PointExtents[3] + 1) +
				"&projection=" + MapProjection;
			form.setAttribute('action',url);
			form.submit();
			break;
		case 'Return' :
			hideRubberBand();
			var referer = decodeURIComponent(Referer);
			if (referer.match(/\/mapper.php$/))
				referer += '?queryScreen=mapper_queryscreen.xsl';
			form.setAttribute('action',referer);
			form.submit();
			break;
		case 'ReDraw' :
			hideRubberBand();
			var box = "minlong="+ currentExtent.x1 
				+"&minlat="+ currentExtent.y1 
				+"&maxlong="+ currentExtent.x2 
				+"&maxlat="+ currentExtent.y2;
			url += "&"+box+"&projection="+MapProjection;
			diagnostic(url);
			
			form.setAttribute('action',url);
			form.submit();
			break;
		case 'Print' :
			hideRubberBand();
			diagnostic(url);
			displayMapImage();
			selectTool('ZoomIn');
			break;
		default :
			alert("Unknown action: " + tool);
			break;
	}
}

function downMouse(userEvent)
{
	MouseIsDown = true;
	document.getElementById('LatLongDisplay').style.color = '#ff0000';	

	var pMouse  = getMouseEventCoords(userEvent);
	if (mouseOnMap(pMouse))
	{
		if (RubberBandStatus == 'idle')
		{
			RubberBandStatus = 'stretching';
			updateRubberBand(pMouse);
		}
	}
}

function upMouse(userEvent)
{
	MouseIsDown = false;
	document.getElementById('LatLongDisplay').style.color = '#000000';	

	var pMouse  = getMouseEventCoords(userEvent);
	if (mouseOnMap(pMouse))
	{
		mSubmit(CurrentTool);
	}
	else
	{
		RubberBandStatus = 'idle';
	}

}

function moveMouse(userEvent)
{
	var pMouse  = getMouseEventCoords(userEvent);
	if (mouseOnMap(pMouse))
	{
		updateXHairs(pMouse);

		updateRubberBand(pMouse);

		// display latlong of current mouse position
		var latLong = ImageXYToLatLong(pMouse.x,pMouse.y);
		if (MapUnits.match(/MET/))
			latLong = metresToLatLong(latLong.x,latLong.y);

		if (latLong.x > 180)
		{
				while (latLong.x > 180)
				{
						latLong.x -= 360.0;
				}
				latLong.x = Math.round(latLong.x*1000)/1000;
		}

		var msg = '- -';
		if (xHairs == 'on')
			msg = pad(''+ latLong.y +",", 10) + pad(''+ latLong.x, 10);
		document.getElementById("LatLongDisplay").innerHTML = msg;
	}
}

function diagnostic(msg)
{
	/*var element = document.getElementById('diagnostics');
	element.style.visibility = 'visible';
	element.innerHTML = msg;*/
	//alert(msg);
}

function setToolHint(state,text)
{
	var element = document.getElementById('ControlsHelp');
	element.style.visibility = state;
	element.innerHTML = text;
}

function setButtonOff(id)
{
	var tool = document.getElementById(id);
	var img = tool.getAttribute("coldsrc");
	tool.style.border = '3px outset #000000';
	tool.setAttribute('src',img);
	tool.style.backgroundImage = "url(" + img + ")";
}

function setButtonOn(id)
{
	var tool = document.getElementById(id);
	var img = tool.getAttribute("hotsrc");
	tool.style.border = '3px inset #ff0000';
	tool.setAttribute('src',img);
	tool.style.backgroundImage = "url(" + img + ")";
}


function selectTool(toolSt)
{
	CurrentTool = toolSt;
	var controls = document.getElementsByClassName("controlButton");
	for(i = 0; i < controls.length; i++) 
	{
		var id = controls[i].getAttribute("id");
		setButtonOff(id);
	}
	setButtonOn(CurrentTool);
	var hint = document.getElementById(CurrentTool).getAttribute("toolHint");
	setToolHint('visible',hint);
}

function getCurrentCheckedProjection()
{
	var pOptions = document.getElementsByName('mapfile');
	for (var j=0; j < pOptions.length; j++)
	{
		if (pOptions[j].checked)
		{
			return pOptions[j].value;
		}
	}
	return null;
}

function checkBoxes()
{
	// set checkboxes/radio buttons etc based on passed arguments

	var args;
	if (ReferredArguments.match("&amp;"))
	{
		args = ReferredArguments.split("&amp;");
	}
	else	
	{
		args = ReferredArguments.split("&");
	}
		
	var pOptions = document.getElementsByName('mapfile');
	for (i=0; i < args.length; i++)
	{
		var param = args[i].split("=");
		var element = document.getElementById(param[0]);
		// NB IE will find things with matching name for getElementById
		// so will pick radio buttons whose name attribute matches
		// passed id even if they don't even have an id...
		/*if (element && element.getAttribute('type') == 'radio')
			element = null;*/

		if (param[0] == 'mapfile')
		{
			var mapf = args[i].replace(/mapfile=/,"");
			var found = false;
			for (var j=0; j < pOptions.length; j++)
			{
				if (pOptions[j].value == mapf)
				{
					pOptions[j].setAttribute("checked","true");
					found = true;
					Mapfile = mapf;
				}
			}
			if (! found)
			{
				pOptions[0].setAttribute("checked","true");
			}		
		}
		else if (element != null)
		{
			switch(element.getAttribute('type'))
			{
				case 'radio' :	
					if (element.value == param[1])
						element.setAttribute('checked',param[1]);
					break;
				case 'checkbox' :	
					if ((param[1] == 'on') || (param[1] == 'true'))
						element.setAttribute('checked',param[1]);
					break;	
				default:
					break;
			}
		}
		else if (param[0] == 'sortby')
		{
			var element = document.getElementById("sortby_"+param[1]);
			if (element)
				element.checked = true;
		}
	}
}




function GoogleMap()
{
	setButtonOff('ZoomIn','./mapper/images/zoomin.gif');
	setButtonOff('ZoomOut','./mapper/images/zoomout.gif');
	setButtonOff('Query','./mapper/images/query.gif');
	setButtonOff('Pan','./mapper/images/pan.gif');
	setButtonOff('ReDraw','./mapper/images/redraw.gif');
	/*setButtonOff('Spatial','./mapper/images/areaquery.gif');*/
	/*setButtonOn('Google','./mapper/images/maps_res_logo_but.gif');*/
	/*setToolHint('visible','Open A Google Map Display');*/

	var url = "http://syd.kesoftware.com/jonk/gmap/gmap.php";
	url += "?extent=" + escape(MapExtent.join(" "));
	url += "&dataCache=http://titanis.yvr.kesoftware.com[data]";
	var windowHandle = window.open(url,'KE_Web_Mapper_to_Google_Maps','');
	if (window.focus)
		{windowHandle.focus()};
}

/* link to emuweb for data */
function getInfoOn(term,category,emuBackend)
{
	var emuwebPath = "../intranet/pages/"+ emuBackend + "/" ;

	var url = emuwebPath + "ResultsList.php?";
	url += "Where=" + escape("SummaryData CONTAINS '"+ term +"'");
	url += "&QueryPage=" + escape("../../../" + emuwebPath + "Query.php");
	url += "&LimitPerPage=100";

	var form = document.getElementById('form');
	form.setAttribute('action',url);
	form.submit();
	return;
}

/* This is web service portal display for data */
/*function getInfoOn(term,category,emuBackend)
{
	var url = "./portal.php?search=<filter><equals>" +
		"<darwin:" + category + ">" + term +"</darwin:" + category +">" +
		"</equals></filter><records limit='50' start='0'>" +
		"<structure schemaLocation='http://digir.sourceforge.net/schema/conceptual/darwin/full/2003/1.0/darwin2full.xsd'/>"+
		"</records>&stylesheet=portal/style/portal.xsl&source[]=" + Sources.join("&source[]=");

	var form = document.getElementById('form');
	form.setAttribute('action',url);
	form.submit();
}
*/

function savePreferences()
{
	var inputs = document.getElementsByName('mapfile');
	for (var i=0; i < inputs.length; i++)
	{
		if ((inputs[i].checked == 'true') || inputs[i].checked)
		{
			alert ("saving '"+ inputs[i].value + "' as default view");
			document.cookie = "KE_cookie_mapfile_="+inputs[i].value +"; expires=0; path=/";
		}
	}
}

function initXHairs()
{
	var h = document.getElementById('xHairH');
	h.style.left = MapLeft + 'px';
	h.style.width = MapWidth + 'px';
	h.style.top = MapHeight/2 + 'px';

	var v = document.getElementById('xHairV');
	v.style.left = MapWidth/2 + 'px';
	v.style.height = MapHeight + 'px';
	v.style.top = MapTop + 'px';
}

function initRubberBand()
{
	var r = document.getElementById('rubberBand');
	r.style.top = MapHeight/2 + 'px';
	r.style.left = MapWidth/2 + 'px';
	RubberBandExtent = new Box(0,0,0,0);				
}

function displayMapImage()
{
	window.open(Map);
}

function initLayout()
{
	// calculate absolute screen coords of map

	var div = document.getElementById('Map');


	var posTopXy =  findAbsoluteOffset(div);
	MapLeft = posTopXy.x;
	MapTop = posTopXy.y;

	MapHeight = ImgHeight;
	MapWidth = ImgWidth;
	MapBottom = MapTop + MapHeight;
	MapRight = MapLeft + MapWidth;
}

function findAbsoluteOffset(element)
{
	// need to find the absolute screen position of an element (in all browsers).
	// Do this by crawling up the tree and add offsets
	var pos = new Point(0,0);
	if (element.offsetParent) 
	{
		pos.x = element.offsetLeft
		pos.y = element.offsetTop
		while (element = element.offsetParent) 
		{
			pos.x += element.offsetLeft
			pos.y += element.offsetTop
		}
	}
	return pos;
}

function adjustHotSpots()
{
	// move hotspots under image - they are given with origin at 0,0
	var hotSpots = document.getElementsByClassName("hotSpot");
	for(i = 0; i < hotSpots.length; i++) 
	{
		var x = hotSpots[i].style.left;
		var y = hotSpots[i].style.top;
		x = x.replace(/px/,'');
		y = y.replace(/px/,'');

		hotSpots[i].style.left =  (+MapLeft + +x) + "px";
		hotSpots[i].style.top =  (+MapTop + +y) + "px";
	}
}

function printMap()
{
	// the map is a background image of a div because of IE issues - 	
	// most browsers won't print background images by default.
	// We do have a 'hidden' map image on the page we can make
	// visible when printing
	document.getElementById('tempMap').style.visibility = 'visible';
}

function afterPrintMap()
{
	document.getElementById('tempMap').style.visibility = 'hidden';
}

function init()
{
	initLayout();
	initXHairs();
	initRubberBand();

	checkBoxes();

	if (ActionRequested.match(/ZoomIn|ZoomOut|Pan|Query|SpatialQuery/))
		selectTool(ActionRequested);
	else
		selectTool('ZoomIn');

	adjustHotSpots();

	window.onbeforeprint = printMap;
	window.onafterprint = afterPrintMap;
}

function getReferer()
{
	return (decodeURIComponent(Referer));
}


function stopEvent(ev)
{
	var e = ev;
	if (! ev)
		e = window.event;
	e.cancelBubble = true;
	if (e.stopPropagation) 
		e.stopPropagation();
	return false;
}

function coolSpot(el)
{
	el.parentNode.removeChild(el);
	Behaviour.apply();
	hsActive = false;
}

function hotSpot(el,data)
{
	//var id = "toolTip_" + el.getAttribute("id");
	var id = "toolTip";
	if (!hsActive && !document.getElementById(id))
	{
		var tooltipDiv = document.createElement("div");
		tooltipDiv.setAttribute("id", id);
		tooltipDiv.setAttribute("class","tooltip");
		// IE requires class to be called 'className'
		tooltipDiv.setAttribute("className","tooltip");

		data = data.replace(/\|/g,"<br/>AND<br/>");
		var key = el.getAttribute("key");

		tooltipDiv.innerHTML = 
			"<div class='b1'></div><div class='b2'></div><div class='b3'></div><div class='b4'></div>" +
			" <div class='roundBoxContent'>" +
			"  <div>" +
			"   <img class='tooltipCloseButton' src='./images/closeIcon.jpg' />" +
				data +
			"   <div class='tooltipLink' key='" + key + "' >DETAILS</div>" +
			"  </div>" +
			" </div>" +
			"<div class='b4'></div><div class='b3'></div><div class='b2'></div><div class='b1'></div>";

		tooltipDiv.style.height = (data.length/10) + "em";
		el.appendChild(tooltipDiv);
		Behaviour.apply();
		hsActive = true;
	}
}

function getCurrentShowBySetting()
{
	var inputs = document.getElementsByTagName('input');
	for (var i=0; i < inputs.length; i++)
	{
		if (inputs[i].name == "showby" && inputs[i].checked )
		return inputs[i].value;
	}
	if (inputs.length > 0)
		return inputs[0].value;
	else
	return "ScientificName";
}


function portalLink(query)
{
	return "/" + EmuWebBase + "/pages/" + EmuBackendType + "/ResultsList.php?Where=" + query;
}


// adds a function to the window onload call 'queue' without overwriting
// existing ones
function addLoadEvent(func)
{
	var oldonload = window.onload;
	if (typeof window.onload != 'function')
	{
		window.onload = func;
	} 
	else
	{
		window.onload = function()
		{
			if (oldonload)
			{
				oldonload();
			}
			func();
		}
	}
}

var behaviours =  {
	'#rubberBand' : function(element)
	{
		element.onmousedown = function(ev)
		{
			if (CurrentTool != 'Pointer')
			{
				downMouse(ev);
				stopEvent(ev);
			}
		}	
		element.onmouseup = function(ev)
		{
			if (CurrentTool != 'Pointer')
			{
				upMouse(ev);
				stopEvent(ev);
			}
		}
		element.onmousemove = function(ev)
		{
			if (CurrentTool != 'Pointer')
			{
				moveMouse(ev);
				stopEvent(ev);
			}
		}
	},
	'#xHairV' : function(element)
	{
		element.onmousedown = function(ev)
		{
			if (CurrentTool != 'Pointer')
			{
				downMouse(ev);
				stopEvent(ev);
			}
		}	
		element.onmouseup = function(ev)
		{
			if (CurrentTool != 'Pointer')
			{
				upMouse(ev);
				stopEvent(ev);
			}
		}
	},
	'#xHairH' : function(element)
	{
		element.onmousedown = function(ev)
		{
			if (CurrentTool != 'Pointer')
			{
				downMouse(ev);
				stopEvent(ev);
			}
		}	
		element.onmouseup = function(ev)
		{
			if (CurrentTool != 'Pointer')
			{
				upMouse(ev);
				stopEvent(ev);
			}
		}
	},
	'.hotSpot' : function(element)
	{
		element.onmousedown = function(ev)
		{
			if (CurrentTool == 'Pointer')
			{
				if (hsActive)
				{
					stopEvent(ev);
					coolSpot(document.getElementById('toolTip'));
					hotSpot(element,element.getAttribute('data'));
				}
			}
			else
			{
				downMouse(ev);
				stopEvent(ev);
			}

		}	
		element.onmouseup = function(ev)
		{
			if (CurrentTool != 'Pointer')
			{
				upMouse(ev);
				stopEvent(ev);
			}
		}
		element.onmouseover = function(ev)
		{
			if (CurrentTool == 'Pointer')
			{
				hotSpot(element,element.getAttribute('data'));
				stopEvent(ev);
			}
		}
	},

	'.tooltipLink' : function(element)
	{
		element.onmousedown = function(ev)
		{
			var key = element.getAttribute("key");
			if (key.match(/^\d+$/))
			{
				var query = "irn=" + key;
				window.location = portalLink(query);
				//alert("WEB DEVELOPER/DESIGNER\nplease add web link for statement: '" + query + "'");
			}
			else if (key.match(/,/))
			{
				var query = "irn=" + key.replace(/,/g,"+or+irn=");
				window.location = portalLink(query);
				//alert("WEB DEVELOPER/DESIGNER\nplease add web link for statment: '" + query + "'");
			}
			stopEvent(ev);
		}	
	},
	'.tooltipCloseButton' : function(element)
	{
		element.onmousedown = function(ev)
		{
			stopEvent(ev);
			coolSpot(document.getElementById('toolTip'));
			stopEvent(ev);
		}	
	},
	'.tooltip' : function(element)
	{
	},

	'.controlButton' : function(element)
	{
		element.onclick = function(ev)
		{
			var toolId = element.getAttribute("id");
			selectTool(toolId);
			if ((toolId == 'ReDraw') || (toolId == 'Reset') || 
				(toolId == 'Print') || (toolId == 'Expand') ||
				(toolId == 'Return') || (toolId == 'Print'))
			{
				mSubmit(CurrentTool);
			}
			stopEvent(ev);
		}
	},
	'#ContentControls' : function(element)
	{
		element.onclick = function(ev)
		{
			selectTool('ReDraw');
			stopEvent(ev);
		}
	},
	'#Map' : function(element)
	{
		element.onmousedown = function(ev)
		{
			if (CurrentTool != 'Pointer')
			{
				downMouse(ev);
				stopEvent(ev);
			}	
		}	
		element.onmouseup = function(ev)
		{
			if (CurrentTool != 'Pointer')
			{
				upMouse(ev);
				stopEvent(ev);
			}	
		}
		element.onmousemove = function(ev)
		{
			moveMouse(ev);
			stopEvent(ev);
		}
	},
	'.projection' : function(element)
	{
		element.onclick = function(ev)
		{
			if (getCurrentCheckedProjection() != Mapfile)
			{
				selectTool('Reset');
				ForceReset = true;
				stopEvent(ev);
			}
		}
	},
	'.portalUrlLink' : function(element)
	{
		element.onclick = function(ev)
		{
			submitUrl(portalLink(Texql));
		}
	},
	'#irnLink' : function(element)
	{
		var irn = element.getAttribute("irn");
		element.onclick = function(ev)
		{
			window.location = portalLink("irn=" + irn);
		}
	}

};

var mapImage = new Image();
mapImage.src = Map;


Behaviour.register(behaviours);

addLoadEvent(init);
