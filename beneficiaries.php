<?php $section = 'shelter'; ?>
<?php include('includes/header.php'); ?>

<?php if(isset($_POST['bt-add'])) list($warning, $success) = addShelter($_POST);?>
<?php if(isset($_POST['bt-edit'])) list($warning, $success) = editShelter($_POST);?>
<?php if(isset($_POST['bt-delete'])) list($warning, $success) = delete($_POST);?>
			<h2>Beneficiarios</h2>
            <ul class="toolbar">
                <li><a href="includes/forms/sheltersAdd.php" class="btn colorbox">Agregar Beneficiario</a></li>
            </ul>
            <?php if($success != ''){ echo '<div class="success">' . $success . '</div>'; } ?>
			<?php if($warning != ''){ echo '<div class="error">' . $warning . '</div>'; } ?>
            <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>Teléfonos</th>
                    <th>Dirección</th>
                    <th>Correo Electrónico</th>
                    <th width="50">&nbsp;</th>
                </tr></thead><tbody>
                <?php
					$shelters = getTable('shelters','deletedAt IS NULL','id asc');
					$numRows = mysql_num_rows($shelters);
					if($numRows > 0){
						while($shelter = mysql_fetch_array($shelters)){
							$location = getItemLocation('shelters',$shelter['id']);
				?>
                <tr>
					<td><?php echo $shelter['name']; ?></td>
                    <td><?php echo $shelter['contactName']; ?></td>
                    <td>
                    	<strong>Tel:</strong> <?php echo $shelter['phoneNumber']; ?><br />
                        <strong>Fax:</strong> <?php echo $shelter['fax']; ?>
                    </td>
                    <td>
						<?php echo $shelter['address']; ?><br />
                        <?php echo utf8_encode($location['town'] . ', ' . $location['province']); ?>
                    </td>
                    <td><?php echo $shelter['email']; ?></td>
                    <td>
                    	<ul class="table-actions">
                        	<li><a href="includes/forms/sheltersEdit.php?e=<?php echo $shelter['id']; ?>" class="icon edit colorbox" title="Editar"><span>Editar</span></a></li>
                            <li><a href="includes/forms/delete.php?t=shelters&d=<?php echo $shelter['id']; ?>" class="icon delete colorbox" title="Eliminar"><span>Eliminar</span></a></li>
                        </ul>
                    </td>
                </tr>
                <?php
						}
					}else{
						echo '<tr><td colspan="7">No hay datos para mostrar</td></tr>';
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