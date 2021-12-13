<?php

	/**
	 * @Project NUKEVIET 3.0
	 * @Author VINADES.,JSC (contact@vinades.vn)
	 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
	 * @Createdate Sun, 17 Jul 2011 03:36:01 GMT
	 */

	if (!defined('NV_IS_FILE_ADMIN'))
		die('Stop!!!');

	$page_title = $lang_module['family'];

	$error = "";
	$savecat = 0;
	list($fid, $title, $alias, $description, $keywords) = array(0, "", "", "", "");

	$savecat = $nv_Request->get_int('savecat', 'post', 0);
	if (!empty($savecat))
	{
		$fid = $nv_Request->get_int('fid', 'post', 0);
		$title = filter_text_input('title', 'post', '', 1);
		$keywords = filter_text_input('keywords', 'post', '', 1);
		$alias = filter_text_input('alias', 'post', '');
		$description = $nv_Request->get_string('description', 'post', '');
		$description = nv_nl2br(nv_htmlspecialchars(strip_tags($description)), '<br />');
		$alias = ($alias == "") ? change_alias($title) : change_alias($alias);

		if (empty($title))
		{
			$error = $lang_module['error_name'];
		}
		elseif ($fid == 0)
		{
			list($weight) = $db->sql_fetchrow($db->sql_query("SELECT max(`weight`) FROM `" . NV_PREFIXLANG . "_" . $module_data . "_family`"));
			$weight = intval($weight) + 1;
			$query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_family` (`fid`, `status`, `title`, `alias`, `description`, `weight`, `keywords`, `add_time`, `edit_time`) VALUES (NULL, 1, " . $db->dbescape($title) . ", " . $db->dbescape($alias) . ", " . $db->dbescape($description) . ", " . $db->dbescape($weight) . ", " . $db->dbescape($keywords) . ", UNIX_TIMESTAMP( ), UNIX_TIMESTAMP( ))";
			if ($db->sql_query_insert_id($query))
			{
				$db->sql_freeresult();
				nv_del_moduleCache($module_name);
				Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "");
				die();
			}
			else
			{
				$error = $lang_module['errorsave'];
			}
		}
		else
		{
			$query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_family` SET `title`=" . $db->dbescape($title) . ", `alias` =  " . $db->dbescape($alias) . ", `description`=" . $db->dbescape($description) . ", `keywords`= " . $db->dbescape($keywords) . ", `edit_time`=UNIX_TIMESTAMP( ) WHERE `fid` =" . $fid . "";
			$db->sql_query($query);
			if ($db->sql_affectedrows() > 0)
			{
				$db->sql_freeresult();
				nv_del_moduleCache($module_name);
				Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "");
				die();
			}
			else
			{
				$error = $lang_module['errorsave'];
			}
			$db->sql_freeresult();
		}
	}

	$fid = $nv_Request->get_int('fid', 'get', 0);
	if ($fid > 0)
	{
		list($fid, $title, $alias, $description, $keywords) = $db->sql_fetchrow($db->sql_query("SELECT `fid`, `title`, `alias`, `description`, `keywords`  FROM `" . NV_PREFIXLANG . "_" . $module_data . "_family` where `fid`=" . $fid . ""));
		$lang_module['add_family'] = $lang_module['edit_family'];
	}

	$xtpl = new XTemplate($op . ".tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
	$xtpl->assign('LANG', $lang_module);
	$xtpl->assign('GLANG', $lang_global);
	$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
	$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
	$xtpl->assign('MODULE_NAME', $module_name);
	$xtpl->assign('OP', $op);

	$xtpl->assign('BLOCK_CAT_LIST', nv_show_family_list());

	$xtpl->assign('fid', $fid);
	$xtpl->assign('title', $title);
	$xtpl->assign('alias', $alias);
	$xtpl->assign('keywords', $keywords);
	$xtpl->assign('description', $description);

	if (!empty($error))
	{
		$xtpl->assign('ERROR', $error);
		$xtpl->parse('main.error');
	}

	if (empty($alias))
	{
		$xtpl->parse('main.getalias');
	}

	$xtpl->parse('main');
	$contents = $xtpl->text('main');

	include (NV_ROOTDIR . "/includes/header.php");
	echo nv_admin_theme($contents);
	include (NV_ROOTDIR . "/includes/footer.php");
?>