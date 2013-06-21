/*
 * MapPanel.java
 *
 * Created on 27 September 2005, 15:38
 */

import java.awt.BasicStroke;
import java.awt.Color;
import java.awt.Cursor;
import java.awt.Dimension;
import java.awt.Font;
import java.awt.Graphics;
import java.awt.Graphics2D;
import java.awt.Rectangle;
import java.awt.RenderingHints;
import java.awt.event.InputEvent;
import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;
import java.awt.event.MouseMotionListener;
import java.awt.geom.Ellipse2D;
import java.awt.geom.GeneralPath;
import java.awt.geom.Rectangle2D;
import java.awt.image.BufferedImage;
import java.text.DecimalFormat;
import java.util.ArrayList;

import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.Scrollable;
import javax.swing.SwingConstants;

/**
 * @author martin
 * 
 */
public class MapPanel extends JPanel implements Scrollable, MouseListener,
		MouseMotionListener
{
	private static final long serialVersionUID = 1L;

	private int maxUnitIncrement = 1;

	private int pointerX = 0;

	private int pointerY = 0;

	private int gridSpacing;

	private double xGridPixels, yGridPixels, zGridPixels;

	private JScrollPane scrollPane = null;

	private ArrayList dots = null;

	private ArrayList locationRecords = null;

	private ControlPanel controlPanel = null;

	private Ellipse2D.Double box = null;

	private ObjectLocator runningApplet = null;

	private boolean lassoOn = false;

	private int lassoX = 0;

	private int lassoY = 0;

	private boolean drawLasso = false;
	
	private Rectangle boundingBox = null;

	public MapPanel(ObjectLocator theApplet)
	{
		setBackground(new Color(Config.normalBackgroundColour));
		setAutoscrolls(true);
		addMouseListener(this);
		addMouseMotionListener(this);
		maxUnitIncrement = 10;
		setCursor(Cursor.getPredefinedCursor(Cursor.CROSSHAIR_CURSOR));
		xGridPixels = 10.0;
		yGridPixels = 10.0;
		runningApplet = theApplet;
		calculateGridSpacing();
	}

	/**
	 * Sets the lasso tool to be on and off
	 *
	 */
	public void setLasso()
	{
		this.lassoOn = !this.lassoOn;

		// need to reset the drawing
		this.drawLasso = false;
	}

	public boolean isLassoOn()
	{
		return this.lassoOn;
	}

	// add the dots to the panel
	public void addResults(ArrayList r)
	{
		this.dots = r;
	}

	// save dot so that this can be used for area calculation
	public void saveDotArea()
	{
		double[] savedPoint = screenToWorld(pointerX, pointerY);
		box = new Ellipse2D.Double(savedPoint[0] - Config.locRange / 2,
				savedPoint[1] - Config.locRange / 2, Config.locRange,
				Config.locRange);
	}

	// get the dot area
	public Ellipse2D.Double getDotArea()
	{
		return box;
	}

	// add the location results
	public void addLocationResults(ArrayList l)
	{
		this.locationRecords = l;
	}

	// get the location results
	public ArrayList getLocationResults()
	{
		return this.locationRecords;
	}

	// get the array list of dot objects
	public ArrayList getResults()
	{
		return this.dots;
	}

	// set the map panel and control panel
	public void setReferences(JScrollPane j, ControlPanel p)
	{
		this.scrollPane = j;
		this.controlPanel = p;
	}

	// gets the x pointer of the mouse
	public int getPointerX()
	{
		return this.pointerX;
	}

	// gets the y pointer of the mouse
	public int getPointerY()
	{
		return this.pointerY;
	}

	// set the pointer x
	public void setPointerX(int i)
	{
		this.pointerX = i;
	}

	// set the pointer y
	public void setPointerY(int i)
	{
		this.pointerY = i;
	}

	public void drawDot(Graphics2D g2, double[] coords, double xfactor,
			double yfactor, double zfactor, double xoffset, double yoffset)
	{
		Map theMap = MapReader.getCurrentMap();
		double[] currentBounds = theMap.getCoordinates();

		// turn real world coords into screen coordinates
		int sx = (int) (xfactor * (coords[0] - xoffset));
		int sy = (int) (yfactor * (coords[1] - yoffset));
		BufferedImage bimage = theMap.getBufferedImage();
		int h = bimage.getHeight(this);
		String direction = theMap.getDirection();

		if (direction.equals(Config.EAST_VIEW)
				|| direction.equals(Config.WEST_VIEW))
		{
			if (direction.equals(Config.WEST_VIEW))
				sx = (int) (xfactor * (coords[1] - xoffset));
			else
				sx = (int) (xfactor * (currentBounds[3] - coords[1]));

			sy = h - (int) (yfactor * (coords[2] - yoffset));
		}

		if (direction.equals(Config.NORTH_VIEW)
				|| direction.equals(Config.SOUTH_VIEW))
		{
			if (direction.equals(Config.NORTH_VIEW))
				sx = (int) (xfactor * (currentBounds[1] - coords[0]));

			sy = h - (int) (yfactor * (coords[2] - yoffset));
		}

		g2.setStroke(new BasicStroke(2.0f));
		if (Config.dotShape.toLowerCase().equals("square"))
		{
			Rectangle2D.Double dot = new Rectangle2D.Double(sx - Config.dotSize
					/ 2, sy - Config.dotSize / 2, Config.dotSize,
					Config.dotSize);

			if (Config.queryLocations)
				g2.setColor(new Color(Config.locDotFillColour));
			else
				g2.setColor(new Color(Config.dotFillColour));

			g2.fill(dot);

			if (Config.queryLocations)
				g2.setColor(new Color(Config.locDotBorderColour));
			else
				g2.setColor(new Color(Config.dotBorderColour));

			g2.draw(dot);
		}
		else if (Config.dotShape.toLowerCase().equals("circle"))
		{
			Ellipse2D.Double dot = new Ellipse2D.Double(
					sx - Config.dotSize / 2, sy - Config.dotSize / 2,
					Config.dotSize, Config.dotSize);

			if (Config.queryLocations)
				g2.setColor(new Color(Config.locDotFillColour));
			else
				g2.setColor(new Color(Config.dotFillColour));

			g2.fill(dot);

			if (Config.queryLocations)
				g2.setColor(new Color(Config.locDotBorderColour));
			else
				g2.setColor(new Color(Config.dotBorderColour));

			g2.draw(dot);
		}
		else if (Config.dotShape.toLowerCase().equals("cross"))
		{
			GeneralPath dot = new GeneralPath();
			dot.moveTo(sx, sy + Config.dotSize / 2);
			dot.lineTo(sx, sy - Config.dotSize / 2);
			dot.moveTo(sx + Config.dotSize / 2, sy);
			dot.lineTo(sx - Config.dotSize / 2, sy);

			g2.setStroke(new BasicStroke(3.0f));

			if (Config.queryLocations)
				g2.setColor(new Color(Config.locDotBorderColour));
			else
				g2.setColor(new Color(Config.dotBorderColour));

			g2.draw(dot);
			g2.setStroke(new BasicStroke(1.5f));

			if (Config.queryLocations)
				g2.setColor(new Color(Config.locDotFillColour));
			else
				g2.setColor(new Color(Config.dotFillColour));

			g2.draw(dot);
		}
		else if (Config.dotShape.toLowerCase().equals("triangle"))
		{
			GeneralPath dot = new GeneralPath();
			dot = new GeneralPath();
			dot.moveTo(sx - (Config.dotSize / 2), sy + (Config.dotSize / 2));
			dot.lineTo(sx + (Config.dotSize / 2), sy + (Config.dotSize / 2));
			dot.lineTo(sx, sy - (Config.dotSize / 2));
			dot.lineTo(sx - (Config.dotSize / 2), sy + (Config.dotSize / 2));

			if (Config.queryLocations)
				g2.setColor(new Color(Config.locDotFillColour));
			else
				g2.setColor(new Color(Config.dotFillColour));

			g2.fill(dot);

			if (Config.queryLocations)
				g2.setColor(new Color(Config.locDotBorderColour));
			else
				g2.setColor(new Color(Config.dotBorderColour));

			g2.draw(dot);
		}
		else
		{
			GeneralPath dot = new GeneralPath();
			dot = new GeneralPath();
			dot.moveTo(sx - (Config.dotSize / 2), sy + (Config.dotSize / 2));
			dot.lineTo(sx + (Config.dotSize / 2), sy + (Config.dotSize / 2));
			dot.lineTo(sx, sy - (Config.dotSize / 2));
			dot.lineTo(sx - (Config.dotSize / 2), sy + (Config.dotSize / 2));

			if (Config.queryLocations)
				g2.setColor(new Color(Config.locDotFillColour));
			else
				g2.setColor(new Color(Config.dotFillColour));

			g2.fill(dot);

			if (Config.queryLocations)
				g2.setColor(new Color(Config.locDotBorderColour));
			else
				g2.setColor(new Color(Config.dotBorderColour));

			g2.draw(dot);
		}
	}
	
	/**
	 *  This function unselects the dots - this will be used for various things
	 */
	public void unSelectDots() 
	{
		int number = 0;
		
		if (dots != null && (!Config.queryLocations))
			number = this.dots.size();
		else if (locationRecords != null && (Config.queryLocations))
			number = this.locationRecords.size();

		// set each dot or location as not selected
		for (int i = 0; i < number; i++)
		{
			if (!Config.queryLocations)
			{
				Dot theDot = (Dot) dots.get(i);
				theDot.setSelected(false);
			}
			else
			{
				Location theLocation = (Location) locationRecords.get(i);
				theLocation.setSelected(false);
			}
		}
	}
	
	public void setBoundingBox(Rectangle r)
	{
		this.boundingBox = r;
	}

	// draw the dots on the map
	private void drawDots(Graphics2D g2, int w, int h)
	{
		// determine scaling factors to turn world coords into screen coords
		Map theMap = MapReader.getCurrentMap();
		double x1 = (double) theMap.getX1();
		double y1 = (double) theMap.getY1();
		double x2 = (double) theMap.getX2();
		double y2 = (double) theMap.getY2();
		double bottom = (double) theMap.getBottomViewRange();
		double top = (double) theMap.getTopViewRange();
		String direction = theMap.getDirection();
		double xfactor = (double) w / (y1 - x1);
		double yfactor = (double) h / (y2 - x2);
		double zfactor = 1;
		double xoffset = x1;
		double yoffset = x2;
		String msg = "";
		boolean intersectResult = false;

		if (Config.queryLocations)
			msg = "<tr class='content'><td class='borders' align='center'><b>Total Locations Found</b></td></tr>";
		else
			msg = "<tr class='content'><td class='borders' align='center'><b>Total Objects Found</b></td></tr>";

		if (direction.equals(Config.EAST_VIEW)
				|| direction.equals(Config.WEST_VIEW))
		{
			xfactor = (double) w / (y2 - x2);
			yfactor = (double) h / (top - bottom);
			zfactor = 1;
			xoffset = x2;
			yoffset = bottom;
		}
		else if (direction.equals(Config.NORTH_VIEW)
				|| direction.equals(Config.SOUTH_VIEW))
		{
			yfactor = (double) h / (top - bottom);
			yoffset = bottom;
			zfactor = 1;
		}

		// step through records and draw dot
		int number = 0;

		if (dots != null && (!Config.queryLocations))
			number = this.dots.size();
		else if (locationRecords != null && (Config.queryLocations))
			number = this.locationRecords.size();

		int matches = 0;
		String matchedRecords = "";

		msg += "<tr class='contentLight'><td class='borders'>" + number;
		msg += "</td></tr>";

		// set each dot or location as not selected
		for (int i = 0; i < number; i++)
		{
			if (!Config.queryLocations)
			{
				Dot theDot = (Dot) dots.get(i);
				theDot.setSelected(false);
			}
			else
			{
				Location theLocation = (Location) locationRecords.get(i);
				theLocation.setSelected(false);
			}
		}

		for (int i = 0; i < number; i++)
		{
			double[] coords;
			String desc = "";
			Location theLoc = null;
			Dot theDot = null;

			if (Config.queryLocations)
			{
				theLoc = (Location) locationRecords.get(i);
				coords = theLoc.getCoordinates();
				desc = theLoc.getLocationDescription();
			}
			else
			{
				theDot = (Dot) dots.get(i);
				coords = theDot.getCoordinates();
				desc = theDot.getDescription();
			}

			if (Intersects(coords))
			{
				drawDot(g2, coords, xfactor, yfactor, zfactor, xoffset, yoffset);

				// if the lasso on then draw dots if they fall in the bounding box
				if(this.lassoOn)
				{
					intersectResult = Intersects(coords, xfactor, yfactor, xoffset, yoffset);
				}
				else
				{
					intersectResult = Intersects(coords, pointerX, pointerY, xfactor, yfactor, xoffset, yoffset);
				}
				
				if (intersectResult)
				{
					int oldDotFillColour = 0;
					int oldDotBorderColour = 0;

					if (Config.queryLocations)
					{
						oldDotFillColour = Config.locDotFillColour;
						Config.locDotFillColour = Config.locDotHighlightFillColour;
						oldDotBorderColour = Config.locDotBorderColour;
						Config.locDotBorderColour = Config.locDotHighlightBorderColour;
					}
					else
					{
						oldDotFillColour = Config.dotFillColour;
						Config.dotFillColour = Config.dotHighlightFillColour;
						oldDotBorderColour = Config.dotBorderColour;
						Config.dotBorderColour = Config.dotHighlightBorderColour;
					}

					drawDot(g2, coords, xfactor, yfactor, zfactor, xoffset,
							yoffset);

					if (Config.queryLocations)
						controlPanel.addItemToComboBox(theLoc);

					if (Config.queryLocations)
					{
						Config.locDotFillColour = oldDotFillColour;
						Config.locDotBorderColour = oldDotBorderColour;
					}
					else
					{
						Config.dotFillColour = oldDotFillColour;
						Config.dotBorderColour = oldDotBorderColour;
					}

					matchedRecords += desc;
					matches++;

					if (Config.queryLocations)
					{
						theLoc.setSelected(true);
					}
					else
						theDot.setSelected(true);
				}
			}
		}

		if (matches > 0)
		{
			if (Config.queryLocations)
				msg += "<tr class='content'><td class='borders' align='center'><b>Selected Locations</b></td></tr>";
			else
				msg += "<tr class='content'><td class='borders' align='center'><b>Selected Objects</b></td></tr>";

			msg += "<tr class='contentLight'><td class='borders'>" + matches
					+ "</td></tr>";
			msg += matchedRecords;
		}

		if ((Config.showReference || matches == 0))
		{
			double[] coords = screenToWorld(pointerX, pointerY);
			DecimalFormat myformat = new DecimalFormat(Config.decimalPlaces);
			String table = "<table width='100%'>";

			// if viewing from top
			if (direction.equals(Config.TOP_VIEW))
			{
				msg = table
						+ "<tr class='content'><td class='borders' align='center'>"
						+ "<b>Location</b></td></tr><tr class='contentLight'><td class='borders'>("
						+ myformat.format(coords[0]) + ", "
						+ myformat.format(coords[1]) + ", "
						+ myformat.format(coords[2]) + ")</td></tr>" + msg;
			}
			else
			{
				float newZ = (float) (coords[2] + 1);

				if (direction.equals(Config.EAST_VIEW))
				{
					float newY = (float) (x2 + (y2 - coords[1]));

					msg = table
							+ "<tr class='content'><td class='borders' align='center'>"
							+ "<b>Location</b></td></tr><tr class='contentLight'><td class='borders'>( NA , "
							+ myformat.format(newY) + ", "
							+ myformat.format(newZ) + ")</td></tr>" + msg;
				}
				else if (direction.equals(Config.WEST_VIEW))
				{
					msg = table
							+ "<tr class='content'><td class='borders' align='center'>"
							+ "<b>Location:</b></td></tr><tr class='contentLight'><td class='borders'>( NA , "
							+ myformat.format(coords[1]) + ", "
							+ myformat.format(newZ) + ")</td></tr>" + msg;
				}
				else if (direction.equals(Config.NORTH_VIEW))
				{
					float newX = (float) (x1 + (y1 - coords[0]));

					msg = table
							+ "<tr class='content'><td class='borders' align='center'>"
							+ "<b>Location:</b> </td></tr><tr class='contentLight'><td class='borders'>("
							+ myformat.format(newX) + ", NA , "
							+ myformat.format(newZ) + ")</td></tr>" + msg;
				}
				else if (direction.equals(Config.SOUTH_VIEW))
				{
					msg = table
							+ "<tr class='content'><td class='borders' align='center'>"
							+ "<b>Location:</b> </td></tr><tr class='contentLight'><td class='borders'>("
							+ myformat.format(coords[0]) + ", " + " NA , "
							+ myformat.format(newZ) + ")</td></tr>" + msg;
				}
			}
		}

		msg = msg + "</table>";

		// show the message on the right html panel - only if the location
		// change button has not been pressed
		if (!Config.locationChange && (!Config.locationChangeFlag))
			controlPanel.showMsg(msg);

		// this is needed so that the location change error message can be shown
		// for a frame
		Config.locationChangeFlag = false;
	}

	// uses the map index passed
	public boolean Intersects(int i, double[] coords)
	{
		Map theMap = MapReader.getMap(i);
		double[] currentBounds = theMap.getCoordinates();

		if ((currentBounds[0] > coords[0]) || (currentBounds[1] < coords[0]))
			return false;
		if ((currentBounds[2] > coords[1]) || (currentBounds[3] < coords[1]))
			return false;
		if ((currentBounds[4] > coords[2]) || (currentBounds[5] < coords[2]))
			return false;

		return true;
	}

	// uses the current map
	public boolean Intersects(double[] coords)
	{
		Map theMap = MapReader.getCurrentMap();
		double[] currentBounds = theMap.getCoordinates();

		if ((currentBounds[0] > coords[0]) || (currentBounds[1] < coords[0]))
			return false;
		if ((currentBounds[2] > coords[1]) || (currentBounds[3] < coords[1]))
			return false;
		if ((currentBounds[4] > coords[2]) || (currentBounds[5] < coords[2]))
			return false;

		return true;
	}
	
	/**
	 * This is for Intersection of the bounding box used for the lasso tool
	 * 
	 * @param coords
	 * @param xfactor
	 * @param yfactor
	 * @param xoffset
	 * @param yoffset
	 * @return
	 */
	private boolean Intersects(double[] coords, double xfactor, double yfactor, double xoffset, double yoffset)
	{
		Map theMap = MapReader.getCurrentMap();
		double y1 = theMap.getY1();
		double y2 = theMap.getY2();
		String direction = theMap.getDirection();
		BufferedImage bimage = theMap.getBufferedImage();

		if(boundingBox == null) 
			return false;
		
		int xleft = (int) boundingBox.getX();
		int ytop = (int) boundingBox.getY();
		int xright = (int) boundingBox.getWidth() + xleft;
		int ybottom = (int) boundingBox.getHeight() + ytop;
		
		if (direction.equals(Config.EAST_VIEW))
		{
			// view from the east
			int sx = (int) (xfactor * (y2 - coords[1]));
			int h = bimage.getHeight(this);
			int sy = h - (int) (yfactor * (coords[2] - yoffset));

			if ( (sx < xleft) || (sx > xright) )
				return false;
			if ( (sy < ytop) || (sy > ybottom) )
				return false;
		}
		else if (direction.equals(Config.NORTH_VIEW))
		{
			// view from the north
			int h = bimage.getHeight(this);

			int sx = (int) (xfactor * (y1 - coords[0]));
			int sy = h - (int) (yfactor * (coords[2] - yoffset));
			
			if ( (sx < xleft) || (sx > xright) )
				return false;
			if ( (sy < ytop) || (sy > ybottom) )
				return false;
		}
		else if (direction.equals(Config.SOUTH_VIEW))
		{
			// view from the south
			int h = bimage.getHeight(this);

			int sy = h - (int) (yfactor * (coords[2] - yoffset));
			int sx = (int) (xfactor * (coords[0] - xoffset));

			if ( (sx < xleft) || (sx > xright) )
				return false;
			if ( (sy < ytop) || (sy > ybottom) )
				return false;
		}
		else if (direction.equals(Config.WEST_VIEW))
		{
			// view from the west
			int h = bimage.getHeight(this);

			int sx = (int) (xfactor * (coords[1] - xoffset));
			int sy = h - (int) (yfactor * (coords[2] - yoffset));

			if ( (sx < xleft) || (sx > xright) )
				return false;
			if ( (sy < ytop) || (sy > ybottom) )
				return false;
		}
		else if (direction.equals(Config.TOP_VIEW))
		{
			// view from top
			// turn real world coords into screen coordinates
			int sx = (int) (xfactor * (coords[0] - xoffset));
			int sy = (int) (yfactor * (coords[1] - yoffset));	
			
			if ( (sx < xleft) || (sx > xright) )
				return false;
			if ( (sy < ytop) || (sy > ybottom) )
				return false;
			
			return true;
		}

		return true;
	}

	private boolean Intersects(double[] coords, int xClick, int yClick,
			double xfactor, double yfactor, double xoffset, double yoffset)
	{
		Map theMap = MapReader.getCurrentMap();
		double y1 = theMap.getY1();
		double y2 = theMap.getY2();
		String direction = theMap.getDirection();
		BufferedImage bimage = theMap.getBufferedImage();

		if (direction.equals(Config.EAST_VIEW))
		{
			// view from the east
			int sx = (int) (xfactor * (y2 - coords[1]));
			int h = bimage.getHeight(this);
			int sy = h - (int) (yfactor * (coords[2] - yoffset));

			int dither = Config.dotSize / 2;
			if ((xClick < (sx - dither)) || (xClick > (sx + dither)))
				return false;
			if ((yClick < (sy - dither)) || (yClick > (sy + dither)))
				return false;

		}
		else if (direction.equals(Config.NORTH_VIEW))
		{
			// view from the north
			int h = bimage.getHeight(this);

			int sx = (int) (xfactor * (y1 - coords[0]));
			int sy = h - (int) (yfactor * (coords[2] - yoffset));

			int dither = Config.dotSize / 2;
			if ((xClick < (sx - dither)) || (xClick > (sx + dither)))
				return false;
			if ((yClick < (sy - dither)) || (yClick > (sy + dither)))
				return false;
		}
		else if (direction.equals(Config.SOUTH_VIEW))
		{
			// view from the south
			int h = bimage.getHeight(this);

			int sy = h - (int) (yfactor * (coords[2] - yoffset));
			int sx = (int) (xfactor * (coords[0] - xoffset));

			int dither = Config.dotSize / 2;
			if ((xClick < (sx - dither)) || (xClick > (sx + dither)))
				return false;
			if ((yClick < (sy - dither)) || (yClick > (sy + dither)))
				return false;
		}
		else if (direction.equals(Config.WEST_VIEW))
		{
			// view from the west
			int h = bimage.getHeight(this);

			int sx = (int) (xfactor * (coords[1] - xoffset));
			int sy = h - (int) (yfactor * (coords[2] - yoffset));

			int dither = Config.dotSize / 2;
			if ((xClick < (sx - dither)) || (xClick > (sx + dither)))
				return false;
			if ((yClick < (sy - dither)) || (yClick > (sy + dither)))
				return false;
		}
		else if (direction.equals(Config.TOP_VIEW))
		{
			// view from top
			// turn real world coords into screen coordinates
			int sx = (int) (xfactor * (coords[0] - xoffset));
			int sy = (int) (yfactor * (coords[1] - yoffset));

			int dither = Config.dotSize / 2;
			if ((xClick < (sx - dither)) || (xClick > (sx + dither)))
				return false;
			if ((yClick < (sy - dither)) || (yClick > (sy + dither)))
				return false;
			return true;

		}

		return true;
	}

	// draw the target on the screen
	private void drawPipper(Graphics2D g2)
	{
		int bigDither = (int) (0.8 * Config.dotSize);
		int litDither = Config.dotSize / 3;

		GeneralPath marker = new GeneralPath();
		marker.moveTo(pointerX - litDither, pointerY);
		marker.lineTo(pointerX - bigDither, pointerY);
		marker.moveTo(pointerX + litDither, pointerY);
		marker.lineTo(pointerX + bigDither, pointerY);
		marker.moveTo(pointerX, pointerY + litDither);
		marker.lineTo(pointerX, pointerY + bigDither);
		marker.moveTo(pointerX, pointerY - litDither);
		marker.lineTo(pointerX, pointerY - bigDither);

		Ellipse2D.Double dot = new Ellipse2D.Double(pointerX - bigDither / 2,
				pointerY - bigDither / 2, bigDither, bigDither);

		g2.setColor(new Color(Config.pointerBorderColour));
		g2.setStroke(new BasicStroke(3.0f));
		g2.draw(dot);

		g2.setColor(new Color(Config.pointerColour));
		g2.setStroke(new BasicStroke(1.0f));
		g2.draw(dot);
		g2.setColor(new Color(Config.pointerColour));
		g2.draw(marker);
	}

	public void calculateGridSpacing()
	{
		// we want a grid spacing to be human friendly (eg not 33.2345m)
		// criteria :
		// 1. mantissa 1 or 2 or 5
		// 2. exponent a power of 10
		// 3. approximately 10 grid lines per image

		// assume for argument sake that real world units are metres
		// get real world current plan extent in metres
		Map theMap = MapReader.getCurrentMap();

		if (!theMap.isLoaded())
		{
			MapReader.loadImage(theMap, runningApplet);
		}

		int x1 = theMap.getX1();
		int y1 = theMap.getY1();
		int x2 = theMap.getX2();
		int y2 = theMap.getY2();
		int bottom = theMap.getBottomViewRange();
		int top = theMap.getTopViewRange();

		double xExtent = (y1 - x1);
		double yExtent = (y2 - x2);
		double zExtent = (top - bottom);

		// get pixel / metre ratios
		BufferedImage bimage = theMap.getBufferedImage();
		int w = bimage.getWidth(this);
		int h = bimage.getHeight(this);

		double xPixelPerUnit;
		double yPixelPerUnit;
		double zPixelPerUnit;

		xPixelPerUnit = (double) w / xExtent;
		yPixelPerUnit = (double) h / yExtent;
		zPixelPerUnit = (double) h / zExtent;

		// choose grid spacing in metres
		// first guess = extent / 10
		double minExtent = xExtent;

		double xGrid = minExtent / 10;
		// turn guess into closest to a 1|2|5 * 10^n

		int exponent = (int) Math.floor(Math.log(xGrid) / 2.303);
		double mantissa = Math.round(xGrid / Math.pow(10, exponent));

		if (mantissa == 3)
			mantissa = 2;
		else if (mantissa == 4)
			mantissa = 5;
		else if (mantissa > 5 && mantissa < 8)
			mantissa = 5;
		else if (mantissa > 8)
		{
			mantissa = 1;
			exponent++;
		}

		gridSpacing = (int) (mantissa * Math.pow(10, exponent));

		// turn grid spacing into pixels
		xGridPixels = (gridSpacing * xPixelPerUnit);
		yGridPixels = (gridSpacing * yPixelPerUnit);
		zGridPixels = (zPixelPerUnit);

	}

	// draw scale - the numbers on the top and sides of the grid
	private void drawScale(Graphics2D g2, int w, int h)
	{
		Font font = new java.awt.Font("Tahoma", Font.PLAIN, 12);
		g2.setFont(font);
		g2.setStroke(new BasicStroke(1.0f));

		Rectangle vpB = this.scrollPane.getViewport().getViewRect();
		Map theMap = MapReader.getCurrentMap();

		// map coords
		int theX1 = theMap.getX1();
		int theY1 = theMap.getY1();
		int theX2 = theMap.getX2();
		int theY2 = theMap.getY2();
		String direction = theMap.getDirection();
		int bottom = theMap.getBottomViewRange();
		int top = theMap.getTopViewRange();

		int pX = theX1;
		int pY = theX2;

		// if the map direction is north or south view
		if (direction.equals(Config.NORTH_VIEW)
				|| direction.equals(Config.SOUTH_VIEW))
			pY = bottom;

		// if the map direction is west or east view
		if (direction.equals(Config.EAST_VIEW)
				|| direction.equals(Config.WEST_VIEW))
		{
			pX = theX2;
			pY = bottom;
		}

		double x, y;

		if (direction.equals(Config.TOP_VIEW)
				|| direction.equals(Config.WEST_VIEW)
				|| direction.equals(Config.SOUTH_VIEW))
		{
			for (x = 0.0; x < w; x += xGridPixels)
			{
				g2.setColor(new Color(Config.fadedTextColour));
				g2.drawLine((int) x, 0, (int) x, 10);
				g2.setColor(new Color(Config.pointerBorderColour));
				g2.drawString(Integer.toString(pX), (int) x,
						(int) (vpB.getY() / Config.scale) + 10);
				pX += gridSpacing;
			}
		}
		else
		{
			// east
			if (direction.equals(Config.EAST_VIEW))
				pX = theY2;
			else if (direction.equals(Config.NORTH_VIEW))
				pX = theY1;

			for (x = 0; x < w; x += xGridPixels)
			{
				g2.setColor(new Color(Config.fadedTextColour));
				g2.setColor(new Color(Config.pointerBorderColour));
				g2.drawString(Integer.toString(pX), (int) x,
						(int) (vpB.getY() / Config.scale) + 10);
				pX -= gridSpacing;
			}
		}

		// for writing up the number on the y coordinate
		if (direction.equals(Config.TOP_VIEW))
		{
			for (y = 0.0; y < h; y += yGridPixels)
			{
				g2.setColor(new Color(Config.fadedTextColour));
				g2.setColor(new Color(Config.pointerBorderColour));
				g2.drawString(Integer.toString(pY),
						(int) (vpB.getX() / Config.scale) + 10, (int) y);
				pY += gridSpacing;
			}
		}
		else
		{
			// start at the highest level
			int l = top;

			for (y = 0.0; y < h; y += zGridPixels)
			{
				g2.setColor(new Color(Config.fadedTextColour));
				g2.setColor(new Color(Config.pointerBorderColour));
				g2.drawString(Integer.toString(l),
						(int) (vpB.getX() / Config.scale) + 10, (int) y);
				l--;
			}
		}
	}

	// draw the grid on the map screen
	private void drawGrid(Graphics2D g2, int w, int h)
	{
		Map theMap = MapReader.getCurrentMap();

		g2.setStroke(new BasicStroke(1.0f));
		g2.setColor(new Color(Config.fadedTextColour));

		double x, y;

		for (x = xGridPixels; x < w; x += xGridPixels)
			g2.drawLine((int) x, 0, (int) x, h);

		// drawing line on y coordinate
		if (theMap.getDirection().equals(Config.TOP_VIEW))
		{
			for (y = yGridPixels; y < h; y += yGridPixels)
				g2.drawLine(0, (int) y, w, (int) y);
		}
		else
		{
			for (y = zGridPixels; y < h; y += zGridPixels)
				g2.drawLine(0, (int) y, w, (int) y);
		}

		drawScale(g2, w, h);
	}

	/**
	 * Draw Lasso 
	 * @param g2
	 */
	public void drawLasso(Graphics2D g2)
	{
		int width = 0;
		int height = 0;

		g2.setStroke(new BasicStroke(1.0f));
		g2.setColor(new Color(Config.pointerColour));

		// split up drawing into 4 segments 
		// segment 1 (top left)
		if ((lassoX <= pointerX) && (lassoY <= pointerY))
		{
			height = pointerY - lassoY;
			width = pointerX - lassoX;
			
			this.boundingBox = new Rectangle(lassoX, lassoY, width, height);
			g2.drawRect(lassoX, lassoY, width, height);
		}
		else if ((lassoX <= pointerX) && (lassoY >= pointerY))
		{
			// segment 2 (bottom left)
			height = lassoY - pointerY;
			width = pointerX - lassoX;
			
			this.boundingBox = new Rectangle(lassoX, lassoY - height, width, height);
			g2.drawRect(lassoX, lassoY - height, width, height);
		}
		else if ((lassoX >= pointerX) && (lassoY <= pointerY))
		{
			// segment 3 (top right)
			height = pointerY - lassoY;
			width = lassoX - pointerX;
			
			this.boundingBox = new Rectangle(pointerX, pointerY - height, width, height);
			g2.drawRect(pointerX, pointerY - height, width, height);
		}
		else
		{
			// (lassoX >= pointerX) && (lassoY >= pointerY)
			// segment 4 (bottom right)
			height = lassoY - pointerY;
			width = lassoX - pointerX;
			
			this.boundingBox = new Rectangle(pointerX, pointerY, width, height);
			g2.drawRect(pointerX, pointerY, width, height);
		}
	}

	// draw a map
	public void drawMap(Graphics2D g2)
	{
		BufferedImage bimage;

		// draw current plan
		Map theMap = MapReader.getCurrentMap();

		if (!theMap.isLoaded())
		{
			MapReader.loadImage(theMap, controlPanel.getApplet());
		}

		bimage = theMap.getBufferedImage();
		int w = bimage.getWidth(this);
		int h = bimage.getHeight(this);
		g2.drawImage(bimage, null, 0, 0);

		// draw the dots no matter what
		drawDots(g2, w, h);

		if (Config.showGrid)
			drawGrid(g2, w, h);

		if (pointerX > 0 && (!this.lassoOn))
			drawPipper(g2);

		if (this.lassoOn && this.drawLasso)
			drawLasso(g2);

		// print name of current map
		StringBuffer mapName = new StringBuffer(theMap.getDescription());
		mapName.append(" (");
		mapName.append(w);
		mapName.append(", ");
		mapName.append(h);
		mapName.append(")");

		Font font = new java.awt.Font("Tahoma", Font.BOLD, 20);
		g2.setFont(font);
		g2.setColor(new Color(Config.fadedTextColour));
		g2.drawString(mapName.toString(), 10, 20);
	}

	public void blank(Graphics2D g2)
	{
		// blank screen
		g2.setColor(new Color(Config.normalBackgroundColour));
		g2.setBackground(new Color(Config.highlightTextColour));
		Rectangle2D rect = new Rectangle2D.Float(0, 0, Config.maxXMapPixels,
				Config.maxYMapPixels);
		g2.fill(rect);
	}

	// paint stuff on the screen
	public void paint(Graphics g)
	{
		Graphics2D g2 = (Graphics2D) g;
		g2.scale(Config.scale, Config.scale);

		g2.setRenderingHint(RenderingHints.KEY_ANTIALIASING,
				RenderingHints.VALUE_ANTIALIAS_ON);
		g2.setRenderingHint(RenderingHints.KEY_RENDERING,
				RenderingHints.VALUE_RENDER_SPEED);

		controlPanel.clearComboBox();
		blank(g2);
		drawMap(g2);

		// auto popup of the combo box
		if (Config.autoPopup)
			controlPanel.showPopup();

		g2.dispose();
	}

	// change to world coordinates from screen coordinates
	double[] screenToWorld(int x, int y)
	{
		Map theMap = MapReader.getCurrentMap();
		BufferedImage bimage = theMap.getBufferedImage();
		int w = bimage.getWidth(this);
		int h = bimage.getHeight(this);
		double[] currentBounds = theMap.getCoordinates();
		double xfactor = (double) w / (currentBounds[1] - currentBounds[0]);
		double yfactor = (double) h / (currentBounds[3] - currentBounds[2]);
		double xoffset = currentBounds[0];
		double yoffset = currentBounds[2];
		String direction = theMap.getDirection();

		double[] coords = new double[3];
		coords[0] = (x / xfactor) + xoffset;
		coords[1] = (y / yfactor) + yoffset;
		coords[2] = currentBounds[4];

		if (direction.equals(Config.EAST_VIEW)
				|| direction.equals(Config.WEST_VIEW))
		{
			xfactor = (double) w / (currentBounds[3] - currentBounds[2]);
			yfactor = (double) h / (currentBounds[5] - currentBounds[4]);
			xoffset = currentBounds[2];
			yoffset = currentBounds[4];
			coords[0] = currentBounds[0];
			coords[1] = (x / xfactor) + xoffset;
			coords[2] = currentBounds[5] - (y / yfactor) + yoffset;
		}

		if (direction.equals(Config.SOUTH_VIEW)
				|| direction.equals(Config.NORTH_VIEW))
		{
			yfactor = (double) h / (currentBounds[5] - currentBounds[4]);
			yoffset = currentBounds[4];
			coords[0] = (x / xfactor) + xoffset;
			coords[1] = currentBounds[2];
			coords[2] = currentBounds[5] - (y / yfactor) + yoffset;
		}

		return coords;
	}

	// if the mouse is moving then the lasso tool needs to move accordingly
	public void mouseMoved(MouseEvent e)
	{
		if (lassoOn && drawLasso)
		{
			lassoX = (int) (e.getX() / Config.scale);
			lassoY = (int) (e.getY() / Config.scale);
			repaint();
		}
	}

	public void mouseClicked(MouseEvent e)
	{
	}

	public void mouseReleased(MouseEvent e)
	{
	}

	public void mouseEntered(MouseEvent e)
	{
	}

	public void mouseExited(MouseEvent e)
	{
	}

	// if the mouse the pressed we want to repaint so that the pointer can be
	// painted
	public void mousePressed(MouseEvent e)
	{
		pointerX = (int) (e.getX() / Config.scale);
		pointerY = (int) (e.getY() / Config.scale);
		lassoX = pointerX;
		lassoY = pointerY;
		drawLasso = !drawLasso;
		
		repaint();

		// right mouse button clicked
		if (((e.getModifiers() & InputEvent.BUTTON3_MASK) == InputEvent.BUTTON3_MASK)
				&& (Config.locationChange))
		{
			if (!updateLocation(this.controlPanel.getSelectedLoc()))
			{
				Config.locationChange = false;
				Config.locationChangeFlag = true;
				controlPanel.changeButtonIcons();
				repaint();
			}
		}
	}

	// update a location record with the new coordinates
	private boolean updateLocation(Location l)
	{
		if (l == null)
		{
			System.out.println("There is no dot reference ..");
			controlPanel.showErrorMsg("There is no dot reference");
			return false;
		}
		else if (!MapReader.getCurrentMap().getDirection().equals(
				Config.TOP_VIEW))
		{
			// check if the current map is not a top view
			// cannot insert a dot on a side view
			System.out
					.println("The current map is a side view - location cannot be updated"
							+ " on a side view - please switch to a top view");
			String msg = "The current map is a side view!<br><br>Please make sure you are in a top view when updating a location";
			controlPanel.showErrorMsg(msg);
			return false;
		}

		double[] mouseLocation = screenToWorld(this.pointerX, this.pointerY);

		// get the code base and check connection
		StatementBuilder statement = new StatementBuilder(Config.protocol
				+ "://" + Config.host);

		if (!statement.checkConnection())
		{
			System.out.println("Connection is down .. ");
			controlPanel
					.showErrorMsg("The EMu web server is not running!<br><br>Restart the server and try again");
			return false;
		}

		// set for gc
		statement = null;
		String xMouse = String.valueOf(mouseLocation[0]);
		String yMouse = String.valueOf(mouseLocation[1]);
		String zMouse = String.valueOf(mouseLocation[2]);

		String[] setFields = { Config.locationX, Config.locationY,
				Config.locationZ };
		String[] setFieldValues = { xMouse, yMouse, zMouse };
		String[] whereFieldNames = { Config.locationTableKey };
		String[] whereFieldValues = { l.getLocationIrn() };

		statement = new StatementBuilder(setFields, Config.locationTable,
				setFieldValues, whereFieldNames, Config.protocol + "://"
						+ Config.host, whereFieldValues);

		if (statement.execute() == 0)
		{
			System.out.println("The Update Statement Failed .. ");
			controlPanel.showErrorMsg("The Update Statement Failed!");
			return false;
		}

		Config.locationChange = false;
		ObjectLocator loc = (ObjectLocator) controlPanel.getApplet();

		// add the location to the list of query items
		Config.extraLocationIrns.add(l.getLocationIrn());

		// call the queryLocations method so that the dot refreshes
		if (!loc.queryLocations())
		{
			System.out.println("Error querying locations ..");
			controlPanel.showErrorMsg("Error querying locations");
			return false;
		}

		// now refresh button
		controlPanel.changeButtonIcons();
		controlPanel.refreshLocationProperties();
		
		return true;
	}

	// scroll the window
	public void mouseDragged(MouseEvent e)
	{
		// The user is dragging us, so scroll!
		Rectangle r = new Rectangle(e.getX(), e.getY(), 1, 1);
		scrollRectToVisible(r);
	}

	// scrollable listener methods
	public Dimension getPreferredSize()
	{
		return new Dimension((int) (Config.maxXMapPixels * Config.scale),
				(int) (Config.maxYMapPixels * Config.scale));
	}

	// scrolling method
	public Dimension getPreferredScrollableViewportSize()
	{
		return getPreferredSize();
	}

	public int getScrollableUnitIncrement(Rectangle visibleRect,
			int orientation, int direction)
	{
		// Get the current position.
		int currentPosition = 0;
		if (orientation == SwingConstants.HORIZONTAL)
			currentPosition = visibleRect.x;
		else
			currentPosition = visibleRect.y;

		// Return the number of pixels between currentPosition
		// and the nearest tick mark in the indicated direction.
		if (direction < 0)
		{
			int newPosition = currentPosition
					- (currentPosition / maxUnitIncrement) * maxUnitIncrement;
			return (newPosition == 0) ? maxUnitIncrement : newPosition;
		}
		else
		{
			return ((currentPosition / maxUnitIncrement) + 1)
					* maxUnitIncrement - currentPosition;
		}
	}

	public int getScrollableBlockIncrement(Rectangle visibleRect,
			int orientation, int direction)
	{
		return ((orientation == SwingConstants.HORIZONTAL) ? (visibleRect.width - maxUnitIncrement)
				: (visibleRect.height - maxUnitIncrement));
	}

	public boolean getScrollableTracksViewportWidth()
	{
		return false;
	}

	public boolean getScrollableTracksViewportHeight()
	{
		return false;
	}

	public void setMaxUnitIncrement(int pixels)
	{
		maxUnitIncrement = pixels;
	}
}
