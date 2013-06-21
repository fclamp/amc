/*
 * QueryBuilder.java
 *
 * Created on 6 October 2005, 10:25
 */

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.util.ArrayList;

import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;

import org.xml.sax.SAXParseException;
import org.xml.sax.helpers.DefaultHandler;

/**
 * 
 * @author martin
 */
public class QueryBuilder extends Connection
{
	// fields to bring back
	private String[] backFields;

	// table to query
	private String table = "";

	private String[] queryValues;

	private String queryField = "";

	private String whereClause = "";

	// this constructor is only for checking the connection
	public QueryBuilder(String code)
	{
		super.codeBase = code;
	}

	public QueryBuilder(String[] theBackFields, String t, String[] values,
			String queryFieldName, String code)
	{
		this.backFields = theBackFields;
		this.table = t;
		this.queryValues = values;
		this.queryField = queryFieldName;
		super.codeBase = code;
	}

	// used for a location search (range query)
	public QueryBuilder(String[] theBackFields, String t, String code,
			String theWhereClause)
	{
		this.backFields = theBackFields;
		this.table = t;
		this.whereClause = theWhereClause;
		super.codeBase = code;
	}

	// query using the texxmlserver interface
	public ArrayList query()
	{
		DefaultHandler handler = null;
		ArrayList records = new ArrayList();
		StringBuffer queryString = new StringBuffer("select=");
		int len = backFields.length;
		String theQueryValues = "";

		for (int i = 0; i < len; i++)
		{
			queryString.append(backFields[i]);

			if ((i + 1) < len)
				queryString.append(", ");
		}

		queryString.append("&database=");
		queryString.append(table);
		queryString.append("&where=");

		if (whereClause.equals(""))
		{
			len = queryValues.length;
			for (int i = 0; i < len; i++)
			{
				theQueryValues += queryField;
				theQueryValues += " = ";
				theQueryValues += queryValues[i];

				if ((i + 1) < len)
					theQueryValues += " OR ";
			}

			try
			{
				theQueryValues = URLEncoder.encode(theQueryValues, "UTF-8");
			}
			catch (UnsupportedEncodingException u)
			{
				System.out.println("Exception: " + u);
			}

			queryString.append(theQueryValues);
		}
		else
		{
			try
			{
				this.whereClause = URLEncoder.encode(this.whereClause, "UTF-8");
			}
			catch (UnsupportedEncodingException u)
			{
				System.out.println("Exception: " + u);
			}

			queryString.append(this.whereClause);
		}

		String command = codeBase + Config.serverInterface + "?" + queryString;

		// System.out.println("Command: " + command);

		// construct the array list
		for (int i = 0; i < backFields.length; i++)
			records.add(backFields[i]);

		// pass the field you want back from the parsing document
		handler = new ParseDocument(records);
		// String status = "";

		SAXParserFactory factory = SAXParserFactory.newInstance();
		{
			try
			{
				SAXParser saxParser = factory.newSAXParser();
				saxParser.parse(command, handler);
				ParseDocument d = (ParseDocument) handler;
				records = d.getResults();
				// status = d.getStatus();
			}
			catch (SAXParseException spe)
			{
				System.out.println("Parsing error" + ", line "
						+ spe.getLineNumber() + ", uri " + spe.getSystemId()
						+ " " + spe.getMessage()
						+ "Error Parsing Object Record");
			}
			catch (Throwable t)
			{
				t.printStackTrace();
			}
		}

		return records;
	}
}
