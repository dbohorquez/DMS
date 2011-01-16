<?php $section = 'companies'; ?>
<?php include('includes/header.php'); ?>

<?php if(isset($_POST['bt-add'])) list($warning, $success) = addCompany($_POST);?>
<?php if(isset($_POST['bt-edit'])) list($warning, $success) = editCompany($_POST);?>
<?php if(isset($_POST['bt-delete'])) list($warning, $success) = delete($_POST);?>
			<h2>Entidades</h2>
            <?php if(isSupervisor($_SESSION['dms_id'])){?>
			<ul class="toolbar">
            	<li><a href="includes/forms/companiesAdd.php" class="btn colorbox">Nueva Entidad</a></li>
            </ul>
			<?php } ?>
            <?php if($success != ''){ echo '<div class="success">' . $success . '</div>'; } ?>
			<?php if($warning != ''){ echo '<div class="error">' . $warning . '</div>'; } ?>
            <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	<th>Nombre</th>
                    <th>Tipo</th>
                    <th>Contacto</th>
                    <th>Teléfonos</th>
                    <th>Ubicación</th>
                    <th>Correo Electrónico</th>
                    <th width="50">&nbsp;</th>
                </tr></thead><tbody>
                <?php
					$companies = getTable('companies','','id desc');
					$numRows = mysql_num_rows($companies);
					if($numRows > 0){
						while($company = mysql_fetch_array($companies)){
							$location = getItemLocation('companies',$company['id']);
				?>
                <tr>
                	<td><?php echo $company['name']; ?></td>
                    <td><?php echo $company['type'] == 1 ? 'Proveedora' : 'Canal de Distribución'; ?></td>
                    <td><?php echo $company['contactName']; ?></td>
                    <td>
                    	<strong>Tel:</strong> <?php echo $company['phoneNumber']; ?><br />
                        <strong>Fax:</strong> <?php echo $company['faxNumber']; ?>
                    </td>
                    <td>
						<?php echo $company['address']; ?><br />
                        <?php echo utf8_encode($location['town'] . ', ' . $location['province']); ?>
                    </td>
                    <td><?php echo $company['email']; ?></td>
                    <td>
                    	<ul class="table-actions">
                        	<li><a href="includes/forms/companiesEdit.php?e=<?php echo $company['id']; ?>" class="icon edit colorbox" title="Editar"><span>Editar</span></a></li>
                            <li><a href="includes/forms/delete.php?t=companies&d=<?php echo $company['id']; ?>" class="icon delete colorbox" title="Eliminar"><span>Eliminar</span></a></li>
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