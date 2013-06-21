/*
 * (C) 2005-2006 KE Software
 *
 * common javascript code to assist in handling ajax, xslt and dom manipulation
 *
 */
var ajax = new Object();

ajax.UNINITIALIZED= 0;
ajax.LOADING      = 1;
ajax.LOADED       = 2;
ajax.INTERACTIVE  = 3;
ajax.COMPLETE     = 4;

ajax.message = new Object();
ajax.message[0] = "Initialised";
ajax.message[1] = "loading";
ajax.message[2] = "loaded";
ajax.message[3] = "interactive";
ajax.message[4] = "complete";

ajax.cachedValues = new Object();

ajax.Loader = function(url, method, params, callback)
{
   this.url           = url;
   this.params 	      = params;
   this.method        = method;
   this.callback      = callback;
}

ajax.Loader.prototype = 
{
	popup: function(content)
	{
	    	top.consoleRef=window.open('','debug',
	    'width=350,height=250'
	    +',menubar=0'
	    +',toolbar=1'
	    +',status=0'
	    +',scrollbars=1'
	    +',resizable=1')
	    content.replace(/</,"&lt;");
	    content.replace(/>/,"&gt;");
	    content.replace(/\t*/," ");
	    content.replace(/  */," ");
	    top.consoleRef.document.writeln(
	    	'<html><head><title>Debug</title></head>'
	     	+'<body><h3>DEBUG</h3>'
		+'<pre>'
	        + content
		+'/<pre>'
		+'</body></html>'
	    );
	    top.consoleRef.document.close();
	},

	request: function(handler)
	{
   		this.transport = this.getTransport();
		if ( this.transport )
		{
			try
			{
				// set handler
				var loader = this;
				this.transport.onreadystatechange = function() { loader.handler(); };
				// open connection
				this.transport.open(this.method,this.url,true);
				// send request
				this.transport.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				this.transport.send(this.params);
			}
			catch(err)
			{
				alert("Error: Transport failed");
			}
			
		}
	},

	getResponse: function()
	{
		//this.popup("response\n"+this.transport.responseText);
		return this.transport.responseXML;
	},

	handler: function()
	{
		var ready = this.transport.readyState;
		//alert("state = "+ajax.message[ready]);
		if (ready == ajax.COMPLETE)
		{
			this.callback();
		}
	},

   	getTransport: function()
	{
      		var transport;
      		if ( window.XMLHttpRequest )
         		transport = new XMLHttpRequest();
      		else if ( window.ActiveXObject ) {
         		try {
            			transport = new ActiveXObject('Msxml2.XMLHTTP');
         		}
         		catch(err) {
            			transport = new ActiveXObject('Microsoft.XMLHTTP');
         		}
      		}
      		return transport;
   	}

};


ajax.XsltHandler = function(xmlUrl, xslUrl, activity)
{
   this.xmlUrl = xmlUrl;
   this.xslUrl = xslUrl;
   this.activityElement = document.getElementById(activity);

   this.xml = null;
   this.xsl = null;
   this.destination = null;
}

