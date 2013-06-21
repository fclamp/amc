/*
 * Field.java
 *
 * Created on 27 September 2005, 11:51
 */

/**
 * 
 * @author martin
 */
public class Field
{
	private String value = "";

	private String fieldName = "";

	private String label = "";

	// default constructor
	public Field(String val, String n, String l)
	{
		this.value = val;
		this.fieldName = n;
		this.label = l;
	}

	public String getValue()
	{
		return this.value;
	}

	public String getFieldName()
	{
		return this.fieldName;
	}

	public String getLabel()
	{
		return this.label;
	}

	// return string representation of the field for debugging use
	public String toString()
	{
		return "Field Value: " + value + "\nField Name: " + fieldName
				+ "\nField Label: " + label;
	}

}
