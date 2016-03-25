<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>空中医院</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/swiper.min.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <?php include 'header.php' ?>
    <?php include "server/article.php";?>
	<!-- Swiper -->
	<div class="swiper-container">
	    <div class="swiper-wrapper">
	        <div class="swiper-slide" onclick="location.href='activity.html'" style="background-image:url(images/banner_fllz.jpg);cursor: pointer;"></div>
	        <div class="swiper-slide msk" style="background-image:url(images/banner.png)"></div>
	        <div class="swiper-slide msk" style="background-image:url(images/banner1.png)"></div>
	        <div class="swiper-slide msk" style="background-image:url(images/banner-klinic.png)"></div>
	    </div>

	    <!-- Add Pagination -->
	    <div class="swiper-pagination swiper-pagination-white"></div>
	</div>
	<div class="content">
		<div class="head-title">
			<div class="hr"></div>
			<span>更贴心 更实用</span>
			<div class="hr"></div>
		</div>
		<p class="middle-title">有最适合你的私人医生</p>
		<p class="foot-title"><span>为了您的健康&nbsp;&nbsp;&nbsp;我们还能做更多</span></p>
		
	</div>
	<div class="download">
		<div class="content">
			<p class="download_way">选择平台下载空中医院APP</p>
			<div class="three">
				<div class="three-one" onclick="window.location.href='https://itunes.apple.com/cn/app/kong-zhong-yi-yuan/id907425578?mt=8'">
					<img src="images/apple.png">
					<span>iPhone下载</span>
				</div>
				<div class="three-one" onclick="window.location.href='android/skyhospital.apk'">
					<img src="images/android.png">
					<span>Android下载</span>
				</div>
				<div class="three-one">
					<img src="images/qrcode.png">
					<span>扫描二维码</span>
				</div>
			</div>
		</div>
		<div class="iphone">
			<img src="images/iphone.png">
		</div>
	</div>
	<div class="fun">
		<div class="features">
			<div class="content">
				<p class="tese">特色功能</p>
				<div class="lingxing">
					<img src="images/lingxing.png">
				</div>
				<div class="four">
					<div class="four-one first">
						<img src="images/icon1.png">
						<p class="title">医生联盟</p>
						<p class="introduction">当预诊患有疾病的可能，空中医院帮您及时打通就医通道。由主任医师发起以科室团队为服务主体，整合医疗资源，提供会诊、住院、手术等专长服务的医疗品牌联盟。</p>
					</div>
					<div class="four-one second">
						<img src="images/icon2.png">
						<p class="title">私人医生服务</p>
						<p class="introduction">空中医院在线下实体空中诊所提供健康管理服务，从健康检查、健康评估、急救培训、健康计划、健康干预和医疗通道的六大方面对您的健康进行科学管理。 </p>
					</div>
					<div class="four-one first">
						<img src="images/icon3.png">
						<p class="title">生命时钟</p>
						<p class="introduction">依据影响健康的八个因素，包括遗传、文化、行为、心理、环境、医学、安全和健康社群，进行科学的分析计算，了解健康规律，测算预期寿命。</p>
					</div>
					<div class="four-one second">
						<img src="images/icon4.png">
						<p class="title">电子健康档案</p>
						<p class="introduction">运用数字化存储和管理手段进行健康评估，主要对个人基本信息、个人急救信息、个人既往病史、用药史、体检记录等内容进行管理、记录和健康评估。</p>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="triangle">
					<img src="images/triangle.png">
				</div>
			</div>
		</div>
	</div>
	<div class="dynamic">
		<div class="content">
			<p class="tese">空中动态</p>
			<div class="lingxing">
				<img src="images/lingxing.png">
			</div>
            <div id="scrollDiv">
                <ul>
                    <?php foreach($datas as $k=>$art){
                        $time = $art['update_time'];
                        $time_y = date("Y.m",$time);
                        $time_d = date("d",$time);
                        ?>
                    <li  onclick="window.location.href='artview.php?aid=<?php echo  $art['id'];?>'">
                        <div class="leftbox">
                            <div class="time-d"><?php echo $time_d;?></div>
                            <div class="time-y"><?php echo $time_y;?></div>
                        </div>
                        <div class="rightbox">
                            <div class="arttitle"><?php echo utf8_str_1($art['title']);?></div>
                            <div class="artdes"><?php echo utf8_str_2($art['description']);?></div>
                        </div>
                        <div class="clearfix"></div>
                    </li>
                    <?php }?>
                </ul>
                <div class="clearfix"></div>
            </div>

		</div>
	</div>
	<div class="investment">
		<div class="content">
			<div class="head-title">
				<div class="hr"></div>
				<span>更专业 更轻松</span>
				<div class="hr"></div>
			</div>
			<p class="middle-title">寻找健康合伙人</p>
			<p class="foot-title"><span>投资健康，您会觉得拥有的更多！</span></p>
			<img src="images/user-doctor.png">
		</div>
		<div class="backR"></div>
	</div>

    <?php include 'footer.php' ?>
    <!-- Swiper JS -->
    <script src="js/jquery.min.js"></script>
    <script src="js/swiper.min.js"></script>
    <script src="js/scrolldiv.js"></script>

    <!-- Initialize Swiper -->
    <script>
	    var swiper = new Swiper('.swiper-container', {
	        pagination: '.swiper-pagination',
	        paginationClickable: '.swiper-pagination',
	        nextButton: '.swiper-button-next',
	        prevButton: '.swiper-button-prev',
	        loop: true,
			autoplay: 3000,
	        effect: 'fade'
	    });
	    
	    $(function(){
	    	var ww = $(window).width();
	    	var wh = $(window).height(); 
	    	$('.msk').append('<div class="mask"><img src="images/wenzi.png"></div>');
	    	$('.backR').width((ww - 1000)/2);

            $('.nav-right ul li:first-child').addClass('selected');


//            //article scroll
//            var scrollDiv = $("#scrollDiv");
//            scrollDiv.Scroll({ line: 1, speed: 500, timer: 2000 });
	    });
    </script>


    <?php
    function utf8_str_1($val){
        if(mb_strlen($val,'utf8')>17){
            $slh = "...";
        }else{
            $slh = "";
        }
        $val = mb_substr($val,0,17,'utf8').$slh;
        return $val;
    }
	
    function utf8_str_2($val){
        if(mb_strlen($val,'utf8')>42){
            $slh = "...";
        }else{
            $slh = "";
        }
        $val = mb_substr($val,0,42,'utf8').$slh;
        return $val;
    }
    ?>
</body>
</html>
