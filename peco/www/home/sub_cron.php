<?
function cron_default(){
	global $core, $assign_list, $mod, $sub, $act;
	exit();
}
/**
 * Module: [home]
 * Home function with $sub=cron, $act=updatePV
 * Update page view
 */
function cron_updatePV(){
	
}
/**
 * Module: [home]
 * Home function with $sub=cron, $act=updateTopic
 * Update total articles of topic
 */
function cron_updateTopic(){
	global $dbconn;
	$clsTopic = new Topics();
	$arrListTopic = $clsTopic->getAll();
	if (is_array($arrListTopic))
	foreach ($arrListTopic as $key => $val){
		Topic_Articles::updateTotalArticle($val['id']);
	}
	echo "1";
	exit();
}
?>