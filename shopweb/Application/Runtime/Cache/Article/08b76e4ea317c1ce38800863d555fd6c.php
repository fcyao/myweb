<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title><?php echo ($de["title"]); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<link rel="stylesheet" href="/shop_skyhospital/trunk/shopweb/Public/Article/css/mui.min.css">
        <link rel="stylesheet" type="text/css" href="/shop_skyhospital/trunk/shopweb/Public/Article/css/app.css"/>
		<link rel="stylesheet" type="text/css" href="/shop_skyhospital/trunk/shopweb/Public/Article/css/actcontent.css"/>
		<link rel="stylesheet" type="text/css" href="/shop_skyhospital/trunk/shopweb/Public/Article/css/iconfont.css"/>
	</head>

	<body>
    <style>
        #s_content img{
            max-width: 95%;
            display: block;
            margin: 0 auto;
        }
        #s_content *{
        	font-size: 16px;
        	line-height: 1.5em;
            text-indent: 0em;
        }
        
    </style>
    <?php if(!isset($_GET['wxfx'])){ ?>
		<header class="mui-bar mui-bar-nav">
            <?php
 if(!isset($_GET['type'])){ ?>
			<div style="color: #fff;" class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" onclick="history.go(-1)"></div>
            <?php
 } else { ?>
            <div  style="color: #fff; "onclick="getOs1()" class=" mui-icon mui-icon-left-nav mui-pull-left" style="width: 3em; "></div>
            <script>
                function getOs1() {
//                   alert(1);
                    if(navigator.userAgent.match('iPhone')){
                        window.location.href="skyhospital://www.skyhospital.net/go_to_yixin";
                    }
                    if(navigator.userAgent.match('Android')){
                        go_to_yixin();
                    }
                }

                function go_to_yixin() {
                    //alert(1);
                    Android.go_to_yixin();
                }

            </script>
            <?php } ?>
			<h1 class="mui-title" style="color:#fff">阅读内容</h1>
            <?php
 if(session('?yixin_user')){ ?>
            <a class="mui-icon mui-icon-compose mui-pull-right commont"></a>
            <?php } ?>
		</header>
    <?php } ?>
		<!--
        	时间：2015-06-29
        	描述：主要内容
        -->
		<div class="mui-content">
			<h4><?php echo ($de["title"]); ?></h4>
			<h6><span>
                <?php echo ($de["article_from"]); ?>

            </span><span class="time"><?php echo ($de["examine_time"]); ?></span></h6>

			<!--<img src="images/muwu.jpg" class="cont-banner"/>-->
			<div class="cont-cont">
                <div id="s_content" style="font-size: 16px; padding-top: 0.5em;">
				<?php echo ($de["content"]); ?>
                    <?php if(isset($_GET['wxfx'])){ ?>

                    <div class="wx" style="padding-bottom:15px;border-top:1px solid #e5e5e5">
                        <p style="text-indent: 0;margin-top: 1.5em;color:#7030a0;font-weight: 700;">空中医院客服电话：400—669—3636<br/>
                            空中医院医生交流群：119798449<br />
                            空中医院官方微信号：kzyygfzh<br />
                            空中医院客服微信号：kzyy159</p>
                        <div style="text-align: center;margin-top:5px">
                            <img src="/shop_skyhospital/trunk/shopweb/Public/Article/images/1.png" style="width: 13px;margin-top: 15px;"/><br />
                            <a href="http://a.app.qq.com/o/simple.jsp?pkgname=com.rongke.yixin.android" style=""><img src="/shop_skyhospital/trunk/shopweb/Public/Article/images/2.png" style="width: 100px;margin-top: -12px;"/></a>
                            <p style="text-indent: 0;font-size: 13px;color:#333;margin-top: 10px;">全国医生多点执业</p>
                            <p style="text-indent: 0;font-size: 13px;color:#333;margin-top: -6px;">移动医疗平台</p>
                            <img src="/shop_skyhospital/trunk/shopweb/Public/Article/images/1.png" style="width: 13px;"/><br />
                            <div style="width: 50%;text-align: center;margin-top:-12px;float: left;">
                                <img src="/shop_skyhospital/trunk/shopweb/Public/Article/images/3.png" style="width: 60%;"/>
                                <div style="font-size: 13px;color:#555;margin-top: 5px;">APP下载</div>
                            </div>
                            <div style="width: 50%;text-align: center;margin-top:-12px;float: left;padding:10px ;">
                                <img src="/shop_skyhospital/trunk/shopweb/Public/Article/images/4.png" style="width: 60%;position: relative;top:-7px"/>
                                <div style="font-size: 13px;color:#555;margin-top: 5px;">长按左侧二维码下载</div>
                            </div>

                            <div class="clear"></div>
                        </div>
                    </div>
                    <?php die(); } ?>
                </div>
                <?php if(!isset($_GET['type'])){ ?>
        		<p class="fx">
        			<!--<span  onclick="sh_evoke_shares()">-->
			        	<!--<img src="/shop_skyhospital/trunk/shopweb/Public/Article/images/fx.png" class="fximg"/>-->
			        	<!--<span>-->
			        		<!--分享-->
			        	<!--</span>-->
		        	<!--</span>-->
					<!--&nbsp;-->
						<!---->
		        	<!--<span is_save="0" id="add_favorite" style="margin-left:0.5em;">-->
			        	<!---->
                        <!--<img src="/shop_skyhospital/trunk/shopweb/Public/Article/images/sc.png" class="scimg"/>-->
                       <!---->
                        <!--<img src="/shop_skyhospital/trunk/shopweb/Public/Article/images/scw.png" class="scimg"/>-->
                      <!---->
			        	<!--<span>-->
			        		<!--收藏-->
			        	<!--</span>-->
		        	<!--</span>-->

       	        </p>
       	        <?php } ?>
			</div>
		</div>
		<!--
        	时间：2015-06-29
        	描述：相关阅读
        -->
		<div class="rela">
			<div style="height:1.5em;width:3px;background:red;float:left;margin-top: 0.5em;"></div>
			<div class="relatext">相关阅读</div>
		</div>
		<div class="relap">
            <?php if(is_array($sde)): foreach($sde as $key=>$v): ?><a href="<?php echo U('detail',array('aid'=>$v['id']));?>"><p class="p1"><?php echo ($v["title"]); ?></p></a><?php endforeach; endif; ?>
		</div>
        <div class="zan">
            <button id="zan_bottom" class="mui-btn zan-button" style="margin-right: 2em;background: #db8f18;color:#fff">
                <span class="mui-icon iconfont icon-zan"></span>
                <span class="san_zan"> <?php echo ($de["up_num"]); ?></span>
            </button>
            <button id="down_bottom" class="mui-btn zan-button" style="background: #30c6df;color:#fff">
                <span class="mui-icon iconfont icon-cai"></span>
                <span class="san_zan"><?php echo ($de["down_num"]); ?></span>
            </button>
        </div>
        <div>

            <?php
 if($evalute!=0){ ?>
            <?php
 if(count($hotcom)>0){ ?>
            <div class="rela">
                <div style="height:1.5em;width:3px;background:red;float:left;margin-top: 0.5em;"></div>
                <div class="relatext">热门评论</div>
            </div>
            <div>
                <ul class="mui-table-view ulleft">
                    <?php if(is_array($hotcom)): foreach($hotcom as $key=>$v): ?><li class="mui-table-view-cell" class="com-list">

                            <img src="<?php echo ($v['thumbnail_image_url']); ?>" class="mui-pull-left com-img"/>
                            <div class="com-li">
                                <div style="color:#000"><?php echo ($v["user_name"]); ?><span class="mui-pull-right" style="color:#666666;font-size: 12px;"><?php echo ($v["create_time"]); ?></span></div>
                                <div style="font-size:12px"><?php echo ($v["content"]); ?></div>
                                <div aid="<?php echo ($de['id']); ?>" eid="<?php echo ($v["id"]); ?>" class="mui-pull-right up_evalute_list" style="font-size: 12px;">
                                    <span  class="mui-icon iconfont icon-zan blue"></span>
                                    (<span class="up_num" style="color:red"><?php echo ($v["up_num"]); ?></span>)
                                </div>
                            </div>
                        </li><?php endforeach; endif; ?>
                </ul><!--列表-->

            </div>
            <?php } ?>
            <?php
 if(count($newcom)>0){ ?>
            <div class="rela">
                <div style="height:1.5em;width:3px;background:red;float:left;margin-top: 0.5em;"></div>
                <div class="relatext">最新评论</div>
            </div>
        </div>
        <ul class="mui-table-view ulleft">
            <?php if(is_array($newcom)): foreach($newcom as $key=>$v): ?><li class="mui-table-view-cell" class="com-list">

                    <img src="<?php echo ($v['thumbnail_image_url']); ?>" class="mui-pull-left com-img"/>
                    <div class="com-li">
                        <div style="color:#000"><?php echo ($v["user_name"]); ?><span class="mui-pull-right" style="color:#666666;font-size: 12px;"><?php echo ($v["create_time"]); ?></span></div>
                        <div style="font-size:12px"><?php echo ($v["content"]); ?></div>
                        <div aid="<?php echo ($de['id']); ?>" eid="<?php echo ($v["id"]); ?>" class="mui-pull-right up_evalute_list" style="font-size: 12px;">
                            <span  class="mui-icon iconfont icon-zan blue"></span>
                            (<span class="up_num" style="color:red"><?php echo ($v["up_num"]); ?></span>)
                        </div>
                    </div>
                </li><?php endforeach; endif; ?>
        </ul><!--列表-->
        <?php } ?>
        <?php
 if($evalute<=10){ echo ''; }else{ ?>
        <div class="more"><a style="color: #333" href="<?php echo U('evalute',array('aid'=>$de['id'],'type'=>1));?>">更多评论...</a></div>
        <?php
 } ?>

    <?php } else { ?>
    <div class="shafa">
        <img src="/shop_skyhospital/trunk/shopweb/Public/Article/images/shafa.png" class="shafaimg"/>
        <div class="">

            <button class="shafabtn">快抢沙发</button>
        </div>
    </div>
    <?php } ?>




    <!--
        时间：2015-06-29
        描述：评论
    -->

        <div class="hid">
		<div class="rela">
			<div style="height:1.5em;width:3px;background:red;float:left;margin-top: 0.5em;"></div>
			<div class="relatext">
				<span id="">
					我要评论
				</span>
				<span style="font-size: 11px">
					(文明上网、理性发言)
				</span>
                <div class="mui-icon mui-icon-arrowdown mui-pull-right arrdown">

                </div>
                <?php
 if($evalute==0){ echo '<a><span style="font-size: 11px;float: right;color:#000">暂无评论</span></a>'; }else{ ?>
				<a href="<?php echo U('evalute',array('aid'=>$de['id'],'type'=>1));?>"><span style="font-size: 11px;float: right;color:#000">
					<span style="color:red">
                        <?php echo ($evalute); ?>
                    </span>条评论
				</span></a>
                <?php
 } ?>
			</div>
		</div>
        <form id="evalute_form" method="post" action="<?php echo U('evalute');?>">
		<div class="mui-input-row center" style="margin-top:10px;">
			<textarea style="margin: 0; " id="TextArea1" name="content" rows="5" placeholder="我要评论"></textarea>

            <p style="margin: 0; padding: 0; font-size: 12px;"><span id="textCount"></span></p>
		</div>
		<div class="center" style="margin-top:-10px">		
			<button  id="submit_avalute" class="mui-btn " style="float:right;background: #30c6df;color:#fff; margin:1em 0;">发表评论</button>
		</div>
            <input type="hidden" name="aid" value="<?php echo ($de["id"]); ?>" />
        </form>
        </div>
        <div class="hidbd"></div>
        <div id="bg"></div>
        <script src="/shop_skyhospital/trunk/shopweb/Public/Article/js/jquery-1.9.1.min.js"></script>
        <script src="/shop_skyhospital/trunk/shopweb/Public/Article/js/mui.min.js"></script>
        <script>
            //赞
            var attent_url="<?php echo U('addtend','','');?>";
            var snaliyi_artid="<?php echo ($_GET['aid']); ?>"
            $('#zan_bottom').click(function(){
                $.post(attent_url,{'type':1,'aid':snaliyi_artid},function(data){
                    if(data==1){
                        var up=$('#zan_bottom').find('.san_zan').html();
                        $('#zan_bottom').find('.san_zan').html((parseInt(up)+1));
                    }
                },'text');
            });
            //踩
            $('#down_bottom').click(function(){
                $.post(attent_url,{'type':2,'aid':snaliyi_artid},function(data){
                    if(data==1){
                        var up=$('#down_bottom').find('.san_zan').html();
                        $('#down_bottom').find('.san_zan').html((parseInt(up)+1));
                    }
                },'text');
            });

            //攒评论
            $('.up_evalute_list').click(
                    function () {
                        var now_up=$(this).find('.up_num').html();
                        var up_dom=$(this).find('.up_num');
                        var url="<?php echo U('evalueUp');?>";
                        var aid=$(this).attr('aid');
                        var eid=$(this).attr('eid');
                        $.post(url,{'aid':aid,'eid':eid},function(data){
                            if(data==1){
                                var new_up=parseInt(now_up)+1;
                                // alert(new_up);
                                up_dom.html(new_up);
                            }
                        },'text')


                    }
            );
        </script>

        <script type="text/javascript">
            $(document).ready(function(){
                $("#TextArea1").keyup(function(){
                    var curLength= $("#TextArea1").val().length;
                    if(curLength>=500){
                        var num=$("#TextArea1").val().substr(0,499);
                        $("#TextArea1").val(num);
                        //alert("超过字数限制，多出的字将被截断！" );
                    }
                    else{
                       // $("#textCount").text(500-$("#TextArea1").val().length)
                    }
                })
            })

            function sh_check_logins(ss){
                if(navigator.userAgent.match('iPhone')){
                    return sh_check_login(ss);
                }
                if(navigator.userAgent.match('Android')){
                    return  Android.sh_check_login(ss);
                }
            }
            //评价
            $('#submit_avalute').click(function() {

                        var ss="<?php echo session('yixin_ss'); ?>";
                        var is_login = "<?php echo ($islogin); ?>";
                        var curLength = $("#TextArea1").val().length;
                        if (curLength <= 0 || is_login == 0) {
                            return false;
                        }else if(sh_check_logins(ss)!=1){
                            alert('用户不合法');
                            return false;
                        }else {
                            $('#evalute_form').submit();
                        }
                    }
            );
            //增加收藏
            $('#add_favorite').click(function(){
                var ss="<?php echo session('yixin_ss'); ?>";
                var snaliyi_artid="<?php echo ($_GET['aid']); ?>"
                var save_url="<?php echo U('MyChat/saveFavorite');?>";
                var is_save=$(this).attr("is_save");
                var isLogin=sh_check_logins(ss)
                //var isLogin=1;
                 if(isLogin!=1){
                     mui.alert('用户未登录', '消息', function() {

                     });
                 }else{
                     $.post(save_url,{'aid':snaliyi_artid,'is_save':is_save},function(data){
                        if(data==1){
                            if(is_save==0) {
                                $('#add_favorite').attr('is_save','0');
                                $('#add_favorite img').attr('src', "/shop_skyhospital/trunk/shopweb/Public/Article/images/scw.png");
                            }else if(is_save==1){
                                $('#add_favorite').attr('is_save','0');
                                $('#add_favorite img').attr('src', "/shop_skyhospital/trunk/shopweb/Public/Article/images/sc.png");
                            }
                        }
                     },'text');
                 }
            });


        </script>
        <script type="text/javascript">

            $(function(){
                var bodyhei = $('body').height();
                $("#bg").height(bodyhei);
                $(".commont").click(function(){
                    $(".hid").css("display","block");
                    $(".hidbd").css("display","block");
                    $('#bg').css("display","block");

                });
                $(".shafabtn").click(function(){
                    $(".hid").css("display","block");
                    $(".hidbd").css("display","block");
                    $('#bg').css("display","block");

                });
                $(".arrdown").click(function(){
                    $(".hid").css("display","none");
                    $(".hidbd").css("display","none");
                    $('#bg').css("display","none");
                });
            });

        </script>
        <script>
            //分享
            function sh_evoke_shares(){

                    var url="<?php echo C('DOMAIN').U('Article/Index/detail',array('aid'=>$de['id'],'wxfx'=>1)) ?>"
                    var imgurl="<?php  $img=unserialize($de['pic']);if(!$img){echo '';}else{echo C('WEB_URL').$img[0];}?>"
                    var title="<?php echo ($de["title"]); ?>";
                   if(navigator.userAgent.match('iPhone')){
                       //alert(1);
                    return sh_evoke_share(url,title,imgurl);
                  }
                  if(navigator.userAgent.match('Android')){
                    return  Android.sh_evoke_share(url,title,imgurl);
                  }
            }
        </script>

    </body>

</html>