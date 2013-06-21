/*
 * Connection.java
 *
 * Abstract class because this class should not be instantiated - designed to be subclassed 
 *
 * Created on 20 October 2005, 10:25
 */

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.URL;
import java.net.URLConnection;

/**
 * 
 * @author martin
 */
public abstract class Connection
{
	protected String codeBase = "";

	// checks the texxmlserver connection
	public boolean checkConnection()
	{
		String firstLine = "";
		String connection = codeBase + Config.serverInterface;

		try
		{
			URL theUrl = new URL(connection);
			URLConnection loc = theUrl.openConnection();

			BufferedReader in = new BufferedReader(new InputStreamReader(loc
					.getInputStream()));

			String inputLine = "";

			while ((inputLine = in.readLine()) != null)
			{
				firstLine = inputLine;
				break;
			}

			in.close();
		}
		catch (IOException e)
		{
			System.out.println("Error reading php interface: " + e);
			return false;
		}
		catch (Exception e)
		{
			System.out.println("Error reading php interface: " + e);
			return false;
		}

		return firstLine.startsWith("<?xml") ? true : false;
	}
}
