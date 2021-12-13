<?php

	/**
	 * @Project NUKEVIET 3.0
	 * @Author VINADES.,JSC (contact@vinades.vn)
	 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
	 * @Createdate 4/12/2010, 1:27
	 */

	if (!defined('NV_IS_MOD_GIA_PHA'))
	{
		die('Stop!!!');
	}

	$url = array();
	$cacheFile = NV_ROOTDIR . "/" . NV_CACHEDIR . "/" . NV_LANG_DATA . "_" . $module_data . "_Sitemap.cache";
	$pa = NV_CURRENTTIME - 7200;

	if (($cache = nv_get_cache($cacheFile)) != false and filemtime($cacheFile) >= $pa)
	{
		$url = unserialize($cache);
	}
	else
	{
		$sql = "SELECT `alias`, `add_time` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` WHERE `status`=1 AND `who_view`=0 ORDER BY `add_time` DESC LIMIT 1000";
		$result = $db->sql_query($sql);
		$url = array();
		while (list($alias, $add_time) = $db->sql_fetchrow($result))
		{
			$url[] = array(//
				'link' => NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $alias, //
				'publtime' => $add_time);
		}

		$cache = serialize($url);
		nv_set_cache($cacheFile, $cache);
	}

	nv_xmlSitemap_generate($url);
	die();
?>