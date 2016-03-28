<?php
/**
 * 医生信息管理控制器
 * 
 */

namespace Home\Controller;
use Think\Controller;
use Think\Model;
class DocManageController extends TemplateController{
	public function index(){
		
	}	
	public function DocManageList($id=0){
		
		
		
		//加载扩展函数
		Load('extend');
		
		//取得分页设置
		$pageList=session('SESS_ListItemData');
		$pageList=$pageList[session('SESS_optModuleID')];
		$pageList=$pageList['parameter'];
		$dbc=M('com_dic_doctor_info','',$this->getDbLink(1));		
		
		
		
		
		//分地区条件
		$reg=$this->getRegionCatch(session('SESS_optModuleID'));
		
		if(is_array($reg)){
			$r=implode(',',$reg);
			//$w='district in ('.$r.')';
			$s['com_dic_doctor_info.district']  = array('in',$r);
		}
		else{
			if($reg==9){
				//$w='true';
			}
			else{
				//$s['com_dic_user_info.district']  = 0;
			}
		}
		if($id>0){
			$rt=$this->getRegion(4,$id);
			if($rt['level']==1){
				$s['com_dic_doctor_info.province']  =$id;
			}
			elseif($rt['level']==2){
				$s['com_dic_doctor_info.city']  =$id;
			}
			else{
				$s['com_dic_doctor_info.district']  =$id;
			}
		}
		//搜索条件
		$condition=$pageList['condition'];
		if($condition != ''){
			if(strstr($condition, 'form,')){//复杂搜索
				$arr=explode(',', $condition);
				
				
				
				$end=$arr[2]?$arr[2]:date('Y-m-d',time());
				$start=$arr[1]?$arr[1]:0;
				$start=$start.' 00:00:00';
				$end=$end.' 23:59:59';
				
				
				$s['_string'] = 'user_base_info.reg_date >"'.$start.'" and user_base_info.reg_date < "'.$end.'"';
				
				
				
				$s['com_dic_user_info.name']=array('like','%'.$arr[3].'%');
				$s['com_dic_user_info.mobile']=array('like','%'.$arr[4].'%');
				if($arr[5]){
					//推广人搜索
					$sql="select SUBSTR(user_id,-6,6) as code from user_base_info  where user_name like '%".$arr[5]."%'";
					$u_ids=M('user_base_info','',$this->getDbLink(1))->query($sql);
					
					$sql="select concat(a.code,s.code) as code from spreader_info s
						left join com_dic_authentication_info a on s.agent_id = a.id
						where s.name like '%".$arr[5]."%'";
					$a_ids=M('user_base_info','',$this->getDbLink(1))->query($sql);
					
					$codes=array_merge($a_ids,$u_ids);
					foreach ($codes as $code){
						if(strlen($code['code'])==6){
							$code_str.=','.$code['code'];
						}
					}
					$code_s=trim($code_str,',');
					
					$s['_string'].=' and concat(com_dic_doctor_info.agent,com_dic_doctor_info.spreader) in ('.$code_s.') ';					
				}
	
				
				if($arr[6] != -1){
					$s['user_base_info.authentication']=$arr[6];
				}
				
			}else{//简单搜索
				
			}
		}	
// 		dump($s);
// 		dump($condition);
		//排序条件
		$order=$pageList['order'];
		if($order != ''){
			$arr=explode(',', $order);	

			$list=array(
				'注册时间'=>'reg_date',
				'注册手机号码'=>'mobile',
			);
			$orderStr=$list[$arr[0]].' '.$arr[1];
		}else{
			$orderStr='user_base_info.reg_date desc';
		}
		$count=$dbc->join('LEFT JOIN com_dic_user_info ON com_dic_doctor_info.id = com_dic_user_info.id')
					->join('LEFT JOIN user_base_info ON com_dic_doctor_info.id = user_base_info.user_id')
					->where($s)
					->count();
		//echo $dbc->getLastSql();
		//dump($count);
		//设置分页		
		$result=$dbc->field('com_dic_user_info.name as user_name,com_dic_user_info.mobile,com_dic_user_info.sex,user_base_info.hospital,dim_recollection_code.name,staff_doctor_check.check_name,staff_doctor_check.staff_name,user_base_info.authentication,com_dic_doctor_info.health_agency,user_base_info.reg_date,staff_doctor_check.doctor_phone as isPic,com_dic_doctor_info.agent,com_dic_doctor_info.spreader,com_dic_user_info.id as id')
					->join('LEFT JOIN user_base_info ON com_dic_doctor_info.id = user_base_info.user_id')
					->join('LEFT JOIN com_dic_user_info ON com_dic_doctor_info.id = com_dic_user_info.id')
					->join('LEFT JOIN dim_recollection_code ON user_base_info.recollection_id = dim_recollection_code.recollection_id')
					->join('LEFT JOIN staff_doctor_check ON com_dic_user_info.id = staff_doctor_check.doctor_id')					
					->where($s)
					->limit($pageList['start'],$pageList['limit'])
					->order($orderStr)->select();		
		//echo $dbc->getLastSql();
		foreach($result as &$v){
			$sexArr=array(
					0=>'未选择',
					1=>'男',
					2=>'女'
			);
			$stateArr=array(
					0=>'未认证',
					1=>'完全认证',
					2=>'待认证',
					3=>'未通过',
					11=>'工牌认证',
			);
			
			$healthArr=array(
					0=>'未分配',
					1=>'已分配',
			);

			$v['sex']=$sexArr[$v['sex']];
			$v['health_agency']=$healthArr[$v['health_agency']];
			$v['authentication']=$stateArr[$v['authentication']];
			
			//$hArr=getHospitalArr($v['id']);
			$hArr=getHospitalArr_bak($v['hospital']);
			$v['hospital']=$hArr['hospital'];
			
			

			$agent=M('com_dic_authentication_info','',$this->getDbLink(1))->where('code='.$v['agent'])->find();
			$speader_name=M('spreader_info','',$this->getDbLink(1))->where('agent_id='.$agent['id'].' and code='.$v['spreader'])->getField('name');
			
			if(strlen($v['agent'])==3 && substr($v['agent'],0,1)=='0'){//系统用户或者医生推广 (25005841 如果用户增长到25100000，会出问题)
				$user_name=M('user_base_info','',$this->getDbLink(1))->where('user_id='.'25'.$v['agent'].$v['spreader'])->getField('user_name');				
				$v['agent']='用户推广_'.$user_name; 
			}else{//组织机构推广
				if($agent && $speader_name){
					$v['agent']=$agent['name'].'_'.$speader_name;
				}elseif($agent && empty($speader_name)){
					$v['agent']=$agent['name'].'_'.$v['spreader'];
				}else{
					$v['agent']=$v['agent'].'_'.$v['spreader'];
				}				
			}
		
			$v['agent']=($v['agent']=='_')?'':$v['agent'];
			$img_count=M('doctor_auth_info','',$this->getDbLink(1))->where('user_id='.$v['id'])->count();
			$v['isPic']=$img_count>0?'有图':'暂无';			
		}
		$_SESSION['region'][session('SESS_optModuleID')]=$id;
		$this->tplListItem(session('SESS_optModuleID'),$result,$count);		
	}
	
