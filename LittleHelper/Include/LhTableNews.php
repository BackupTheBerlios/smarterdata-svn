<?php
class LhTableNews extends LhTable
{
	private $translation= array (
		'tableName' => '',
		'cellNameUniqueId' => '',
		'cellNameParentId' => '',
		'cellNameDateCreated' => '',
		'cellNameDateChanged' => '',
		'order' => '',
		'keyForChildren' => ''
	);
	private $dateMin= '';
	private $dateMax= '';
	public function __construct(& $pdoHandler, $tableName= false)
	{
		if ($tableName !== false)
		{
			$this->translation['tableName']= $tableName;
		}
		else
		{
			$this->translation['tableName']= 'news';
		}
		$this->translation['cellNameUniqueId']= $this->getCellNameNewsId();
		$this->translation['cellNameParentId']= $this->getCellNameNewsGroupId();
		$this->translation['cellNameDateCreated']= $this->getCellNameNewsDateCreated();
		$this->translation['cellNameDateChanged']= $this->getCellNameNewsDateChanged();
		$this->translation['order']= $this->getDefaultOrder();
		$this->translation['keyForChildren']= '//CHILDREN//';
		$dateDay= date('d', time());
		$dateMonth= date('m', time());
		$dateYear= date('Y', time());
		$this->setDateMin($dateDay, $dateMonth, $dateYear);
		$this->setDateMax($dateDay, $dateMonth, $dateYear);
		parent :: __construct($pdoHandler, $this->translation);
		$this->initTable();
	}
	public function __destruct()
	{
	}
	private function initTable()
	{
		$query= 'CREATE TABLE IF NOT EXISTS `' . $this->getTableName() . '` ( ';
		$query .= '`' . $this->getCellNameNewsId() . '` BIGINT, ';
		$query .= '`' . $this->getCellNameNewsGroupId() . '` BIGINT DEFAULT 0, ';
		$query .= '`' . $this->getCellNameDateCreated() . '` CHAR( 20 ), ';
		$query .= '`' . $this->getCellNameDateChanged() . '` CHAR( 20 ), ';
		$query .= '`' . $this->getCellNameNewsPage() . '` INT DEFAULT 0, ';
		$query .= '`' . $this->getCellNameNewsHeadline() . '` CHAR( 255 ), ';
		$query .= '`' . $this->getCellNameNewsContent() . '` TEXT, ';
		$query .= 'UNIQUE (`' . $this->getCellNameUniqueId() . '`))';
		$pdo= $this->getPdoHandler()->prepare($query);
		$pdo->execute();
		$pdo= null;
	}
	public function setDateMin($day, $month, $year)
	{
		$this->dateMin= $this->generateDate(0, 0, 0, $day, $month, $year);
		$this->setCurrentTime();
	}
	public function getDateMin()
	{
		return $this->dateMin;
	}
	public function setDateMax($day, $month, $year)
	{
		$this->dateMax= $this->generateDate(23, 59, 59, $day, $month, $year);
		$this->setCurrentTime();
	}
	public function getDateMax()
	{
		return $this->dateMax;
	}
	private function setCurrentTime($additionalWhere= null)
	{
		$where[0]['cell_name']= $this->getCellNameDateCreated();
		$where[0]['cell_op']= '>';
		$where[0]['cell_value']= $this->dateMin;
		$where[1]['cell_name']= $this->getCellNameDateCreated();
		$where[1]['cell_op']= '<';
		$where[1]['cell_value']= $this->dateMax;
		$this->setWhere($where);
	}
	private function generateDate($hour, $min, $sec, $day, $month, $year)
	{
		$return= mktime($hour, $min, $sec, $month, $day, $year);
		return $return;
	}
	public function addNews($headline, $preview)
	{
		$newsData[$this->getCellNameNewsHeadline()]= $headline;
		$newsData[$this->getCellNameNewsContent()]= $preview;
		$newsData[$this->getCellNameParentId()]= '0';
		$newsData[$this->getCellNameNewsPage()]= '0';
		$newsId= parent :: newRow($newsData);
		return $newsId;
	}
	public function updateNews($newsId, $headline= null, $preview= null)
	{
		if ($headline !== null)
		{
			$newsData[$this->getCellNameNewsHeadline()]= $headline;
		}
		if ($preview !== null)
		{
			$newsData[$this->getCellNameNewsContent()]= $preview;
		}
		return parent :: updateRow($newsId, $newsData);
	}
	public function addPage($newsId, $pageHeadline, $pageContent)
	{
		$where[0]['cell_name']= $this->getCellNameParentId();
		$where[0]['cell_op']= '=';
		$where[0]['cell_value']= (int) $newsId;
		$where[1]['cell_name']= $this->getCellNameNewsPage();
		$where[1]['cell_op']= '>';
		$where[1]['cell_value']= '0';
		$this->setWhere($where);
		$order[0]['cell_name']= $this->getCellNameNewsPage();
		$order[0]['direction']= 'DESC';
		$this->setOrder($order);
		$lastPage= parent :: getFirstRow();
		$newsPage= 1;
		if (is_array($lastPage))
		{
			$newsPage= (int) $lastPage[$this->getCellNameNewsPage()] + 1;
		}
		$newsData[$this->getCellNameNewsHeadline()]= $pageHeadline;
		$newsData[$this->getCellNameNewsContent()]= $pageContent;
		$newsData[$this->getCellNameParentId()]= $newsId;
		$newsData[$this->getCellNameNewsPage()]= $newsPage;
		$pageId= parent :: newRow($newsData);
		return $pageId;
	}
	public function updatePage($pageId, $pageHeadline= null, $pageContent= null)
	{
		if ($pageHeadline !== null)
		{
			$newsData[$this->getCellNameNewsHeadline()]= $pageHeadline;
		}
		if ($pageContent !== null)
		{
			$newsData[$this->getCellNameNewsContent()]= $pageContent;
		}
		return parent :: updateRow($pageId, $newsData);
	}
	public function getPagePreview($pageNumber, $rowsPerPage)
	{
		$this->setCurrentTime();
		$where= $this->getWhere();
		$where[]= array (
		'cell_name' => $this->getCellNameParentId(), 'cell_op' => '=', 'cell_value' => '0');
		$this->setWhere($where);
		$this->setDefaultOrder();
		$results= parent :: getPage($pageNumber, $rowsPerPage);
		return $results;
	}
	protected function getCellNameNewsId()
	{
		return 'news_id';
	}
	protected function getCellNameNewsParentId()
	{
		return 'news_parent_id';
	}
	protected function getCellNameNewsContent()
	{
		return 'news_content';
	}
	protected function getCellNameNewsHeadline()
	{
		return 'news_headline';
	}
	protected function getCellNameNewsPage()
	{
		return 'news_page';
	}
	protected function getCellNameNewsGroupId()
	{
		return 'news_group_id';
	}
	protected function getCellNameNewsDateCreated()
	{
		return 'news_created';
	}
	protected function getCellNameNewsDateChanged()
	{
		return 'news_changed';
	}
	protected function getDefaultOrder()
	{
		$order[0]['cell_name']= $this->getCellNameNewsDateCreated();
		$order[0]['direction']= 'DESC';
		return $order;
	}
	protected function setDefaultOrder()
	{
		$order= $this->getDefaultOrder();
		$this->setOrder($order);
	}
}