<?php

/**
 * Search.
 *
 * This is the model which will perform the searchs against the IMu database.
 *
 * @author BMCD AP  @fc_lamp
 * @version 0.1.1
 */

final class Search
{
	protected $SearchHost = '203.22.224.29';
	protected $SearchPort = 40000;
	
	public $columns = NULL;
	public $narrativeColumns = NULL;
	public $ImageColumns = NULL;
	public $defaultImage =NULL;
	public $showImageUrl = NULL;
	
	public $error = NULL;
	
	private $_collection = array ('natural', 'cultural' );
	
	/**
	 * 
	 * Construct 
	 * @param string $table
	 */
	public function __construct()
	{
		
		$this->defaultImage = './images/100.jpg';
		$this->showImageUrl = 'show-img/%s';
		
		/**
		 * 
		 * Object Columns
		 * @var unknown_type
		 */
		$this->columns = array ('irn', 
			'WebSummaryData', 
			'SummaryData', 
			'SumItemName',
			'image.resource', 
			'CatRegNumber', 
			'SumRegNum', 
			'MulHasMultiMedia',
			'ObjLabel', 
			'SumArchSiteName', 
			'ProPlace', 
			'QuiTaxonLocal', 
			'ProCountry_tab', 
			'ProCollectionArea', 
			'ProStateProvince_tab', 
			'AcqRegDate', 
			'SumCategory', 
			'AdmWebMetadata',
			'ObjIndigenousName',
			'ObjDescription',
			'images',
			'AdmInsertedBy',//author
			'SumCategory'//type
		);
		
		/**
		 * 
		 * Narrative Columns
		 * @var unknown_type
		 */
		$this->narrativeColumns = array (
			'irn', 
			'NarTitle', 
			'SummaryData',
			'image',
			'ObjObjectsRef_tab', //Related Objects
			'AssMasterNarrativeRef',//Related Stories
			'AssAssociatedWithRef_tab', 
			'NarNarrative',
			'AdmInsertedBy',
			//'resource{resource:only, width:520}'
			);
		
		/**
		 * Image Columns
		 * @var 
		 */
		$this->ImageColumns = array 
		( 
			'image.resource',
			'DocHeight_tab',
			'DocWidth_tab',
			'DocIdentifier_tab',
			'DocMimeType_tab',
			'DocMimeFormat_tab',
			'DocFileSize_tab',
			'MulIdentifier',
			'MulMimeType',
			'MulMimeFormat',
			'MulDocumentType',
			'ChaImageWidth',
			'ChaImageHeight',
			'MulTitle',
			'MulCreator_tab',
			'MulDescription',
			'DetPublisher',
			'DetRights',
			'irn',		
			
		);
		
		/**
		 * Load Lib
		 */
		try
		{
			$ImuSession = App::make ( 'ImuSession' );
			$ImuSession ->host = $this->SearchHost;
			$ImuSession	->port = $this->SearchPort;
			$ImuSession	->connect ();
		
		} catch ( Exception $e )
		{
			$this->error = $e->getMessage ();
		}
	
	}
	
	/**
	 * Lookup
	 *
	 * @param array $searchData
	 * @return array $result
	 * @access public
	 */
	public function lookup($searchData, $pageSize = 30, $offset = 0)
	{
		//Init
		$result = array ('total' => 0, 
			'natural_num' => 0, 
			'cultural_num' => 0, 
			'object_natural_list' => array (), 
			'object_cultural_list' => array (),
			'narrative_natural_list' => array (),
			'narrative_cultural_list' => array (), 
		);
		try
		{
			//Narrative
			$narrative = $this->getNarratives ($searchData, $pageSize,$offset);
			
			//Objects
			$objects = $this->getObjects($searchData, $pageSize, array(), $offset);
			
			$result['total'] = $narrative['cultural_num'] + $narrative['natural_num'] + $objects['natural_num'] + $objects['cultural_num'];
			$result['natural_num'] = $narrative['natural_num']+ $objects['natural_num'];
			$result['cultural_num'] = $narrative['cultural_num']+ $objects['cultural_num'];
			
			$result['object_natural_list'] = $objects['natural_list'];
			$result['object_cultural_list'] = $objects['cultural_list'];
			
			$result['narrative_natural_list'] = $narrative['natural_list'];
			$result['narrative_cultural_list'] = $narrative['cultural_list'];			
			$narrative = $objects = NULL;
		
		} catch ( Exception $e )
		{
			$this->error = $e->getMessage ();
			
		}
		
		return $result;
	}
	
