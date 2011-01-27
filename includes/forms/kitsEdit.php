<div class="narrow">
	<h3>Editar Kit</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
		<div id="errorMessage" class="error"> </div>

    <form action="kits.php" enctype="application/x-www-form-urlencoded" method="post" onsubmit="return validateColorboxForm();">
    	<?php
			include('../functions.php');
			$userid = $_GET['us']; 
			$id = $_GET['e']; 
			$kit = getTable('kits',"id = $id",'',1);
			$products = getTable('products','','name asc');
			$data = '';
			while($product = mysql_fetch_array($products)){
				$data .= '"' . $product['name'] . '",';
			}
		?>
        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
        <fieldset>
            <label for="name">Nombre: <span class="required">*</span></label>
            <input type="text" class="text not-nil" size="48" name="name" id="name" value="<?php echo $kit['name']; ?>" />
        </fieldset>
        <h4>Productos <span class="required">*</span></h4>
        <fieldset>
            <div class="column c50p">
                <label for="type">Añadir Producto:</label>
                <input type="text" class="text autocomplete" size="30" name="product" id="product" />
            </div>
            <div class="column c50p last">
                <label for="quantity">Cantidad:</label>
                <input type="text" class="text" size="4" name="quantity" id="quantity" value="1" />
                <a href="javascript:void(0);" class="btn" onclick="addProduct('#product',$('#quantity').attr('value'),'#expirationDate','.product-list',this);" id="add">Añadir</a>
            </div>
        </fieldset>
        <label>Productos seleccionados:</label>
        <ul class="product-list text atLeastOne">
        	<?php
				$products = getKitProducts($id);
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
		 if($rol== 1 || $rol== 3 || $rol== 5 || $rol== 6){?>
          	<input type="submit" class="btn" value="Guardar Cambios" name="bt-edit" />
   		<?php } ?>
	        <span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
        </fieldset>
    </form>
    <script type="text/javascript">
		$('#add').hide();
		var data = [<?php echo $data; ?>];
		$('#product').autocomplete({
			source: data,
			mustMatch: true,
			select: function(event, ui){
				$('#add').show();
			}
		});
	</script>
</div>