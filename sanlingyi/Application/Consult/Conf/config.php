<?php
return array(
	//'配置项'=>'配置值'
	'DB_TYPE'               =>  'mysqli',     // 数据库类型
    'DB_HOST'               =>  '117.34.72.251', // 服务器地址
    'DB_NAME'               =>  'yixin_duplicate',      // 数据库名
    'DB_USER'               =>  'rongke',      // 用户名
    'DB_PWD'                =>  'rongke',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
	'SHOW_PAGE_TRACE' =>false,
    'DB_PREFIX'             => 'bbs_',
	/* 图片上传相关配置 */
	//本地上传文件驱动配置
	'DOMAIN'=>'http://117.34.72.251:8081',
    'URL_HTML_SUFFIX'=>'',
	//分页数字
	'PAGE_NUM'=>10,
    'WEB_URL'=>'http://117.34.72.251:8081',  //图片文件地址
    'HISTORY_EMPIRE'=>3600*24*7,
    'IMG_HOST'=>'117.34.72.251',
    //路径
    'TMPL_PARSE_STRING'=>array(
        '__CSS__'=>__ROOT__ .'/Public/Consult/css',
        '__IMG__'=>__ROOT__ .'/Public/Consult/images',
        '__JS__'=>__ROOT__ .'/Public/Consult/js'
    )



);
