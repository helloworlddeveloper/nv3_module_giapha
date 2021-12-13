<?php

/**
 * @Project NUKEVIET 3.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @Createdate Wed, 31 Dec 2014 08:03:48 GMT
 */

if ( ! defined( 'NV_IS_FILE_SITEINFO' ) ) die( 'Stop!!!' );


$lang_siteinfo = nv_get_lang_module( $mod );
/*
// Tong so bai viet 
list( $number ) = $db->sql_fetchrow( $db->sql_query( "SELECT COUNT(*) as number FROM `" . NV_PREFIXLANG . "_" . $mod_data . "_rows` where `status`= 1 AND `publtime` < " . NV_CURRENTTIME . " AND (`exptime`=0 OR `exptime`>" . NV_CURRENTTIME . ")" ) );
if ( $number > 0 )
{
    $siteinfo[] = array( 
        'key' => $lang_siteinfo['siteinfo_publtime'], 'value' => $number 
    );
}
*/
?>