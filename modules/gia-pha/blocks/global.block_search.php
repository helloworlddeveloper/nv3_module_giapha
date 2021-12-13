<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 3/9/2010 23:25
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

if ( defined( 'NV_SYSTEM' ) )
{
    global $site_mods, $module_name, $module_info, $lang_module, $nv_Request;
    $module = $block_config['module'];
    $mod_file = $site_mods[$module]['module_file'];
    $mod_data = $site_mods[$module]['module_data'];
    if ( isset( $site_mods[$module] ) )
    {
        if ( $module == $module_name )
        {
            $lang_block_module = $lang_module;
        }
        else
        {
            $temp_lang_module = $lang_module;
            $lang_module = array();
            include ( NV_ROOTDIR . "/modules/" . $site_mods[$module]['module_file'] . "/language/" . NV_LANG_INTERFACE . ".php" );
            $lang_block_module = $lang_module;
            $lang_module = $temp_lang_module;
        }
        
        
        $textfield = filter_text_input( 'textfield', 'get', '', 1, NV_MAX_SEARCH_LENGTH );
        $locationid = $nv_Request->get_int( 'location', 'get', 0 );
        $searchtype = $nv_Request->get_int( 'searchtype', 'get', 0 );
    	if (file_exists(NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $mod_file . "/block_search.tpl"))
        {
            $block_theme = $module_info['template'];
        }
        else
        {
            $block_theme = "default";
        }

        $xtpl = new XTemplate("block_search.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $mod_file);
        $xtpl->assign( 'LANG', $lang_block_module );
        $xtpl->assign( 'module', $module );
        $xtpl->assign( 'textfield', $textfield );
        $xtpl->assign( 'FORMACTION', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module . '&' . NV_OP_VARIABLE . '=search' );
        $sql = "SELECT `locationid`, `title`, `number`, `alias` FROM `" . NV_PREFIXLANG . "_" . $mod_data . "_location` WHERE `parentid`=0 ORDER BY `weight` ASC";
        $array_location = nv_db_cache($sql, 'locationid', $module );
        foreach ($array_location as $row)
        {
            $row['sl'] = ( $row['locationid'] == $locationid ) ? 'selected=selected' : '';
            $xtpl->assign( 'LOCATION', $row );
            $xtpl->parse( 'main.location' );
        }
        $array_searchtype = array(
            1 => $lang_block_module['search_for2'],
            2 => $lang_block_module['search_for3']
        );
        foreach ($array_searchtype as $key => $val )
        {
            $sl = ( $key == $searchtype ) ? 'selected=selected' : '';
            $xtpl->assign( 'VAL', $val );
            $xtpl->assign( 'KEY', $key );
            $xtpl->assign( 'SL', $sl );
            $xtpl->parse( 'main.searchtype' );
        }
        $xtpl->parse( 'main' );
        $content = $xtpl->text( 'main' );
    }
}

?>