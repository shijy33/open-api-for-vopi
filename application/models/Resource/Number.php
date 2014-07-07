<?php
namespace Resource;

class NumberModel {

	function __construct() {

	}

	function __destruct() {

	}

	public function put($_parameters = [], $_conf = []) {
		$_result = FALSE;
		$rpc_client = new \Rpc\PHPRpc\Client();
		$rpc_client->setProxy(NULL);
		$rpc_client->useService('http://www.phprpc.org/server.php');
		$rpc_client->setKeyLength(1024);
		$rpc_client->setEncryptMode(3);

		$result = $rpc_client->RegisterAccount('17090440005','FFFFFFFFFFFFFFFFFFF', 0, [], '史景烨', '北京', '010', '130xxxxxxxxxx');

		return $_result;
	}
}