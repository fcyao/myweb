<?php
//专家组购买后支付宝回调
require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");
include(dirname(__FILE__) . "/../1.0/common/MecManager.php");
require_once(dirname(__FILE__) . "/../1.0/common/inc.php");
// require_once(dirname(__FILE__) . "/common/inc.php");
// require_once(dirname(__FILE__) . "/../pay/alipay.config.php");
// require_once(dirname(__FILE__) . "/../pay/lib/alipay_notify.class.php");
$logger = Logger::getLogger(basename(__FILE__));
//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();
$logger->info(print_r($_POST,true));

if($verify_result) {//验证成功
	
    if($_POST['trade_status'] == 'TRADE_FINISHED') {
    	$out_trade_no=$_POST['out_trade_no'];
    	$ali_trade_no=$_POST['trade_no'];
    	$tot_fee=$_POST ['total_fee'];
    	$databaseManager = new DatabaseManager();
    	$database = $databaseManager->getConn();
    	//数据库链接失败
    	if(!$database){
    		$logger->error(sprintf("Database connect fail."));
    	}

//    	//检测实际支付金额和应该支付金额
//    	$need_pay=$database->getOne("SELECT price FROM user_buy_goods_info WHERE order_nums='$out_trade_no'");
//    	if ($tot_fee<$need_pay){
//    		$databaseManager->errorReport($out_trade_no);
//    		$logger->info ( "实际支付的钱小于应该支付的钱，可能被HACK" );
//    		exit;
//    	}
//
//    	$sql = "update user_buy_goods_info set pay_type = 1,pay_time=now(),pay_state=1,order_state=1,pay_nums='$ali_trade_no'
//    			where order_nums ='$out_trade_no'";
//    	$result = $database->execute($sql);
//
//    	if ($result){
//    		echo "success";//给支付报返回
//    		$logger->info("已经给支付宝返回成功标志");
//    	}

        //检测实际支付金额和应该支付金额
        //取价格,商品名称
        $sql = "select buy.price,info.goods_name from user_buy_goods_info AS buy LEFT JOIN first_aid_goods_info AS info ON info.id = buy.goods_id WHERE buy.order_nums = '$out_trade_no'";
        $res = $database->getAll($sql);
        //var_dump($res);
        $total = 0;
//        $gname = '';
        foreach ($res as $p) {
            $total = $total + $p['price'];
//            $gname .= $p['goods_name'].',';
        }
//        $gname = substr($gname,0,-1);
//		$need_pay=$database->getOne("SELECT price FROM user_buy_goods_info WHERE order_nums='$out_trade_no'");
        if ($tot_fee<$total){
//            $databaseManager->errorReport($out_trade_no);
            $logger->info ( "实际支付的钱小于应该支付的钱，可能被HACK" );
            exit;
        }


        //更新支付状态
        $sql = "update user_buy_goods_info set pay_type = 1,buy_time=now(),pay_time=now(),pay_state=1,order_state=1,pay_nums='$ali_trade_no'
    			where order_nums ='$out_trade_no'";
        $result = $database->execute($sql);

        if ($result) {
            echo "success"; // 给支付报返回
            $logger->info ( "已经给支付宝返回成功标志" );
            $sql = "select goods_id from user_buy_goods_info  where order_nums = '$out_trade_no'" ;
            $rs = $database->getCol($sql);
            foreach($rs as $v){
                $sql = "update first_aid_goods_info set goods_stock = goods_stock-1,goods_sell_nums = goods_sell_nums+1
                        where id ='$v'";
                $res = $database->execute($sql);
            }


            //处理赠送关系表user_buy_goods_largess_info
            $sql = "select user_id,pay_user_id from user_buy_goods_info where order_nums = '$out_trade_no'";
            $payid = $database->getRow($sql);
            $sql = "insert into user_buy_goods_largess_info (order_nums,accepter,sender,createDate) VALUES ('$out_trade_no','".$payid['user_id']."','".$payid['pay_user_id']."',NOW())";
            $database->execute($sql);

        }else{
    		$logger->error("订单".$out_trade_no."交易处理失败，等待支付宝发送下一次数据");
    	}    	
    	$databaseManager->destoryConn();//释放数据库资源
    	
    	
    }

}
else {
    //验证失败
    echo "fail";
    $logger->error("数据验签失败");
}
?>