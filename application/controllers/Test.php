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
class TestController extends Yaf\Controller_Abstract {
	
	public function indexAction($_action = NULL) {
		$_action .= 'Action';
		return $this->$_action();
	}

	public function requestAction() {
		var_dump($this->getRequest());
		return FALSE;
	}

	public function modelAction() {
		$_model_handler = new \Resource\NumberModel();
		var_dump($_model_handler->put());
		return FALSE;
	}

	public function rpcAction() {
		$server = new \Rpc\PHPRpc\Server();
		$server->add('RegisterAccount', new TestServer());
		$server->setCharset('UTF-8');
		$server->setDebugMode(FALSE);
		$server->start();

		return FALSE;
	}

	public function clientAction() {
		$rpc_client = new \Rpc\PHPRpc\Client();
		$rpc_client->setProxy(NULL);
		$rpc_client->useService('http://api.cu-dev.devel/test/rpc');
		$rpc_client->setKeyLength(1024);
		$rpc_client->setEncryptMode(3);

		$result = $rpc_client->RegisterAccount('17090440005','FFFFFFFFFFFFFFFFFFF', 0, [], '史景烨', '北京', '010', '130xxxxxxxxxx');

		var_dump($result);
		return FALSE;
	}
}

class TestServer {
	public function RegisterAccount($_sPhoneNumber, $_sImsi, $_sIccid, $_sUserProperty, $_sService, $_sName, $_sAddress, $_sCertTypeCode, $_sCertCode) {

		return [
			'status'    =>  TRUE,
			'code'      =>  200,
		];

	}
}