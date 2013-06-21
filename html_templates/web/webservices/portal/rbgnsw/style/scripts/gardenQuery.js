<!-- (C)2000-2008 KE Software -->

// globals
//var gAutoCompleters = new Array();
var comboActive = null;

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

function fillExamples(count,terms,sources)
{
	var andList = terms.split(",");
	var srcList = sources.split("~");

	for(var j = 0; j < andList.length; j++)
	{
		var qField = andList[j];
		if (qField)
		{
			var options = document.getElementById(qField+"_examples");
			if (options.value)
			{
				var values = options.value.split(":");
				for(var i = 0; i < count; i++)
				{
					if (i < values.length)
					{
						var sourceCheckBox = document.getElementById("chk_"+srcList[i]);
						if (sourceCheckBox && sourceCheckBox.checked)
						{
							var field = "qry_field:"+ qField +"_"+ i;
							var inputElement = document.getElementById(field);
							if (inputElement)
							{
								inputElement.value = values[i];
							}
						}	
					}
				}
			}
		}
	}
}	


function generateStructuredRequest()
{
	var input;
	var stack = new Array();

	var row = document.getElementById("query_terms");
	if (row)
	{
		var inputs = row.getElementsByTagName("input");

		for (var i=0; i < inputs.length; i++)
		{
			input = inputs[i];
			var field = input.getAttribute("field");
			if (field != null)
			{
				var fieldType = input.getAttribute("type");
				op = "contains";
				if ((fieldType != "string") && (fieldType != "text"))
					op = "equals";
				var value = input.value;
				if (value.length > 0)
				{
					stack.push("<comparison type='" + op + "'><field>" + field + "</field><value>" + value + "</value></comparison>");
					if (stack.length > 1)
					{
						stack.push("<logicalOperator type='and' />");
					}
				}	
			}
		}
	}

	var xml = "<query>\n<select><field>*</field></select>\n<sources><source>ecatalogue</source></sources>\n<postfixFilterStack>\n";

	var l = stack.length;

	if (l == 0)
		return "";

	for (var i = 0; i < stack.length; i++)
	{
		xml += "<stackItem level='" + --l + "'>" + stack[i] + "</stackItem>\n";
	}
	xml += "</postfixFilterStack>\n";
	var start = document.getElementById("start").value;
	var limit = document.getElementById("limit").value;
	xml += "<limits from='" + start + "' to='" + limit + "' />";
	xml += "</query>\n";
	return xml;
}


function decTimer()
{
	document.getElementById("remaining").style.visibility = "visible";	

	var timeElement = document.getElementById("timer");
	var current = timeElement.value;
	current = timeElement.firstChild.nodeValue;
	if (isNaN(current))
	{
		current = document.getElementById("timeout").value;
	}
	else if (current <= 0)
	{
		current = 1;
		timeElement.style.backgroundColor = '#ff0000';
		timeElement.style.color = '#000000';
	}
	else if (current < 5)
	{
		timeElement.style.backgroundColor = '#ff7f7f';
		timeElement.style.color = '#000000';
	}
	else if (current < 10)
	{
		timeElement.style.backgroundColor = '#ffaaaa';
		timeElement.style.color = '#000000';
	}
	timeElement.firstChild.nodeValue = --current;
}

function startCountdown()
{
	intervalId = setInterval ( "decTimer()", 1010 );
}

function makeSetDescription()
{
	var limit = document.getElementById("limit").value;
	var description = "Set of up to " + limit + " matching records";
	document.forms[0].dataSetDescription.value = description;
}


function showArgs()
{
	var sources = document.forms[0].getElementsByTagName("input");
	data = "";
	for (var i=0; i < sources.length; i++)
	{
		input = sources[i];
		var name = input.getAttribute("name");
		if (name != null)
		{
			data += name;
			data += " " + input.getAttribute("type");
			data += " =  " + input.getAttribute("value");
			if (input.getAttribute("type") == 'checkbox')
			{
				data += " ( checked = " + input.checked + ")";
			}
			data += "\n";
		}
	}
	alert(data);
}

