/*
 * Result (a array list of Field objects)
 *
 * Created on 27 September 2005, 11:51
 */

import java.util.ArrayList;

/**
 * 
 * @author martin
 */
public class Result
{
	private ArrayList fields = null;

	public Result()
	{
		fields = new ArrayList();
	}

	public void addField(Field f)
	{
		fields.add(f);
	}

	public Result(ArrayList f)
	{
		this.fields = f;
	}

	public ArrayList getFields()
	{
		return this.fields;
	}

	public int getNumberOfFields()
	{
		return this.fields.size();
	}

	// get field by index
	public Field getField(int i) throws IndexOutOfBoundsException
	{
		try
		{
			return (Field) fields.get(i);
		}
		catch (IndexOutOfBoundsException e)
		{
			System.out.println("Index Out of Bounds: " + e);
			throw new IndexOutOfBoundsException();
		}

	}

}
