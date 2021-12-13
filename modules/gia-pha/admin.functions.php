<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Sun, 17 Jul 2011 03:36:01 GMT
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN'))
    die('Stop!!!');

$submenu['genealogy'] = $lang_module['genealogy'];
$submenu['location'] = $lang_module['location'];
$submenu['family'] = $lang_module['family'];
//$submenu['config'] = $lang_module['config'];

$allow_func = array('main', 'config', 'location', 'location_del', 'alias', 'change_status_location', 'change_weight_location', 'family', 'chang_family', 'list_family', 'del_family', 'genealogy', 'list_genealogy', 'chang_genealogy', 'del_genealogy', 'anniversary', 'genealogy_show', 'users');

define('NV_IS_FILE_ADMIN', true);

function nv_show_genealogy_list()
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` ORDER BY `weight` ASC";
    $result = $db->sql_query($sql);
    $num = $db->sql_numrows($result);
    if ($num > 0)
    {
        $contents = "<table class=\"tab1\">\n";
        $contents .= "<thead>\n";
        $contents .= "<tr>\n";
        $contents .= "<td style=\"width:50px;\">" . $lang_module['weight'] . "</td>\n";
        $contents .= "<td>" . $lang_module['name'] . "</td>\n";
        $contents .= "<td align=\"center\">" . $lang_module['add_time'] . "</td>\n";
        $contents .= "<td align=\"center\">" . $lang_module['status'] . "</td>\n";
        $contents .= "<td style=\"width:180px;\">" . $lang_module['function'] . "</td>\n";
        $contents .= "</tr>\n";
        $contents .= "</thead>\n";
        $a = 0;
        $array_status = array($lang_global['no'], $lang_global['yes']);
        while ($row = $db->sql_fetchrow($result))
        {
            $class = ($a % 2) ? " class=\"second\"" : "";
            $contents .= "<tbody" . $class . ">\n";
            $contents .= "<tr>\n";
            $contents .= "<td align=\"center\"><select id=\"id_weight_" . $row['gid'] . "\" onchange=\"nv_chang_genealogy('" . $row['gid'] . "','weight');\">\n";
            for ($i = 1; $i <= $num; $i++)
            {
                $contents .= "<option value=\"" . $i . "\"" . ($i == $row['weight'] ? " selected=\"selected\"" : "") . ">" . $i . "</option>\n";
            }
            $contents .= "</select></td>\n";

            $contents .= "<td><a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=genealogy_show&amp;gid=" . $row['gid'] . "\">" . $row['title'] . "</a>";

            $contents .= " </td>\n";
            $contents .= "<td align=\"center\">" . nv_date("H:i d/m/y", $row['add_time']) . "</a>";

            $contents .= "<td align=\"center\"><select id=\"id_status_" . $row['gid'] . "\" onchange=\"nv_chang_genealogy('" . $row['gid'] . "','status');\">\n";
            foreach ($array_status as $key => $val)
            {
                $contents .= "<option value=\"" . $key . "\"" . ($key == $row['status'] ? " selected=\"selected\"" : "") . ">" . $val . "</option>\n";
            }
            $contents .= "</select></td>\n";
            $contents .= "<td align=\"center\">";
            $contents .= "<span class=\"default_icon\"><a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=anniversary&amp;gid=" . $row['gid'] . "\">" . $lang_module['anniversary'] . "</a></span>\n";
            $contents .= "&nbsp;-&nbsp;<span class=\"edit_icon\"><a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=genealogy&amp;gid=" . $row['gid'] . "\">" . $lang_global['edit'] . "</a></span>\n";
            $contents .= "&nbsp;-&nbsp;<span class=\"delete_icon\"><a href=\"javascript:void(0);\" onclick=\"nv_del_genealogy(" . $row['gid'] . ")\">" . $lang_global['delete'] . "</a></span></td>\n";
            $contents .= "</tr>\n";
            $contents .= "</tbody>\n";
            $a++;
        }
        $contents .= "</table>\n";
    }
    else
    {
        $contents = "&nbsp;";
    }
    $db->sql_freeresult();
    return $contents;
}

function nv_fix_genealogy()
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
    $query = "SELECT `gid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` ORDER BY `weight` ASC";
    $weight = 0;
    $result = $db->sql_query($query);
    while ($row = $db->sql_fetchrow($result))
    {
        $weight++;
        $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` SET `weight`=" . $weight . " WHERE `gid`=" . intval($row['gid']);
        $db->sql_query($sql);
    }
    $db->sql_freeresult();
}

function nv_fix_genealogy_user($parentid)
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
    $query = "SELECT `id`, `relationships`  FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `parentid`=" . $parentid . " ORDER BY `weight` ASC";
    $weight1 = $weight2 = 0;
    $result = $db->sql_query($query);
    while ($row = $db->sql_fetchrow($result))
    {
        if ($row['relationships'] == 2)
        {
            $weight2++;
            $weight = $weight2;
        }
        else
        {
            $weight1++;
            $weight = $weight1;
        }
        $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "` SET `weight`=" . $weight . " WHERE `id`=" . intval($row['id']);
        $db->sql_query($sql);
    }
    $db->sql_freeresult();
}

