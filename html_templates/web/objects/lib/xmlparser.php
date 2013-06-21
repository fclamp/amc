<?php
// Copyright (c) 1998-2012 KE Software Pty Ltd
class Item {}

class xmlParser
{
	// Public Vars
	var $handler;
	var $errorHandler;
	var $declarationHandler;
	var $lexicalHandler;

	// Private Const
	var $XMLDECL	= "<\\?xml";
	var $VERSION	= "(['\"])([-a-zA-Z0-9_.:]+)\\1";
	var $ENCODING	= "(['\"])([a-zA-Z][-a-zA-Z0-9._]*)\\1";
	var $YESNO	= "(['\"])(yes|no)\\1";
	var $SYSTEM1	= "\"([^\"]*)\"";
	var $SYSTEM2	= "'([^']*)'";
	var $PUBLIC1	= "\"([-\\n\\r a-zA-Z0-9'()+,.\\/:=?;*#@\$_%]*)\"";
	var $PUBLIC2	= "'([-\\n\\r a-zA-Z0-9()+,.\\/:=?;*#@\$_%]*)'";
	var $COMMENT	= "<!--";
	var $PROCINST	= "<\\?";
	var $DOCTYPE	= "<!DOCTYPE";
	var $NAME	= "([a-zA-Z_:][-a-zA-Z0-9._:]*)";
	var $ELEMENT	= "<!ELEMENT";
	var $ATTLIST	= "<!ATTLIST";
	var $ATTTYPE	= "(CDATA|ID|IDREF|IDREFS|ENTITY|ENTITIES|NMTOKEN|NMTOKENS)\\b";
	var $TAGSTART	= "<([a-zA-Z_:][-a-zA-Z0-9._:]*)";
	var $TAGEND	= "<\\/([a-zA-Z_:][-a-zA-Z0-9._:]*)";
	var $HTTP_HEADER= "HTTP\\/.*OK";

	function parseFile ($filename)
	{
		$this->fd = fopen($filename, 'r');
		$this->parse();
	}

	function parseFD ($fd)
	{
		$this->fd = $fd;
		$this->parse();
	}

	function parse ($data='')
	{
		if($data != '')
			$this->data = $data;
		
		$this->line = 0;
		$this->full = '';
		$this->next = '';

		// Strip HTTP Header if exists
		if($this->match($this->HTTP_HEADER))
		{
			while(!preg_match('/^\\r?\\n$/', $this->full))
			{
				$this->getnext();
			}
			$this->getnext();
		}

		if ($this->match($this->XMLDECL))
		{
			$this->xml();
		}

		$this->misc();

		if ($this->match($this->DOCTYPE))
		{
			$this->dtd();
		}

		$this->misc();

		if (! $this->match($this->TAGSTART))
		{
			$this->syntax("prolog or element expected");
		}

		$this->doc($this->_1);
	}

	function xml()
	{
		$xml = new Item;
		if(! $this->space("version"))
		{
			$this->syntax("'version' expected");
		}
		if(! $this->space("="))
		{
			$this->syntax("= expected after 'version'");
		}
		if (! $this->space($this->VERSION))
		{
			$this->syntax("quoted version number expected");
		}
		$xml->version= $this->_2;

		if ($this->space("encoding"))
		{
			if (! $this->space("="))
			{
				$this->syntax("= expected after 'encoding'");
			}
			if (! $this->space($this->ENCODING))
			{
				$this->syntax("quoted encoding name expected");
			}
			$xml->encoding = $this->_2;
		}

		if ($this->space("standalone"))
		{
			if (! $this->space("="))
			{
				$this->syntax("= expected after 'standalone'");
			}
			if (! $this->space($this->YESNO))
			{
				$this->syntax("quoted 'yes' or 'no' expected");
			}
			$xml->standalone = $this->_2;
		}

		if (! $this->space("\?>"))
		{
			$this->syntax("?> expected");
		}

		if (isset($this->declarationHandler) && is_object($this->declarationHandler))
		{
			$this->declarationHandler->endXML($xml->version, $xml->encoding, $xml->standalone);
		}
	}

	function dtd ()
	{
		//TODO
		return;
	}

	function doc ($name)
	{
		 $this->nest = 0;
		 $this->doc = $this->element($name);
	}

	function misc ()
	{
		$list = array();

		for (;;)
		{
			$this->space("");

			$node = new Item;
			if ($this->match($this->COMMENT))
			{
				$node->type = "comment";
				$node->text = $this->comment();
			}
			elseif ($this->match($this->PROCINST))
			{
				if (! $this->match($this->NAME))
				{
					$this->syntax("processing name expected");
				}
				$node->type = "procinst";
				$node->name = $this->_1;
				$node->text = $this->procinst($node->name);
			}
			else
			{
				break;
			}
			array_push($list, $node);
		}
		return($list); 
	}


