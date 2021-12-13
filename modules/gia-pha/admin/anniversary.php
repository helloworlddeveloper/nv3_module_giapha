<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Sun, 17 Jul 2011 03:36:01 GMT
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');
$gid = $nv_Request->get_int('gid', 'post,get', 0);

$row_genealogy = $db->sql_fetchrow($db->sql_query("SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` where `gid`=" . $gid . ""));
if (empty($row_genealogy))
{
    Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name);
    die();
}

$id = $nv_Request->get_int('id', 'post,get', 0);
if ($id > 0)
{
    if ($nv_Request->isset_request('anniversary', 'post'))
    {
        $anniversary = filter_text_input('anniversary', 'post', '');
        $query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "` SET `anniversary`=" . $db->dbescape($anniversary) . " WHERE `id` =" . $id;
        if ($db->sql_query($query))
        {
            die("OK");
        }
        else
        {
            die("ERROR");
        }
    }
    else
    {
        $actanniversary = $nv_Request->get_int('actanniversary', 'post,get', 0);
        $actanniversary = ($actanniversary) ? 1 : 0;
        $row = $db->sql_fetchrow($db->sql_query("SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `id`=" . $id));
        if ($row['dieday'] == '0000-00-00 00:00:00' and $row['anniversary'] == '')
        {
            $actanniversary = 0;
        }
        $query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "` SET `actanniversary`=" . $actanniversary . " WHERE `id` =" . $id . "";
        $db->sql_query($query);
    }
}

$page_title = $lang_module['anniversary'] . ": " . $row_genealogy['title'];

$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `gid`=" . $gid . " AND `status`=0 ORDER BY `dieday` DESC, `anniversary` DESC";
$result = $db->sql_query($sql);
$num = $db->sql_numrows($result);
if ($num > 0)
{
    $xtpl = new XTemplate($op . ".tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GID', $gid);
    $xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
    $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('PAGE_TITLE', $page_title);
    $xtpl->assign('OP', $op);
    $number = 0;
    while ($row = $db->sql_fetchrow($result, 2))
    {
        $number++;
        $row['number'] = $number;
        $row['class'] = ($number % 2 == 0) ? ' class="second"' : '';
        $row['dieday_view'] = "";
        $row['show_anniversary'] = ($row['actanniversary']) ? 'checked="checked"' : '';
        $row['actanniversary'] = ($row['actanniversary']) ? 0 : 1;
        if ($row['dieday'] != "0000-00-00 00:00:00")
        {
            preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})/", $row['dieday'], $datetime);
            $row['dieday_view'] = $datetime[3] . "/" . $datetime[2] . "/" . $datetime[1];
        }
        elseif ($row['anniversary'] != "")
        {
            $row['dieday_view'] = $row['anniversary'];
        }
        else
        {
            $row['dieday_view'] = "";
        }

        $xtpl->assign('DATALOOP', $row);

        if ($row['dieday'] != "0000-00-00 00:00:00")
        {
            $xtpl->parse('main.loop.text');
        }
        else
        {
            $xtpl->parse('main.loop.input');
        }

        $xtpl->parse('main.loop');
    }
    $xtpl->parse('main');
    $contents = $xtpl->text('main');
}
else
{
    Header("Location: " . nv_url_rewrite(NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=genealogy_show&gid=" . $gid, true));
    exit();
}

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>