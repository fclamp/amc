<?php
/*
** Copyright (c) 1998-2012 KE Software Pty Ltd
*/
require_once(dirname(realpath(__FILE__)) . "/query.php");
require_once(dirname(realpath(__FILE__)) . "/serverconnection.php");

$media = new Media;
$media->Show();

class
Media
{	
	public function
	__construct()
	{
		$this->QueryResult = NULL;

		global $EMU_GLOBALS;
		
		if (isset($_REQUEST['irn']) && is_numeric($_REQUEST['irn']))
			$this->IRN = $_REQUEST['irn'];
		else
			$this->IRN = 0;

		if (isset($_REQUEST['width']) && is_numeric($_REQUEST['width']))
		{
			$this->Width = $_REQUEST['width'];
		}

		if (isset($_REQUEST['height']) && is_numeric($_REQUEST['height']))
		{
			$this->Height = $_REQUEST['height'];
		}

		if (isset($_REQUEST['thumb']) && $_REQUEST['thumb'] == "yes")
		{
			$this->Width = "thumb";
			$this->ForceImage = 1;
		}

		if (isset($_REQUEST['image']) && $_REQUEST['image'] == "yes")
			$this->ForceImage = 1;

		if (isset($_REQUEST['force']) && $_REQUEST['force'] == "yes")
		{
			$this->ForceImage = 1;
			$this->ForceDimension = 1;
		}

		if (isset($_REQUEST['crop']) && $_REQUEST['crop'] == "yes")
		{
			$this->ForceImage = 1;
			$this->Crop = 1;
		}

		if (isset($EMU_GLOBALS['MAX_IMAGE_WIDTH']) && is_numeric($EMU_GLOBALS['MAX_IMAGE_WIDTH']))
			$this->MaxWidth = $EMU_GLOBALS['MAX_IMAGE_WIDTH'];

		if (isset($EMU_GLOBALS['MAX_IMAGE_HEIGHT']) && is_numeric($EMU_GLOBALS['MAX_IMAGE_HEIGHT']))
			$this->MaxHeight = $EMU_GLOBALS['MAX_IMAGE_HEIGHT'];
	}

	public function
	Show()
	{
		if ($this->QueryDone == 0)
			$this->DoQuery();

		$ReturnLarger = 0;
		if ($this->Crop == 1 || $this->ForceDimension == 1)
		{
			$ReturnLarger = 1;
		}

		list($filename, $mimetype, $mimeformat) = $this->FindBestFile($ReturnLarger);

		/*
		** If we have a filename now then we can display something, otherwise
		** we have to display a placeholder image because either there is no multimedia,
		** or because an image has been requested and there is no appropriate resolution
		*/
		if (isset($filename))
		{
			/*
			**  File is on the server
			*/
			$serverpath = urlencode($this->ConstructServerPath($filename));
			$connection = new ServerConnection;
			$fd = $connection->Open();
			fputs($fd, "GET file=$serverpath HTTP/1.0\r\n\r\n");
			$buff = fread($fd, 1024);
			if (strpos($buff, "Not Found"))
			{
				global $EMU_GLOBALS;
				if ($EMU_GLOBALS['DEBUG'] == 1)
					throw new Exception("Multimedia '$serverpath' not found on server");
				else
					$this->ShowLocalImage();
				return;
			}

			$printed = 0;

			if ($this->Crop == 1)
			{
				/*
				** We need to crop the image
				*/
				$printed = $this->PrintCroppedImage($buff, $fd);
			}
			else if ($this->ForceDimension == 1)
			{
				/*
				** We need to resample the image
				*/
				$printed = $this->PrintResizedImage($buff, $fd);
			}

			if ($printed == 0)
			{
				/*
				** We need to spit the raw file out
				*/
				header("Content-type: $mimetype/$mimeformat");
				if (strpos($this->WebFormats, strtolower($mimeformat)) === FALSE)
					header('Content-Disposition: attachment; filename="' . $filename . '"');
				print $buff;
				while (!feof($fd))
					print fread($fd, 4096);
			}

			fclose($fd);
		}
		else
		{
			/*
			** File is local to PHP pages
			*/
			$this->ShowLocalImage();	
		}
	}

	private $IRN;
	private $Width;
	private $Height;
	private $ForceImage = 0;

	private $ForceDimension = 0;
	private $Crop = 0;
	
	private $QueryResult;
	private $WebFormats = "jpeg gif png";

	private $MaxWidth = 0;
	private $MaxHeight = 0;

	private $QueryDone = 0;

	private function
	DoQuery()
	{
		if (!empty($this->IRN))
		{
			$qry = new Query;
			$qry->Table = "emultimedia";
			$qry->Term("irn", $this->IRN);
			$qry->Select("MulIdentifier");
			$qry->Select("MulMimeType");
			$qry->Select("MulMimeFormat");
			$qry->Select("DocWidth_tab");
			$qry->Select("DocHeight_tab");
			$qry->Select("DocMimeType_tab");
			$qry->Select("DocMimeFormat_tab");
                        $qry->Select("DocIdentifier_tab");
                        $qry->Select("ChaRepository_tab");

			$results = $qry->Fetch();
			if (isset($results[0]->MulIdentifier))
				$this->QueryResult = $results[0];
		}

		$this->QueryDone = 1;
	}


	private
	function
	PrintCroppedImage($buffer, $fd)
	{
		/*
		** Create an image from the buffer and fd
		*/
		while (!feof($fd))
			$buffer .= fread($fd, 8192);
		
		$srcImage = imagecreatefromstring($buffer);
		
		if ($srcImage === FALSE)
			return 0;

		/*
		** Get the sizes we want to crop to
		*/
		$destWidth = $destHeight = 0;
		if (isset($this->Width))
			$destWidth = $this->Width;
		else
			$destWidth = imagesx($srcImage);
		
		if (isset($this->Height))
			$destHeight = $this->Height;
		else
			$destHeight = imagesy($srcImage);
		
		/*
		** Create the destination image
		*/
		$destImage = imagecreatetruecolor($destWidth, $destHeight);

		/*
		** Set the background white if the destination is larger
		** than the source
		*/
		if ($destWidth > imagesx($srcImage) || $destHeight > imagesy($srcImage))
		{
			imagecolortransparent($destImage, imagecolorallocate($destImage,0,0,0));
		}

		/*
		** Work out top left coord of source rectangle.
		*/
		$sAx = intval( (imagesx($srcImage) - $destWidth)  / 2 );
		$sAy = intval( (imagesy($srcImage) - $destHeight) / 2 );

		/*
		** Copy to destination
		*/
		if (imagecopy($destImage, $srcImage, 0, 0,
			$sAx, $sAy, $destWidth, $destHeight) === FALSE)
		{
			imagedestroy($destImage);
			imagedestroy($srcImage);
			return 0;
		}

		header('Content-type: image/png');
		imagepng($destImage);

		imagedestroy($destImage);
		imagedestroy($srcImage);

		return 1;
	}
	
	private
	function
	PrintResizedImage($buffer, $fd)
	{
		if (!is_numeric($this->Width) && !is_numeric($this->Height))
			return 0;

		/*
		** Fill buffer with contents of remote file
		*/
		while (!feof($fd))
			$buffer .= fread($fd, 8196);
		
		$srcImage = imagecreatefromstring($buffer);

		if ($srcImage === FALSE)
			return 0;

		/*
		** Work out dimensions of destination image
		*/
		$destWidth = $destHeight = 0;
		if (is_numeric($this->Width))
			$destWidth = $this->Width;
		else if (is_numeric($this->Height))
			$destHeight = $this->Height;
		
		$srcAspect = imagesx($srcImage) / imagesy($srcImage);

		if ($destWidth > 0)
			$destHeight = $destWidth / $srcAspect;
		else if ($destHeight > 0)
			$destWidth = $destHeight * $srcAspect;
		
		/*
		** Create destination image and copy source to it
		*/
		$destImage = imagecreatetruecolor($destWidth, $destHeight);

		if (imagecopyresampled($destImage, $srcImage, 
			0,0,0,0,
			$destWidth, $destHeight,
			imagesx($srcImage), imagesy($srcImage)) === FALSE)
		{
			imagedestroy($destImage);
			imagedestroy($srcImage);
			return 0;
		}

		header('Content-type: image/png');
		imagepng($destImage);

		imagedestroy($destImage);
		imagedestroy($srcImage);

		return 1;
	}

	private function
	PathToPlaceholder()
	{
		if ($this->QueryDone == 0)
			$this->DoQuery();

		$mimetype = "";
		$mimeformat = "";
		if (isset($this->QueryResult))
		{
			$mimetype = $this->QueryResult->MulMimeType;
			$mimeformat = $this->QueryResult->MulMimeFormat;
		}
		
		$placeholder_path = dirname(realpath(__FILE__)) . "/images/";

		$placeholder_image = "";
		switch (strtolower($mimetype))
		{
			case "":
				$placeholder_image = "noimage";
				break;
			case "application" :
				switch (strtolower($mimeformat))
				{
					case "ppt":
						$placeholder_image = "ppt";
						break;
					case "msword":
					case "pdf":
						$placeholder_image = "doc";
						break;
					default:
						$placeholder_image = "app";
						break;
				}
				break;
			case "image":
				$placeholder_image = "image";
				break;
			case "audio":
				$placeholder_image = "audio";
				break;
			case "video":
				$placeholder_image = "video";
				break;
			case "text":
				switch (strtolower($mimeformat))
				{
					case "html":
						$placeholder_image = "html";
						break;
					default:
						$placeholder_image = "text";
						break;
				}
				break;
			default:
				$placeholder_image = "default";
				break;
		}

		/*
		** If a thumbnail's not been requested return the larger sized image
		*/
		if ((string) $this->Width != "thumb")
			$placeholder_image .= "_lg";

		$placeholder_image .= ".png";

		return $placeholder_path . $placeholder_image;
	}

	private function
	ShowLocalImage()
	{
		$imagepath = $this->PathToPlaceholder();
		if (is_readable($imagepath))
		{
			header("Content-type: image/png");
			$fd = fopen($imagepath, 'r');
			do
		{
			print fread($fd, 4096);
		}
			while (!feof($fd));
			fclose($fd);
		}
		else
		{
			throw new Exception("Cannot read file $imagepath");
		}
	}

	private function
	FindBestFile($LargerThanRequested = 0)
	{
		/*
		** This function looks at the url parameters that have been set and returns the
		** identifier of the best available resolution
		*/
		if ($this->QueryDone == 0)
			$this->DoQuery();

		if (empty($this->QueryResult))
			return array(NULL,NULL,NULL);

		$BestFile;
		$BestMimeFormat;
		$BestMimeType;
		$BestWidth = 0;
		$BestHeight = 0;
		$LargestFile;
		$LargestMimeFormat;
		$LargestMimeType;
		$LargestWidth;
		$LargestHeight;
		$SmallestFile;
		$SmallestMimeFormat;
		$SmallestMimeType;
		$SmallestWidth;
		$SmallestHeight;

		/*
		** If they just want a thumbnail, find the right file and return
		** it here.
		*/
		if ((string) $this->Width == "thumb")
		{
			for ($i = 0; $i < count($this->QueryResult->DocIdentifier_tab); $i++)
			{
				$fname = $this->QueryResult->DocIdentifier_tab[$i];
				if (preg_match("/\.thumb\.(jpg|gif|png)$/", $fname))
				{
					$BestFile = $fname;
					$BestMimeFormat = $this->QueryResult->DocMimeFormat_tab[$i];
					$BestMimeType = $this->QueryResult->DocMimeType_tab[$i];
				}
			}

			/*
			** If BestFile is not set, we have been asked for a thumbnail but none
			** exists, so return NULL
			*/
			if (isset($BestFile))
				return array(
					$BestFile,
					$BestMimeType,
					$BestMimeFormat);
			else
				return array(NULL, NULL, NULL);
		}

		for ($i = 0; $i < count($this->QueryResult->DocIdentifier_tab); $i++)
                {
                        /*
                        ** If the image is in the dams assume we don't have access to the master and move on. 
                        **
                        */
                        if (preg_match("/dam/",strtolower($this->QueryResult->ChaRepository_tab[$i])) && ($this->QueryResult->DocIdentifier_tab[$i] == $this->QueryResult->MulIdentifier))
                        {
                                continue;
                        }

			if ($this->ForceImage == 1)
			{
				/*
				**  Ignore this one if it's not in the list of $this->WebFormats
				*/
				if (strpos($this->WebFormats, strtolower($this->QueryResult->DocMimeFormat_tab[$i])) === FALSE)
					continue;
			}

			/*
			** Find the largest available size
			*/
			$newwidth = $this->QueryResult->DocWidth_tab[$i];
			$newheight = $this->QueryResult->DocHeight_tab[$i];

			/*
			 * Skip this one if the dimensions are larger than MAX_IMAGE_HEIGHT
			 * or MAX_IMAGE_WIDTH from config.php
			 */
			if ($this->MaxWidth > 0 && $newwidth > $this->MaxWidth)
				continue;
			if ($this->MaxHeight > 0 && $newheight > $this->MaxHeight)
				continue;

			if (!isset($LargestWidth) || $newwidth > $LargestWidth)
			{
				$LargestWidth = $newwidth;
				$LargestHeight = $newheight;
				$LargestFile = $this->QueryResult->DocIdentifier_tab[$i];
				$LargestMimeType = $this->QueryResult->DocMimeType_tab[$i];
				$LargestMimeFormat = $this->QueryResult->DocMimeFormat_tab[$i];
			}

			if (!isset($SmallestWidth) || $newwidth < $SmallestWidth)
			{
				$SmallestWidth = $newwidth;
				$SmallestHeight = $newheight;
				$SmallestFile = $this->QueryResult->DocIdentifier_tab[$i];
				$SmallestMimeType = $this->QueryResult->DocMimeType_tab[$i];
				$SmallestMimeFormat = $this->QueryResult->DocMimeFormat_tab[$i];
			}

			if( (is_numeric($this->Width) && $this->Width != 0)
				|| (is_numeric($this->Height) && $this->Height != 0) )
			{
				/*
				** We've been asked for a specific size, so find out if the current size is
				**	better than those previous 
				*/

				$IsBetter = 0;

				if (!isset($this->Height))
				{
					/*
					 * i.e. No specific height asked for
					 */
					if ($LargerThanRequested == 1)
					{
						if ( ($newwidth >= $this->Width) &&
							($newwidth < $BestWidth || $BestWidth == 0) )
						{
							$IsBetter = 1;
						}
					}
					else
					{
						if ( ($newwidth <= $this->Width) && ($newwidth > $BestWidth) )
						{
							$IsBetter = 1;
						}
					}
				}
				elseif (!isset($this->Width))
				{
					/*
					 * i.e. No specific Width asked for
					 */
					if ($LargerThanRequested == 1)
					{
						if ( ($newheight >= $this->Height) &&
							($newheight < $BestHeight || $BestHeight == 0) )
						{
							$IsBetter = 1;
						}
					}
					else
					{
						if ( ($newheight <= $this->Height) && ($newheight > $BestHeight) )
						{
							$IsBetter = 1;
						}
					}
				}
				else
				{
					if ($LargerThanRequested == 1)
					{
						if ( ($newwidth >= $this->Width) && ($newheight >= $this->Height) )
						{
							if ( $BestWidth == 0 ||
								($newwidth < $BestWidth) && ($newheight < $BestHeight) )
							{
								$IsBetter = 1;
							}
						}
					}
					else
					{
						if ( ($newwidth <= $this->Width) && ($newheight <= $this->Height) )
						{
							if ( ($newwidth > $BestWidth) && ($newheight > $BestHeight) )
							{
								$IsBetter = 1;
							}
						}
					}
				}

				if ($IsBetter == 1)
				{
					$BestWidth = $newwidth;
					$BestHeight = $newheight;
					$BestFile = $this->QueryResult->DocIdentifier_tab[$i];
					$BestMimeType = $this->QueryResult->DocMimeType_tab[$i];
					$BestMimeFormat = $this->QueryResult->DocMimeFormat_tab[$i];
				}
			}
		}

		/*
		** If BestFile is not set and the requested width is smaller than the smallest
		** available size, return the smallest available, otherwise return the
		** largest
		*/
		if (!isset($BestFile) && (isset($LargestFile) || isset($SmallestFile)))
		{
			if ( (is_numeric($this->Width) && $this->Width < $SmallestWidth) ||
				(is_numeric($this->Height) && $this->Height < $SmallestHeight) )
			{
				$BestFile = $SmallestFile;
				$BestMimeFormat = $SmallestMimeFormat;
				$BestMimeType = $SmallestMimeType;
			}
			else
			{
				$BestFile = $LargestFile;
				$BestMimeType = $LargestMimeType;
				$BestMimeFormat = $LargestMimeFormat;
			}
		}

		/*
		** If $BestFile still not set, it could be a multimedia record type that does not
		** contain resolutions, e.g. Word Document. In this case, return MulIdentifier and
		** related mime type fields
		*/
		if (!isset($BestFile) && $this->ForceImage != 1)
		{
			$BestFile = $this->QueryResult->MulIdentifier;
			$BestMimeType = $this->QueryResult->MulMimeType;
			$BestMimeFormat = $this->QueryResult->MulMimeFormat;
		}
	
		if (isset($BestFile))
		{
			return array(
				$BestFile,
				$BestMimeType,
				$BestMimeFormat);
		}
		else
			return array(NULL,NULL,NULL);
	}

	private function
	ConstructServerPath($filename)
	{
		$pre = intval($this->IRN / 1000);
		$suf = sprintf('%03d', $this->IRN % 1000);
		$dir = "$pre/$suf";

		$path = "$dir/$filename";	

		return $path;
	}
}
?>
