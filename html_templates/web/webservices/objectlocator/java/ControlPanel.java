/*
 * ControlPanel.java
 *
 * Created on 27 September 2005, 16:41
 */

import java.awt.Color;
import java.awt.Component;
import java.awt.Cursor;
import java.awt.Dimension;
import java.awt.Font;
import java.awt.GridLayout;
import java.awt.Insets;
import java.awt.Rectangle;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.Iterator;
import java.applet.AppletContext;

import javax.swing.BoxLayout;
import javax.swing.ButtonGroup;
import javax.swing.ImageIcon;
import javax.swing.JApplet;
import javax.swing.JButton;
import javax.swing.JComboBox;
import javax.swing.JEditorPane;
import javax.swing.JPanel;
import javax.swing.JRadioButton;
import javax.swing.border.LineBorder;
import javax.swing.border.TitledBorder;


/**
 * @author martin
 * 
 */
public class ControlPanel extends JPanel implements ActionListener
{

	private static final long serialVersionUID = 1L;

	private MapPanel mp;

	private javax.swing.Timer timer;

	private double miniStep;

	private int step;

	private int halfXMapPixels;

	private int halfYMapPixels;

	private JRadioButton[] buttons;

	private ObjectLocator theApplet = null;

	private JEditorPane editor = null;

	private ImageIcon zoomInIcon = null;

	private ImageIcon zoomOutIcon = null;

	private ImageIcon noGridIcon = null;

	private ImageIcon gridIcon = null;

	private ImageIcon changeIcon = null;

	private ImageIcon undoIcon = null;

	private ImageIcon storeIcon = null;

	private ImageIcon queryIcon = null;

	private ImageIcon locQueryIcon = null;

	private ImageIcon lassoIcon = null;

	private ImageIcon targetIcon = null;

	private ImageIcon printIcon = null;

	private int zoomStepUnits = 6;

	private JButton gridButton = null;

	private JButton changeButton = null;

	private JButton storeButton = null;

	private JButton queryButton = null;

	private JButton attachButton = null;

	private JButton lassoButton = null;

	private JComboBox combo = null;

	// this is location storage for moving a location
	private Location theSelectedLoc = null;

	// this is for attaching objects (to update the location ref)
	private ArrayList theSelectedObjects = null;

	// the style sheet to be applied to each JEditorPane message
	private String stylesheet = "";

	public ControlPanel(MapPanel mp, ObjectLocator j)
	{
		this.theApplet = j;
		URL url = null;

		try
		{
			// should use cached images if there
			// zoom in icon
			url = new URL(Config.base + "/" + Config.imageLocation + "/"
					+ Config.zoomInIcon);
			zoomInIcon = new ImageIcon(url);

			// zoom out icon
			url = new URL(Config.base + "/" + Config.imageLocation + "/"
					+ Config.zoomOutIcon);
			zoomOutIcon = new ImageIcon(url);

			// no grid icon
			url = new URL(Config.base + "/" + Config.imageLocation + "/"
					+ Config.noGridIcon);
			noGridIcon = new ImageIcon(url);

			// grid icon
			url = new URL(Config.base + "/" + Config.imageLocation + "/"
					+ Config.gridIcon);
			gridIcon = new ImageIcon(url);

			// change icon
			url = new URL(Config.base + "/" + Config.imageLocation + "/"
					+ Config.changeIcon);
			changeIcon = new ImageIcon(url);

			// undo icon
			url = new URL(Config.base + "/" + Config.imageLocation + "/"
					+ Config.undoIcon);
			undoIcon = new ImageIcon(url);

			// store icon
			url = new URL(Config.base + "/" + Config.imageLocation + "/"
					+ Config.storeIcon);
			storeIcon = new ImageIcon(url);

			// catalogue icon
			url = new URL(Config.base + "/" + Config.imageLocation + "/"
					+ Config.catalogueIcon);
			queryIcon = new ImageIcon(url);

			// location icon
			url = new URL(Config.base + "/" + Config.imageLocation + "/"
					+ Config.locationIcon);
			locQueryIcon = new ImageIcon(url);

			// lasso tool icon
			url = new URL(Config.base + "/" + Config.imageLocation + "/"
					+ Config.lassoIcon);
			lassoIcon = new ImageIcon(url);

			// target icon
			url = new URL(Config.base + "/" + Config.imageLocation + "/"
					+ Config.targetIcon);
			targetIcon = new ImageIcon(url);

			// print icon
			url = new URL(Config.base + "/" + Config.imageLocation + "/"
					+ Config.printIcon);
			printIcon = new ImageIcon(url);
		}
		catch (MalformedURLException e)
		{
			System.out.println("MalformedURLException: " + e);
		}

		leftPanel(mp);
	}

