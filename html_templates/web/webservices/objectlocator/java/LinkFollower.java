/*
 * LinkFollower.java
 *
 * Created on 28 September 2005, 11:28
 */

import java.applet.AppletContext;
import java.net.URL;

import javax.swing.event.HyperlinkEvent;
import javax.swing.event.HyperlinkListener;

/**
 * @author martin
 * 
 */
public class LinkFollower implements HyperlinkListener
{
	private AppletContext context;

	/**
	 * @param c
	 */
	public LinkFollower(AppletContext c)
	{
		context = c;
	}

	public void hyperlinkUpdate(HyperlinkEvent evt)
	{
		if (evt.getEventType() == HyperlinkEvent.EventType.ACTIVATED)
		{
			// user clicked a link, load it and show it
			URL url = null;

			try
			{
				url = evt.getURL();
				context.showDocument(url, "_ke");
			}
			catch (Exception e)
			{
				String s = evt.getURL().toString();
				System.out.println("Exception: " + e + " " + s);
			}
		}
	}
}
