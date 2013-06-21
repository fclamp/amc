

var socitm_ratio = 5;
var socitm_popup = "";
var socitm_my_domains_tmp = "";
var socitm_popup_css = "";
var socitm_protocol = "http:";
var cookie_suffix = "2";

if (socitm_my_domains_tmp.length > 0) { socitm_my_domains = socitm_my_domains_tmp; }

if ((document.location.search.indexOf("SocitmForcePop") > -1)||(Math.floor((Math.random() * (typeof(socitm_ratio) != "undefined" ? socitm_ratio : 5))) == 0) || getCookie("socitm_include_me") == "true") {
    document.write('<script type="text/javascript" src="'+ socitm_protocol +'//socitm.govmetric.com/js/jquery.js"><\/script>');
    document.write('<script type="text/javascript" src="'+ socitm_protocol +'//socitm.govmetric.com/js/socitm_popups.aspx"><\/script>');
    document.write('<script type="text/javascript" src="'+ socitm_protocol +'//socitm.govmetric.com/popcounter.aspx'+sArg+'"><\/script>');
    document.write('<link rel="stylesheet" type="text/css" href="'+ socitm_protocol +'//socitm.govmetric.com/css/socitm.css" />');
}

function getCookie(c_name)
{
	if (document.cookie.length>0)
	{
		c_start=document.cookie.indexOf(c_name+cookie_suffix+"=");
		if (c_start!=-1)
		{ 
			c_start=c_start+c_name.length+cookie_suffix.length+1; 
			c_end=document.cookie.indexOf(";",c_start);
			if (c_end==-1) c_end=document.cookie.length;
			return unescape(document.cookie.substring(c_start,c_end));
		} 
	}
	return "";
}

function setCookie(c_name,value,expiredays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie=c_name+cookie_suffix+"=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString()) +";path=/";
}