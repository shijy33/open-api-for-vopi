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
		\Core\Rpc::add_server(new TestServer());
		\Core\Rpc::handle();
		/*$server = new \Core\Rpc\PHPRpc\Server();
		$server->add(new TestServer());
		$server->setCharset('UTF-8');
		$server->setDebugMode(FALSE);
		$server->start();
		*/

		return FALSE;
	}

	public function clientAction() {

		$service = [
			[
				['V0001'],
				['order1'],
				['order','targetnum','18618610010'],
			]

		];
		//{{{"V0001"},{"order1"},{"","",""}},{{"V0016"},{"order2"},{"order3","targetnum","18618610010"}}}
		var_dump($service);
		\Core\Rpc::add_client('http://192.168.20.50:8080/CTC/service/1234567');
		$_result = \Core\Rpc::call()->RegisterAccount('17090440005','FFFFFFFFFFFFFFFFFFF', 'FFFFFFFFFFFFFFFFFFFF', 'postpaid', $service, '史景烨', '北京', '010', '130xxxxxxxxxx');

		var_dump($_result);
		return FALSE;
	}

	public function etcAction() {
		var_dump(get_config('rpc'));
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