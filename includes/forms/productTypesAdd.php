<div class="">
	<h3>Agregar Tipo de Producto</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
    <form action="producttypes.php" enctype="application/x-www-form-urlencoded" method="post">
        <fieldset>
            <label for="name">Nombre: <span class="required">*</span></label>
            <input type="text" class="text" size="48" name="name" id="name" />
        </fieldset>
       <fieldset>
            <label for="description">Descripción:</label>
            <textarea class="text" cols="44" rows="6" name="description" id="description" />
        </fieldset>
        <fieldset class="clear">
	        <input type="submit" class="btn" value="Agregar" name="bt-add" /><span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
        </fieldset>
    </form>
</div>