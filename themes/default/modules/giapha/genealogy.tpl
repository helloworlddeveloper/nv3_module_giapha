<!-- BEGIN: tree -->
<li>
	<span {DIRTREE.class} id="iduser_{DIRTREE.id}"><a href="{DIRTREE.link}">{DIRTREE.full_name}</a></span>
	<!-- BEGIN: wife -->
	- <span {WIFE.class} id="iduser_{WIFE.id}"><a href="{WIFE.link}">{WIFE.full_name}</a></span>
	<!-- END: wife -->
	<!-- BEGIN: tree_content -->
	<ul>
		<!-- BEGIN: loop -->
		{TREE_CONTENT} 
		<!-- END: loop -->
	</ul>
	<!-- END: tree_content -->
</li>
<!-- END: tree -->
<!-- BEGIN: main -->
<link type="text/css" href="{NV_BASE_SITEURL}js/jquery/jquery.treeview.css" rel="stylesheet" />
<script type="text/javascript" src="{NV_BASE_SITEURL}js/jquery/jquery.treeview.min.js"></script>
<ul class="list-genealogy clearfix">
	<li>
		<a href="{GENEALOGY.link_main}">Thông tin chung </a>
	</li>
	<li>
		<a href="{GENEALOGY.link_pha_ky}">Phả ký </a>
	</li>
	<li class="ui-genealogys-selected">
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

<!-- BEGIN: foldertree -->
<ul id="foldertree" class="filetree">
	{DATATREE}
</ul>
<script type="text/javascript">
	//<![CDATA[
	$(document).ready(function() {
		$("#foldertree").treeview();
	});
	//]]>
</script>
<!-- END: foldertree -->
<!-- END: main -->