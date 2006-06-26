<?php
require dirname(__FILE__) . '/../Include.php';
require dirname(__FILE__) . '/Config.php';
$databaseHost = 'localhost';
$databasePort = 3306;
$databaseName = 'test';
$databaseUserName = 'test';
$databaseUserPassword = 'test';
$pdo = LhPdo :: connect($databaseHost, $databasePort, $databaseName, $databaseUserName, $databaseUserPassword);
$news = new LhTableNews($pdo);
$newsId = $news->addNews('News 1', 'Preview 1');
$news->updateNews($newsId, 'News ' . $newsId, 'Preview ' . $newsId);
$pageId = $news->addPage($newsId, 'News ' . $newsId . ' - Page 1', 'Content 1');
$news->updatePage($pageId, 'News ' . $newsId . ' - Page ' . $pageId, 'Content ' . $pageId);
echo $newsId . '-' . $pageId . '<br>';
$pageId = $news->addPage($newsId, 'News ' . $newsId . ' - Page 1', 'Content 1');
$news->updatePage($pageId, 'News ' . $newsId . ' - Page ' . $pageId, 'Content ' . $pageId);
echo $newsId . '-' . $pageId . '<br>';
$pageId = $news->addPage($newsId, 'News ' . $newsId . ' - Page 1', 'Content 1');
$news->updatePage($pageId, 'News ' . $newsId . ' - Page ' . $pageId, 'Content ' . $pageId);
echo $newsId . '-' . $pageId . '<br>';
$results=$news->getPagePreview(0, 30);
echo '<pre>'. print_r($results, 1).'</pre>';
?>