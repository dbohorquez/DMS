<?php $section = 'product-types'; ?>
<?php include('includes/header.php'); ?>

<?php if(isset($_POST['bt-add'])) list($warning, $success) = addCategory($_POST);?>
<?php if(isset($_POST['bt-edit'])) list($warning, $success) = editCategory($_POST);?>
<?php if(isset($_POST['bt-delete'])) list($warning, $success) = delete($_POST);?>
			<h2>Categorias</h2>
			<ul class="toolbar">
            <?php 
			$rol=isAnyRol($_SESSION['dms_id']);
			if($rol== 1 || $rol== 3 || $rol== 5 || $rol== 6){?>
            	<li><a href="includes/forms/categoriesAdd.php?us=<?php echo $_SESSION['dms_id']?>" class="btn colorbox">Agregar Categoria</a></li>
			<?php } ?>
            </ul>
            <?php if($success != ''){ echo '<div class="success">' . $success . '</div>'; } ?>
			<?php if($warning != ''){ echo '<div class="error">' . $warning . '</div>'; } ?>
            <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	<th>Nombre</th>
									<th>Cantidad</th>
                  <th>Descripción</th>
                  <th width="50">&nbsp;</th>
                </tr></thead><tbody>
                <?php
					$categories = getTable('categories','deletedAt IS NULL','id desc');
					$numRows = mysql_num_rows($categories);
					if($numRows > 0){
						while($category = mysql_fetch_array($categories)){
							 $unit = getTable('units',"id = $category[unit_id]",'',1);
				?>
                <tr>
                	<td><?php echo $category['name']; ?></td>
                  <td><?php echo $category['quantity']; ?> - <?php echo $unit['name'] ?></td>
									<td><?php echo $category['description']; ?></td>
                  <td>
                     <?php if($rol== 1 || $rol== 3 || $rol== 5 || $rol== 6){?>
                    	<ul class="table-actions">
                        	<li><a href="includes/forms/categoriesEdit.php?e=<?php echo $category['id']; ?>&us=<?php echo $_SESSION['dms_id']?>" class="icon edit colorbox" title="Editar"><span>Editar</span></a></li>
                            <li><a href="includes/forms/delete.php?t=categories&d=<?php echo $category['id']; ?>" class="icon delete colorbox" title="Eliminar"><span>Eliminar</span></a></li>
                        </ul>
					<?php } ?>
            			</td>
                </tr>
                <?php
						}
					}else{
						echo '<tr><td colspan="5">No hay datos para mostrar</td></tr>';
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