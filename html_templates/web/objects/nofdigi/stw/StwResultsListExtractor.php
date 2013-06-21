<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*
*  Alex Fell - A Stw specific ResultsListExtractor
*/
if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once($WEB_ROOT . '/objects/common/ResultsListExtractor.php');

class
StwResultsListExtractor extends ResultsListExtractor
{

        var $BookDisplayPage = "";
        var $BookTitleField = "";
        var $BookPageField = "";

        function
        ExtractFields($fields)
        {
                $this->Fields = $fields;
                if (!empty($this->BookTitleField) || !empty($this->BookPageField))
                {
                        array_push($this->Fields, $this->BookTitleField);
                        array_push($this->Fields, $this->BookPageField);
                        array_unique($this->Fields);
                }
                $this->doQuery();
        }

        function
        PrintLinkedField($field, $num, $additionalURLParms="")
        {
                if ($this->IsBook($num))
                        $link = $this->BookPageLink($num);
                else
                        $link = $this->DisplayPageLink($num);

                if ($additionalURLParms != "")
                {
                        $link .= "&amp;" . $additionalURLParms;
                }
                print "<a href=\"$link\">";
                print $this->records[$num]->{"$field"};
                print "</a>";
        }

        function
        PrintLinkedThumbnail($num, $width=60, $height=60, $keepaspectratio=0, $additionalURLParms="")
        {
                if ($this->IsBook($num))
                        $link = $this->BookPageLink($num);
                else
                        $link = $this->DisplayPageLink($num);

                if ($additionalURLParms != "")
                {
                        $link .= "&amp;" . $additionalURLParms;
                }
                $this->PrintThumbnail($num, $width, $height, $keepaspectratio, $link);
        }

        function
        BookPageLink($num)
        {
                $link = $this->BookDisplayPage;

                $link .= '?irn=' . $this->records[$num]->irn_1;
                if ($this->QueryPage != "")
                {
                        $link .= "&amp;QueryPage=";
                        $link .= urlencode($this->QueryPage);
                }
                return $link;
        }

        function
        IsBook($num)
        {
                $bookfield = $this->BookTitleField;
                $bookpages = $this->BookPageField;
                if (empty($bookfield) || empty($bookpages) || empty($this->BookDisplayPage))
                {
                        return 0;
                }
                $book = $this->records[$num]->{"$bookfield"};
                $pages = $this->records[$num]->{"$bookpages"};
                if (empty($book) || empty($pages) || $pages == "1")
                {
                        return 0;
                }
                return 1;
        }
}
?>
