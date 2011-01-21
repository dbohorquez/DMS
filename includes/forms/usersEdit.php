<div class="">
	<?php 
		include('../functions.php');
		$id = $_GET['e']; 
		$user = getTable('users',"id = $id",'',1);
	?>
	<h3>Editar Usuario</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
    <form action="options.php" enctype="application/x-www-form-urlencoded" method="post">
    	<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
        <fieldset>
            <label for="name">Nombre: <span class="required">*</span></label>
            <input type="text" class="text" size="48" name="name" id="name" value="<?php echo $user['name']; ?>" />
        </fieldset>
        <fieldset>
            <label for="email">Correo electrónico: <span class="required">*</span></label>
            <p><?php echo $user['email']; ?></p>
        </fieldset>
        <fieldset>
            <label for="phonenumber">Teléfono:</label>
            <input type="text" class="text" size="48" name="phonenumber" id="phonenumber" value="<?php echo $user['phoneNumber']; ?>" />
        </fieldset>
        <fieldset>
            <label for="profile">Perfil:</label>
            <select name="profile" id="profile">
                <option value="Administrador" <?php if($user['profile'] == 'Administrador'){ ?> selected="selected"<?php } ?>>Administrador</option>
                <option value="Supervisor" <?php if($user['profile'] == 'Supervisor'){ ?> selected="selected"<?php } ?>>Supervisor</option>
                <option value="Gestor" <?php if($user['profile'] == 'Gestor'){ ?> selected="selected"<?php } ?>>Gestor</option>
                <option value="Operador de Distribución" <?php if($user['profile'] == 'Operador de Distribución'){ ?> selected="selected"<?php } ?>>Operador de Distribución</option>
                <option value="Operador de Bodega" <?php if($user['profile'] == 'Operador de Bodega'){ ?> selected="selected"<?php } ?>>Operador de Bodega</option>
                <option value="Operador Comercial" <?php if($user['profile'] == 'Operador Comercial'){ ?> selected="selected"<?php } ?>>Operador Comercial</option>
            </select>
        </fieldset>
        <fieldset class="clear">
                <?php if(isAnyRol($_SESSION['dms_id'])== 1){?>
                 <input type="submit" class="btn" value="Guardar Cambios" name="bt-edit" />
				<?php } ?>
	       <span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
        </fieldset>
    </form>
</div>