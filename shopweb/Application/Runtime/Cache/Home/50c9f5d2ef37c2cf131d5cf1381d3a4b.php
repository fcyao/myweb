<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>西安三聆医信息有限公司</title>
<link rel="stylesheet" href="/sanlingyi/Public/css/default.css" type="text/css" />
<script language="JavaScript" src="/sanlingyi/Public/js/jquery/jquery-1.9.1.min.js"></script>
<script language="JavaScript" src="/sanlingyi/Public/js/jquery/jquery.form.js"></script>
<script language="JavaScript">
<!--
$(function(){
	$('#frmLogin').ajaxForm({
		beforeSubmit:  checkForm,  // pre-submit callback
		success:       complete,  // post-submit callback
		dataType: 'json'
	});
	function checkForm(){
		if(''==$.trim($('#account').val()) || ''==$.trim($('#passwd').val())){
			$('#result').html('请填写完整信息！').show();
			$("#result").fadeOut(4000);
			$('#account').focus();
			return false;
		}
		// 可以在此添加其它判断
	}
    function complete(data){
    	var info='';
    	switch(data){
    		case '1':
    			info='帐号密码不匹配！';
    			break;
    		case '2':
    			info='帐号已被停用！';
    			break;
    		case '3':
    			info='服务器异常！';
    			break;
    		default:
    			window.location="<?php echo U('Index/index');?>";
    	}
    	$('#result').html(info).show();
        $("#result").fadeOut(4000);
    }
});

//-->
</script>
<style type="text/css">
<!--
#login{
	position:relative;
	width:220px;
	margin-left:auto;
	margin-right:auto;
	margin-top:200px;
}
input{
	width:170px;
	margin-top:5px;
}
#info{
	position:relative;
	float:left;
	width:140px;
	height:26px;
	line-height:26px;
	margin-top:5px;
	text-align:center;
	font-size:12px;
	color:#FF0000;
	font-weight:bold;
}
#bt{
	margin-left:16px;
	width: 60px;
}
-->
</style>
</head>
<body>
<div id='login'>
	<form name="frmLogin" id="frmLogin" method="post" action="<?php echo U('Login/loginTo');?>">
	帐 号: <input type="text" name="account" id="account" /><br />
	密 码: <input type="password" name="passwd" id="passwd" /><br />
	<div id="info">
		<span id="result"></span>
	</div>
	<input type="submit" value="登 录" id="bt" />
	</form>
</div>
</body>
</html>