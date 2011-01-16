<?php
$section = 'login';
session_start(); 
if(isset($_SESSION['dms_authorized'])){
	session_destroy();
	unset($_SESSION['dms_authorized']);
}
require_once('includes/functions.php');
if(isset($_POST['bt-login'])) $warning = validateLogin($_POST);
?>
<?php include('includes/header.php'); ?>
			<h2>Iniciar Sesión</h2>
            <?php if($warning != ''){ echo '<div class="error">' . $warning . '</div>'; } ?>
			<form action="login.php" enctype="application/x-www-form-urlencoded" method="post">
            	<fieldset>
                	<label for="email">Correo Electrónico:</label>
                    <input type="text" class="text" size="32" name="email" id="email" />
                </fieldset>
                <fieldset>
                	<label for="password">Contraseña:</label>
                    <input type="password" class="text" size="32" name="password" id="password" />
                </fieldset>
                <input type="submit" class="btn" value="Ingresar" name="bt-login" /><span class="cancel"><a href="recover.php">Olvidé mi contraseña</a></span>
            </form>
<?php include('includes/footer.php'); ?>