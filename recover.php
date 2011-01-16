<?php
$section = 'login';
session_start(); 
if(isset($_SESSION['dms_authorized'])){
	session_destroy();
	unset($_SESSION['dms_authorized']);
}
require_once('includes/functions.php');
if(isset($_POST['bt-recover'])) list($warning, $success) = resetPassword($_POST);
?>
<?php include('includes/header.php'); ?>
			<h2>Recuperar Contraseña</h2>
            <?php if($warning != ''){ echo '<div class="error">' . $warning . '</div>'; } ?>
			<form action="recover.php" enctype="application/x-www-form-urlencoded" method="post">
            	<fieldset>
                	<label for="email">Correo Electrónico:</label>
                    <input type="text" class="text" size="32" name="email" id="email" />
                </fieldset>
                <input type="submit" class="btn" value="Recuperar" name="bt-recover" /><span class="cancel">o <a href="login.php">Volver</a></span>
            </form>
<?php include('includes/footer.php'); ?>