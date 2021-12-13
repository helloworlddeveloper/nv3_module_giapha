<!-- BEGIN: main -->
<link type="text/css" href="{NV_BASE_SITEURL}js/ui/jquery.ui.core.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}js/ui/jquery.ui.theme.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}js/ui/jquery.ui.dialog.css" rel="stylesheet" />
<script type="text/javascript" src="{NV_BASE_SITEURL}js/jquery/jquery.treeview.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}js/ui/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}js/ui/jquery.ui.dialog.min.js"></script>
<table class="tab1" width="100%">
	<thead align="center">
		<td>STT</td>
		<td>Họ tên</td>
		<td>Ngày mất</td>
		<td>Hiển thị ngoài site</td>
		<td>&nbsp;</td>
	</thead>
	<!-- BEGIN: loop -->
	<tbody {DATALOOP.class}>
		<tr>
			<td align="center">{DATALOOP.number}</td>
			<td>{DATALOOP.full_name}</td>
			<!-- BEGIN: input -->
			<td>
			<input type="text" value="{DATALOOP.dieday_view}" id="input_anniversary_{DATALOOP.id}" maxlength="10"/>
			<input type="button" onclick="nv_chang_anniversary('{DATALOOP.id}')" value="Cập nhật"/>
			</td>
			<!-- END: input -->
			<!-- BEGIN: text -->
			<td>{DATALOOP.dieday_view}</td>
			<!-- END: text -->
			<td align="center">
			<input type="checkbox" onclick="nv_chang_act('{DATALOOP.id}','{DATALOOP.actanniversary}')" id="change_act_{DATALOOP.id}" {DATALOOP.show_anniversary}>
			</td>
			<td align="center"><span class="edit_icon"><a href="javascript:void(0);" onclick="nv_edit_genealogy_users('{DATALOOP.id}')">Sửa</a></span></td>
		</tr>
	</tbody>
	<!-- END: loop -->
</table>
<div id="create_genealogy_users" style="overflow:auto;display:none;padding:10px;" title="{PAGE_TITLE}">
	<iframe id="modalIFrame" width="100%" height="100%" marginWidth="0" marginHeight="0" frameBorder="0" scrolling="auto"></iframe>
</div>
<script type="text/javascript">
	function nv_chang_anniversary(id) {
		var anniversary = strip_tags(document.getElementById('input_anniversary_' + id).value);
		if(anniversary != '') {
			nv_ajax('post', script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=anniversary&anniversary=' + encodeURIComponent(anniversary) + '&gid={GID}&id=' + id, '', 'nv_chang_anniversary_res');
		}
		return false;
	}

	function nv_chang_anniversary_res(res) {
		if( res = "OK") {
			alert("Cập nhật thành công");
		} else {
			alert("Lỗi: hệ thống không cập nhật được, vui lòng kiểm tra lại dữ liệu nhập vào");
		}

		return false;
	}

	function nv_chang_act(id, actanniversary) {
		var nv_timer = nv_settimeout_disable('change_act_' + id, 5000);
		window.location = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=anniversary&gid={GID}&id=' + id + '&actanniversary=' + actanniversary + '&num=' + nv_randomPassword(8);
		return;
	}

	function nv_edit_genealogy_users(id) {
		$("div#create_genealogy_users").dialog({
			autoOpen : false,
			width : 800,
			height : 550,
			modal : true,
			position : "center"
		}).dialog("open");
		$("#modalIFrame").attr('src', script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=users&opanniversary=1&id=' + id);
	}
</script>
<!-- END: main -->