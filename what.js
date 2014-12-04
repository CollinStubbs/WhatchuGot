// JavaScript Document

$("document").ready(function() {
	
	var url = String(window.location);   
	if (url.search("id=") > 0 ){
		var id = url.substr(url.lastIndexOf("=")+1, url.length);
		var uni = id.replace(/%20/g, " ");
		$("#univeristy").val("" + uni + "");
		$("tr").hide();
		$("tr:first").show();
		$("tr:contains("+ uni + ")").show();
	}
	
});

function filterUniversity(){
	$("tr").show();
	var num = $("#univeristy").val();
	$("tr").hide();
	$("tr:first").show();
	$("tr:contains("+ num + ")").show();
	
}

