<?php
define("MONGO_CONFIG_PATH",dirname(__FILE__) . "/../config/sysConfig.ini");
define("FIND_USER_INSTANCE",4000000);//查找附近用户的距离，单位米
define("FIND_USER_NUMBER",100);//查找附近用户的数量
define("FIND_USER_ACTIVE",100000);//查找附近用户的活跃度，也即距离当前时间多少分钟使用过，单位分钟
class RKMongo
{
	private $normal="normalLbsInfo";
	private $doctor="doctorLbsInfo";
	private $normal_His = "normalLbsInfoHistory";
	private $doctor_His ="doctorLbsInfoHistory";
	private $normal_Act = "normalActivist";
	private $doctor_Act ="doctorActivist";
	private $config = array();
	private $mongodb;
	private $mongo;
	function getConfig()
	{
		try
		{
			$this->config = parse_ini_file(MONGO_CONFIG_PATH);
			if (isset($this->config['MONGO_HOST']) && isset($this->config['MONGO_PORT']) && isset($this->config['MONGO_NAME'])){
				return $this->config;
			}
			else{
				return false;
			}
		}
		catch(Exception $e)
		{
			return false;
		}
	}

	function connect()
	{
		if ($this->getConfig()){
			$host = $this->config['MONGO_HOST'];
			$port = $this->config['MONGO_PORT'];
			$database = $this->config['MONGO_NAME'];
			$server="mongodb://".$host.":".$port;
			try
			{
				$this->mongo = new Mongo($server);
				return true;
			}
			catch(Exception $e)
			{
				return false;
			}
		}
		else{
			return false;
		}
	}

	function getTableName($userType)
	{
		$table="";
		switch($userType)
		{
		case 1:
			$table = $this->normal;
			break;
		case 2:
			$table = $this->doctor;
			break;
		default:
			$table="Err";
			break;
		}
		return $table;
	}
	
	function getHisTableName($userType)
	{
		$table="";
		switch($userType)
		{
			case 1:
				$table = $this->normal_His;
				break;
			case 2:
				$table = $this->doctor_His;
				break;
			default:
				$table="Err";
				break;
		}
		return $table;
	}
	
	function getActTableName($userType)
	{
		$table="";
		switch($userType)
		{
			case 1:
				$table = $this->normal_Act;
				break;
			case 2:
				$table = $this->doctor_Act;
				break;
			default:
				$table="Err";
				break;
		}
		return $table;
	}
	
