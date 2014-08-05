<?php
/**
 * File    application\plugin\Api.php
 * Desc    请求预处理插件模块
 * Manual  svn://svn.vop.com/api/manual/plugin/Process
 * version 1.0.0
 * User    duanchi <http://weibo.com/shijingye>
 * Date    2013-11-22
 * Time    20:36
 */

class AuthorizePlugin extends Yaf\Plugin_Abstract {

	public function routerStartup(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
	}

	public function routerShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {

		//PRETREATMENT REQUEST START -->
		if ($request->controller == 'Api') {
			//AUTHENTICATE START -->
			//应用认证,appkey,appsecret,ip,count from authorize_config.ini
			$_APP = \Process\AuthorizeModel::authenticate(
				(isset($request->getParams()['_token']) ? $request->getParams()['_token'] : NULL),
				$_SERVER['REMOTE_ADDR']
			);

			if (empty($_APP) || $_APP == FALSE) throw new \Exception('AUTHORIZE_FAILURE');
			\Yaf\Registry::set('_APP', $_APP);
			//AUTHENTICATE END <--

			\Yaf\Registry::set('_REQUEST', \Api\Process\Request::pretreatment($_GET, file_get_contents('php://input'), $request->method, $request->getParams()));
		}

		//PRETREATMENT REQUEST END <--

	}

	public function dispatchLoopStartup(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {

	}

	public function preDispatch(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {

	}

	public function postDispatch(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {

	}

	public function dispatchLoopShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {

	}

	public function preResponse(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {

	}

	function __destruct() {
	}
} 