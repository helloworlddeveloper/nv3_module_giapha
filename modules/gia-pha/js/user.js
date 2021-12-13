/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Sun, 17 Jul 2011 03:36:01 GMT
 */

function nv_del_genealogy(gid, checkss)
{
    if(confirm(nv_is_del_confirm[0]))
    {
        window.location = nv_siteroot + 'index.php?' + nv_lang_variable + '=' + nv_sitelang + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=manager&delgid=' + gid + '&checkss=' + checkss;
    }
    return false;
}