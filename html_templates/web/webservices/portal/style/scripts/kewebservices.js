var Selections = Object();
var UniqueValues = Object();
var Keys = Object();

function debugArray(name,a)
{
	var st = Array();
	for (var v in a)
		st.push("("+ typeof(v) + ") "+ v );
	alert("array:" + name+" =[\n  '"+st.join("',\n  '")+"'\n]");
}

function addToSelection(i)
{
	Selections[i] = 1;
}

function dropFromSelection(i)
{
	Selections[i] = null;
}

function clearSelection()
{
	for (var i in Selections)
		Selections[i] = null;
	var domHelper = new ajax.DomHelper(document);
	var rows = domHelper.getElementsByClass('dataRow marked');
	for (var i=0; i < rows.length; i++)
	{
		rows[i].className = 'dataRow unmarked';
	}
}

function isSelected(i)
{
	return (Selections[i] != null);
}

function returnSelected()
{
	var list = Array();
	for (var i in Selections)
		if (isSelected(i))
		{
			i = i.replace(/^.+_idx_/,'');
			list.push(i);
		}
	return list.join(",");
}

function addToValues(nameSpace,field,value,recordIndexes)
{
	if (!UniqueValues[field])
		UniqueValues[field] = new Object;
	
	var values = UniqueValues[field];
	values[value]++;
	UniqueValues[field] = values;

	var key = nameSpace+":"+field+":"+value;
	Keys[key] = recordIndexes;
}




function selectAllMatching(nameSpace,field,value)
{
	value = value.replace(/\+/," ");
	var unseen = 0;
	var key = nameSpace+":"+field+":"+value;
	if (Keys[key])
	{
		var indices = Keys[key].split(",");
		for (var i=0; i < indices.length; i++)
		{
			addToSelection(indices[i]);
			if (document.getElementById(nameSpace+"_idx_"+indices[i]))
				document.getElementById(nameSpace+"_idx_"+indices[i]).className = "datarow marked";
			else
				unseen++;

		}
		if (unseen == indices.length)
			alert("NB "+unseen +" records marked but not visible on this screen");
	}
	else
	{
		alert("No "+key+" found");
	}
}

var behaviours =  {
		'span.hide' : function(element){
			element.onclick = function(){
				this.hide = ! this.hide
				var destination = this.getAttribute('control');
				if (this.hide)
				{
					new Effect.Fade(document.getElementById(destination)); 
					this.innerHTML = 'Show'
				}
				else
				{
					new Effect.Appear(document.getElementById(destination));
					this.innerHTML = 'Hide'
				}
			} ,	
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
		'span.searchAgain' : function(element) {
			element.onclick = function(){
				var url = this.getAttribute('url');
				location.replace(unescape(url));
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
		'span.help' : function(element) {
			element.onclick = function(){
				alert("THIS NEEDS REWRITING !\n\n"+
					"Click on Column Headings to Sort by that Column\n"+
					"Click on 'Reverse' link to reverse Sort Order\n\n"+
					"Page Up/Down using '+/-' and 'First/Last' links\n\n"+
					"Click on Desired Row to Select/Unselect Record\n\n"+
					"Red 'X' indicates Record currently Selected\n"+
					"Red ID number indicates Record mapped\n\n"+
					"Red Map Dot indicates the Mapped Record is on current Page\n"+
					"Grey Map Dot indicates the Mapped Record is in set but not on current Page\n\n"+
					"To Show currently Selected Records only, click on 'Show Selected' link\n"+
					"'Show All' link will return to full Record Set\n"
			
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

		'.action' : function(element){
			element.onclick = function(){
				var nameSpace = this.getAttribute('nameSpace');

				if (this.getAttribute('name') == 'Select None')
					clearSelection();
				var i = 0;
				// IE doesn't implement hasAttribute so test against null
				while (this.getAttribute('xmlurl_'+i) != null) 
				{
					var xmlurl = this.getAttribute('xmlurl_'+i);
					xmlurl += '&' + nameSpace + '-selected='+returnSelected();
					var xslurl = this.getAttribute('xslurl_'+i);
					var destId = this.getAttribute('destination_'+i);
					var dest = document.getElementById(this.getAttribute('destination_'+i));
					var activity = this.getAttribute('activity');
					//alert("XML: "+xmlurl+"\nXSL: "+xslurl+"\nDEST: "+dest.id);
					//var loader = new ajax.Loader('','');
					//loader.popup("XML: "+xmlurl+"\nXSL: "+xslurl+"\nDEST: "+dest.id);
					if (xmlurl && xslurl && dest)
					{
						var handler = new ajax.XsltHandler(xmlurl,xslurl,activity);
						if (handler != null)
						{
							handler.xsltProcess(dest);
						}
					}
					i++;
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
		},
	
		'tr.dataRow' : function(element){
			element.onmouseover = function(){
				var selected = (this.className.search(/unmarked/) == -1);
				if (selected)
				{
					this.className = 'dataRow markedHover';
				}
				else
				{
					this.className = 'dataRow unmarkedHover';
				}
			},
			element.onmouseout = function(){
				var selected = (this.className.search(/^dataRow unmarked/) == -1);
				if (selected)
				{
					this.className = 'dataRow marked';
				}
				else
				{
					this.className = 'dataRow unmarked';
				}
			},
			element.onclick = function(){
				var index = this.getAttribute('index');

				this.selected = ! (this.className.search(/^dataRow unmarked/) == -1);
				if (this.selected)
				{
					addToSelection(index);
					this.className = 'dataRow marked';
				}
				else
				{
					dropFromSelection(index);
					this.className = 'dataRow unmarked';
				}
			}
		},

		'select.nestedSelect' : function(element) {
			element.onchange = function(){
				var dest = document.getElementById(this.getAttribute('nestedField'));
				var name = this.options[this.selectedIndex].value;
				var values = UniqueValues[name];

				if (dest && name)
				{
					while (dest.options.length)
						dest.remove(0);
					for (var value in values)
					{
						var option = document.createElement('option');
						option.setAttribute("field",name);
						option.setAttribute("value",value);
						option.appendChild(document.createTextNode(value));
						dest.appendChild(option);
					}
				}
			}
		},

		'span.selectors' : function(element) {
			element.onclick = function() {
				var fieldSelect = document.getElementById(this.getAttribute('fieldControl'));
				var valueSelect = document.getElementById(this.getAttribute('valueControl'));
				var nameSpace = this.getAttribute('nameSpace');
				var field = fieldSelect.options[fieldSelect.selectedIndex].value;
				var value = valueSelect.options[valueSelect.selectedIndex].value;
				selectAllMatching(nameSpace,field,value);
			}
		}
};

Behaviour.register(behaviours);

