<div class="medium">
	<?php 
		include('../functions.php');
		$id = $_GET['e']; 
		$shelter = getTable('shelters',"id = $id",'',1);
		$location = getItemLocation('shelters',$id);
		$userid = $_GET['us']; 
	?>
	<h3>Editar Beneficiario</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
    <form action="donors.php" enctype="application/x-www-form-urlencoded" method="post">
    	<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
        <div class="column c50p">
            <fieldset>
                <label for="name">Nombre: <span class="required">*</span></label>
                <input type="text" class="text" size="48" name="name" id="name" value="<?php echo $shelter['name']; ?>" />
            </fieldset>
            <fieldset>
                <label for="contactname">Contacto: <span class="required">*</span></label>
                <input type="text" class="text" size="48" name="contactname" id="contactname" value="<?php echo $shelter['contactName']; ?>" />
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
                <input type="text" class="text" size="48" name="address" id="address" value="<?php echo $shelter['address']; ?>" />
            </fieldset>
            <fieldset>
            	<label for="phonenumber">Teléfono:</label>
                <input type="text" class="text" size="48" name="phonenumber" id="phonenumber" value="<?php echo $shelter['phoneNumber']; ?>" />
            </fieldset>
            <fieldset>
            	<label for="fax">Fax:</label>
                <input type="text" class="text" size="48" name="fax" id="fax" value="<?php echo $shelter['faxNumber']; ?>" />
            </fieldset>
           <fieldset>
            	<label for="email">Correo electrónico:</label>
                <input type="text" class="text" size="48" name="email" id="email" value="<?php echo $shelter['email']; ?>" />
            </fieldset>
        </div>
        <fieldset class="clear">
        	<?php 
			$rol=isAnyRol($userid);
			if($rol== 1 || $rol== 4){?>
			<input type="submit" class="btn" value="Guardar Cambios" name="bt-edit" />
			<?php } ?>
	        <span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
        </fieldset>
    </form>
</div>