<div class="medium">
	<h3>Agregar Operador</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
		<div id="errorMessage" class="error"> </div>

    <form action="companies.php" enctype="application/x-www-form-urlencoded" method="post" onsubmit="return validateCompaniesForm();">
    <?php include('../functions.php'); ?>
        <div class="column c50p">
		    <fieldset>
                <label for="nit">Nit: <span class="required">*</span></label>
                <input type="text" class="text" size="48" name="nit" id="nit" />
            </fieldset>
            <fieldset>
                <label for="name">Nombre: <span class="required">*</span></label>
                <input type="text" class="text" size="48" name="name" id="name" />
            </fieldset>
            <fieldset>
            	<label for="type">Tipo de Entidad:</label>
                <select name="type" id="type">
                	<option value="3">Gestor</option>
                    <option value="1">Operador Comercial</option>
                	<option value="2">Operador de Distribución</option>
                </select>
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
                <select name="town" id="town">
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
            	<label for="contactname">Contacto:</label>
                <input type="text" class="text" size="48" name="contactname" id="contactname" />
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
            	<label for="email">Correo electrónico: <span class="required">*</span></label>
                <input type="text" class="text" size="48" name="email" id="email" />
            </fieldset>
        </div>
        <fieldset class="clear">
	        <input type="submit" class="btn clear" value="Agregar" name="bt-add" /><span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
        </fieldset>
    </form>
</div>