	public JApplet getApplet()
	{
		return this.theApplet;
	}

	// get the selected location
	public Location getSelectedLoc()
	{
		return this.theSelectedLoc;
	}

	public void setEditorReference(JEditorPane e)
	{
		this.editor = e;
	}

	public void setStyleSheet(String style)
	{
		this.stylesheet = style;
	}

	public void pan()
	{
		mp.setSize((int) (Config.scale * Config.xMapPixels),
				(int) (Config.scale * Config.yMapPixels));

		int newX = (int) (Config.scale * mp.getPointerX());
		int newY = (int) (Config.scale * mp.getPointerY());

		Rectangle r = new Rectangle(newX - halfXMapPixels, newY
				- halfYMapPixels, Config.xMapPixels, Config.yMapPixels);
		mp.scrollRectToVisible(r);
	}

	public void stopPan()
	{
		mp.repaint();
	}

	public void leftPanel(MapPanel mp)
	{
		this.mp = mp;
		this.setAlignmentY(TOP_ALIGNMENT);
		this.setAlignmentX(CENTER_ALIGNMENT);

		setBackground(new Color(Config.normalBackgroundColour));
		setLayout(new BoxLayout(this, BoxLayout.Y_AXIS));
		Font font = new java.awt.Font("Tahoma", Font.PLAIN, 12);
		Font sfont = new java.awt.Font("Tahoma", Font.PLAIN, 10);
		Insets bMargin = new Insets(1, 1, 1, 1);

		JPanel buttonPanel2 = new JPanel();
		buttonPanel2.setLayout(new GridLayout(0, 3));
		buttonPanel2.setBackground(new Color(Config.normalBackgroundColour));
		
		// used to have html in this button
		JButton b4 = new JButton();
		b4.setActionCommand("zoomin");
		b4.setToolTipText("zoom in on map");
		b4.addActionListener(this);
		b4.setFont(sfont);
		b4.setMargin(bMargin);
		b4.setIcon(zoomInIcon);
		b4.setSelectedIcon(zoomInIcon);
		b4.setBackground(new Color(Config.normalBackgroundColour));
		buttonPanel2.add(b4);

		JButton b5 = new JButton();
		b5.setActionCommand("zoomout");
		b5.setToolTipText("zoom out on map");
		b5.addActionListener(this);
		b5.setFont(sfont);
		b5.setMargin(bMargin);
		b5.setIcon(zoomOutIcon);
		b5.setSelectedIcon(zoomOutIcon);
		b5.setBackground(new Color(Config.normalBackgroundColour));
		buttonPanel2.add(b5);

		gridButton = new JButton();
		gridButton.setActionCommand("grid");
		gridButton.setToolTipText("overlay a grid on map");
		gridButton.addActionListener(this);
		gridButton.setFont(font);
		gridButton.setMargin(bMargin);

		// set up icon
		if (Config.showGrid)
		{
			gridButton.setIcon(noGridIcon);
			gridButton.setSelectedIcon(noGridIcon);
		}
		else
		{
			gridButton.setIcon(gridIcon);
			gridButton.setSelectedIcon(gridIcon);
		}

		gridButton.setBackground(new Color(Config.normalBackgroundColour));
		buttonPanel2.add(gridButton);

		// set up the lasso tool button
		lassoButton = new JButton();
		lassoButton.setActionCommand("lasso");
		lassoButton.setToolTipText("turn on the lasso tool");
		lassoButton.addActionListener(this);
		lassoButton.setFont(font);
		lassoButton.setMargin(bMargin);

		if (!mp.isLassoOn())
		{
			lassoButton.setIcon(lassoIcon);
			lassoButton.setSelectedIcon(lassoIcon);
		}
		else
		{
			lassoButton.setIcon(targetIcon);
			lassoButton.setSelectedIcon(targetIcon);
		}

		lassoButton.setBackground(new Color(Config.normalBackgroundColour));
		buttonPanel2.add(lassoButton);

		// the store button
		if (!Config.disableUpdate)
		{
			storeButton = new JButton();
			storeButton.setActionCommand("store");
			storeButton.setToolTipText("store the selected location");
			storeButton.addActionListener(this);
			storeButton.setFont(font);
			storeButton.setMargin(bMargin);
			storeButton.setIcon(storeIcon);
			storeButton.setSelectedIcon(storeIcon);
			storeButton.setBackground(new Color(Config.normalBackgroundColour));
			buttonPanel2.add(storeButton);
		}

		// the query button
		queryButton = new JButton();
		queryButton.setActionCommand("query");
		queryButton
				.setToolTipText("switch to different mode (location or catalogue)");
		queryButton.addActionListener(this);
		queryButton.setFont(font);
		queryButton.setMargin(bMargin);

		if (Config.queryLocations)
		{
			queryButton.setIcon(queryIcon);
			queryButton.setSelectedIcon(queryIcon);
		}
		else
		{
			queryButton.setIcon(locQueryIcon);
			queryButton.setSelectedIcon(locQueryIcon);
		}

		queryButton.setBackground(new Color(Config.normalBackgroundColour));
		buttonPanel2.add(queryButton);

		if (!Config.disableUpdate)
		{
			changeButton = new JButton();
			changeButton.setActionCommand("change");
			changeButton.setToolTipText("change selected location");
			changeButton.addActionListener(this);
			changeButton.setFont(font);
			changeButton.setMargin(bMargin);

			if (!Config.locationChange)
			{
				changeButton.setIcon(changeIcon);
				changeButton.setSelectedIcon(changeIcon);
			}
			else
			{
				changeButton.setIcon(undoIcon);
				changeButton.setSelectedIcon(undoIcon);
			}

			changeButton
					.setBackground(new Color(Config.normalBackgroundColour));
			buttonPanel2.add(changeButton);
		}

		// create the print button
		JButton printButton = new JButton();
		printButton.setActionCommand("print");
		printButton.setToolTipText("print as a report");
		printButton.addActionListener(this);
		printButton.setFont(sfont);
		printButton.setMargin(bMargin);
		printButton.setIcon(printIcon);
		printButton.setSelectedIcon(printIcon);
		printButton.setBackground(new Color(Config.normalBackgroundColour));
		buttonPanel2.add(printButton);
		
		buttonPanel2.setBorder(new TitledBorder(LineBorder
				.createBlackLineBorder(), "Map Controls", TitledBorder.CENTER,
				TitledBorder.TOP, new Font("Tahoma", Font.BOLD, 15), new Color(
						Config.highlightTextColour)));
		buttonPanel2.setAlignmentX(Component.CENTER_ALIGNMENT);
		buttonPanel2.setAlignmentY(Component.TOP_ALIGNMENT);
		buttonPanel2.setMaximumSize(new Dimension(Integer.MAX_VALUE, 10));
		add(buttonPanel2);

		JPanel layerPanel = new JPanel();
		layerPanel.setBackground(new Color(Config.normalBackgroundColour));
		layerPanel.setLayout(new BoxLayout(layerPanel, BoxLayout.Y_AXIS));
		layerPanel.setAlignmentX(Component.CENTER_ALIGNMENT);
		layerPanel.setAlignmentY(Component.TOP_ALIGNMENT);

		ButtonGroup group = new ButtonGroup();
		int numberOfMaps = MapReader.getNumberOfMaps();
		buttons = new JRadioButton[numberOfMaps];

		for (int i = 0; i < numberOfMaps; i++)
		{
			// make button for each plan
			String description = MapReader.getMapName(i);

			// start the count of the number of dots on each map to zero
			// this can be calculated after a query instead
			int count = 0;

			JRadioButton b = new JRadioButton(description);
			b.setActionCommand(Integer.toString(i));
			b.setFont(font);

			// need ths so that two windows can be opened and run simultaneously 
			if (MapReader.hasBeenRead())
			{
				if (MapReader.getMapIndex() == i)
					b.setSelected(true);
				else
					b.setSelected(false);
			}
			else
			{
				if (i == 0)
					b.setSelected(true);
				else
					b.setSelected(false);
			}

			if (count == 0)
				b.setForeground(new Color(Config.fadedTextColour));
			else
				b.setForeground(new Color(Config.highlightTextColour));

			b.setToolTipText("click to view " + description + " (" + count
					+ " Records Here)");
			b.addActionListener(this);
			b.setBackground(new Color(Config.normalBackgroundColour));

			buttons[i] = b;
			group.add(buttons[i]);
			layerPanel.add(buttons[i]);
		}

		layerPanel.setBorder(new TitledBorder(LineBorder
				.createBlackLineBorder(), "Select Map", TitledBorder.CENTER,
				TitledBorder.TOP, new Font("Tahoma", Font.BOLD, 15), new Color(
						Config.highlightTextColour)));
		layerPanel.setMaximumSize(new Dimension(Integer.MAX_VALUE, 10));

		add(layerPanel);

		// start combo panel
		JPanel comboPanel = new JPanel();
		comboPanel.setLayout(new GridLayout(10, 1, 0, 1));
		comboPanel.setBackground(new Color(Config.normalBackgroundColour));

		// add the button for attaching objects to locations
		if (!Config.disableUpdate)
		{
			attachButton = new JButton("Attach Location to Objects");
			attachButton.setActionCommand("attach");
			attachButton.setToolTipText("attach to location");
			attachButton.addActionListener(this);
			attachButton.setFont(font);
			attachButton.setMargin(bMargin);

			if (Config.queryLocations)
				attachButton.setEnabled(true);
			else
				attachButton.setEnabled(false);

			comboPanel.add(attachButton);

			// add a combo box for record selection
			combo = new JComboBox();
			combo.setMaximumRowCount(8);
			combo.setEditable(false);

			if (Config.queryLocations)
				combo.setEnabled(true);
			else
				combo.setEnabled(false);

			comboPanel.add(combo);

			// set the combo box panel border
			comboPanel.setBorder(new TitledBorder(LineBorder
					.createBlackLineBorder(), "Locations Selected",
					TitledBorder.CENTER, TitledBorder.TOP, new Font("Tahoma",
							Font.BOLD, 15), new Color(
							Config.highlightTextColour)));
		}

		// set up icon
		b4.setIcon(zoomInIcon);
		b4.setSelectedIcon(zoomInIcon);

		b4.setBackground(new Color(Config.normalBackgroundColour));
		buttonPanel2.add(b4);

		comboPanel.setMaximumSize(new Dimension(Integer.MAX_VALUE,
				Integer.MAX_VALUE));

		add(comboPanel);
		// end combo panel

		setCursor(Cursor.getPredefinedCursor(Cursor.DEFAULT_CURSOR));
		miniStep = Config.zoomStep / zoomStepUnits;
		step = 0;

		timer = new javax.swing.Timer(10, new ActionListener()
		{
			public void actionPerformed(ActionEvent evt)
			{
				Config.scale += miniStep;
				pan();
				if (step++ > zoomStepUnits)
				{
					timer.stop();
					step = 0;
					stopPan();
				}
			}
		});

		timer.stop();
		halfXMapPixels = Config.xMapPixels / 2;
		;
		halfYMapPixels = Config.yMapPixels / 2;
	}

