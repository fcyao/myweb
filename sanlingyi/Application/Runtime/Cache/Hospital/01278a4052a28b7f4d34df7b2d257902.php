<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>医苑天地</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
        
<link rel="stylesheet" href="/sanlingyi/Public/Hospital/css/mui.min.css">
<link rel="stylesheet" type="text/css" href="/sanlingyi/Public/Hospital/css/app.css" />
<link rel="stylesheet" type="text/css" href="/sanlingyi/Public/Hospital/css/common.css" />
		<link rel="stylesheet" type="text/css" href="/sanlingyi/Public/Hospital/css/doctorindex.css" />
        <style>
            #scroller,#thelist{
                -webkit-transform:translate3d(0,0,0);
            }
            #wrapper {
                position: absolute;
                z-index: 1;
                top: 0;
                 bottom: 0;
                left: -9999px;
                width: 100%;
                overflow: auto;
                -webkit-transform:translate3d(0,0,0);

            }

            #pullDown{
                text-align: center;
            }
            #pullUp{
                text-align: center;
            }

        </style>
	</head>

	<body>
            <div id="wrapper">
                <div id="scroller">
                    <div id="pullDown">
                        <span class="pullDownIcon"></span><span class="pullDownLabel"></span>
                    </div>
                    <div class="title-content">
                        <!--导航-->
                        <a class="title-nav" onclick="gotoIos('<?php echo U('Index/cate');?>')">
                            <div class="navbox">
                                <img src="/sanlingyi/Public/Hospital/images/pic1.png" alt=""/>
                                <div>热点话题</div>
                                <div class="line"></div>
                            </div>
                        </a>
                        <a class="title-nav" onclick="gotoIos('<?php echo U('Index/lists',array('cid'=>1));?>')">
                            <div class="navbox">
                                <img src="/sanlingyi/Public/Hospital/images/pic2.png" alt=""/>
                                <div>学术交流</div>
                                <div class="line"></div>
                            </div>
                        </a>
                        <a class="title-nav" onclick="gotoIos('<?php echo U('Index/lists',array('cid'=>2));?>')">
                            <div class="navbox">
                                <img src="/sanlingyi/Public/Hospital/images/pic3.png" alt=""/>
                                <div>有问必答</div>
                            </div>
                        </a>
                        <div class="clear"></div>

                        <a class="title-nav" onclick="gotoIos('<?php echo U('Index/lists',array('cid'=>3));?>')">
                            <div class="navbox">
                                <img src="/sanlingyi/Public/Hospital/images/pic4.png" alt=""/>
                                <div>病例分析</div>
                                <div class="line"></div>
                            </div>
                        </a>
                        <a class="title-nav" onclick="gotoIos('<?php echo U('Index/lists',array('cid'=>4));?>')">
                            <div class="navbox">
                                <img src="/sanlingyi/Public/Hospital/images/pic5.png" alt=""/>
                                <div>行业观察</div>
                                <div class="line"></div>
                            </div>
                        </a>

                        <a class="title-nav" onclick="gotoIos('<?php echo U('MyChat/index');?>')">
                            <div class="navbox">
                                <img src="/sanlingyi/Public/Hospital/images/pic6.png" alt=""/>
                                <div>我的记录</div>
                            </div>
                        </a>
                        <div class="clear"></div>
                    </div>

                    <div style="width: 100%;height: 10px;background: #eeeeee;border-top: 1px solid #e2e2e2;border-bottom: 1px solid #e2e2e2;margin-top: 13px"></div>
                    <div class="mui-content">

                    <ul class="new-list" id="thelist">
                        <?php if(is_array($news)): foreach($news as $key=>$vo): ?><li>
                                <a onclick="gotoIos('<?php echo U('Index/detail',array('aid'=>$vo['id']));?>')">

                                <div class="headimg">
                                    <div style="position: absolute;z-index:1;width: 100%;">
                                        <?php if($vo['authentication']==11){ ?>
                                        <img src="/sanlingyi/Public/Hospital/images/icon_authdoctor_v2.png" style="width:8.5%;"/>
                                        <?php }else if($vo['authentication']==1){ ?>
                                        <img src="/sanlingyi/Public/Hospital/images/icon_authdoctor_v1.png" style="width:8.5%;"/>
                                        <?php } ?>
                                        <img class="auth" src="/sanlingyi/Public/Hospital/images/icon_authdoctor.png" style="width:5.5%;position:absolute;left:9%;"/>
                                    </div>
                                    <img src="<?php echo ($vo["img_url"]); ?>"/>
                                </div>

                                <div class="list-box">
                                    <p class="p1 ">
                                         <?php echo ($vo["user_name"]); ?>
                                        <p class="p2"><?php echo $vo['recollection_id']; ?></p>
                                        <div class="clear"></div>
                                    </p>

                                    <div class="p3">
                                        <div><?php echo ($vo["title"]); ?></div>
                                        <?php if($vo['cimg_url'][0]['source_image_url']){ ?>
                                        <img src="<?php echo $vo['cimg_url'][0]['source_image_url']; ?>" alt="" style="width: 35%;float: none;margin-top: 5px"/>
                                        <?php } ?>
                                    </div>
                                    <div class="p4">
                                        <div class="time"><?php echo substr($vo['createDate'],5,5); ?></div>
                                        <div class="blue sort"><?php echo get_name($vo['columns']); ?></div>
                                        <div class="joined">已参与人次：<?php echo ($vo["comment_cont"]); ?></div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                </a>
                            </li><?php endforeach; endif; ?>
                    </ul>
                    <div id="pullUp">
                        <span class="pullUpIcon"></span><span class="pullUpLabel">上拉加载更多...</span>
                    </div>
                </div>
            </div>
		</div>
        <script src="/sanlingyi/Public/Hospital/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="/sanlingyi/Public/Hospital/js/iscroll.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
            $(function(){
                hostUrl = location.host;
//                console.log(hostUrl);
                var get_left = $('.auth').css('left');
                $('.auth').css('top',get_left);
            });
            function gotoIos(url){
                if(navigator.userAgent.match('iPhone')){
                    console.log(hostUrl+url);
                    gotoYixinagent(hostUrl+url);
                }
                if(navigator.userAgent.match('Android')){
                    //alert($uid);
                    Android.gotoYixinagent(hostUrl+url);
                }
            }
        </script>


        <script type="text/javascript">
            var myScroll,
                    pullDownEl, pullDownOffset,
                    pullUpEl, pullUpOffset,
                    generatedCount = 0;

