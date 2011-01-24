<div class="medium">
	<h3>Editar Punto de Reorden</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
    <form action="products_checkpoint.php" enctype="application/x-www-form-urlencoded" method="post">
    	<?php
			include('../functions.php');
			$types = getTable('products','deletedAt IS NULL','name asc');
			$data = '';
			$id = $_GET['e']; 
			$checkpoint = getTable('products_checkpoint',"id = $id",'',1);
			$userid = $_GET['us']; 
			while($type = mysql_fetch_array($types)){
				$data .= '"' . $type['name'] . '",';
			}
		?>
        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
        <fieldset>
            <label for="product">Producto: <span class="required">*</span></label>
            <input type="text" class="text autocomplete" size="48" name="product" id="product" value="<?php echo findRow("products","id",$checkpoint['product_id'],"name"); ?>"/>
        </fieldset>
        <fieldset>
            <label for="quantity">Cantidad: <span class="required">*</span></label>
            <input type="text" class="text" size="48" name="quantity" id="quantity" value="<?php echo $checkpoint['quantity']; ?>"/>
        </fieldset>

        <fieldset class="clear">
         <?php 
		 $rol=isAnyRol($userid);
		 if($rol== 1 || $rol== 3 || $rol== 5 || $rol== 6){?>
          	<input type="submit" class="btn clear" value="Editar" name="bt-edit" />
          <?php } ?>
	        <span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
        </fieldset>
    </form>
    <script type="text/javascript">
		var data = [<?php echo $data; ?>];
		$('#product').autocomplete({
			source: data
		});
	</script>
</div>