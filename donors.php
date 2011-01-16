<?php $section = 'donors'; ?>
<?php include('includes/header.php'); ?>

<?php if(isset($_POST['bt-add'])) list($warning, $success) = addDonor($_POST);?>
<?php if(isset($_POST['bt-edit'])) list($warning, $success) = editDonor($_POST);?>
<?php if(isset($_POST['bt-delete'])) list($warning, $success) = delete($_POST);?>
			<h2>Donantes</h2>
            <ul class="toolbar">
                <li><a href="includes/forms/donorsAdd.php" class="btn colorbox">Agregar Donante</a></li>
            </ul>
            <?php if($success != ''){ echo '<div class="success">' . $success . '</div>'; } ?>
			<?php if($warning != ''){ echo '<div class="error">' . $warning . '</div>'; } ?>
            <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	<th>Identificación</th>
                    <th>Nombre</th>
                    <th>Teléfonos</th>
                    <th>Ubicación</th>
                    <th>Correo Electrónico</th>
                    <th width="50">&nbsp;</th>
                </tr></thead><tbody>
                <?php
					$donors = getTable('donors','','id asc');
					$numRows = mysql_num_rows($donors);
					if($numRows > 0){
						while($donor = mysql_fetch_array($donors)){
							$location = getItemLocation('donors',$donor['id']);
							$types = array("","C.C.","C.E.","NIT");
				?>
                <tr>
                	<td><?php echo $types[$donor['type']] . ': ' . $donor['id']; ?></td>
                    <td><?php echo $donor['name']; ?></td>
                    <td>
                    	<strong>Tel:</strong> <?php echo $donor['phoneNumber']; ?><br />
                        <strong>Fax:</strong> <?php echo $donor['faxNumber']; ?>
                    </td>
                    <td>
						<?php echo $donor['address']; ?><br />
                        <?php echo utf8_encode($location['town'] . ', ' . $location['province']); ?>
                    </td>
                    <td><?php echo $donor['email']; ?></td>
                    <td>
                    	<ul class="table-actions">
                        	<li><a href="includes/forms/donorsEdit.php?e=<?php echo $donor['id']; ?>" class="icon edit colorbox" title="Editar"><span>Editar</span></a></li>
                            <li><a href="includes/forms/delete.php?t=donors&d=<?php echo $donor['id']; ?>" class="icon delete colorbox" title="Eliminar"><span>Eliminar</span></a></li>
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