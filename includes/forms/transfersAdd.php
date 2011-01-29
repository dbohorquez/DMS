<div class="medium">
	<h3>Nueva Transferencia</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
		<div id="errorMessage" class="error"> </div>

    <form action="transfers.php" enctype="application/x-www-form-urlencoded" method="post" onsubmit="return validateColorboxForm();"> 
    	<?php
			include('../functions.php');
			$query = "SELECT  products.id, products.name, COUNT(products_donations.id)
				FROM products
				INNER JOIN products_donations
				ON products.id=products_donations.products_id
				WHERE products_donations.state=2
				GROUP BY products.id, products.name
				ORDER BY products.name";
			$products = runQuery($query);
			$data = '';
			$userid = $_GET['us']; 
			while($product = mysql_fetch_array($products)){
				$data .= '"' . $product['name'] . '",';
			}
		?>
        <div class="column c50p">
            <fieldset>
                <label for="warehousefrom">Bodega Origen: <span class="required">*</span></label>
								
                <select name="warehousefrom" id="warehousefrom">
										<option value="-1">Bodega Virtual</option>
                <?php
                    $warehouses = getTable('warehouses','','name asc');
                    while($warehouse = mysql_fetch_array($warehouses)){
                ?>
                    <option value="<?php echo $warehouse['id']; ?>"><?php echo $warehouse['name']; ?></option>
                <?php } ?>
                </select>
            </fieldset>
                        <fieldset>
                <label for="warehouseto">Bodega Destino: <span class="required">*</span></label>
                <select name="warehouseto" id="warehouseto">
                <?php
                    $warehouses = getTable('warehouses','type=1','name asc');
                    while($warehouse = mysql_fetch_array($warehouses)){
                ?>
                    <option value="<?php echo $warehouse['id']; ?>"><?php echo $warehouse['name']; ?></option>
                <?php } ?>
                </select>
            </fieldset>

            
        </div>
        <div class="column c50p last">
        <fieldset>
                <label for="shelter">Beneficiarios: <span class="required">*</span></label>
                <select name="shelter" id="shelter">
                <?php
                    $shelters = getTable('shelters','','name asc');
                    while($shelter = mysql_fetch_array($shelters)){
                ?>
                    <option value="<?php echo $shelter['id']; ?>"><?php echo $shelter['name']; ?></option>
                <?php } ?>
                </select>
            </fieldset>
        <fieldset>
            	<label for="notes">Comentarios:</label>
                <textarea class="text" cols="44" rows="6" name="notes" id="notes"></textarea>
        </fieldset>

        </div>
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
        <ul class="product-list text atLeastOne"></ul>
        <fieldset class="clear">
        <?php 
		$rol=isAnyRol($userid);
		if($rol== 1 || $rol== 2){?>
  	    <input type="submit" class="btn clear" value="Agregar" name="bt-transfer" />
        <?php } ?>
	    <span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
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