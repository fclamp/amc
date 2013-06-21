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
			'SumItemName', 
			'ObjLabel', 
			'SumArchSiteName', 
			'ProPlace', 
			'QuiTaxonLocal', 
			'ProCountry_tab', 
			'ProCollectionArea', 
			'ProStateProvince_tab', 
			'AcqRegDate', 
			'SumCategory', 
			'AdmWebMetadata' );
		
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
			'NarNarrative' );
		
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
	public function lookup($searchData, $pageSize = 30)
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
			$narrative = $this->getNarratives ( $searchData, $pageSize );
			
			//Objects
			$objects = $this->getObjects($searchData,$pageSize);
			
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
			var_dump($e);
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
			'main_object_list'=>array(),
			'main_object_num'=>0,
			'narrative_list'=>array(),
			'related_objects'=>array(),
		);
		$narrative = $this->narrativesModule();
		$hits = $narrative->findKey($id); 
		$tpl = $narrative->fetch('start', 0, 1,$this->narrativeColumns); 
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
			
			$tpl = NULL;
			
			//Main Object
			if(!empty($result['main_object']))
			{
				$object = $this->ecatalogueModule();
				$hits = $object->findKeys($result['main_object']);
				$rows = $object->fetch ( 'start', 0,$hits, array_slice ( $this->columns, 0, 7 ) );
				foreach ($rows->rows as $row)
				{
					$val = array('irn'=>$row['irn']);
					$val['regNum'] = empty($row['SumRegNum']) ? $row['CatRegNumber'] : $row['SumRegNum'];
					if(!empty($row['image']))
					{
						$val['imageIrn'] = $row['image']['irn'];
					}else
					{
						$val['imageIrn'] = -1;
					}
					$u= sprintf($this->showImageUrl,$val['imageIrn']);
					$val['getImageUrl'] = URL::to($u);					
					$result['main_object_list'][] = $val;
				}
				$rows = NULL;
				unset($result['main_object']);
				$result['main_object_num'] = count($result['main_object_list']);
				
			}
			
			//Related narratives
			if(!empty($result['narratives']))
			{
				$narrative = $this->narrativesModule();
				$hits = $narrative->findKeys($result['narratives']);
				$rows = $narrative->fetch ( 'start', 0,$hits, array_slice ( $this->narrativeColumns, 0, 2 ) );
				
				foreach ($rows->rows as $row)
				{
					$result['narrative_list'][] = $row;
				}
				unset($result['narratives']);
				$rows = NULL;
				
			}			
			
			//Related objects
						
		}
		return $result;		
	}
	
	
	
	/**
	 * 
	 * Get Objects list
	 * @param $searchData array
	 * @param $pageSize int
	 * @return $result
	 * 
	 */	
	public function getObjects($searchData,$pageSize=19)
	{
		$result = array ('natural_num' => 0, 'cultural_num' => 0, 'natural_list' => array (), 'cultural_list' => array () );
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
					$tpl = $ecatalogueModule->fetch ( 'start', 0, $pageSize, array_slice ( $this->columns, 0, 2 ) );
					foreach ( $tpl->rows as $row )
					{
						$row ['WebSummaryData'] = mb_convert_encoding ( $row ['WebSummaryData'], 'ISO-8859-10', 'UTF-8' );
						$result ['natural_list'] [] = $row;
					}
					
					$searchData ['collection'] = 'cultural';
					$query = $this->buildQuery ( $searchData );
					$cultural_hits = $ecatalogueModule->findTerms ( $query );
					$result ['cultural_num'] = $cultural_hits;
					$tpl = $ecatalogueModule->fetch ( 'start', 0, $pageSize, array_slice ( $this->columns, 0, 2 ) );
					foreach ( $tpl->rows as $row )
					{
						$row ['WebSummaryData'] = mb_convert_encoding ( $row ['WebSummaryData'], 'ISO-8859-10', 'UTF-8' );
						$result ['cultural_list'] [] = $row;
					}
				
				} else
				{
					$result [$searchData ['collection'] . '_num'] = $hits;
					$tpl = $ecatalogueModule->fetch ( 'start', 0, $pageSize, array_slice ( $this->columns, 0, 2 ) );
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
	 * Get narratives list
	 * @param $searchData array
	 * @param $pageSize int
	 * @return $narrative
	 * 
	 */
	public function getNarratives($searchData, $pageSize = 19)
	{
		$narrative = array ('cultural_num'=>0,'cultural_list'=>array(),'natural_num'=>0,'natural_list'=>array());
		//Cultural
		$keyWords = array('keyWords'=>$searchData['keyWords'].' cultural');
		$res = $this->getNarrativesList($keyWords);
		$narrative['cultural_num'] = $res['num'];
		$narrative['cultural_list'] = $res['list'];
		
		//Natural
		$keyWords = array('keyWords'=>$searchData['keyWords'].' natural history');
		$res = $this->getNarrativesList($keyWords);		
		
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
	public function getImage($irn,$size=array(100,100))
	{
		if(!is_numeric($irn) or $irn<0)
		{
			echo file_get_contents($this->defaultImage,'rb');
			exit;
		}
		$ImageModule = $this->ImageModule();
		$ImageModule->findKey($irn);  
		$result = $ImageModule->fetch('start', 0, 1, $this->ImageColumns);
		//echo '<Pre>';
		//print_r($result);exit;
		$imgName = $result->rows[0]['DocIdentifier_tab']['1'];
		$result =NULL;

		//Can't got Server Image, So return defalut image
		echo file_get_contents($this->defaultImage,'rb');
		//return $this->defaultImage;
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
	public function ImageModule()
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
	 * Get Narratives List
	 * @param $searchData array
	 */
	private function getNarrativesList($searchData)
	{
		$res = array('num'=>0,'list'=>array());
		$query = $this->buildNarrativeQuery ( $searchData );
		if (! empty ( $query ))
		{
			$narrativesModule = $this->narrativesModule ();
			$hits = $narrativesModule->findTerms ( $query );
			$f = $narrativesModule->fetch ( 'start', 0,$hits, array_slice ( $this->narrativeColumns, 0, 5 ) );
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
