
<?php
include dirname(dirname(__DIR__)).'/common/php/common.php';
error_reporting(0);
session_start();
if($_REQUEST['ss']){
    $ss=$_REQUEST['ss'];
    $_SESSION['ss']=$ss;
}
$_POST['ss']=$_SESSION['ss'];
$result=httpRequest($URLHOST.'/firstaid/1.0/get_receive_list.php',$_POST,'post');
$result = json_decode($result);
if($result->code == 1){
    $result = $result->result;
    $count = count($result);
}