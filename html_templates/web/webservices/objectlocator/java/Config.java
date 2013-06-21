/*
 * Config.java
 *
 * Created on 27 September 2005, 10:56
 */

import java.util.ArrayList;

/**
 * 
 * @author martin
 */
public class Config
{
	// locations
	public static String imageLocation = "images";

	public static String planLocation = "plans";

	// codebase info - defaults but should be auto detected
	public static String host = "localhost";

	public static String protocol = "http";

	public static String base = "";

	// texxmlserver interface
	public static String serverInterface = "";

	// log file name
	public static String logfile = "logger.properties";

	// standard images
	public static String zoomInIcon = "zoomInIcon.gif";

	public static String zoomOutIcon = "zoomOutIcon.gif";

	public static String noGridIcon = "noGrid.gif";

	public static String gridIcon = "grid.gif";

	public static String changeIcon = "update.gif";

	public static String undoIcon = "undo.gif";

	public static String storeIcon = "store.gif";

	public static String locationIcon = "location.gif";

	public static String catalogueIcon = "catalogue.gif";

	public static String lassoIcon = "lasso.gif";
	
	public static String targetIcon = "target.gif";
	
	public static String printIcon = "printPreview.gif";

	// default stylesheet for JEditorPane
	public static String stylesheet = "objectlocator.css";
	
	// default XML file for labels 
	public static String labels = "objectlocator.xml";
	
	// default index file
	public static String indexFile = "index.php";

	// decimal places
	public static String decimalPlaces = "0.00";

	// media
	public static String mediaPage = "";

	public static String mediaLink = "";

	public static boolean searchMedia = true;

	// use for location changing
	public static boolean locationChange = false;

	public static boolean locationChangeFlag = false;

	// settings - and defaults
	public static String plansParam = "";

	public static boolean showGrid = false;

	public static boolean queryLocations = false;

	public static boolean showReference = true;

	public static String dataName = "No Data Name Set! - Please set this in the setup.php file";

	public static String returnFields = "SummaryData";

	public static String locationReturnFields = "PhyLocationX, PhyLocationY, PhyLocationZ";

	public static String locationComboField = "SummaryData";

	public static String webPage = "";

	public static String queryIrn = "";

	public static String linkField = "";

	public static ArrayList extraLocationIrns = null;

	// shouldnt really be changed (tags and fields)
	public static final String mainTable = "ecatalogue";

	public static final String locationTable = "elocations";

	public static final String mainTableKey = "irn_1";

	public static final String locationTableKey = "irn_1";

	public static final String locationField = "LocCurrentLocationRef";

	public static final String mediaField = "MulMultiMediaRef_tab";

	public static final String endOfRecordTag = "record";

	public static final String resultsTag = "results";

	public static final String statusAttribute = "status";

	public static final String locationX = "PhyLocationX";

	public static final String locationY = "PhyLocationY";

	public static final String locationZ = "PhyLocationZ";
	
	public static final String nameAttribute = "name";
	
	public static final String moduleTag = "module";
	
	public static final String fieldTag = "field";

	// map details
	public static int xMapPixels = 800;

	public static int yMapPixels = 600;

	public static int maxXMapPixels = 800;

	public static int maxYMapPixels = 600;

	// location dot
	public static int locDotFillColour = 0xcc33cc;

	public static int locDotBorderColour = 0x336699;

	public static int locDotHighlightFillColour = 0x0066cc;

	public static int locDotHighlightBorderColour = 0x99ccff;

	// standard dot
	public static int dotFillColour = 0xff0000;

	public static int dotBorderColour = 0x336699;

	public static int dotHighlightFillColour = 0xff7f7f;

	public static int dotHighlightBorderColour = 0x99ccff;

	// others
	public static int pointerColour = 0x000000;

	public static int pointerBorderColour = 0xffa0a0;

	public static int normalBackgroundColour = 0xffffff;

	public static int fadedTextColour = 0x7f7f7f;

	public static int highlightTextColour = 0x000000;

	public static int dotSize = 10;

	public static String dotShape = "triangle";

	public static double zoomStep = 0.4;

	public static double scale = 1.0;

	public static boolean autoPopup = true;

	public static boolean disableUpdate = false;
	
	public static boolean report = false;

	// location querying (world coordinates)
	public static double locRange = 700.0f;

	// direction the maps are viewed
	public static final String TOP_VIEW = "TOP";

	public static final String NORTH_VIEW = "NORTH";

	public static final String EAST_VIEW = "EAST";

	public static final String SOUTH_VIEW = "SOUTH";

	public static final String WEST_VIEW = "WEST";

	// max query length
	public static final int MAX_QUERY = 100;

	// cannot be instantiated
	// probably should be a real singleton object
	private Config()
	{

	}
}
