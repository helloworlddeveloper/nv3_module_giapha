<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Sun, 17 Jul 2011 03:36:01 GMT
 */

if( ! defined( 'NV_IS_MOD_GIA_PHA' ) ) die( 'Stop!!!' );

function nv_theme_gia_pha_main_location( $array_data )
{
	global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

	$xtpl = new XTemplate( "main-location.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );

	$i = 0;
	$j = 0;
	foreach( $array_data as $row )
	{
		$i++;
		$xtpl->assign( 'DATA', $row );
		if( $row['number'] )
		{
			$xtpl->parse( 'main.looptr.looptd.number' );
		}
		$xtpl->parse( 'main.looptr.looptd' );
		if( $i % 4 == 0 )
		{
			$xtpl->assign( 'CLASS', ( $j % 2 == 0 ) ? ' class="second "' : '' );
			$xtpl->parse( 'main.looptr' );
			$j++;
		}
	}
	if( $i % 4 != 0 )
	{
		$xtpl->parse( 'main.looptr' );
	}
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function nv_theme_gia_pha_location( $location, $array_data )
{
	global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

	$xtpl = new XTemplate( $op . ".tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'LOCATION', $location );
	$i = 0;
	foreach( $array_data as $row )
	{
		$i++;
		$row['number'] = $i;
		$xtpl->assign( 'CLASS', ( $i % 2 == 0 ) ? ' class="second "' : '' );
		$xtpl->assign( 'DATA', $row );
		$xtpl->parse( 'main.loop' );
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function nv_theme_gia_pha_search_by_location( $location, $array_data, $textfield )
{
	global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

	$xtpl = new XTemplate( $op . ".tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	if( ! empty( $textfield ) )
	{
		$xtpl->assign( 'textfield', $textfield );
		$xtpl->parse( 'main.textfield' );
	}
	if( ! empty( $location ) )
	{
		$xtpl->assign( 'LOCATION', $location );
		$xtpl->parse( 'main.location' );
	}
	$i = 0;
	if( ! empty( $array_data ) )
	{
		foreach( $array_data as $row )
		{
			$i++;
			$row['number'] = $i;
			$xtpl->assign( 'CLASS', ( $i % 2 == 0 ) ? ' class="second "' : '' );
			$xtpl->assign( 'DATA', $row );
			$xtpl->parse( 'main.bylocation.loop' );
		}
	}
	else
	{
		$xtpl->parse( 'main.noresult' );
	}
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function nv_theme_gia_pha_search_by_genealogy( $location, $array_data, $textfield )
{
	global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

	$xtpl = new XTemplate( $op . ".tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	if( ! empty( $textfield ) )
	{
		$xtpl->assign( 'textfield', $textfield );
		$xtpl->parse( 'main.textfield' );
	}
	if( ! empty( $location ) )
	{
		$xtpl->assign( 'LOCATION', $location );
		$xtpl->parse( 'main.location' );
	}
	if( ! empty( $array_data ) )
	{
		foreach( $array_data as $data )
		{
			$xtpl->assign( 'DATA', $data );
			$xtpl->parse( 'main.bygiapha.loop' );
		}
		$xtpl->parse( 'main.bygiapha' );
	}
	else
	{
		$xtpl->parse( 'main.noresult' );
	}
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function nv_theme_gia_pha_main( $array_data )
{
	global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op, $array_op;
	$xtpl = new XTemplate( "main.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
	$xtpl->assign( 'DATA', $array_data );
	$xtpl->assign( 'arrayop', implode( "/", $array_op ) );
	if( ! empty( $array_data['telephone'] ) )
	{
		$xtpl->parse( 'main.telephone' );
	}

	if( ! empty( $array_data['years'] ) )
	{
		$xtpl->parse( 'main.years' );
	}
	if( ! empty( $array_data['author'] ) )
	{
		$xtpl->parse( 'main.author' );
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function nv_theme_gia_pha_pha_ky( $array_data )
{
	global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

	$xtpl = new XTemplate( "pha-ky.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'DATA', $array_data );
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function nv_theme_gia_pha_toc_uoc( $array_data )
{
	global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

	$xtpl = new XTemplate( "toc-uoc.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'DATA', $array_data );
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function nv_theme_gia_pha_huong_hoa( $array_data )
{
	global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

	$xtpl = new XTemplate( "huong-hoa.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'DATA', $array_data );
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function nv_viewdirtree_genealogy( $array_data, $parentid = 0 )
{
	global $module_info, $module_file;
	$_dirlist = $array_data[$parentid];
	$content = "";
	$i = 1;
	foreach( $_dirlist as $_dir )
	{
		if( $_dir['relationships'] == 1 )
		{
			$_dir['lev'] = $_dir['lev'] . "." . $i++;
			switch( $_dir['gender'] )
			{
				case 1:
					$_dir['class'] = 'class="male"';
					break;
				case 2:
					$_dir['class'] = 'class="female"';
					break;
				default:
					$_dir['class'] = 'class="default"';
					break;
			}

			$xtpl = new XTemplate( "genealogy.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
			if( isset( $array_data[$_dir['id']] ) )
			{
				$_dirlist_wife = $array_data[$_dir['id']];
				foreach( $_dirlist_wife as $_dir_wife )
				{
					if( $_dir_wife['relationships'] != 1 )
					{
						switch( $_dir_wife['gender'] )
						{
							case 1:
								$_dir_wife['class'] = 'class="male"';
								break;
							case 2:
								$_dir_wife['class'] = 'class="female"';
								break;
							default:
								$_dir_wife['class'] = 'class="default"';
								break;
						}
						$xtpl->assign( "WIFE", $_dir_wife );
						$xtpl->parse( 'tree.wife' );
					}
				}

				$content2 = nv_viewdirtree_genealogy( $array_data, $_dir['id'] );
				if( ! empty( $content2 ) )
				{
					$xtpl->assign( "TREE_CONTENT", $content2 );
					$xtpl->parse( 'tree.tree_content.loop' );
				}
				$xtpl->parse( 'tree.tree_content' );
			}
			$xtpl->assign( "DIRTREE", $_dir );
			$xtpl->parse( 'tree' );
			$content .= $xtpl->text( 'tree' );
		}
	}
	return $content;
}

function nv_theme_gia_pha_genealogy( $row_genealogy, $array_data )
{
	global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

	$xtpl = new XTemplate( "genealogy.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'GENEALOGY', $row_genealogy );
	if( ! empty( $array_data ) )
	{
		$xtpl->assign( 'DATATREE', nv_viewdirtree_genealogy( $array_data, 0 ) );
		$xtpl->parse( 'main.foldertree' );
	}
	else
	{
		$xtpl->parse( 'main.no_users' );
	}
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function nv_theme_gia_pha_anniversary( $array_data, $array_anniversary )
{
	global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

	$xtpl = new XTemplate( "anniversary.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'DATA', $array_data );

	$i = 0;
	foreach( $array_anniversary as $row )
	{
		$i++;
		$row['number'] = $i;
		$row['class'] = ( $i % 2 == 0 ) ? 'class="second"' : '';

		$xtpl->assign( 'ANNIVERSARY', $row );
		$xtpl->parse( 'main.loop' );
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function nv_theme_gia_pha_detail( $row_genealogy, $row_detail, $array_parentid, $OrgChart )
{
	global $global_config, $module_name, $module_file, $lang_module, $my_head, $module_info, $op;

	if( ! defined( 'SHADOWBOX' ) )
	{
		$my_head .= "<link rel=\"Stylesheet\" href=\"" . NV_BASE_SITEURL . "js/shadowbox/shadowbox.css\" />\n";
		$my_head .= "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/shadowbox/shadowbox.js\"></script>\n";
		$my_head .= "<script type=\"text/javascript\">Shadowbox.init({ handleOversize: \"drag\" });</script>";
		define( 'SHADOWBOX', true );
	}
	$xtpl = new XTemplate( "detail.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'GENEALOGY', $row_genealogy );
	$array_key = array(
		'full_name',
		'gender',
		'status',
		'code',
		'name1',
		'name2',
		'birthday',
		'dieday',
		'life',
		'burial' );
	$i = 0;

	$lang_module['u_life'] = ( $row_detail['life'] >= 50 ) ? $lang_module['u_life_ht'] : $lang_module['u_life_hd'];

	foreach( $array_key as $key )
	{
		if( $row_detail[$key] != "" )
		{
			$i++;
			$dataloop = array(
				'class' => ( $i % 2 == 0 ) ? 'class="second"' : '',
				'lang' => $lang_module['u_' . $key],
				'value' => $row_detail[$key] );
			$xtpl->assign( 'DATALOOP', $dataloop );
			$xtpl->parse( 'main.loop' );
		}
	}
	$xtpl->assign( 'DATA', $row_detail );

	foreach( $array_parentid as $array_parentid_i )
	{
		$xtpl->assign( 'PARENTIDCAPTION', $array_parentid_i['caption'] );
		$items = $array_parentid_i['items'];
		$number = 1;
		foreach( $items as $item )
		{
			$item['number'] = $number++;
			$item['class'] = ( $number % 2 == 0 ) ? 'class="second"' : '';

			$xtpl->assign( 'DATALOOP', $item );
			$xtpl->parse( 'main.parentid.loop2' );
		}
		$xtpl->parse( 'main.parentid' );
	}
	if( ! empty( $row_detail['content'] ) )
	{
		$xtpl->parse( 'main.content' );
	}

	if( ! empty( $OrgChart ) )
	{
		$xtpl->assign( 'DATACHARTROWS', count( $OrgChart ) );
		foreach( $OrgChart as $item )
		{
			if( $item['id'] == $row_detail['id'] )
			{
				$item['full_name'] = '<span style="color:red; font-weight: 700">' . $item['full_name'] . '</span>';
			}
			$xtpl->assign( 'DATACHART', $item );
			if( $item['number'] > 0 )
			{
				$xtpl->parse( 'main.orgchart.looporgchart.looporgchart2' );
			}
			$xtpl->parse( 'main.orgchart.looporgchart' );
		}
		$xtpl->parse( 'main.orgchart' );
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function nv_theme_gia_pha_export_main_to_pdf( $array_data )
{
	global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;
	$xtpl = new XTemplate( "exportpdf.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
	$xtpl->assign( 'TEMPLATE', $module_info['template'] );
	$xtpl->assign( 'DATA', $array_data );
	if( ! empty( $array_data['telephone'] ) )
	{
		$xtpl->parse( 'biapg.telephone' );
	}

	if( ! empty( $array_data['years'] ) )
	{
		$xtpl->parse( 'biapg.years' );
	}
	if( ! empty( $array_data['author'] ) )
	{
		$xtpl->parse( 'biapg.author' );
	}

	$xtpl->parse( 'biapg' );
	return $xtpl->text( 'biapg' );
}

function nv_theme_gia_pha_pha_ky_export( $array_data )
{
	global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

	$xtpl = new XTemplate( "exportpdf.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'DATA', $array_data );
	$xtpl->parse( 'phaky' );
	return $xtpl->text( 'phaky' );
}

function nv_theme_gia_pha_genealogy_export( $array_data )
{
	global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

	$xtpl = new XTemplate( "exportpdf.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
	if( ! empty( $array_data ) )
	{
		$xtpl->assign( 'DATATREE', nv_viewdirtree_genealogy_export( $array_data, 0 ) );
		$xtpl->parse( 'phado.foldertree' );
	}
	$xtpl->parse( 'phado' );
	return $xtpl->text( 'phado' );
}

function nv_viewdirtree_genealogy_export( $array_data, $parentid = 0 )
{
	global $module_info, $module_file;
	$_dirlist = $array_data[$parentid];
	$content = "";
	foreach( $_dirlist as $_dir )
	{
		if( $_dir['relationships'] == 1 )
		{
			switch( $_dir['gender'] )
			{
				case 1:
					$_dir['class'] = "style=\"background: url('" . NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/gia-pha/male.png') no-repeat; padding: 1px 0 1px 16px\"";
					;
					break;
				case 2:
					$_dir['class'] = "style=\"background: url('" . NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/gia-pha/female.png') no-repeat; padding: 1px 0 1px 16px\"";
					break;
				default:
					$_dir['class'] = "style=\"background: url('" . NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/gia-pha/default.png') no-repeat; padding: 1px 0 1px 16px\"";
					break;
			}

			$xtpl = new XTemplate( "exportpdf.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
			if( isset( $array_data[$_dir['id']] ) )
			{
				$_dirlist_wife = $array_data[$_dir['id']];
				foreach( $_dirlist_wife as $_dir_wife )
				{
					if( $_dir_wife['relationships'] != 1 )
					{
						switch( $_dir_wife['gender'] )
						{
							case 1:
								$_dir_wife['class'] = "style=\"background: url('" . NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/gia-pha/male.png') no-repeat; padding: 1px 0 1px 16px\"";
								break;
							case 2:
								$_dir_wife['class'] = "style=\"background: url('" . NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/gia-pha/female.png') no-repeat; padding: 1px 0 1px 16px\"";
								break;
							default:
								$_dir_wife['class'] = "style=\"background: url('" . NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/gia-pha/default.png') no-repeat; padding: 1px 0 1px 16px\"";
								break;
						}
						$xtpl->assign( "WIFE", $_dir_wife );
						$xtpl->parse( 'tree.wife' );
					}
				}
				$content2 = nv_viewdirtree_genealogy_export( $array_data, $_dir['id'] );
				if( ! empty( $content2 ) )
				{
					$xtpl->assign( "TREE_CONTENT", $content2 );
					$xtpl->parse( 'tree.tree_content.loop' );
				}
				$xtpl->parse( 'tree.tree_content' );
			}
			$xtpl->assign( "DIRTREE", $_dir );
			$xtpl->parse( 'tree' );
			$content .= $xtpl->text( 'tree' );
		}
	}
	return $content;
}

function nv_theme_gia_pha_toc_uoc_export( $array_data )
{
	global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

	$xtpl = new XTemplate( "exportpdf.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'DATA', $array_data );
	$xtpl->parse( 'tocuoc' );
	return $xtpl->text( 'tocuoc' );
}
function nv_theme_gia_pha_huong_hoa_export( $array_data )
{
	global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

	$xtpl = new XTemplate( "exportpdf.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'DATA', $array_data );
	$xtpl->parse( 'huonghoa' );
	return $xtpl->text( 'huonghoa' );
}
function nv_theme_gia_pha_viewphado( $array_data, $parentid, $list_lev )
{
	global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;
	$xtpl = new XTemplate( "viewphado.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
	$xtpl->assign( 'TEMPLATE', $module_info['template'] );
	$xtpl->assign( 'module_file', $module_file );
	$xtpl->assign( 'list_level', sprintf( $lang_module['list_level'], implode( ",", $list_lev ) ) );
	if( ! empty( $array_data ) )
	{
		foreach( $parentid as $par )
		{
			$xtpl->assign( 'DATATREE', nv_viewdirtree_genealogy_phado( $array_data, $par ) );
			$xtpl->parse( 'main.foldertree' );
		}
	}
	else
	{
		$xtpl->parse( 'main.no_users' );
	}
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function nv_viewdirtree_genealogy_phado( $array_data, $parentid = 0 )
{
	global $module_info, $module_file;
	$_dirlist = $array_data[$parentid];
	//print_r($_dirlist);die();
	$content = "";
	foreach( $_dirlist as $_dir )
	{
		if( $_dir['relationships'] == 1 )
		{
			switch( $_dir['gender'] )
			{
				case 1:
					$_dir['class'] = 'male';
					break;
				case 2:
					$_dir['class'] = 'female';
					break;
				default:
					$_dir['class'] = 'default';
					break;
			}

			$xtpl = new XTemplate( "viewphado.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
			$xtpl->assign( 'module_file', $module_file );
			$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
			$xtpl->assign( 'TEMPLATE', $module_info['template'] );
			if( isset( $array_data[$_dir['id']] ) )
			{
				$_dirlist_wife = $array_data[$_dir['id']];
				foreach( $_dirlist_wife as $_dir_wife )
				{
					if( $_dir_wife['relationships'] != 1 )
					{
						switch( $_dir_wife['gender'] )
						{
							case 1:
								$_dir_wife['class'] = 'male';
								break;
							case 2:
								$_dir_wife['class'] = 'female';
								break;
							default:
								$_dir_wife['class'] = 'default';
								break;
						}
						$xtpl->assign( "WIFE", $_dir_wife );
						$xtpl->parse( 'tree.wife' );
					}
				}
				$content2 = nv_viewdirtree_genealogy_phado( $array_data, $_dir['id'] );
				if( ! empty( $content2 ) )
				{
					$xtpl->assign( "TREE_CONTENT", $content2 );
					$xtpl->parse( 'tree.tree_content.loop' );
				}
				$xtpl->parse( 'tree.tree_content' );
			}
			$xtpl->assign( "DIRTREE", $_dir );
			$xtpl->parse( 'tree' );
			$content .= $xtpl->text( 'tree' );
		}
	}
	return $content;
}

function nv_theme_gia_pha_export_detail( $row_genealogy, $row_detail )
{
	global $global_config, $module_name, $module_file, $lang_module, $module_info;

	$xtpl = new XTemplate( "export-detail.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'GENEALOGY', $row_genealogy );
	$array_key = array(
		'full_name',
		'gender',
		'status',
		'code',
		'name1',
		'name2',
		'birthday',
		'dieday',
		'life',
		'burial' );
	$i = 0;

	$lang_module['u_life'] = ( $row_detail['life'] >= 50 ) ? $lang_module['u_life_ht'] : $lang_module['u_life_hd'];

	foreach( $array_key as $key )
	{
		if( $row_detail[$key] != "" )
		{
			$i++;
			$dataloop = array(
				'class' => ( $i % 2 == 0 ) ? 'class="second"' : '',
				'lang' => $lang_module['u_' . $key],
				'value' => $row_detail[$key] );
			$xtpl->assign( 'DATALOOP', $dataloop );
			$xtpl->parse( 'main.loop' );
		}
	}
	$xtpl->assign( 'DATA', $row_detail );

	if( ! empty( $row_detail['content'] ) )
	{
		$xtpl->parse( 'main.content' );
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

?>