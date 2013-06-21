<html xsl:version="1.0"
        xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<head>
		<title>Webservices <xsl:value-of select='//response/@component'/> Error</title>
	</head>
	<body>
		<h2>KE Software Webservices</h2>
		<b>Generating application: </b> <xsl:value-of select='//response/@component'/> <br/>
		<b>Status: </b><xsl:value-of select='//response/@status'/><br/>
		<hr/>
		<p>
			<xsl:value-of select='//message'/>
		</p>
		<hr/>

	</body>
</html>