	/**
	 * 
	 * Return Narrative Info
	 */
	public function getNarrativeInfo($id)
	{
		$result = array('title'=>'',
			'content'=>'',
			'mainObjectList'=>array(),
			'mainObjectNum'=>0,
			'narrativeList'=>array(),
			'relatedObjects'=>array(),
		);
		
		try
		{
			$narrative = $this->narrativesModule();
			$hits = $narrative->findKey($id); 
			$tpl = $narrative->fetch('start', 0, 1, $this->narrativeColumns);
			if(!empty($tpl->rows[0]))
			{
				$result['title'] = $tpl->rows[0]['NarTitle'];
				if(!empty($tpl->rows[0]['ObjObjectsRef_tab']))
				{
					$result['main_object'] = $tpl->rows[0]['ObjObjectsRef_tab'];
				}
				if(!empty($tpl->rows[0]['AssAssociatedWithRef_tab']))
				{
					$result['narratives'] = $tpl->rows[0]['AssAssociatedWithRef_tab'];
				}
				if(!empty($tpl->rows[0]['AssMasterNarrativeRef']))
				{
					$result['narratives'][] =  $tpl->rows[0]['AssMasterNarrativeRef'];
				}
				
				$result['content'] =  mb_convert_encoding ( $tpl->rows[0]['NarNarrative'], 'ISO-8859-10', 'UTF-8' );
				
				//Main Object
				if(!empty($result['main_object']))
				{
					$object = $this->ecatalogueModule();
					$hits = $object->findKeys($result['main_object']);
					$col = array_slice ( $this->columns, 0, 7 );
					$col = array_merge($col,array('SumCategory','ProPlace','ProStateProvince_tab','ProCountry_tab','AdmInsertedBy'));
			
					$rows = $object->fetch ( 'start', 0,$hits,$col);
					foreach ($rows->rows as $row)
					{
						$val = array('irn'=>$row['irn'],
							'SumCategory'=>$row['SumCategory'],
							'ProPlace'=>$row['ProPlace'],
							'ProStateProvince_tab'=>$row['ProStateProvince_tab'],
							'ProCountry_tab'=>$row['ProCountry_tab'],
							'AdmInsertedBy'=>$row['AdmInsertedBy']
						);
						
						$val['regNum'] = empty($row['SumRegNum']) ? $row['CatRegNumber'] : $row['SumRegNum'];
						$val['regNum'] = substr($val['regNum'], 0,8);
						if(!empty($row['image']))
						{
							$val['imageIrn'] = $row['image']['irn'];
						}else
						{
							$val['imageIrn'] = -1;
						}
						$u= sprintf($this->showImageUrl,$val['imageIrn']);
						$val['getImageUrl'] = URL::to($u);					
						$result['mainObjectList'][] = $val;
					}
					$rows = NULL;
					unset($result['main_object']);
					$result['mainObjectNum'] = count($result['mainObjectList']);
					
				}
				
				//Related narratives
				if(!empty($result['narratives']))
				{
					$narrative = $this->narrativesModule();
					$hits = $narrative->findKeys($result['narratives']);
					$rows = $narrative->fetch ( 'start', 0,$hits, array_slice ( $this->narrativeColumns, 0, 2 ) );
					
					foreach ($rows->rows as $row)
					{
						$result['narrativeList'][] = $row;
					}
					unset($result['narratives']);
					$rows = NULL;
					
				}			
				
				//Related objects
				if(!empty($result['mainObjectList']))
				{
					$object = reset($result['mainObjectList']);
					$rules = array(
						'objectType'=>$object['SumCategory'],
						'provenance'=>array('place'=>$object['ProPlace'],
							'city'=>reset($object['ProStateProvince_tab']),
							'country'=>reset($object['ProCountry_tab'])),
						'author'=>$object['AdmInsertedBy']
					);
					
	
					$result['relatedObjects'] = $this->getRelatedObjects($rules);					
				}
								
			}			
		}catch (Exception $e)
		{
			$this->error = $e->getMessage();
		}
		return $result;		
	}

