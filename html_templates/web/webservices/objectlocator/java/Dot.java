/*
 * Dot
 *
 * Created on 27 September 2005, 11:51
 */

import java.util.ArrayList;
import java.util.Iterator;

/**
 * 
 * @author martin
 */
public class Dot
{
	private Result catResult = null;

	private Result locationResult = null;

	private boolean selected = false;

	public Dot(Result cat, Result loc)
	{
		this.catResult = cat;
		this.locationResult = loc;
	}

	// checks if locations are the same
	public boolean compareLocations(Dot d)
	{
		double[] thesePoints = this.getCoordinates();
		double[] otherPoints = d.getCoordinates();

		for (int i = 0; i < thesePoints.length; i++)
		{
			if (thesePoints[i] != otherPoints[i])
				return false;
		}

		return true;
	}

	// returns the irn of the catalogue result
	public String getCatalogueIrn()
	{
		Iterator iter = catResult.getFields().iterator();
		Field f = null;
		String fieldName = "";
		String fieldValue = "";

		while (iter.hasNext())
		{
			f = (Field) iter.next();
			fieldName = f.getFieldName();
			fieldValue = f.getValue();

			if (fieldName.equals(Config.mainTableKey))
				return fieldValue;
		}

		return "";
	}

	// get the location irn of the dot
	public String getLocationIrn()
	{
		Iterator iter = catResult.getFields().iterator();
		Field f = null;
		String fieldName = "";
		String fieldValue = "";

		while (iter.hasNext())
		{
			f = (Field) iter.next();
			fieldName = f.getFieldName();
			fieldValue = f.getValue();

			if (fieldName.equals(Config.locationField))
				return fieldValue;
		}

		return "";
	}

	// check if the fieldname passed is a wanted field to be printed out
	private boolean checkCatalogueWantedField(String s)
	{
		String[] wantedFields = Config.returnFields.split("\\s*\\,\\s*");
		int length = wantedFields.length;

		for (int i = 0; i < length; i++)
		{
			if (wantedFields[i].equals(s))
				return true;
		}

		return false;
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

	public String getDescription()
	{
		Iterator iter = catResult.getFields().iterator();
		Field f = null;
		String fieldName = "";
		String fieldValue = "";
		String irn = this.getCatalogueIrn();
		StringBuffer print = new StringBuffer(
				"<tr><td>&nbsp;</td></tr><tr class='content'><td class='borders'><b><center>Catalogue Info</center></b></td></tr>");
		String theMediaField = Config.mediaField;
		int indexTo = 0;
		Labels theLabels = Labels.getInstance();

		// array list of media irns
		ArrayList mediaIrns = new ArrayList();

		// convert the media field to a nest item
		if (theMediaField.endsWith("_tab"))
		{
			indexTo = theMediaField.lastIndexOf("_tab");

			if (indexTo != -1)
				theMediaField = theMediaField.substring(0, indexTo);
		}

		while (iter.hasNext())
		{
			f = (Field) iter.next();
			fieldName = f.getFieldName();
			fieldValue = f.getValue();

			// add to media references
			if (fieldName.equals(theMediaField))
				mediaIrns.add(fieldValue);

			// back to start of loop if you dont want the field printed
			if (!checkCatalogueWantedField(fieldName))
				continue;

			print.append("<tr class='contentLight'><td class='borders'>");
			print.append("<b>");
			print.append(theLabels.getValue(Config.mainTable, fieldName));
			print.append(":</b> ");

			// make a link to the web object display page
			if (fieldName.equals(Config.linkField)
					&& (!Config.webPage.equals("")))
			{
				print.append("<a href='");
				print.append(Config.protocol);
				print.append("://");
				print.append(Config.host);
				print.append(Config.webPage + "?irn=" + irn);
				print.append("'>" + fieldValue + "</a>");
			}
			else
				print.append(fieldValue);

			print.append("</td></tr>");
		}

		iter = locationResult.getFields().iterator();
		print
				.append("<tr class='content'><td class='borders'><b><center>Location Info</center></b></td></tr>");

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
			// print.append("<br>");
		}

		// print media info if it has been specified
		if ((Config.searchMedia) && (!irn.equals("")) && (mediaIrns.size() > 0))
		{
			print
					.append("<tr class='content'><td class='borders'><b><center>Media Info</center></b></td></tr>");
			iter = mediaIrns.iterator();

			// print each media item
			while (iter.hasNext())
			{
				String mediaIrn = (String) iter.next();

				print.append("<tr class='contentLight'><td class='borders'>");
				print.append("<center><a href='");
				print.append(Config.protocol);
				print.append("://");
				print.append(Config.host);
				print.append(Config.mediaLink + "?irn=" + mediaIrn
						+ "&reftable=ecatalogue&refirn=" + irn + "'>");
				print.append("<img src='");
				print.append(Config.protocol);
				print.append("://");
				print.append(Config.host);
				print.append(Config.mediaPage + "?irn=" + mediaIrn
						+ "&thumb=yes'>");
				print.append("</a></center>");
				print.append("</td></tr>");
			}
		}

		return print.toString();
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
}
