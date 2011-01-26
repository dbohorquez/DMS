<?php $section = 'product-types'; ?>
<?php include('includes/header.php'); ?>

<?php if(isset($_POST['bt-add'])) list($warning, $success) = addCategory($_POST);?>
<?php if(isset($_POST['bt-edit'])) list($warning, $success) = editCategory($_POST);?>
<?php if(isset($_POST['bt-delete'])) list($warning, $success) = delete($_POST);?>
			<h2>Metas</h2>
		     <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	<th>Nombre</th>
						   		<th>Meta</th>
									<th>Cantidad adquirida</th>
									<th>Porcentaje de cumplimiento</th>
							  </tr></thead><tbody>
                <?php
					$query	= 'SELECT c.name name, c.quantity AS quantity, u.name unit, SUM(p.quantity) accomplished,
									   (SUM(p.quantity)/c.quantity)*100 percentage
										 FROM categories c, units u, producttypes pt, products p
										 WHERE p.productTypes_id=pt.id AND pt.categories_id=c.id AND c.unit_id=u.id 
										 AND c.deletedAt IS NULL AND pt.deletedAt IS NULL AND p.deletedAt IS NULL 
										 GROUP BY  c.name';
					$categories = runQuery($query);
					$numRows = mysql_num_rows($categories);
					if($numRows > 0){
						while($category = mysql_fetch_array($categories)){
				?>
                <tr>
                	<td><?php echo $category['name']; ?></td>
                	<td><?php echo $category['quantity']; ?> - <?php echo $category['unit'] ?></td>
									<td><?php echo $category['accomplished']; ?> - <?php echo $category['unit'] ?></td>
									<td><?php echo $category['percentage']; ?> %</td>
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