//            myScroll.refresh();
            /**
             * 下拉刷新 （自定义实现此方法）
             * myScroll.refresh();		// 数据加载完成后，调用界面更新方法
             */
            function pullDownAction () {
                // sanlingyi_page=0;
                myScroll.refresh();
//                window.location.reload();
            }

            /**
             * 滚动翻页 （自定义实现此方法）
             * myScroll.refresh();		// 数据加载完成后，调用界面更新方法
             */
            sanlingyi_page=1;
            function pullUpAction () {
                //查询更多
                var article=$('#thelist');
                var url="<?php echo U('index/morenews');?>";
//                console.log(sanlingyi_page);
                $.post(
                        url,{'page':sanlingyi_page},function(data){
                            console.log(data)
                            if(data) {
                                sanlingyi_page=sanlingyi_page+1;
                                article.append(data);
                                setTimeout(
                                        function(){
                                            myScroll.refresh()
                                        },200);
                                //alert(date);
                            }else{
                                myScroll.refresh();
                            }
                        }
                        ,'html' );

            }

            /**
             * 初始化iScroll控件
             */
            function loaded() {
                pullDownEl = document.getElementById('pullDown');
                pullDownOffset = pullDownEl.offsetHeight;
                pullUpEl = document.getElementById('pullUp');
                pullUpOffset = pullUpEl.offsetHeight;
                setTimeout(function(){
                    myScroll = new iScroll('wrapper', {
                        scrollbarClass: 'myScrollbar', /* 重要样式 */
                        useTransition: false, /* 此属性不知用意，本人从true改为false */
                        topOffset: 0,
                        onRefresh: function () {
                            if (pullDownEl.className.match('loading')) {
                                pullDownEl.className = '';
                                pullDownEl.querySelector('.pullDownLabel').innerHTML = '加载中...';
                            } else if (pullUpEl.className.match('loading')) {
                                pullUpEl.className = '';
                                pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉加载更多...';
                            }
                        },
                        onScrollMove: function () {
                            if (this.y > 5 && !pullDownEl.className.match('flip')) {
//                                pullDownEl.className = 'flip';
//                                pullDownEl.querySelector('.pullDownLabel').innerHTML = '松手开始更新...';
//                                this.minScrollY = 0;
                            } else if (this.y < 5 && pullDownEl.className.match('flip')) {
//                                pullDownEl.className = '';
//                                pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉刷新...';
//                                this.minScrollY = -pullDownOffset;
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
                },200);

//                myScroll.refresh();
                setTimeout(function () { document.getElementById('wrapper').style.left = '0'; }, 800);
//                myScroll.refresh();
            }

            //初始化绑定iScroll控件
            document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
            document.addEventListener('DOMContentLoaded', loaded, false);
//            myScroll.refresh();
        </script>
	</body>

</html>