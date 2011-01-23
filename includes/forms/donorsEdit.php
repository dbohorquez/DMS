<div class="medium">
	<?php 
		include('../functions.php');
		$id = $_GET['e']; 
		$userid = $_GET['us']; 
		$donor = getTable('donors',"id = $id",'',1);
		$location = getItemLocation('donors',$id);
	?>
	<h3>Editar Donante</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
    <form action="donors.php" enctype="application/x-www-form-urlencoded" method="post">
    	<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
        <div class="column c50p">
            <fieldset>
                <label for="name">Nombre: <span class="required">*</span></label>
                <input type="text" class="text" size="48" name="name" id="name" value="<?php echo $donor['name']; ?>" />
            </fieldset>
            <fieldset>
            	<label for="type">Tipo de Identificación:</label>
                <select name="type" id="type">
                	<option value="1"<?php if($donor['type'] == 1){ ?> selected="selected"<?php } ?>>Cédula de Ciudadanía</option>
                    <option value="2"<?php if($donor['type'] == 2){ ?> selected="selected"<?php } ?>>Cédula de Extranjería</option>
                    <option value="3"<?php if($donor['type'] == 3){ ?> selected="selected"<?php } ?>>NIT</option>
                </select>
            </fieldset>
            <fieldset>
                <label for="identification">Identificación: <span class="required">*</span></label>
                <input type="text" class="text" size="48" name="identification" id="identification" value="<?php echo $donor['id']; ?>" />
            </fieldset>
            <fieldset>
            	<label for="province">Departamento: <span class="required">*</span></label>
                <select name="province" id="province" onchange="updateElm('#town','includes/data/towns.php?p=' + this.value);">
                <?php
					$provinces = getTable('provinces','','name asc');
					while($province = mysql_fetch_array($provinces)){
				?>
                	<option value="<?php echo $province['id']; ?>"<?php if($location['provinces_id'] == $province['id']){ ?> selected="selected"<?php } ?>><?php echo utf8_encode($province['name']); ?></option>
                <?php } ?>
                </select>
            </fieldset>
            <fieldset>
            	<label for="town">Ciudad/Municipio: <span class="required">*</span></label>
                <select name="town" id="town">
                <?php
					$towns = getTable('towns',"provinces_id = $location[provinces_id]",'name asc');
					while($town = mysql_fetch_array($towns)){
				?>
                	<option value="<?php echo $town['id']; ?>"<?php if($location['towns_id'] == $town['id']){ ?> selected="selected"<?php } ?>><?php echo utf8_encode($town['name']); ?></option>
                <?php } ?>
                </select>
            </fieldset>
        </div>
        <div class="column c50p last">
        	<fieldset>
            	<label for="address">Dirección:</label>
                <input type="text" class="text" size="48" name="address" id="address" value="<?php echo $donor['address']; ?>" />
            </fieldset>
            <fieldset>
            	<label for="phonenumber">Teléfono:</label>
                <input type="text" class="text" size="48" name="phonenumber" id="phonenumber" value="<?php echo $donor['phoneNumber']; ?>" />
            </fieldset>
            <fieldset>
            	<label for="fax">Fax:</label>
                <input type="text" class="text" size="48" name="fax" id="fax" value="<?php echo $donor['faxNumber']; ?>" />
            </fieldset>
           <fieldset>
            	<label for="email">Correo electrónico:</label>
                <input type="text" class="text" size="48" name="email" id="email" value="<?php echo $donor['email']; ?>" />
            </fieldset>
        </div>
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