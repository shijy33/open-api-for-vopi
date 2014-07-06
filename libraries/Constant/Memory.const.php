<?php
/**
 * File    libraries\Constant\Memory.const.php
 * Desc    内存静态变量配置文件
 * Manual  svn://svn.vop.com/api/manual/Constant/Memory
 * version 1.0.1
 * User    duanchi <http://weibo.com/shijingye>
 * Date    2014-01-08
 * Time    14:56
 */
$_server_conf = parse_config(SERVICE_CONF_FILE_PATH);

\Yaf\Registry::set('service',$_server_conf);