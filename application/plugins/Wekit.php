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

class WekitPlugin extends Yaf\Plugin_Abstract {

	public function routerShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {

		if ($request->controller == 'Api') {

            require \Yaf\Registry::get('config')->application->phpwind->wekit_bin;
            Wekit::init('phpwind');
            $application = Wind::application('phpwind', Wekit::S());

		}

	}
} 