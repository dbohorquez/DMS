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
                    <th>Productos</th>
                    <th width="50">&nbsp;</th>
                </tr></thead><tbody>
                <?php
					$warehouses = getTable('warehouses','deletedAt IS not NULL','id desc');
					$numRows = mysql_num_rows($warehouses);
					if($numRows > 0){
						while($warehouse = mysql_fetch_array($warehouses)){
							$location = getItemLocation('warehouses',$warehouse['id']);
				?>
                <tr>
                	<td><?php echo $warehouse['name']; ?></td>
                    <td><?php echo $warehouse['type'] == 1 ? 'Física' : 'Virtual'; ?><br />
                    	<span<?php echo $warehouse['occupation'] >= 90 ? ' class="full"' : ' class="available"'; ?>><?php echo $warehouse['occupation']; ?>%</span>
                    </td>
                    <td><a href="mailto:<?php echo $warehouse['email']; ?>"><?php echo $warehouse['contactName']; ?></a></td>
                    <td>
                    	<strong>Tel:</strong> <?php echo $warehouse['phoneNumber']; ?><br />
                    	<strong>Cel:</strong> <?php echo $warehouse['cellphone']; ?><br />
                        <strong>Fax:</strong> <?php echo $warehouse['faxNumber']; ?>
                    </td>
                    <td>
						<?php echo $warehouse['address']; ?><br />
                        <?php echo utf8_encode($location['town'] . ', ' . $location['province']); ?>
                    </td>
                    <td>
                    <?php if($rol== 1 || $rol== 2){?>
                    	<ul class="table-actions">
                        <li><a href="includes/forms/delete.php?t=warehouses&d=<?php echo $warehouse['id']; ?>" class="icon delete colorbox" title="Eliminar"><span>Eliminar</span></a></li>
                        </ul>
			        <?php } ?>          
        
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