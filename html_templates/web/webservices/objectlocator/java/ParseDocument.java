/**
 *
 * KE Software Pty Ltd 2005
 *
 * Parse Documents 
 *
 */

import java.util.ArrayList;
import java.util.Iterator;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

/**
 * @author martin
 * 
 */
public class ParseDocument extends DefaultHandler
{

	private String state = "";

	private ArrayList fields = null;

	private boolean found = false;

	private StringBuffer values = null;

	private final String STARTING_STATE = "starting";

	private final String FINISHED_STATE = "finished";

	private final String OTHER_STATE = "other";

	private String status = "";

	// will be a list of fields
	private ArrayList results = null;

	private Result res = null;

	// the fields passed are the fields wanted back from the document
	public ParseDocument(ArrayList theFields)
	{
		fields = theFields;
		results = new ArrayList();
		res = new Result();

		removeNestedItems();
	}

	// get the status from the results tag attribute 'status'
	public String getStatus()
	{
		return this.status;
	}

	// remove the nested items so that nested items like
	// multiple media references can be treated as individual fields
	public void removeNestedItems()
	{
		Iterator iter = fields.iterator();
		String label = "";
		ArrayList newFields = new ArrayList();

		while (iter.hasNext())
		{
			label = (String) iter.next();
			label = label.trim();

			if (label.endsWith("_tab"))
			{
				int indexTo = 0;
				indexTo = label.lastIndexOf("_tab");

				if (indexTo != -1)
					label = label.substring(0, indexTo);
			}

			newFields.add(label);
		}

		// set the new fields
		fields = newFields;
	}

	// return the results (which is a list of result objects)
	public ArrayList getResults()
	{
		return this.results;
	}

	// start document
	public void startDocument() throws SAXException
	{
		state = STARTING_STATE;
	}

	// end document
	public void endDocument() throws SAXException
	{
		state = FINISHED_STATE;
	}

	// start tag element
	public void startElement(String namespaceURI, String localName,
			String qName, Attributes attrs) throws SAXException
	{
		Iterator iter = fields.iterator();
		String label = "";
		found = false;
		qName = qName.trim();

		// get the status
		if (qName.equals(Config.resultsTag))
			this.status = attrs.getValue(Config.statusAttribute);

		while (iter.hasNext())
		{
			label = (String) iter.next();
			label = label.trim();

			if (qName.equals(label))
			{
				state = label;
				found = true;
				values = new StringBuffer("");

				break;
			}
		}

		if (!found)
			state = OTHER_STATE;
	}

	// end tag element
	public void endElement(String namespaceURI, String localName, String qName)
			throws SAXException
	{
		Iterator iter = fields.iterator();
		String label = "";
		qName = qName.trim();

		if (qName.equals(Config.endOfRecordTag))
		{
			// add a result object to the array list
			results.add(res);
			state = OTHER_STATE;
			res = new Result();

			return;
		}

		while (iter.hasNext())
		{
			label = (String) iter.next();
			label = label.trim();

			if (qName.equals(label))
			{
				// now make the field and add it to the array list
				Field f = new Field(values.toString(), label, "");
				res.addField(f);
				values = null;

				break;
			}
		}

		state = OTHER_STATE;
	}

	// get characters in between tags
	public void characters(char buf[], int offset, int len) throws SAXException
	{
		String s = new String(buf, offset, len);
		String label = "";

		Iterator iter = fields.iterator();

		while (iter.hasNext())
		{
			label = (String) iter.next();
			label = label.trim();

			if (state.equals(label))
			{
				values.append(s);
				break;
			}
		}

	}
}
