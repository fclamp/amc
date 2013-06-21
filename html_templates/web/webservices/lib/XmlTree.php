<?php

/*
** Copyright (c) 2007 - KE Software Pty Ltd
**
** Class XmlTree
** Class XmlTreeNode
**
** @package EMuWebServices
**
*/


/*
** Class XmlTree
**
** PUBLIC METHODS:
**
** - parseXmlToStruct 
**   ARGS: xml = xml to parse, tags = reference to variable to populate with XML tags,
**         index = reference to variable to populate with XML index, error_mesg = 
**         reference to variable to populate with parse error message (if any).
**   Parses XML to struct. Returns true if successful & false if there is a parse error.
**   Populates arguments with XML tags array, xml index array & error message if the parse
**   fails.
**
** - parseXmlStructToTree
**   ARGS: tags = XML tags array generated by parseXmlToStruct
**   Uses XML tags array (generated from parseXmlToStruct, see above) to generate a tree of
**   the XML - uses XmlTreeNode object (see below) for nodes of the tree.
**
** - breadthFirstTreeTraversal
**
**
**
** - depthFirstTreeTraversal
**
**
**
**
** - getXmlTreeNodeElement
**   ARGS: tree = tree to be searched, name = tag name to retrieve element from, element =
**         element to retrieve.
**   Searches an XML tree (generated from parseXmlStructToTree, see above) by tag name 
**   for any of the XmlTreeNode elements ("name", "attributes", "value" or "children")
**
** PRIVATE METHODS:
**
** - _getTreeElement
**   ARGS: tree_node = tree node currently being examined, name = tree node name to retrieve 
**         element from, function_name = the name of the function call to retrieve the tree
**         node element required
**   Recursive helper function for getXmlTreeNodeElement();
**
*/

class
XmlTree extends BaseWebServiceObject
{
        function
        ParseXmlToStruct($xml, &$tags, &$index, &$error_mesg)
        {
		$parser = xml_parser_create();
                xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
                xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
                if ( ! xml_parse_into_struct($parser, $xml, $tags, $index))
                {
                        $error_string = xml_error_string(xml_get_error_code($parser));
                        $error_line = xml_get_current_line_number($parser);
			$error_mesg = "Invalid xml request: $error_string on line $error_line";

			xml_parser_free($parser);
                        return false;
                }
		xml_parser_free($parser);
		return true;
        }

        function
        ParseXmlStructToTree($tags)
        {
                $element = array();
                $stack = array();

                foreach ($tags as $tag)
                {
                        $index = count($element);
                        if ($tag['type'] == "open" || $tag['type'] == "complete")
                        {
				$tag_name = $tag['tag'];
				$attributes = $tag['attributes'];
				$value = $tag['value'];
                                $element[$index] = new XmlTreeNode($tag_name, $attributes, $value);

                                if ($tag['type'] == "open")
                                {
                                        $stack[count($stack)] = &$element;
                                        $element = &$element[$index]->children;
                                }
                        }
                        else if ($tag['type'] == "close")
                        {
                                $element = &$stack[count($stack) - 1];
                                unset($stack[count($stack) - 1]);
                        }
                }
		return $element[0];
        }

	function 
	GetXmlTreeNodeElement($tree, $name, $element)
	{
		$function_name = 'get' . ucfirst(strtolower($element));
		if (method_exists($tree, $function_name))
			return $this->_GetTreeElement($tree, $name, $function_name);
		return '';
	}

	function
	BreadthFirstTreeTraversal(&$caller, $stack, &$return_object, $function_name)
	{
		if (empty($stack))
			return;

		$tree_node = array_pop($stack);
		$stack = array_merge($stack, array_reverse($tree_node->GetChildren()));

		if (method_exists($caller, $function_name))
		{
			if (! $caller->$function_name($this, $stack, $return_object, $tree_node, $function_name))
				$this->BreadthFirstTreeTraversal($caller, $stack, $return_object, $function_name);
		}
		else
		{
			return;
		}
	}

	function
	DepthFirstTreeTraversal(&$caller, $tree_node, &$return_object, $function_name)
	{
		if (method_exists($caller, $function_name))
		{
			if (! $caller->$function_name($this, $return_object, $tree_node, $function_name))
			{
				foreach ($tree_node->GetChildren() as $child)
					$this->DepthFirstTreeTraversal($caller, $child, $return_object, $function_name);
			}
		}
		else
		{
			return;
		}
	}

	function
	_GetTreeElement($tree_node, $name, $function_name)
	{
		if (preg_match("/^$name$/i", $tree_node->GetName()))
		{
			return $tree_node->$function_name();
		}
		else
		{
			foreach ($tree_node->GetChildren() as $child)
			{
				$element = $this->_getTreeElement($child, $name, $function_name);
				if (isset($element))
					return $element;
			}
		}
	}
}

/*
** Class XmlTreeNode
**
** PUBLIC METHODS:
**
** - XmlTreeNode
**   ARGS: name = tag name of XML element, attributes = XML tag attributes, value =
**         the value between the XML tags
**   Constructor.
**
** - GetName, GetAttributes, GetValue, GetChildren
**   Returns that value of the node
**
*/

class
XmlTreeNode
{
        var $name;
        var $attributes;
        var $value;
        var $children;

	function
	XmlTreeNode($name, $attributes, $value)
	{
		$this->name = $name;
		$this->attributes = $attributes;
		$this->value = $value;
		$this->children = array();
	}

	function
	GetName()
	{
		return $this->name;
	}

	function
	GetAttributes()
	{
		return $this->attributes;
	}

	function
	GetValue()
	{
		return $this->value;
	}
	function
	GetChildren()
	{
		return $this->children;
	}

	function
	GetOnlyChild()
	{
		if ( ! empty( $this->children ) &&
		       count( $this->children ) == 1 )
		{
			return $this->children[0];
		}
		return NULL;
	}

	function
	SetName($name)
	{
		$this->name = $name;
	}

	function
	SetAttributes($attributes)
	{
		$this->attributes = $attributes;
	}

	function
	SetValue($value)
	{
		$this->value = $value;
	}
	function
	SetChildren($children)
	{
		$this->children = $children;
	}
}


?>