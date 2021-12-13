<!-- BEGIN: biapg -->
<div style="color: #FFFFFF;text-align: center;margin:0 auto;">
	<div style="color: #FFFF00;font-size: 50px;padding-top: 10px;text-transform: uppercase;">
		<b> CỘNG HOÀ XÃ HỘI CHỦ NGHĨA VIỆT NAM
		<br/>
		HỘI ĐỒNG GIA TỘC </b>
		<br/>
		TỈNH&nbsp;{DATA.location}
	</div><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	<div style="color: #FBFE00;font-size: 100px;padding-top:300px;font-weight: bold;">
		GIA PHẢ
	</div>
	<div style="font-size: 80px; font-weight: bold; text-transform:uppercase; color: #024105;">
		Họ {DATA.family}
	</div>
	<div style="font-size: 60px;">
		{DATA.title}
	</div><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	<div style="font-size: 30px; text-transform:uppercase; height: 50px">
		<!-- BEGIN: years -->
		NĂM BIÊN SOẠN: {DATA.years}
		<!-- END: years -->
		<!-- BEGIN: author -->
		<br/>
		NGƯỜI BIÊN SOẠN: {DATA.author}
		<!-- END: author -->
	</div>
	<div style="font-size: 28px; padding-top: 8px;">
		Người liên hệ: {DATA.full_name}
		<br/>
		<!-- BEGIN: telephone -->
		Điện thoại: {DATA.telephone} - <!-- END: telephone -->
		Email: {DATA.email}
		<br/>
		Tổng số : {DATA.maxlev} đời, số thành viên trong gia phả {DATA.number}
	</div>
</div>
<!-- END: biapg -->
<!-- BEGIN: phaky -->
    {DATA.description}
    <div style="clear:both;">&nbsp;</div>
<!-- END: phaky -->
<!-- BEGIN: phado -->
    <!-- BEGIN: foldertree -->
    <ul id="foldertree" class="filetree">
    	{DATATREE}
    </ul>
    <!-- END: foldertree -->
    <div style="clear:both;">&nbsp;</div>
<!-- END: phado -->
<!-- BEGIN: tree -->
<li>
	<span {DIRTREE.class} id="iduser_{DIRTREE.id}">{DIRTREE.full_name}</span>
	<!-- BEGIN: wife -->
	- <span {WIFE.class} id="iduser_{WIFE.id}">{WIFE.full_name}</span>
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
<!-- BEGIN: tocuoc -->
    {DATA.rule}
    <div style="clear:both;">&nbsp;</div>
<!-- END: tocuoc -->
<!-- BEGIN: huonghoa -->
    {DATA.content}
    <div style="clear:both;">&nbsp;</div>
<!-- END: huonghoa -->
