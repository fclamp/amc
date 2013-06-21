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

function showDot(txt)
{
	var mapDiv = document.getElementById("mapHolder");
	var areas = mapDiv.getElementsByTagName('div');
	for (var i = 0; i < areas.length; i++)
	{
		var area =  areas[i];
		var id = area.getAttribute("id"); 
		if (id && id.match(/^k-/))
		{
			var pattern = new RegExp(",{0,1}" + txt + ",{0,1}");
			if (id.match(pattern))
			{
				area.style.backgroundColor = 'transparent';
				area.style.borderColor = 'white';
				area.style.borderWidth = '2px';
				area.style.borderStyle = 'solid';
				area.style.visibilty = 'visible';
			}
			else
			{
				area.style.backgroundColor = 'transparent';
				area.style.borderColor = 'transparent';
				area.style.borderWidth = '0px';
				area.style.visibility = 'visible';
			}
		}
	}
}

function loadMap()
{
		var mapHolder = document.getElementById("mapHolder");

		if (mapHolder != null)
		{
			var mapWidth = mapHolder.getAttribute("mapWidth");
			var mapHeight = mapHolder.getAttribute("mapHeight");
			var texqlMapArgs = mapHolder.getAttribute("texqlMapArgs");
			var mapArgs = mapHolder.getAttribute("mapArgs");
			var minLat = mapHolder.getAttribute("minLat");
			var maxLat = mapHolder.getAttribute("maxLat");
			var minLong = mapHolder.getAttribute("minLong");
			var maxLong = mapHolder.getAttribute("maxLong");

			var url = "./simplemap.php?minlong=" + minLong +
					"&minlat=" + minLat +
					"&maxlong=" + maxLong +
					"&maxlat=" + maxLat +
					"&" + texqlMapArgs + "&" + mapArgs +
					"&width=" + mapWidth +
					"&height=" + mapHeight;

			var ip = '<br/><div>(C)2005-2008 KE Software <div>' +
				/*'<img border="0" alt="KE EMu" src="./images/productlogo.gif" width="134" height="48"/>' +
				'<img border="0" alt="KE Software" src="./images/companylogo.gif" width="60" height="50"/>' +*/
				'</div>';



			var loader = new ajax.Loader(url,"GET","",
				function()
				{
					var html = this.transport.responseText;
					document.getElementById("mapHolder").innerHTML = html + ip;
				});
			loader.request();
		}
		else
		{
			alert("Woah");
		}	
}


function getScrollY()
{
        var scrollY = 0;
        if( document.documentElement && document.documentElement.scrollTop )
	{
            scrollY = document.documentElement.scrollTop;
        }
        else if( document.body && document.body.scrollTop )
	{
            scrollY = document.body.scrollTop;
        }
        else if( window.pageYOffset )
	{
            scrollY = window.pageYOffset;
        }
        else if( window.scrollY )
	{
            scrollY = window.scrollY;
        }
        return scrollY;
}

function adjustMapPos()
{
	/* IE won't do position relative so we have to do floating scroll
	 * stuff */

	var scrollY = getScrollY();
	var map = document.getElementById("mapHolder");
	if (map)
	{
		var mapTop = map.style.top.replace(/px/,"");
		if (mapTop == "")
			mapTop = 100;

		// if near the top of scroll and map is high on page, reset to
		// somewhere pleasant
		if ((scrollY < 200) && (mapTop < 220))
		{
			map.style.top = '200px';
			return;
		}
	
		var error = (scrollY - mapTop);
		// if map close to where it should be that'll do
		if (Math.abs(error) < 15)
		{
			map.style.top = scrollY + 'px';
			return
		}

		
		// if map a long way off move it quickly (if close move slowly)

		// start slow...
		var speed = 1/6;
		if (Math.abs(error) > 400)
			speed = 1;
		if (Math.abs(error) > 100)
			speed = 1/3;

		var step = error * speed;

		map.style.top = (+mapTop + step) + 'px';
	}
}

var behaviours =  
{
		'tr.zebraOdd' : function(element){
			element.onmouseover = function()
			{
				this.col =  this.style.color;
				this.style.textDecoration = 'underline';
				this.style.color = '#8f6f6f';
				showDot(this.getAttribute("irn"));
				//adjustMapPos();
			},
			element.onmouseout = function()
			{
				this.style.color = this.col;
				this.style.textDecoration = 'none';
				showDot(this.getAttribute("ALLOFF"));
			}
			element.onclick = function()
			{
				var link = "./oaix.php" + 
					"?verb=GetRecord&" +
					"metadataPrefix=oai_emu&" +
					"identifier=oaix:kesoftware.com:EMu.RBGNSW.catalogue.irn." +
					this.getAttribute("irn");
				window.location.href = link;
			}	
		},
		'tr.zebraEven' : function(element){
			element.onmouseover = function()
			{
				this.col =  this.style.color;
				this.style.textDecoration = 'underline';
				this.style.color = '#8f6f6f';
				showDot(this.getAttribute("irn"));
				//adjustMapPos();
			},
			element.onmouseout = function()
			{
				this.style.color = this.col;
				this.style.textDecoration = 'none';
				showDot(this.getAttribute("ALLOFF"));
			}
			element.onclick = function()
			{
				var link = "./oaix.php" + 
					"?verb=GetRecord&" +
					"metadataPrefix=oai_emu&" +
					"identifier=oaix:kesoftware.com:EMu.RBGNSW.catalogue.irn." +
					this.getAttribute("irn");
				window.location.href = link;
			}
		}
};

function init()
{

	loadMap();

	intervalId = setInterval ( "adjustMapPos()", 50 );

}


addLoadEvent(init);

Behaviour.register(behaviours);




