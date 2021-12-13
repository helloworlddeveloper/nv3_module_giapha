<!-- BEGIN: main -->
<form name="search" action="{FORMACTION}" method="get" id="fsearch">
<div style="margin:5px;">
    {LANG.search_keyword}&nbsp;<input type="text" name="textfield" value="{textfield}" style="width:200px" />&nbsp;
    {LANG.search_for}&nbsp;
    <select name="location">
        <option value="0">{LANG.location}</option>
        <!-- BEGIN: location -->
        <option value="{LOCATION.locationid}"{LOCATION.sl}>{LOCATION.title}</option>
        <!-- END: location -->
    </select><br />
    {LANG.search_for1}&nbsp;
    <select name="searchtype">
        <!-- BEGIN: searchtype -->
        <option value="{KEY}"{SL}>{VAL}</option>
        <!-- END: searchtype -->
    </select>
    &nbsp;
    <input type="submit" value="Search" name="search" /> 
</div>
</form>
<script type="text/javascript">

var module = '{module}';

//<![CDATA[
$("#fsearch").submit(function() {
    
        var textfield = $("input[name=textfield]").val();
        var location = $("select[name=location]").val();
        var searchtype = $("select[name=searchtype]").val();
        if( searchtype == "0" && location == "0" && textfield == "" ){
            alert('{LANG.search_error1}');
            return!1
        }else{
             window.location.href = nv_siteroot + 'index.php?'+ nv_lang_variable +'='+nv_sitelang+'&'+nv_name_variable + '=' + module+'&'+ nv_fc_variable +'=search&textfield='+rawurlencode(textfield)+'&location='+location+'&searchtype='+searchtype;
        }
  return!1
});
</script>
<!-- END: main -->