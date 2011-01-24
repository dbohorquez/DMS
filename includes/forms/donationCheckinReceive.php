<div class="medium">
	<?php
		include('../functions.php');
		$id = $_GET['r']; 
		if($id !=''){
			$voucher = getTable('vouchers',"id = $id",'',1);
			$donor = getTable('donors',"id = $voucher[donors_id]",'',1);
			$location = getItemLocation('donors',$donor['id']);
			$types = array("","C.C.","C.E.","NIT");
			$products = getTable('products','','name asc');
			$data = '';
			$company = getTable('companies',"id = $voucher[company_id]",'',1);
			$query = "select p.*,products.name from products_donations p, donations d, products where d.donors_id = $donor[id] and d.companies_id = $voucher[company_id] and d.bill = $voucher[bill] and d.deletedAt IS NULL and d.sequence = p.donations_id and p.deletedAt IS NULL and products.id = p.products_id";
		  $products = runQuery($query);
		  $products_length = mysql_num_rows($products);
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
							<p><strong>Operador:</strong> <?php echo $company['name']; ?></p>
							<p><strong>Factura:</strong> <?php echo $voucher['bill']; ?></p>
							<p><strong>Date:</strong> <?php echo formatDate($voucher['date']); ?></p>
							<fieldset>
	                <label for="notes"><strong>Notas:</strong></label>
	                <textarea class="text" cols="44" rows="3" name="notes" id="notes"></textarea>
	            </fieldset>
							
						</div>
						<div class="table_scroll">
							<table cellpadding="0" cellspacing="0" class="clear"><thead>
		           	<tr>
		               	<th>Nombre</th>
		                <th width="100">Fecha de expiración</th>
		             </tr></thead><tbody>
						<?php
							if ($products_length > 0){
		            while($product = mysql_fetch_array($products)){
				    	 ?>
							<tr>
		   							<td><?php echo $product['name']; ?> </td>
										<td><?php echo $product['expirationDate']; ?> </td>
							</tr>
		        <?php
		            } 
							}else{
		         ?>
								<tr><td colspan="5">No se han encontrado productos en la factura registrada.</td></tr>
						<?php
							}
						?>
						 </tbody>
					   </table>
				   </div>		
						<?php
							if ($products_length > 0){
		         ?> <fieldset>
									<label for="state"><strong>Estado:</strong></label>
		         			<select name="state" id="state" >
										<option value="1">Completo </option>
										<option value="2">Incompleto </option>
									</select>
		         		</fieldset>
						<?php
							}else{
						?>
							<input type="hidden" name="state" value="3" id="state">
						<?php
							}
						?>
	        <fieldset class="clear">
		        <input type="submit" class="btn" value="Comprobar" name="bt-verify" /><span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
	        </fieldset>
		    </form>
		    <script type="text/javascript">
						$('.datepicker').datepicker($.datepicker.regional[ "es" ],{
							inline: true
						});	
						$('.datepicker').datepicker("option", "dateFormat", 'yy-mm-dd');
						$('.datepicker').datepicker( "setDate" , "<?php echo $voucher['date']; ?>" );
			</script>
			<??><?php
				}else{ ?>
	  	<div class="error">Debe escribir un número de consecutivo.</div>
	  	<p><a href="javascript:void(0);" class="btn" onClick="$.colorbox.close()">Volver</a></p>
	  <?php } ?>
	</div>