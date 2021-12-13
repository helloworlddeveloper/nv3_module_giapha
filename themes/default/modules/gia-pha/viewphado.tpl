<!-- BEGIN: tree -->
<li style="padding: 3px 0 2px 16px; background: url('{NV_BASE_SITEURL}js/jquery/images/treeview-default-line.gif') no-repeat; margin: 0;">
	<span style="padding: 1px 0 1px 6px; ">{DIRTREE.lev} <img height="12px" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/{module_file}/{DIRTREE.class}.png" />{DIRTREE.full_name}</span>
	<!-- BEGIN: wife -->
	<span style="padding: 1px 0 1px 6px;"><span>- <img height="12px" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/{module_file}/{WIFE.class}.png" />{WIFE.full_name}</span></span>
	<!-- END: wife -->
	<!-- BEGIN: tree_content -->
	<ul style="margin-top: 4px; list-style: none; margin: 0;padding: 0;">
		<!-- BEGIN: loop -->
		{TREE_CONTENT} 
		<!-- END: loop -->
	</ul>
	<!-- END: tree_content -->
</li>
<!-- END: tree -->
<!-- BEGIN: main -->
<span>{list_level}</span>
<!-- BEGIN: foldertree -->
<ul style="list-style: none;margin: 0;padding:0;font-size:25px;">
	{DATATREE}
</ul>
<!-- END: foldertree -->
<!-- END: main -->