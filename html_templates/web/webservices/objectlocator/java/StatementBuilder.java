/*
 * StatementBuilder.java
 *
 * Created on 20 October 2005, 10:25
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
public class StatementBuilder extends Connection
{
	// fields to bring back
	private String[] theSetFields;

	// table to query
	private String table = "";

	private String[] theSetValues;

	private String[] whereFields;

	private String[] whereValues;

	// this constructor is only for checking the connection
	public StatementBuilder(String code)
	{
		super.codeBase = code;
	}

	public StatementBuilder(String[] setFields, String t, String[] setValues,
			String[] whereFieldNames, String code, String[] whereFieldValues)
	{
		this.theSetFields = setFields;
		this.table = t;
		this.theSetValues = setValues;
		this.whereFields = whereFieldNames;
		this.whereValues = whereFieldValues;
		super.codeBase = code;
	}

	// returns the number of fields effected
	public int execute()
	{
		DefaultHandler handler = null;
		StringBuffer stmtString = new StringBuffer("update=");
		int len = theSetFields.length;
		String theWhere = "";
		String theSet = "";

		StringBuffer set = new StringBuffer("");

		for (int i = 0; i < len; i++)
		{
			set.append(theSetFields[i]);
			set.append(" = ");
			set.append(theSetValues[i]);

			if ((i + 1) < len)
				set.append(", ");
		}

		// encode the set
		try
		{
			theSet = URLEncoder.encode(set.toString(), "UTF-8");
		}
		catch (UnsupportedEncodingException u)
		{
			System.out.println("Exception: " + u);
		}

		stmtString.append(theSet);

		stmtString.append("&database=");
		stmtString.append(table);
		stmtString.append("&where=");

		len = whereFields.length;

		StringBuffer where = new StringBuffer("");

		for (int i = 0; i < len; i++)
		{
			where.append(whereFields[i]);
			where.append(" = ");
			where.append(whereValues[i]);

			if ((i + 1) < len)
				where.append(" OR ");
		}

		// encode the where
		try
		{
			theWhere = URLEncoder.encode(where.toString(), "UTF-8");
		}
		catch (UnsupportedEncodingException u)
		{
			System.out.println("Exception: " + u);
		}

		stmtString.append(theWhere);

		String command = codeBase + Config.serverInterface + "?"
				+ stmtString.toString();
		String status = "";
		// System.out.println("Command: " + command);

		handler = new ParseDocument(new ArrayList());
		SAXParserFactory factory = SAXParserFactory.newInstance();
		{
			try
			{
				SAXParser saxParser = factory.newSAXParser();
				saxParser.parse(command, handler);
				ParseDocument d = (ParseDocument) handler;
				status = d.getStatus();
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

		if (status.equals("success"))
			return 1;
		else
			return 0;
	}
}
