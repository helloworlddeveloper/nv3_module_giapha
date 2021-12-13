<?php

/**
 * @Project NUKEVIET 3.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @Createdate Wed, 31 Dec 2014 08:03:48 GMT
 */

if ( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) or ! defined( 'NV_IS_MODADMIN' ) ) die( 'Stop!!!' );

$submenu['config'] = $lang_module['config'];
$submenu['anniversary'] = $lang_module['anniversary'];
$submenu['family'] = $lang_module['family'];
$submenu['genealogy'] = $lang_module['genealogy'];
$submenu['genealogy_show'] = $lang_module['genealogy_show'];
$submenu['location'] = $lang_module['location'];
$submenu['users'] = $lang_module['users'];

$allow_func = array( 'main', 'config', 'anniversary', 'family', 'genealogy', 'genealogy_show', 'location', 'users');

define( 'NV_IS_FILE_ADMIN', true );

?>