<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>医信健康</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<link rel="stylesheet" href="/shopweb/Public/Home/css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="/shopweb/Public/Home/css/app.css" />
		<link rel="stylesheet" type="text/css" href="/shopweb/Public/Home/css/common.css" />
		<link rel="stylesheet" type="text/css" href="/shopweb/Public/Home/css/agency_newshop.css" />

	</head>

	<body>
		<header class="mui-bar mui-bar-nav" style="background:#e45335;position: fixed;">
			<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" onclick="goToA()"></a>
			<h1 class="mui-title" style="color:#fff" onclick="goToA()">新开店</h1>
			
			<div class="right">
				<a ><img src="/shopweb/Public/Home/images/baocun.png" class="jiluzixun" /></a>
			</div>
		</header>
		<!--
        	时间：2015-06-29
        	描述：主要内容
        -->
        <div class="mui-content">
        	<div class="shop-form">
	        	<form action="<?php echo U('addShop');?>" method="post" id="newshop">
	        		<input type="text" name="shopName" id="shopName" value="" placeholder="店面名称"/>
	        		<input type="text" name="shopAdr" id="shopAdr" value="" placeholder="店面地址"/>
	        	</form>
        	</div>
        </div>
		
    <script src="/shopweb/Public/Home/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/shopweb/Public/Home/js/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/shopweb/Public/Home/js/common.js" type="text/javascript" charset="utf-8"></script>
		<style type="text/css">
			.layui-layer-btn a{
				background: #E43D37;
			}						
		</style>
		<script type="text/javascript">
			
			$(function(){
				$('.jiluzixun').click(function(){
					var get_shopName = $('#shopName').val();
					var get_shopAdr = $('#shopAdr').val();
					
					if(!(get_shopName.length&&get_shopAdr.length)){
						layer.msg("店铺名称和地址<br/>不得为空");
					}else if(get_shopName.length>10){
						layer.msg("店铺名称<br/>不得大于10个字");
					}else if(!reg.test(get_shopName)){
						layer.msg("对不起，店铺名称<br/>只能是汉字字母或数字");
					}else{
						layer.alert("保存成功",{
							title:false,
							closeBtn:false
						},function(){
							$('#newshop').submit();
						});
					}
				});
			});
			function goToA(){
                    if(navigator.userAgent.match('iPhone')){
                        goToAgency();
                    }
                    if(navigator.userAgent.match('Android')){
                        Android.goToAgency();
                    }
			}
		</script>
	</body>

</html>