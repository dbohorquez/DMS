<div class="">
	<h3>Agregar Usuario</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
    <form action="options.php" enctype="application/x-www-form-urlencoded" method="post">
        <fieldset>
            <label for="name">Nombre: <span class="required">*</span></label>
            <input type="text" class="text" size="48" name="name" id="name" />
        </fieldset>
        <fieldset>
            <label for="email">Correo electrónico: <span class="required">*</span></label>
            <input type="text" class="text" size="48" name="email" id="email" />
        </fieldset>
        <fieldset>
            <label for="phonenumber">Teléfono:</label>
            <input type="text" class="text" size="48" name="phonenumber" id="phonenumber" />
        </fieldset>
        <fieldset>
            <label for="profile">Perfil:</label>
            <select name="profile" id="profile">
                <option value="Administrador">Administrador</option>
                <option value="Supervisor">Supervisor</option>
                <option value="Gestor">Gestor</option>
                <option value="Operador de Distribución">Operador de Distribución</option>
                <option value="Operador de Bodega">Operador de Bodega</option>
                <option value="Operador Comercial">Operador Comercial</option>
           </select>
        </fieldset>
        <fieldset class="clear">
                <?php if(isAnyRol($_SESSION['dms_id'])== 1){?>
                 <input type="submit" class="btn" value="Agregar" name="bt-add" />
				<?php } ?>
	        <span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
        </fieldset>
    </form>
</div>