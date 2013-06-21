/*
 * HTTPReader.java
 *
 * This class is used to read the stylesheet content 
 * (there is possibly a better way of doing this - maybe using HTMLEditorKit ?)
 *
 * Created on 26 November 2005, 10:30
 */

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.URL;
import java.net.URLConnection;

/**
 * Used to get files and there content from the server (eg. a stylesheet)
 * 
 * @author martin
 */
public class HTTPReader
{
	private String location = "";

	public HTTPReader(String loc)
	{
		this.location = loc;
	}

	public String getContent()
	{
		StringBuffer firstLine = new StringBuffer();

		try
		{
			URL theUrl = new URL(location);
			URLConnection loc = theUrl.openConnection();

			BufferedReader in = new BufferedReader(new InputStreamReader(loc
					.getInputStream()));

			String inputLine = "";

			while ((inputLine = in.readLine()) != null)
				firstLine.append(inputLine);

			in.close();
		}
		catch (IOException e)
		{
			System.out.println("Error reading file (IOException): " + e);
			return "";
		}
		catch (Exception e)
		{
			System.out.println("Error reading file: " + e);
			return "";
		}

		return firstLine.toString();
	}

}
