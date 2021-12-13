<!-- BEGIN: main -->
	<!-- BEGIN: error -->	
		<blockquote class="error"><span>"{ERROR}"</span></blockquote>
	<!-- END: error -->

<!-- BEGIN: data -->
<a href="{comeback}">{back}</a>
<table class="tab1">
	 <thead>
	 	<tr >
		    <th width="5%" style="font-size:13px; font-weight:bold;">{LANG.thutu}</th>
		    <th width="40%" style="font-size:13px; font-weight:bold;">{LANG.title_location}</th>
		   <th width="20%" style="font-size:13px; font-weight:bold;">{LANG.view}</th>
		    <th width="30%" style="font-size:13px; font-weight:bold;">{LANG.action}</th>
  		</tr>
	 
	 </thead>
		<!-- BEGIN: loop -->
		<tr>
			<tbody {class}>
			<td>
			   <select id="change_weight_{cuid}" onchange="nv_chang_weight_location('{cuid}','{parentid}','weight');">
				<!-- BEGIN: loop1 -->
					<option value="{stt}" {select}>{stt}</option>
				<!-- END: loop1 -->
				</select>
			</td>
			
			<td>
				<a href="{link_cu}">{title}</a><span style="color:#FF0000"> {num}</span>
			</td>
			
			<td>
	    	<select id="change_status_{cuid}" onchange="nv_chang_status_location('{cuid}','{parentid}','status');">
			<!-- BEGIN: loop2 -->
				<option value="{key}" {sel}>{value}</option>
			<!-- END: loop2 -->
			</select>	    
	    </td>	       	
			<td>
				<span class="edit_icon"><a href="{editlink}#edit">{LANG.edit}</a></span> 
		       &nbsp;-&nbsp;
		       <span class="delete_icon"><a href="javascript:void(0);" onclick= "nv_del_location('{cuid}','{parentid}','{nu}');" >{LANG.del}</a></span>
	       </td>
			
		</tr>
		</tbody>
		<!-- END: loop -->
	
	
</table>

<!-- END: data -->


<form action="{FORM_ACTION}" method="post" >
	<table class="tab1" id="edit">
		<tbody>
		<tr>
			<td>{LANG.title_location} <strong>( {title_cata} )</strong></td>
			<td style="width:10px">(<span style="color:#FF0000">*</span>)</td>
			<td><input type="text" value="{title_cu}" name="title" style="width:350px">
			<input type="hidden" value="{location_id}" name="cuid" style="width:350px">
			<input type="hidden" value="{parent_id}" name="parentid_old" style="width:350px"></td>
		</tr>
		</tbody>
		
		<tbody class="second">
		<tr>
			<td>{LANG.alias}</td> <td></td>
			<td><input type="text" value="{alias}" name="alias" style="width:350px"></td>
		</tr>
		</tbody>
		
		<tbody>
		<tr>
			<td>{LANG.danhmuc_location}</td>
			<td style="width:10px"></td>
			 <td><strong>{title_cata}</strong></td>
		</tr>
		</tbody >
		
		<tbody>
		<tr>
		 	<td colspan="3"><input type="submit" name="save" value="{LANG.save}"></td>
		 				 			
		 	</tr>
	</tbody>
	
	</table>
</form>
<!-- END: main -->