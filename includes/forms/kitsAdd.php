<div class="narrow">
	<h3>Agregar Kit</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
    <form action="kits.php" enctype="application/x-www-form-urlencoded" method="post">
    	<?php
			include('../functions.php');
			$userid = $_GET['us']; 
			$products = getTable('products','','name asc');
			$data = '';
			while($product = mysql_fetch_array($products)){
				$data .= '"' . $product['name'] . '",';
			}
		?>
        <fieldset>
            <label for="name">Nombre: <span class="required">*</span></label>
            <input type="text" class="text" size="48" name="name" id="name" />
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
        <ul class="product-list text"></ul>
        <fieldset class="clear">
         <?php 
		 $rol=isAnyRol($userid);
		 if($rol== 1 || $rol== 3 || $rol== 5 || $rol== 6){?>
          	<input type="submit" class="btn clear" value="Guardar Kit" name="bt-add" />
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