	public function docManageAuthItemOpt(){
		$result='docManageAuth';
		return $result;
	}
	//认证
	public function docManageAuth($id,$data){
		
		//dump($_SESSION['SESS_EmployeeInfo']['role_id']);
		
		$Model=M('com_dic_user_info','',$this->getDbLink(1));		
		$da=$Model->field("com_dic_user_info.name as user_name,com_dic_user_info.email,com_dic_user_info.mobile,user_base_info.birthday,user_base_info.authentication,com_dic_doctor_info.skills,dim_recollection_code.name as section_name,com_dic_user_info.province as live_province,com_dic_user_info.address,com_dic_user_info.blood,com_dic_user_info.sex,com_dic_doctor_info.duty_id,com_sic_duty_info.name as duty,staff_doctor_check.staff_name,staff_doctor_check.check_name,com_dic_doctor_info.agent,com_dic_doctor_info.spreader")			  	
			  ->join('LEFT JOIN com_dic_doctor_info ON com_dic_user_info.id = com_dic_doctor_info.id')
			  ->join('LEFT JOIN staff_doctor_check ON com_dic_user_info.id = staff_doctor_check.doctor_id')
			  ->join('LEFT JOIN dim_recollection_code ON com_dic_doctor_info.section_id = dim_recollection_code.recollection_id')
			  ->join('LEFT JOIN com_sic_duty_info ON com_dic_doctor_info.duty_id = com_sic_duty_info.id')			  
			  ->join('LEFT JOIN user_base_info ON com_dic_doctor_info.id = user_base_info.user_id')
			  ->where('com_dic_user_info.id='.$data)
			  ->find();	
		//echo $Model->getLastSql();
		//dump($da);
		$da['id']=$data;
		
		$hospitalArr=getHospitalArr($data);
		
		$province=$hospitalArr['province'];
		$city=$hospitalArr['city'];
		$district=$hospitalArr['district'];
		$hospital_name=$hospitalArr['hospital_name'];

		$da['province_id']=$hospitalArr['province_id'];
		$da['city_id']=$hospitalArr['city_id'];
		$da['district_id']=$hospitalArr['district_id'];
		$da['hospital_name']=$hospitalArr['hospital_name'];
		$da['hospital']=$hospitalArr['hospital'];

		$da['province']=$province;
		
		
		
		
		$agent=M('com_dic_authentication_info','',$this->getDbLink(1))->where('code='.$da['agent'])->find();
		$speader_name=M('spreader_info','',$this->getDbLink(1))->where('agent_id='.$agent['id'].' and code='.$da['spreader'])->getField('name');		
		
		if(strlen($da['agent'])==3 && substr($da['agent'],0,1)=='0'){//系统用户或者医生推广 (25005841 如果用户增长到25100000，会出问题)
			$user_name=M('user_base_info','',$this->getDbLink(1))->where('user_id='.'25'.$da['agent'].$da['spreader'])->getField('user_name');
			$staff_name='用户推广_'.$user_name;
		}else{//组织机构推广
			if($agent && $speader_name){
				$staff_name=$agent['name'].'_'.$speader_name;
			}elseif($agent && empty($speader_name)){
				$staff_name=$agent['name'].'_'.$da['spreader'];
			}else{
				$staff_name=$da['agent'].'_'.$da['spreader'];
			}
				
			$da['check_name']=$_SESSION['SESS_EmployeeInfo']['name'];
		}
		
		$da['staff_name']=$staff_name;
		
		

		$blood=array(
			0=>'未选择',
			1=>'A型',
			2=>'B型',
			3=>'O型',
			4=>'AB型',
			5=>'Rh型',
			6=>'HLA型',
		);
		$da['blood']=$blood[$da['blood']];

		$sexArr=array('未选择','男','女');
		$da['sex']=$sexArr[$da['sex']];
		
		
		$imgs=M('doctor_auth_info','',$this->getDbLink(1))->where('user_id='.$da['id'])->select();	
		
		foreach ($imgs as $key=>$val){
			$img[$val['type']]['img']=strtr(C('IMG_URL').$val["file_addr"],array('M00'=>'MOO/data'));
			$img[$val['type']]['u_img']=urlencode($img[$val['type']]['img']);			
		}
		$this->assign('img',$img);
		
		if($da['authentication'] == 2 || $da['authentication'] == 0 || $_SESSION['SESS_EmployeeInfo']['role_id']==1){
			//取出模板里面的按钮
			$poList=$Model->order('position')->select();
			$this->getPlaceModule($id,0);
			$this->assign('poList',$poList);			
		}

		
		$this->assign('data',$da);				
		$this->display('auth');
	}	
	public function docManageAuthModify(){
		if(IS_POST){	
		actionLog(1,'审批医生');//操作日志记录
		$model = M();
		$docId=I('post.docId');
		$aggree=I('post.authentication');
		$h_data['name']=I('post.hospital_name');
		$h_data['province']=I('post.province');//医院所在省
		$h_data['city']=I('post.city');//医院所在市
		$h_data['section']=I('post.district');//医院所在区


		$h_model=M('hospital_base_info','',$this->getDbLink(1));
		$c_model=M('staff_doctor_check','',$this->getDbLink(1));
		
		$hos=$h_model->where('section='.$h_data['section'].' and name="'.$h_data['name'].'"')->find();		
		$che=$c_model->where('doctor_id='.$docId)->find();		
		$model->startTrans();
		if($aggree==1 || $aggree==11){//通过认证			
			if($hos){//医院存在，医生数量加1
				$result=$h_model->where('pl_id='.$hos['pl_id'])->setInc('doc_num',1); 
			}else{
				$h_data['address']='';
				$h_data['lev']='';
				$h_data['phone']='';
				$h_data['nature']='';
				$h_data['doc_num']=1;
				$h_model->add($h_data);
				//echo $h_model->getLastSql();
			}

			$c_data=array('staff_name'=>I('post.staff_name'),
						  'check_name'=>I('post.check_name'),
						  'check_time'=>date('Y-m-d H:i:s',time()),
					);
			
			if($che){//认证信息存在更新				
				$result=$c_model->where('doctor_id='.$docId)->save($c_data);
			}else{//不存在存在则插入				
				$c_data['doctor_id']=$docId;
				$c_data['doctor_name']=I('post.doctor_name');
				$c_data['doctor_phone']=I('post.doctor_phone');
								
				$result=$c_model->add($c_data);
			}		
			//更新代理商推广医生佣金字段	
			$agent_code=M('com_dic_doctor_info','',$this->getDbLink(1))->where('id='.$docId)->getField('agent');
			if($agent_code){
				M('com_dic_authentication_info','',$this->getDbLink(1))->where('code='.$agent_code.' and status=1')->setInc('doc_balance',C('DOC_VISIT_MONEY'));
			}
			
			
					
		
		}elseif($aggree==3){//拒绝通过认证
			if($hos['doc_num']>1){//医院存在，医生数量减一
				$result=$h_model->where('pl_id='.$hos['pl_id'])->setDec('doc_num');
			}else{
				$result=$h_model->where('pl_id='.$hos['pl_id'])->delete();
			}
			$c_model->where('doctor_id='.$docId)->delete();
		}
		
		//更新用户版本号
		M('user_version_info','',$this->getDbLink(1))->where('user_id='.$docId)->setInc('base_ver');
		//更新认证状态
		$result=M('com_dic_doctor_info','',$this->getDbLink(1))->where('id='.$docId)->save(array('authentication'=>$aggree));
		$result=M('user_base_info','',$this->getDbLink(1))->where('user_id='.$docId)->save(array('authentication'=>$aggree));
		
		//更新healthinfo
		$docInfo=M('user_base_info','',$this->getDbLink(1))
					->where('user_id='.$docId)
					->find();
		
		$hosArr=explode('-',$docInfo['hospital']);
		$versionInfo=M('user_version_info','',$this->getDbLink(1))->where('user_id='.$docId)->find();
		$mtb_model=M('mtb_doctor','',$this->getDbLink(2));
		$is_in=$mtb_model->where('id='.$docId)->find();
		$img=strtr($versionInfo['thumbnail_image_url'],array('M00'=>'MOO/data'));
		if($is_in){
			$mtb_model->where('id='.$docId)->save(array('headImg'=>$img));
		}else{
			$recollection=M('dim_recollection_code','',$this->getDbLink(1))->where('recollection_id='.$docInfo['recollection_id'])->getField('name');
			$duty=M('dim_duty_code','',$this->getDbLink(1))->where('duty_id='.$docInfo['duty_id'])->getField('name');
			
			$arr=array(
				'id'=>$docId,
				'name'=>$docInfo['user_name'],	
				'headImg'=>$img,
				'phone'=>$docInfo['mobile'],
				'province'=>$hosArr[0],
				'city'=>$hosArr[1],
				'section'=>$hosArr[2],
				'hospital'=>$hosArr[3],
				'depart'=>$recollection,
				'title'=>$duty,
				'remark'=>$docInfo['comm'],
			);
			$mtb_model->add($arr);
		}
		
		
		
		if($result!==false){
			$model->commit();
			$this->ajaxReturn('0');
		}else{
			$model->rollback();
			$this->ajaxReturn('1');
		}
	}else{
			$this->loginError('3');
		}	
	}	

	

