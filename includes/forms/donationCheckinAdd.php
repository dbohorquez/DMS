<div class="medium">
	<h3>Agregar Comprobante de Donación</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
		<div id="errorMessage" class="error"> </div>

    <form action="donation-checkin.php" enctype="application/x-www-form-urlencoded" method="post" onsubmit="return validateColorboxForm();">
    	<?php
			include('../functions.php');
			$donorId = $_GET['d'];
			if(is_numeric($donorId)){
				if(exists('donors',"id = $donorId")){
					$userid = $_GET['us']; 
					$donor = getTable('donors',"id = $donorId",'',1);
					$location = getItemLocation('donors',$donorId);
			?>
        <h4>Identificación: (<?php echo $donorId; ?>)</h4>
        <input type="hidden" id="exists" name="exists" value="true" />
			<?php
                }else{
            ?>
        <h4>Donante Nuevo (Identificación: <?php echo $donorId; ?>)</h4>
        <input type="hidden" id="exists" name="exists" value="false" />
			<?php
                }
            ?>
        <div class="column c50p">
        	<input type="hidden" id="identification" name="identification" value="<?php echo $donorId; ?>" />
            <fieldset>
                <label for="name">Nombre: <span class="required">*</span></label>
                <input type="text" class="text not-nil" size="48" name="name" id="name" value="<?php echo $donor['name']; ?>" />
            </fieldset>
            <fieldset>
            	<label for="type">Tipo de Identificación:</label>
                <select name="type" id="type">
                	<option value="1"<?php if($donors['type'] == 1){ ?> selected="selected"<?php } ?>>Cédula de Ciudadanía</option>
                    <option value="2"<?php if($donors['type'] == 2){ ?> selected="selected"<?php } ?>>Cédula de Extranjería</option>
                    <option value="3"<?php if($donors['type'] == 3){ ?> selected="selected"<?php } ?>>NIT</option>
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
	                <input type="text" class="text" size="48" name="address" id="address" value="<?php echo $donor['address']; ?>" />
	            </fieldset>
					  	<fieldset>
		            	<label for="phonenumber">Teléfono:</label>
		                <input type="text" class="text" size="48" name="phonenumber" id="phonenumber" value="<?php echo $donor['phoneNumber']; ?>" />
	           </fieldset>
	        </div>
        <div class="column c50p last">
            <fieldset>
            	<label for="fax">Fax:</label>
                <input type="text" class="text" size="48" name="fax" id="fax" value="<?php echo $donor['faxNumber']; ?>" />
            </fieldset>
           <fieldset>
            	<label for="email">Correo electrónico:</label>
                <input type="text" class="text ifEmail" size="48" name="email" id="email" value="<?php echo $donor['email']; ?>" />
            </fieldset>
	        	<h4>Detalle de Factura:</h4>
						<fieldset>
               <label for="company_id">Operador: <span class="required">*</span></label>
               <select name="company_id" id="company_id">
               <?php
                   $companies = getTable('companies','','name asc');
                   while($company = mysql_fetch_array($companies)){
               ?>
                   <option value="<?php echo $company['id']; ?>"<?php if($donation['companies_id'] == $company['id']){ ?> selected="selected"<?php } ?>><?php echo $company['name']; ?></option>
               <?php } ?>
              </select>
           </fieldset>
						<fieldset>
               <label for="bill">Número de Factura: <span class="required">*</span></label>
               <input type="text" class="text" size="48" name="bill" id="bill" value="<?php echo $donation['bill']; ?>" />
           </fieldset>
					 <fieldset>
                <label for="date">Fecha de recibo: <span class="required">*</span></label>
                <input type="text" class="text datepicker" size="20" name="date" id="date" />
            </fieldset>
        </div>

        <fieldset class="clear">
        	<?php 
			$rol=isAnyRol($userid);
			if($rol== 1 ||  $rol== 2){?>
            <input type="submit" class="btn" value="Agregar" name="bt-add" />
			<?php } ?>
	        <span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
        </fieldset>
	    </form>
	    <script type="text/javascript">
					$('.datepicker').datepicker($.datepicker.regional[ "es" ],{
						inline: true
					});	
					$('.datepicker').datepicker("option", "dateFormat", 'yy-mm-dd');
		</script>
     		<?php }else{ ?>
          	<div class="error">Debe escribir un número de identificación</div>
              <p><a href="javascript:void(0);" class="btn" onClick="$.colorbox.close()">Volver</a></p>
          <?php } ?>
</div>