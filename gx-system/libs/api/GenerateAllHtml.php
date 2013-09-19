<?php

exit('GenerateAllHtml: You Need To Switch the Fun By Hand!');

require_once dirname(dirname(__FILE__)).'/tools/load.php'; 

$Article = ArticleModel::get_instance();
$rows = $Article->get_articles(10000);
foreach ($rows as $row){
	$i = 1;
	$TemplateAction = new TemplateAction();
	$TemplateAction->generate_archive($row['id']);
	echo 'Have Generated '.$i++.'</br>';
	unset($TemplateAction);
	//GXEngien 处理 - 清理模板的GXEngien引用
	ObjectManager::clear_object(ObjectManager::TemplateActionGXEngien);
}