<?php
/**
 * Created by PhpStorm.
 * User: lovemybud
 * Date: 14/7/8
 * Time: 22:17
 */

namespace Core;


class Rpc {
	protected static $_driver		    = 'Yar';

	private static $__client_instance   = [];
	private static $__server_instance   = [];

	public static function initialize() {
		$_config = get_config('rpc');

		self::$_driver = $_config['_config']['driver'];


	}

	public static function add_client($_server_uri, $_options = []) {
		$_client_flag = mk_rand_str(8);

		$_class = '\Core\Rpc\\'. self::$_driver . '\Client';
		self::$__client_instance[$_client_flag] = new $_class($_server_uri, $_options);

		if (!is_object(self::$__client_instance[$_client_flag])) return FALSE;
		else return $_client_flag;
	}

	public static function call($_client_flag = NULL) {
		if ($_client_flag == NULL) return reset(self::$__client_instance);
		return self::$__client_instance[$_client_flag];
	}

	public static function add_server() {

	}

	public static function handle(){

	}
} 