<?php $section = 'options'; ?>
<?php include('includes/header.php'); ?>

<?php if(isset($_POST['bt-add'])) list($warning, $success) = addUser($_POST);?>
<?php if(isset($_POST['bt-edit'])) list($warning, $success) = editUser($_POST);?>
<?php if(isset($_POST['bt-delete'])) list($warning, $success) = delete($_POST);?>
<?php if(isset($_POST['bt-import'])) list($warning, $success) = importTowns($_POST,$_FILES);?>
<?php if(isset($_POST['bt-change'])) list($warning, $success) = changePassword($_POST);?>
			<h2>Opciones</h2>
            <?php if($success != ''){ echo '<div class="success">' . $success . '</div>'; } ?>
            <?php if($warning != ''){ echo '<div class="error">' . $warning . '</div>'; } ?>
            <div class="column c66p">
            	<h3>Usuarios</h3>
                <?php 
				$rol=isAnyRol($_SESSION['dms_id']);
				if($rol== 1){?>
				<ul class="toolbar">
                    <li><a href="includes/forms/usersAdd.php" class="btn colorbox">Agregar Usuario</a></li>
                </ul>
				<?php } ?>
                
                <table cellpadding="0" cellspacing="0"><thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                        <th>Perfil</th>
                        <th width="50">&nbsp;</th>
                    </tr></thead><tbody>
                    <?php
                        $users = getTable('users','deletedAt IS NULL','id asc');
                        $numRows = mysql_num_rows($users);
                        if($numRows > 0){
                            while($user = mysql_fetch_array($users)){
                    ?>
                    <tr>
                        <td><?php echo $user['name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['profile']; ?></td>
                        <td>
                        <?php if($rol== 1){?>
                            <ul class="table-actions">
                                <li><a href="includes/forms/usersEdit.php?e=<?php echo $user['id']; ?>" class="icon edit colorbox" title="Editar"><span>Editar</span></a></li>
                                <li><a href="includes/forms/delete.php?t=users&d=<?php echo $user['id']; ?>" class="icon delete colorbox" title="Eliminar"><span>Eliminar</span></a></li>
                            </ul>
                        <?php } ?>
                        </td>
                    </tr>
                    <?php
                            }
                        }else{
                            echo '<tr><td colspan="4">No hay datos para mostrar</td></tr>';
                        }
                    ?>
                </tbody></table>
            </div>
            <div class="column c33p last">
            	<h3>Cambiar Contraseña</h3>
                <form action="options.php" enctype="application/x-www-form-urlencoded" method="post">
                	<input type="hidden" name="user_id" value="<?php echo $_SESSION['dms_id']; ?>" />
                    <fieldset>
                        <label for="current">Contraseña Actual:</label>
                        <input type="password" class="text" size="32" name="current" id="current" />
                    </fieldset>
                    <fieldset>
                        <label for="password">Nueva Contraseña:</label>
                        <input type="password" class="text" size="32" name="password" id="password" />
                    </fieldset>
                    <fieldset>
                        <label for="password-confirm">Confirmar Nueva Contraseña:</label>
                        <input type="password" class="text" size="32" name="password-confirm" id="password-confirm" />
                    </fieldset>
                    <fieldset class="push">
	                    <input type="submit" class="btn" value="Cambiar" name="bt-change" />
                    </fieldset>
                </form>
            	<h3 class="floatleft">Municipios</h3>
                <?php if($rol== 1){?>
                <a href="includes/forms/townsImport.php" class="btn floatright colorbox">Importar Municipios</a>
				<?php } ?>
				<ul class="toolbar">
                    <li>
                    	<select name="province" id="province" onchange="document.location.href='options.php?p=' + this.value;">
                        	<option value="">-- Seleccione un Departamento --</option>
						<?php
                            $provinces = getTable('provinces','','name asc');
                            while($province = mysql_fetch_array($provinces)){
                        ?>
                            <option value="<?php echo $province['id']; ?>"<?php if($_GET['p'] == $province['id']){ ?> selected="selected"<?php } ?>><?php echo utf8_encode($province['name']); ?></option>
                        <?php } ?>
                        </select>
                    </li>
                </ul>
                <table cellpadding="0" cellspacing="0"><thead>
                    <tr>
                        <th>Municipio</th>
                        <th width="20">&nbsp;</th>
                    </tr></thead><tbody>
                    <?php
						if($province = $_GET['p']){
							$towns = getTable('towns',"provinces_id = $province",'name asc');
							$numRows = mysql_num_rows($towns);
							if($numRows > 0){
								while($town = mysql_fetch_array($towns)){
                    ?>
                    <tr>
                        <td><?php echo utf8_encode($town['name']); ?></td>
                        <td>
                            <ul class="table-actions">
                                <li><a href="includes/forms/delete.php?t=towns&d=<?php echo $town['id']; ?>" class="icon delete colorbox" title="Eliminar"><span>Eliminar</span></a></li>
                            </ul>
                        </td>
                    </tr>
                    <?php
								}
							}else{
								echo '<tr><td colspan="3">No hay datos para mostrar</td></tr>';
							}
						}else{
							echo '<tr><td colspan="3">Seleccione un departamento</td></tr>';
						}
                    ?>
                </tbody></table>
            </div>
<?php include('includes/footer.php'); ?>