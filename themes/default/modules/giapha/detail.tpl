<!-- BEGIN: main -->
<ul class="list-genealogy clearfix">
	<li>
		<a href="{GENEALOGY.link_main}">Thông tin chung </a>
	</li>
	<li>
		<a href="{GENEALOGY.link_pha_ky}">Phả ký </a>
	</li>
	<li>
		<a href="{GENEALOGY.link_pha_do}">Phả đồ</a>
	</li>
	<li>
		<a href="{GENEALOGY.link_toc_uoc}">Tộc ước</a>
	</li>
	<li>
		<a href="{GENEALOGY.link_huong_hoa}">Hương Hoả</a>
	</li>
	<li>
		<a href="{GENEALOGY.link_ngay_gio}">Danh sách ngày giỗ</a>
	</li>
</ul>
<div class="fl">
	<table class="tabnkv" style="width: 530px">
		<caption>
			Đời thứ {DATA.lev}: {DATA.full_name}
		</caption>
		<col style="width: 180px" />
		<!-- BEGIN: loop -->
		<tbody {DATALOOP.class}>
			<tr>
				<td align="right">{DATALOOP.lang}:</td>
				<td>{DATALOOP.value}</td>
			</tr>
		</tbody>
		<!-- END: loop -->
	</table>
</div>
<div id="imghome" class="fr" style="width:150px;margin-top:40px;margin-right:10px;">
	<a href="{DATA.image}" title="" rel="shadowbox"><img alt="{DATA.full_name}" src="{DATA.image}" width="150"></a>
</div>
<div class="clearfix">
	&nbsp;
</div>
<!-- BEGIN: content -->
<table class=" tabnkv" style="width: 100%">
	<caption>
		{LANG.u_content}
	</caption>
	<tbody>
		<tr>
			<td>{DATA.content}</td></td>
		</tr>
	</tbody>
</table>
<!-- END: content -->

<!-- BEGIN: orgchart -->
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
	google.load('visualization', '1', {
		packages : ['orgchart']
	});

</script>
<script type="text/javascript">
	function drawVisualization() {
		// Create and populate the data table.
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Name');
		data.addColumn('string', 'Manager');
		data.addRows({DATACHARTROWS});
		
		<!-- BEGIN: looporgchart -->
			data.setCell({DATACHART.number}, 0, '{DATACHART.id}', '<a href="{DATACHART.link}">{DATACHART.full_name}</a>');
			<!-- BEGIN: looporgchart2 -->
			data.setCell({DATACHART.number}, 1, '{DATACHART.parentid}');
			<!-- END: looporgchart2 -->		
		<!-- END: looporgchart -->

		// Create and draw the visualization.
		new google.visualization.OrgChart(document.getElementById('visualization')).draw(data, {
			allowHtml : true
		});
	}
	google.setOnLoadCallback(drawVisualization);
</script>
<table class="tabnkv" width="100%">
	<caption>
		Sơ đồ gia phả
	</caption>
</table>
<div id="visualization" style="white-space : nowrap;"></div>
<br>
<!-- END: orgchart -->

<!-- BEGIN: parentid -->
<table class="tabnkv" width="100%">
	<caption>
		{PARENTIDCAPTION}
	</caption>
	<col style="width: 20px" />
	<col style="width: 180px" />
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
			<td><a href="{DATALOOP.link}">{DATALOOP.full_name}</a></td>
			<td> {DATALOOP.birthday}</td>
			<td> {DATALOOP.status}</td>
		</tr>
	</tbody>
	<!-- END: loop2 -->
</table>
<!-- BEGIN: parentid -->
<!-- END: main -->