	// used to buttons once pressed
	public void changeButtonIcons()
	{
		if (Config.showGrid)
		{
			gridButton.setIcon(noGridIcon);
			gridButton.setSelectedIcon(noGridIcon);
		}
		else
		{
			gridButton.setIcon(gridIcon);
			gridButton.setSelectedIcon(gridIcon);
		}

		// used for the lasso and target icons 
		if (!mp.isLassoOn())
		{
			lassoButton.setIcon(lassoIcon);
			lassoButton.setSelectedIcon(lassoIcon);
			lassoButton.setRolloverIcon(lassoIcon);
		}
		else
		{
			lassoButton.setIcon(targetIcon);
			lassoButton.setSelectedIcon(targetIcon);

			// im not sure why i need this - the image disappears without it 
			lassoButton.setRolloverIcon(targetIcon);
		}

		if (!Config.disableUpdate)
		{
			if (Config.locationChange)
			{
				changeButton.setIcon(undoIcon);
				changeButton.setSelectedIcon(undoIcon);
			}
			else
			{
				changeButton.setIcon(changeIcon);
				changeButton.setSelectedIcon(changeIcon);
			}
		}

		if (Config.queryLocations)
		{
			queryButton.setIcon(queryIcon);
			queryButton.setSelectedIcon(queryIcon);

			if (!Config.disableUpdate)
			{
				attachButton.setEnabled(true);
				combo.setEnabled(true);
			}
		}
		else
		{
			queryButton.setIcon(locQueryIcon);
			queryButton.setSelectedIcon(locQueryIcon);

			if (!Config.disableUpdate)
			{
				attachButton.setEnabled(false);
				combo.setEnabled(false);
			}
		}
	}

