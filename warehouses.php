<?php $section = 'warehouses'; ?>
<?php include('includes/header.php'); ?>

<?php if(isset($_POST['bt-add'])) list($warning, $success) = addWarehouse($_POST);?>
<?php if(isset($_POST['bt-edit'])) list($warning, $success) = editWarehouse($_POST);?>
<?php if(isset($_POST['bt-transfer'])) list($warning, $success) = transferProducts($_POST);?>
<?php if(isset($_POST['bt-delete'])) list($warning, $success) = delete($_POST);?>
			<h2>Bodegas</h2>
			<ul class="toolbar">
            	<li><a href="includes/forms/warehousesAdd.php" class="btn colorbox">Nueva Bodega</a></li>
                <li><a href="includes/forms/warehousesTransfer.php" class="btn colorbox">Transferir Productos</a></li>
            </ul>
            <?php if($success != ''){ echo '<div class="success">' . $success . '</div>'; } ?>
			<?php if($warning != ''){ echo '<div class="error">' . $warning . '</div>'; } ?>
            <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	<th>Nombre</th>
                    <th>Tipo</th>
                    <th>Contacto</th>
                    <th>Teléfonos</th>
                    <th>Ubicación</th>
                    <th>Descripción</th>
                    <th width="50">&nbsp;</th>
                </tr></thead><tbody>
                <?php
					$warehouses = getTable('warehouses','','id desc');
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
                    <td><?php echo $warehouse['contactName']; ?></td>
                    <td>
                    	<strong>Tel:</strong> <?php echo $warehouse['phoneNumber']; ?><br />
                    	<strong>Cel:</strong> <?php echo $warehouse['cellphone']; ?><br />
                        <strong>Fax:</strong> <?php echo $warehouse['faxNumber']; ?>
                    </td>
                    <td>
						<?php echo $warehouse['address']; ?><br />
                        <?php echo utf8_encode($location['town'] . ', ' . $location['province']); ?>
                    </td>
                    <td><?php echo $warehouse['description']; ?></td>
                    <td>
                    	<ul class="table-actions">
                        	<li><a href="includes/forms/warehousesEdit.php?e=<?php echo $warehouse['id']; ?>" class="icon edit colorbox" title="Editar"><span>Editar</span></a></li>
                            <li><a href="includes/forms/delete.php?t=warehouses&d=<?php echo $warehouse['id']; ?>" class="icon delete colorbox" title="Eliminar"><span>Eliminar</span></a></li>
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