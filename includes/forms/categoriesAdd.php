<div class="">
	<h3>Agregar Categoria</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
    <form action="categories.php" enctype="application/x-www-form-urlencoded" method="post">
        <fieldset>
            <label for="name">Nombre: <span class="required">*</span></label>
            <input type="text" class="text" size="48" name="name" id="name" />
        </fieldset>
       <fieldset>
            <label for="description">Descripción:</label>
            <textarea class="text" cols="44" rows="6" name="description" id="description" />
        </fieldset>
        <fieldset class="clear">
            <?php 
			$rol=isAnyRol($_SESSION['dms_id']);
			if($rol== 1 || $rol== 3 || $rol== 5 || $rol== 6){?>
			<input type="submit" class="btn" value="Agregar" name="bt-add" />
			<?php } ?>
	        <span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
        </fieldset>
    </form>
</div>