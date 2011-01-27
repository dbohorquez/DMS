<div class="medium">
	<h3>Editar Distribución</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
    <form action="distribution.php" enctype="application/x-www-form-urlencoded" method="post">
    	<?php
			include('../functions.php');
			$userid = $_GET['us']; 
			$id = $_GET['e']; 
			$distribution = getTable('distributions',"id = $id",'',1);
			$shelter = getTable('shelters',"id = $distribution[shelter_id]",'',1);
			$query = "SELECT  products.id, products.name, COUNT(products_donations.id)
				FROM products
				INNER JOIN products_donations
				ON products.id=products_donations.products_id
				WHERE products_donations.state=2
				GROUP BY products.id, products.name
				ORDER BY products.name";
			$products = runQuery($query);
			$data = '';
			while($product = mysql_fetch_array($products)){
				$data .= '"' . $product['name'] . '",';
			}
		?>
        <div class="column c50p">
            <fieldset>
                <label for="warehouse">Bodega: <span class="required">*</span></label>
                <select name="warehouse" id="warehouse">
                <?php
                    $warehouses = getTable('warehouses','','name asc');
                    while($warehouse = mysql_fetch_array($warehouses)){
                ?>
                    <option value="<?php echo $warehouse['id']; ?>"<?php if($distribution['warehouses_id'] == $warehouse['id']){ ?> selected="selected"<?php } ?>><?php echo $warehouse['name']; ?></option>
                <?php } ?>
                </select>
            </fieldset>
            <fieldset>
                <label for="company">Canal de Distribución: <span class="required">*</span></label>
                <select name="company" id="company">
                <?php
                    $companies = getTable('companies','type = 2','name asc');
                    while($company = mysql_fetch_array($companies)){
                ?>
                    <option value="<?php echo $company['id']; ?>"<?php if($distribution['companies_id'] == $company['id']){ ?> selected="selected"<?php } ?>><?php echo $company['name']; ?></option>
                <?php } ?>
                </select>
            </fieldset>
						 <fieldset>
	                <label for="shelter">Beneficiarios:</label>
	                <input type="text" class="text" size="20" name="shelter" id="shelter" value="<?php echo $shelter['name'] ?>"/>
	            </fieldset>
        </div>
        <div class="column c50p last">
            <fieldset>
                <label for="deliveryDate">Fecha de Entrega: <span class="required">*</span></label>
                <input type="text" class="text datepicker" size="20" name="deliveryDate" id="deliveryDate" value="<?php echo $distribution['deliveryDate']; ?>" />
            </fieldset>
            <fieldset>
                <label for="state">Estado: <span class="required">*</span></label>
                <select name="state" id="state">
                    <option value="1"<?php if($distribution['state'] == 1){ ?> selected="selected"<?php } ?>>Programada</option>
                    <option value="2"<?php if($distribution['state'] == 2){ ?> selected="selected"<?php } ?>>Entregada</option>
                    <option value="3"<?php if($distribution['state'] == 3){ ?> selected="selected"<?php } ?>>Pendiente</option>
                </select>
            </fieldset>
        </div>
				<div class="clear"></div>
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
        <ul class="product-list text">
        	 <?php
				$products = getDistributionProducts($id);
				while($product = mysql_fetch_array($products)){
					$rand = rand(1,10000000);
			?>
					<li id="item<?php echo $rand ; ?>"><a href="javascript:void(0);" onclick="removeProduct($(this).parent());" class="icon delete" title="Remover Producto"><span>Remover Producto</span></a><span class="product-name"><?php echo $product['name']; ?></span><span class="product-quantity">x<?php echo $product['quantity']; ?></span><input type="hidden" id="hitem<?php echo $rand ; ?>" name="hitem<?php echo $rand ; ?>" value="<?php echo $product['name'] ; ?>" /><input type="hidden" id="citem<?php echo $rand ; ?>" name="citem<?php echo $rand ; ?>" value="<?php echo $product['quantity']; ?>" /></li>
			<?php
				}
			?>
        </ul>
        <fieldset class="clear">
        <?php 
		$rol=isAnyRol($userid);
		if($rol== 1 || $rol== 2){?>
  	    <input type="submit" class="btn clear" value="Guardar Cambios" name="bt-edit" />
        <?php } ?>
        <span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
        </fieldset>
    </form>
    <script type="text/javascript">
		$('.datepicker').datepicker($.datepicker.regional[ "es" ],{
			inline: true
		});	
		$('.datepicker').datepicker("option", "dateFormat", 'yy-mm-dd');
		$('.datepicker').datepicker('setDate', '<?php echo $distribution['deliveryDate']; ?>');
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