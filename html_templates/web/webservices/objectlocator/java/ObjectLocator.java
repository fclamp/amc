/*
 * ObjectLocator
 *
 * Created on 27 September 2005, 10:46
 */

import java.awt.Color;
import java.awt.Dimension;
import java.awt.Font;
import java.awt.geom.Ellipse2D;
import java.net.URL;
import java.security.InvalidParameterException;
import java.util.ArrayList;
import java.util.Iterator;

import javax.swing.BoxLayout;
import javax.swing.JApplet;
import javax.swing.JEditorPane;
import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.SwingUtilities;
import javax.swing.UIManager;
import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;

import org.xml.sax.SAXParseException;
import org.xml.sax.helpers.DefaultHandler;

/**
 * 
 * @author martin
 */
public class ObjectLocator extends JApplet
{
	private static final long serialVersionUID = 1L;

	// the control panel on the left
	private ControlPanel controlPanel = null;

	// the scroll pane on the right
	private JScrollPane scrollMapPanel = null;

	// the html pane which will be inside the scroll pane on the right
	private JEditorPane statusMessages = null;

	// map panel
	private MapPanel mp = null;

	// init - abstract function of JApplet
	public void init()
	{
		URL codeBase = this.getCodeBase();
		Config.host = codeBase.getHost();
		Config.protocol = codeBase.getProtocol();
		Config.base = codeBase.toString();

		try
		{
			UIManager.setLookAndFeel(UIManager.getSystemLookAndFeelClassName());
			SwingUtilities.updateComponentTreeUI(this);
		}
		catch (Exception e)
		{
			e.printStackTrace();
		}

		try
		{
			processParameters();
		}
		catch (InvalidParameterException e)
		{
			System.out.println("Processing the Parameters Failed: " + e);
		}

		try
		{
			MapReader.readMaps(this);
		}
		catch (NumberFormatException e)
		{
			System.out.println("Reading the maps failed: " + e);
		}

		createPanels();
		loadLabels();
	}
	
