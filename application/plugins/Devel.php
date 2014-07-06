<?php
/* 
 * @todo 完善header信息写入
 */
class DevelPlugin extends Yaf\Plugin_Abstract {
	private $_config;
	private $_runtime;
	
	function __construct() {
		\Devel\Timespent::_init();
	}
	public function routerStartup(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
		if ($this->_config['start']) $this->_runtime->start();
	}

	public function routerShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
	}

	public function dispatchLoopStartup(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
	}

	public function preDispatch(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
	}

	public function postDispatch(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
	}

	public function dispatchLoopShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
		\Devel\Timespent::record();
	}
	
	public function preResponse(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
		
	}
}