<div class="">
	<h3>Agregar Tipo de Producto</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
    <form action="producttypes.php" enctype="application/x-www-form-urlencoded" method="post">
        	<?php
			include('../functions.php');
			$userid = $_GET['us']; 
			$categories = getTable('categories','deletedAt IS NULL','name asc');
			$data = '';
			while($category = mysql_fetch_array($categories)){
				$data .= '"' . $category['name'] . '",';
			}
		?>

        <fieldset>
            <label for="name">Nombre: <span class="required">*</span></label>
            <input type="text" class="text" size="48" name="name" id="name" />
        </fieldset>
       <fieldset>
            <label for="description">Descripción:</label>
            <textarea class="text" cols="44" rows="6" name="description" id="description" />
        </fieldset>
                <fieldset>
            <label for="category">Categoria: <span class="required">*</span></label>
            <input type="text" class="text autocomplete" size="48" name="category" id="category" />
        </fieldset>
        <fieldset class="clear">
	        <?php 
			$rol=isAnyRol($userid);
			if($rol== 1 || $rol== 3 || $rol== 5 || $rol== 6){?>
               <input type="submit" class="btn" value="Agregar" name="bt-add" />
            <?php } ?>
	        <span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
        </fieldset>
    </form> 
    <script type="text/javascript">
		var data = [<?php echo $data; ?>];
		$('#category').autocomplete({
			source: data
		});
	</script>

</div>