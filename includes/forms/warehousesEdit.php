<div class="medium">
	<?php 
		include('../functions.php');
		$id = $_GET['e']; 
		$warehouse = getTable('warehouses',"id = $id",'',1);
		$location = getItemLocation('warehouses',$id);
	?>
	<h3>Editar Bodega</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
    <form action="warehouses.php" enctype="application/x-www-form-urlencoded" method="post" onsubmit="return validateColorboxForm();">
				<div id="errorMessage" class="error"> </div>
        <div class="column c50p">
        	<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
            <fieldset>
                <label for="name">Nombre: <span class="required">*</span></label>
                <input type="text" class="text not-nil" size="48" name="name" id="name" value="<?php echo $warehouse['name']; ?>" />
            </fieldset>
            <fieldset>
            	<label for="type">Tipo de Bodega: <span class="required">*</span></label>
                <select name="type" id="type">
                	<option value="1"<?php if($warehouse['type'] == 1){ ?> selected="selected"<?php } ?>>Física</option>
                    <option value="2"<?php if($warehouse['type'] == 2){ ?> selected="selected"<?php } ?>>Virtual</option>
                </select>
            </fieldset>
            <fieldset>
            	<label for="description">Descripción:</label>
                <textarea class="text" cols="44" rows="6" name="description" id="description"><?php echo $warehouse['description']; ?></textarea>
            </fieldset>
           <fieldset>
            	<label for="occupation">Capacidad Actual:</label>
                <input type="text" class="text" size="4" name="occupation" id="occupation" value="<?php echo $warehouse['occupation']; ?>"/> %
            </fieldset>
        </div>
        <div class="column c50p last">
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
            	<label for="town">Ciudad/Municipio <span class="required">*</span>:</label>
                <select name="town" id="town" class="selectOne">
                <?php
					$towns = getTable('towns',"provinces_id = $location[provinces_id]",'name asc');
					while($town = mysql_fetch_array($towns)){
				?>
                	<option value="<?php echo $town['id']; ?>"<?php if($location['towns_id'] == $town['id']){ ?> selected="selected"<?php } ?>><?php echo utf8_encode($town['name']); ?></option>
                <?php } ?>
                </select>
            </fieldset>
        	<fieldset>
            	<label for="address">Dirección:</label>
                <input type="text" class="text" size="48" name="address" id="address" value="<?php echo $warehouse['address']; ?>" />
            </fieldset>
        	<fieldset>
            	<label for="contactname">Contacto:</label>
                <input type="text" class="text" size="48" name="contactname" id="contactname" value="<?php echo $warehouse['contactName']; ?>" />
            </fieldset>
            <fieldset>
            	<label for="email">Correo Electrónico:</label>
                <input type="text" class="text" size="48" name="email" id="email" value="<?php echo $warehouse['email']; ?>"/>
            </fieldset>
            <fieldset>
            	<label for="phonenumber">Teléfono:</label>
                <input type="text" class="text" size="48" name="phonenumber" id="phonenumber" value="<?php echo $warehouse['phoneNumber']; ?>" />
            </fieldset>
            <div class="column c50p">
                <fieldset>
                    <label for="cellphone">Celular:</label>
                    <input type="text" class="text" size="16" name="cellphone" id="cellphone" value="<?php echo $warehouse['cellphone']; ?>" />
                </fieldset>
            </div>
            <div class="column c50p last">
                <fieldset>
                    <label for="fax">Fax:</label>
                    <input type="text" class="text" size="16" name="fax" id="fax" value="<?php echo $warehouse['faxNumber']; ?>" />
                </fieldset>
            </div>
        </div>
        <fieldset class="clear">
	        <input type="submit" class="btn" value="Guardar Cambios" name="bt-edit" /><span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
        </fieldset>
    </form>
</div>