	/**
	 * Get object info
	 *
	 * @param int $id
	 * @param int $imgId
	 * @return array
	 */
	public function getObjectInfo($id,$imgId=0)
	{
		$result = array(
			'irn'=>'',
			'title'=>'',
			'images'=>array(),
			'content'=>'',
			'objectId'=>'',
			'objectName'=>'',
			'photoCopy'=>'',
			'photoGrapher'=>'',
			'firstImage'=>'',
			'relatedNarratives'=>array(),
			'relatedObjects'=>array(),
		);
		
		try
		{
			$ecatalog = $this->ecatalogueModule();
			$ecatalog->findKey($id);
			$tpl = $ecatalog->fetch('start', 0, 1, $this->columns);
			if(!empty($tpl->rows[0]))
			{
				$object = $tpl->rows[0];
				$result['irn'] = $object['irn'];
				$tpl = NULL;
				
				$result['title']= $object['WebSummaryData'];
				$ImageModule = $this->imageModule();
				$photoCopy = 'Australian Museum.';
				foreach ($object['images'] as $row)
				{
					$u= sprintf($this->showImageUrl,$row['irn']);
					$row['getImageUrl'] = URL::to($u);
					
					//Get Image Info
					$ImageModule->findKey($row['irn']);  
					$imgInfo = $ImageModule->fetch('start', 0, 1, $this->ImageColumns);				
					$imgInfo = $imgInfo->rows[0];
					$row['photoCopy'] = !empty($imgInfo['DetRights']) ? mb_convert_encoding ( $imgInfo['DetRights'], 'ISO-8859-10', 'UTF-8' ) : $photoCopy;
					$row['photoGrapher'] = reset($imgInfo['MulCreator_tab']);
					
					$result['images'][$imgInfo['irn']] = $row;
				}
				if(empty($result['images']))
				{
					$result['images'][] = array('photoCopy'=>'','photoGrapher'=>'','getImageUrl'=>'/show-img/-1');
				}
				
				
				if(!isset($result['images'][$imgId]))
				{
					$img = reset($result['images']);
					$result['photoCopy'] = $img['photoCopy'];
					$result['photoGrapher'] = $img['photoGrapher'];
					$result['firstImage'] = $img['getImageUrl'];
				}else
				{
					$result['photoCopy'] = $result['images'][$imgId]['photoCopy'];
					$result['photoGrapher'] = $result['images'][$imgId]['photoGrapher'];
					$result['firstImage'] = $result['images'][$imgId]['getImageUrl'];
				}
				
				
				$result['content'] = $object['ObjDescription'];
				$result['objectId'] = empty($object['SumRegNum']) ? $object['CatRegNumber'] : $object['SumRegNum'];
				$result['objectName'] = $object['SumItemName'];
				
				//Related information sheets
				$narratives = array();
				$narrativesModule = $this->narrativesModule();
				$col = array('SummaryData','irn');
				$query = array('ObjObjectsRef_tab',$id);
				$hits =$narrativesModule->findTerms($query);
				$tpl = $narrativesModule->fetch('start', 0, $hits,$col);
				foreach ($tpl->rows as $row)
				{
					$val['irn'] = $row['irn'];
					$val['title'] = $row['SummaryData'];
					$result['relatedNarratives'][] = $val;
				}
				$tpl = NULL;
				
				//Related Object
				$rules = array(
					'objectType'=>$object['SumCategory'],
					'provenance'=>array('place'=>$object['ProPlace'],
						'city'=>reset($object['ProStateProvince_tab']),
						'country'=>reset($object['ProCountry_tab'])),
					'author'=>$object['AdmInsertedBy']
				);

				$result['relatedObjects'] = $this->getRelatedObjects($rules);
				if(isset($result['relatedObjects'][$id]))
				{
					unset($result['relatedObjects'][$id]);
				}
			}
			
			
		}catch (Exception $e)
		{
			
			$this->error = $e->getMessage();
		}
		return $result;
	}

