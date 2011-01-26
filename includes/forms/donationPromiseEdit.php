<div class="medium">
	<?php
		include('../functions.php');
		$id = $_GET['e']; 
		if($id !=''){
			$userid = $_GET['us']; 
			$donation = getTable('donations',"sequence = $id",'',1);
			$donor = getTable('donors',"id = $donation[donors_id]",'',1);
			$location = getItemLocation('donors',$donor['id']);
			$types = array("","C.C.","C.E.","NIT");
			$products = getTable('products','','name asc');
			$data = '';
			while($product = mysql_fetch_array($products)){
				$data .= '"' . $product['name'] . '",';
			}
	?>
	<h3>Editar Promesa de Donación #<?php echo $donation['sequence']; ?></h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
    <form action="donations-promises.php" enctype="application/x-www-form-urlencoded" method="post">
        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
        <div class="column c50p">
            <fieldset>
                <p><strong>Fecha:</strong> <?php echo formatDate($donation['date']); ?></p>
                <h4>Donante</h4>
                <p><strong>Identificación:</strong> <?php echo $types[$donor['type']] . ': ' . $donor['id']; ?></p>
                <p><strong>Nombre:</strong> <?php echo $donor['name']; ?></p>
                <p><strong>Teléfonos:</strong> Tel: <?php echo $donor['phoneNumber']; ?>, Fax: <?php echo $donor['faxNumber']; ?></p>
                <p><strong>Ubicación:</strong> <?php echo $donor['address']; ?>, <?php echo utf8_encode($location['town'] . ', ' . $location['province']); ?></p>
                <p><strong>Correo Electrónico:</strong> <?php echo $donor['email']; ?></p>
            </fieldset>
            <fieldset>
                <label for="detail">Detalles:</label>
                <textarea class="text" cols="44" rows="3" name="detail" id="detail"><?php echo $donation['detail']; ?></textarea>
            </fieldset>
        </div>
        <div class="column c50p last">
            <h4>Productos <span class="required">*</span></h4>
            <fieldset>
                <div class="column c50p">
                    <label for="type">Añadir Producto:</label>
                    <input type="text" class="text autocomplete" size="20" name="product" id="product" />
                </div>
                <div class="column c50p last">
                    <label for="quantity">Cantidad:</label>
                    <input type="text" class="text" size="4" name="quantity" id="quantity" value="1" />
                </div>
            </fieldset>
            <fieldset>
                <a href="javascript:void(0);" class="btn" onclick="addProductAjax('#product',$('#quantity'),'#expirationDate','.product-list',this, <?php echo $id; ?>, $('#warehouse').val(), 3 );" id="add">Añadir</a>
            </fieldset>
            <label>Productos seleccionados:</label>
            <ul class="product-list text">
                <?php
                    $products = getDonationProducts($id);
                    while($product = mysql_fetch_array($products)){
                        //$rand = rand(1,10000000);
												$quantity = getProductQuantity($product['name'],$id);
                ?>
                        <li id="<?php echo $product['id']; ?>"><a href="javascript:void(0);" onclick="removeProductAjax($(this).parent(), <?php echo $id; ?>, 3 );" class="icon delete" title="Remover Producto"><span>Remover Producto</span></a><span class="product-name"><?php echo $product['name']; ?></span><span class="product-quantity">x<?php echo  $quantity; ?></span><!--input type="hidden" id="hitem<?php echo $rand ; ?>" name="hitem<?php echo $rand ; ?>" value="<?php echo $product['name'] ; ?>" /><input type="hidden" id="citem<?php echo $rand ; ?>" name="citem<?php echo $rand ; ?>" value="<?php echo $quantity; ?>" /><input type="hidden" id="ditem<?php echo $rand ; ?>" name="ditem<?php echo $rand ; ?>" value="<?php echo $product['expirationDate']; ?>" /--></li>
                <?php
                    }
                ?>
            </ul>
        </div>
        <fieldset class="clear">
	        <?php 
			$rol=isAnyRol($userid);
			if($rol== 1 ||  $rol== 3){?>
            <input type="submit" class="btn" value="Guardar Cambios" name="bt-edit" />
			<?php } ?>
	        <span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
        </fieldset>
    </form>
    <script type="text/javascript">
		$('.datepicker').datepicker($.datepicker.regional[ "es" ],{
			inline: true
		});	
		$('.datepicker').datepicker("option", "dateFormat", 'yy-mm-dd');
		$('#add').hide();
		var data = [<?php echo $data; ?>];
		$('#product').autocomplete({
			source: data,
			mustMatch: true,
			select: function(event, ui){
				$('#add').show();
			}
		});
	</script>
    <?php }else{ ?>
    <div class="error">Debe escribir un número de consecutivo</div>
    <p><a href="javascript:void(0);" class="btn" onClick="$.colorbox.close()">Volver</a></p>
    <?php } ?>
</div>