	function element ($name)
	{
		$attr = '';
		$data = '';

		$item = new Item;
		$item->name = $name;
		$item->attr = array();

		for (;;)
		{
			if ($this->space(">"))
			{
				$item->type = "start";
				break;
			}
			if ($this->space("\\/>"))
			{
				$item->type = "empty";
				break;
			}
			if (! $this->space($this->NAME))
			{
				$this->syntax(">, /> or attribute name expected");
			}

			/* Attribute */
			$attr = $this->_1;
			if (! $this->space("="))
			{
				$this->syntax("= expected after attribute name");
			}
			if (! $this->space("\""))
			{
				$this->syntax("attribute value must start with \"");
			}
			$data = '';
			while (! $this->match("([^\"]*)\""))
			{
				$data .= $this->next;
				$this->getnext();
			}
			$data = $this->_1;

			$item->attr["$attr"] = $data;
		}

		if (isset($this->handler) && is_object($this->handler))
		{
			$this->handler->startElement($item->name, $item->attr);
		}

		if ($item->type == "start")
		{
			$name = $this->content();
			if ($name != $item->name)
			{
				$this->syntax("end tag does not match start tag");
			}
			if (! $this->space(">"))
			{
				$this->syntax("> expected");
			}
		}
		else if ($item->type == "empty")
		{
			if (isset($this->handler) && is_object($this->handler))
			{
				$this->handler->cData("");
			}
		}

		if (isset($this->handler) && is_object($this->handler))
		{
			$this->handler->endElement($item->name);
		}
	}

	function content ()
	{
		for (;;)
		{
			if ($this->match($this->TAGEND))
			{
				$etag = $this->_1;
				break;
			}
			if ($this->match($this->TAGSTART))
			{
				$this->element($this->_1);
			}
			elseif ($this->match($this->COMMENT))
			{
				$this->comment();
			}
			else
			{
				$this->chardata();
			}
		}
		return $etag;
	}

	function chardata ()
	{
		$data = "";
		while (! $this->match("([^<]*)(?=<)"))
		{
			$data .= $this->next;
			$this->getnext();
		}
		$data .= $this->_1;

		$data = preg_replace('/&amp;/', '&', $data);
		$data = preg_replace('/&lt;/', '<', $data);
		$data = preg_replace('/&gt;/', '>', $data);
		$data = preg_replace('/&apos;/', "'", $data);
		$data = preg_replace('/&quot;/', '"', $data);

		if (isset($this->handler) && is_object($this->handler))
		{
			$this->handler->cData($data);
		}
	}

	function comment ()
	{
		$text = '';
		while (! $this->match("(.*?)-->"))
		{
			$text .= $this->next;
			$this->getnext();
		}
		$text .= $this->_1;

		if (isset($this->lexicalHandler) && is_object($this->lexicalHandler))
		{
			$this->lexicalHandler->endComment($text);
		}
	}

	function procinst ($name)
	{
		$text = '';
		while (! $this->match("([^?])\\?>"))
		{
			$text .= $this->next;
			$this->getnext();
		}
		$text .= $this->_1;

		return $text;
	}

	function match ($patt)
	{
		if ($this->next == "")
		{
			$this->getnext();
		}

		$patt = "/^$patt/";
		$hit = preg_match($patt, $this->next, $matches);

		// Ugly but it makes the code using it clearer
		$this->_1 = $matches[1];
		$this->_2 = $matches[2];
		$this->_3 = $matches[3];
		$this->_4 = $matches[4];
		$this->_5 = $matches[5];
		$this->_6 = $matches[6];
		$this->_7 = $matches[7];
		$this->_8 = $matches[8];
		$this->_9 = $matches[9];

		$this->next = preg_replace($patt, '', $this->next);

		return $hit;
	}

	function space ($patt)
	{
		while (preg_match('/^\\s*$/', $this->next) == 1)
		{
			$this->getnext();
		}
		$this->next = preg_replace("/^\\s*/", '', $this->next);
		return($patt != '' ? $this->match($patt) : 1);
	}

	function getnext ()
	{
		if (isset($this->data))
		{
			preg_match('/^([^\\r\\n]*\\r?\\n)/', $this->data, $matches);
			$full = $matches[1];
			$this->data = preg_replace('/^[^\\r\\n]*\\r?\\n/', '', $this->data);
			$this->full = $full;
			$this->next = $full;
		}
		elseif(isset($this->fd))
		{
			$buffer = '';
			while (strpos($buffer, "\n") === FALSE)
			{
				$buffer .= fgets($this->fd, 4096);
				if (feof($this->fd))
				{
					break;
				}
			}
			if ($buffer == '')
			{
				$this->error("unexpected end-of-file");
			}
			$this->full = $buffer;
			$this->next = $buffer;
		}
		$this->line++;
	}

	function syntax ($mesg)
	{
		$offs = strlen($this->full) - strlen($this->next);
		$line = substr($this->full, 0, $offs);
		$line = preg_replace('/[^	]/', ' ', $line);

		$x = $this->line;
		$text = "<br />\n<pre>XML syntax error at line $x:<br />\n";
		$this->full = preg_replace('/</', '&lt;', $this->full);
		$this->full = preg_replace('/>/', '&gt;', $this->full);
		$text .= $this->full;
		$text .= "$line^<br />\n";
		$text .= $mesg;
		$text .= "</pre>";
		$this->error($text);
	}

	function error ($mesg)
	{
		if (isset($this->errorHandler) && is_object($this->errorHandler))
		{
			$this->errorHandler->parseError($mesg);
		}
		else
		{
			die("$mesg\n");
		}
	}
} //end xmlParser Class

?>
