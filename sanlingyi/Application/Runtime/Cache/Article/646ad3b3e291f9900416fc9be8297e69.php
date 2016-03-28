<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>阅读内容</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<link rel="stylesheet" href="/sanlingyi/Public/Article/css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="/sanlingyi/Public/Article/css/app.css"/>
		<link rel="stylesheet" type="text/css" href="/sanlingyi/Public/Article/css/actcontent.css"/>
		<link rel="stylesheet" type="text/css" href="/sanlingyi/Public/Article/css/iconfont.css"/>

	</head>

	<body>
	<style type="text/css" media="all">



#wrapper {
	position:absolute; z-index:1;
	top:190px; bottom:0px; left:0px;
	width: 100%;
	background:none;
	overflow:auto;
}


/**
 *
 * 下拉样式 Pull down styles
 *
 */

</style>

	
		<header class="mui-bar mui-bar-nav" style="background:#30c6df;position: fixed;">
            <div style="color: #fff;" class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" onclick="history.go(-1)"></div>
			<h1 class="mui-title" style="color:#fff">发表评论</h1>
            <?php
 if(!session('?yixin_user')){ $isshow=0; }else{ $count=M('article_evaluation')->where(array('user_id'=>session('yixin_user')))->count(); if($count<1){ $isshow=0; }else{ $isshow=1; } } ?>

            <?php
 if($isshow){ ?>
			<a class="mui-icon mui-icon-chat mui-pull-right" href="<?php echo U('MyChat/index');?>"></a>
            <?php }?>
		</header>
		<!--
        	时间：2015-06-29
        	描述：主要内容
        -->
         
		<div class="mui-content">
			<h4><?php echo ($de["title"]); ?></h4>
			<h6><span><?php echo ($de["article_from"]); ?></span><span class="time"><?php echo ($de["examine_time"]); ?></span><span style="float:right"><span style="color:red"><?php echo ($evalute); ?></span>条评论</span></h6>

		<!--
        	时间：2015-06-29
        	描述：选项卡
        -->
        <img class="hdline" src="/sanlingyi/Public/Article/images/line.png" />
        <div class="mui-segmented-control cc">
			<a href="<?php echo U('evalute',array('aid'=>$de['id'],'type'=>1));?>" class="mui-control-item <?php if($type==1) echo 'mui-active'; ?> ">时间</a>
			<a href="<?php echo U('evalute',array('aid'=>$de['id'],'type'=>2));?>" class="mui-control-item <?php if($type==2) echo 'mui-active1'; ?>">热度</a>
		</div>
            <?php
 $count=count($com); $page=C('PAGE_NUM'); ?>
 		<!--
        	时间：2015-06-30
        	描述：列表
        -->
            <?php
 if($count>=$page){ ?>
           <div id="wrapper">
            <div id="scroller">
                <div id="pullDown" style="text-align: center;padding: 10px 0; color:#555;">
                    <span class="pullDownIcon"></span><span class="pullDownLabel">下拉刷新</span>
                </div>
             <?php
 } ?>
							<ul class="mui-table-view" id="thelist">
                                <?php if(is_array($com)): foreach($com as $key=>$v): ?><li class="mui-table-view-cell" class="com-list">

                                        <img src="<?php echo ($v['thumbnail_image_url']); ?>" class="mui-pull-left com-img"/>
                                        <div class="com-li">
                                            <div style="color:#000"><?php echo ($v["user_name"]); ?><span class="mui-pull-right" style="color:#666666;font-size: 12px;"><?php echo ($v["create_time"]); ?></span></div>
                                            <div style="font-size:12px"><?php echo ($v["content"]); ?></div>
                                            <div aid="<?php echo ($de['id']); ?>" eid="<?php echo ($v["id"]); ?>" class="mui-pull-right" style="font-size: 12px;">
                                                <span  class="mui-icon iconfont icon-zan blue"></span>
                                                (<span class="up_num" style="color:red"><?php echo ($v["up_num"]); ?></span>)
                                            </div>
                                        </div>
                                    </li><?php endforeach; endif; ?>


					</ul><!--列表-->
                <?php
 if($count>=$page){ ?>
                <div id="pullUp" style="text-align: center;padding: 10px 0; color:#555;">
                    <span class="pullUpIcon"></span><span class="pullUpLabel">上拉加载更多...</span>
                </div>
            </div>
            </div>
              <?php
 } ?>
		</div>
        <script src="/sanlingyi/Public/Article/js/jquery-1.9.1.min.js"></script>
        <?php
 if($count>=$page){ ?>

        <script src="/sanlingyi/Public/Article/js/iscroll.js"></script>
        <script type="text/javascript">
            var myScroll,
                    pullDownEl, pullDownOffset,
                    pullUpEl, pullUpOffset,
                    generatedCount = 0;

            /**
             * 下拉刷新 （自定义实现此方法）
             * myScroll.refresh();		// 数据加载完成后，调用界面更新方法
             */
            function pullDownAction () {
                // sanlingyi_page=0;
                //查询更多
                var article=$('#thelist');
                var url="<?php echo U('evalute','','');?>";
                var type="<?php echo ($type); ?>";
                var aid="<?php echo ($de["id"]); ?>";
                $.post(
                        url,{"update":1,"aid":aid,"type":type,"ajax":1},function(date){

                            if(date!=0) {
                                sanlingyi_page=1;
                                //article.append(date);
                                var obj = eval(date);
                                var str='';
                                $(obj).each(function(index) {
                                    var val = obj[index];
                                    if (typeof (val.summary) == "object") {
                                        $(val.summary).each(function(ind) {
                                            alert(val.user_name + " " + val.Content + " " + val.summary[ind].sum0);
                                        });
                                    } else {

                                        str+='<li class="mui-table-view-cell" class="com-list">'+
                                        '  <img src="'+val.thumbnail_image_url+'" class="mui-pull-left com-img"/>'+
                                        '              <div class="com-li">'+
                                        ' <div style="color:#000">'+val.user_name+'<span class="mui-pull-right" style="color:#666666;font-size: 12px;">'+val.create_time+'</span></div>'+
                                        '                                            <div style="font-size:12px">'+val.content+'</div>'+
                                        '                                            <div aid="8" eid="75" class="mui-pull-right" style="font-size: 12px;">'+
                                        '                                                <span  class="mui-icon iconfont icon-zan blue"></span>'+
                                        '                                                (<span class="up_num" style="color:red">'+val.up_num+'</span>)'+
                                        '                                            </div>'+
                                        '                                        </div>'+
                                        '                                    </li>';

                                    }
                                   
                                });
                                article.html('');
                                article.html(str);
                                myScroll.refresh();
                                //alert(date);
                            }else{
                                myScroll.refresh();
                            }
                        }
                        ,'text' );
                //myScroll.refresh();
            }

            /**
             * 滚动翻页 （自定义实现此方法）
             * myScroll.refresh();		// 数据加载完成后，调用界面更新方法
             */
            sanlingyi_page=1;
            function pullUpAction () {
                //查询更多
                var article=$('#thelist');
                var url="<?php echo U('evalute','','');?>";
                var type="<?php echo ($type); ?>";
                var aid="<?php echo ($de["id"]); ?>";
                $.post(
                        url,{"page":sanlingyi_page,"aid":aid,"type":type,"ajax":1},function(date){

                            if(date!=0) {
                                sanlingyi_page=sanlingyi_page+1;
                                //article.append(date);
                                var obj = eval(date);
                                var str='';
                                $(obj).each(function(index) {
                                    var val = obj[index];
                                    if (typeof (val.summary) == "object") {
                                        $(val.summary).each(function(ind) {
                                            alert(val.user_name + " " + val.Content + " " + val.summary[ind].sum0);
                                        });
                                    } else {

                                        str+='<li class="mui-table-view-cell" class="com-list">'+
                                        '  <img src="'+val.thumbnail_image_url+'" class="mui-pull-left com-img"/>'+
                                        '              <div class="com-li">'+
                                        ' <div style="color:#000">'+val.user_name+'<span class="mui-pull-right" style="color:#666666;font-size: 12px;">'+val.create_time+'</span></div>'+
                                        '                                            <div style="font-size:12px">'+val.content+'</div>'+
                                        '                                            <div aid="8" eid="75" class="mui-pull-right" style="font-size: 12px;">'+
                                        '                                                <span  class="mui-icon iconfont icon-zan blue"></span>'+
                                        '                                                (<span class="up_num" style="color:red">'+val.up_num+'</span>)'+
                                        '                                            </div>'+
                                        '                                        </div>'+
                                        '                                    </li>';
                                       

                                    }
                                   
                                   
                                });
                                article.append(str);
                                myScroll.refresh();
                                //alert(date);
                            }else{
                                myScroll.refresh();
                            }
                        }
                        ,'text' );

            }

            /**
             * 初始化iScroll控件
             */
            function loaded() {
                pullDownEl = document.getElementById('pullDown');
                pullDownOffset = pullDownEl.offsetHeight;
                pullUpEl = document.getElementById('pullUp');
                pullUpOffset = pullUpEl.offsetHeight;

                myScroll = new iScroll('wrapper', {
                    scrollbarClass: 'myScrollbar', /* 重要样式 */
                    useTransition: false, /* 此属性不知用意，本人从true改为false */
                    topOffset: pullDownOffset,
                    onRefresh: function () {
                        if (pullDownEl.className.match('loading')) {
                            pullDownEl.className = '';
                            pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉刷新...';
                        } else if (pullUpEl.className.match('loading')) {
                            pullUpEl.className = '';
                            pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉加载更多...';
                        }
                    },
                    onScrollMove: function () {
                        if (this.y > 5 && !pullDownEl.className.match('flip')) {
                            pullDownEl.className = 'flip';
                            pullDownEl.querySelector('.pullDownLabel').innerHTML = '松手开始更新...';
                            this.minScrollY = 0;
                        } else if (this.y < 5 && pullDownEl.className.match('flip')) {
                            pullDownEl.className = '';
                            pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉刷新...';
                            this.minScrollY = -pullDownOffset;
                        } else if (this.y < (this.maxScrollY - 5) && !pullUpEl.className.match('flip')) {
                            pullUpEl.className = 'flip';
                            pullUpEl.querySelector('.pullUpLabel').innerHTML = '松手开始更新...';
                            this.maxScrollY = this.maxScrollY;
                        } else if (this.y > (this.maxScrollY + 5) && pullUpEl.className.match('flip')) {
                            pullUpEl.className = '';
                            pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉加载更多...';
                            this.maxScrollY = pullUpOffset;
                        }
                    },
                    onScrollEnd: function () {
                        if (pullDownEl.className.match('flip')) {
                            pullDownEl.className = 'loading';
                            pullDownEl.querySelector('.pullDownLabel').innerHTML = '加载中...';
                            pullDownAction();	// Execute custom function (ajax call?)
                        } else if (pullUpEl.className.match('flip')) {
                            pullUpEl.className = 'loading';
                            pullUpEl.querySelector('.pullUpLabel').innerHTML = '加载中...';
                            pullUpAction();	// Execute custom function (ajax call?)
                        }
                    }
                });

                setTimeout(function () { document.getElementById('wrapper').style.left = '0'; }, 800);
            }

            //初始化绑定iScroll控件
            document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
            document.addEventListener('DOMContentLoaded', loaded, false);



        </script>
        <?php } ?>
        <script>
            $('.mui-pull-right').click(
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

	</body>

</html>