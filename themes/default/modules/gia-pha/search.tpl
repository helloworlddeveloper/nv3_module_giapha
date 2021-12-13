<!-- BEGIN: main -->
    <div style="padding:10px">
    {LANG.search_result} : <!-- BEGIN: location -->{LANG.search_result_in} <strong>{LOCATION.title}</strong> &nbsp; <!-- END: location -->
        <!-- BEGIN: textfield -->{LANG.search_result_keyword}&nbsp;<strong>{textfield}</strong><!-- END: textfield -->
    </div>
    <!-- BEGIN: noresult -->
    <div style="text-align:center;"><strong>{LANG.search_noresult}</strong></div>
    <!-- END: noresult -->
    <!-- BEGIN: bylocation -->
    <table class="tabnkv" summary="">
    	<!-- BEGIN: loop -->
    	<tbody{CLASS}>
    		<tr>
    			<td>{DATA.number}</td>
    			<td><a title="{DATA.title}" href="{DATA.link}"><b>{DATA.title}</b></a></td>
    		</tr>
    		</tbody> <!-- END: loop -->
    </table>
    <!-- END: bylocation -->
    <!-- BEGIN: bygiapha -->
    <table class="tabnkv" summary="">
    	<!-- BEGIN: loop -->
        	<tbody{CLASS}>
    		<tr>
    			<td><a title="{DATA.title}" href="{DATA.link}">{DATA.full_name}</a></td>
    			<td>{DATA.title}</td>
    		</tr>
    		</tbody> 
        <!-- END: loop -->
    </table>
    <!-- END: bygiapha -->
<!-- END: main -->