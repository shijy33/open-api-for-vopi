<?php
namespace User;

class ProfileModel {

	function __construct() {

	}

	function __destruct() {

	}

	public function get($_parameters = [], $_conf = []) {
		$_result = FALSE;

		\Core\Rpc::add_client($_conf['rpc_uri'].'?'.$_conf['rpc_secret']);
		$_result = \Core\Rpc::call()->RegisterAccount('17090440005','FFFFFFFFFFFFFFFFFFF', 0, [], '史景烨', '北京', '010', '130xxxxxxxxxx');

		return $_result;
	}
}