<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Sun, 17 Jul 2011 03:36:01 GMT
 */

if (!defined('NV_IS_MOD_GIA_PHA'))
    die('Stop!!!');

function nv_show_genealogy_list_us()
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op, $global_config, $user_info;
    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` WHERE `userid` =" . $user_info['userid'] . " ORDER BY `weight` ASC";
    $result = $db->sql_query($sql);
    $num = $db->sql_numrows($result);
    if ($num > 0)
    {
        $contents = "<table class=\"tab1\">\n";
        $contents .= "<thead>\n";
        $contents .= "<tr align=\"center\">\n";
        $contents .= "<td>" . $lang_module['name'] . "</td>\n";
        $contents .= "<td>" . $lang_module['who_view'] . "</td>\n";
        $contents .= "<td>" . $lang_module['status'] . "</td>\n";
        $contents .= "<td style=\"width:180px;\">" . $lang_module['function'] . "</td>\n";
        $contents .= "</tr>\n";
        $contents .= "</thead>\n";
        $a = 0;
        $array_status = array($lang_global['no'], $lang_global['yes']);
        $array_who_view = array(0 => $lang_module['who_view0'], 1 => $lang_module['who_view1'], 2 => $lang_module['who_view2']);
        while ($row = $db->sql_fetchrow($result))
        {
            $class = ($a % 2) ? " class=\"second\"" : "";
            $contents .= "<tbody" . $class . ">\n";
            $contents .= "<tr>\n";
            $contents .= "<td><a href=\"" . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=shows&amp;gid=" . $row['gid'] . "\">" . $row['title'] . "</a>";
            $contents .= " </td>\n";
            $contents .= "<td align=\"center\">" . $array_who_view[$row['who_view']] . "</td>\n";
            $contents .= "<td align=\"center\">" . $array_status[$row['status']] . "</td>\n";
            $contents .= "<td align=\"center\">";
            $contents .= "<span class=\"default_icon\"><a href=\"" . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=anniversary&amp;gid=" . $row['gid'] . "\">" . $lang_module['anniversary'] . "</a></span>\n";
            $contents .= "&nbsp;-&nbsp;<span class=\"edit_icon\"><a href=\"" . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=genealogy&amp;gid=" . $row['gid'] . "\">" . $lang_global['edit'] . "</a></span>\n";
            $contents .= "&nbsp;-&nbsp;<span class=\"delete_icon\"><a href=\"javascript:void(0);\" onclick=\"nv_del_genealogy(" . $row['gid'] . ", '" . md5($row['gid'] . session_id() . $global_config['sitekey']) . "')\">" . $lang_global['delete'] . "</a></span></td>\n";
            $contents .= "</tr>\n";
            $contents .= "</tbody>\n";
            $a++;
        }
        $contents .= "<tfooter>\n";
        $contents .= "<tr>\n";
        $contents .= "<td colspan=\"4\"><input type=\"button\" value=\"" . $lang_module['addnews'] . "\" onclick=\"window.location='" . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=genealogy'\" /></td>\n";
        $contents .= "</tr>\n";
        $contents .= "</tfooter>\n";
        $contents .= "</table>\n";
    }
    else
    {
        Header("Location: " . nv_url_rewrite(NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=genealogy", true));
        exit();
    }
    $db->sql_freeresult();
    return $contents;
}

if (defined('NV_IS_USER'))
{
    $gid = $nv_Request->get_int('delgid', 'get', 0);
    $checkss = $nv_Request->get_string('checkss', 'get', 0);
    if ($gid > 0 and md5($gid . session_id() . $global_config['sitekey']) == $checkss)
    {
        list($gid, $locationid, $status) = $db->sql_fetchrow($db->sql_query("SELECT `gid`,`locationid`, `status`  FROM `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` WHERE `gid`=" . intval($gid) . " AND `userid` =" . $user_info['userid']));
        if ($gid > 0)
        {
            $query = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` WHERE `gid`=" . $gid . "";
            if ($db->sql_query($query))
            {
                $db->sql_freeresult();

                $query = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_anniversary` WHERE `gid`=" . $gid . "";
                $db->sql_query($query);

                if ($status)
                {
                    $db->sql_query("UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_location` SET number = number-1 WHERE `locationid` =" . $locationid);
                }

                nv_fix_genealogy();
                nv_del_moduleCache($module_name);

                Header("Location: " . nv_url_rewrite(NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=manager", true));
                die();
            }
        }

    }

    $array_mod_title[] = array('title' => $module_info['funcs']['manager']['func_custom_name'], 'link' => NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=manager");

    $contents = nv_show_genealogy_list_us();
    $page_title = $module_info['custom_title'];
    $key_words = $module_info['keywords'];

    include (NV_ROOTDIR . "/includes/header.php");
    echo nv_site_theme($contents);
    include (NV_ROOTDIR . "/includes/footer.php");
}
else
{
    $redirect = "<meta http-equiv=\"Refresh\" content=\"2;URL=" . nv_url_rewrite(NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=users&" . NV_OP_VARIABLE . "=login&nv_redirect=" . nv_base64_encode($client_info['selfurl']), true) . "\" />";
    nv_info_die($lang_module['error_login_title'], $lang_module['error_login_title'], $lang_module['error_login_content'] . $redirect);
}
?>