	/**
	 * Load the labels from the XML file on the server
	 *
	 */
	private void loadLabels()
	{
		DefaultHandler handler = null;
		handler = new ParseLabels();

		SAXParserFactory factory = SAXParserFactory.newInstance();
		{
			try
			{
				SAXParser saxParser = factory.newSAXParser();
				saxParser.parse(Config.base + Config.labels, handler);
				//ParseLabels l = (ParseLabels) handler;
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
	}

	// start the main process
	public void start()
	{
		showStatus("Querying EMu ... ");

		if (checkConnection())
		{
			ArrayList results = queryRecords();
			showStatus("Displaying " + results.size() + " records ... ");

			// add the dots to the control panel
			if (results.size() > 0)
				mp.addResults(results);
			else
			{
				System.out.println("No Results Found .. ");
				showStatus("No Results Found .. ");
				mp.addResults(results);
			}

			// refresh the panel
			controlPanel.refreshProperties();
		}
		else
		{
			System.out.println("EMu web is not running .. ");
			showStatus("EMu web is not running .. ");

			// add no results to the Map Panel so that a refresh can be made
			ArrayList results = new ArrayList();
			mp.addResults(results);

			// refresh the panel
			controlPanel.refreshProperties();
		}
	}

	// check the texxmlserver connection
	private boolean checkConnection()
	{
		QueryBuilder queryCheck = new QueryBuilder(Config.protocol + "://"
				+ Config.host);
		return queryCheck.checkConnection();
	}

	// update the catalogue references
	public boolean updateCatalogueRefs(Location loc, ArrayList objects)
	{
		// get the code base and check connection
		StatementBuilder statement = new StatementBuilder(Config.protocol
				+ "://" + Config.host);

		if (!statement.checkConnection())
		{
			System.out.println("Connection is down .. ");
			controlPanel
					.showErrorMsg("The EMu web server is not running! Restart the server and try again");
			showStatus("EMu web is not running .. ");
			return false;
		}

		int numberOfObjects = objects.size();
		String[] whereFieldNames = new String[numberOfObjects];
		String[] whereFieldValues = new String[numberOfObjects];

		// set for gc
		statement = null;

		String[] setFields = { Config.locationField };
		String[] setFieldValues = { loc.getLocationIrn() };

		for (int i = 0; i < numberOfObjects; i++)
		{
			whereFieldNames[i] = Config.mainTableKey;
			Dot aDot = (Dot) objects.get(i);
			whereFieldValues[i] = aDot.getCatalogueIrn();
		}

		statement = new StatementBuilder(setFields, Config.mainTable,
				setFieldValues, whereFieldNames, Config.protocol + "://"
						+ Config.host, whereFieldValues);

		if (statement.execute() == 0)
		{
			System.out.println("The Update Statement Failed .. ");
			controlPanel.showErrorMsg("The Update Statement Failed!");
			showStatus("The update statement failed .. ");
			return false;
		}

		controlPanel
				.showStdMsg("Objects have been attached to this location below"
						+ loc.getLocationDescription());
		System.out.println("Objects have been attached to location "
				+ loc.getLocationIrn());

		start();
		return true;
	}

	// query records
	// will get the irns that were passed to the object locator
	// then do a catalogue search and get all the fields
	// then find all the location records and then make all the dot objects
	private ArrayList queryRecords()
	{
		ArrayList objectResults = queryCatalogue();
		ArrayList dots = new ArrayList();

		Iterator iter = objectResults.iterator();
		Result r = null;

		while (iter.hasNext())
		{
			r = (Result) iter.next();

			// System.out.println("Start of Catalogue Record .. ");
			ArrayList fields = r.getFields();
			Iterator fieldsIt = fields.iterator();
			Field f = null;

			while (fieldsIt.hasNext())
			{
				f = (Field) fieldsIt.next();

				String value = f.getValue();
				String fieldName = f.getFieldName();
				// System.out.println(f.toString());

				if (fieldName.equals(Config.locationField))
				{
					// query the location fields
					ArrayList locationResult = queryLocation(value);
					// debug(locationResult);

					if (locationResult.size() <= 0)
						System.out.println("Location Record " + value
								+ " Not Found!");
					else
					{
						// create the dot and add to the collection of dots
						// should only be one location returned - so get the
						// first record
						Dot d = new Dot(r, (Result) locationResult.get(0));
						dots.add(d);
					}
				}
			}

		}

		return dots;
	}

	// query the location records
	public boolean queryLocations()
	{
		String theReturnFields = Config.locationReturnFields;

		if (theReturnFields.equals(""))
		{
			System.out.println("There is no location back fields set!");
			return false;
		}

		// add the location x if necessary because this is needed
		if (Config.locationReturnFields.indexOf(Config.locationX) == -1)
			theReturnFields += ", " + Config.locationX;

		// add the location y if necessary because this is needed
		if (Config.locationReturnFields.indexOf(Config.locationY) == -1)
			theReturnFields += ", " + Config.locationY;

		// add the location z if necessary because this is needed
		if (Config.locationReturnFields.indexOf(Config.locationZ) == -1)
			theReturnFields += ", " + Config.locationZ;

		// add the key if necessary because this is needed
		if (Config.locationReturnFields.indexOf(Config.locationTableKey) == -1)
			theReturnFields += ", " + Config.locationTableKey;

		// add the combo field if necessary because this is needed
		if (Config.locationReturnFields.indexOf(Config.locationComboField) == -1)
			theReturnFields += ", " + Config.locationComboField;

		String[] backFields = theReturnFields.split(",");
		Ellipse2D.Double area = mp.getDotArea();
		double width = area.getWidth();
		double x = area.getX();
		double x2 = x + width;
		double y = area.getY();
		double y2 = y + width;
		StringBuffer whereClause = new StringBuffer("(");

		whereClause.append(Config.locationX);
		whereClause.append(" >= ");
		whereClause.append(x);
		whereClause.append(" AND ");
		whereClause.append(Config.locationX);
		whereClause.append(" <= ");
		whereClause.append(x2);
		whereClause.append(" AND ");
		whereClause.append(Config.locationY);
		whereClause.append(" >= ");
		whereClause.append(y);
		whereClause.append(" AND ");
		whereClause.append(Config.locationY);
		whereClause.append(" <= ");
		whereClause.append(y2);
		whereClause.append(") ");

		// extra irns to query - used for moving locations and still displaying
		// the other moved locations
		if (Config.extraLocationIrns != null)
		{
			if (Config.extraLocationIrns.size() != 0)
			{
				// iterate through the array list and make the where clause
				Iterator iter = Config.extraLocationIrns.iterator();

				while (iter.hasNext())
				{
					String irn = (String) iter.next();
					whereClause.append(" OR ");
					whereClause.append(Config.locationTableKey);
					whereClause.append(" = ");
					whereClause.append(irn);
				}
			}
		}

		System.out.println("Where Clause: " + whereClause.toString());

		QueryBuilder query = new QueryBuilder(backFields, Config.locationTable,
				Config.protocol + "://" + Config.host, whereClause.toString());
		ArrayList locationResults = query.query();
		// System.out.println("Size of Location Results: " +
		// locationResults.size());

		Iterator iter = locationResults.iterator();
		Result res = null;
		ArrayList theLocs = new ArrayList();

		// go through the results and convert to location records
		while (iter.hasNext())
		{
			res = (Result) iter.next();
			Location loc = new Location(res);
			theLocs.add(loc);
		}

		mp.addLocationResults(theLocs);

		return true;
	}

	// query location record based on irn
	private ArrayList queryLocation(String irn)
	{
		String[] irns = { irn };
		String theReturnFields = Config.locationReturnFields;

		if (theReturnFields.equals(""))
			System.out.println("There is no location back fields set!");

		// add the location x if necessary because this is needed
		if (Config.locationReturnFields.indexOf(Config.locationX) == -1)
			theReturnFields += ", " + Config.locationX;

		// add the location y if necessary because this is needed
		if (Config.locationReturnFields.indexOf(Config.locationY) == -1)
			theReturnFields += ", " + Config.locationY;

		// add the location z if necessary because this is needed
		if (Config.locationReturnFields.indexOf(Config.locationZ) == -1)
			theReturnFields += ", " + Config.locationZ;

		String[] backFields = theReturnFields.split(",");

		QueryBuilder query = new QueryBuilder(backFields, Config.locationTable,
				irns, Config.locationTableKey, Config.protocol + "://"
						+ Config.host);
		ArrayList locationResults = query.query();

		return locationResults;
	}

	// retuns list of result objects - query is based on what params are passed
	// to the object locator
	private ArrayList queryCatalogue()
	{
		String[] irns = Config.queryIrn.split(",");
		String theReturnFields = Config.returnFields;

		if (theReturnFields.equals(""))
			System.out.println("There is no catalogue back fields set!");

		// add the irn if necessary because this is needed for the link
		if (Config.returnFields.indexOf(Config.mainTableKey) == -1)
			theReturnFields += ", " + Config.mainTableKey;

		// add the location field if necessary because this is needed
		if (Config.returnFields.indexOf(Config.locationField) == -1)
			theReturnFields += ", " + Config.locationField;

		// add the media field if necessary because this is needed
		if (Config.returnFields.indexOf(Config.mediaField) == -1)
			theReturnFields += ", " + Config.mediaField;

		String[] theBackFields = theReturnFields.split(",");
		QueryBuilder query = new QueryBuilder(theBackFields, Config.mainTable,
				irns, Config.mainTableKey, Config.protocol + "://"
						+ Config.host);
		ArrayList objectResults = query.query();

		return objectResults;
	}

	// display all the panels on the screen
	private void createPanels()
	{
		// create map panel and control panel
		mp = new MapPanel(this);
		controlPanel = new ControlPanel(mp, this);

		scrollMapPanel = new JScrollPane(mp,
				JScrollPane.VERTICAL_SCROLLBAR_AS_NEEDED,
				JScrollPane.HORIZONTAL_SCROLLBAR_AS_NEEDED);
		scrollMapPanel.setBackground(new Color(Config.normalBackgroundColour));

		JPanel messagePanel = new JPanel();
		messagePanel.setBackground(new Color(Config.normalBackgroundColour));
		messagePanel.setLayout(new BoxLayout(messagePanel, BoxLayout.Y_AXIS));
		messagePanel.setAlignmentX(CENTER_ALIGNMENT);

		statusMessages = new JEditorPane();
		statusMessages.setContentType("text/html");
		statusMessages.setFont(new Font("Tahoma", Font.PLAIN, 12));
		statusMessages.setEditable(false);
		statusMessages.setHighlighter(null);
		statusMessages.setBackground(new Color(Config.normalBackgroundColour));
		statusMessages
				.addHyperlinkListener(new LinkFollower(getAppletContext()));

		HTTPReader styleContent = new HTTPReader(Config.base
				+ Config.stylesheet);

		// System.out.println("Style Content: " + styleContent.getContent());

		/*
		 * HTMLEditorKit kit = (HTMLEditorKit) statusMessages.getEditorKit();
		 * StyleSheet style = new StyleSheet(); // set up the stylesheet for the
		 * JEditorPane try { URL styleLoc = new
		 * URL(this.getCodeBase().toString() + Config.stylesheet);
		 * style.importStyleSheet(styleLoc); } catch(MalformedURLException e) {
		 * System.out.println("Error with URL: " + e); }
		 * 
		 * kit.setStyleSheet(style); statusMessages.setEditorKit(kit);
		 */

		// need a reference the the pane and control panel
		mp.setReferences(scrollMapPanel, controlPanel);
		controlPanel.setEditorReference(statusMessages);
		controlPanel.setStyleSheet(styleContent.getContent());

		JScrollPane statusScrollPane = new JScrollPane(statusMessages);
		statusScrollPane.setPreferredSize(new Dimension(250, 145));
		messagePanel.add(statusScrollPane);

		JPanel contentPanel = new JPanel();
		contentPanel.setBackground(new Color(Config.normalBackgroundColour));
		contentPanel.setLayout(new BoxLayout(contentPanel, BoxLayout.X_AXIS));

		if(!Config.report)
			contentPanel.add(controlPanel);
		
		contentPanel.add(scrollMapPanel);
		
		if(!Config.report)
			contentPanel.add(messagePanel);
		
		contentPanel.setOpaque(true);
		setContentPane(contentPanel);
	}

	// process the parameters passed to the applet
	// plans - planLocation - queryIrn and imageLocation are the only
	// params that are needed and will throw a InvalidParameterException
	// if they dont exist
	private void processParameters() throws InvalidParameterException
	{
		if (getParameter("queryIrn") != null)
			Config.queryIrn = getParameter("queryIrn");
		else
		{
			System.out.println("Error: queryIrn Parameter is missing");
			showStatus("Parameter Error (check java console)");
			throw new InvalidParameterException();
		}
		
		if (getParameter("report") != null)
			Config.report = Boolean.valueOf(getParameter("report")).booleanValue();
		else
			Config.report = false;

		System.out.println("Report: " + Config.report);
		
		if (getParameter("planLocation") != null)
			Config.planLocation = getParameter("planLocation");
		else
		{
			System.out.println("Error: planLocation Parameter is missing");
			showStatus("Parameter Error (check java console)");
			throw new InvalidParameterException();
		}

		if (getParameter("plans") != null)
			Config.plansParam = getParameter("plans");
		else
		{
			System.out.println("Error: plans Parameter is missing");
			showStatus("Parameter Error (check java console)");
			throw new InvalidParameterException();
		}

		if (getParameter("locatorWebService") != null)
			Config.serverInterface = getParameter("locatorWebService");
		else
		{
			System.out.println("Error: locatorWebService Parameter is missing");
			showStatus("Parameter Error (check java console)");
			throw new InvalidParameterException();
		}

		if (getParameter("imageLocation") != null)
			Config.imageLocation = getParameter("imageLocation");
		else
		{
			System.out.println("Error: imageLocation Parameter is missing");
			showStatus("Parameter Error (check java console)");
			throw new InvalidParameterException();
		}

		// field used for linking to EMu web
		if (getParameter("linkField") != null)
			Config.linkField = getParameter("linkField");
		else
		{
			System.out.println("Warning: linkField Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("dotSize") != null)
			Config.dotSize = Integer.parseInt(getParameter("dotSize"));
		else
		{
			System.out.println("Warning: dotSize Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("zoomStep") != null)
			Config.zoomStep = (double) (Integer
					.parseInt(getParameter("zoomStep"))) / 100;
		else
		{
			System.out.println("Warning: zoomStep Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("dotFillColour") != null)
			Config.dotFillColour = Integer.parseInt(getParameter(
					"dotFillColour").replaceAll("#", ""), 16);
		else
		{
			System.out.println("Warning: dotFillColor Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("dotBorderColour") != null)
			Config.dotBorderColour = Integer.parseInt(getParameter(
					"dotBorderColour").replaceAll("#", ""), 16);
		else
		{
			System.out.println("Warning: dotBorderColour Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("dotHighlightFillColour") != null)
			Config.dotHighlightFillColour = Integer.parseInt(getParameter(
					"dotHighlightFillColour").replaceAll("#", ""), 16);
		else
		{
			System.out
					.println("Warning: dotHighlightFillColour Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("dotHighlightBorderColour") != null)
			Config.dotHighlightBorderColour = Integer.parseInt(getParameter(
					"dotHighlightBorderColour").replaceAll("#", ""), 16);
		else
		{
			System.out
					.println("Warning: dotHighlightBorderColour Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("pointerColour") != null)
			Config.pointerColour = Integer.parseInt(getParameter(
					"pointerColour").replaceAll("#", ""), 16);
		else
		{
			System.out.println("Warning: pointerColour Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("pointerBorderColour") != null)
			Config.pointerBorderColour = Integer.parseInt(getParameter(
					"pointerBorderColour").replaceAll("#", ""), 16);
		else
		{
			System.out
					.println("Warning: pointerBorderColour Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("normalBackgroundColour") != null)
			Config.normalBackgroundColour = Integer.parseInt(getParameter(
					"normalBackgroundColour").replaceAll("#", ""), 16);
		else
		{
			System.out
					.println("Warning: normalBackgroundColour Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("fadedTextColour") != null)
			Config.fadedTextColour = Integer.parseInt(getParameter(
					"fadedTextColour").replaceAll("#", ""), 16);
		else
		{
			System.out.println("Warning: fadedTextColour Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("highlightTextColour") != null)
			Config.highlightTextColour = Integer.parseInt(getParameter(
					"highlightTextColour").replaceAll("#", ""), 16);
		else
		{
			System.out
					.println("Warning: highlightTextColour Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("dotShape") != null)
			Config.dotShape = getParameter("dotShape");
		else
		{
			System.out.println("Warning: dotShape Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("webObjectPage") != null)
			Config.webPage = getParameter("webObjectPage");
		else
		{
			System.out.println("Warning: webObjectPage Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("mediaPage") != null)
			Config.mediaPage = getParameter("mediaPage");
		else
		{
			System.out.println("Warning: mediaPage Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("searchMedia") != null)
			Config.searchMedia = Boolean.valueOf(getParameter("searchMedia"))
					.booleanValue();
		else
		{
			System.out.println("Warning: searchMedia Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("mediaLink") != null)
			Config.mediaLink = getParameter("mediaLink");
		else
		{
			System.out.println("Warning: mediaLink Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("decimalPlaces") != null)
			Config.decimalPlaces = getParameter("decimalPlaces");
		else
		{
			System.out.println("Warning: decimalPlaces Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("returnFields") != null)
			Config.returnFields = getParameter("returnFields");
		else
		{
			System.out.println("Warning: returnFields Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("locationReturnFields") != null)
			Config.locationReturnFields = getParameter("locationReturnFields");
		else
		{
			System.out
					.println("Warning: locationReturnFields Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("dataName") != null)
			Config.dataName = getParameter("dataName");
		else
		{
			System.out.println("Warning: dataName Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("locationDotFillColor") != null)
			Config.locDotFillColour = Integer.parseInt(getParameter(
					"locationDotFillColor").replaceAll("#", ""), 16);
		else
		{
			System.out
					.println("Warning: locationDotFillColor Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("locationDotBorderColor") != null)
			Config.locDotBorderColour = Integer.parseInt(getParameter(
					"locationDotBorderColor").replaceAll("#", ""), 16);
		else
		{
			System.out
					.println("Warning: locationDotBorderColor Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("locationDotHighlightFillColor") != null)
			Config.locDotHighlightFillColour = Integer.parseInt(getParameter(
					"locationDotHighlightFillColor").replaceAll("#", ""), 16);
		else
		{
			System.out
					.println("Warning: locationDotBorderColor Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("locationDotHighlightBorderColor") != null)
		{
			Config.locDotHighlightBorderColour = Integer.parseInt(getParameter(
					"locationDotHighlightBorderColor").replaceAll("#", ""), 16);
		}
		else
		{
			System.out
					.println("Warning: locationDotHighlightBorderColor Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("locationRangeQuery") != null)
			Config.locRange = Double
					.parseDouble(getParameter("locationRangeQuery"));
		else
		{
			System.out
					.println("Warning: locationRangeQuery Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("autoPopup") != null)
			Config.autoPopup = Boolean.valueOf(getParameter("autoPopup"))
					.booleanValue();
		else
		{
			System.out.println("Warning: autoPopup Parameter is missing");
			showStatus("Parameter Error (check java console)");
		}

		if (getParameter("disableUpdate") != null)
			Config.disableUpdate = Boolean.valueOf(
					getParameter("disableUpdate")).booleanValue();
		else
		{
			System.out.println("Warning: disableUpdate Parameter is missing");
			showStatus("Parameter Error (check java console");
		}
	}

	// main method
	/*
	 * public static void main(String s[]) { JFrame f = new JFrame("KE Object
	 * Locator");
	 * 
	 * f.addWindowListener(new WindowAdapter() { public void
	 * windowClosing(WindowEvent e) { System.exit(0); } });
	 * 
	 * JApplet applet = new ObjectLocator(); f.getContentPane().add("Center",
	 * applet);
	 * 
	 * applet.init(); f.pack(); f.setVisible(true); }
	 */

	/**
	 * Create the GUI and show it. For thread safety, this method should be
	 * invoked from the event-dispatching thread.
	 */
	private static void createAndShowGUI()
	{
		// Make sure we have nice window decorations.
		JFrame.setDefaultLookAndFeelDecorated(true);

		// Create and set up the window.
		JFrame frame = new JFrame("KE Object Locator");
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);

		JApplet applet = new ObjectLocator();
		frame.getContentPane().add("Center", applet);

		applet.init();
		frame.pack();
		frame.setVisible(true);
	}

	public static void main(String s[])
	{

		// Schedule a job for the event-dispatching thread:
		// creating and showing this application's GUI.
		javax.swing.SwingUtilities.invokeLater(new Runnable()
		{
			public void run()
			{
				createAndShowGUI();
			}
		});

	}

}
