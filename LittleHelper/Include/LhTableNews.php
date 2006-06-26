<?php
class LhTableNews extends LhTable
{
	private $translation= array (
		'tableName' => 'news',
		'cellNameUniqueId' => 'news_id',
		'cellNameDateCreated' => 'date_created',
		'cellNameDateChanged' => 'date_changed',
		'order' => 'ORDER BY date_created DESC',
		'keyForChildren' => '//CHILDREN//'
	);
	public function __construct(& $pdoHandler, $tableName= false)
	{
		if ($tableName !== false)
		{
			$translation['tableName']= $tableName;
		}
		$minDate= mktime(0, 0, 0, date('m', time()), date('d', time()), date('Y', time()));
		$maxDate= mktime(23, 59, 59, date('m', time()), date('d', time()), date('Y', time()));
		$this->translation['where']= 'WHERE `date_created`>\'' . $minDate . '\' ';
		$this->translation['where'] .= '&& `date_created`<\'' . $maxDate . '\'';
		parent :: __construct(& $pdoHandler, $this->translation);
	}
}