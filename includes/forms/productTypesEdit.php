<div class="">
	<?php 
		include('../functions.php');
		$id = $_GET['e'];
		$userid = $_GET['us'];  
		$type = getTable('producttypes',"id = $id",'',1);

			$categories = getTable('categories','deletedAt IS NULL','name asc');
			$data = '';
			while($category = mysql_fetch_array($categories)){
				$data .= '"' . $category['name'] . '",';
			}
			
			
		?>

	<h3>Editar Tipo de Producto</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
    <form action="producttypes.php" enctype="application/x-www-form-urlencoded" method="post">
    	<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
        <fieldset>
            <label for="name">Nombre: <span class="required">*</span></label>
            <input type="text" class="text" size="48" name="name" id="name" value="<?php echo $type['name']; ?>" />
        </fieldset>
       <fieldset>
            <label for="description">Descripción:</label>
            <textarea class="text" cols="44" rows="6" name="description" id="description"><?php echo $type['description']; ?></textarea>
        </fieldset>
        <fieldset>
            <label for="category">Categoría: <span class="required">*</span></label>
            <input type="text" class="text autocomplete" size="48" name="category" id="category" value="<?php $query = "select * from categories where id=$type[categories_id]";
						$result = runQuery($query);
						if(mysql_num_rows($result) == 0){
							return false;
						}else{
							$row = mysql_fetch_array($result);
							echo $row['name'];
						}  ?>" />
        </fieldset>
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
		var data = [<?php echo $data; ?>];
		$('#category').autocomplete({
			source: data
		});
	</script>
</div>