	// clear the combo boxes
	public void clearComboBox()
	{
		if (!Config.disableUpdate)
			combo.removeAllItems();
	}

	// add an item to the combo box
	public void addItemToComboBox(Location l)
	{
		if (!Config.disableUpdate)
			combo.addItem(l);
	}

	// popup the combo box to show which locations are selected
	public void showPopup()
	{
		if (!Config.disableUpdate)
		{
			if (combo.getItemCount() > 0)
				combo.showPopup();
		}
	}

	// will refresh the location properties of each map
	public void refreshLocationProperties()
	{
		ArrayList locs = mp.getLocationResults();

		// reset the number of dots on each map
		for (int j = 0; j < MapReader.getNumberOfMaps(); j++)
			MapReader.resetDotsOnMap(j);

		// set the number of dots per map
		for (int i = 0; i < locs.size(); i++)
		{
			Location l = (Location) locs.get(i);
			double[] coords = l.getCoordinates();

			for (int j = 0; j < MapReader.getNumberOfMaps(); j++)
			{
				if (mp.Intersects(j, coords))
					MapReader.incrementDotsOnMap(j);
			}
		}

		// refresh the properties of the buttons
		for (int i = 0; i < MapReader.getNumberOfMaps(); i++)
		{
			String description = MapReader.getMapName(i);
			Map theMap = MapReader.getMap(i);
			int count = theMap.getNumberOfDots();

			if (count == 0)
				buttons[i].setForeground(new Color(Config.fadedTextColour));
			else
				buttons[i].setForeground(new Color(Config.highlightTextColour));

			buttons[i].setToolTipText("Click to View " + description + " ("
					+ count + " Records Here)");
			buttons[i].addActionListener(this);
			buttons[i].setBackground(new Color(Config.normalBackgroundColour));
		}

	}

