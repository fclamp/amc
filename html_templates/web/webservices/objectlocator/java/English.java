/*
 * English.java 
 *
 * Created on 27 September 2005, 11:51
 */

/**
 * 
 * @author martin
 */
public class English
{
	// make sure that the keys and labels have the same array length
	private String[] keys = { "irn_1", "SummaryData", "LocCurrentLocationRef",
			"MulMultiMediaRef", "PhyLocationX", "PhyLocationY", "PhyLocationZ",
			"LocLocationName" };

	private String[] labels = { "IRN", "Summary Data", "Current Location IRN",
			"Media Reference", "X", "Y", "Z", "Location Name" };

	public English()
	{

	}

	// get a english label
	// if none exists then return the field name passed
	public String getLabel(String fieldName)
			throws ArrayIndexOutOfBoundsException
	{
		int number = keys.length;

		try
		{
			for (int i = 0; i < number; i++)
			{
				if (keys[i].equals(fieldName))
					return labels[i];
			}
		}
		catch (ArrayIndexOutOfBoundsException e)
		{
			System.out.println("Exception Array out of Bounds: " + e);
			throw new ArrayIndexOutOfBoundsException();
		}

		return fieldName;
	}

	// get a fieldname according to the label passed
	// if none exists then return the label passed
	public String getFieldName(String label)
			throws ArrayIndexOutOfBoundsException
	{
		int number = keys.length;

		try
		{
			for (int i = 0; i < number; i++)
			{
				if (labels[i].equals(label))
					return keys[i];
			}
		}
		catch (ArrayIndexOutOfBoundsException e)
		{
			System.out.println("Exception Array out of Bounds: " + e);
			throw new ArrayIndexOutOfBoundsException();
		}

		return label;
	}
}
