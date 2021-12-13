<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 2-10-2010 18:49
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
if ( ! defined( 'NV_IS_AJAX' ) ) die( 'Wrong URL' );
$fid = $nv_Request->get_int( 'fid', 'post', 0 );
$mod = $nv_Request->get_string( 'mod', 'post', '' );
$new_vid = $nv_Request->get_int( 'new_vid', 'post', 0 );

if ( empty( $fid ) ) die( "NO_" . $fid );
$content = "NO_" . $fid;
if ( $mod == "weight" and $new_vid > 0 )
{
    $query = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_family` WHERE `fid`=" . $fid;
    $result = $db->sql_query( $query );
    $numrows = $db->sql_numrows( $result );
    if ( $numrows != 1 ) die( 'NO_' . $topicid );
    
    $query = "SELECT `fid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_family` WHERE `fid`!=" . $fid . " ORDER BY `weight` ASC";
    $result = $db->sql_query( $query );
    $weight = 0;
    while ( $row = $db->sql_fetchrow( $result ) )
    {
        $weight ++;
        if ( $weight == $new_vid ) $weight ++;
        $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_family` SET `weight`=" . $weight . " WHERE `fid`=" . intval( $row['fid'] );
        $db->sql_query( $sql );
    }
    $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_family` SET `weight`=" . $new_vid . " WHERE `fid`=" . intval( $fid );
    $db->sql_query( $sql );
    $content = "OK_" . $fid;
}
elseif ( $mod == "status" and $fid > 0 )
{
    $new_vid = ( intval( $new_vid ) == 1 ) ? 1 : 0;
    $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_family` SET `status`=" . $new_vid . " WHERE `fid`=" . intval( $fid );
    $db->sql_query( $sql );
    $content = "OK_" . $fid;
}
nv_del_moduleCache( $module_name );

include ( NV_ROOTDIR . "/includes/header.php" );
echo $content;
include ( NV_ROOTDIR . "/includes/footer.php" );

?>