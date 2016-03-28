<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>空中诊所</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" type="text/css" href="/sanlingyi/Public/Clinic/css/myclinic.css" />
        <style>
        </style>
	</head>

	<body>
        <div class="headerbar">
            <div class="areanum"><span class="positiontop">全国</span>共有<span class="posnum"><?php echo ($num); ?></span>家</div>
            <div class="selectarea" cl="1">选择地区
                <div class="detail" id="birth_pVal" vl="" style="display: none"></div>
            </div>
            <div class="clear"></div>
        </div>
        <div id="hospitalbox">
            <?php if(is_array($cmsg)): foreach($cmsg as $key=>$vo): ?><div class="clinicbox">
                    <img class="houseimg" src="<?php if($vo->logo_url){echo $vo->logo_url;}else{echo '/sanlingyi/Public/Clinic/images/default@2x.png';} ?>" alt=""/>
                    <div class="houseintroduce">
                        <div class="housetitile"><?php echo $vo->name; ?></div>
                        <div class="houseaddr"><?php echo $vo->address; ?></div>
                    </div>

                    <div class="clear"></div>


                    <div class="housedoctor">
                        <div class="titledoc">坐诊医生：</div>
                            <div class="doc">
                                <?php $physicians = $vo->physicians; foreach($physicians as $k=>$v){ if($k<=2){ ?>
                                    <div class="docbox">
                                        <img  src="<?php if($v->thumbnail_image_url){echo $v->thumbnail_image_url;}else{echo '/sanlingyi/Public/Clinic/images/督脉正阳师-@2x.png';} ?>" alt=""/>
                                        <div class="p1"><?php echo $v->user_name ?></div>
                                        <div class="p2"><?php echo (dim_rec_code($v->recollection_id)); ?></div>
                                    </div>
                                <?php } } ?>
                                <div class="clear"></div>
                            </div>
                    </div>
                    <!--div class="housebottom">
                        <div class="distin">距离我3500米</div>
                        <div class="position">查看地图上的位置</div>
                        <div class="clear"></div>
                    </div-->
                    <div class="houseborder"></div>
                </div><?php endforeach; endif; ?>
        </div>
        <script src="/sanlingyi/Public/Clinic/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="/sanlingyi/Public/Clinic/js/layer/layer.js" type="text/javascript" charset="utf-8"></script>
        <script src="/sanlingyi/Public/Clinic/js/iscroll.js" type="text/javascript" charset="utf-8"></script>
        <script src="/sanlingyi/Public/Clinic/js/area_city.js" type="text/javascript"></script>
        <link rel="stylesheet" href="/sanlingyi/Public/Clinic/css/area.css"/>
        <script type="text/javascript">
            isclick = '';
            html = '';
            docthtml = "<div style='position: absolute;top: 39%;width:100%;text-align:center;color:#A0A0A0;font-size: 14px;'>该地区暂无诊所</div>";
            hbox = $('#hospitalbox');
            getImgwidth = $('.clinicbox').width();
            $('.houseintroduce').width(getImgwidth-100);

            $('.selectarea').click(function(){
                isclick = $(this).attr('cl');
                if(isclick == 1){
                    $('.clinicbox').hide();
                    $(this).css('background-image','url("/sanlingyi/Public/Clinic/images/down.png")');
                    $('.selectarea').attr('cl',2);
                    var pcid = $(this).children('.detail').attr('id');
    //                localStorage["pcVal"]=pcid;
                    setCookie('pcVal',pcid,7);
                    getProvinceBuy(function(pid,cid,pcname){
                        $('.clinicbox').show();
                        $('.selectarea').css('background-image','url(/sanlingyi/Public/Clinic/images/top.png)');
                        areaUrl = '<?php echo U('Index/showArea');?>';
                        data = {
                            'province' : pid,
                            'city' : cid
                        }
                        loadindex = layer.load();
                        $.post(areaUrl,data, function(data){

                            layer.close(loadindex);
                            $('.selectarea').attr('cl',1);
                            $('.positiontop').html(pcname);
                            if(data){
                                hbox.html(data);
                            }else{

                                $('.posnum').html(0);
                                hbox.html(docthtml);
                            }
                        });
                    });
                }else if(isclick == 2){

                    $(this).css('background-image','url("/sanlingyi/Public/Clinic/images/top.png")');
                    $('.clinicbox').show();
                    $('.dqld_div').hide();
                    $('.selectarea').attr('cl',1);
                }
            });



        </script>


	</body>

</html>