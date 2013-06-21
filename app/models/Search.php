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
	
	protected $columns = NULL;
	protected $narrativeColumns = NULL;
	
	public $error = NULL;
	
	private $_collection = array ('natural', 'cultural' );
	
	/**
	 * 
	 * Construct 
	 * @param string $table
	 */
	public function __construct()
	{
		/**
		 * 
		 * Object Columns
		 * @var unknown_type
		 */
		$this->columns = array ('irn', 
			'WebSummaryData', 
			'SummaryData', 
			'SumItemName', 
			'MulHasMultiMedia', 
			'CatRegNumber', 
			'SumItemName', 
			'ObjLabel', 
			'SumArchSiteName', 
			'ProPlace', 
			'QuiTaxonLocal', 
			'ProCountry_tab', 
			'ProCollectionArea', 
			'ProStateProvince_tab', 
			'AcqRegDate', 
			'SumRegNum', 
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
			'AssAssociatedWithRef_tab', //Related Stories
			'NarNarrative' );
		
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
	public function lookup($searchData, $pageSize = 50)
	{
		$result = array ('total' => 0, 'natural_num' => 0, 'cultural_num' => 0, 'natural_list' => array (), 'cultural_list' => array () );
		try
		{
			//Narrative
			$list = $this->getNarratives ( $searchData, $pageSize );
			
			//Objects
			$objects = $this->getObjects($searchData,$pageSize);
			
			$result['total'] = $list['total'] + $objects['total'];
		
		} catch ( Exception $e )
		{
			$this->error = $e->getMessage ();
			var_dump ( $e );
		
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
		$result = array ('total' => 0, 'natural_num' => 0, 'cultural_num' => 0, 'natural_list' => array (), 'cultural_list' => array () );
		$ecatalogueModule = $this->ecatalogueModule ();
		$query = $this->buildQuery ( $searchData );
		if (! empty ( $query ))
		{
			$hits = $ecatalogueModule->findTerms ( $query );
			$result ['total'] = $hits;
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
		$narrative = array ('total'=>0,'list'=>array());
		$narrativesModule = $this->narrativesModule ();
		$query = $this->buildNarrativeQuery ( $searchData );
		if (! empty ( $query ))
		{
			$hits = $narrativesModule->findTerms ( $query );
			$f = $narrativesModule->fetch ( 'start', 0, $pageSize, array_slice ( $this->narrativeColumns, 0, 5 ) );
			$narrative ['total'] = $f->hits;
			
			$ImageModule = $this->ImageModule();
			var_dump($ImageModule);exit;
			foreach ( $f->rows as $row )
			{
				if (! empty ( $row ['image'] ))
				{
					$ImageModule->findKey($row['image']['irn']); 
					$columns = array 
					( 
					 'image.resource' 
					); 
					$result = $ImageModule->fetch('start', 0, 1, $columns);
					$row ['image'] = $result[0]['image']['resource']['file']; 					
				} else
				{
					$row ['image'] = HTML::image ( 'images/100.jpg' );
				}
				$narrative ['list'] [] = $row;
			}
		}
		return $narrative;
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
		App::instance('ImuModule','');
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