	// used to update the properties of radio buttons on new data
	public void refreshProperties()
	{
		ArrayList dots = mp.getResults();

		// reset the number of dots on each map
		for (int j = 0; j < MapReader.getNumberOfMaps(); j++)
			MapReader.resetDotsOnMap(j);

		// set the number of dots per map
		for (int i = 0; i < dots.size(); i++)
		{
			Dot d = (Dot) dots.get(i);
			double[] coords = d.getCoordinates();

			for (int j = 0; j < MapReader.getNumberOfMaps(); j++)
			{
				if (mp.Intersects(j, coords))
					MapReader.incrementDotsOnMap(j);
			}
		}

		// refresh the properties of the buttons
		for (int i = 0; i < MapReader.getNumberOfMaps(); i++)
		{
			String description = MapReader.getMapName(i);
			Map theMap = MapReader.getMap(i);
			int count = theMap.getNumberOfDots();

			if (count == 0)
				buttons[i].setForeground(new Color(Config.fadedTextColour));
			else
				buttons[i].setForeground(new Color(Config.highlightTextColour));

			buttons[i].setToolTipText("Click to View " + description + " ("
					+ count + " Records Here)");
			buttons[i].addActionListener(this);
			buttons[i].setBackground(new Color(Config.normalBackgroundColour));
		}
	}

	// normal message used for results
	public void showMsg(String msg)
	{
		String head = "<html><head><STYLE TYPE=\"text/css\">" + stylesheet
				+ "</style></head><body>";
		String foot = "</body></html>";

		editor.setText(head + msg + foot);
		editor.moveCaretPosition(0);
	}

	// error message
	public void showErrorMsg(String msg)
	{
		String head = "<html><head><STYLE TYPE=\"text/css\">"
				+ stylesheet
				+ "</style></head><body>"
				+ "<center><table width='100%'><tr class='error'><td class='errorBorders' align='center'><b>Error</b></td>"
				+ "</tr><tr class='errorLight'><td class='errorBorders'>";
		String foot = "</td></tr></table></center></body></html>";

		editor.setText(head + msg + foot);
		editor.moveCaretPosition(0);
	}