	//获取当前个人GPS位置信息
	function getMyLbs($userType,$userId)
	{
		$tableName=$this->getTableName($userType);
		if($tableName!="Err")
		{
			$database = $this->config['MONGO_NAME'];
			try
			{
				$collection = $this->mongo->{$database}->selectCollection($tableName);
				$result=$collection->findOne(array("_id"=>$userId));
				return $result['gps'];
			}
			catch(Exception $e)
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	/*上传医信用户GPS位置信息
	$userType	医信用户类型
	$userId		医信用户ID
	$longitude	经度，精确小数位6   ==>
	$latitude   维度精确小数位6		==> gps =array(longitude,latitude)	
	*/
	function setLbs($userType,$userId,$gps)
	{
		$tableName=$this->getTableName($userType);
		$tableNameHis=$this->getHisTableName($userType);
		$tableNameAct=$this->getActTableName($userType);
		if($tableName!="Err")
		{
			//匹配更新数据记录
			//srcDocument 源记录值
			//dstDocument 修改后记录值
			$srcDocument = array("_id"=>$userId);
			$dstDocument = array("_id"=>$userId,"dt"=>new MongoDate(),"gps"=>$gps);
			$hisDocument = array("userId"=>$userId,"dt"=>date("Y-m-d"),"t"=>date("G:i:s"),"gps"=>$gps);
			$actDocument = array("_id"=>$userId."-".date("Y-m-d"));
			$database = $this->config['MONGO_NAME'];
			try
			{
				$collection = $this->mongo->{$database}->selectCollection($tableName);
				$collection->update($srcDocument,$dstDocument,array("upsert"=>true));
				
				$col_His = $this->mongo->{$database}->selectCollection($tableNameHis);
				$d = date("Y-m-d",strtotime("-1 day"));
				$col_His->remove(array("dt"=>$d));
				$col_His->insert($hisDocument);
				
				$col_Act = $this->mongo->{$database}->selectCollection($tableNameAct);
				$col_Act->update($actDocument,array("\$inc"=>array("activists"=>1)),array("upsert"=>true));
				return true;
			}
			catch(Exception $e)
			{
				return false;
			}
		}
		else		
		{
			return false;
		}    
	}

	/*上传用户失联GPS位置信息
	$userId		用户ID
	$longitude	经度，精确小数位6   ==>
	$latitude   维度精确小数位6		==> gps =array(longitude,latitude)
	*/
	function setLinkmanLbs($userId,$time,$gps)
	{
		$tableName="linkLbsInfo";
	
		if($tableName!="Err")
		{
			//匹配更新数据记录
			//srcDocument 源记录值
			$srcDocument = array("userId"=>$userId,"dt"=>$time,"gps"=>$gps);
			$database = $this->config['MONGO_NAME'];
			try
			{
				$col_link = $this->mongo->{$database}->selectCollection($tableName);
				$col_link->insert($srcDocument);
				return true;
			}
			catch(Exception $e)
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	/*删除用户失联GPS位置信息
	 $userId  用户ID
	*/
	function delLinkmanLbs($userId)
	{
		$tableName="linkLbsInfo";
	
		if($tableName!="Err")
		{
			//匹配更新数据记录
			$database = $this->config['MONGO_NAME'];
			try
			{
				$col_link = $this->mongo->{$database}->selectCollection($tableName);
				$col_link->remove(array("userId"=>$userId));
				return true;
			}
			catch(Exception $e)
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	/*获取用户失联GPS位置历史信息
	 $userId		用户ID
	 $longitude	经度，精确小数位6   ==>
	 $latitude   维度精确小数位6		==> gps =array(longitude,latitude)
	*/
	function getLinkmanLbsHistory($userId,$start,$end)
	{
		$tableName="linkLbsInfo";
	
		if($tableName!="Err")
		{
			$database = $this->config['MONGO_NAME'];
			try
			{
				$col_link = $this->mongo->{$database}->selectCollection($tableName);
				$result=$col_link->find(array("userId"=>$userId),array("dt"=>array("\$gte"=>$start,"\$lte"=>$end)))->sort(array("dt"=>-1))->limit(10);
				return $result;
			}
			catch(Exception $e)
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}	
	
	/*获取用户失联GPS位置实时信息
	 $userId		用户ID
	$longitude	经度，精确小数位6   ==>
	$latitude   维度精确小数位6		==> gps =array(longitude,latitude)
	*/
	function getLinkmanLbsNow($userId,$now,$page)
	{
		$tableName="linkLbsInfo";
		$pageSize = 80;
		if($tableName!="Err")
		{
			$database = $this->config['MONGO_NAME'];
			try
			{
				$col_link = $this->mongo->{$database}->selectCollection($tableName);
				if($page==1){
					$result=$col_link->find(array("userId"=>$userId))->sort(array("dt"=>-1))->limit($pageSize);
				}else{
					$result=$col_link->find(array("userId"=>$userId))->sort(array("dt"=>-1))->skip(($page-1)*$pageSize)->limit($pageSize);
				}
				return $result;
			}
			catch(Exception $e)
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	/*获取个人周围的医信好友
	$userType 医信用户类型
	$userId   医信用户ID
	$gps	  gps位置信息array(经度，维度)	
	$filterFriendList 需要过滤的医信用户array(userid1,userid2,userid3.........)
	$instance 查找范围,单位米
	$maxNum   返回数量
	*/
	function getLbs($userType,$userId,$gps,$filterFriendList)
	{
		$tableName=$this->getTableName($userType);		
		if($tableName!="Err")
		{			
			$strCommand = array('geoNear'=>$tableName,
								'near'=>$gps,
								'spherical'=>true,
								'maxDistance'=>FIND_USER_INSTANCE/6371000,
								'distanceMultiplier'=>6371000,
								'num'=>FIND_USER_NUMBER);
			$start = new MongoDate(strtotime('-'.FIND_USER_ACTIVE.' minute'));
			$queryCondition = array('_id'=>array('$nin'=>$filterFriendList),'dt'=>array('$gt'=>$start));
			
			$strCommand['query'] = $queryCondition;
			$database = $this->config['MONGO_NAME'];
			try
			{
				return $this->mongo->{$database}->command($strCommand);		
			}
			catch(Exception $e)
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	function close()
	{
		$this->mongo->close();
	}
}
?>
