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

$locationid = 0;
if (isset($array_op[1]))
{
    $sql = "SELECT `locationid`, `title`, `number`, `alias` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_location` WHERE `alias`=" . $db->dbescape($array_op[1]);
    $result = $db->sql_query($sql);
    $row_location = $db->sql_fetchrow($result, 2);
    $locationid = $row_location['locationid'];
}
if (empty($locationid))
{
    Header("Location: " . nv_url_rewrite(NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name, true));
    die();
}

$array_data = array();

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

$sql = "SELECT `gid`, `title`, `alias`, `fid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` WHERE `locationid`=" . $locationid . " AND `status`=1 " . $where_who_view . " ORDER BY `weight` ASC";
$result = $db->sql_query($sql);

/*
 if ($db->sql_numrows($result) == 1)
 {
 $row = $db->sql_fetchrow($result);
 Header("Location: " . nv_url_rewrite(NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $row['alias'], true));
 die();
 }*/

while ($row = $db->sql_fetchrow($result))
{
    $row['title'] = $lang_module['family'] . " " . $array_family[$row['fid']]['title'] . ", " . $row['title'];

    $row['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $array_family[$row['fid']]['alias'] . "/" . $row['alias'];
    $array_data[] = $row;
}

$contents = nv_theme_gia_pha_location($row_location, $array_data);

include (NV_ROOTDIR . "/includes/header.php");
echo nv_site_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>