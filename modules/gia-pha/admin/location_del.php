<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 2-1-2010 15:23
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

if ( ! defined( 'NV_IS_AJAX' ) ) die( 'Wrong URL' );

$cuid = $nv_Request->get_int( 'cuid', 'post', 0 );
$parentid = $nv_Request->get_int( 'parentid', 'post', 0 );
if ( empty( $cuid ) ) die( 'NO_' . $cuid );

$query = "SELECT `title` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_location` WHERE `locationid`=" . $cuid . " AND `parentid`=" . $parentid;
$result = $db->sql_query( $query );
$numrows = $db->sql_numrows( $result );
if ( $numrows != 1 ) die( 'NO_' . $typeid );
nv_insert_logs( NV_LANG_DATA, $module_name, 'log_del_about', "aboutid  " . $cuid, $admin_info['userid'] );

$query = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_location` WHERE `locationid`=" . $cuid . " OR `parentid`=" . $cuid;
$db->sql_query( $query );
nv_fix_cu_location( $parentid );
nv_del_moduleCache( $module_name );

if ( $db->sql_affectedrows() > 0 )
{
    nv_del_moduleCache( $module_name );
    die( 'OK_' . $cuid );
}
else
{
    die( 'NO_' . $cuid );
}

include ( NV_ROOTDIR . "/includes/header.php" );
echo 'OK_' . $cuid;
include ( NV_ROOTDIR . "/includes/footer.php" );

?>