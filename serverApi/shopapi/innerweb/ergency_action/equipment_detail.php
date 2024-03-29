<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>急救装备详情</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="./css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="css/app.css" />
		<link rel="stylesheet" type="text/css" href="css/common.css" />
		<link rel="stylesheet" type="text/css" href="css/equipment_detail.css" />
		<?php include 'emergency_server_eq_detail.php';?>
	</head>
	
	<body>
		<div class="container">
			<div class="pro_img" style="margin-top:9px;font-size:14px;color:#333">
				<?php 
				if($cc){
					echo $cc;
				}else{
					echo "<div style='line-height:1.5em;font-size:14px'>该产品暂无介绍<br />This product is no introduction.</div>";
				}
				
				?>
			</div>
			<div class="fixed" >
				<span style="margin-left:0.5em;color:#dd403b;font-size:15px">共计<?php echo $count?>套应急预案配备</span>
				<?php if($count){?>
				<a href="equipment_detail_list.php?gid=<?php echo $gid?>" class="can" >去看看</a>
				<?php }else{?>
				<a onclick="msg()" class="can" >去看看</a>
				
				<?php }?>
			</div>
		</div>
		<script src="../common/js/jquery.js"></script>
		<script src="../common/js/layer/layer.js"></script>
		<script type="text/javascript">
			function msg(){
				layer.msg("对不起，暂无预案");
				}
		</script>
	</body>
</html>
