<div class="medium">
	<?php 
	include('../functions.php'); 
	$userid = $_GET['us']; 
	?>
	<h3>Agregar Donante</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
		<div id="errorMessage" class="error"> </div>
		
    <form action="donors.php" enctype="application/x-www-form-urlencoded" method="post" onsubmit="return validateColorboxForm();">
        <div class="column c50p">
            <fieldset>
                <label for="name">Nombre: <span class="required">*</span></label>
                <input type="text" class="text not-nil" size="48" name="name" id="name" />
            </fieldset>
            <fieldset>
            	<label for="type">Tipo de Identificación:</label>
                <select name="type" id="type">
                	<option value="1">Cédula de Ciudadanía</option>
                    <option value="2">Cédula de Extranjería</option>
                    <option value="3">NIT</option>
                </select>
            </fieldset>
            <fieldset>
                <label for="identification">Identificación: <span class="required">*</span></label>
                <input type="text" class="text integer" size="48" name="identification" id="identification" />
            </fieldset>
            <fieldset>
            	<label for="province">Departamento: <span class="required">*</span></label>
                <select name="province" id="province" onchange="updateElm('#town','includes/data/towns.php?p=' + this.value);">
                <?php
					$provinces = getTable('provinces','','name asc');
					while($province = mysql_fetch_array($provinces)){
				?>
                	<option value="<?php echo $province['id']; ?>"><?php echo utf8_encode($province['name']); ?></option>
                <?php } ?>
                </select>
            </fieldset>
            <fieldset>
            	<label for="town">Ciudad/Municipio: <span class="required">*</span></label>
                <select name="town" id="town" class="selectOne">
                	<option value="0">-- Seleccione un departamento --</option>
                </select>
            </fieldset>
        </div>
        <div class="column c50p last">
        	<fieldset>
            	<label for="address">Dirección:</label>
                <input type="text" class="text" size="48" name="address" id="address" />
            </fieldset>
            <fieldset>
            	<label for="phonenumber">Teléfono:</label>
                <input type="text" class="text" size="48" name="phonenumber" id="phonenumber" />
            </fieldset>
            <fieldset>
            	<label for="fax">Fax:</label>
                <input type="text" class="text" size="48" name="fax" id="fax" />
            </fieldset>
           <fieldset>
            	<label for="email">Correo electrónico:</label>
                <input type="text" class="text" size="48" name="email" id="email" />
            </fieldset>
        </div>
        <fieldset class="clear">
            <?php 
			$rol=isAnyRol($userid);
			if($rol== 1 || $rol== 3 || $rol== 5 || $rol== 6){?>
			<input type="submit" class="btn" value="Agregar" name="bt-add" />
            <?php } ?>
            <span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
        </fieldset>
    </form>
</div>