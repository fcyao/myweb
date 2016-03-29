<?php
/*
 * 空中急救模块API
 * 1.3.6. get_org_userlist.php (获取志愿者list)
 */
include(dirname(__FILE__) . "/common/inc.php");
$config = new Config();
$logger = Logger::getLogger(basename(__FILE__));
$params = array(array("ss",true),array("org_id",true));

//print_r($_POST);
$params = Filter::paramCheckAndRetRes($_POST, $params);
if(!$params){
	$logger->error(sprintf("params error. params is %s",v($_POST)));
	ErrCode::echoErr(ErrCode::API_ERR_MISSED_PARAMATER,1);
}

//获取参数
$ss = $params['ss'];
$org_id = $params['org_id'];


$databaseManager = new DatabaseManager();
$dbMaster = $databaseManager->getConn(); //连接sky_first_aid



//数据库链接失败

if(!$dbMaster){
	$logger->error(sprintf("Database sky_first_aid connect fail."));
	ErrCode::echoErr(ErrCode::SYSTEM_ERR,1);
}
//验证session{}
$sessionArr = $databaseManager->checkSession($ss);

if(!$sessionArr){
	$logger->error(sprintf(" Session fail."));
	ErrCode::echoErr(ErrCode::API_ERR_INVALID_SESSION,1);

}

$userId = (int)$sessionArr['user_id'];

//数据逻辑
//通过用户
$sql = "select * from sky_organization_user_join_apply WHERE  org_id ='$org_id' AND apply_state = 1 ORDER BY apply_time DESC ";

//$logger->error(v($sql));
$result[0] = $dbMaster->getAll($sql);

//待审核用户
$sql = "select * from sky_organization_user_join_apply WHERE  org_id ='$org_id' AND apply_state = 0 ORDER BY apply_time DESC ";

$result[1] = $dbMaster->getAll($sql);
ErrCode::echoJson('1','success',$result);

?>































