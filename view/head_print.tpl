<html lang="pl">
<head>
<title>Satrapa</title>
<!--
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
-->
<link href="view/css/style_print.css" rel="stylesheet" type="text/css" />
<link href="view/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="view/smarty/libs/jquery/jquery-1.8.2.js"></script>
<script type="text/javascript" src="view/smarty/libs/jquery/jquery.searchabledropdown-1.0.8.src.js"></script>
<script type="text/javascript" src="view/smarty/libs/jquery/jquery-ui.js"></script>
<script type="text/javascript" src="view/smarty/libs/jquery/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="view/smarty/libs/jquery/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript">
 {literal}
 
 
<!-- 
function view(url, width, height) {
var Win = window.open(url,"displayWindow",'width=' + width + ',height=' + height + ',resizable=0,scrollbars=yes,menubar=no' );
}
//-->

 
 $(function() {
        $( "#datepicker" ).datetimepicker({
			showOn: "button",
            buttonImage: "view/img/calendar.gif",
            buttonImageOnly: true,
			dateFormat: "yy-mm-dd",
			timeFormat: 'HH:mm:ss'

			});		
    });
	
$(function() {
        $( "#datepicker1" ).datetimepicker({
			showOn: "button",
            buttonImage: "view/img/calendar.gif",
            buttonImageOnly: true,
			dateFormat: "yy-mm-dd",
			timeFormat: 'HH:mm:ss'
			});		
    });

	$(function() {
        $( "#datepicker2" ).datetimepicker({
			showOn: "button",
            buttonImage: "view/img/calendar.gif",
            buttonImageOnly: true,
			dateFormat: "yy-mm-dd",
			timeFormat: 'HH:mm:ss'
			});		
    });
	
$(function() {
        $( "#date" ).datepicker({
			showOn: "button",
            buttonImage: "view/img/calendar.gif",
            buttonImageOnly: true,
			dateFormat: "yy-mm-dd",
			timeFormat: 'HH:mm:ss'
			});		
    });
	
	

	
$(document).ready(function()
{
	$("#pokazCzesci").click(
	function()
	{
	$("#czesci").toggle();
	$("#statusy").toggle();
	});
});

$(document).ready(function()
{
	$("#schowajCzesci").click(
	function()
	{
	$("#czesci").toggle();
	$("#statusy").toggle();
	});

});


$(document).ready(function() {
            $('#btnAdd').click(function() {
                var num     = $('.clonedInput').size();
				//num = num + 1;
                var newNum  = new Number(num + 1);
 
                var newElem = $('#input' + num).clone().attr('id', 'input' + newNum);
 
                newElem.children(':first').attr('id', 'name' + newNum).attr('name', 'name' + newNum);
                $('#input' + num).after(newElem);
                $('#btnDel').show();
 $("select").searchable();
                if (newNum == 10)
                    $('#btnAdd').hide();
				
            });
			
			
 
            $('#btnDel').click(function() {
                var num = $('.clonedInput').length;
 
                $('#input' + num).remove();
                $('#btnAdd').show();
 
                if (num-1 == 1)
                   $('#btnDel').hide();
            });
 
            if (('#input2').lenght == 0) {
				$('#btnDel').hide();}
        });


$(document).ready(function()
{
	$("#link1").click(
	function()
	{
	$("#Box1").toggle();
	$("#Box2").toggle();
	});

});


$(document).ready(function() {
			$("select").searchable();
		});
	
	
		// demo functions
		$(document).ready(function() {
			$("#value").html($("#part :selected").text() + " (VALUE: " + $("#part").val() + ")");
			$("select").change(function(){
				$("#value").html(this.options[this.selectedIndex].text + " (VALUE: " + this.value + ")");
			});
		});
	
		function modifySelect() {
			$("select").get(0).selectedIndex = 5;
		}
	
		function appendSelectOption(str) {
			$("select").append("<option value=\"" + str + "\">" + str + "</option>");
		}
	
		function applyOptions() {			  
			$("select").searchable({
				maxListSize: $("#maxListSize").val(),
				maxMultiMatch: $("#maxMultiMatch").val(),
				latency: $("#latency").val(),
				exactMatch: $("#exactMatch").get(0).checked,
				wildcards: $("#wildcards").get(0).checked,
				ignoreCase: $("#ignoreCase").get(0).checked
			});
	
			alert(
				"OPTIONS\n---------------------------\n" + 
				"maxListSize: " + $("#maxListSize").val() + "\n" +
				"maxMultiMatch: " + $("#maxMultiMatch").val() + "\n" +
				"exactMatch: " + $("#exactMatch").get(0).checked + "\n"+
				"wildcards: " + $("#wildcards").get(0).checked + "\n" +
				"ignoreCase: " + $("#ignoreCase").get(0).checked + "\n" +
				"latency: " + $("#latency").val()
			);
		}
		

{/literal}
</script>
</head>
<body>
