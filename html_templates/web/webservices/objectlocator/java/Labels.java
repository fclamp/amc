import java.util.HashMap;


public class Labels
{
	private static Labels ref;
	private HashMap theLabels = null;

	/**
	 * Use getInstance method 
	 *
	 */
	private Labels()
	{
		super();
		theLabels = new HashMap();
	}
	
	/**
	 * Add a label to the HashMap 
	 * The key should consist of the module name and fieldname 
	 * 
	 * @param s
	 */
	public synchronized void setValue(String module, String fieldName, String label) 
	{
		theLabels.put(module + fieldName, label);
	}
	
	/**
	 * This method is used to get a label value
	 * The key consists of the module name and fieldname
	 * 
	 * @param module
	 * @param fieldName
	 * @return
	 */
	public String getValue(String module, String fieldName) 
	{
		String val = (String) theLabels.get(module + fieldName);
		
		if(val == null || val.equals(""))
		{
			return "LABEL NOT SET!";
		}
		else
			return val;
	}

	/**
	 * Get the one and only instance to be used 
	 * 
	 * @return
	 */
	public static synchronized Labels getInstance()
	{
		if (ref == null)
			ref = new Labels();

		return ref;
	}

	/**
	 * Cant be clones because its a singleton object
	 */
	public Object clone()
	throws CloneNotSupportedException
	{
		throw new CloneNotSupportedException(); 
	}
}