	/**
	 * 
	 * Get Objects list
	 * @param $searchData array
	 * @param $pageSize int
	 * @param array $columns
	 * @param int $offset
	 * @return $result
	 * 
	 */	
	public function getObjects($searchData, $pageSize=19, $columns=array(), $offset = 0)
	{
		$result = array ('natural_num' => 0, 'cultural_num' => 0, 'natural_list' => array (), 'cultural_list' => array () );
		if(empty($columns))
		{
			$columns = array_slice ( $this->columns, 0, 2 );
		}
		
		
		$ecatalogueModule = $this->ecatalogueModule ();
		$query = $this->buildQuery ( $searchData );
		if (! empty ( $query ))
		{
			$hits = $ecatalogueModule->findTerms ( $query );
			if (! empty ( $hits ))
			{
				
				//Count Natural Science items Cultural collections items
				if (! in_array ( $searchData ['collection'], $this->_collection ))
				{
					
					$searchData ['collection'] = 'natural';
					$query = $this->buildQuery ( $searchData );
					$natural_hits = $ecatalogueModule->findTerms ( $query );
					$result ['natural_num'] = $natural_hits;
					$tpl = $ecatalogueModule->fetch ('start', $offset, $pageSize, $columns);
					foreach ( $tpl->rows as $row )
					{
						$row ['WebSummaryData'] = mb_convert_encoding ( $row ['WebSummaryData'], 'ISO-8859-10', 'UTF-8' );
						$result ['natural_list'] [] = $row;
					}
					
					$searchData ['collection'] = 'cultural';
					$query = $this->buildQuery ( $searchData );
					$cultural_hits = $ecatalogueModule->findTerms ( $query );
					$result ['cultural_num'] = $cultural_hits;
					$tpl = $ecatalogueModule->fetch ('start', $offset, $pageSize, $columns );
					foreach ( $tpl->rows as $row )
					{
						$row ['WebSummaryData'] = mb_convert_encoding ( $row ['WebSummaryData'], 'ISO-8859-10', 'UTF-8' );
						$result ['cultural_list'] [] = $row;
					}
				
				} else
				{
					$result [$searchData ['collection'] . '_num'] = $hits;
					$tpl = $ecatalogueModule->fetch ( 'start', $offset, $pageSize, $columns );
					foreach ( $tpl->rows as $row )
					{
						$row ['WebSummaryData'] = mb_convert_encoding ( $row ['WebSummaryData'], 'ISO-8859-10', 'UTF-8' );
						$result [$searchData ['collection'] . '_list'] [] = $row;
					}
				}
			}
		}
		return $result;
	}

