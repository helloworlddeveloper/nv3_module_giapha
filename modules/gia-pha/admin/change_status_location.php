<?php

	/**
	 * @Project NUKEVIET 3.0
	 * @Author VINADES.,JSC (contact@vinades.vn)
	 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
	 * @Createdate 2-10-2010 18:49
	 */

	if (!defined('NV_IS_FILE_ADMIN'))
		die('Stop!!!');
	$cuid = $nv_Request->get_int('cuid', 'post', 0);
	$parentid = $nv_Request->get_int('parentid', 'post', 0);

	if (empty($cuid))
		die("NO_" . $cuid);
	$query = "SELECT `status` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_location` WHERE `locationid`=" . $cuid . " AND `parentid`=" . $parentid;
	$result = $db->sql_query($query);
	$numrows = $db->sql_numrows($result);
	if ($numrows != 1)
		die('NO_' . $catid);

	$new_status = $nv_Request->get_bool('new_status', 'post');
	$new_status = (int)$new_status;

	$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_location` SET `status`=" . $new_status . " WHERE `locationid`=" . $cuid . " AND `parentid`=" . $parentid;
	if ($db->sql_query($sql))
	{
		nv_del_moduleCache($module_name);
		die("OK");
	}
?>
