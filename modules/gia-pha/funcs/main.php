<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Sun, 17 Jul 2011 03:36:01 GMT
 */

if (!defined('NV_IS_MOD_GIA_PHA'))
    die('Stop!!!');

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];
if (isset($array_op[1]))
{
    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` WHERE `alias`=" . $db->dbescape($array_op[1]) . " AND `status`=1";
    $result = $db->sql_query($sql);
    if ($db->sql_numrows($result) == 1)
    {
        $row_genealogy = $db->sql_fetchrow($result, 2);
        $family_alias = $array_family[$row_genealogy['fid']]['alias'];
        if ($family_alias != $array_op[0])
        {
            trigger_error("erorr url", 256);
        }
        // Kiểm tra quyền hạn được xem
        $who_view = ( string )$row_genealogy['who_view'];

        $check_who_view = ($who_view == "0" or ($who_view == "1" and defined('NV_IS_USER')) or ($who_view == "2" and defined('NV_IS_MODADMIN'))) ? true : false;

        if (!$check_who_view)
        {
            $check_is_us = (defined('NV_IS_USER') and $row_genealogy['userid'] == $user_info['userid']) ? true : false;
            if (!$check_is_us)
            {
                $redirect = "<meta http-equiv=\"Refresh\" content=\"3;URL=" . nv_url_rewrite(NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name, true) . "\" />";
                nv_info_die($lang_module['error_who_view_title'], $lang_module['error_who_view_title'], $lang_module['error_who_view_content'] . $redirect);
            }
        }
        $row_genealogy = nv_menu_gia_pha($row_genealogy);
        $array_mod_title[] = array('title' => $row_genealogy['title'], 'link' => $row_genealogy['link_main']);

        if (isset($array_op[2]))
        {
            if ($array_op[2] == "pha-ky")
            {
                $contents = nv_theme_gia_pha_pha_ky($row_genealogy);
            }
            elseif ($array_op[2] == "pha-do")
            {
                // Phả đồ
                $array_data = array();
                $query = "SELECT `id`, `parentid`, `weight`, `relationships`, `gender`, `status`, `alias`, `full_name`, `lev` FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `gid`=" . $row_genealogy['gid'] . " ORDER BY `parentid` ASC, `weight`, `id` ASC";
                $result = $db->sql_query($query);
                while ($row = $db->sql_fetchrow($result))
                {
                    $row['link'] = $row_genealogy['link_main'] . '/' . $row['alias'];
                    $array_data[$row['parentid']][$row['id']] = $row;
                }
                $contents = nv_theme_gia_pha_genealogy($row_genealogy, $array_data);
            }
            elseif ($array_op[2] == "toc-uoc")
            {
                $contents = nv_theme_gia_pha_toc_uoc($row_genealogy);
            }
            elseif ($array_op[2] == "huong-hoa")
            {
                $contents = nv_theme_gia_pha_huong_hoa($row_genealogy);
            }
            elseif ($array_op[2] == "ngay-gio")
            {
                // Danh sách ngày giỗ
                $array_anniversary = array();
                $sql = "SELECT `full_name`, `anniversary`, `dieday` FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `gid`=" . $row_genealogy['gid'] . " AND `status`=0 AND `actanniversary`=1 ORDER BY `dieday`, `anniversary` ASC";
                $result = $db->sql_query($sql);
                while ($row = $db->sql_fetchrow($result, 2))
                {
                    if ($row['dieday'] != "0000-00-00 00:00:00")
                    {
                        preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})/", $row['dieday'], $datetime);
                        $row['date'] = $datetime[3] . "/" . $datetime[2];
                    }
                    elseif ($row['anniversary'] != "")
                    {
                        $row['date'] = $row['anniversary'];
                    }

                    $array_anniversary[] = $row;
                }
                $contents = nv_theme_gia_pha_anniversary($row_genealogy, $array_anniversary);
            }
            else
            {
                $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `gid`=" . $row_genealogy['gid'] . " AND `alias`=" . $db->dbescape($array_op[2]);
                $row_genealogy['link_xuat_pdf'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=exportpdf/chitiet/" . $row_genealogy['alias'] . "/" . $array_op[2];
                $result = $db->sql_query($sql);
                if ($db->sql_numrows($result) == 1)
                {
                    $row_detail = $db->sql_fetchrow($result, 2);

                    if ($row_detail['image'] != "" and file_exists(NV_UPLOADS_REAL_DIR . "/" . $module_name . "/" . $row_detail['image']))
                    {
                        $row_detail['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" . $row_detail['image'];
                    }
                    else
                    {
                        $row_detail['image'] = NV_BASE_SITEURL . 'themes/' . $module_info['template'] . '/images/' . $module_info['module_file'] . '/no-images.jpg';
                    }
                    $lang_module['u_burial'] = ($row_detail['status'] == 0) ? $lang_module['u_burial'] : $lang_module['u_address'];

                    $array_relationships = array(1 => $lang_module['u_relationships_1'], 2 => $lang_module['u_relationships_2'], 3 => $lang_module['u_relationships_3']);
                    $array_gender = array(0 => $lang_module['u_gender_0'], 1 => $lang_module['u_gender_1'], 2 => $lang_module['u_gender_2']);
                    $array_status = array(0 => $lang_module['u_status_0'], 1 => $lang_module['u_status_1'], 2 => $lang_module['u_status_2']);

                    $array_parentid = array();
                    //Danh sách anh em
                    if ($row_detail['relationships'] == 1)
                    {
                        $query = "SELECT `id`, `parentid`, `weight`, `relationships`, `gender`, `status`, `alias`, `full_name`, `birthday`  FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `gid`=" . $row_detail['gid'] . " AND `parentid`=" . $row_detail['parentid'] . " AND `id`!=" . $row_detail['id'] . " AND `relationships` NOT IN(2,3) ORDER BY `weight` ASC";
                        $result = $db->sql_query($query);
                        if ($db->sql_numrows($result))
                        {
                            $array_parentid[0]['caption'] = $lang_module['list_parentid_0'];
                            while ($row = $db->sql_fetchrow($result, 2))
                            {
                                $row['link'] = $row_genealogy['link_main'] . '/' . $row['alias'];
                                if ($row['birthday'] != '0000-00-00 00:00:00')
                                {
                                    preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})/", $row['birthday'], $datetime);
                                    $row['birthday'] = $datetime[3] . "/" . $datetime[2] . "/" . $datetime[1];
                                }
                                else
                                {
                                    $row['birthday'] = "";
                                }
                                $row['status'] = $array_status[$row['status']];
                                $array_parentid[0]['items'][] = $row;
                            }
                        }
                    }

                    //Danh sách con cái
                    $query = "SELECT `id`, `parentid`, `weight`, `relationships`, `gender`, `status`, `alias`, `full_name`, `birthday` FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `gid`=" . $row_detail['gid'] . " AND `parentid`=" . $row_detail['id'] . " AND `relationships`=1 ORDER BY `weight` ASC";
                    $result = $db->sql_query($query);
                    if ($db->sql_numrows($result))
                    {
                        $array_parentid[1]['caption'] = $lang_module['list_parentid_1'];
                        while ($row = $db->sql_fetchrow($result, 2))
                        {
                            $row['link'] = $row_genealogy['link_main'] . '/' . $row['alias'];
                            if ($row['birthday'] != '0000-00-00 00:00:00')
                            {
                                preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})/", $row['birthday'], $datetime);
                                $row['birthday'] = $datetime[3] . "/" . $datetime[2] . "/" . $datetime[1];
                            }
                            else
                            {
                                $row['birthday'] = "";
                            }
                            $row['status'] = $array_status[$row['status']];
                            $array_parentid[1]['items'][] = $row;
                        }
                    }

                    //Danh sách vợ
                    if ($row_detail['gender'] == 1)
                    {
                        $query = "SELECT `id`, `parentid`, `weight`, `relationships`, `gender`, `status`, `alias`, `full_name`, `birthday` FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `gid`=" . $row_detail['gid'] . " AND `parentid`=" . $row_detail['id'] . " AND `relationships`=2 ORDER BY `weight` ASC";
                        $result = $db->sql_query($query);
                        if ($db->sql_numrows($result))
                        {
                            $array_parentid[2]['caption'] = $lang_module['list_parentid_2'];
                            while ($row = $db->sql_fetchrow($result, 2))
                            {
                                $row['link'] = $row_genealogy['link_main'] . '/' . $row['alias'];
                                if ($row['birthday'] != '0000-00-00 00:00:00')
                                {
                                    preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})/", $row['birthday'], $datetime);
                                    $row['birthday'] = $datetime[3] . "/" . $datetime[2] . "/" . $datetime[1];
                                }
                                else
                                {
                                    $row['birthday'] = "";
                                }
                                $row['status'] = $array_status[$row['status']];
                                $array_parentid[2]['items'][] = $row;
                            }
                        }
                    }

                    if ($row_detail['birthday'] != '0000-00-00 00:00:00')
                    {
                        preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})/", $row_detail['birthday'], $datetime);
                        $row_detail['birthday'] = $datetime[3] . "/" . $datetime[2] . "/" . $datetime[1];
                    }
                    else
                    {
                        $row_detail['birthday'] = "";
                    }

                    if ($row_detail['status'] == 0)
                    {
                        if ($row_detail['dieday'] != '0000-00-00 00:00:00')
                        {
                            preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})/", $row_detail['dieday'], $datetime);
                            $row_detail['dieday'] = $datetime[3] . "/" . $datetime[2] . "/" . $datetime[1];
                        }
                        else
                        {
                            $row_detail['dieday'] = "";
                        }
                    }
                    else
                    {
                        $row_detail['dieday'] = "";
                        $row_detail['life'] = "";
                    }

                    if ($row_detail['life'] == 0)
                    {
                        $row_detail['life'] = "";
                    }

                    $row_detail['relationships'] = $array_relationships[$row_detail['relationships']];
                    $row_detail['gender'] = $array_gender[$row_detail['gender']];
                    $row_detail['status'] = $array_status[$row_detail['status']];

                    // Cay gia pha
                    $OrgChart = array();
                    $i = 0;
                    // Xác định cha của người này
                    if ($row_detail['parentid'] > 0)
                    {
                        list($full_name_parentid, $alias_parentid) = $db->sql_fetchrow($db->sql_query("SELECT `full_name`, `alias` FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `id`=" . $row_detail['parentid']));
                        $OrgChart[$i] = array('number' => $i, 'id' => $row_detail['parentid'], 'parentid' => 0, 'full_name' => $full_name_parentid, 'link' => $row_genealogy['link_main'] . '/' . $alias_parentid);

                        // Thông tin của người này
                        $i++;
                        $OrgChart[$i] = array('number' => $i, 'id' => $row_detail['id'], 'parentid' => $row_detail['parentid'], 'full_name' => $row_detail['full_name'], 'link' => $row_genealogy['link_main'] . '/' . $row_detail['alias']);
                    }
                    else
                    {
                        // Thông tin của người này
                        $OrgChart[$i] = array('number' => $i, 'id' => $row_detail['id'], 'parentid' => 0, 'full_name' => $row_detail['full_name'], 'link' => $row_genealogy['link_main'] . '/' . $row_detail['alias']);
                    }

                    $array_in_parentid = array();
                    $query = "SELECT `id`, `parentid`, `parentid2`, `weight`, `relationships`, `gender`, `status`, `alias`, `full_name`, `birthday` FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `gid`=" . $row_detail['gid'] . " AND `parentid`=" . $row_detail['id'] . " ORDER BY `relationships` ASC, `weight` ASC";
                    $result = $db->sql_query($query);
                    while ($row = $db->sql_fetchrow($result, 2))
                    {
                        $row['link'] = $row_genealogy['link_main'] . '/' . $row['alias'];
                        $array_in_parentid[$row['relationships']][] = $row;
                    }

                    // Xác định vợ của người này.
                    if (isset($array_in_parentid[2]))
                    {
                        foreach ($array_in_parentid[2] as $key => $value)
                        {
                            $i++;
                            $OrgChart[$i] = array('number' => $i, 'id' => $value['id'], 'parentid' => $value['parentid'], 'full_name' => $value['full_name'] . '<br><span style="color:red;">(' . $lang_module['u_relationships_2'] . ')</span>', 'link' => $value['link']);
                        }
                        foreach ($array_in_parentid[1] as $key => $value)
                        {
                            $i++;
                            $OrgChart[$i] = array('number' => $i, 'id' => $value['id'], 'parentid' => $value['parentid2'], 'full_name' => $value['full_name'], 'link' => $value['link']);
                        }
                        // Xác định các con
                    }
                    elseif (isset($array_in_parentid[3]))
                    {
                        foreach ($array_in_parentid[3] as $key => $value)
                        {
                            $i++;
                            $OrgChart[$i] = array('number' => $i, 'id' => $value['id'], 'parentid' => $value['parentid'], 'full_name' => $value['full_name'] . '<br><span style="color:red;">(' . $lang_module['u_relationships_3'] . ')</span>', 'link' => $value['link']);
                        }
                        foreach ($array_in_parentid[1] as $key => $value)
                        {
                            $i++;
                            $OrgChart[$i] = array('number' => $i, 'id' => $value['id'], 'parentid' => $value['parentid2'], 'full_name' => $value['full_name'], 'link' => $value['link']);
                        }
                    }
                    elseif (isset($array_in_parentid[1]))
                    {
                        foreach ($array_in_parentid[1] as $key => $value)
                        {
                            $i++;
                            $OrgChart[$i] = array('number' => $i, 'id' => $value['id'], 'parentid' => $row_detail['id'], 'full_name' => $value['full_name'], 'link' => $value['link']);
                        }
                    }
                    // Cay gia pha
                    $contents = nv_theme_gia_pha_detail($row_genealogy, $row_detail, $array_parentid, $OrgChart);
                }
                else
                {
                    $redirect = "<meta http-equiv=\"Refresh\" content=\"3;URL=" . nv_url_rewrite(NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $row_genealogy['alias'], true) . "\" />";
                    nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect);
                }
            }
        }
        else
        {
            list($location) = $db->sql_fetchrow($db->sql_query("SELECT `title` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_location` where `locationid`=" . $row_genealogy['locationid']));
            $row_genealogy['location'] = $location;

            $row_genealogy['family'] = $array_family[$row_genealogy['fid']]['title'];

            list($maxlev) = $db->sql_fetchrow($db->sql_query("SELECT max(lev) FROM `" . NV_PREFIXLANG . "_" . $module_data . "` where `gid`=" . $row_genealogy['gid']));
            $row_genealogy['maxlev'] = intval($maxlev);

            if (empty($row_genealogy['full_name']))
            {
                $row_userid = $db->sql_fetchrow($db->sql_query("SELECT * FROM `" . NV_USERS_GLOBALTABLE . "` where `userid`=" . $row_genealogy['userid']), 2);
                if (empty($row_userid['full_name']))
                {
                    $row_genealogy['full_name'] = $row_userid['username'];
                }
                else
                {
                    $row_genealogy['full_name'] = $row_userid['full_name'];
                }

                if (empty($row_userid['telephone']))
                {
                    $row_genealogy['telephone'] = $row_userid['mobile'];
                }
                else
                {
                    $row_genealogy['telephone'] = $row_userid['telephone'];
                }
                $row_genealogy['email'] = $row_userid['email'];
            }
            $contents = nv_theme_gia_pha_main($row_genealogy);
        }
    }
    else
    {
        $redirect = "<meta http-equiv=\"Refresh\" content=\"3;URL=" . nv_url_rewrite(NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name, true) . "\" />";
        nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect);
    }
}
else
{
    $array_data = array();
    $sql = "SELECT `locationid`, `title`, `number`, `alias` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_location` WHERE `parentid`=0 AND `status` = 1 ORDER BY `weight` ASC";
    $array_location = nv_db_cache($sql, 'locationid', $module_name);
    foreach ($array_location as $row)
    {
        $row['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=location/" . $row['alias'];
        $array_data[] = $row;
    }
    $contents = nv_theme_gia_pha_main_location($array_data);
}

include (NV_ROOTDIR . "/includes/header.php");
echo nv_site_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>