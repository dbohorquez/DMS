<?php $section = 'warehouses'; ?>
<?php include('includes/header.php'); ?>

<?php if(isset($_POST['bt-transfer'])) list($warning, $success) = transferProducts($_POST);?>
<?php if(isset($_POST['bt-delete'])) list($warning, $success) = delete($_POST);?>
			<h2>Transferencias</h2>
			<ul class="toolbar">
            <?php 
			$rol=isAnyRol($_SESSION['dms_id']);
			if($rol== 1 || $rol== 2){?>
            <li><a href="includes/forms/transfersAdd.php?us=<?php echo $_SESSION['dms_id']?>" class="btn colorbox">Nueva Transferencia</a></li>
	        <?php } ?>          
            </ul>
            <?php if($success != ''){ echo '<div class="success">' . $success . '</div>'; } ?>
			<?php if($warning != ''){ echo '<div class="error">' . $warning . '</div>'; } ?>
            <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	<th>Bodega de Origen</th>
                  <th>Bodega Destino</th>
                  <th>Destino de Despacho</th>
                  <th>Comentarios</th>
									<th width="50">&nbsp;</th>
						  </tr></thead><tbody>
                <?php
					$transfers = getTable('transfers','deletedAt IS NULL','id desc');
					$numRows = mysql_num_rows($transfers);
					if($numRows > 0){
						while($transfer = mysql_fetch_array($transfers)){
							$starting_warehouse = getTable('warehouses', "deletedAt IS NULL and id = $transfer[starting_warehouse]","",1);
							$destination_warehouse = getTable('warehouses', "deletedAt IS NULL and id = $transfer[destination_warehouse]","",1);
							$shelter = getTable('shelters',"deletedAt IS NULL and id = $transfer[shelter_id]","",1);					
				?>
                <tr>
                	<td><?php echo $starting_warehouse['name'] == null ? "Virtual" : $starting_warehouse['name'] ; ?></td>
              	 	<td><?php echo $destination_warehouse['name']; ?></td>
									<td><?php echo $shelter['name']; ?></td>
									<td><?php echo $transfer['notes']; ?></td>
									<td>
                 		<ul class="table-actions">
                    	<li><a href="includes/forms/transferView.php?t=<?php echo $transfers['id']; ?>" class="icon view colorbox" title="Ver"><span>Ver</span></a></li>
                  	</ul>	
            			</td>
								</tr>
				<?php
					 }
					}else{
						echo '<tr><td colspan="6">No hay datos para mostrar</td></tr>';
					}
				?>
            </tbody></table>
            <ul id="pagination">
                <li class="prev"><a href="javascript:void(0);">&laquo;</a></li>
                <li class="next"><a href="javascript:void(0);">&raquo;</a></li>
                <li class="floatright">Mostrar: 
                    <select class="pagesize">
                        <option selected="selected" value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </li>
            </ul>
<?php include('includes/footer.php'); ?>
<script type="text/javascript">

function validateWarehouseForm(){
		valid = true
	  $("form input, form select").removeClass("error")
		if (isNil($("#name")))
		{ valid= false; $("#name").addClass("error") }
		if (!isSelected($("#town")))
		{ valid= false; $("#town").addClass("error") }
		if ( !isNil($("#occupation")) && !isPercentage($("#occupation")) )
		{ valid= false; $("#occupation").addClass("error") }
		
		if (!valid)
		{	jQuery("#errorMessage").html("Falta llenar algunos campos obligatorios(<span class=\"required\">*</span>).");
			jQuery.colorbox.resize();
		}
    return valid;
}

function validateTransferForm(){
		valid = true
	  $("form input").removeClass("error")
	
		if (!atLeastOne($(".product-list.text")))
		{ valid= false; $(".product-list.text").addClass("error") }
		
		if (!valid)
		{	jQuery("#errorMessage").html("Falta llenar algunos campos obligatorios(<span class=\"required\">*</span>).");
			jQuery.colorbox.resize();
		}
    return valid;
}

</script>