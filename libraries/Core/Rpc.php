<?php
/**
 * Created by PhpStorm.
 * User: lovemybud
 * Date: 14/7/8
 * Time: 22:17
 */

namespace Core;


class Rpc {
	protected static $_driver_client    = 'Yar';
	protected static $_driver_server     = 'Yar';

	private static $__client_instance   = [];
	private static $__server_instance   = [];

	public static function initialize() {
		$_config = get_config('rpc');

		self::$_driver_client = $_config->get('driver')->client;
		self::$_driver_server = $_config->get('driver')->server;


	}

	public static function add_client($_server_uri, $_options = [], $_client_driver = NULL) {
		$_result = FALSE;
		$_client_flag = mk_rand_str(8);
		$_client_driver == NULL ? $_client_driver = self::$_driver_client : FALSE;

		$_class = '\Core\Rpc\\'. $_client_driver . '\Client';
		self::$__client_instance[$_client_flag] = new $_class($_server_uri, $_options);

		if (is_object(self::$__client_instance[$_client_flag])) $_result = $_client_flag;

		return $_result;
	}

	public static function call($_client_flag = NULL) {
		$_result = FALSE;

		if ($_client_flag == NULL) $_result = reset(self::$__client_instance);
		else $_result = self::$__client_instance[$_client_flag];

		return $_result;
	}

	public static function add_server($object, $_server_flag = NULL, $_server_driver = NULL) {
		$_result = FALSE;
		$_has_instance = FALSE;
		$_server_driver == NULL ? $_server_driver = self::$_driver_server : FALSE;

		if ($_server_flag == NULL) {
			$_server_flag = mk_rand_str(8);
		} else {
			$_has_instance = (array_key_exists($_server_flag, self::$__server_instance) ? TRUE : FALSE);
		}

		if ($_has_instance == FALSE) {
			$_class = '\Core\Rpc\\'. $_server_driver . '\Server';
			self::$__server_instance[$_server_flag] = new $_class($object);
			$_result = $_server_flag;
		}

		return $_result;
	}

	public static function handle($_server_flag = NULL){
		$_result = FALSE;

		if ($_server_flag == NULL) {
			foreach (self::$__server_instance as $_server) {
				$_server->handle();
			}
			$_result = TRUE;
		} else {
			$_result = self::$__server_instance[$_server_flag]->handle();
		}

		return $_result;
	}
} 