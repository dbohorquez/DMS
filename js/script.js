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

	var xDate = $(expDate).val(),
	 	product = $(field).val(),
		d1 = 0,
		d2 = 1
				
	if(xDate){
		var d1=new Date();
		d1.setDate(d1.getDate());
		d1.setHours(0,0,0)

		var d2= xDate.split(/\W+/);
		d2=new Date(d2[0]*1,d2[1]-1,d2[2]*1);
	}
		
	if( product != '' && d2 > d1 ) {
		var rand = Math.floor(Math.random()*10000000);
		$(container).append('<li id="item' + rand + '"><a href="javascript:void(0);" onclick="removeProduct($(this).parent());" class="icon delete" title="Remover Producto"><span>Remover Producto</span></a><span class="product-name">' + product + '</span><span class="product-quantity">x' + quantity + '</span></li>');
		$(container).parent().append('<input type="hidden" id="hitem' + rand + '" name="hitem' + rand + '" value="' + product + '" /><input type="hidden" id="citem' + rand + '" name="citem' + rand + '" value="' + quantity + '" /><input type="hidden" id="ditem' + rand + '" name="ditem' + rand + '" value="' + xDate + '" />');
		$(field).attr('value','');
		$(expDate).attr('value','');
		$(field).focus();
		$(trigger).hide();
	}else{
		$(field).addClass("error")
		$(expDate).addClass("error")
	}
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

function addProductAjax(field,quantityField,expDate,container,trigger, donationId, warehouseId, donationType){
	if(quantity < 1) quantity = 1;

	var xDate = $(expDate).val(),
	 	product = $(field).val(),
		quantity = quantityField.val(),
		d1 = 0,
		d2 = 1
		
	if(xDate){
		var d1=new Date();
		d1.setDate(d1.getDate());
		d1.setHours(0,0,0)
	
		var d2= xDate.split(/\W+/);
		d2=new Date(d2[0]*1,d2[1]-1,d2[2]*1);
	}
		
	if(product != '' && isInteger(quantityField) && d2 > d1 ) {
		jQuery.ajax({
			type	 : 'POST', 
			url      : "includes/data/addDonationProduct.php",
			dataType : "text",
			data     : { product_name : product , product_quantity : quantity, product_date : xDate, donation_id : donationId, warehouse_id : warehouseId, donation_type : donationType },
			success  : function(msg){
				if (msg != "error"){
					$(container).append('<li id="'+msg+'"><a href="javascript:void(0);" onclick="removeProductAjax($(this).parent(),'+donationId+','+donationType+');" class="icon delete" title="Remover Producto"><span>Remover Producto</span></a><span class="product-name">' + product + '</span><span class="product-quantity">x' + quantity + '</span></li>');
				  	quantityField.val("1")
					$(field).val("")
					$(expDate).val("")
					$(field).focus();
					$(trigger).hide();
				}else{
					$(field).addClass("error")
					$(expDate).addClass("error")
				}
					
			}
		})
	}else{
		$(field).addClass("error")
		$(expDate).addClass("error")
		quantityField.addClass("error")
	}

}

function removeProductAjax(product, donationId, donationType){
	product_id =  product.attr('id');
	product_name = product.find(".product-name").html()
	jQuery.ajax({
		type	 : 'POST', 
		url      : "includes/data/removeDonationProduct.php",
		dataType : "text",
		data     : { product_id : product.attr('id'), product_name : product_name, donation_id : donationId, donation_type : donationType },
		success  : function(msg){
			if (msg != "error"){
				msg =  msg.split("_")
				quantity = msg[1]
				if ( parseInt(quantity) > 0)
					{	nextId = msg[2]
						product.find(".product-quantity").html("x"+quantity)
						product.attr("id",nextId) 
					}
				else
					product.remove();
			}		 
		}
	})
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

function validateColorboxForm() {
	valid = true
  	$("form input, form select").removeClass("error")
	$(".not-nil").each(function(){
		$elem = $(this)
		if (isNil($elem))
		{ valid= false; $elem.addClass("error") }
	})
	$(".integer").each(function(){
		$elem = $(this)
		if (!isInteger($elem))
		{ valid= false; $elem.addClass("error") }
	})
	$(".percent").each(function(){
		$elem = $(this)
		if (!isPercentage($elem))
		{ valid= false; $elem.addClass("error") }
	})
	$(".decimal").each(function(){
		$elem = $(this)
		if (!isFloat($elem))
		{ valid= false; $elem.addClass("error") }
	})
	$(".atLeastOne").each(function(){
		$elem = $(this)
		if (!atLeastOne($elem))
		{ valid= false; $elem.addClass("error") }
	})
	$(".selectOne").each(function(){
		$elem = $(this)
		if (!isSelected($elem))
		{ valid= false; $elem.addClass("error") }
	})
	$(".email").each(function(){
		$elem = $(this)
		if (!isEmail($elem))
		{ valid= false; $elem.addClass("error") }
	})
	$(".ifEmail").each(function(){
		$elem = $(this)
		if (!isNil($elem) && !isEmail($elem))
		{ valid= false; $elem.addClass("error") }
	})
	
	if (!valid){
		$("#errorMessage").html("Por favor digite todos los campos obligatorios (<span class=\"required\">*</span>).");
		$("#errorMessage").show();
		$.colorbox.resize();
	}
   return valid;
}
