<!-- BEGIN: main -->
<form action="{NV_ACTION_FILE}" method="post">
	<table class="tab1" width="100%">
		<caption>Thông tin chi họ</caption>
		<tbody>
			<tr>
				<td>Chi họ</td>
				<td>
				<select name="fid">
					<option value="0">-- Chọn chi họ hoặc nhập tên chi họ --</option>
					<!-- BEGIN: family -->
					<option value="{FAMILY.fid}"{FAMILY.selected}>{FAMILY.title}</option>
					<!-- END: family -->
				</select>
				<input name="fidname" value="{DATA.fidname}" maxlength="50" style="width: 250px;" type="text">
				<span style="color: #CC0000">(*)</span>
				</td>
			</tr>
		</tbody>
		<tbody class="second">
			<tr>
				<td>Thông tin chi họ:</span></td>
				<td>
				<input name="title" value="{DATA.title}" maxlength="255" style="width: 450px;" type="text"> <span style="color: #CC0000">(*)</span>
				<br>
				<br>
				(ghi chú phần này chỉ nhập nội dung đến Quận huyện. VD: Thôn Thọ Hạ, Quảng Sơn, Quảng Trạch)
				<br>
				</td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td>Tỉnh/TP:</td>
				<td>
				<select name="locationid">
					<option value="0">-- Chọn tỉnh --</option>
					<!-- BEGIN: location -->
					<option value="{LOCATION.locationid}" {LOCATION.selected}>{LOCATION.title}</option>
					<!-- END: location -->
				</select> <span style="color: #CC0000">(*)</span></td>
			</tr>
		</tbody>
		<tbody class="second">
			<tr>
				<td colspan="2"><b>Phả ký</b> (nguồn gốc xuất xứ của gia tộc, hành trạng của Thuỷ tổ)
				<br>
				<br>
				{DATA.description}</td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td colspan="2"><b>Tộc ước </b>(Các quy định của dòng họ)
				<br>
				<br>
				{DATA.rule}</td>
			</tr>
		</tbody>
		<tbody class="second">
			<tr>
				<td colspan="2"><b>Từ đường - Hương hoả</b> Ghi chép về phần đất (lăng mộ dòng họ) tài sản dòng họ( Vật thể như nhà thờ, phi vật thể như các bài cúng, tế ...)
				<br>
				<br>
				{DATA.content}</td>
			</tr>
		</tbody>
	</table>
	
	<table class="tab1" width="100%">
		<caption>Thông tin biên soạn</caption>		
		<tbody class="second">
			<tr>
				<td>Năm biên soạn:</span></td>
				<td>
				<input name="years" value="{DATA.years}" maxlength="55" style="width: 200px;" type="text">
				</td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td>Người biên soạn:</span></td>
				<td>
				<input name="author" value="{DATA.author}" maxlength="255" style="width: 450px;" type="text">
				</td>
			</tr>
		</tbody >
		<tbody class="second">
			<tr>
				<td>Người liên hệ:</span></td>
				<td>
				<input name="full_name" value="{DATA.full_name}" maxlength="255" style="width: 450px;" type="text">
				</td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td>Điện thoại:</span></td>
				<td>
				<input name="telephone" value="{DATA.telephone}" maxlength="255" style="width: 200px;" type="text">
				</td>
			</tr>
		</tbody>
		<tbody  class="second">
			<tr>
				<td>Email:</span></td>
				<td>
				<input name="email" value="{DATA.email}" maxlength="255" style="width: 450px;" type="text">
				</td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td>Thành viên được xem gia phả:</td>
				<td>
				<select name="who_view">
					<!-- BEGIN: who_view -->
					<option value="{WHO_VIEW.id}" {WHO_VIEW.selected}>{WHO_VIEW.title}</option>
					<!-- END: who_view -->
				</select> <span style="color: #CC0000">(*)</span></td>
			</tr>
		</tbody>		
	</table>
	<div style="text-align: center">
		<input name="gid" type="hidden" value="{DATA.gid}" />
		<input name="submit" type="submit" value="{LANG.save}" style="width: 200px;" />
	</div>
	<br/>
		Ghi chú: Nếu không nhập thông tin người liên hệ, hệ thống sẽ lấy thông tin của người tạo chi họ
		<br/><br/>
</form>
<!-- END: main -->
