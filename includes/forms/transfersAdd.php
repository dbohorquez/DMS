<div class="medium">
	<h3>Nueva Transferencia</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
		<div id="errorMessage" class="error"> </div>

    <form action="transfers.php" enctype="application/x-www-form-urlencoded" method="post" onsubmit="return validateColorboxForm();"> 
    	<?php
			include('../functions.php');
			$companies = getTable('companies','type = 1 and deletedAt IS NULL','name asc');
        	 if($company = mysql_fetch_array($companies)){
				$query = "SELECT  products.id, products.name, COUNT(products_donations.id)
							FROM products
							INNER JOIN products_donations
							ON products.id=products_donations.products_id
							LEFT JOIN donations
							ON donations.sequence=products_donations.donations_id
							WHERE  products_donations.state=2 AND products_donations.deletedAt IS NULL AND donations.companies_id= $company[id]
							GROUP BY products.id, products.name
							ORDER BY products.name";
							echo $query;
				$products = runQuery($query);
				$data = '';
				$userid = $_GET['us']; 
				while($product = mysql_fetch_array($products)){
					$data .= '"' . $product['name'] . '",';
				}
			}
		?>
        <div class="column c50p">
            <fieldset>
                <label for="warehousefrom">Bodega Origen: <span class="required">*</span></label>
								
                <select name="warehousefrom" id="warehousefrom">
										<option value="-1">Bodega Virtual</option>
                <?php
                    $warehouses = getTable('warehouses','','name asc');
                    while($warehouse = mysql_fetch_array($warehouses)){
                ?>
                    <option value="<?php echo $warehouse['id']; ?>"><?php echo $warehouse['name']; ?></option>
                <?php } ?>
                </select>
            </fieldset>
						<fieldset>
                <label for="company">Operador comercial: <span class="required">*</span></label>
                <select name="company" id="company">
                <?php
                    $companies = getTable('companies','type = 1 and deletedAt IS NULL','name asc');
                    while($company = mysql_fetch_array($companies)){
                ?>
                    <option value="<?php echo $company['id']; ?>"><?php echo $company['name']; ?></option>
                <?php } ?>
                </select>
            </fieldset>

            <fieldset>
                <label for="warehouseto">Bodega Destino: <span class="required">*</span></label>
                <select name="warehouseto" id="warehouseto">
                <?php
                    $warehouses = getTable('warehouses','type=1','name asc');
                    while($warehouse = mysql_fetch_array($warehouses)){
                ?>
                    <option value="<?php echo $warehouse['id']; ?>"><?php echo $warehouse['name']; ?></option>
                <?php } ?>
                </select>
            </fieldset>
        </div>
        <div class="column c50p last">
        <fieldset>
                <label for="shelter">Beneficiarios:</label>
                <select name="shelter" id="shelter">
								<option value="" selected="selected">Ninguno</option>
                <?php
                    $shelters = getTable('shelters','','name asc');
                    while($shelter = mysql_fetch_array($shelters)){
                ?>
                    <option value="<?php echo $shelter['id']; ?>"><?php echo $shelter['name']; ?></option>
                <?php } ?>
                </select>
            </fieldset>
        <fieldset>
            	<label for="notes">Comentarios:</label>
                <textarea class="text" cols="44" rows="6" name="notes" id="notes"></textarea>
        </fieldset>

        </div>
        <h4>Productos <span class="required">*</span></h4>
        <fieldset>
            <div class="column c33p">
                <label for="type">Añadir Producto:</label>
                <input type="text" class="text autocomplete" size="24" name="product" id="product" />
            </div>
            <div class="column c33p">
                <label for="quantity">Cantidad:</label>
	            <select name="quantity" id="quantity">
                	<option value="1">1</option>
                </select>
            </div>
            <div class="column c33p last">
                <a href="javascript:void(0);" class="btn fix" onclick="addProduct('#product',$('#quantity').attr('value'),'#expirationDate','.product-list',this);" id="add">Añadir</a>
            </div>
        </fieldset>
        <label>Productos seleccionados:</label>
        <ul class="product-list text atLeastOne"></ul>
        <fieldset class="clear">
        <?php 
		$rol=isAnyRol($userid);
		if($rol== 1 || $rol== 2){?>
  	    <input type="submit" class="btn clear" value="Agregar" name="bt-transfer" />
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
				from = $('#warehousefrom').val()
				updateElm('#quantity','includes/data/productQuantity.php?p='+ ui.item.value+"&w="+from);
			}
		});
		
		$('#warehousefrom').change(function () {		
			 selValue = $(this).children(":selected").val()
		   $("#warehouseto").children().show()
			 if (selValue != -1){
					$("#warehouseto").children("option[value='"+selValue+"']").hide()
					$("#company").parent().hide()
					company_id = ""
				}else{
					$("#company").parent().show()
					company_id = $("#company").val()
				}
			$("#warehouseto").children(":visible:first").attr("selected","selected")
			warehouse_id = $(this).val()
			
			$.ajax({
				type	 : 'POST', 
				url      : "includes/data/getProductNames.php",
				dataType : "text",
				data     : { warehouse : warehouse_id, company : company_id },
				success  : function(msg){
					if (msg != "error"){
						newData = msg.replace('"',"").split(",")
						$('#product').autocomplete( "option", "source",newData)
					}
				}
			})
			
			
		}) 
		
	</script>
</div>