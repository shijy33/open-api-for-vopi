<?php
/**
 * File    libraries\Constant\Basic.const.php
 * Desc    基础静态变量配置文件
 * Manual  svn://svn.vop.com/api/manual/Constant/Basic
 * version 1.0.1
 * User    duanchi <http://weibo.com/shijingye>
 * Date    2013-11-23
 * Time    22:06
 */

/*
 * HTTP MEHOD CODE
 */
define(   'HTTP_GET', 8001); //HTTP GET 请求
define(  'HTTP_POST', 8002); //HTTP POST 请求
define(  'HTTP_HEAD', 8003); //HTTP HEAD 请求
define(   'HTTP_PUT', 8004); //HTTP PUT 请求
define('HTTP_DELETE', 8005); //HTTP DELETE 请求

/*
 * RPC METHOD CODE
 */
define( 'RPC_SYNC', 9001); //RPC 同步接口请求
define('RPC_ASYNC', 9002); //RPC 异步接口请求

/*
 * DATA TYPE CODE
 */
define(    'DATA_TYPE_JSON', 7001);
define(   'DATA_TYPE_JSONP', 7002);
define( 'DATA_TYPE_MSGPACK', 7003);



/*
 * MEM DB CODE
 */
define(    'MEM_DB_EXCEPTION', 0);
define(       'MEM_DB_SERIAL', 1);
define(         'MEM_DB_DUMP', 2);
define(         'MEM_DB_CONF', 3);
define(       'MEM_DB_RECORD', 4);


$_conf = \Yaf\Registry::get('config')->get('application')->constant;
define(         'API_CONF_FILE_PATH', $_conf->api_conf_file_path         );
define(        'APP_CONF_FILE_PATH', $_conf->app_conf_file_path        );
define( 'APPSECRET_CONF_FILE_PATH', $_conf->appsecret_conf_file_path );
define('MESSAGE_CODE_CONF_FILE_PATH', $_conf->message_code_conf_file_path);
define(     'SERVICE_CONF_FILE_PATH', $_conf->service_conf_file_path     );

$_conf = \Yaf\Registry::get('config')->get('api');
_app_define($_conf->application);
_app_define($_conf->authorize  );

unset($_conf);
function _app_define($_array = []) {
	foreach ($_array as $k => $v) define('API_'.strtoupper($k), $v);
}