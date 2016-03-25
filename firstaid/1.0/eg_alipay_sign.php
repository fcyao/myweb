<?php
/**
 * 功能:支付宝支付
* 参数:
* ss：session（必填）
* oid：订单ID（必填）
* cc 备注(非必填)
*/
include(dirname(__FILE__) . "/common/inc.php");
include(dirname(__FILE__) . "/../pay/lib/alipay_notify.class.php");
include(dirname(__FILE__) . "/../pay/alipay.config.php");
$logger = Logger::getLogger(basename(__FILE__));
//参数校验
$params = array(array("ss",true),array("id",true),array("cc",false));
$params = Filter::paramCheckAndRetRes($_POST, $params);
if(!$params){
	$logger->error(sprintf("params error. params is %s",v($_POST)));
	ErrCode::echoErr(ErrCode::API_ERR_MISSED_PARAMATER,1);
}

//过滤参数

$session = $params["ss"]; //用户sesssion
//$cc=addslashes($params['cc']);//备注
$cc=$params['cc'];
//session校验
$databaseManager = new DatabaseManager();
$database = $databaseManager->getConn();
if(!$database){
	$logger->error("database connect error.");
	ErrCode::echoErr(ErrCode::SYSTEM_ERR,1);
}
$sessionArr = $databaseManager->checkSession($session);
if($sessionArr){
	$userID= $sessionArr['user_id'];
}
else
{
	$databaseManager->destoryConn();
	$logger->error(sprintf("Session check is fail. Error session is [%s]",$session));
	Errcode::echoErr(ErrCode::API_ERR_INVALID_SESSION,1);
}

$oid=$params['id'];
$logger->info("收到的内容".$oid);

$sql="select user_name from sky_user_data_master.user_base_info where user_id='$userID'";
$userName=$database->getOne($sql);

$config=new Config();
$notify_url=$config->getConfig("notify_prifix");
//$sql="select  info.goods_name,buy.price
//		from user_buy_goods_info as buy
//		left join first_aid_goods_info as info
//		on info.id = buy.goods_id
//		where order_nums = '$oid'";
//$service=$database->getRow($sql);

//取价格,商品名称
$sql = "select buy.price,info.goods_name from user_buy_goods_info AS buy LEFT JOIN first_aid_goods_info AS info ON info.id = buy.goods_id WHERE buy.order_nums = '$oid'";
$res = $database->getAll($sql);
//var_dump($res);
$total = 0;
$gname = '';
foreach ($res as $p) {
    $total = $total + $p['price'];
    $gname .= $p['goods_name'].',';
}
$gname = substr($gname,0,-1);


if (empty($res)){
	$logger->info("支付订单不存在");
	ErrCode::echoErr(ErrCode::API_ERR_EG_ORDER_NO,1);
}

$notify_url=urlencode($notify_url.'/eg_alipay_notify.php');//回调地址firstaid/pay/eg_alipay_notify.php
$logger->error(v($notify_url));
$res='partner="'.$alipay_config['partner'].'"&out_trade_no="'.$oid.'"&subject="'.$userName.'购买'.$gname.'"&body="'.$userName.'购买'.$gname.'"&total_fee="'.$total.'"&notify_url="'.$notify_url.'"&service="mobile.securitypay.pay"&_input_charset="UTF-8"&return_url="http%3A%2F%2Fm.alipay.com"&payment_type="1"&seller_id="sanlingyi2010@163.com"&it_b_pay="2m"';

$private_key_path=dirname(__FILE__) . "/../pay/key/rsa_private_key.pem";
$sign=rsaSign($res,$private_key_path);
$res=$res.'&sign="'.urlencode($sign).'"&sign_type="RSA"';
//$logger->info("原始签名".$sign."全参数返回".$res);
$logger->info($res);
//echo $res;
//$jsonStr=json_encode(array("sign"=>$res));
$logger->info(v($res));
ErrCode::echoOkArr("1","SUCCESS",$res);