function addItems(drop, name)
{
	document.getElementById("spinner").style.display = "inline";
	drop.options[0].selected = false;

	var loader = new ajax.Loader("./ajax/rbgnsw/getLookupLists.php?level=" + name, "GET","",
		function() {
			// NB when exectuted, 'this' will equal the ajax.Loader
			// object 

			var doc = this.transport.responseXML;

			var items = doc.getElementsByTagName('li');
			for (var i = 0; i < items.length; i++)
			{
				var text = items[i].firstChild.nodeValue;
				var item = document.createElement('option');
				item.className = "comboSelectOption";
				item.setAttribute("name", "option_" + (+1+i));
				item.setAttribute("value", text);
				item.style.color = '#339933';
				item.appendChild(document.createTextNode(text));
				drop.appendChild(item);
			}
			if (drop.options.length > 1)
				drop.options[1].selected = true;
			else	
				drop.options[0].selected = true;

			document.getElementById("spinner").style.display = "none";
			drop.focus();	
		}
	);	
	loader.request();
}

function activateDropDown(inputElement, dropDownHolder)
{
	document.getElementById("spinner").style.display = "inline";

	dropDownHolder.style.top = "0px";
	dropDownHolder.style.left = "0px";

	var select = dropDownHolder.childNodes[0];
	if (select.options.length <= 1)
		addItems(select, select.getAttribute("id"));

	var top = inputElement.offsetTop + inputElement.offsetHeight;
	var left = inputElement.offsetLeft;
	left += 22; // width of activation button
	while (inputElement.offsetParent != document.body)
	{
		inputElement = inputElement.offsetParent;
		top += inputElement.offsetTop;
		left += inputElement.offsetLeft;
	}
	dropDownHolder.style.left = left + 'px';
	dropDownHolder.style.top = top + 'px';

	dropDownHolder.style.display = "block";

	//select.focus();	
	document.getElementById("spinner").style.display = "none";
}

function deActivateDropDown(inputElement, dropDownHolder)
{
	dropDownHolder.style.display = 'none';
	inputElement.focus();	
	comboActive = null;
}

function focusDropdown(comboBox)
{
	document.getElementById("spinner").style.display = "inline";

	deFocusDropdown(comboActive);

	comboActive = comboBox;

	var textInput = comboBox.childNodes[0];
	var selectHolder = comboBox.childNodes[2];

	selectHolder.style.top = "0px";
	selectHolder.style.left = "0px";

	var select = selectHolder.childNodes[0];
	if (select.options.length <= 1)
		addItems(select, comboBox.getAttribute("field"));

	var top = textInput.offsetTop + textInput.offsetHeight;
	var left = textInput.offsetLeft;
	while (textInput.offsetParent != document.body)
	{
		textInput = textInput.offsetParent;
		top += textInput.offsetTop;
		left += textInput.offsetLeft;
	}
	selectHolder.style.left = left + 'px';
	selectHolder.style.top = top + 'px';

	selectHolder.style.display = "block";

	select.focus();
	document.getElementById("spinner").style.display = "none";
}

function deFocusDropdown(comboBox)
{
	if (comboBox != null)
	{
		var textInput = comboBox.childNodes[0];
		var selectHolder = comboBox.childNodes[2];
		var select = selectHolder.childNodes[0];
		textInput.value = select.options[select.selectedIndex].value;
		selectHolder.style.display = 'none';
		textInput.focus();	
		comboActive = null;
	}
}

