<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 会员控制器
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/8/21
 * Time: 13:43
 */

class UserController extends  CommonController{


    /**
     * 会员消费记录
     */
    public function buyRecord(){
    	//调用接口
    	$data=array(
    			'ss'=>session('yixin_ss'),
    			'page'=>1
    	);
    	$result=poster("Member/getMoneyLog",$data);
    	if($result){
    		$this->assign('result',$result['result']);
    	}else{
    		$this->error($result['msg']);
    	}
        //消费记录
        $result=poster("Member/consumeList",$data);
        if($result){
            $this->assign('consum',$result['result']);
        }else{
            $this->error($result['msg']);
        }
    	//dump($_SESSION);
    	$this->assign('total_money',$_SESSION['user_info']['agency_money']);
    	$this->display('user_consumeRec');
    }
    
    /**
     *	消费记录分页
     */
    public  function  updateBuy(){
    
//     	$model=D('Article');
//     	$page=$_GET['page']*C('PAGE_NUM');
//     	$this->news=$model->myArticle($page,C('PAGE_NUM'));
//     	if(count($this->news)==0){
//     		return 0;
//     		die();
//     	}
//     	return $this->fetch('art');
    
    
    
    }
    /**
     *消费记录分页
     */
    public  function  updateBuyAjax(){
        $data=array(
            'ss'=>session('yixin_ss'),
            'page'=>I('page')
        );
        $result=poster("Member/consumeList",$data);
        if($result){
            $this->assign('consum',$result['result']);
            $this->display('Data:consumlist');
        }else{
            echo 0;
        }
    }
    
    public  function  updateProfit(){    	
    	$data=array(
    			'ss'=>session('yixin_ss'),
    			'page'=>$_GET['page']
    	);
    	$result=poster("Member/getMoneyLog",$data);
    	

    	if($result['result']){
    		$this->assign('result',$result['result']);
    	}else{
    		//$this->error($result['msg']);
    	}
    	$this->display('profit_list');
    	//var_dump( $str);
    } 
    /**
     *活动详情页
     */       
    public function activityDetial(){
    	
    	 
    	//dump($result);
    	$result['result']=M('mall_activity_info')->where(array('activity_id'=>$_GET['id']))->find();
    	
    	if($result['result']){
    		$this->assign('result',$result['result']);
    	}else{
    		//$this->error($result['msg']);
    	}
    	$this->display();
    	
    	
    }
    /**
     *商品详情页面
     */
    public function goodsDetial(){
    	 
    	$data=array(
    			'ss'=>session('yixin_ss'),
    			'gid'=>$_GET['id']
    	);
    	 
    	$result=poster("Member/goodDetail",$data);
    
    	$resultgoods=$result['result'];
    	
    	//dump($result);
    	//die();
    	
    	$point_x=C('MEMBER_POINTS_X');//积分换算规则
    	$point_y=C('MEMBER_POINTS_Y');//积分可以抵扣比例
    	//dump($resultgoods['goods_price']/2);
    	
    	//积分*0.01 > 总价/2
    	if(($resultgoods['member_points']*$point_x) > ($resultgoods['goods_price']*$point_y)){
    		$allow_points=($resultgoods['goods_price']*$point_y)/$point_x;
    		
    	}else{
    		$allow_points=$resultgoods['member_points'];
    	}
    	
    	 //['pakege_list']
    	if($result['result']){
    		$this->assign('result',$result['result']);
    	}else{
    		//$this->error($result['msg']);
    	}
    	$this->point_x=$point_x;
    	$this->allow_points=$allow_points;// 可用积分
    	$this->display('goods_detial'); 
    }
    /**
     * 购买商品
     */    
    public function buyGoods(){
    	$data=I();
    	$data['ss']=session('yixin_ss');
    	$result=poster("Member/buyGoods", $data);
    	
    	if($result['code']==1){
    		echo 1;
    	}elseif($result['code']=='1102'){
    		echo 1102;
    	}else{
    		$this->error($result['msg']);
    	}
    }
    /**
     * 商品列表
     */
    public function user_goodsList(){
        if(!IS_AJAX){
            $resultclass=poster("Member/getClass", array('ss'=>session('yixin_ss')));
            if($resultclass['result']){
                $this->assign('goodsclass',$resultclass['result']);
            }else{
                $this->error($resultclass['msg']);
            }
            $this->cid=$resultclass['result'][0]['gc_id'];
        }else{
            if(isset($_GET['update'])){
                $tem='Data:goods_list2';
            }else{
                $tem='Data:goods_list';
            }
        }
         //默认显示第一个
    	$data=array(
    		'ss'=>session('yixin_ss'),
    		'cid'=>I('cid',$this->cid),
            'page'=>I('page',1)
    	);



    	$result=poster("Member/goodsList", $data);

    	//dump($resultclass);
    	//die();
    	if(!is_null($result['result'])){
    		$this->assign('result',$result['result']);
            $counts=count($result['result']);
            $this->assign('nums',$counts);

    	}else{
            opError($result['msg']);

    	}

        !IS_AJAX ? $this->display() : $this->display($tem);

    }
    public  function getgoodsClass(){
    	$data=array(
    		'ss'=>session('yixin_ss')
    	);
    }
    public  function user_video(){
    	$data=array(
    		'ss'=>session('yixin_ss'),
    		'page'=>1
    	);
    	$result=poster("Member/getVedio", $data);
    	if($result['result']){
    		$this->assign('result',$result['result']);
    	}else{
    		$this->error($result['msg']);
    	}
    	$this->display();
    }
    //视频分页
    public  function uservideoAjax(){
    	echo ($this->videoAjax());
    }
    public  function videoAjax(){
    	$data=array(
    			'ss'=>session('yixin_ss'),
    			'page'=>$_GET['page']
    	);
    	$result=poster("Member/getVedio", $data);
    	if($result['result']){
    		$this->assign('result',$result['result']);
    	}else{
    		//$this->error($result['msg']);
    	}
    	
    }
    
    
    
    /**
     * 新增二期接口
     */
    //获取活动详情
    
    public  function getActivityInfo(){
    	$data = I();		//ss , id
    	session("yixin_ss",I('ss'));
    	session("yixin_aid",I('id'));
    	$result=poster("Member/getActivityInfo", $data);
    	$count = count($result['result']);
    	$this->assign('rs',$result['result']);
    	$this->assign('count',$count);
    	$conn=M();
    	//查最大参与人数和已参与人数
    	$sql = "select now_num,max_num from mall_activity_info where activity_id = ".session('yixin_aid');
		
    	$num = $conn->query($sql);
		$this->assign('num',$num[0]);
		$sql = "select user_id from mall_user_session_info where `session` = '".session("yixin_ss")."'";
		$uid = $conn->query($sql);
		$sql="select count(member_id) as c from mall_activity_belong_member where member_id =".$uid[0]['user_id'];
    	$uid_num = $conn->query($sql);
    	$this->assign('unum',$uid_num[0]['c']);
		$this->display();
    	
    	
    }
    
    //参加活动
    
    public function joinActivity(){
		
    	//$data = I();		//ss , aid
    	$data["ss"]=session("yixin_ss");
    	$data['aid']=session("yixin_aid");
    	$result=poster("Member/joinActivity", $data);
    	$result=json_encode($result);
    	echo $result;
     	\Think\Log::write($result['code'],'WARN');
    	

    	
    }
    
    
}