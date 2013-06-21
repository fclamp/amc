/*
 * Map.java
 *
 * Created on 27 September 2005, 11:51
 */

import java.awt.image.BufferedImage;

/**
 * 
 * @author martin
 */
public class Map
{
	private String mapDescription = "";

	private String mapFileName = "";

	// viewing range
	private int viewX1 = 0;

	private int viewY1 = 0;

	private int viewX2 = 0;

	private int viewY2 = 0;

	// top and bottom viewing range
	private int bottomViewRange = 0;

	private int topViewRange = 0;

	// direction the map is to be viewed
	private String direction = Config.TOP_VIEW;

	// buffered image
	private BufferedImage bimage = null;

	// number of dots on the map
	private int numberOfDots = 0;

	// flag to indicate if the map has been loaded
	private boolean loaded = false;

	// default constructor
	public Map()
	{

	}

	// map instance
	public Map(String desc, String file, int x1, int y1, int x2, int y2,
			int bottom, int top, String dir, BufferedImage b)
	{
		this.mapDescription = desc;
		this.mapFileName = file;
		this.viewX1 = x1;
		this.viewY1 = y1;
		this.viewX2 = x2;
		this.viewY2 = y2;
		this.bottomViewRange = bottom;
		this.topViewRange = top;
		this.direction = dir;
		this.bimage = b;
	}

	public boolean isLoaded()
	{
		return this.loaded;
	}

	public void setLoaded()
	{
		this.loaded = true;
	}

	// get the description
	public String getDescription()
	{
		return this.mapDescription;
	}

	public void setNumberOfDots(int i)
	{
		this.numberOfDots = i;
	}

	public void incrementNumberOfDots()
	{
		this.numberOfDots++;
	}

	public int getNumberOfDots()
	{
		return this.numberOfDots;
	}

	// returns the filename
	public String getFile()
	{
		return this.mapFileName;
	}

	// returns the x1 point
	public int getX1()
	{
		return this.viewX1;
	}

	// returns the y1 point
	public int getY1()
	{
		return this.viewY1;
	}

	// return the x2 point
	public int getX2()
	{
		return this.viewX2;
	}

	// return the y2 point
	public int getY2()
	{
		return this.viewY2;
	}

	// get the bottom viewing range
	public int getBottomViewRange()
	{
		return this.bottomViewRange;
	}

	// get the top viewing range
	public int getTopViewRange()
	{
		return this.topViewRange;
	}

	// return the direction the map should be viewed
	public String getDirection()
	{
		return this.direction;
	}

	// return the buffered image attached to this map object
	public BufferedImage getBufferedImage()
	{
		return this.bimage;
	}

	// set the description of the map
	public void setDescription(String desc)
	{
		this.mapDescription = desc;
	}

	// set the filename of the map
	public void setFile(String file)
	{
		this.mapFileName = file;
	}

	// set x1 point
	public void setX1(int i)
	{
		this.viewX1 = i;
	}

	// set y1 point
	public void setY1(int i)
	{
		this.viewY1 = i;
	}

	// set x2 point
	public void setX2(int i)
	{
		this.viewX2 = i;
	}

	// set y2 point
	public void setY2(int i)
	{
		this.viewY2 = i;
	}

	// set the bottom view range
	public void setBottomViewRange(int i)
	{
		this.bottomViewRange = i;
	}

	// set the top view range
	public void setTopViewRange(int i)
	{
		this.topViewRange = i;
	}

	// set the direction the map should be viewed from
	public void setDirection(String d)
	{
		this.direction = d;
	}

	// set the buffered image
	public void setBufferedImage(BufferedImage b)
	{
		this.bimage = b;
	}

	// get coordinates
	public double[] getCoordinates()
	{
		double[] values = { (double) viewX1, (double) viewY1, (double) viewX2,
				(double) viewY2, (double) bottomViewRange,
				(double) topViewRange };
		return values;
	}

}
