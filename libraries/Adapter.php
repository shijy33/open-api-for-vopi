<?php
class Adapter {
	
	static protected $__instance = [];
	
	static public function init($class = '', $params = []) {
		self::$__instance[$class] = call_user_func_array([new ReflectionClass($class), 'newInstance'], $params);
	}
	
	static public function getInstance($class = '') {
		return self::$__instance[$class];
	}
	
	static public function destroy($class = '') {
		unset(self::$__instance[$class]);
	}
}