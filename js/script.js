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