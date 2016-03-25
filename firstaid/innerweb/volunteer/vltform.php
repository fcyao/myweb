<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>申请成为志愿者</title>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">

	<link rel="stylesheet" type="text/css" href="css/app.css" />
	<link rel="stylesheet" type="text/css" href="css/common.css" />
	<link rel="stylesheet" type="text/css" href="css/volApplication.css" />
	<?php include "php/getVltstate.php";?>
    <?php include "php/getUserbasic.php";?>
	<style type="text/css">
		.layui-layer{
			border-radius:5px;
		}
	</style>
	
</head>
<body>
	<div class="container">
		<div class="row" id="sex">
			<div class="heading">性别</div>
			<div class="heading detail" id="sexVal" vl="<?php echo $usrbase['sex'];?>"><?php echo $usrinfo['sex'];?></div>
			<span class="span1"></span>
            <div class="clear"></div>
		</div>
		<div class="row" id="blood">
			<div class="heading">血型</div>
			<div class="heading detail" id="bloodVal" vl="<?php echo $usrbase['blood'];?>"><?php echo $usrinfo['blood'];?><?php if($usrinfo['blood']){ echo "型";} ?></div>
			<span class="span2"></span>
            <div class="clear"></div>
		</div>
		<div class="row" id="birth_d">
			<div class="heading">出生日期</div>
			<input class="heading detail" id="birth_dVal" vl="<?php echo $usrbase['birth_d'];?>" readonly="readonly"  name="date" value="<?php echo $usrinfo['birth_d'];?>"/>
			<span></span>
            <div class="clear"></div>
		</div>
		<div class="row pcarea" id="birth_p">
			<div class="heading">出生地</div>
			<div class="heading detail" id="birth_pVal" vl="<?php echo $usrbase['birth_p'];?>"><?php echo $usrinfo['birth_p'];?></div>
			<span></span>
            <div class="clear"></div>
		</div>
		<div class="row pcarea" id="live_p">
			<div class="heading">现居地</div>
			<div class="heading detail" id="live_pVal" vl="<?php echo $usrbase['live_p'];?>"><?php echo $usrinfo['live_p'];?></div>
			<span></span>
            <div class="clear"></div>
		</div>
		<div class="row" id="live_pinfo">
			<div class="heading">具体地址</div>

			<input class="heading detail" vl="<?php echo $usrbase['live_pinfo'];?>" type="text" <?php if($apply==1){ echo  "readonly='readonly'";}?> id="live_pinfoVal" value="<?php echo $usrinfo['live_pinfo'];?>">

            <div class="clear"></div>
		</div>



		<div class="hidden" id="hid-gender">
			<div class="sex" vl="1">男</div>
			<div class="sex famale" vl="2">女</div>
		</div>
		<div class="hidden" id="hid-blood">
			<div class="sex" vl="1">A型</div>
			<div class="sex" vl="2">B型</div>
			<div class="sex" vl="3">AB型</div>
			<div class="sex famale" vl="4">O型</div>
		</div>
	</div>
    <?php if($apply==1){

        echo "<div style='color:#dd403b;text-align: center;font-size: 14px;margin-top: 87px;'>恭喜您，已成为急救志愿者</div>";


    }elseif($apply==0){

        echo "<div class='submit'>申请志愿者</div>";



    }?>
	<script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.mobile-1.3.0.min.js"></script>
    <link href="css/mobiscroll.custom-2.5.0.min.css" rel="stylesheet" type="text/css" />
    <script src="js/mobiscroll.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/area.js"></script>
    <link rel="stylesheet" type="text/css" href="css/area.css" />
	<script type="text/javascript">
    <?php if($apply==0){?>

			$(function(){

                $("#sex").click(function(){
                    layer_gender();
                });
                $("#blood").click(function(){
                    layer_bloodtype();
                });

                $('#hid-gender .sex').click(function(){
                    sexVal = $(this).attr("vl");
                    sexHtml = $(this).html();
                    layer.closeAll();
                    $('#sexVal').html(sexHtml);
                    $('#sexVal').attr('vl',sexVal);
                });

                $('#hid-blood .sex').click(function(){
                    bloodVal = $(this).attr("vl");
                    bloodHtml = $(this).html();
                    layer.closeAll();
                    $('#bloodVal').html(bloodHtml);
                    $('#bloodVal').attr('vl',bloodVal);
                });



                function layer_gender(){
                    layer.open({
                        type: 1,
                        title:false,
                        closeBtn: false,
                        shadeClose:true,
                        area:'80%',
                        content: $('#hid-gender')
                    });
                }
                function layer_bloodtype(){
                    layer.open({
                        type: 1,
                        title:false,
                        closeBtn: false,
                        shadeClose:true,
                        area:'80%',
                        content: $('#hid-blood')
                    });
                }

                //申请志愿者
                $(".submit").click(function(){
                    var sexVal = $('#sexVal').attr('vl');
                    var bloodVal = $('#bloodVal').attr('vl');
                    var birth_dVal = $('#birth_dVal').val();
                    var birth_pVal = $('#birth_pVal').attr('vl');
                    var live_pVal = $('#live_pVal').attr('vl');
                    var live_pinfoVal = $('#live_pinfoVal').val();
                    //校验填写完整
                    if(sexVal=='0'||bloodVal=='-1'||birth_pVal==''||live_pVal==''||live_pinfoVal==''){
                        layer.msg("请完善您的个人信息，谢谢");
                    }else{
                        //修改个人信息
                        $.post("php/update_personal_info.php",{'ss':'<?php echo $_GET['ss'];?>', 'sex':sexVal, 'blood':bloodVal, 'birthday':birth_dVal+' 00:00:00', 'birth_place':birth_pVal, 'live_place':live_pVal, 'live_placeinfo':live_pinfoVal},function(data){
                            if(data.code=='1'){
                                //提交申请
                                $.post("php/user_auth_apply.php",{'ss':'<?php echo $_GET['ss'];?>'},function(data){
                                    if(data.code=='1'){
                                        window.location.reload();
                                    }else{
                                        layer.msg(data.msg);
                                    }
                                },'json');
                            }else{
                                layer.msg(data.msg);
                            }
                        },'json');
                    }
                });




			});



            $('.pcarea').click(function(){
                var pcid = $(this).children('.detail').attr('id');
//                localStorage["pcVal"]=pcid;
                setCookie('pcVal',pcid,7);
                getProvinceBuy();
            });



            $(function(){
                var opt = {
                    preset: 'date', //日期
                    theme: 'sense-ui', //皮肤样式
                    display: 'modal', //显示方式
                    mode: 'scroller', //日期选择模式
                    dateFormat: 'yy-mm-dd', // 日期格式
                    setText: '确定', //确认按钮名称
                    cancelText: '取消',//取消按钮名籍我
                    dateOrder: 'yymmdd', //面板中日期排列格式
                    dayText: '日', monthText: '月', yearText: '年', //面板中年月日文字
                    endYear:<?php echo date('Y',time());?> //结束年份
                };
                $("#birth_dVal").mobiscroll(opt).date(opt);
            });

    <?php }elseif($apply==1){?>

	    <?php }?>
    </script>

    <style>

        .layui-layer{
            left:0;
        }
        .ui-loader{
            display: none;
        }
    </style>
</body>
</html>