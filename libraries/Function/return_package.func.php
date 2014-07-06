<?php
/**
 * File    libraries\Function\pre_process_request.func.php
 * Desc    请求预处理函数
 * Manual  svn://svn.vop.com/api/manual/Function/pre_process_request
 * version 1.0.0
 * User    duanchi <http://weibo.com/shijingye>
 * Date    2013-11-12
 * Time    17:55
 */

function return_package($_object = NULL, $_data_type = DATA_TYPE_JSON, $_callback = NULL) {
	$_result = NULL;

	switch($_data_type) {
		case DATA_TYPE_JSONP:
			$_result = ($_callback == NULL ? '' : $_callback) .'('.json_encode($_object, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE).');';
			break;

		case DATA_TYPE_MSGPACK:
			$_result = msgpack_pack($_object);
			break;

		case DATA_TYPE_JSON:
		default:
		$_result = json_encode($_object, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
			break;
	}

	echo $_result;
}