<?php
/**
 * File    libraries\VOP\Process\Request.php
 * Desc    请求预处理模块
 * Manual  svn://svn.vop.com/api/manual/Plugin/Request
 * version 1.0.0
 * User    duanchi <http://weibo.com/shijingye>
 * Date    2013-11-23
 * Time    16:15
 */

namespace Api\Process;


class Request {

	/**
	 * Function pretreatment
	 * @param $_get
	 * @param $_post
	 * @param $_version
	 * @param $_scope
	 * @param $_interface
	 * @return array
	 */
	public static function pretreatment($_get = NULL, $_post = NULL, $_http_method = 'GET', $_mvc_params = NULL) {
		$_result = FALSE;

		if ($_mvc_params == NULL) {
			$_mvc_params = [
				'_service'      =>  NULL,
				'_method'       =>  NULL,
				'_datatype'     =>  DATA_TYPE_JSON
			];
		} else {
			switch($_mvc_params['_datatype']) {
				case 'jsonp' :
					$_mvc_params['_datatype'] = DATA_TYPE_JSONP;
					break;

				case 'msgpack' :
					$_mvc_params['_datatype'] = DATA_TYPE_MSGPACK;
					break;

				case 'json' :
				default:
					$_mvc_params['_datatype'] = DATA_TYPE_JSON;
					break;
			}

		}

		$_system = [];


		//IF $_POST -->
		$_post = $_POST;
		//$_POST END <--

		$_result = [
			'authorize'	    =>	[
				'appkey'       =>  NULL,
				'token'         =>	NULL,
				'ip'            =>	$_SERVER['REMOTE_ADDR'],
			],
			'api'	        =>	[
				'service'       =>  $_mvc_params['_service'],
				'method'        =>	$_mvc_params['_method'],
				'http_method'   =>  $_http_method,
				'datatype'      =>  $_mvc_params['_datatype']
			],
			'method'	    =>	[
				'request_method'=>	constant('HTTP_' . $_SERVER['REQUEST_METHOD']),
				'return_type'   =>  $_mvc_params['_datatype'],
				'callback'   =>  isset($_get['callback']) ? $_get['callback'] : NULL,
			],
			'parameters'	=>	[
				'system'        =>  $_system,
				'post'	        =>	$_post,
				'get'	        =>	$_get,
			],
			'system'        =>  $_system,
		];

		//GET TOKEN -->
		//token 由 mvc控制器中获取
		$_result['authorize']['token'] = (isset($_mvc_params['_token']) ? $_mvc_params['_token'] : NULL);
		//GET TOKEN END <--

		//CHECK PARAMETERS -->

		//[appkey] START -->

		$_result['authorize']['appkey'] = \Yaf\Registry::get('_APP')['appkey'];
		//[appkey] END <--

		//[token]


		if ($_result['method']['request_method'] == HTTP_POST){

		//[service] START -->
			if (($_result['api']['service'] == $_result['parameters']['get']['service']) && self::check_service($_result['api']['service'], 'service'));
			else {
				throw new \Exception('INVALID_SERVICE');
			}
		//[service] END <--

		//[method] START -->
			if (($_result['api']['method'] == $_result['parameters']['get']['method']) && self::check_service($_result['api']['method'], 'method'));
			else {
				throw new \Exception('INVALID_METHOD');
			}
		//[method] END <--
		}

		//CHECK PARAMETERS END <--

		return $_result;
	}

	private static function check_service($_name, $_type = 'service') {
		$_result = FALSE;
		$_conf = \Yaf\Registry::get('service');
		switch($_type) {

			case 'method':
				if (isset($_conf['method'][$_name]) && ($_conf['method'][$_name] == '1')) {
					$_result = TRUE;
				}
				break;

			case 'service':
			default:
			if (isset($_conf['service'][$_name]) && ($_conf['service'][$_name] == '1')) {
				$_result = TRUE;
			}
				break;
		}

		return $_result;
	}
}