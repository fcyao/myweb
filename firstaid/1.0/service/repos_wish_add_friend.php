<?php
/**
 * Created by PhpStorm.
 * User: mandrills
 * Date: 15-10-28
 * Time: 下午2:03
 */

/**
 * @param $uid
 * @return bool
 */
function wishAddFriend($userId,$friendId,&$authStatus,$userType=1,$friendType=1)
{

    //$message[0] 直接添加
    $message = array();
    $check = checkUserAddFriendPermission($friendId);

    try {
        $dbObj = new DatabaseManager();
        $db = $dbObj->getConn();

        if($check){
            //直接添加好友
            $authFlag = 0;
            $authStatus = 1;
        }else{
            //添加好友需要验证
            $authFlag = 1;
            $authStatus = 2;
        }


        $sql= <<<T_ECHO
            INSERT INTO user_friend_list(user_id,friend_id,friend_type_id,auth_flag,add_date)
				VALUES($userId,$friendId,$friendType,$authFlag,NOW()),
				($friendId,$userId,$userType,$authFlag,NOW())
				ON DUPLICATE KEY UPDATE add_date=NOW();
T_ECHO;
//        echo $sql;
        return $db->execute($sql);

    } catch (ErrorException $e) {
        ErrCode::echoJson($e->getCode(),$e->getMessage());
    }


}


function checkUserAddFriendPermission($uid)
{
    $sql = <<<T_ECHO
SELECT friend_flag FROM sky_first_aid.user_privilege_list
WHERE user_id = {$uid};
T_ECHO;
    try {
        $dbObj = new DatabaseManager();
        $db = $dbObj->getConn();

        if(!$res = $db->getRow($sql)){
          ErrCode::echoJson('0','Users ID do not exist');
        }

        return $res['friend_flag'];
    } catch (ErrorException $e) {
        ErrCode::echoJson($e->getCode(),$e->getMessage());
    }

}

function isFriend($uid,$fid){
    $sql = <<<T_ECHO
SELECT
    *
FROM
    sky_first_aid.user_friend_list AS list
WHERE
    list.user_id in ({$uid},{$fid}) AND
    list.friend_id in ({$uid},{$fid}) AND
    list.is_friend = 1
T_ECHO;

    try {
        $dbObj = new DatabaseManager();
        $db = $dbObj->getConn();
        return (count($db->getAll($sql))>1) ? true : false;
    } catch (ErrorException $e) {
        ErrCode::echoJson($e->getCode(),$e->getMessage());
    }

}


function isBlock($uid,$fid){
    $sql = <<<T_ECHO
SELECT
    *
FROM
    sky_first_aid.user_friend_list AS list
WHERE
    list.user_id in ({$uid},{$fid}) AND
    list.friend_id in ({$uid},{$fid}) AND
    list.is_friend = 0
T_ECHO;

    try {
        $dbObj = new DatabaseManager();
        $db = $dbObj->getConn();
        return (count($db->getAll($sql))>1) ? true : false;
    } catch (ErrorException $e) {
        ErrCode::echoJson($e->getCode(),$e->getMessage());
    }

}

function deleteFriend($uid,$fid){
    $sql = <<<T_ECHO
DELETE FROM
    sky_first_aid.user_friend_list AS list
WHERE
    list.user_id in ({$uid},{$fid}) AND
    list.friend_id in ({$uid},{$fid}) AND
    list.is_friend = 1
T_ECHO;

//    echo $sql;
    try {
        $dbObj = new DatabaseManager();
        $db = $dbObj->getConn();

        return $db->execute($sql);

    } catch (ErrorException $e) {
        ErrCode::echoJson($e->getCode(),$e->getMessage());
    }

}


function userAddFriendsInfo($uid, $fid)
{
    $select = <<<T_ECHO
SELECT * FROM user_add_friends_info WHERE user_id = $uid AND friend_id = $fid;
T_ECHO;
    $insert = <<<T_ECHO
INSERT INTO user_add_friends_info(user_id,friend_id,createDate) VALUES($uid,$fid,NOW());
T_ECHO;
    $update = <<<T_ECHO
UPDATE user_add_friends_info SET createDate = NOW() WHERE user_id = $uid AND friend_id = $fid;
T_ECHO;

    $dbObj = new DatabaseManager();
    $db = $dbObj->getConn();
    $res = $db->getRow($select);

    if ($res) {
        return $db->execute($update);
    }else{
        return $db->execute($insert);
    }

}

