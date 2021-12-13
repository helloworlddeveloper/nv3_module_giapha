<?php

	/**
	 * @Project NUKEVIET 3.0
	 * @Author VINADES.,JSC (contact@vinades.vn)
	 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
	 * @Createdate Sun, 17 Jul 2011 03:36:01 GMT
	 */

	if (!defined('NV_IS_FILE_ADMIN'))
		die('Stop!!!');

	function nv_viewdirtree_genealogy($parentid = 0)
	{
		global $array_data, $global_config, $module_file;

		$_dirlist = $array_data[$parentid];
		$content = "";
		foreach ($_dirlist as $_dir)
		{
			if ($_dir['relationships'] == 1)
			{
				switch ($_dir['gender'] )
				{
					case 1 :
						$_dir['class'] = 'class="male"';
						break;
					case 2 :
						$_dir['class'] = 'class="female"';
						break;
					default :
						$_dir['class'] = 'class="default"';
						break;
				}

				$xtpl = new XTemplate("genealogy_show.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
				if (isset($array_data[$_dir['id']]))
				{
					$_dirlist_wife = $array_data[$_dir['id']];
					foreach ($_dirlist_wife as $_dir_wife)
					{
						if ($_dir_wife['relationships'] != 1)
						{
							switch ($_dir_wife['gender'] )
							{
								case 1 :
									$_dir_wife['class'] = 'class="male noadd"';
									break;
								case 2 :
									$_dir_wife['class'] = 'class="female noadd"';
									break;
								default :
									$_dir_wife['class'] = 'class="default noadd"';
									break;
							}

							$xtpl->assign("WIFE", $_dir_wife);
							$xtpl->parse('tree.wife');
						}
					}

					$content2 = nv_viewdirtree_genealogy($_dir['id']);
					if (!empty($content2))
					{
						$xtpl->assign("TREE_CONTENT", $content2);
						$xtpl->parse('tree.tree_content.loop');
					}
					$xtpl->parse('tree.tree_content');
				}
				$xtpl->assign("DIRTREE", $_dir);
				$xtpl->parse('tree');
				$content .= $xtpl->text('tree');
			}
		}
		return $content;
	}

	function nv_viewdirtree_genealogy_delete($parentid = 0)
	{
		global $db, $array_data_delete, $module_data;

		if (isset($array_data_delete[$parentid]))
		{
			$_dirlist = $array_data_delete[$parentid];
			foreach ($_dirlist as $_dir)
			{
				nv_viewdirtree_genealogy_delete($_dir['id']);
			}
		}
		$db->sql_query("DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `id`=" . $parentid);
	}

	$gid = $nv_Request->get_int('gid', 'post,get', 0);
	$deleteid = $nv_Request->get_int('deleteid', 'post,get', 0);
	if ($deleteid > 0)
	{
		$array_data_delete = array();
		$query = "SELECT `id`, `parentid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `gid`=" . $gid . " ORDER BY `parentid`, `weight` ASC";
		$result = $db->sql_query($query);
		while ($row = $db->sql_fetchrow($result))
		{
			$array_data_delete[$row['parentid']][$row['id']] = $row;
		}
		$db->sql_freeresult();

		nv_viewdirtree_genealogy_delete($deleteid);

		list($number) = $db->sql_fetchrow($db->sql_query("SELECT  count(*) FROM `" . NV_PREFIXLANG . "_" . $module_data . "` where `gid`=" . $gid));
		$db->sql_query("UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` SET `number`=" . $number . " WHERE `gid` =" . $gid);

		nv_del_moduleCache($module_name);
	}

	$row_genealogy = $db->sql_fetchrow($db->sql_query("SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` where `gid`=" . $gid));
	if (empty($row_genealogy))
	{
		Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name);
		die();
	}

	$page_title = $lang_module['family'] . ": " . $row_genealogy['title'];
	$array_data = array();
	$query = "SELECT `id`, `parentid`, `weight`, `relationships`, `gender`, `status`, `full_name` FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `gid`=" . $gid . " ORDER BY `parentid`, `weight` ASC";
	$result = $db->sql_query($query);
	while ($row = $db->sql_fetchrow($result))
	{
		$array_data[$row['parentid']][$row['id']] = $row;
	}

	$xtpl = new XTemplate($op . ".tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
	$xtpl->assign('LANG', $lang_module);
	$xtpl->assign('GLANG', $lang_global);
	$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
	$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
	$xtpl->assign('MODULE_NAME', $module_name);
	$xtpl->assign('OP', $op);
	$xtpl->assign('GID', $gid);
	$xtpl->assign('PAGE_TITLE', $page_title);
	if (!empty($array_data))
	{
		$xtpl->assign('DATATREE', nv_viewdirtree_genealogy());
		$xtpl->parse('main.foldertree');
	}
	else
	{
		$xtpl->parse('main.create_users');
	}
	$xtpl->parse('main');
	$contents = $xtpl->text('main');

	include (NV_ROOTDIR . "/includes/header.php");
	echo nv_admin_theme($contents);
	include (NV_ROOTDIR . "/includes/footer.php");
?>