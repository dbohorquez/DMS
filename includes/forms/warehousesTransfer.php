<div class="medium">
	<h3>Transferir Productos</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
    <form action="warehouses.php" enctype="application/x-www-form-urlencoded" method="post">
    	<?php
			include('../functions.php');
			$items = getTable('products_donations','state = 1 group by products_id','id asc');
			$data = '';
			while($item = mysql_fetch_array($items)){
				$product = getTable('products',"id = $item[products_id]",'',1);
				$data .= '"' . $product['name'] . '",';
			}
		?>
        <fieldset>
            <label for="warehouse">Bodega: <span class="required">*</span></label>
            <select name="warehouse" id="warehouse">
            <?php
                $warehouses = getTable('warehouses','type = 1','name asc');
                while($warehouse = mysql_fetch_array($warehouses)){
            ?>
                <option value="<?php echo $warehouse['id']; ?>"><?php echo $warehouse['name']; ?></option>
            <?php } ?>
            </select>
        </fieldset>
        <h4>Productos <span class="required">*</span></h4>
        <fieldset>
            <div class="column c33p">
                <label for="type">Añadir Producto:</label>
                <input type="text" class="text autocomplete" size="24" name="product" id="product" />
            </div>
            <div class="column c33p">
                <label for="quantity">Cantidad:</label>
	            <select name="quantity" id="quantity">
                	<option value="1">1</option>
                </select>
            </div>
            <div class="column c33p last">
                <a href="javascript:void(0);" class="btn fix" onclick="addProduct('#product',$('#quantity').attr('value'),'#expirationDate','.product-list',this);" id="add">Añadir</a>
            </div>
        </fieldset>
        <label>Productos seleccionados:</label>
        <ul class="product-list text"></ul>
        <fieldset class="clear">
	        <input type="submit" class="btn clear" value="Transferir" name="bt-transfer" /><span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
        </fieldset>
    </form>
    <script type="text/javascript">
		$('.datepicker').datepicker($.datepicker.regional[ "es" ],{
			inline: true
		});	
		$('.datepicker').datepicker("option", "dateFormat", 'yy-mm-dd');
		$('#add').hide();
		var data = [<?php echo $data; ?>];
		$('#product').autocomplete({
			source: data,
			mustMatch: true,
			select: function(event, ui){
				$('#add').show();
				updateElm('#quantity','includes/data/productQuantity.php?p=' + ui.item.value);
			}
		});
	</script>
</div>