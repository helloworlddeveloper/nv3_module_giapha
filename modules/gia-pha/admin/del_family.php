<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 2-10-2010 18:49
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$fid = $nv_Request->get_int( 'fid', 'post', 0 );

$contents = "NO_" . $fid;
list( $fid ) = $db->sql_fetchrow( $db->sql_query( "SELECT `fid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_family` WHERE `fid`=" . intval( $fid ) . "" ) );
if ( $fid > 0 )
{
	$query = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_family` WHERE `fid`=" .$fid . "";
    if ( $db->sql_query( $query ) )
    {
        $db->sql_freeresult();
        nv_fix_family();
        nv_del_moduleCache($module_name);
        $contents = "OK_" . $fid;
    }
}

include ( NV_ROOTDIR . "/includes/header.php" );
echo $contents;
include ( NV_ROOTDIR . "/includes/footer.php" );

?>