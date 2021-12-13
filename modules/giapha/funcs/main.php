<?php

/**
 * @Project NUKEVIET 3.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @Createdate Wed, 31 Dec 2014 08:03:48 GMT
 */

if ( ! defined( 'NV_IS_MOD_GIAPHA' ) ) die( 'Stop!!!' );




//$contents = nv_theme_giapha_main( $array_data );
$contents = "ab";
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>