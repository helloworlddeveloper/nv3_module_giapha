<!-- BEGIN: main -->
<ul class="list-genealogy clearfix">
	<li>
		<a href="{DATA.link_main}">Thông tin chung </a>
	</li>
	<li >
		<a href="{DATA.link_pha_ky}">Phả ký </a>
	</li>
	<li>
		<a href="{DATA.link_pha_do}">Phả đồ</a>
	</li>
	<li >
		<a href="{DATA.link_toc_uoc}">Tộc ước</a>
	</li>
	<li >
		<a href="{DATA.link_huong_hoa}">Hương Hoả</a>
	</li>
	<li class="ui-genealogys-selected">
		<a href="{DATA.link_ngay_gio}">Danh sách ngày giỗ</a>
	</li>
</ul>
<table class="tabnkv" width="100%">
	<caption>
		Ngày giỗ: {DATA.title}
	</caption>
	<tbody>
		<thead>
		<tr>
			<td>Số Thứ tự</td>
			<td>Ngày giỗ</td>
			<td>Họ và tên</td>
		</tr>
		</thead>
	<!-- BEGIN: loop -->
	<tbody {ANNIVERSARY.class}>
		<tr>
			<td>{ANNIVERSARY.number}</td>
			<td>{ANNIVERSARY.date}</td>
			<td>{ANNIVERSARY.full_name}</td>
		</tr>
	</tbody>
	<!-- END: loop -->
</table>
<!-- END: main -->