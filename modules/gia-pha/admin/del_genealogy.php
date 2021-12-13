<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 2-10-2010 18:49
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

$gid = $nv_Request->get_int('gid', 'post', 0);

$contents = "NO_" . $gid;
list($gid, $locationid, $status) = $db->sql_fetchrow($db->sql_query("SELECT `gid`,`locationid`, `status` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` WHERE `gid`=" . intval($gid) . ""));
if ($gid > 0)
{
    $query = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` WHERE `gid`=" . $gid . "";
    if ($db->sql_query($query))
    {
        $db->sql_freeresult();

        $query = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `gid`=" . $gid . "";
        $db->sql_query($query);

        if ($status)
        {
            $db->sql_query("UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_location` SET number = number-1 WHERE `locationid` =" . $locationid);
        }
        nv_fix_genealogy();
        nv_del_moduleCache($module_name);
        $contents = "OK_" . $gid;
    }
}

include (NV_ROOTDIR . "/includes/header.php");
echo $contents;
include (NV_ROOTDIR . "/includes/footer.php");
?>