/*
 * Location 
 *
 * Created on 16 November 2005, 11:51
 */

import java.util.Iterator;

/**
 * 
 * @author martin
 */
public class Location
{
	private Result locationResult = null;

	private boolean selected = false;

	public Location(Result loc)
	{
		this.locationResult = loc;
	}

	// check if the dot is selected
	public boolean isSelected()
	{
		return this.selected;
	}

	// set the selected flag
	public void setSelected(boolean b)
	{
		this.selected = b;
	}

	// get the location irn of the dot
	public String getLocationIrn()
	{
		Iterator iter = locationResult.getFields().iterator();
		Field f = null;
		String fieldName = "";
		String fieldValue = "";

		while (iter.hasNext())
		{
			f = (Field) iter.next();
			fieldName = f.getFieldName();
			fieldValue = f.getValue();

			if (fieldName.equals(Config.locationTableKey))
				return fieldValue;
		}

		return "";
	}

	// checks if locations are the same
	public boolean compareLocations(Location l)
	{
		double[] thesePoints = this.getCoordinates();
		double[] otherPoints = l.getCoordinates();

		for (int i = 0; i < thesePoints.length; i++)
		{
			if (thesePoints[i] != otherPoints[i])
				return false;
		}

		return true;
	}

	// get a description of the location
	public String getLocationDescription()
	{
		Iterator iter = locationResult.getFields().iterator();
		Field f = null;
		String fieldName = "";
		String fieldValue = "";
		StringBuffer print = new StringBuffer(
				"<tr><td>&nbsp;</td></tr><tr class='content'><td class='borders'><b><center>Location Info</center></b></td></tr>");
		Labels theLabels = Labels.getInstance();

		while (iter.hasNext())
		{
			f = (Field) iter.next();
			fieldName = f.getFieldName();
			fieldValue = f.getValue();

			if (!checkLocationWantedField(fieldName))
				continue;

			print.append("<tr class='contentLight'><td class='borders'>");
			print.append("<b>");
			print.append(theLabels.getValue(Config.locationTable, fieldName));
			print.append(":</b> ");
			print.append(fieldValue);
			print.append("</td></tr>");
		}

		return print.toString();
	}

	// this is used to print the combo box data
	public String toString()
	{
		Iterator iter = locationResult.getFields().iterator();
		Field f = null;
		String fieldName = "";
		String fieldValue = "";

		while (iter.hasNext())
		{
			f = (Field) iter.next();
			fieldName = f.getFieldName();
			fieldValue = f.getValue();

			if (fieldName.equals(Config.locationComboField))
				return fieldValue;
		}

		return "ERROR: no combo field";
	}
	
	/**
	 * Debugging use
	 * 
	 * @return
	 */
	public String debugLocation()
	{
		int size = locationResult.getNumberOfFields();
		Field f = null;
		String name = "";
		String value = "";
		StringBuffer buff = new StringBuffer();

		buff.append("Location IRN: ");
		buff.append(this.getLocationIrn());
		buff.append(" ");
		
		for (int i = 0; i < size; i++)
		{
			try
			{
				f = this.locationResult.getField(i);
				name = f.getFieldName();
				value = f.getValue();

				if (name.equals(Config.locationX)) 
				{
					buff.append("X: ");
					buff.append(value);
					buff.append(" ");
				}
				else if (name.equals(Config.locationY))
				{
					buff.append("Y: ");
					buff.append(value);
					buff.append(" ");
				}
				else if (name.equals(Config.locationZ))
				{
					buff.append("Z: ");
					buff.append(value);
					buff.append(" ");
				}
			}
			catch (IndexOutOfBoundsException e)
			{
				System.out.println("Index Out of Bounds Exception: " + e);
			}
			catch (NumberFormatException e)
			{
				System.out
						.println("The Dot Coordinates are incorrect! This is because the location coordinates have not been set: "
								+ e);
			}
		}

		return buff.toString();
	}

	// get x, y and z coordinates in double format
	public double[] getCoordinates()
	{
		int size = locationResult.getNumberOfFields();
		double[] points = { 0.0, 0.0, 0.0 };
		Field f = null;
		String name = "";
		String value = "";

		for (int i = 0; i < size; i++)
		{
			try
			{
				f = this.locationResult.getField(i);
				name = f.getFieldName();
				value = f.getValue();

				if (name.equals(Config.locationX))
					points[0] = Double.valueOf(value).doubleValue();
				else if (name.equals(Config.locationY))
					points[1] = Double.valueOf(value).doubleValue();
				else if (name.equals(Config.locationZ))
					points[2] = Double.valueOf(value).doubleValue();
			}
			catch (IndexOutOfBoundsException e)
			{
				System.out.println("Index Out of Bounds Exception: " + e);
			}
			catch (NumberFormatException e)
			{
				System.out
						.println("The Dot Coordinates are incorrect! This is because the location coordinates have not been set: "
								+ e);
			}
		}

		return points;
	}

	// check if the fieldname passed is a wanted field to be printed out
	private boolean checkLocationWantedField(String s)
	{
		String[] wantedFields = Config.locationReturnFields
				.split("\\s*\\,\\s*");
		int length = wantedFields.length;

		for (int i = 0; i < length; i++)
		{
			if (wantedFields[i].equals(s))
				return true;
		}

		return false;
	}

}
