<?php
function get_config ($_scope = NULL) {
	$_result = ($_scope == NULL) ? Yaf\Registry::get('config') : \Yaf\Registry::get('config')->get($_scope);
	return $_result;
}