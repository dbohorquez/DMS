$(document).ready(function(){
	$('.datepicker').datepicker($.datepicker.regional[ "es" ],{
		inline: true
	});	
	$('.colorbox').colorbox({opacity:0.4});
	$('table').tablesorter({widthFixed: true, widgets: ['zebra']}).tablesorterPager({container: $("#pagination")}); 

});

function colorbox(trigger,href){
	$(trigger).colorbox({inline:true, href:href, opacity:0.4});
}

function updateElm(elm,source){
	$.ajax({
	  url: source,
	  success: function(data) {
		$(elm).html(data);
	  }
	});
}

function addProduct(field,quantity,expDate,container,trigger){
	if(quantity < 1) quantity = 1;
	var xDate = $(expDate).attr('value');
	var product = $(field).attr('value');
	if(product != ''){
		var rand = Math.floor(Math.random()*10000000);
		$(container).append('<li id="item' + rand + '"><a href="javascript:void(0);" onclick="removeProduct($(this).parent());" class="icon delete" title="Remover Producto"><span>Remover Producto</span></a><span class="product-name">' + product + '</span><span class="product-quantity">x' + quantity + '</span></li>');
		$(container).parent().append('<input type="hidden" id="hitem' + rand + '" name="hitem' + rand + '" value="' + product + '" /><input type="hidden" id="citem' + rand + '" name="citem' + rand + '" value="' + quantity + '" /><input type="hidden" id="ditem' + rand + '" name="ditem' + rand + '" value="' + xDate + '" />');
	}
	$(field).attr('value','');
	$(expDate).attr('value','');
	$(field).focus();
	$(trigger).hide();
}

function removeProduct(product){
	var hiddenId = '#h' + product.attr('id');
	var qtyId = '#c' + product.attr('id');
	var dateId = '#d' + product.attr('id');
	product.remove();
	$(hiddenId).remove();
	$(qtyId).remove();
	$(dateId).remove();
}


/* Form Validation
============================================================ */

var reEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
var reFloat = /^((\d+(\.\d*)?)|((\d*\.)?\d+))$/;
var reInteger = /^\d+$/;

function isInteger(elem){
	return reInteger.test(elem.val());
}

function isEmail(elem){
	return reEmail.test(elem.val());
}

function isFloat(elem){
	return reFloat.test(elem.val());
}

function isNil(elem) {
	return elem.val().length == 0
}

function isSelected(elem) {
	return elem.val() != 0 && elem.val() != null
}

function atLeastOne(elem) {
	return elem.children().length > 0
}

function isPercentage(elem) {
	return isFloat(elem) && parseInt(elem.val()) > 0 && parseInt(elem.val()) < 100
}

function validateWarehouseForm(){
		valid = true
	  $("form input, form select").removeClass("error")
		if (isNil($("#name")))
		{ valid= false; $("#name").addClass("error") }
		if (!isSelected($("#town")))
		{ valid= false; $("#town").addClass("error") }
		if ( !isNil($("#occupation")) && !isPercentage($("#occupation")) )
		{ valid= false; $("#occupation").addClass("error") }
		
		if (!valid){	
			$("#errorMessage").html("Por favor digite todos los campos obligatorios (<span class=\"required\">*</span>).");
			$("#errorMessage").show();
			$.colorbox.resize();
		}
    return valid;
}

function validateTransferForm(){
		valid = true
	  $("form input").removeClass("error")
	
		if (!atLeastOne($(".product-list.text")))
		{ valid= false; $(".product-list.text").addClass("error") }
		
		if (!valid){
			$("#errorMessage").html("Por favor digite todos los campos obligatorios (<span class=\"required\">*</span>).");
			$("#errorMessage").show();
			$.colorbox.resize();
		}
    return valid;
}