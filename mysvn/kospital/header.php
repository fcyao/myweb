        <script type="text/javascript" src="js/mobile.js"></script>
        <link rel="stylesheet" href="css/header.css">

		<div class="header">
			<div class="top">
				<div class="content">
					<ul class="headli">
						<li><a>客服热线：400-669-3636</a></li>
						<li class="signup nolog"><a href="signup.php">注册</a></li>
						<li class="logindo nolog"><a href="login.php">登录</a></li>
                        <li class="signup logt username"><a style="cursor: pointer;"></a></li>
                        <li class="logindo logt" id="logout"><a>退出</a></li>
                        <div class="clearfix"></div>
					</ul>
                    <div class="clearfix"></div>
				</div>
			</div>
			<div class="navbar">
				<div class="content">
					<a class="nav-left" href="index.php">
						<img src="images/logo.png"  border="0">
						<div class="logo_tit">空中医院</div>
						<div class="clearfix"></div>
					</a>
					<div class="nav-right">
						<ul>
							<li><a href="index.php">主页</a></li>
							<li><a href="klinic.php" >空中诊所</a></li>
							<li><a href="firstaid.php">空中急救</a></li>
							<li><a href="yixin.php">医信健康</a></li>
							<li><a href="dreamhouse.php">圆梦庄园</a></li>
							<li><a href="healthpay.php">健康宝</a></li>
						</ul>
					</div>
					<div class="clearfix"></div>
				</div>	
			</div>
		</div>
		<script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/layer/layer.js"></script>
        <script type="text/javascript" src="js/common.js"></script>

		<script>
			$(function(){
                $('.nav-right ul li').on('hover',function(){
                    $(this).addClass('selected').siblings().removeClass('selected');
                });
                
			});
            if(getCookie('user')){
                $('.nolog').hide();
                $('.logt').show();
                $('.username a').html("您好，"+getCookie('user'));
            }
            $('#logout').click(function(){
                removeCookie('user');
                layer.alert("退出成功",{icon:1,title:false,closeBtn:false}, function () {

                    location.reload();
                });
            });


		</script>
        <style>
            .layui-layer-btn .layui-layer-btn0{
                border-color: #4dbbaa;
                background-color: #4dbbaa;
            }
        </style>
