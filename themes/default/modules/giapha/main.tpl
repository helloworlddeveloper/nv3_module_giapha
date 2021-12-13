<!-- BEGIN: main -->
<div style="text-align: center; border:3px solid #6F3700;  height: 620px;">
	<div style="font-size: 14px; padding-top: 20px; text-transform:uppercase">
		<b> CỘNG HOÀ XÃ HỘI CHỦ NGHĨA VIỆT NAM
		<br/>
		HỘI ĐỒNG TRƯƠNG TỘC VIỆT NAM </b>
		<br/>
		{DATA.location} TỈNH
	</div>
	<div style="font-size: 44px; padding: 70px; font-weight: 700">
		GIA PHẢ
	</div>
	<div style="font-size: 25px; font-weight: 700; text-transform:uppercase">
		Họ {DATA.family}
	</div>
	<div style="font-size: 20px;">
		{DATA.title}
	</div>
	<div style="padding: 40px 0px 40px 100px">
		<ul class="list-genealogy clearfix">
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
			<li>
				<a href="{DATA.link_ngay_gio}">Danh sách ngày giỗ</a>
			</li>
		</ul>
	</div>
	<div style="font-size: 16px; text-transform:uppercase; height: 50px">
		<!-- BEGIN: years -->
		NĂM BIÊN SOẠN: {DATA.years}
		<!-- END: years -->
		<!-- BEGIN: author -->
		<br/>
		NGƯỜI BIÊN SOẠN: {DATA.author}
		<!-- END: author -->
	</div>
	<div style="font-size: 16px; padding-top: 8px;">
		Người liên hệ: {DATA.full_name}
		<br/>
		<!-- BEGIN: telephone -->
		Điện thoại: {DATA.telephone} - <!-- END: telephone -->
		Email: {DATA.email}
		<br/>
		Tổng số : {DATA.maxlev} đời, số thành viên trong gia phả {DATA.number}
	</div>
</div>
<!-- END: main -->