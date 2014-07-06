<?php

class CmsModel {

	function __construct() {

	}

	function __destruct() {

	}

	public function cms_list($_params = []) {
		$_result = FALSE;

		$_sql = 'SELECT * FROM `shoubiaozhijia`.`pw_wt_cms` WHERE `isact` = 1 ORDER BY `cid` DESC LIMIT 30;';

		\DB::query($_sql);
		$_result = \DB::result_array();

		return $_result;
	}
}