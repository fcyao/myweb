<?php

/**
 * @param $uid
 * @param $fid
 * @return array
 * @throws Exception
 */

function getVerInfoListFromBlack($uid,$bid = null)
{

    $sql = <<<T_ECHO
SELECT
    v.user_id uid,
    v.base_ver piv,
    v.image_ver pav
FROM
    sky_user_data_master.user_version_info AS v
WHERE
    v.user_id in (
        SELECT
            f.friend_id
        FROM
            sky_first_aid.user_friend_list AS f
        WHERE
            f.user_id = $uid
        AND
            f.is_friend = 0
)
T_ECHO;

    if($bid){
        $sql .= " AND v.user_id in ($bid)";
    }
//echo $sql;
    try {

        $dbObj = new DatabaseManager();
        $db = $dbObj->getConn();

        return $db->getAll($sql);

    } catch (ErrorException $e) {
        ErrCode::echoJson($e->getCode(),$e->getMessage());
    }

}

function getVerInfoList($uid,$bid = null)
{

    $sql = <<<T_ECHO
SELECT
    v.user_id uid,
    v.base_ver piv,
    v.image_ver pav
FROM
    sky_user_data_master.user_version_info AS v
WHERE
    v.user_id in (
        SELECT
            f.friend_id
        FROM
            sky_first_aid.user_friend_list AS f
        WHERE
            f.user_id = $uid
)
T_ECHO;

    if($bid){
        $sql .= " AND v.user_id in ($bid)";
    }
//echo $sql;
    try {

        $dbObj = new DatabaseManager();
        $db = $dbObj->getConn();

        return $db->getAll($sql);

    } catch (ErrorException $e) {
        ErrCode::echoJson($e->getCode(),$e->getMessage());
    }

}

function getFriendsVerInfoListByFriendId($uid,$fid)
{
    $sql = <<<T_ECHO
SELECT
    user_info.user_id uid,
    user_info.base_ver piv,
    user_info.image_ver pav
FROM
    sky_user_data_master.user_version_info AS user_info
WHERE
    user_info.user_id in (
        SELECT
            friend_list.friend_id
        FROM
            sky_first_aid.user_friend_list AS friend_list
        WHERE
            friend_list.user_id = $uid
        AND
            friend_list.is_friend = 1
)
AND
   user_info.user_id in ($fid)
;
T_ECHO;

    try {

        $dbObj = new DatabaseManager();
        $db = $dbObj->getConn();

        return $db->getAll($sql);

    } catch (ErrorException $e) {
        ErrCode::echoJson($e->getCode(),$e->getMessage());
    }

}

/**
 * @param $uid
 * @return array
 * @throws Exception
 */
function getFriendsVerInfoList($uid)
{
    $sql = <<<T_ECHO
SELECT
    user_info.user_id uid,
    user_info.base_ver piv,
    user_info.image_ver pav
FROM
    sky_user_data_master.user_version_info AS user_info
WHERE
    user_info.user_id in (
        SELECT
            friend_list.friend_id
        FROM
            sky_first_aid.user_friend_list AS friend_list
        WHERE
            friend_list.user_id = $uid
        AND
            friend_list.is_friend = 1
);
T_ECHO;
//echo $sql;
    try {

        $dbObj = new DatabaseManager();
        $db = $dbObj->getConn();

        return $db->getAll($sql);

    } catch (ErrorException $e) {
        ErrCode::echoJson($e->getCode(),$e->getMessage());
    }

}
