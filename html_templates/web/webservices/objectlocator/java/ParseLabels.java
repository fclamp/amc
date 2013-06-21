/**
 * KE Software Pty Ltd 2005
 * Parse Labels
 */

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

/**
 * @author martin
 * 
 */
public class ParseLabels extends DefaultHandler
{
	private String state = "";
	
	private final String STARTING_STATE = "starting";

	private final String FINISHED_STATE = "finished";

	private final String OTHER_STATE = "other";
	
	private final String READING_FIELD_STATE = "readingfield";
	
	private String module = "";
	
	private String fieldName = "";
	
	private StringBuffer fieldLabel = null;
	
	// the fields passed are the fields wanted back from the document
	public ParseLabels()
	{

	}
	
	// start document
	public void startDocument() throws SAXException
	{
		state = STARTING_STATE;
	}

	
	public void endDocument() throws SAXException
	{
		state = FINISHED_STATE;
	}

	// start tag element
	public void startElement(String namespaceURI, String localName,
			String qName, Attributes attrs) throws SAXException
	{
		qName = qName.trim();

		// get the status
		if (qName.equals(Config.moduleTag))
			this.module = attrs.getValue(Config.nameAttribute);
		else if(qName.equals(Config.fieldTag))
		{
			state = READING_FIELD_STATE;
			this.fieldLabel = new StringBuffer();
			this.fieldName = attrs.getValue(Config.nameAttribute);
		}
	}

	// end tag element
	public void endElement(String namespaceURI, String localName, String qName)
			throws SAXException
	{
		qName = qName.trim();
		
		if(qName.equals(Config.moduleTag))
		{
			this.module = "";
		}
		else if(qName.equals(Config.fieldTag))
		{
			Labels theLabels = Labels.getInstance();
			theLabels.setValue(this.module, this.fieldName, this.fieldLabel.toString().trim());
			this.fieldName = "";
			this.fieldLabel = new StringBuffer();
		}

		state = OTHER_STATE;
	}

	// get characters in between tags
	public void characters(char buf[], int offset, int len) throws SAXException
	{
		String s = new String(buf, offset, len);
		
		if(state.equals(READING_FIELD_STATE))
			fieldLabel.append(s);
	}
	
}
