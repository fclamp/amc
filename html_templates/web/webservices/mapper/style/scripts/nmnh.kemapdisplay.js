/*
 * (C)2000-2006 KE Software
 *
 * the following global variables must be 
 * defined and set prior to including this file in the HTML.
 *
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
 var RubberBandExtent = null;


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

function ImageXYToLatLong(x,y)
{
	// turn passed x,y page coords to lat/long coords
	// based on map size and extent

	pMouse = new Point(x,y);
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

	h.style.top = p.y;
	v.style.left = p.x;

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
	if (extent.x2 > 180)
	{
		extent.x2 = 180;
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

				if (name = 'showby')
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

	var url = MapperUrl +"&action=" +  CurrentTool;

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
			url += "&"+box;
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
			url += "&"+ box;
			diagnostic(url);
			
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
			url += "&"+ box;
			diagnostic(url);
			
			form.setAttribute('action',url);
			form.submit();
			break;
		case 'Query' :
			hideRubberBand();
			var box = "minlong="+ start.x +"&minlat="+ start.y +"&maxlong="+ stop.x +"&maxlat="+ stop.y;
			url += "&"+box;
			url += "&qstylesheet="+QueryDataStylesheet;
			diagnostic(url);

			form.setAttribute('action',url);
			form.submit();
			break;
		case 'Spatial' :
			hideRubberBand();
			var box = "minlong="+ start.x +"&minlat="+ start.y +"&maxlong="+ stop.x +"&maxlat="+ stop.y;
			url += "&"+box;
			diagnostic(url);
			form.setAttribute('action',url);
			form.submit();
			break;
		case 'First' :
			hideRubberBand();
			url += "&getPrevious=0";
			form.setAttribute('action',url);
			form.submit();
			break;
		case 'Return' :
			hideRubberBand();
			var referer = decodeURIComponent(Referer);
			form.setAttribute('action',referer);
			form.submit();
			break;
		case 'ReDraw' :
			hideRubberBand();
			var box = "minlong="+ currentExtent.x1 
				+"&minlat="+ currentExtent.y1 
				+"&maxlong="+ currentExtent.x2 
				+"&maxlat="+ currentExtent.y2;
			url += "&"+box;
			diagnostic(url);
			
			form.setAttribute('action',url);
			form.submit();
			break;
		default :
			break;
	}
}

function downMouse(userEvent)
{
	MouseIsDown = true;
	document.getElementById('LatLongCell').style.color = '#ff0000';	

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
	document.getElementById('LatLongCell').style.color = '#000000';	

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
		var msg = '- -';
		if (xHairs == 'on')
			msg = pad(''+ latLong.y +",", 10) + pad(''+ latLong.x, 10);
		document.getElementById("LatLongCell").innerHTML = msg;
	}
}

function diagnostic(msg)
{
	/*var element = document.getElementById('diagnostics');
	element.style.visibility = 'visible';
	element.innerHTML = msg;*/
}

function setToolHint(state,text)
{
	var element = document.getElementById('ButtonHelpCell');
	element.style.visibility = state;
	element.innerHTML = text;
}

function setButtonOff(id,image)
{
	document.getElementById(id).style.border = '3px outset #7f7f7f';
	document.getElementById(id).style.color = '#7f7f7f';
	document.getElementById(id).style.background = '#000000';
	document.getElementById(id).style.fontWeight = 'lighter';
	document.getElementById(id).style.fontSize = '0.7em';
	document.getElementById(id).setAttribute("src",image)
}

function setButtonOn(id,image)
{
	document.getElementById(id).style.border = '3px inset #ffffff';
	document.getElementById(id).style.color = '#000000';
	document.getElementById(id).style.background = '#d0d0d0';
	document.getElementById(id).style.fontWeight = 'bold';
	document.getElementById(id).style.fontSize = '0.7em';
	document.getElementById(id).setAttribute("src",image)
}


