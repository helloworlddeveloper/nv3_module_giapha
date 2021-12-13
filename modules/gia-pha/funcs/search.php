<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Sun, 17 Jul 2011 03:36:01 GMT
 */

if( ! defined( 'NV_IS_MOD_GIA_PHA' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$locationid = $nv_Request->get_int( "location", "get", 0 );
$textfield = $nv_Request->get_string( "textfield", "get", 0 );
$searchtype = $nv_Request->get_int( "searchtype", "get", 0 );
if( $searchtype > 2 && $searchtype < 1 ) $searchtype = 1;
$where = "";
$row_location = array();
if( $locationid > 0 )
{
	$sql = "SELECT `locationid`, `title`, `number`, `alias` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_location` WHERE `locationid`=" . $locationid;
	$result = $db->sql_query( $sql );
	$row_location = $db->sql_fetchrow( $result, 2 );
	$locationid = $row_location['locationid'];
}
if( $searchtype == 1 )
{
	if( ! empty( $textfield ) )
	{
		$where .= " AND (`title` LIKE '%" . $textfield . "%' OR `description` LIKE '%" . $textfield . "%' OR `full_name` LIKE '%" . $textfield . "%' )";
	}
	if( $locationid > 0 )
	{
		$where .= " AND `locationid`=" . $locationid . "";
	}

	if( empty( $locationid ) && $textfield == "" )
	{
		Header( "Location: " . nv_url_rewrite( NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name, true ) );
		die();
	}
	if( defined( 'NV_IS_MODADMIN' ) )
	{
		$where_who_view = "";
	}
	elseif( defined( 'NV_IS_USER' ) )
	{
		$where_who_view = "AND (`who_view`=0 OR `who_view`=1 OR `userid`=" . $user_info['userid'] . ")";
	}
	else
	{
		$where_who_view = "AND `who_view`=0";
	}
	$sql = "SELECT `gid`, `title`, `alias`, `fid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` WHERE `status`=1 " . $where_who_view . $where . " ORDER BY `weight` ASC";
	$result = $db->sql_query( $sql );
	while( $row = $db->sql_fetchrow( $result ) )
	{
		$row['title'] = $lang_module['family'] . " " . $array_family[$row['fid']]['title'] . ", " . $row['title'];

		$row['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $array_family[$row['fid']]['alias'] . "/" . $row['alias'];
		$array_data[] = $row;
	}
	$contents = nv_theme_gia_pha_search_by_location( $row_location, $array_data, $textfield );
}
else
{
	if( ! empty( $textfield ) )
	{
		$where .= " AND t1.`full_name` LIKE '%" . $textfield . "%'";
	}
	if( $locationid > 0 )
	{
		$where .= " AND t2.`locationid`=" . $locationid . "";
	}
	// Ph? d?
	$array_data = array();
	$query = "SELECT t1.`id`, t1.`gid`, t1.`parentid`, t1.`weight`, t1.`relationships`, t1.`gender`, t1.`status`, t1.`alias`, t1.`full_name`, t2.alias as genalias, t2.fid FROM `" . NV_PREFIXLANG . "_" . $module_data . "` AS t1 INNER JOIN `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` AS t2 ON t1.gid=t2.gid WHERE 1" . $where . " ORDER BY t1.`parentid` ASC, t1.`weight`, t1.`id` ASC";
	$result = $db->sql_query( $query );
	while( $row = $db->sql_fetchrow( $result ) )
	{
		$row['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $array_family[$row['fid']]['alias'] . "/" . $row['genalias'] . '/' . $row['alias'];
		$array_data[$row['id']] = $row;
	}
	$contents = nv_theme_gia_pha_search_by_genealogy( $row_location, $array_data, $textfield );
}

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>