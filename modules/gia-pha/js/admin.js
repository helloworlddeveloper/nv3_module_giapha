/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Sun, 17 Jul 2011 03:36:01 GMT
 */

function nv_chang_status_location(cuid, parentid) {
	var nv_timer = nv_settimeout_disable('change_status_' + cuid, 5000);
	var new_status = document.getElementById('change_status_' + cuid).options[document.getElementById('change_status_' + cuid).selectedIndex].value;
	nv_ajax("post", script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=change_status_location&cuid=' + cuid + '&parentid=' + parentid + '&new_status=' + new_status + '&num=' + nv_randomPassword(8), '', '');
	setTimeout('', 2000);
	window.location = 'index.php?' + nv_name_variable + '=' + nv_module_name + '&op=location&parentid=' + parentid;
	return;
}

function nv_chang_weight_location(cuid, parentid) {
	var nv_timer = nv_settimeout_disable('change_weight_' + cuid, 5000);
	var new_weight = document.getElementById('change_weight_' + cuid).options[document.getElementById('change_weight_' + cuid).selectedIndex].value;
	nv_ajax("post", script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=change_weight_location&cuid=' + cuid + '&parentid=' + parentid + '&new_weight=' + new_weight + '&num=' + nv_randomPassword(8), '', 'nv_chang_weight_location_res');
}
function nv_chang_weight_location_res(){
	window.location.href = window.location.href;
	return;
}

function nv_del_location(cuid, parentid, num) {
	if(num > 0) {
		if(confirm("Danh mục này tồn tại " + num + " danh mục con, Nếu đồng ý, các danh mục con sẽ bị xóa. Bạn có muốn tiếp tục xóa?")) {
			nv_ajax('post', script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=location_del&cuid=' + cuid + '&parentid=' + parentid + '&num=' + num, '', 'nv_del_location_result');
		}
	} else {
		if(confirm(nv_is_del_confirm[0])) {
			nv_ajax('post', script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=location_del&cuid=' + cuid + '&parentid=' + parentid + '&num=' + num, '', 'nv_del_location_result');
		}
	}
	return false;
}
function nv_del_location_result(res) {
	window.location.href = window.location.href;
	return false;
}

function get_alias(mod, id) {
	var title = strip_tags(document.getElementById('idtitle').value);
	if(title != '') {
		nv_ajax('post', script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=alias&title=' + encodeURIComponent(title) + '&mod=' + mod + '&id=' + id, '', 'res_get_alias');
	}
	return false;
}

function res_get_alias(res) {
	if(res != "") {
		document.getElementById('idalias').value = res;
	} else {
		document.getElementById('idalias').value = '';
	}
	return false;
}

// ---------------------------------------

function nv_del_family(fid) {
	if(confirm(nv_is_del_confirm[0])) {
		nv_ajax('post', script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=del_family&fid=' + fid, '', 'nv_del_family_result');
	}
	return false;
}

function nv_del_family_result(res) {
	var r_split = res.split("_");
	if(r_split[0] == 'OK') {
		nv_show_list_family();
	} else if(r_split[0] == 'ERR') {
		alert(r_split[1]);
	} else {
		alert(nv_is_del_confirm[2]);
	}
	return false;
}

function nv_chang_family(fid, mod) {
	var nv_timer = nv_settimeout_disable('id_' + mod + '_' + fid, 5000);
	var new_vid = document.getElementById('id_' + mod + '_' + fid).options[document.getElementById('id_' + mod + '_' + fid).selectedIndex].value;
	nv_ajax("post", script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=chang_family&fid=' + fid + '&mod=' + mod + '&new_vid=' + new_vid + '&num=' + nv_randomPassword(8), '', 'nv_chang_family_result');
	return;
}

function nv_chang_family_result(res) {
	var r_split = res.split("_");
	if(r_split[0] != 'OK') {
		alert(nv_is_change_act_confirm[2]);
	}
	clearTimeout(nv_timer);
	nv_show_list_family();
	return;
}

function nv_show_list_family() {
	if(document.getElementById('module_show_list')) {
		nv_ajax("get", script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=list_family&num=' + nv_randomPassword(8), 'module_show_list');
	}
	return;
}

// ---------------------------------------

function nv_del_genealogy(gid) {
	if(confirm(nv_is_del_confirm[0])) {
		nv_ajax('post', script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=del_genealogy&gid=' + gid, '', 'nv_del_genealogy_result');
	}
	return false;
}

function nv_del_genealogy_result(res) {
	var r_split = res.split("_");
	if(r_split[0] == 'OK') {
		nv_show_list_genealogy();
	} else if(r_split[0] == 'ERR') {
		alert(r_split[1]);
	} else {
		alert(nv_is_del_confirm[2]);
	}
	return false;
}

function nv_chang_genealogy(gid, mod) {
	var nv_timer = nv_settimeout_disable('id_' + mod + '_' + gid, 5000);
	var new_vid = document.getElementById('id_' + mod + '_' + gid).options[document.getElementById('id_' + mod + '_' + gid).selectedIndex].value;
	nv_ajax("post", script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=chang_genealogy&gid=' + gid + '&mod=' + mod + '&new_vid=' + new_vid + '&num=' + nv_randomPassword(8), '', 'nv_chang_genealogy_result');
	return;
}

function nv_chang_genealogy_result(res) {
	var r_split = res.split("_");
	if(r_split[0] != 'OK') {
		alert(nv_is_change_act_confirm[2]);
	}
	clearTimeout(nv_timer);
	nv_show_list_genealogy();
	return;
}

function nv_show_list_genealogy() {
	if(document.getElementById('module_show_list')) {
		nv_ajax("get", script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=list_genealogy&num=' + nv_randomPassword(8), 'module_show_list');
	}
	return;
}