function selectTool(toolSt)
{
	CurrentTool = toolSt;
	setButtonOff('ZoomIn','./mapper/images/zoomin.gif');
	setButtonOff('ZoomOut','./mapper/images/zoomout.gif');
	setButtonOff('Pan','./mapper/images/pan.gif');
	setButtonOff('Query','./mapper/images/query.gif');
	/*setButtonOff('Spatial','./mapper/images/areaquery.gif');*/
	setButtonOff('ReDraw','./mapper/images/redraw.gif');
	/* setButtonOff('Google','./mapper/images/maps_res_logo_but.gif'); */
	setButtonOff('Back','./mapper/images/back.gif');
	setButtonOff('Initial','./mapper/images/first.gif');
	switch (CurrentTool)
	{
		case 'ZoomIn' :
			setButtonOn('ZoomIn','./mapper/images/zoominactive.gif');
			setToolHint('visible','Draw Box To Zoom To');
			break;
		case 'ZoomOut' :
			setButtonOn('ZoomOut','./mapper/images/zoomoutactive.gif');
			setToolHint('visible','Click Map to Zoom Out about Point');
			break;
		case 'Pan' :
			setButtonOn('Pan','./mapper/images/panactive.gif');
			setToolHint('visible','Click Map on New Centre Position');
			break;
		case 'Query' :
			setButtonOn('Query','./mapper/images/queryactive.gif');
			setToolHint('visible','Draw Box Around Records to Query');
			break;
		/*case 'Spatial' :
			setButtonOn('Spatial','./mapper/images/areaqueryactive.gif');
			setToolHint('visible','Query Again using Boxed Boundary');
			break;*/
		case 'ReDraw' :
			setButtonOn('ReDraw','./mapper/images/redrawactive.gif');
			setToolHint('visible','Click Map to ReDraw With New Settings');
			break;
		/*case 'Google' :
			setButtonOn('Google','./mapper/images/googleactive.gif');
			setToolHint('visible','Display data using Google(R) Mapper');
			break; */
		default :
			break;
	}
}





function checkBoxes()
{
	var args = ReferredArguments.split("&amp;");
	for (i=0; i < args.length; i++)
	{
		var param = args[i].split("=");
		var element = document.getElementById(param[0]);
		if (element)
		{
			switch(element.getAttribute('type'))
			{
				case 'radio' :	
					if (param[1] == 'on')
						element.setAttribute('checked',param[1]);
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
	var emuwebPath = "../pages/"+ emuBackend + "/";

	var url = emuwebPath + "ResultsList.php?";
	url += "Where=" + escape("SummaryData CONTAINS '"+ term +"'");
	url += "&QueryPage=" + escape(emuwebPath + "Query.php");
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

function initXHairs()
{
	var h = document.getElementById('xHairH');
	h.style.left = MapLeft;
	h.style.width = MapWidth;
	h.style.top = MapHeight/2;

	var v = document.getElementById('xHairV');
	v.style.left = MapWidth/2;
	v.style.height = MapHeight;
	v.style.top = MapTop;
}

function initRubberBand()
{
	var r = document.getElementById('rubberBand');
	r.style.top = MapHeight/2;
	r.style.left = MapWidth/2;
	RubberBandExtent = new Box(0,0,0,0);				
}

function initLayout()
{
	// set image and calculate absolute screen ccords of map

	var div = document.getElementById('MapCell');
	div.style.backgroundImage = "url("+ Map +")";

	var posTopXy =  findAbsoluteOffset(div);
	MapLeft = posTopXy.x;
	MapTop = posTopXy.y;

	MapHeight = ImgHeight;
	MapWidth = ImgWidth;
	MapBottom = MapTop + MapHeight;
	MapRight = MapLeft + MapWidth;

	div.style.width = ImgWidth;
	div.style.height = ImgHeight;
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

	document.onmousemove = moveMouse;
	document.onmousedown = downMouse;
	document.onmouseup = upMouse;


}

document.onmousedown = null;
