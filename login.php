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
if (isset($_POST['user']) && isset($_POST['password'])) {
    $bool = $_SESSION['Biblioteca']->ingresarUser($_POST['user'], $_POST['password']);
    if($bool == true){
        header("location: index.php");

    }else{
        echo "<script type=\"text/javascript\">
                    alert('Datos erroneos, no se ha podido ingresar');
                    window.location='index.php';
                </script>";

    }
}
?>
</body>
</html>