	public function docManageAgencyItemOpt(){
		$result='docManageAgency';
		return $result;
	}
	//认证
	public function docManageAgency($id,$data){
		$this->getPlaceModule($id, 0, $data, 1);
		$param=array(
				'moduleID'=>$id,
				'objectID'=>$data,
		);
		$this->assign('param',$param);
		$this->display('Template/singleTree');
	}
	public function docManageAgencyModify($data,$parameter){
		$dbc=M('h_assistant_belong_doctor','',$this->getDbLink(1));
		$dbc->startTrans();
		$success=true;
		$res=$dbc->where('doc_id='.$data)->delete();		
		if($res!==false){
			$health_agency=0;
			if($parameter != 'NONE'){
				$t=explode(',',$parameter);	
				foreach ($t as $k=>$v){
					$d['doc_id']=$data;
					$d['user_id']=$v;
					$d['auditor_id']=$_SESSION['SESS_EmployeeInfo']['id'];
					$d['createDate']=date('Y-m-d H:i:s',time());
					$res=$dbc->add($d);					
					if($res<1){
						$success=false;
					}
				}	
				$health_agency=1;
			}
			M('com_dic_doctor_info','',$this->getDbLink(1))->where('id='.$data)->save(array('health_agency'=>$health_agency));			
		}
		if($success){
			$dbc->commit();
		}
		else{
			$dbc->rollback();
		}
		return $success;
	}	
	public function docManageRecItemOpt(){
		$result='docManageRec';
		return $result;
	}	
	//认证
	public function docManageRec($id,$data){
	
		$u_dbc=M('user_base_info','',$this->getDbLink(1));
		$u_info=$u_dbc->where('user_id='.$data)->getField('authentication');
		if($u_info==1){
			$Model=M();
			$poList=$Model->order('position')->select();
			$this->getPlaceModule($id,0);
			$this->assign('poList',$poList);
		}
		

	
		$dbc=M('sys_recommend_doctor_info','',$this->getDbLink(1));
		
		$had_star=$dbc->where('level=1')->find();		
		$info=$dbc->where('doc_id='.$data)->getField('level');		
		$da['rec_type']=$info>0?$info:0;
		$da['had_star']=empty($had_star)?0:1;
		$da['doc_id']=$data;
		//dump($da);
		
		$this->assign('data',$da);
		$this->display('rec');
	}
	public function docManageRecModify(){
		if(IS_POST){
			
			$doc_id=$_POST['doc_id'];
			
			
			$dbc=M('sys_recommend_doctor_info','',$this->getDbLink(1));		
			$dbc->startTrans();
			$info=$dbc->where('doc_id='.$doc_id)->find();
			
			if($info){
				$result=$dbc->where('doc_id='.$doc_id)->save(array('createDate'=>date('Y-m-d H:i:m',time()),'referee'=>$_SESSION['SESS_EmployeeInfo']['id'],'level'=>$_POST['rec_type']));
			}else{
				$result=$dbc->add(array('doc_id'=>$doc_id,'createDate'=>date('Y-m-d H:i:m',time()),'referee'=>$_SESSION['SESS_EmployeeInfo']['id'],'level'=>$_POST['rec_type']));				
			}
	
			if($result!==false){
				$dbc->commit();
				$this->ajaxReturn('0');
			}else{
				$dbc->rollback();
				$this->ajaxReturn('1');
			}
		}else{
			$this->loginError('3');
		}
	}	
	/**
	 * 展示图片
	 * @param str $url  图片地址
	 */
	public function showImg(){
		$url=urldecode($_GET['url']);	
		
		$this->assign('img',$url);
		$this->display('show');
	}	
	//按条件导出员工审核列表
	public function getExcel(){
		ini_set("memory_limit","-1");
			//加载扩展函数
		Load('extend');
		
		//取得分页设置
		$pageList=session('SESS_ListItemData');
		$pageList=$pageList[session('SESS_optModuleID')];
		$pageList=$pageList['parameter'];
		$dbc=M('com_dic_doctor_info','',$this->getDbLink(1));		
		
		$id=$_SESSION['region'][session('SESS_optModuleID')];
		
		
		//分地区条件
		$reg=$this->getRegionCatch(session('SESS_optModuleID'));
		
		if(is_array($reg)){
			$r=implode(',',$reg);
			//$w='district in ('.$r.')';
			$s['com_dic_doctor_info.district']  = array('in',$r);
		}
		else{
			if($reg==9){
				//$w='true';
			}
			else{
				//$s['com_dic_user_info.district']  = 0;
			}
		}
		if($id>0){
			$rt=$this->getRegion(4,$id);
			if($rt['level']==1){
				$s['com_dic_doctor_info.province']  =$id;
			}
			elseif($rt['level']==2){
				$s['com_dic_doctor_info.city']  =$id;
			}
			else{
				$s['com_dic_doctor_info.district']  =$id;
			}
		}
		//搜索条件
		$condition=$pageList['condition'];
		if($condition != ''){
			if(strstr($condition, 'form,')){//复杂搜索
				$arr=explode(',', $condition);
				
				
				
				$end=$arr[2]?$arr[2]:date('Y-m-d',time());
				$start=$arr[1]?$arr[1]:0;
				$start=$start.' 00:00:00';
				$end=$end.' 23:59:59';
				
				
				$s['_string'] = 'user_base_info.reg_date >"'.$start.'" and user_base_info.reg_date < "'.$end.'"';
				
				
				
				$s['com_dic_user_info.name']=array('like','%'.$arr[3].'%');
				$s['com_dic_user_info.mobile']=array('like','%'.$arr[4].'%');
				if($arr[5]){
					//推广人搜索
					$sql="select SUBSTR(user_id,-6,6) as code from user_base_info  where user_name like '%".$arr[5]."%'";
					$u_ids=M('user_base_info','',$this->getDbLink(1))->query($sql);
					
					$sql="select concat(a.code,s.code) as code from spreader_info s
						left join com_dic_authentication_info a on s.agent_id = a.id
						where s.name like '%".$arr[5]."%'";
					$a_ids=M('user_base_info','',$this->getDbLink(1))->query($sql);
					
					$codes=array_merge($a_ids,$u_ids);
					foreach ($codes as $code){
						if(strlen($code['code'])==6){
							$code_str.=','.$code['code'];
						}
					}
					$code_s=trim($code_str,',');
					
					$s['_string'].=' and concat(com_dic_doctor_info.agent,com_dic_doctor_info.spreader) in ('.$code_s.') ';					
				}
	
				
				if($arr[6] != -1){
					$s['user_base_info.authentication']=$arr[6];
				}
				
			}else{//简单搜索
				
			}
		}	
		//排序条件
		$order=$pageList['order'];
		if($order != ''){
			$arr=explode(',', $order);	

			$list=array(
				'注册时间'=>'reg_date',
				'注册手机号码'=>'mobile',
			);
			$orderStr=$list[$arr[0]].' '.$arr[1];
		}else{
			$orderStr='user_base_info.reg_date desc';
		}
		$count=$dbc->join('LEFT JOIN com_dic_user_info ON com_dic_doctor_info.id = com_dic_user_info.id')
					->join('LEFT JOIN user_base_info ON com_dic_doctor_info.id = user_base_info.user_id')
					->where($s)
					->count();
		//echo $dbc->getLastSql();
		//dump($count);
		//设置分页		
		$result=$dbc->field('com_dic_user_info.name as user_name,com_dic_user_info.mobile,user_base_info.sex_id,user_base_info.hospital,dim_recollection_code.name,user_base_info.authentication,user_base_info.reg_date')
					->join('LEFT JOIN user_base_info ON com_dic_doctor_info.id = user_base_info.user_id')
					->join('LEFT JOIN com_dic_user_info ON com_dic_doctor_info.id = com_dic_user_info.id')
					->join('LEFT JOIN dim_recollection_code ON user_base_info.recollection_id = dim_recollection_code.recollection_id')
					->join('LEFT JOIN staff_doctor_check ON com_dic_user_info.id = staff_doctor_check.doctor_id')					
					->where($s)
					
					->order($orderStr)->select();		
		//echo $dbc->getLastSql();
		foreach($result as $k=>$v){
			$new_arr[$k]=$v;
			$sexArr=array(
					0=>'未选择',
					1=>'男',
					2=>'女',
			);
			$new_arr[$k]['sex_id']=$sexArr[$v['sex_id']];
			$stateArr=array(
					0=>'未认证',
					1=>'完全认证',
					2=>'待认证',
					3=>'未通过',
					11=>'工牌认证',
			);

			$new_arr[$k]['authentication']=$stateArr[$v['authentication']];
			
			//$hArr=getHospitalArr($v['id']);
			$hArr=getHospitalArr_bak($v['hospital']);
			$new_arr[$k]['hospital']=$hArr['hospital'];

			}



				//dump($new_arr);
				// 输出Excel文件头，可把user.csv换成你要的文件名
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="doctorList.csv"');
				header('Cache-Control: max-age=0');

				// 打开PHP文件句柄，php://output 表示直接输出到浏览器
				$fp = fopen('php://output', 'a');

				// 输出Excel列名信息
				$head = array('用户名','手机号','性别','医院','科室','认证','注册时间');
				foreach ($head as $i => $v) {
					// CSV的Excel支持GBK编码，一定要转换，否则乱码
					$head[$i] = iconv('utf-8', 'gbk', $v);
				}

				// 将数据通过fputcsv写到文件句柄
				fputcsv($fp, $head);
				foreach ($new_arr as $key => $val) {
					//var_dump($val);
					foreach($val as $k=>$v){
						$new[$k] = iconv('utf-8', 'gbk', $v);
					}
					fputcsv($fp, $new);
				}
			}	
}