	// standard information message
	public void showStdMsg(String msg)
	{
		String head = "<html><head><STYLE TYPE=\"text/css\">"
				+ stylesheet
				+ "</style></head><body>"
				+ "<table width='100%'><tr class='content'><td class='borders' align='center'><b>Message</b></td>"
				+ "</tr><tr class='contentLight'><td class='borders'>";
		String foot = "</td></tr></table></body></html>";

		editor.setText(head + msg + foot);
		editor.moveCaretPosition(0);
	}

	// attach the selected dots
	private void attachDots()
	{
		ArrayList dots = mp.getResults();
		theSelectedObjects = new ArrayList();

		if ((dots == null) || (dots.size() == 0))
		{
			System.out.println("No Catalogue Records have been queried");
			showErrorMsg("No Catalogue Records have been queried!");
			this.theSelectedObjects = null;
			return;
		}

		// go through the dots and see which ones are selected
		// add the ones to the theSelectedObjects ArrayList if need be
		for (int i = 0; i < dots.size(); i++)
		{
			Dot theDot = (Dot) dots.get(i);

			if (theDot.isSelected())
				this.theSelectedObjects.add(theDot);
		}

		if (this.theSelectedObjects.size() == 0)
		{
			showErrorMsg("There is no selected object");
			System.out.println("There is no selected object .. ");
			this.theSelectedObjects = null;
			return;
		}

		Iterator iter = theSelectedObjects.iterator();
		String msg = "";

		while (iter.hasNext())
		{
			Dot d = (Dot) iter.next();
			msg += "<tr class='contentLight'><td class='borders'>"
					+ d.getCatalogueIrn() + "</tr></td>";
		}

		if (Config.queryLocations)
			showStdMsg("These Objects have already been attached: " + msg);
		else
			showStdMsg("Objects attached: " + msg);
	}

	// change location of selected
	private boolean changeLocation()
	{
		ArrayList locs = mp.getLocationResults();
		Location l = null;

		if ((locs == null) || (locs.size() == 0))
		{
			System.out.println("No Location Records have been queried");
			showErrorMsg("No Location Records have been queried!");
			this.theSelectedLoc = null;
			return false;
		}

		// first go through all the locs and see if more than one location is
		// selected
		// have to make sure that only one location is selected
		for (int i = 0; i < locs.size(); i++)
		{
			Location theLoc = (Location) locs.get(i);

			if (l == null && theLoc.isSelected())
				l = theLoc;
			else if (theLoc.isSelected())
			{
				if (!l.compareLocations(theLoc))
				{
					showErrorMsg("There is more than one location selected - only one location can be changed at a time!");
					System.out
							.println("There is more than one location selected!");
					this.theSelectedLoc = null;
					return false;
				}
			}
		}

		if (l == null)
		{
			showErrorMsg("There is no selected location - please select a location!");
			System.out.println("There is no selected location .. ");
			this.theSelectedLoc = null;
			return false;
		}

		String msg = l.getLocationDescription();
		String header = "<table width='100%'><tr class='content'><td class='borders' align='center'><b>Location Selected</b></td></tr>";
		showMsg(header
				+ msg
				+ "<tr class='contentLight'><td class='borders' align='center'>"
				+ "Please select a new location with the LEFT mouse button and when you are ready "
				+ "use the RIGHT mouse to update the location - keep in mind that this location might be attached to multiple objects"
				+ "</td></tr></table>");

		// set the selected location - this will be used to update the location
		// record
		this.theSelectedLoc = l;

		return true;
	}

	// attach location to objects that are saved
	private void attachToLocation()
	{
		if (Config.disableUpdate)
		{
			System.out.println("Disable update is on");
			return;
		}

		Location l = (Location) combo.getSelectedItem();

		if (theSelectedObjects != null)
		{
			if (theSelectedObjects.size() > 0)
			{
				if (!theApplet.updateCatalogueRefs(l, theSelectedObjects))
					System.out
							.println("An Error Occured when updating catalogue refs");
			}
			else
			{
				showErrorMsg("There is no attached objects!");
				System.out.println("There is no attached objects");
			}
		}
		else
		{
			showErrorMsg("There is no attached objects!");
			System.out.println("There is no attached objects");
		}
	}
	
