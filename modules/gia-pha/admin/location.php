<?php
/**
 * @Project NUKEVIET 3.0
 * @Author VINADES., JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES ., JSC. All rights reserved
 * @Createdate Dec 3, 2010  11:33:22 AM 
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$array_inhome = array( $lang_global['no'], $lang_global['yes'] );
$page_title = $lang_module['location'];
$cuid = 0;
$parentid = 0;
$alias = "";
$title = "";
$error = "";
$cuid = $nv_Request->get_int( 'cuid', 'post,get', "" );
$parentid = $nv_Request->get_int( 'parentid', 'post,get', "" );

if ( $cuid != 0 )
{
    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_location`  WHERE `locationid`=" . $cuid . " AND `parentid`=" . $parentid . " ORDER BY `order` ASC";
    $result = $db->sql_query( $sql );
    list( $cuid, $parentid, $title, $alias, $weight, $order, $lev, $numlistcu, $listcu, $status ) = $db->sql_fetchrow( $result );
}

if ( $nv_Request->get_string( 'save', 'post' ) != "" )
{
    $cuid = $nv_Request->get_int( 'cuid', 'post', 0 );
    $parentid_old = $nv_Request->get_int( 'parentid_old', 'post', 0 );
    $title = filter_text_input( 'title', 'post', '', 1, 255 );
    $alias = filter_text_input( 'alias', 'post', '', 1, 255 );
    $parentid = $nv_Request->get_int( 'parentid', 'post,get', 0 );
    $alias = ( $alias == "" ) ? change_alias( $title ) : change_alias( $alias );
    
    if ( $title == "" )
    {
        $error = $lang_module['error_title'];
    }
    else
    {
        if ( $cuid == 0 )
        {
            list( $weight ) = $db->sql_fetchrow( $db->sql_query( "SELECT max(`weight`) FROM `" . NV_PREFIXLANG . "_" . $module_data . "_location` WHERE `parentid`=" . $db->dbescape( $parentid ) . "" ) );
            $weight = intval( $weight ) + 1;
            $listcu = "";
            if ( $db->sql_numrows( $db->sql_query( "SELECT `title` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_location` WHERE `title`=" . $db->dbescape( $title ) . " AND parentid=" . $parentid ) ) != 0 )
            {
                $error = $lang_module['title_exist'];
            }
            else
            {
                $query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_location` (`locationid`, `parentid`, `title`, `alias`, `weight`, `order`, `lev`, `numlistcu`, `listcu`, `status`) 
		        VALUES (NULL," . intval( $parentid ) . ", " . $db->dbescape( $title ) . ", " . $db->dbescape( $alias ) . ", " . intval( $weight ) . ", '0', '0', '0', " . $db->dbescape( $listcu ) . ", 1)";
                $newcatid = intval( $db->sql_query_insert_id( $query ) );
                if ( $newcatid > 0 )
                {
                    $db->sql_freeresult();
                    nv_fix_cu_location();
                    nv_del_moduleCache( $module_name );
                    nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['add_cat'], $title, $admin_info['userid'] );
                    Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&parentid=" . $parentid . "" );
                    die();
                }
                else
                {
                    $error = $lang_module['errorsave'];
                }
            }
        }
        else
        {
            $query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_location` SET `parentid`=" . $db->dbescape( $parentid ) . ", `title`=" . $db->dbescape( $title ) . ", `alias` =  " . $db->dbescape( $alias ) . " WHERE `locationid` =" . $cuid . "";
            $db->sql_query( $query );
            if ( $db->sql_affectedrows() > 0 )
            {
                $db->sql_freeresult();
                if ( $parentid != $parentid_old )
                {
                    list( $weight ) = $db->sql_fetchrow( $db->sql_query( "SELECT max(`weight`) FROM `" . NV_PREFIXLANG . "_" . $module_data . "_location` WHERE `parentid`=" . $db->dbescape( $parentid ) . "" ) );
                    $weight = intval( $weight ) + 1;
                    $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_location` SET `weight`=" . $weight . " WHERE `locationid`=" . intval( $cuid );
                    $db->sql_query( $sql );
                    nv_fix_cu_location();
                    nv_del_moduleCache( $module_name );
                    nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['edit_cat'], $title, $admin_info['userid'] );
                }
                nv_del_moduleCache( $module_name );
                Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&parentid=" . $parentid . "" );
                die();
            }
            else
            {
                $error = $lang_module['errorsave'];
            }
        }
    
    }
}

$xtpl = new XTemplate( "location.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$action = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=location&parentid=" . $parentid . "";
$xtpl->assign( 'FORM_ACTION', $action );
$xtpl->assign( 'LANG', $lang_module );

if ( $error != "" )
{
    $xtpl->assign( 'ERROR', $error );
    $xtpl->parse( 'main.error' );
}
if ( empty( $parentid ) )
{
    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_location` where `parentid`=0 order by `weight` ";
}
else
{
    $comback = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=location";
    $xtpl->assign( 'comeback', $comback );
    $xtpl->assign( 'back', $lang_module['back'] );
    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_location` where `parentid`=" . $parentid . " order by `weight` ";
}
$result = $db->sql_query( $sql );
$num = $db->sql_numrows( $result );
$level_cata = 0;
if ( $num > 0 )
{
    $count = 0;
    while ( $row = $db->sql_fetchrow( $result ) )
    {
        $class = ( $count % 2 ) ? " class=\"second\"" : "";
        $count ++;
        $xtpl->assign( 'class', $class );
        $xtpl->assign( 'cuid', $row['locationid'] );
        $xtpl->assign( 'parentid', $row['parentid'] );
        for ( $i = 1; $i <= $num; $i ++ )
        {
            $xtpl->assign( 'stt', $i );
            if ( $i == $row['weight'] )
            {
                $xtpl->assign( 'select', 'selected' );
            }
            else
            {
                $xtpl->assign( 'select', '' );
            }
            $xtpl->parse( 'main.data.loop.loop1' );
        }
        
        $xtpl->assign( 'nu', $row['numlistcu'] );
        if ( $row['lev'] < 1 )
        {
            $link_cu = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=location&amp;parentid=" . $row['locationid'];
            $xtpl->assign( 'link_cu', $link_cu );
            $xtpl->assign( 'title', $row['title'] );
            $xtpl->assign( 'num', "(" . $row['numlistcu'] . ")" );
        }
        else
        {
            $xtpl->assign( 'title', $row['title'] );
        }
        foreach ( $array_inhome as $key => $val )
        {
            $xtpl->assign( 'key', $key );
            $xtpl->assign( 'value', $val );
            if ( $key == $row['status'] )
            {
                $xtpl->assign( 'sel', 'selected' );
            }
            else
            {
                $xtpl->assign( 'sel', '' );
            }
            $xtpl->parse( 'main.data.loop.loop2' );
        }
        
        $editlink = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=location&amp;cuid=" . $row['locationid'] . "&amp;parentid=" . $row['parentid'];
        $xtpl->assign( 'editlink', $editlink );
        $xtpl->parse( 'main.data.loop' );
        $level_cata = $row['lev'];
    }
    
    $xtpl->parse( 'main.data' );

}
else
{
    $sql = "SELECT `lev` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_location` where `locationid`=" . $parentid . " order by `weight` ";
    $result = $db->sql_query( $sql );
    $row = $db->sql_fetchrow( $result );
    $level_cata = $row['lev'];
}
if ( empty( $parentid ) )
{
    $level_cata = 2;
}
if ( $parentid > 0 )
{
    $arr_culist = $lang_module['huyen'];
}
else
{
    $arr_culist = $lang_module['tinh'];
}

$xtpl->assign( 'title_cata', $arr_culist );
$xtpl->assign( 'title_cu', $title );
$xtpl->assign( 'location_id', $cuid );
$xtpl->assign( 'parent_id', $parentid );
$xtpl->assign( 'alias', $alias );

$xtpl->assign( 'levelcurent', $level_cata );

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>