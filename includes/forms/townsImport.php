<div class="narrow">
	<h3>Importar Municipios</h3>
    <p>Los municipios importados reemplazarán los existentes.</p>
    <?php include('../functions.php'); ?>
    <form action="options.php" enctype="multipart/form-data" method="post">
    	<fieldset>
            <label for="province">Departamento: <span class="required">*</span></label>
            <select name="province" id="province">
            <?php
                $provinces = getTable('provinces','','name asc');
                while($province = mysql_fetch_array($provinces)){
            ?>
                <option value="<?php echo $province['id']; ?>"><?php echo utf8_encode($province['name']); ?></option>
            <?php } ?>
            </select>
        </fieldset>
        <fieldset>
        	<label for="datos">Archivo a Importar:</label>
            <input type="file" name="datos" id="datos" />
            <p>El archivo debe estar en formato CSV (Valores Separados por Coma)</p>
        </fieldset>
    	<fieldset class="clear">
	        <input type="submit" class="btn" value="Importar" name="bt-import" /><span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
        </fieldset>
    </form>
</div>