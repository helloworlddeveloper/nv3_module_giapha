<?php

/**
 * @Project NUKEVIET 3
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES., JSC. All rights reserved
 * @Createdate 24/8/2011 23:25
 */

if (!defined('NV_MAINFILE'))
    die('Stop!!!');

if (!nv_function_exists('nv_gia_pha_block_genealogy'))
{

    function nv_block_config_gia_pha_genealogy($module, $data_block, $lang_block)
    {
        global $db, $language_array;
        $sl0 = ($data_block['type'] == 0) ? ' selected="selected"' : '';
        $sl1 = ($data_block['type'] == 1) ? ' selected="selected"' : '';
        $sl2 = ($data_block['type'] == 2) ? ' selected="selected"' : '';
        $html = "";
        $html .= "<tr>";
        $html .= "	<td>Lấy các dòng họ</td>";
        $html .= "	<td>
					<select name=\"config_type\">
					<option value=\"0\"" . $sl0 . ">Sắp xếp hiển thị theo cấu hình trong admin</option>
					<option value=\"1\"" . $sl1 . ">Các dòng họ mới nhất</option>
					<option value=\"2\"" . $sl2 . ">Các dòng họ nhiều người nhất</option>
					</select>			
			</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "	<td>Số dòng họ</td>";
        $html .= "	<td><input type=\"text\" name=\"config_numrow\" size=\"5\" value=\"" . $data_block['numrow'] . "\"/></td>";
        $html .= "</tr>";
        return $html;
    }

    function nv_block_config_gia_pha_genealogy_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['type'] = $nv_Request->get_int('config_type', 'post', 0);
        $return['config']['numrow'] = $nv_Request->get_int('config_numrow', 'post', 0);
        return $return;
    }

    function nv_gia_pha_block_genealogy($block_config, $mod_file, $mod_data)
    {
        global $module_array_cat, $module_info, $lang_module, $db, $module_config, $user_info;

        $module = $block_config['module'];
        $type = $block_config['type'];

        $sql = "SELECT `fid`, `title`, `alias` FROM `" . NV_PREFIXLANG . "_" . $mod_data . "_family` ORDER BY `weight` ASC";
        $array_family = nv_db_cache($sql, 'fid', $module);

        $sql = "SELECT `locationid`, `title`, `number`, `alias` FROM `" . NV_PREFIXLANG . "_" . $mod_data . "_location` WHERE `parentid`=0 ORDER BY `weight` ASC";
        $array_location = nv_db_cache($sql, 'locationid', $module);

        $a = 1;
        if ($type == 1)
        {
            $orderbytype = "`gid` DESC";
        }
        elseif ($type == 1)
        {
            $orderbytype = "`number` DESC";
        }
        else
        {
            $orderbytype = "`weight` ASC";
        }

        if (defined('NV_IS_MODADMIN'))
        {
            $where_who_view = "";
        }
        elseif (defined('NV_IS_USER'))
        {
            $where_who_view = "AND (`who_view`=0 OR `who_view`=1 OR `userid`=" . $user_info['userid'] . ")";
        }
        else
        {
            $where_who_view = "AND `who_view`=0";
        }

        $sql = "SELECT `gid`, `fid`, `title`, `alias`, `locationid` FROM `" . NV_PREFIXLANG . "_" . $mod_data . "_genealogy` WHERE `status`=1 " . $where_who_view . " ORDER BY " . $orderbytype . " LIMIT 0 , " . $block_config['numrow'];
        $result = $db->sql_query($sql);

        if (file_exists(NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $mod_file . "/block_genealogy.tpl"))
        {
            $block_theme = $module_info['template'];
        }
        else
        {
            $block_theme = "default";
        }

        $xtpl = new XTemplate("block_genealogy.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $mod_file);

        while ($row = $db->sql_fetchrow($result))
        {
            $row['title'] = "Họ " . $array_family[$row['fid']]['title'] . ", " . $row['title'] . ", " . $array_location[$row['locationid']]['title'];
            $row['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module . "&amp;" . NV_OP_VARIABLE . "=" . $array_family[$row['fid']]['alias'] . "/" . $row['alias'];

            $row['class'] = ($a % 2 == 0) ? "second" : "";
            $xtpl->assign('DATA', $row);

            $xtpl->parse('main.loop');
            $a++;
        }
        $xtpl->parse('main');
        return $xtpl->text('main');
    }

}

if (defined('NV_SYSTEM'))
{
    global $site_mods, $module_name, $global_array_cat, $module_array_cat;
    $module = $block_config['module'];
    if (isset($site_mods[$module]))
    {
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
        $content = nv_gia_pha_block_genealogy($block_config, $mod_file, $mod_data);
    }
}
?>