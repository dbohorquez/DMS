<?php
	include('../functions.php');
	$units = getTable("units");
?>

<div class="">
	<h3>Agregar Categoria</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
		<div id="errorMessage" class="error"> </div>
		<form action="categories.php" enctype="application/x-www-form-urlencoded" method="post" onsubmit="return validateColorboxForm();">
        <fieldset>
            <label for="name">Nombre: <span class="required">*</span></label>
            <input type="text" class="text not-nil" size="48" name="name" id="name" />
        </fieldset>
       <fieldset>
            <label for="description">Descripción:</label>
            <textarea class="text" cols="44" rows="6" name="description" id="description" />
        </fieldset>
				<fieldset>
					<label for="quantity">Cantidad: <span class="required">*</span></label>
					<input type="text" class="text decimal" size="48" name="quantity" id="quantity" />
				</fieldset>
				<fieldset>
					<label for="unit">Unidad: <span class="required">*</span></label>
					<select name="unit" id="unit">
			     <?php
	               while($unit = mysql_fetch_array($units)){
	          ?>
	               <option value="<?php echo $unit['id']; ?>"><?php echo $unit['name']; ?></option>
	           <?php } ?>			
					</select>
     		</fieldset>
				
        <fieldset class="clear">
    <?php 
			$userid = $_GET['us']; 
			$rol=isAnyRol($userid);
			if($rol== 1 || $rol== 3 || $rol== 5 || $rol== 6){?>
			<input type="submit" class="btn" value="Agregar" name="bt-add" />
		<?php } ?>
	        <span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
        </fieldset>
    </form>
</div>