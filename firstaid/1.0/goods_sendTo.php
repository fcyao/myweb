<?php
/*
 * 空中急救模块API
 * 1.3.6. set_org_apply.php (获取机构list)
 */
include(dirname(__FILE__) . "/common/inc.php");
$config = new Config();
$logger = Logger::getLogger(basename(__FILE__));
$params = array(array("ss",true),array("order_nums",true),array("acc",true));

//print_r($_POST);
$params = Filter::paramCheckAndRetRes($_POST, $params);
if(!$params){
	$logger->error(sprintf("params error. params is %s",v($_POST)));
	ErrCode::echoErr(ErrCode::API_ERR_MISSED_PARAMATER,1);
}

//获取参数
$ss = $params['ss'];
$order_nums = $params['order_nums'];
$acc = $params['acc'];


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


$sql = "insert into user_buy_goods_largess_info (order_nums,accepter,sender,createDate) VALUES ('$order_nums','$acc','$userId',NOW())";
$logger->error(v($sql));
$res = $dbMaster->execute($sql);
if($res){
    $sql = "update user_buy_goods_info set user_id='$acc',pay_time=now() WHERE order_nums = '$order_nums'";
    $dbMaster->execute($sql);
    ErrCode::echoJson('1','success',array());
}

?>































