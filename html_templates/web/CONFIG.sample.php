<?php $APPLICATION = 'KE EMu Web';

/***********************************************************
**
**	Config for KE Web PHP pages. Modify with care.  
**
************************************************************/


/*
** Texxmlserver hostname/address.  This is "localhost" if EMu is running on
**   the same system as the web server.
**  example = "kembla.mel.kesoftware.com";
*/ 
$XML_SERVER_HOST	= "localhost";


/*
** Texxmlserver port number as defined in etc/config on the EMu 
**   database server.
*/
$XML_SERVER_PORT	= 30024;   // amlive's assigned web port


/*
** Set this if the name of the Link or "Virtual Directory" in 
**   the web document root is not the default 'web'
*/
//$WEB_DIR_NAME 	= "emuwebamlive";

/*
** EMu Catalogue backend type.
*/
$BACKEND_TYPE		= "am";


/*
** These settings are used by the remote "WebServices" interfaces.
** They allow other websites to query the database via an
** XML API.
*/
$ENABLE_WEBSERVICES = 1;

$WEBSERVICES_BASIC_INTERFACE = '
        <interface name="default">
                <Password></Password>
                <QueryColumns>AdmWebMetadata,SummaryData</QueryColumns>
                <Database>ecatalogue</Database>
                <ExtraReturnColumns></ExtraReturnColumns>
                <MaximumRetrievalLimit>100</MaximumRetrievalLimit>
        </interface>
	<interface name="narratives">
                <QueryColumns>AdmWebMetadata,SummaryData</QueryColumns>>
                <Database>enarratives</Database>
                <CatagoryColumn>DesType:1</CatagoryColumn>
                <MaximumRetrievalLimit>100</MaximumRetrievalLimit>
        </interface>
        <interface name="notes">
                <Password>mypassword</Password>
                <QueryColumns>NotNotes</QueryColumns>
                <Database>ecatalogue</Database>
                <ExtraReturnColumns>NotNotes</ExtraReturnColumns>
                <CatagoryColumn>TitObjectType</CatagoryColumn>
                <MaximumRetrievalLimit>100</MaximumRetrievalLimit>
        </interface>
';

$WEBSERVICES_DUBLIN_CORE_INTERFACE = 
'<interface name="default">
	<Database>ecatalogue</Database>
	<NameColumn>TitMainTitle</NameColumn>
	<DescriptionColumn>SummaryData</DescriptionColumn>
	<DCMapping>
		<Title>
			<Col type="text">TitMainTitle</Col>
		</Title>
		<Creator>
			<Col type="text">CreCreatorRef_tab-&gt;eparties-&gt;SummaryData</Col>
		</Creator>
	</DCMapping>
</interface>';



/*
** A secondary Texxserver can be defined to introduce some basic 
**   fallover support.  Note that this does not have to be a separate
**   physical system. 
*/
//$XML_SECONDARY_SERVER_HOST	= "myserver.com";
//$XML_SECONDARY_SERVER_PORT	= 8002;

/*
** Application and administration settings.
*/
$ADMIN_PASSWORD		= "keemu";
$DEFAULT_LANGUAGE	= "english";

/*
** see http://php.net/manual/en/function.date-default-timezone-set.php
*/
$TIMEZONE               = "America/New_York";

/* Watermark Information
**
**  The Watermark logo needs to be placed in:	
**		web/pages/$BACKEND_TYPE/images/
**
**  Opacity: 100 = Not Transparent
**           0   = Totally Transparent
**
**  Percentage: 25 = Watermark size will be 25% of the Image its overlaying. 
*/ 
#$DEFAULT_WATERMARK	= "";
#$DEFAULT_WATERMARK_LOGO                 = "kelogo.png";
#$DEFAULT_WATERMARK_OPACITY              = 50;
#$DEFAULT_WATERMARK_PERCENTAGE           = 25;
/* Watermark logo position
** Options:
** 'tl'  - top left
** 'tr'  - top right
** 'bl'  - bottom left
** 'br'  - bottom right
** 'tm'  - top middle
** 'bm'  - bottom middle
** 'center' - center
*/
#$DEFAULT_WATERMARK_LOGO_POSITION        = 'br';

/*
** LANGUAGE_SHOW_FIRST_FILLED allowed the web interface to override
** the "show first filled" setting in the registry.  Comment this out if you
** would like the web to behave the same way as the client.
** Valid values: 0 or 1 
*/
$LANGUAGE_SHOW_FIRST_FILLED = 1;
$LANGUAGE_DELIMITER 	= ";:;";

/*
** If the display objects use security, users can be classed into groups 
**   as defined here. Uncomment and use the PHP array syntax.
*/
//$USER_GROUPS = array(
//	'admin" 	=> "administrators",
//	"bob"		=> "guest",
//	"mary"		=> "curators",
//	);

/*
** Initial Image Size. This determines the initial size of the image displayed
** 	in imagedisplay.php when the user clicks on a thumbnail in a display
**	page. The image of closest of smaller size is selected.
*/
$INITIAL_IMAGE_WIDTH = 340;

/* Uncomment this line if you would like image thumbnails to link straight to
**   the image itself, and not to an alternative display page (such
**   as imagedisplay.php). Uncommenting this will revert EMuWeb back to it's
**   legacy behaviour
*/
//$LINK_DIRECT_TO_IMAGE = 1;

/*
** Max Internet/Intranet image side. Specifies the length of the longest side
**	of an image that is to be displayed on the Internet/Intranet. Any
**	images with a side longer than that specified will not be shown on the
**	web. Make sure multimedia records have plenty of available resolutions
**	if you use this.
*/
//$MAX_INTERNET_IMAGE_SIDE = 600;
//$MAX_INTRANET_IMAGE_SIDE = 600;

/*
** Display debug messages.  For development use only.
**	Uncomment to use.
*/
//$DEBUG = 1;


?>
