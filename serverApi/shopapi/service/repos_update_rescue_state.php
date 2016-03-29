<?php
/**
 * Created by PhpStorm.
 * User: mandrills
 * Date: 15-11-5
 * Time: 下午3:37
 */


function updateStateForRescue($rsid,$state)
{
    $dbObj = new DatabaseManager();
    $db = $dbObj->getConn();

    $querySql = <<< T_ECHO
    UPDATE sky_first_aid.rescue_scene_info SET state = $state, createDate = NOW() WHERE id = $rsid
T_ECHO;

    return $db->execute($querySql);

}


function checkUserHasRescueId($uid,$rsid){
    $dbObj = new DatabaseManager();
    $db = $dbObj->getConn();

    $querySql = <<< T_ECHO
    SELECT user_id FROM sky_first_aid.rescue_scene_info WHERE id = $rsid;
T_ECHO;

    $res = $db->getRow($querySql);

    return $res['user_id'] == $uid;

}

function getContentById($rsid)
{
    $dbObj = new DatabaseManager();
    $db = $dbObj->getConn();

    $querySql = <<< T_ECHO
    SELECT content FROM sky_first_aid.rescue_scene_info WHERE id = $rsid;
T_ECHO;

    $res = $db->getRow($querySql);
    return $res['content'];

}


function appendContentForRescue($rsid,$content)
{
    $dbObj = new DatabaseManager();
    $db = $dbObj->getConn();

    $querySql = <<< T_ECHO
    UPDATE sky_first_aid.rescue_scene_info SET content ="$content", createDate = NOW() WHERE id = $rsid
T_ECHO;

    return $db->execute($querySql);

}