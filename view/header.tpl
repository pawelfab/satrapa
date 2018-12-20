<html lang="pl">
<head>
<title>Satrapa</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link href="view/css/style.css" rel="stylesheet" type="text/css" />
<link href="view/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="view/css/menustyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="view/smarty/libs/jquery/jquery-1.8.2.js"></script>
<script type="text/javascript" src="view/smarty/libs/jquery/jquery.searchabledropdown-1.0.8.src.js"></script>
<script type="text/javascript" src="view/smarty/libs/jquery/jquery-ui.js"></script>
<script type="text/javascript" src="view/smarty/libs/jquery/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="view/smarty/libs/jquery/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="view/smarty/libs/jquery/validate.js"></script>
<script type="text/javascript" src="view/smarty/libs/jquery/jquery.validate.js"></script>
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
		
//walidacja danych	

jQuery.validator.addMethod("alphanumericspecial", function(value, element) {
        return this.optional(element) || value == value.match(/^[-a-zA-Z\\\/\.\-0-9_ ]+$/);
        }, "Tylko litery, spacje, cyfry, myślnik oraz ukośniki");
		
jQuery.validator.addMethod("kodpoczt", function(value, element) {
        return this.optional(element) || value == value.match(/^[0-9]{5}/);
        }, "Kod pocztowy np. 03555");
		
jQuery.validator.addMethod("cena", function(value, element) {
        return this.optional(element) || value == value.match(/^[0-9]{2}\,[0-9]{2}/);
        }, "Wpisz prawidłową cenę np. 25,20");
		
jQuery.extend(jQuery.validator.messages, {
		 required: "Pole wymagane.",
});
		
$(document).ready(function(){
    $("#add_repair").validate({
	onkeyup: false,
		  rules: {
			nr_ser: {
			  required: true,
			  rangelength: [2, 20]
			  
			},
			kod_poczt: {
				required: true,
				kodpoczt: true
			}
		  },
  
		  messages: {
				
				nr_ser: {
					rangelength: "Musisz wpisać 2-20 znaków"
				},
			}
  
	});
	
	 $(".txt").each(function (item) {
            $(this).rules("add", {
                required: true,
                alphanumericspecial: true,
            });
        });
		
	
		
 });

$(document).ready(function(){
    $("#add_part").validate({
	onkeyup: false,
		  rules: {
			cena_sprzed: {
				required: true,
				cena: true
			}
		  } 
  
	});
	
	 $(".txt1").each(function (item) {
            $(this).rules("add", {
                required: true,
                alphanumericspecial: true
            });
        });
		
	
		
 }); 

{/literal}
</script>
</head>
<body>