	/**
	 * 
	 * GET Related Object
	 * @param array $rules array('objectType','provenance','author')
	 * @internal
	 * 				$rules = array(
					'objectType'=>$object['SumCategory'],
					'provenance'=>array('place'=>$object['ProPlace'],
						'city'=>reset($object['ProStateProvince_tab']),
						'country'=>reset($object['ProCountry_tab'])),
					'author'=>$object['AdmInsertedBy']
				);
	 */
	public function getRelatedObjects($rules=array(),$pageSize=0)
	{
		$list = array();
		if(!isset($rules['objectType']) or !isset($rules['provenance']) or !isset($rules['author']))
		{
			return $list;
		}		
		try 
		{
			
			$terms = array();
			$object = $this->ecatalogueModule();
			$col = array('irn','SumRegNum','CatRegNumber','image');
			//A = Object type
			if(!empty($rules['objectType']))
			{
				$queryField = 'SumCategory';
				$object->addSearchAlias ( 'objectType', $queryField );
				$terms [] = array ('objectType',$rules['objectType']);				
			}
			//C = Author
			if(!empty($rules['author']))
			{
				$queryField = 'AdmInsertedBy';
				$object->addSearchAlias ( 'author', $queryField );
				$terms [] = array ('author',$rules['author']);				
			}
			
			//Query
			if(!empty($terms))
			{
				$search = array('and',$terms);
				$hits = $object->findTerms ( $search );
				$f = $object->fetch ( 'start', 0,$hits, $col);
				if(!empty($f->rows))
				{
					$list = $this->parseList($f->rows);
				}				
			}		
			
			//B = Provenance
			$placeList = array();
			if(!empty($rules['provenance']['place']))
			{
				$hits = $object->findTerms ( array('ProPlace',$rules['provenance']['place']) );
				$f = $object->fetch ( 'start', 0,$hits, $col);
				if(!empty($f->rows))
				{
					$placeList = $this->parseList($f->rows);
				}				
			}
			if(!empty($rules['provenance']['city']) and empty($placeList))
			{
				$hits = $object->findTerms ( array('ProStateProvince_tab',$rules['provenance']['city']) );
				$f = $object->fetch ( 'start', 0,$hits, $col);
				if(!empty($f->rows))
				{
					$placeList = $this->parseList($f->rows);
				}				
			}
			if(!empty($rules['provenance']['country']) and empty($placeList))
			{
				$hits = $object->findTerms ( array('ProCountry_tab',$rules['provenance']['country']) );
				$f = $object->fetch ( 'start', 0,$hits, $col);
				if(!empty($f->rows))
				{
					$placeList = $this->parseList($f->rows);
				}				
			}			
			$f = NULL;
			$list = $list+$placeList;
			
		}catch (Exception $e)
		{
			$this->error = $e->getMessage();
		}
		return $list;		
	}
	
	
	/**
	 * 
	 * Get narratives list
	 * @param $searchData array
	 * @param $pageSize int
	 * @return $narrative
	 * 
	 */
	public function getNarratives($searchData, $pageSize = 30,$offset=0)
	{
		$narrative = array ('cultural_num'=>0,'cultural_list'=>array(),'natural_num'=>0,'natural_list'=>array());
		//Cultural
		$keyWords = array('keyWords'=>$searchData['keyWords'].' cultural');
		$res = $this->getNarrativesList($keyWords,$pageSize,$offset);
		$narrative['cultural_num'] = $res['num'];
		$narrative['cultural_list'] = $res['list'];
		
		//Natural
		$keyWords = array('keyWords'=>$searchData['keyWords'].' natural');
		$res = $this->getNarrativesList($keyWords,$pageSize,$offset);
		
		$narrative['natural_num'] = $res['num'];
		$narrative['natural_list'] = $res['list'];		
		$res = NULL;
		
		return $narrative;
	}
	
	
	/**
	 * 
	 * Get Image
	 * @param $size array(100,100)
	 */
	public function getImage($irn, $size=array(100,100))
	{
		if(!is_numeric($irn) or $irn<0)
		{
			echo file_get_contents($this->defaultImage,'rb');
			exit;
		}
		
		if(empty($size[0]) or !is_numeric($size[0]))
		{
			$size[0] = 100;
		}
		if(empty($size[1]) or !is_numeric($size[1]))
		{
			$size[1] = 100;
		}		
		
		$ImageModule = $this->imageModule();
		$ImageModule->findKey($irn);  
		$result = $ImageModule->fetch('start', 0, 1, 
			array('irn', 
				'SummaryData', 
				"resource{resource:only,width:$size[0],height:$size[1]}"
			)
		);
		
		if(!empty($result->rows[0]['resource']['file']))
		{
			$file = $result->rows[0]['resource']['file'];
			header('Content-type: image/' . $result->rows[0]['resource']['mimeFormat']);
		    while(true)
        	{
                $data = fread($file, 4096);
                if ($data === false || strlen($data) == 0)
                        break;
                print $data;
        	}			
		}else
		{
			echo file_get_contents($this->defaultImage,'rb');	
		}
		exit;
	}
	

	
	/**
	 * 
	 * Return ecatalogue Module
	 */
	public function ecatalogueModule()
	{
		Config::set ( 'imu.module_table', 'ecatalogue' );
		return App::make ( 'ImuModule' );
	}
	
	/**
	 * 
	 * Return Image Module
	 */
	public function imageModule()
	{
		Config::set ( 'imu.module_table', 'emultimedia' );
		return App::make ( 'ImuModule' );
	}
	
	/**
	 * 
	 * Narratives Modules
	 * 
	 */
	public function narrativesModule()
	{
		Config::set ( 'imu.module_table', 'enarratives' );
		return App::make ( 'ImuModule' );
	}
	
	
	/**
	 * 
	 *  Parse List
	 * @param array $inputList
	 * @return array $outList
	 */
	private function parseList($inputList)
	{
		$outList = array();
		foreach ($inputList as $row)
		{
			if(!empty($row['image']))
			{
				$row['imageIrn'] = $row['image']['irn'];
			}else
			{
				$row['imageIrn'] = -1;
			}
			$u= sprintf($this->showImageUrl,$row['imageIrn']);
			$row['getImageUrl'] = URL::to($u);
			
			$row['SumRegNum'] = !empty($row['SumRegNum']) ? $row['SumRegNum'] : $row['CatRegNumber'];
			$row['SumRegNum'] = substr($row['SumRegNum'],0,8);
			
			unset($row['image'],$row['CatRegNumber']);						
			$outList[$row['irn']] = $row;
		}
		return $outList;		
	}
	
