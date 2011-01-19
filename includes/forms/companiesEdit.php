<div class="medium">
	<?php 
		include('../functions.php');
		$id = $_GET['e']; 
		$company = getTable('companies',"id = $id",'',1);
		$location = getItemLocation('companies',$id);
	?>
	<h3>Editar Entidad</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
    <form action="companies.php" enctype="application/x-www-form-urlencoded" method="post">
        <div class="column c50p">
        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
        <fieldset>
                <label for="nit">Nit: <span class="required">*</span></label>
                <input type="text" class="text" size="48" name="nit" id="nit" value="<?php echo $company['id']; ?>" />
            </fieldset>
            <fieldset>
                <label for="name">Nombre: <span class="required">*</span></label>
                <input type="text" class="text" size="48" name="name" id="name" value="<?php echo $company['name']; ?>" />
            </fieldset>
            <fieldset>
            	<label for="type">Tipo de Entidad:</label>
                <select name="type" id="type">
                	<option value="3"<?php if($company['type'] == 3){ ?> selected="selected"<?php } ?>>Gestor</option>
                    <option value="1"<?php if($company['type'] == 1){ ?> selected="selected"<?php } ?>>Operador Comercial</option>
                    <option value="2"<?php if($company['type'] == 2){ ?> selected="selected"<?php } ?>>Operador de Distribución</option>
                </select>
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
                <input type="text" class="text" size="48" name="address" id="address" value="<?php echo $company['address']; ?>" />
            </fieldset>

        	<fieldset>
            	<label for="contactname">Contacto:</label>
                <input type="text" class="text" size="48" name="contactname" id="contactname" value="<?php echo $company['contactName']; ?>" />
            </fieldset>
            <fieldset>
            	<label for="phonenumber">Teléfono:</label>
                <input type="text" class="text" size="48" name="phonenumber" id="phonenumber" value="<?php echo $company['phoneNumber']; ?>" />
            </fieldset>
            <fieldset>
            	<label for="fax">Fax:</label>
                <input type="text" class="text" size="48" name="fax" id="fax" value="<?php echo $company['faxNumber']; ?>" />
            </fieldset>
            <fieldset>
            	<label for="email">Correo Electrónico: <span class="required">*</span></label>
                <input type="text" class="text" size="48" name="email" id="email" value="<?php echo $company['email']; ?>" />
            </fieldset>

        </div>
        <fieldset class="clear">
	        <input type="submit" class="btn clear" value="Guardar Cambios" name="bt-edit" /><span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
        </fieldset>
    </form>
</div>