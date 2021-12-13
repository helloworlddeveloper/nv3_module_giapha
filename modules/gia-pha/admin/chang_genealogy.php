<?php

	/**
	 * @Project NUKEVIET 3.0
	 * @Author VINADES.,JSC (contact@vinades.vn)
	 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
	 * @Createdate 2-10-2010 18:49
	 */

	if (!defined('NV_IS_FILE_ADMIN'))
		die('Stop!!!');
	if (!defined('NV_IS_AJAX'))
		die('Wrong URL');
	$gid = $nv_Request->get_int('gid', 'post', 0);
	$mod = $nv_Request->get_string('mod', 'post', '');
	$new_vid = $nv_Request->get_int('new_vid', 'post', 0);

	$content = "NO_" . $gid;

	$query = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` WHERE `gid`=" . $gid;
	$result = $db->sql_query($query);
	$numrows = $db->sql_numrows($result);
	if ($numrows != 1)
	{
		die('NO_' . $topicid);
	}
	$data = $db->sql_fetchrow($result);

	if ($mod == "weight" and $new_vid > 0)
	{
		$query = "SELECT `gid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` WHERE `gid`!=" . $gid . " ORDER BY `weight` ASC";
		$result = $db->sql_query($query);
		$weight = 0;
		while ($row = $db->sql_fetchrow($result))
		{
			$weight++;
			if ($weight == $new_vid)
				$weight++;
			$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` SET `weight`=" . $weight . " WHERE `gid`=" . intval($row['gid']);
			$db->sql_query($sql);
		}
		$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` SET `weight`=" . $new_vid . " WHERE `gid`=" . intval($gid);
		$db->sql_query($sql);
		$content = "OK_" . $gid;
	}
	elseif ($mod == "status" and $gid > 0)
	{
		$new_vid = (intval($new_vid) == 1) ? 1 : 0;
		if ($new_vid != $data['status'])
		{
			$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` SET `status`=" . $new_vid . " WHERE `gid`=" . intval($gid);
			$db->sql_query($sql);

			if ($new_vid)
			{
				$db->sql_query("UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_location` SET number = number+1 WHERE `locationid` =" . $data['locationid']);
			}
			else
			{
				$db->sql_query("UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_location` SET number = number-1 WHERE `locationid` =" . $data['locationid']);
			}
		}

		$content = "OK_" . $gid;
	}
	nv_del_moduleCache($module_name);

	include (NV_ROOTDIR . "/includes/header.php");
	echo $content;
	include (NV_ROOTDIR . "/includes/footer.php");
?>