	/**
	 * 
	 * Get Narratives List
	 * @param $searchData array
	 */
	private function getNarrativesList($searchData,$pageSize=0,$offset=0)
	{
		$res = array('num'=>0,'list'=>array());
		$query = $this->buildNarrativeQuery ( $searchData );
		if (! empty ( $query ))
		{
			$narrativesModule = $this->narrativesModule ();
			$hits = $narrativesModule->findTerms ( $query );
			if(empty($pageSize))
			{
				$pageSize = $hits;
			}
			
			$f = $narrativesModule->fetch ( 'start',$offset,$pageSize, array_slice ( $this->narrativeColumns, 0, 5 ) );
			$res ['num'] = $f->hits;
			
			foreach ( $f->rows as $row )
			{
				$row['NarTitle'] = mb_convert_encoding ( $row['NarTitle'], 'ISO-8859-10', 'UTF-8' );
				$row['SummaryData'] = mb_convert_encoding ( $row['SummaryData'], 'ISO-8859-10', 'UTF-8' );
				if(!empty($row['image']))
				{
					$row['imageIrn'] = $row['image']['irn'];
				}else
				{
					$row['imageIrn'] = -1;
				}
				$u= sprintf($this->showImageUrl,$row['imageIrn']);
				$row['getImageUrl'] = URL::to($u);
				
				unset($row['image']);
				$res ['list'] [] = $row;
			}
		}
		return $res;		
	}
		
	
	/**
	 * 
	 * Build Narrative Query
	 * @param array $searchData
	 * @return array
	 * @internal
	 */
	private function buildNarrativeQuery($searchData = array())
	{
		$terms = array ();
		if (! empty ( $searchData ['keyWords'] ))
		{
			$terms [] = array ('NarTitle', $searchData ['keyWords'] );
			$terms [] = array ('NarNarrative', $searchData ['keyWords'] );
			$terms [] = array ('SummaryData', $searchData ['keyWords'] );
		}
		if (empty ( $terms ))
		{
			return $terms;
		}
		
		return array ('or', $terms );
	
	}
	
	/**
	 * 
	 * Build Query
	 * @param array $searchData
	 * @return array
	 * @internal
	 */
	private function buildQuery($searchData = array())
	{
		
		$terms = array ();
		if (! empty ( $searchData ['keyWords'] ))
		{
			$terms [] = array ('SummaryData', $searchData ['keyWords'] );
		}
		//eg:18/09/1979
		if (! empty ( $searchData ['date'] ))
		{
			$terms [] = array ('AcqRegDate', $searchData ['date'] );
		}
		
		if (! empty ( $searchData ['location'] ))
		{
			$columns = 'ProPlace;ProStateProvince_tab;ProCountry_tab;ProCollectionArea';
			
			$ecatalogueModule = $this->ecatalogueModule ();
			
			$ecatalogueModule->addSearchAlias ( 'location', $columns );
			$terms [] = array ('location', $searchData ['location'] );
		}
		
		//Cultural Collection
		if ($searchData ['collection'] == end ( $this->_collection ))
		{
			if (! empty ( $searchData ['registration'] ))
			{
				$terms [] = array ('SumRegNum', $searchData ['registration'] );
			} else
			{
				
				$terms [] = array ('CatRegNumber', 'null', '=' );
			}
		
		//Natural Science
		} elseif ($searchData ['collection'] == reset ( $this->_collection ))
		{
			if (! empty ( $searchData ['registration'] ))
			{
				$terms [] = array ('CatRegNumber', $searchData ['registration'] );
			} else
			{
				$terms [] = array ('SumRegNum', 'null', '=' );
			
			}
		
		//All
		} else
		{
			if (! empty ( $searchData ['registration'] ))
			{
				$or_terms = array ();
				$or_terms [] = array ('SumRegNum', $searchData ['registration'] );
				$or_terms [] = array ('CatRegNumber', $searchData ['registration'] );
				$terms [] = array ('or', $or_terms );
			}
		}
		
		if (! empty ( $searchData ['imagesOnly'] ))
		{
			$terms [] = array ('MulHasMultiMedia', 'y' );
		}
		//Noting?
		if (empty ( $terms ))
		{
			return $terms;
		}
		return array ('and', $terms );
	
	}
}
