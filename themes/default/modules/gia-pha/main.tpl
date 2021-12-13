<!-- BEGIN: main -->
<div id="biagiapha">
	<div class="header">
		<b> CỘNG HOÀ XÃ HỘI CHỦ NGHĨA VIỆT NAM
		<br/>
		HỘI ĐỒNG {DATA.family} TỘC VIỆT NAM</b>
		<br/>
		TỈNH&nbsp;{DATA.location}
	</div>
	<div id="tengiapha">
		GIA PHẢ
	</div>
	<div style="font-size: 25px; font-weight: 700; text-transform:uppercase; color: #024105;">
		Họ {DATA.family}
	</div>
	<div style="font-size: 20px;">
		{DATA.title}
	</div>
	<div style="padding: 100px 0px 40px 80px">
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
<div style="text-align:center;padding:10px; width:auto;max-width: 620px; *width:620px; margin: 0 auto;">
<form name="exportpdf">
    <table class="tab1" id="export">
        <tbody>
            <tr>
                <td style="width:10px"><input checked="checked" type="checkbox" value="biagp" name="biagp" /></td>
                <td>Bìa gia phả</td>
                <td><input checked="checked" type="checkbox" value="phaky" name="phaky" /></td>
                <td>Phả ký</td>
                <td><input checked="checked" type="checkbox" value="phado" name="phado" /></td>
                <td>Phả đồ</td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td><input checked="checked" type="checkbox" value="tocuoc" name="tocuoc" /></td>
                <td>Tộc ước</td>
                <td><input checked="checked" type="checkbox" value="huonghoa" name="huonghoa" /></td>
                <td>Hương hỏa</td>
                <td><input checked="checked" type="checkbox" value="ngaygio" name="ngaygio" /></td>
                <td>Ngày giỗ</td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td><input checked="checked" type="checkbox" value="thanhvien" name="thanhvien" /></td>
                <td>Chi tiết thành viên</td>
                <td colspan="4"><span id="loadbar"><input type="button" name="exportpdf" value="Xuất dữ liệu ra PDF" /></span></td>
            </tr>
        </tbody>
    </table>
</form>    
</div>
<script type="text/javascript">
//<![CDATA[
    var arrayop = '{arrayop}';
    var link = nv_siteroot + "index.php?" + nv_lang_variable + "=" + nv_sitelang + "&" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=exportpdf";
    $("input[name=exportpdf]").click(function(){
        $("#loadbar").html("Đang tải... <img src='{NV_BASE_SITEURL}images/load_bar.gif' alt='' />");
        var show = "";
        $("#export input:checked").each(function(){
             
            show = show + "-" + $(this).val();
        });
        show = show.substring(1);
        if( show == "" ){
            alert("Bạn phải chọn ít nhất 1 thông tin đễ xuất dữ liệu");
            return;
        }
        window.location.href = link + '/' + show + '/' + arrayop;
    });
//]]>    
</script>
<!-- END: main -->