ajax.XsltHandler.prototype = 
{

	xsltProcess: function(destination)
	{
		this.xml = null;
		this.xsl = null;

		this.destination = destination;

		this.activityElement.setAttribute('src','images/activity_anim.gif');
		if (ajax.cachedValues[this.xmlUrl] != undefined)
		{
			this.xml = ajax.cachedValues[this.xmlUrl];
			this.transform();
		}
		else
		{
			var xsltObject = this;
			var loader = new ajax.Loader(this.xmlUrl,"GET","",
				function() {
					// NB when exectuted, 'this' will equal the ajax.Loader
					// object 
					xsltObject.xml = this.getResponse();
					xsltObject.transform();
				}
			);
			loader.request();
		}
		if (ajax.cachedValues[this.xslUrl] != undefined)
		{
			this.xsl = ajax.cachedValues[this.xslUrl];
			this.transform();
		}
		else
		{
			var xsltObject = this;
			loader = new ajax.Loader(this.xslUrl,"GET","",
				function() {
					// NB when exectuted, 'this' will equal the ajax.Loader
					// object 
					xsltObject.xsl = this.getResponse();
					xsltObject.transform();
				}
			);
			loader.request();
		}	
		return true;
	},


	setupXsltProcessor: function()
	{
		var xsltProcessor = new XSLTProcessor();
		if (xsltProcessor)
		{
			try {
				xsltProcessor.reset();
				xsltProcessor.importStylesheet(this.xsl);
			}
			catch(err)
			{
				alert("Error with stylesheet: "+this.xslUrl+" \n"+err);
				return false; 
			}
		}
		return xsltProcessor;

	},


	transform: function()
	{
		// don't act unless we have both xml and xsl - these being
		// brought back asynchronously
		if (this.xml == null || this.xsl == null)
			return false;

		// cache values to save time if used at later time
		ajax.cachedValues[this.xmlUrl] = this.xml;
		ajax.cachedValues[this.xslUrl] = this.xsl;


		// do either mozilla or microsoft transform and replacement
		if (window.XMLHttpRequest && window.XSLTProcessor )
		{
			xsltProcessor = this.setupXsltProcessor();
			if (xsltProcessor)
			{
				try
				{
					// want to minimise 'jitter' when replacing contents of a node
					// so do a kind of double buffering

					var frag = xsltProcessor.transformToFragment(this.xml,document);
					var fragHolder = this.destination.cloneNode(false);
					fragHolder.appendChild(frag);
					if (this.destination.parentNode)
						this.destination.parentNode.replaceChild(fragHolder,this.destination);
					else
						alert("No parent for"+ this.destination.id);

					Sortable.create('body',{tag:'div', constraint:false});
					this.activityElement.setAttribute('src','images/activity_ok.gif');
					Behaviour.apply();
					return true;
				}	
				catch(err)
				{
					alert("Error transforming xml: "+ err);
					return false; 
				}
			}
			else
			{
				alert("Error creating xslt processor");
				return false; 
			}
		}
		else 
		{	
			if ( window.ActiveXObject )
			{
				try {
					var xslDoc = new ActiveXObject("Msxml2.FreeThreadedDOMDocument.3.0");

					var xslProc;
					xslDoc.async = false;
					xslDoc.load(this.xslUrl);
					if (xslDoc.parseError.errorCode != 0)
					{
						var myErr = xslDoc.parseError;
						alert("Error: " + myErr.reason);
					}
					else
					{
						var xslt = new ActiveXObject("Msxml2.XSLTemplate.3.0");
						xslt.stylesheet = xslDoc;
						var xmlDoc = new ActiveXObject("Msxml2.DOMDocument.3.0");
						xmlDoc.async = false;
						xmlDoc.load(this.xmlUrl);
						if (xmlDoc.parseError.errorCode != 0)
						{
							var myErr = xmlDoc.parseError;
							alert("Error: " + myErr.reason);
						}
						else
						{
							xslProc = xslt.createProcessor();
							xslProc.input = xmlDoc;
							xslProc.transform();
					
							var fragHolder = this.destination.cloneNode(false);
							fragHolder.innerHTML = "";
							fragHolder.innerHTML = xslProc.output;
							if (this.destination.parentNode)
								this.destination.parentNode.replaceChild(fragHolder,this.destination);
							else
								alert("No parent for"+ this.destination.id);
						}
					}
					
					Behaviour.apply();
					document.getElementById('activity').setAttribute('src','images/activity_ok.gif');
					return true;
				}
				catch(err)
				{
					alert("Error transforming with stylesheet: "+this.xslUrl+" \n"+err);
					return false; 
				}
			}
			else
				return false; 
		}
	},

	isXsltSupported: function ()
	{
	   if (window.XMLHttpRequest && window.XSLTProcessor )
	   	return true;

	   if ( ! window.ActiveXObject )
	      return false;

	   try 
	   {
	   	new ActiveXObject("Microsoft.XMLDOM");
		return true; 
	   }
	   catch(err) 
	   {
	   	return false;
	   }
	},

	xmlObjToText: function (xml)
	{
    		var text;

		try
		{
			var serializer = new XMLSerializer();
			text = serializer.serializeToString(xml);
		} 
		catch(e)
		{
			// IE only
			text = xml.xml;
		}
		return text;
	}

}

ajax.DomHelper = function(document)
{
	this.document = document;
}

ajax.DomHelper.prototype = 
{
	getElementsByClass: function (searchClass,node,tag)
	{
		var classElements = new Array();
		if ( node == null )
			node = this.document;
		if ( tag == null )
			tag = '*';
		var elements = node.getElementsByTagName(tag);
		var elementsLen = elements.length;
		var pattern = new RegExp("(^|\s)"+searchClass+"(\s|$)");
		for (i = 0, j = 0; i < elementsLen; i++)
		{
			if ( pattern.test(elements[i].className) )
			{
				classElements[j] = elements[i];
				j++;
			}
		}
		return classElements;
	}
};
