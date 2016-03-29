<?php
/*
 * 空中急救模块API
 * 1.3.6. set_org_apply.php (提交志愿者注册申请表)
 */
include(dirname(__FILE__) . "/common/inc.php");
$config = new Config();
$logger = Logger::getLogger(basename(__FILE__));
$params = array(array("ss",true),array("org_id",true),array("name",true),array("sex",true),array("birthday",true),array("nation",true),array("address",true),array("phone",true),array("email",true),array("education",true),array("speciality",true),array("company",true),array("undergo",true));

//print_r($_POST);
$params = Filter::paramCheckAndRetRes($_POST, $params);
if(!$params){
	$logger->error(sprintf("params error. params is %s",v($_POST)));
	ErrCode::echoErr(ErrCode::API_ERR_MISSED_PARAMATER,1);
}

//获取参数
$ss = $params['ss'];
$org_id = $params['org_id'];
$name = $params['name'];
$sex = $params['sex'];
$birthday = $params['birthday'];
$nation = $params['nation'];
$address = $params['address'];
$phone = $params['phone'];
$email = $params['email'];
$education = $params['education'];
$speciality = $params['speciality'];
$company = $params['company'];
$undergo = $params['undergo'];


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
//查询是否存在
$sql = "select id from sky_organization_user_join_apply WHERE org_id = '$org_id' AND user_id = '$userId'";
$resultid = $dbMaster->getOne($sql);
if($resultid){
    //存在
    $sql = "update sky_organization_user_join_apply set  name='$name', sex='$sex', birthday='$birthday', nation='$nation', address='$address', phone='$phone', email='$email', education='$education', speciality='$speciality', company='$company', undergo='$undergo', apply_time=NOW(), apply_state='0'
  WHERE org_id = '$org_id' AND user_id = '$userId'  ";
}else{
    $sql = "insert into sky_organization_user_join_apply (org_id, name, sex, birthday, nation, address, phone, email, education, speciality, company, undergo, apply_time, user_id) VALUES ('$org_id', '$name', '$sex', '$birthday', '$nation', '$address', '$phone', '$email', '$education', '$speciality', '$company', '$undergo', NOW(), '$userId')";
    //echo $sql;
}
//$logger->error(v($sql));
$result = $dbMaster->execute($sql);
if(!$result){
    $logger->error(sprintf(" insert fail."));
    ErrCode::echoErr(ErrCode::SYSTEM_ERR,1);

}

ErrCode::echoJson('1','success',array());

?>































