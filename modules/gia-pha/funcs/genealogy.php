<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Sun, 17 Jul 2011 03:36:01 GMT
 */

if (!defined('NV_IS_MOD_GIA_PHA'))
    die('Stop!!!');

if (defined('NV_IS_USER'))
{
    if (defined('NV_EDITOR'))
    {
        require_once (NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php');
    }
    else
    {
        define('NV_EDITOR', 'ckeditor');
        require_once (NV_ROOTDIR . '/' . NV_EDITORSDIR . '/ckeditor/ckeditor_php5.php');
        function nv_aleditor($textareaname, $width = "100%", $height = '450px', $val = '')
        {
            global $module_name, $client_info;

            $CKEditor = new CKEditor();
            $CKEditor->returnOutput = true;

            $editortoolbar = array( array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', '-', 'Link', 'Unlink', 'Anchor', '-', 'Image', 'Flash', 'Table', 'Font', 'FontSize', 'RemoveFormat', 'Templates', 'Maximize'), array('Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote', 'CreateDiv', '-', 'TextColor', 'BGColor', 'SpecialChar', 'Smiley', 'PageBreak', 'Source', 'About'));

            $CKEditor->config['skin'] = 'v2';
            $CKEditor->config['entities'] = false;
            $CKEditor->config['enterMode'] = 2;
            $CKEditor->config['language'] = NV_LANG_INTERFACE;
            $CKEditor->config['toolbar'] = $editortoolbar;
            $CKEditor->config['pasteFromWordRemoveFontStyles'] = true;

            // Path to CKEditor directory, ideally instead of relative dir, use an absolute path:
            //   $CKEditor->basePath = '/ckeditor/'
            // If not set, CKEditor will try to detect the correct path.
            $CKEditor->basePath = NV_BASE_SITEURL . '' . NV_EDITORSDIR . '/ckeditor/';
            // Set global configuration (will be used by all instances of CKEditor).
            if (!empty($width))
            {
                $CKEditor->config['width'] = strpos($width, '%') ? $width : intval($width);
            }

            if (!empty($height))
            {
                $CKEditor->config['height'] = strpos($height, '%') ? $height : intval($height);
            }

            // Change default textarea attributes
            $CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);

            $val = nv_unhtmlspecialchars($val);
            return $CKEditor->editor($textareaname, $val);
        }

    }

    $post = array('description' => '', 'rule' => '', 'content' => '', 'status' => 0, 'who_view' => 0, 'fidname' => '');

    if ($nv_Request->get_string('submit', 'post') != "")
    {
        $post['gid'] = $nv_Request->get_int('gid', 'post', 0);

        $post['title'] = filter_text_input('title', 'post', '', 1);
        $post['fid'] = $nv_Request->get_int('fid', 'post', 0);
        $post['fidname'] = filter_text_input('fidname', 'post', '', 1);
        if (!empty($post['fidname']) and empty($post['fid']))
        {
            $alias_fid = change_alias($post['fidname']);
            list($post['fid']) = $db->sql_fetchrow($db->sql_query("SELECT `fid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_family` WHERE `alias`=" . $db->dbescape($alias_fid)));
            if (empty($post['fid']))
            {
                list($weight) = $db->sql_fetchrow($db->sql_query("SELECT max(`weight`) FROM `" . NV_PREFIXLANG . "_" . $module_data . "_family`"));
                $weight = intval($weight) + 1;
                $query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_family` (`fid`, `status`, `title`, `alias`, `description`, `weight`, `keywords`, `add_time`, `edit_time`) VALUES (NULL, 1, " . $db->dbescape($post['fidname']) . ", " . $db->dbescape($alias_fid) . ", '', " . $db->dbescape($weight) . ", " . $db->dbescape($post['fidname']) . ", UNIX_TIMESTAMP( ), UNIX_TIMESTAMP( ))";
                $post['fid'] = $db->sql_query_insert_id($query);
            }
            else
            {
                $post['fidname'] = '';
            }
        }
        else
        {
            $post['fidname'] = '';
        }

        $post['locationid'] = $nv_Request->get_int('locationid', 'post', 0);

        $post['description'] = $nv_Request->get_string('description', 'post', '');
        $post['description'] = defined('NV_EDITOR') ? nv_nl2br($post['description'], '') : nv_nl2br(nv_htmlspecialchars(strip_tags($post['description'])), '<br />');

        $post['rule'] = $nv_Request->get_string('rule', 'post', '');
        $post['rule'] = defined('NV_EDITOR') ? nv_nl2br($post['rule'], '') : nv_nl2br(nv_htmlspecialchars(strip_tags($post['rule'])), '<br />');

        $post['content'] = $nv_Request->get_string('content', 'post', '');
        $post['content'] = defined('NV_EDITOR') ? nv_nl2br($post['content'], '') : nv_nl2br(nv_htmlspecialchars(strip_tags($post['content'])), '<br />');

        $post['who_view'] = $nv_Request->get_int('who_view', 'post', 0);

        $post['years'] = filter_text_input('years', 'post', '', 1);
        $post['author'] = filter_text_input('author', 'post', '', 1);
        $post['full_name'] = filter_text_input('full_name', 'post', '', 1);
        $post['telephone'] = filter_text_input('telephone', 'post', '', 1);
        $post['email'] = filter_text_input('email', 'post', '', 1);

        if (!empty($post['title']) and $post['locationid'] > 0)
        {
            $post['alias'] = change_alias($post['title']);
            $post['userid'] = $user_info['userid'];
            if (empty($post['gid']))
            {
                $weight = 0;
                $post['gid'] = $db->sql_query_insert_id("INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` 
					(`gid`, `title`, `alias`, `weight`, `add_time`, `edit_time`, `userid`, `fid`, `locationid`, `description`, `rule`, `content`, `status`, `number`, `years`, `author`, `full_name`, `telephone`, `email`, `who_view`) 
            		VALUES 
            		(NULL, " . $db->dbescape_string($post['title']) . ", " . $db->dbescape_string($post['alias']) . ", '" . $weight . "', '" . NV_CURRENTTIME . "', '" . NV_CURRENTTIME . "', '" . $post['userid'] . "', '" . $post['fid'] . "', '" . $post['locationid'] . "', " . $db->dbescape_string($post['description']) . ", " . $db->dbescape_string($post['rule']) . ", " . $db->dbescape_string($post['content']) . ", '" . $post['status'] . "', 0, " . $db->dbescape_string($post['years']) . ", " . $db->dbescape_string($post['author']) . ", " . $db->dbescape_string($post['full_name']) . ", " . $db->dbescape_string($post['telephone']) . ", " . $db->dbescape_string($post['email']) . ", " . $db->dbescape_string($post['who_view']) . ")");

                if ($post['gid'] > 0)
                {
                    $query = "SELECT `gid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` ORDER BY `weight` ASC";
                    $weight = 0;
                    $result = $db->sql_query($query);
                    while ($row = $db->sql_fetchrow($result))
                    {
                        $weight++;
                        $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` SET `weight`=" . $weight . " WHERE `gid`=" . intval($row['gid']);
                        $db->sql_query($sql);
                    }
                    $db->sql_freeresult();
                    Header("Location: " . nv_url_rewrite(NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=manager", true));
                    die();
                }
            }
            else
            {
                $post_old = $db->sql_fetchrow($db->sql_query("SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` WHERE gid=" . $post['gid']));
                $db->sql_freeresult();
                if ($post_old['userid'] == $user_info['userid'])
                {
                    $update = $db->sql_query("UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` SET 
						`title`=" . $db->dbescape_string($post['title']) . ", 
						`alias`=" . $db->dbescape_string($post['alias']) . ", 
						`edit_time` = " . NV_CURRENTTIME . ", 
						`fid`=" . $post['fid'] . ", 
						`locationid`=" . $post['locationid'] . ",
						`description` =" . $db->dbescape_string($post['description']) . ", 
						`rule` =" . $db->dbescape_string($post['rule']) . ", 
						`content`=" . $db->dbescape_string($post['content']) . ", 
						`years`=" . $db->dbescape_string($post['years']) . ", 
						`author`=" . $db->dbescape_string($post['author']) . ", 
						`full_name`=" . $db->dbescape_string($post['full_name']) . ", 
						`telephone`=" . $db->dbescape_string($post['telephone']) . ", 
						`email`=" . $db->dbescape_string($post['email']) . ", 
						`who_view`=" . $db->dbescape_string($post['who_view']) . " 
					WHERE `gid` =" . $post['gid']);
                    if ($update)
                    {
                        nv_del_moduleCache($module_name);
                        Header("Location: " . nv_url_rewrite(NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=manager", true));
                        die();
                    }
                }
                else
                {
                    Header("Location: " . nv_url_rewrite(NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=manager", true));
                    exit();
                }
            }
        }
    }
    else
    {
        $post['fid'] = 0;
        $post['locationid'] = 0;
        $post['gid'] = $nv_Request->get_int('gid', 'get', 0);
        if ($post['gid'] > 0)
        {
            $post = $db->sql_fetchrow($db->sql_query("SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_genealogy` WHERE gid=" . $post['gid']));
            if (empty($post) or $post['userid'] != $user_info['userid'])
            {
                Header("Location: " . nv_url_rewrite(NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=manager", true));
                exit();
            }
        }
    }

    $xtpl = new XTemplate("manager-genealogy.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('NV_ACTION_FILE', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=genealogy");
    $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
    $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);

    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_family` ORDER BY `weight` ASC";
    $result = $db->sql_query($sql);
    while ($row = $db->sql_fetchrow($result))
    {
        $row['selected'] = ($row['fid'] == $post['fid']) ? ' selected="selected"' : '';
        $xtpl->assign('FAMILY', $row);
        $xtpl->parse('main.family');
    }

    $sql = "SELECT `locationid`, `title` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_location` WHERE `parentid`=0 ORDER BY `weight` ASC";
    $result = $db->sql_query($sql);
    while ($row = $db->sql_fetchrow($result))
    {
        $row['selected'] = ($row['locationid'] == $post['locationid']) ? ' selected="selected"' : '';
        $xtpl->assign('LOCATION', $row);
        $xtpl->parse('main.location');
    }

    if (nv_function_exists('nv_aleditor'))
    {
        $post['description'] = nv_aleditor('description', '100%', '200px', $post['description']);
        $post['rule'] = nv_aleditor('rule', '100%', '200px', $post['rule']);
        $post['content'] = nv_aleditor('content', '100%', '200px', $post['content']);
    }
    else
    {
        $post['description'] = "<textarea style=\"width: 100%\" name=\"description\" cols=\"20\" rows=\"15\">" . $post['description'] . "</textarea>";
        $post['rule'] = "<textarea style=\"width: 100%\" name=\"rule\" cols=\"20\" rows=\"15\">" . $post['rule'] . "</textarea>";
        $post['content'] = "<textarea style=\"width: 100%\" name=\"rule\" cols=\"20\" rows=\"15\">" . $post['content'] . "</textarea>";
    }
    $post['status_checked'] = ($post['status']) ? ' checked="checked"' : '';

    $array_who_view = array(0 => $lang_module['who_view0'], 1 => $lang_module['who_view1'], 2 => $lang_module['who_view2']);
    foreach ($array_who_view as $key => $value)
    {
        $row = array('id' => $key, 'title' => $value, 'selected' => ($key == $post['who_view']) ? ' selected="selected"' : '');

        $xtpl->assign('WHO_VIEW', $row);
        $xtpl->parse('main.who_view');
    }
    $xtpl->assign('DATA', $post);

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    $page_title = $module_info['custom_title'];
    $key_words = $module_info['keywords'];

    include (NV_ROOTDIR . "/includes/header.php");
    echo nv_site_theme($contents);
    include (NV_ROOTDIR . "/includes/footer.php");
}
else
{
    $redirect = "<meta http-equiv=\"Refresh\" content=\"2;URL=" . nv_url_rewrite(NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=users&" . NV_OP_VARIABLE . "=login&nv_redirect=" . nv_base64_encode($client_info['selfurl']), true) . "\" />";
    nv_info_die($lang_module['error_login_title'], $lang_module['error_login_title'], $lang_module['error_login_content'] . $redirect);
}
?>