var behaviours =  {
	'.comboDropButton' : function(element)
	{
		element.onclick = function()
		{
			focusDropdown(this.parentNode);
			return false;
		}

	},
	'.makeStructuredRequest' : function(element)
	{
		element.onclick = function()
		{
			
			var request = generateStructuredRequest()
			if (request.length > 0)
			{
				startCountdown();
				document.forms[0].structuredQuery.value = request;
				makeSetDescription();
				//showArgs();
				document.forms[0].submit();
			}
			else
				alert("You must enter query Terms !");
		}
	},

	'.sampleValues' : function(element)
	{
		element.onclick = function(){
			fillExamples(
				this.getAttribute('orTermsCount'),
				this.getAttribute('andTerms'),
				this.getAttribute('andSources')
			);
		}
		element.onmouseover = function(){
			this.col =  this.style.color;
			this.style.textDecoration = 'underline';
			this.style.color = '#7f7f7f';
		},
		element.onmouseout = function(){
			this.style.color = this.col;
			this.style.textDecoration = 'none';
		}
	},	

	'.queryHelp' : function(element)
	{
		element.onclick = function(){
			alert("Enter Terms to search for\n"+
				"and Select Sources to Query.\n"+
				"Terms on the same line are 'ANDed'\n"+
				"and all the lines are then 'ORed'.\n\n"+
				"THIS NEEDS REWRITING !"
			);
		},
		element.onmouseover = function(){
			this.col =  this.style.color;
			this.style.textDecoration = 'underline';
			this.style.color = '#7f7f7f';
		},
		element.onmouseout = function(){
			this.style.color = this.col;
			this.style.textDecoration = 'none';
		}
	},

	'.clear' : function(element)
	{
		element.onclick = function(){
			var inputs = document.getElementsByTagName("input");
			for (var i = 0; i < inputs.length; i++)
			{
				if (inputs[i].getAttribute('type') == 'text')
				{
					inputs[i].value = "";
				}
			}
		},
		element.onmouseover = function(){
			this.col =  this.style.color;
			this.style.textDecoration = 'underline';
			this.style.color = '#7f7f7f';
		},
		element.onmouseout = function(){
			this.style.color = this.col;
			this.style.textDecoration = 'none';
		}
	}

	,
	'.comboDropList' : function(element){
		element.onchange = function(ev)
		{
			deFocusDropdown(comboActive);
		}
	},	
	'.comboInputText' : function(element){
		element.onfocus = function(ev)
		{
			deFocusDropdown(comboActive);
		}
	},
	'body' : function(element){
		element.onclick = function(ev)
		{
			ev = ev || window.event;
			var target = ev.target || ev.srcElement;
			if (target.parentNode != comboActive)
				deFocusDropdown(comboActive);
		}
	}	


};

function init()
{
	document.getElementById("spinner").style.display = "inline";
	
	/* this stuff for dynamically creating combo boxes - revisit later
	 *
	var inputs = document.getElementsByTagName("div");
	for (var i=0; i < inputs.length; i++)
	{
		if (inputs[i].className == "inputHolder")
		{
			var field = inputs[i].getAttribute("field");
			var dataType = inputs[i].getAttribute("dataType");
		
			var input = document.createElement('input');
			input.setAttribute("type","text"); 
			input.setAttribute("size","10"); 
			input.className = "comboInputText"; 
			inputs[i].appendChild(input);

			var button = document.createElement('input');
			button.setAttribute("type","button");
			button.className = "comboDropButton";
			button.setAttribute("hidefocus","1");
			button.setAttribute("onClick","alert('X')");
			button.setAttribute("value","X");
			inputs[i].appendChild(button);

			var selectHolder = document.createElement('div');
			selectHolder.className = "selectHolder";

			var select = document.createElement('select');
			select.setAttribute("size","5");
			select.setAttribute('id',field);
			select.setAttribute("field",field);
			select.setAttribute("datatype",dataType);

			var blankOption = document.createElement('option');
			blankOption.setAttribute("name", "option_0");
			blankOption.setAttribute("value", "");
			blankOption.appendChild(document.createTextNode(""));

			select.appendChild(blankOption);
			selectHolder.appendChild(select);
			inputs[i].appendChild(selectHolder);
			//addItems(select,field);
		}


	
	}
	Behaviour.register(behaviours);
	*/

	document.getElementById("spinner").style.display = "none";
}


Behaviour.register(behaviours);

addLoadEvent(init);

