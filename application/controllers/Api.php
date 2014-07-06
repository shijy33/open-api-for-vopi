<?php
/**
 * File    application\controllers\Router.php
 * Desc    Api路由全流程处理模块
 * Manual  svn://svn.vop.com/api/manual/Controller/Router
 * version 1.1.2
 * User    duanchi <http://weibo.com/shijingye>
 * Date    2013-11-23
 * Time    17:38
 */

/**
 * @name    ApiController
 * @author  duanChi <http://weibo.com/shijingye>
 * @desc    API路由控制器
 * @see     http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class ApiController extends Yaf\Controller_Abstract {
	
	public function indexAction($_service = NULL, $_method = NULL, $_token = 'NO_TOKEN', $_datatype = DATA_TYPE_JSON) {

		$_REQUEST           = \Yaf\Registry::get('_REQUEST');
		$_APP              = \Yaf\Registry::get('_APP');
		$_API               = FALSE;
		$_API_PARAMETERS    = NULL;
		$_RESULT            = FALSE;
		$_RETURN_PACKEGE    = NULL;

		//AUTHORIZE START -->
		//授权, with service, method, token
		if ($_APP != FALSE && \Api\Authorize::authorize(
			$_REQUEST['api']['service'],
			$_REQUEST['api']['method'],
			$_APP['role']
		)) {
			//授权成功
		} else {
			throw new \Exception('PERMISSION_DENIED');
		}
		//AUTHORIZE END <--


		//API ROUTER START -->
		//路由到对应api from api_config_devel.ini

		$_API = \Api\Api::get($_REQUEST['api']['service'], $_REQUEST['api']['method'], $_REQUEST['api']['http_method']);

		if ($_API == FALSE || empty($_API)) {
			throw new \Exception('API_ROUTE_ERROR');
		}
		//API ROUTER END <--


		//API PROCESS START -->

		$_RESULT = \Api\Api::process($_API, $_REQUEST);

		//API PROCESS END <--

		//RESULT PACKAGE START -->
		//接口返回内容封装
		$_RETURN_PACKAGE = \Api\Api::package($_RESULT);
		//RESULT PACKAGE END <--

		//RETURN RESULT START -->
		return_package($_RETURN_PACKAGE, $_REQUEST['method']['return_type'], $_REQUEST['method']['callback']);
		//RESULT PACKAGE END <--

		var_dump(debug_backtrace());

		fastcgi_finish_request();

		//记录联调情况 -->
		//通过FASTCGI_FINISH_REQUEST 可以确认已经调用成功并且返回成功状态

		return FALSE;
	}
}
