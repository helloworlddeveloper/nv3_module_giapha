<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Sun, 17 Jul 2011 03:36:01 GMT
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');
$post = array('description' => '', 'rule' => '', 'content' => '', 'status' => 1, 'who_view' => 0);

if ($nv_Request->get_string('submit', 'post') != "")
{
    $post['gid'] = $nv_Request->get_int('gid', 'post', 0);

    $post['title'] = filter_text_input('title', 'post', '', 1);
    $post['fid'] = $nv_Request->get_int('fid', 'post', 0);

    $post['locationid'] = $nv_Request->get_int('locationid', 'post', 0);

    $post['description'] = $nv_Request->get_string('description', 'post', '');
    $post['description'] = defined('NV_EDITOR') ? nv_nl2br($post['description'], '') : nv_nl2br(nv_htmlspecialchars(strip_tags($post['description'])), '<br />');

    $post['rule'] = $nv_Request->get_string('rule', 'post', '');
    $post['rule'] = defined('NV_EDITOR') ? nv_nl2br($post['rule'], '') : nv_nl2br(nv_htmlspecialchars(strip_tags($post['rule'])), '<br />');

    $post['content'] = $nv_Request->get_string('content', 'post', '');
    $post['content'] = defined('NV_EDITOR') ? nv_nl2br($post['content'], '') : nv_nl2br(nv_htmlspecialchars(strip_tags($post['content'])), '<br />');

    $post['status'] = ( int )$nv_Request->get_bool('status', 'post');
    $post['who_view'] = $nv_Request->get_int('who_view', 'post', 0);

    $post['years'] = filter_text_input('years', 'post', '', 1);
    $post['author'] = filter_text_input('author', 'post', '', 1);
    $post['full_name'] = filter_text_input('full_name', 'post', '', 1);
    $post['telephone'] = filter_text_input('telephone', 'post', '', 1);
    $post['email'] = filter_text_input('email', 'post', '', 1);

    if (!empty($post['title']) and $post['locationid'] > 0)
    {
        $post['alias'] = change_alias($post['title']);
        $post['userid'] = $admin_info['admin_id'];
        if (empty($post['gid']))
        {
            $weight = 0;
            $post['gid'] = $db->sql_query_insert_id("INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` 
					(`gid`, `title`, `alias`, `weight`, `add_time`, `edit_time`, `userid`, `fid`, `locationid`, `description`, `rule`, `content`, `status`, `number`, `years`, `author`, `full_name`, `telephone`, `email`, `who_view`) 
            		VALUES 
            		(NULL, " . $db->dbescape_string($post['title']) . ", " . $db->dbescape_string($post['alias']) . ", '" . $weight . "', '" . NV_CURRENTTIME . "', '" . NV_CURRENTTIME . "', '" . $post['userid'] . "', '" . $post['fid'] . "', '" . $post['locationid'] . "', " . $db->dbescape_string($post['description']) . ", " . $db->dbescape_string($post['rule']) . ", " . $db->dbescape_string($post['content']) . ", '" . $post['status'] . "', 0, " . $db->dbescape_string($post['years']) . ", " . $db->dbescape_string($post['author']) . ", " . $db->dbescape_string($post['full_name']) . ", " . $db->dbescape_string($post['telephone']) . ", " . $db->dbescape_string($post['email']) . ", " . $db->dbescape_string($post['who_view']) . ")");

            if ($post['gid'] > 0)
            {
                if ($post['status'])
                {
                    $db->sql_query("UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_location` SET number = number+1 WHERE `locationid` =" . $post['locationid']);
                }
                nv_fix_genealogy();
                nv_del_moduleCache($module_name);

                Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name);
                die();
            }

        }
        else
        {
            $post_old = $db->sql_fetchrow($db->sql_query("SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` WHERE gid=" . $post['gid']));
            $db->sql_freeresult();
            $update = $db->sql_query("UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` SET 
				`title`=" . $db->dbescape_string($post['title']) . ", 
				`alias`=" . $db->dbescape_string($post['alias']) . ", 
				`edit_time` = " . NV_CURRENTTIME . ", 
				`fid`=" . $post['fid'] . ", 
				`locationid`=" . $post['locationid'] . ",
				`description` =" . $db->dbescape_string($post['description']) . ", 
				`rule` =" . $db->dbescape_string($post['rule']) . ", 
				`content`=" . $db->dbescape_string($post['content']) . ", 
				`status`  =" . $post['status'] . ", 
				`years`=" . $db->dbescape_string($post['years']) . ", 
				`author`=" . $db->dbescape_string($post['author']) . ", 
				`full_name`=" . $db->dbescape_string($post['full_name']) . ", 
				`telephone`=" . $db->dbescape_string($post['telephone']) . ", 
				`email`=" . $db->dbescape_string($post['email']) . ", 
				`who_view`=" . $db->dbescape_string($post['who_view']) . " 
			WHERE `gid` =" . $post['gid']);
            if ($update)
            {
                if ($post['status'] != $post_old['status'] and $post['locationid'] == $post_old['locationid'])
                {
                    if ($post['status'])
                    {
                        $db->sql_query("UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_location` SET number = number+1 WHERE `locationid` =" . $post['locationid']);
                    }
                    else
                    {
                        $db->sql_query("UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_location` SET number = number-1 WHERE `locationid` =" . $post['locationid']);
                    }
                }
                elseif ($post['status'] == $post_old['status'] and $post['status'] == 1 and $post['locationid'] != $post_old['locationid'])
                {
                    $db->sql_query("UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_location` SET number = number+1 WHERE `locationid` =" . $post['locationid']);
                    $db->sql_query("UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_location` SET number = number-1 WHERE `locationid` =" . $post_old['locationid']);
                }
                elseif ($post['status'] == 1 and $post_old['status'] == 0 and $post['locationid'] != $post_old['locationid'])
                {
                    $db->sql_query("UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_location` SET number = number+1 WHERE `locationid` =" . $post['locationid']);
                }
                elseif ($post['status'] == 0 and $post_old['status'] == 1 and $post['locationid'] != $post_old['locationid'])
                {
                    $db->sql_query("UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_location` SET number = number-1 WHERE `locationid` =" . $post_old['locationid']);
                }

                nv_del_moduleCache($module_name);

                Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name);
                die();
            }
        }
    }
}
else
{
    $post['fid'] = 190;
    $post['locationid'] = 0;
    $post['gid'] = $nv_Request->get_int('gid', 'get', 0);
    if ($post['gid'] > 0)
    {
        $post = $db->sql_fetchrow($db->sql_query("SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` WHERE gid=" . $post['gid']));
        if (empty($post))
        {
            Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name);
        }
    }
}
if (defined('NV_EDITOR'))
{
    require_once (NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php');
}

$xtpl = new XTemplate($op . ".tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_family` ORDER BY `weight` ASC";
$result = $db->sql_query($sql);
while ($row = $db->sql_fetchrow($result))
{
    $row['selected'] = ($row['fid'] == $post['fid']) ? ' selected="selected"' : '';
    $xtpl->assign('FAMILY', $row);
    $xtpl->parse('main.family');
}

$sql = "SELECT `locationid`, `title` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_location` WHERE `parentid`=0 ORDER BY `weight` ASC";
$result = $db->sql_query($sql);
while ($row = $db->sql_fetchrow($result))
{
    $row['selected'] = ($row['locationid'] == $post['locationid']) ? ' selected="selected"' : '';
    $xtpl->assign('LOCATION', $row);
    $xtpl->parse('main.location');
}

if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor'))
{
    $post['description'] = nv_aleditor('description', '100%', '200px', $post['description']);
    $post['rule'] = nv_aleditor('rule', '100%', '200px', $post['rule']);
    $post['content'] = nv_aleditor('content', '100%', '200px', $post['content']);
}
else
{
    $post['description'] = "<textarea style=\"width: 100%\" name=\"description\" cols=\"20\" rows=\"15\">" . $post['description'] . "</textarea>";
    $post['rule'] = "<textarea style=\"width: 100%\" name=\"rule\" cols=\"20\" rows=\"15\">" . $post['rule'] . "</textarea>";
    $post['content'] = "<textarea style=\"width: 100%\" name=\"rule\" cols=\"20\" rows=\"15\">" . $post['content'] . "</textarea>";
}
$post['status_checked'] = ($post['status']) ? ' checked="checked"' : '';

$array_who_view = array(0 => $lang_global['who_view0'], 1 => $lang_global['who_view1'], 2 => $lang_module['who_view2']);
foreach ($array_who_view as $key => $value)
{
    $row = array('id' => $key, 'title' => $value, 'selected' => ($key == $post['who_view']) ? ' selected="selected"' : '');

    $xtpl->assign('WHO_VIEW', $row);
    $xtpl->parse('main.who_view');
}
$xtpl->assign('DATA', $post);

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['main'];

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>