function nv_fix_family()
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
    $query = "SELECT `fid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_family` ORDER BY `weight` ASC";
    $weight = 0;
    $result = $db->sql_query($query);
    while ($row = $db->sql_fetchrow($result))
    {
        $weight++;
        $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_family` SET `weight`=" . $weight . " WHERE `fid`=" . intval($row['fid']);
        $db->sql_query($sql);
    }
    $db->sql_freeresult();
}

function nv_fix_anniversary($gid)
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
    $query = "SELECT `id` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_anniversary` WHERE `gid`=" . $gid . " ORDER BY `weight` ASC";
    $weight = 0;
    $result = $db->sql_query($query);
    while ($row = $db->sql_fetchrow($result))
    {
        $weight++;
        $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_anniversary` SET `weight`=" . $weight . " WHERE `id`=" . intval($row['id']);
        $db->sql_query($sql);
    }
    $db->sql_freeresult();
}

function nv_fix_cu_location($parentid = 0, $order = 0, $lev = 0)
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
    $query = "SELECT `locationid`, `parentid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_location` WHERE `parentid`=" . $parentid . " ORDER BY `weight` ASC";
    $result = $db->sql_query($query);
    $array_cu_order = array();
    while ($row = $db->sql_fetchrow($result))
    {
        $array_cu_order[] = $row['locationid'];
    }
    $db->sql_freeresult();
    $weight = 0;
    if ($parentid > 0)
    {
        $lev++;
    }
    else
    {
        $lev = 0;
    }
    foreach ($array_cu_order as $cuid_i)
    {
        $order++;
        $weight++;
        $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_location` SET `weight`=" . $weight . ", `order`=" . $order . ", `lev`='" . $lev . "' WHERE `locationid`=" . intval($cuid_i);
        $db->sql_query($sql);
        $order = nv_fix_cu_location($cuid_i, $order, $lev);
    }
    $numlistcu = $weight;
    if ($parentid > 0)
    {
        $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_location` SET `numlistcu`=" . $numlistcu;
        if ($numlistcu == 0)
        {
            $sql .= ",`listcu`='' ";
        }
        else
        {
            $sql .= ",`listcu`='" . implode(",", $array_cu_order) . "'";
        }
        $sql .= " WHERE `locationid`=" . intval($parentid);
        $db->sql_query($sql);
    }
    return $order;
}

function nv_show_family_list()
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_family` ORDER BY `weight` ASC";
    $result = $db->sql_query($sql);
    $num = $db->sql_numrows($result);
    if ($num > 0)
    {
        $contents = "<table class=\"tab1\">\n";
        $contents .= "<thead>\n";
        $contents .= "<tr>\n";
        $contents .= "<td style=\"width:50px;\">" . $lang_module['weight'] . "</td>\n";
        $contents .= "<td>" . $lang_module['name'] . "</td>\n";
        $contents .= "<td align=\"center\">" . $lang_module['status'] . "</td>\n";
        $contents .= "<td style=\"width:100px;\"></td>\n";
        $contents .= "</tr>\n";
        $contents .= "</thead>\n";
        $a = 0;
        $array_status = array($lang_global['no'], $lang_global['yes']);
        while ($row = $db->sql_fetchrow($result))
        {
            $class = ($a % 2) ? " class=\"second\"" : "";
            $contents .= "<tbody" . $class . ">\n";
            $contents .= "<tr>\n";
            $contents .= "<td align=\"center\"><select id=\"id_weight_" . $row['fid'] . "\" onchange=\"nv_chang_family('" . $row['fid'] . "','weight');\">\n";
            for ($i = 1; $i <= $num; $i++)
            {
                $contents .= "<option value=\"" . $i . "\"" . ($i == $row['weight'] ? " selected=\"selected\"" : "") . ">" . $i . "</option>\n";
            }
            $contents .= "</select></td>\n";
            list($numnews) = $db->sql_fetchrow($db->sql_query("SELECT count(*)  FROM `" . NV_PREFIXLANG . "_" . $module_data . "_block` where `fid`=" . $row['fid'] . ""));
            if ($numnews)
            {
                $contents .= "<td><a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=main&amp;fid=" . $row['fid'] . "\">" . $row['title'] . " ($numnews " . $lang_module['topic_num_news'] . ")</a>";
            }
            else
            {
                $contents .= "<td><a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=main&amp;fid=" . $row['fid'] . "\">" . $row['title'] . "</a>";
            }
            $contents .= " </td>\n";
            $contents .= "<td align=\"center\"><select id=\"id_status_" . $row['fid'] . "\" onchange=\"nv_chang_family('" . $row['fid'] . "','status');\">\n";
            foreach ($array_status as $key => $val)
            {
                $contents .= "<option value=\"" . $key . "\"" . ($key == $row['status'] ? " selected=\"selected\"" : "") . ">" . $val . "</option>\n";
            }
            $contents .= "</select></td>\n";
            $contents .= "<td align=\"center\"><span class=\"edit_icon\"><a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;fid=" . $row['fid'] . "#edit\">" . $lang_global['edit'] . "</a></span>\n";
            $contents .= "&nbsp;-&nbsp;<span class=\"delete_icon\"><a href=\"javascript:void(0);\" onclick=\"nv_del_family(" . $row['fid'] . ")\">" . $lang_global['delete'] . "</a></span></td>\n";
            $contents .= "</tr>\n";
            $contents .= "</tbody>\n";
            $a++;
        }
        $contents .= "</table>\n";
    }
    else
    {
        $contents = "&nbsp;";
    }
    $db->sql_freeresult();
    return $contents;
}
?>