	/**
	 * The purpose of this reporter method 
	 * is so that you can have a clean report of the map and its associated objects without having to scroll
	 * so that you have a printable report
	 */
	private void printReport()
	{
		URL url = null;
		AppletContext context = theApplet.getAppletContext();
		
		try
		{
			url = new URL(Config.base + Config.indexFile + "?report=true&irn=" + Config.queryIrn);
			context.showDocument(url, "_kereport");
		}
		catch (Exception e)
		{
			System.out.println("Exception: " + e.getMessage());
		}
	}

	public void actionPerformed(ActionEvent e)
	{
		boolean update = true;

		if ("grid".equals(e.getActionCommand()))
		{
			Config.showGrid = !Config.showGrid;
			changeButtonIcons();
		}
		else if ("zoomin".equals(e.getActionCommand()))
		{
			miniStep = Config.zoomStep / zoomStepUnits;
			timer.start();
		}
		else if ("zoomout".equals(e.getActionCommand()))
		{
			miniStep = -Config.zoomStep / zoomStepUnits;
			timer.start();
		}
		else if ("change".equals(e.getActionCommand()))
		{
			if (Config.queryLocations)
			{
				// if the lasso is on then turn it off
				if (mp.isLassoOn())
				{
					mp.setLasso();
					mp.setPointerX(0);
					mp.setPointerY(0);
					mp.unSelectDots();
					mp.setBoundingBox(null);
				}

				Config.locationChange = !Config.locationChange;

				if (Config.locationChange)
				{
					if (changeLocation())
						changeButtonIcons();
					else
					{
						Config.locationChange = false;
						Config.locationChangeFlag = true;
					}
				}
				else
				{
					Config.locationChange = false;
					Config.locationChangeFlag = false;
					changeButtonIcons();
				}
			}
			else
			{
				showErrorMsg("User must be in location mode to update a location!");
				System.out
						.println("User must be in location mode to update a location");
				Config.locationChange = false;
				Config.locationChangeFlag = true;
				changeButtonIcons();
			}
		}
		else if ("store".equals(e.getActionCommand()))
		{
			attachDots();
			update = false;
		}
		else if ("lasso".equals(e.getActionCommand()))
		{
			if (Config.locationChange && Config.queryLocations)
			{
				showErrorMsg("User cannot select the lasso tool while updating a location");
				System.out
						.println("User cannot select the lasso tool while updating a location");
			}
			else
			{
				mp.setLasso();
				mp.setPointerX(0);
				mp.setPointerY(0);
				mp.unSelectDots();
				mp.setBoundingBox(null);
			}

			changeButtonIcons();
		}
		else if ("query".equals(e.getActionCommand()))
		{
			Config.queryLocations = !Config.queryLocations;

			// need to do thnis otherwise it looks dodgy otherwise it looks dodgy
			if (mp.isLassoOn())
			{
				mp.setPointerX(0);
				mp.setPointerY(0);
			}

			mp.unSelectDots();
			mp.setBoundingBox(null);

			if (Config.queryLocations)
			{
				mp.saveDotArea();
				Config.extraLocationIrns = new ArrayList();

				if (!theApplet.queryLocations())
					System.out
							.println("Query of the location records failed ..");

				refreshLocationProperties();
				changeButtonIcons();
			}
			else
			{
				Config.locationChange = false;
				Config.locationChangeFlag = false;
				refreshProperties();
				changeButtonIcons();
			}
		}
		else if ("attach".equals(e.getActionCommand()))
		{
			attachToLocation();
			update = false;
		}
		else if ("print".equals(e.getActionCommand()))
		{
			printReport();
		}
		else
		{
			if (e.getActionCommand().matches("^[0-9]+"))
			{
				int indexNo = Integer.parseInt(e.getActionCommand());
				MapReader.setCurrentMap(indexNo);
				Config.scale = 1.0;
				mp.setPointerX(0);
				mp.setPointerY(0);
				mp.calculateGridSpacing();
				step = 0;
				JRadioButton b = buttons[MapReader.getMapIndex()];
				b.setEnabled(true);
				pan();
			}
		}

		if (update)
			mp.repaint();
	}
}
