<!-- BEGIN: main -->
<table class="tabnkv" summary="">
	<caption>
		{LANG.location_maps}
	</caption>
	<col style="width: 25%"/>
	<col style="width: 25%"/>
	<col style="width: 25%"/>
	<col style="width: 25%"/>
	<!-- BEGIN: looptr -->
	<tbody{CLASS}>
		<tr>
			<!-- BEGIN: looptd -->
			<td><a title="{DATA.title}" href="{DATA.link}"><b>{DATA.title}</b></a><!-- BEGIN: number -->
			<br>
			(Có: <span style="color: red;">{DATA.number}</span> Gia phả)<!-- END: number --></td>
			<!-- END: looptd -->
		</tr>
		</tbody> <!-- END: looptr -->
</table>
<br>
<!-- END: main -->