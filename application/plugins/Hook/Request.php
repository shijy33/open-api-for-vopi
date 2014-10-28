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
namespace Hook;

class RequestPlugin extends \Yaf\Plugin_Abstract {

	public function routerShutdown(\Yaf\Request_Abstract $request, \Yaf\Response_Abstract $response) {

		//PRETREATMENT REQUEST START -->
		if ($request->controller == 'Api') {

            \Core\KEY::set('_REQUEST', \Process\RequestModel::get($request->method, $request->getParams()));

            \Core\KEY::set('_IS_AUTHORIZED', FALSE);

        }
		//PRETREATMENT REQUEST END <--

	}
} 