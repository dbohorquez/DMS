<div class="medium">
	<?php
		include('../functions.php');
		$id = $_GET['e']; 
		if($id !=''){
			$voucher = getTable('vouchers',"id = $id",'',1);
			$donor = getTable('donors',"id = $voucher[donors_id]",'',1);
			$location = getItemLocation('donors',$donor['id']);
			$types = array("","C.C.","C.E.","NIT");
			$products = getTable('products','','name asc');
			$data = '';
			while($product = mysql_fetch_array($products)){
				$data .= '"' . $product['name'] . '",';
			}
	?>
	<h3>Editar Comprobante de Donación #<?php echo $voucher['id']; ?></h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
    <form action="donation-checkin.php" enctype="application/x-www-form-urlencoded" method="post">
        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
	        <div class="column c50p">
	        	<input type="hidden" id="identification" name="identification" value="<?php echo $donor['id']; ?>" />
	         <fieldset>
                <p><strong>Fecha:</strong> <?php echo formatDate($voucher['date']); ?></p>
                <h4>Donante</h4>
                <p><strong>Identificación:</strong> <?php echo $types[$donor['type']] . ': ' . $donor['id']; ?></p>
                <p><strong>Nombre:</strong> <?php echo $donor['name']; ?></p>
                <p><strong>Teléfonos:</strong> Tel: <?php echo $donor['phoneNumber']; ?>, Fax: <?php echo $donor['faxNumber']; ?></p>
                <p><strong>Ubicación:</strong> <?php echo $donor['address']; ?>, <?php echo utf8_encode($location['town'] . ', ' . $location['province']); ?></p>
                <p><strong>Correo Electrónico:</strong> <?php echo $donor['email']; ?></p>
            </fieldset>
            </div>
	        <div class="column c50p last">
	          	<h4>Detalle de Factura:</h4>
							<fieldset>
	               <label for="company_id">Operador: <span class="required">*</span></label>
	               <select name="company_id" id="company_id">
	               <?php
	                   $companies = getTable('companies','','name asc');
	                   while($company = mysql_fetch_array($companies)){
	               ?>
	                   <option value="<?php echo $company['id']; ?>"<?php if($voucher['companies_id'] == $company['id']){ ?> selected="selected"<?php } ?>><?php echo $company['name']; ?></option>
	               <?php } ?>
	              </select>
	           </fieldset>
							<fieldset>
	               <label for="bill">Número de Factura: <span class="required">*</span></label>
	               <input type="text" class="text" size="48" name="bill" id="bill" value="<?php echo $voucher['bill']; ?>" />
	           </fieldset>
						 <fieldset>
	                <label for="date">Fecha de recibo: <span class="required">*</span></label>
	                <input type="text" class="text datepicker" size="20" name="date" id="date" value="<?php echo $voucher['date']; ?>" />
	            </fieldset>
	        </div>

	        <fieldset class="clear">
		        <input type="submit" class="btn" value="Editar" name="bt-edit" /><span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
	        </fieldset>
		    </form>
		    <script type="text/javascript">
						$('.datepicker').datepicker($.datepicker.regional[ "es" ],{
							inline: true
						});	
						$('.datepicker').datepicker("option", "dateFormat", 'yy-mm-dd');
						$('.datepicker').datepicker( "setDate" , "<?php echo $voucher['date']; ?>" );
			</script>
	     		<?php }else{ ?>
	          	<div class="error">Debe escribir un número de identificación</div>
	              <p><a href="javascript:void(0);" class="btn" onClick="$.colorbox.close()">Volver</a></p>
	          <?php } ?>
	</div>