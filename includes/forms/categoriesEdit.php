<div class="">
	<?php 
		include('../functions.php');
		$id = $_GET['e']; 
		$userid = $_GET['us']; 
		$type = getTable('categories',"id = $id",'',1);
		$units = getTable("units");
	?>
	<h3>Editar Categorias</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
    <form action="categories.php" enctype="application/x-www-form-urlencoded" method="post">
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
						<label for="quantity">Cantidad: <span class="required">*</span></label>
						<input type="text" class="text" size="48" name="quantity" id="quantity" value="<?php echo $type['quantity'] ?>" />
					</fieldset>
					<fieldset>
						<label for="unit">Unidad: <span class="required">*</span></label>
						<select name="unit" id="unit">
				     <?php
		               while($unit = mysql_fetch_array($units)){
		          ?>
		               <option value="<?php echo $unit['id']; ?>" <?php if($type['unit_id'] == $unit['id']){ ?> selected="selected"<?php } ?> ><?php echo $unit['name']; ?></option>
		           <?php } ?>			
						</select>
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
</div>