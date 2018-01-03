<?php 
	include "Biblioteca.php";
	session_start();
	if (!isset($_SESSION["Biblioteca"])) {
    	$_SESSION["Biblioteca"] = new Biblioteca();
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Redirigiendo...</title>
</head>
<body>
<?php 
	$_SESSION['Biblioteca']->cerrar() 
?>
</body>
</html>