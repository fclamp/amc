/*
 * MapReader.java
 *
 * Created on 27 September 2005, 12:02
 */

import java.awt.Graphics2D;
import java.awt.Image;
import java.awt.MediaTracker;
import java.awt.image.BufferedImage;
import java.net.URL;
import java.util.ArrayList;

import javax.swing.JApplet;

/**
 * 
 * @author martin
 */
public class MapReader
{
	// vector of maps
	static private ArrayList maps = new ArrayList();

	// current map being displayed
	static private int currentMap = 0;

	static private boolean hasBeenRead = false;

	// cannot be intantiated
	private MapReader()
	{

	}
	
	public static boolean hasBeenRead() {
		return hasBeenRead;
	}

	// set the current map
	public static void setCurrentMap(int i)
	{
		currentMap = i;
	}

	// decrement the map index
	public static void decrementCurrentMap()
	{
		currentMap -= 1;
	}

	public static void incrementCurrentMap()
	{
		currentMap += 1;
	}

	// get the map index
	public static int getMapIndex()
	{
		return currentMap;
	}

	// returns the current map
	public static Map getCurrentMap()
	{
		return (Map) maps.get(currentMap);
	}

	// returns all the maps
	public static ArrayList getMaps()
	{
		return maps;
	}

	// returns the number of maps
	public static int getNumberOfMaps()
	{
		return maps.size();
	}

	public static void resetDotsOnMap(int i)
	{
		Map theMap = null;

		try
		{
			theMap = (Map) maps.get(i);
		}
		catch (ArrayIndexOutOfBoundsException e)
		{
			System.out
					.println("Failed to get map because the map index was incorrect: "
							+ e);
		}

		theMap.setNumberOfDots(0);
	}

	// increment dots on map index
	public static void incrementDotsOnMap(int i)
	{
		Map theMap = null;

		try
		{
			theMap = (Map) maps.get(i);
		}
		catch (ArrayIndexOutOfBoundsException e)
		{
			System.out
					.println("Failed to get map because the map index was incorrect: "
							+ e);
		}

		theMap.incrementNumberOfDots();
	}

	// get map by index
	public static Map getMap(int i)
	{
		try
		{
			return (Map) maps.get(i);
		}
		catch (ArrayIndexOutOfBoundsException e)
		{
			System.out
					.println("Failed to get map because the map index was incorrect: "
							+ e);
		}

		return null;
	}

	// get map name by index
	public static String getMapName(int i)
	{
		Map theMap = null;

		try
		{
			theMap = (Map) maps.get(i);
		}
		catch (ArrayIndexOutOfBoundsException e)
		{
			System.out
					.println("Failed to get map because the map index was incorrect: "
							+ e);
		}

		if (theMap == null)
			return "";

		return theMap.getDescription();
	}

	// read the maps
	// will read the plansParam config string
	// Example
	// value="
	// Site Map^MorleySite030403.jpg^0^5300^0^5400^-1^2^TOP|
	// Basement^MorleyBasement030403.jpg^2600^4500^2200^4100^-1^-1^TOP"
	public static void readMaps(JApplet applet) throws NumberFormatException
	{
		if (Config.plansParam != null && !hasBeenRead)
		{
			// extract each list of plans (pipe seperated)
			String[] plans = Config.plansParam.split("\\s*\\|\\s*");

			// for each plan...
			for (int i = 0; i < plans.length; i++)
			{
				String plan = plans[i];

				// split each bit of the plan (carrot seperated)
				String[] fields = plan.split("\\s*\\^\\s*");

				if (fields.length <= 0)
				{
					System.out.println("Cannot Decipher Plan Syntax: " + plan);
					throw new NumberFormatException();
				}

				// remove lead/trail whitespace
				for (int j = 0; j < fields.length; j++)
					fields[j] = fields[j].trim();

				// add a map
				addMap(fields, applet);
			}

			// this is needed because the MapReader class is static (need flag
			// specifying if maps have been read)
			hasBeenRead = true;
		}
	}

	// add maps to map vector
	private static void addMap(String[] params, JApplet applet)
	{
		// convert the params to more suitable names for readability
		String description = params[0];
		String image = params[1];
		int x1 = Integer.parseInt(params[2]);
		int y1 = Integer.parseInt(params[3]);
		int x2 = Integer.parseInt(params[4]);
		int y2 = Integer.parseInt(params[5]);
		int bottom = Integer.parseInt(params[6]);
		int top = Integer.parseInt(params[7]);
		String direction = params[8];

		Map map = new Map();
		map.setDescription(description);
		map.setFile(image);
		map.setX1(x1);
		map.setY1(y1);
		map.setX2(x2);
		map.setY2(y2);
		map.setDirection(direction);
		map.setTopViewRange(top);
		map.setBottomViewRange(bottom);

		// add the map to the vector
		maps.add(map);
	}

	// get url function
	private static URL getURL(String filename, JApplet theApplet)
	{
		URL codeBase = theApplet.getCodeBase();
		URL url = null;

		try
		{
			url = new URL(codeBase, filename);
		}
		catch (java.net.MalformedURLException e)
		{
			System.out.println("Couldn't create image: badly specified URL");
			return null;
		}

		return url;
	}

	/**
	 * Load the map image dynamically so that loading times are not compromised
	 * on startup Still not that fast because its not threaded and the media
	 * tracker waits for the image to be loaded so that the coords have been
	 * made (x, y)
	 * 
	 */
	public static void loadImage(Map theMap, JApplet applet)
	{

		String location = Config.planLocation + "/" + theMap.getFile();

		// utilises the browser cache automatically
		Image img = applet.getImage(getURL(location, applet));

		if (img == null)
			System.out.println("Couldnt get the image: "
					+ theMap.getDescription() + " (file: " + location + ")");
		else
		{
			try
			{
				MediaTracker tracker = new MediaTracker(applet);
				tracker.addImage(img, 0);
				tracker.waitForID(0);
			}
			catch (InterruptedException e)
			{
				System.out.println("An Exception Occured: " + e);
			}
			catch (Exception e)
			{
				System.out.println("An Exception Occured: " + e);
			}

			int w = img.getWidth(applet);
			int h = img.getHeight(applet);
			if (w > Config.maxXMapPixels)
				Config.maxXMapPixels = w;
			if (h > Config.maxYMapPixels)
				Config.maxYMapPixels = h;

			try
			{
				BufferedImage bimage = new BufferedImage(w, h,
						BufferedImage.TYPE_INT_RGB);
				Graphics2D big = bimage.createGraphics();
				big.drawImage(img, 0, 0, applet);

				// set the buffered image for the map here
				theMap.setBufferedImage(bimage);

				// set the map as being read
				theMap.setLoaded();

			}
			catch (Exception e)
			{
				System.out.println("The Image failed to be created: " + e);
			}

		}
	}

}
