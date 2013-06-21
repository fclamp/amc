<!-- (C)2000-2005 KE Software -->

var cookies = true;

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

function countSources()
{
	var sources = document.getElementsByTagName("input");
	var sourcesExist = false;
	var totalSources = 0;

	for (var i=0; i < sources.length; i++)
	{
		input = sources[i];
		var id = input.getAttribute("id");
		if (id != null && id.match("chk_"))
		{
			totalSources++;
			if (input.checked)
			{
				sourcesExist = true;
				var source = document.createElement("input");
				source.setAttribute("type","hidden");
				source.setAttribute("name","source[]");
				source.setAttribute("value",input.getAttribute("name") + "=" + i);
				document.forms[0].appendChild(source);
			}
		}
	}

	return sourcesExist;
}

function setCookie(data)
{
	document.cookie = 'keportal=' + data + '; path=/';
}

function readCookie()
{
	if (document.cookie.length > 0)
	{
		var search = "keportal=";
		var offset = document.cookie.indexOf(search);
		if (offset != -1)
		{
			offset += search.length
			var end = document.cookie.indexOf(";", offset)
			if (end == -1)
			{
				end = document.cookie.length;
			}
			var values = unescape(document.cookie.substring(offset, end));
			globalSavedState = values.split("~");
			for (var i=0; i < globalSavedState.length; i++)
			{
				var pair = new Array();
				pair = globalSavedState[i].split('=', 2);
				var input = document.getElementById(pair[0]);
				if (input != null)
				{
					input.value = pair[1];
				}
			}
		}
		else
		{
			//alert("nope - no keportal cookie");
		}
	}
	else
	{
		//alert("nope - no cookies, no nothing");
	}
}


function saveTermsForFutureVisits()
{
	// to maintain state get values in input/select elements for saving in
	// cookie

	var pairs = new Array();
	var inputs = document.getElementsByTagName("input");
	for (var i=0; i < inputs.length; i++)
	{
		if (inputs[i].id.match(/qry_field/))
		{
			if (inputs[i].value != "")
			{
				pairs.push(inputs[i].id + "=" + inputs[i].value);
			}
		}
	}
	setCookie(pairs.join("~"));
}


function generateStructuredRequest()
{

	if (cookies)
	{
		saveTermsForFutureVisits();
	}


	var input;
	var rowNum = 5;

	var stack = new Array();

	var orTerms = 0;
	while (rowNum >= 0)
	{
		var rowUsed = 0;
		var row = document.getElementById("qryRow_" + rowNum);
		if (row)
		{
			var inputs = row.getElementsByTagName("input");

			for (var i=0; i < inputs.length; i++)
			{
				input = inputs[i];
				var field = input.getAttribute("field");
				var fieldType = input.getAttribute("type");
				op = "contains";
				if (fieldType != "string")
					op = "equals";
				var value = input.value;
				if (value.length > 0)
				{
					stack.push("<comparison type='" + op + "'><field>" + field + "</field><value>" + value + "</value></comparison>");
					if (rowUsed++ > 0)
					{
						stack.push("<logicalOperator type='and' />");
					}
				}	
			}
			if (rowUsed > 0 && orTerms > 0)
			{
				stack.push("<logicalOperator type='or' />");
			}
			else if (rowUsed > 0)
			{
				orTerms++;
			}

		}
		rowNum--;
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
	/*var start = document.getElementById("start").value;
	var order = document.getElementById("order").value;
	var sortby = document.getElementById("sortby").value;*/
	var limit = document.getElementById("limit").value;

	var description = "Set of up to " + limit + " matching records ";
	if (document.getElementById("scatterTrue").checked)
		description += " sampling across sources";
	else
		description += " sampling from sources in priority order";


	document.forms[0].dataSetDescription.value = description;
}

function moveToActual(element)
{
	var cb = document.getElementById("chk_" + element.getAttribute("srcName"));
	var currentClass = element.getAttribute("class");

	var destinationHolder = null;

	if (currentClass == 'actual')
	{
		destinationHolder = document.getElementById('potential');
		element.setAttribute("class","potential");
		cb.checked = false;
	}
	else
	{
		destinationHolder = document.getElementById('actual');
		element.setAttribute("class","actual");
		cb.checked = true;
	}

	destinationHolder.appendChild(element);
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

var behaviours =  {
	'.makeStructuredRequest' : function(element) {
		element.onclick = function(){
			if (! countSources())
			{
				alert("You must select at least one data source !");
				return;
			}
			
			var request = generateStructuredRequest()
			if (request.length > 0)
			{
				startCountdown();
				document.forms[0].structuredQuery.value = request;
				makeSetDescription();
				document.forms[0].submit();
				//showArgs();
			}
			else
				alert("You must enter query Terms !");
		}
	},
	'.potential' : function(element) {
		element.onclick = function(){
			moveToActual(this);
		}
	},
	'.sampleValues' : function(element) {
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
	'.queryHelp' : function(element) {
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
	'.clear' : function(element) {
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

};

Behaviour.register(behaviours);

if (cookies)
{
	readCookie();
}	

