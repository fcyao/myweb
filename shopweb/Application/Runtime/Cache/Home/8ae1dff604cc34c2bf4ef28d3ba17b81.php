<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"
	content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<title>手机会员福利大放送</title>
<link rel="stylesheet" href="/shopweb/Public/Home/css/activecss/swiper.min.css">
<link rel="stylesheet" type="text/css" href="/shopweb/Public/Home/css/activecss/style.css">
<script src="/shopweb/Public/Home/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
		$(document).ready(function(){
			var wh = $(window).height();
			var sh = $('.pull-left img').height();
			var bw = $('.bmtext').width();
			var bh = bw * 0.3412;
			var btn_width = $('.button').width();
			var btn_height = btn_width * 0.3985;
			var pullImgW = $('.pull-left img').width();
				$('.pull-left img').height(pullImgW);
			var pullImgH = pullImgW * 0.9375;
			$('.pull-left').height(pullImgH + 23+'px');
			$('.swiper-container').css('height',pullImgH + 35);
			$('.sec-bot').css('height',pullImgH + 34);
			$('.container').height(wh);
			$('.swiper-slide').height(sh + 22);
			$('.button').css('top',(bh + 57 - btn_height)/2);
			$('.line').height(bh + 27);
		});
	</script>
<style>
.container {
	background-image: url(/shopweb/Public/Home/images/active/bg.png);
}

.swiper-button-next, .swiper-button-prev {
	top: 10%;
}
#bg{ display: none;  position: absolute;  top: 0%;  left: 0%;  width: 100%;  height: 100%;  background-color: black;  z-index:1001;  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);}
</style>
</head>
<body>
	<div class="container">
		<img class="header" src="/shopweb/Public/Home/images/active/pic2.png" />
		<div class="detail">
			<img src="/shopweb/Public/Home/images/active/pic3.png">
		</div>
		<div class="baoming">
			<img class="bmtext" src="/shopweb/Public/Home/images/active/baoming.png">
			<p>
				<span class="count"><?php echo ($num["now_num"]); ?></span>/<?php echo ($num["max_num"]); ?>
			</p>
			<div class="line"></div>
			<?php if($unum==0){ ?>
			<img class="button" id="button" src="/shopweb/Public/Home/images/active/button.png">
			<img class="button" id="button-yb" src="/shopweb/Public/Home/images/active/yibao.png" style="display:none">
			<?php }else{ ?>
			<img class="button" id="button-yb" src="/shopweb/Public/Home/images/active/yibao.png">
			<?php } ?>
		</div>
		<?php if($num['now_num']==0){ }else{ ?>
		
		<div class="sec-bot">
			
			<div class="swiper-container">
				<div class="swiper-wrapper">

					<?php
 for($i=0;$i*4<$count;$i++){ ?>
					<div class="swiper-slide">
						<?php
 $ki = ($count-4*$i)/4; if($ki>=1){ $y = 4; }else{ $y = ($count-4*$i)%4; } for($j=0;$j<$y;$j++){ $jj = $i*4+$j; $name = $rs[$jj]['member_truename']; $Himg=getImg($rs[$jj]['thumbnail_image_url']); ?>
						<div class="pull-left">

							<img src="<?php echo ($Himg); ?>" />
							<p>
								<?php if($name){ echo $name; }else{ echo "***"; } ?>
							</p>
						</div>

						<?php
 } ?>


					</div>
					<?php	 } ?>





				</div>
			</div>
		</div>

		<?php } ?>

		
	</div>
	<div id="loading"
		style="display: none; position: absolute; left: 50%; top: 50%; z-index: 999999; width: 32px; height: 32px; background: url('/shopweb/Public/Home/images/loading.gif'); background-size: 32px 32px; margin-left: -16px; margin-top: -16px;"></div>
	<div id="bg"></div>
	<script src="/shopweb/Public/Home/js/swiper.min.js"></script>
	<script src="/shopweb/Public/Home/js/layer/layer.js"></script>
	<script type="text/javascript">
  	var mySwiper = new Swiper('.swiper-container',{
    	loop: true,
		autoplay: 0,
		nextButton: '.swiper-button-next',
    	prevButton: '.swiper-button-prev',
  	});
  	$('#button').click(function(){
  		dataajax();
  	});
  		/*//弹窗确定
		function layer_confirm(){
			var index = layer.open({
				type: 1,
				title:false,
				closeBtn: false,
				shadeClose:true,
				area:'80%',
				content:$('#hid-confirm')
			});
			$('#bg').show();
		  	$('#btn_ok').click(function(){

				$('#bg').hide();
		  		layer.closeAll();
		  		dataajax();
		  		
		  	});
		  	$('#btn_cancel').click(function(){
				$('#bg').hide();
		  		layer.close(index);
		  	});
		}*/

  	$('#button-yb').click(function(){
  		layer.msg("您已报名，请勿重新报名");
  	});
		//报名
		function dataajax(){

			var url= "<?php echo U('User/joinActivity');?>";
			$.ajax({
				type:'POST',
				url:url,
				data:"{}",
				beforeSend:function(){
					$('#loading').show();
				},
				success:function(data){
					$('#loading').hide();
					var code=data.code;
					console.log(code);
					if(code=='1'){
						now1 = <?php echo ($num["now_num"]); ?>+1;
						$('.count').html(now1);
				  		$('#button').hide();
				  		$('#button-yb').show();
						layer.msg("报名成功！");
					}else if(code=='1517'){
						layer.msg("对不起,您的积分不够！");
					}else if(code=='1518'){
						layer.msg("对不起,活动没开始！");
					}else if(code=='1519'){
						layer.msg("对不起,人数已满！");
					}else if(code=='1520'){
						layer.msg("对不起,活动已经结束！");
					}else if(code=='1521'){
						layer.msg("对不起,已经参加过了！");
					}else{
						layer.msg("对不起，系统原因暂时无法提交")
					}
				},
				error:function(data){
					$('#loading').hide();
					layer_fail();
					
				},
				dataType:'json',
			});
		}  	
  	
  	

	function layer_fail(){
		layer.open({
			type: 1,
			title:false,
			closeBtn: false,
			shadeClose: true,
			area:'80%',
			content:$('#hid-fail'),
			time: 2000
		});
	}

	</script>
	
	<!--报名确认提示-->
		<div id="hid-confirm">
			<img src="/shopweb/Public/Home/images/active/icon.png">
			<p>您确定报名吗？</p>
			<div class="confirm_btn">
				<div id="btn_cancel" class="btn_cancel">取消</div>
				<div id="btn_ok" class="btn_ok">确定</div>
				<div class="clear"></div>
			</div>
		</div>

		<!--报名失败提示-->
		<div id="hid-fail">
			<img src="/shopweb/Public/Home/images/active/fail.png">
			<p>暂时无法报名，请稍后再试</p>
		</div>
</body>
</html>