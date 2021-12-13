<!-- BEGIN: main -->
	<table class="tabnkv" style="width: 100%">
        <tr>
            <td width="15%">
                <img alt="{DATA.full_name}" src="{DATA.image}" width="150" />
            </td>
            <td width="85%">
                <table cellspacing="0" cellpadding="1" border="1" width="100%">
                    <tr>
                        <td colspan="2">Đời thứ {DATA.lev}: {DATA.full_name}</td>
                    </tr>
                    <!-- BEGIN: loop -->
            			<tr>
            				<td width="30%" align="right">{DATALOOP.lang}</td>
            				<td width="70%">{DATALOOP.value}</td>
            			</tr>
            		<!-- END: loop -->
                </table>
            </td>
        </tr>
	</table>
<!-- BEGIN: content -->
<div><strong>{LANG.u_content}</strong></div>
<div>{DATA.content}</div>
<!-- END: content -->
<!-- BEGIN: parentid -->
<div>{PARENTIDCAPTION}</div>
<table cellspacing="0" cellpadding="1" border="1" width="100%">
	<thead>
		<td>STT</td>
		<td>Họ tên</td>
		<td>Ngày Sinh</td>
		<td>Trạng thái</td>
	</thead>
	<!-- BEGIN: loop2 -->
	<tbody {DATALOOP.class}>
		<tr>
			<td align="right">{DATALOOP.number}</td>
			<td>{DATALOOP.full_name}</td>
			<td> {DATALOOP.birthday}</td>
			<td> {DATALOOP.status}</td>
		</tr>
	</tbody>
	<!-- END: loop2 -->
</table>
<!-- BEGIN: parentid -->
<!-- END: main -->