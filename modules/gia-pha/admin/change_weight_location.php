<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 2-10-2010 18:49
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
if ( ! defined( 'NV_IS_AJAX' ) ) die( 'Wrong URL' );
$cuid = $nv_Request->get_int( 'cuid', 'post', 0 );
$parentid = $nv_Request->get_int( 'parentid', 'post', 0 );
$new_weight = $nv_Request->get_int( 'new_weight', 'post', 0 );
if ( empty( $cuid ) ) die( "NO_" . $cuid );

$query = "SELECT `weight` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_location` WHERE `locationid`=" . $cuid." AND `parentid`=".$parentid;
$result = $db->sql_query( $query );

list($weight_old) = $db->sql_fetchrow( $result );

$query = "SELECT `locationid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_location` WHERE `weight`=" . $new_weight ." AND `parentid`=".$parentid;
$result = $db->sql_query( $query );

list($id_swap) = $db->sql_fetchrow( $result );

$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_location` SET `weight`=" . $new_weight . " WHERE `locationid`=" . $cuid ." AND `parentid`=".$parentid;
$db->sql_query( $sql );
$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_location` SET `weight`=" . $weight_old . " WHERE `locationid`=" . $id_swap." AND `parentid`=".$parentid;
$db->sql_query( $sql );

nv_del_moduleCache( $module_name );
include ( NV_ROOTDIR . "/includes/header.php" );
echo 'OK_' . $cuid;
include ( NV_ROOTDIR . "/includes/footer.php" );

?>