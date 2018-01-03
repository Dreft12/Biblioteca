<?php
include "Biblioteca.php";
session_start();
if (!isset($_SESSION["Biblioteca"])) {
    $_SESSION["Biblioteca"] = new Biblioteca();
}
?>
<html>
<head>
    <title>Registrate en Colbooks</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/EstiloGeneral.css">
    <link rel="stylesheet" href="CSS/Login.css"/>
    <script src="JS/jquery-3.1.1.min.js"></script>
    <script src="JS/login.js"></script>
    <script type="text/javascript">
        function checkIt(evt) {
            evt = (evt) ? evt : window.event
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                alert('No se pueden ingresar letras en este campo.')
                return false
            }
            status = ""
            return true
        }
    </script>
</head>
<body class="back">
<div class="login">
    <div align="left">
        <a href="index.php"><img class="logo" title="Pagina de Inicio de ColBooks" src="icon/logo.png" height="40"></a>
    </div>
    <div align="center">
        <form action="prestamo.php" method="post">
            <input type="text" style="width: 30%;height: 10px;padding: 10px;border: none; border-radius: 2px;"
                   class="textbox" name="buscar" placeholder="Busca tu libro favorito y prestalo!">
            <select style="width: 5%; height: 20px; padding: 5px" CLASS="select" name="ids">
                <option>ISBN</option>
                <option>Titulo</option>
                <option>Autor</option>
            </select>
            <input style="width: 70px; height: 18px;" class="boton" type="submit" value="Buscar">
        </form>
    </div>
    <?php if (isset($_COOKIE['TipoUser'])) {
        if ($_COOKIE['TipoUser'] != '') {
            $_SESSION['Biblioteca']->iniciarTipoUser($_COOKIE['TipoUser']);
        } else {
            $_SESSION['Biblioteca']->iniciarSesion();
        }
    } else {
        $_SESSION['Biblioteca']->iniciarSesion();
    } ?>
</div>
<div id="wrapper" style="width: 994px">
    <h3>Ingresa todos los campos correspondientes para realizar el registro.</h3>
    <div style="padding-right: 600px;padding-top: 20px; position:absolute; font-family: 'Source Sans Pro', sans-serif">
        <h3 style="margin-top: 0">Creacion de Usuarios</h3>
        Bienvenido al panel de creacion de usuarios, en el podrá crear un usuario para un estudiante.
        <p>Nota: Rellene todos los campos e ingrese informacion valida</p></div>
    <div style="position: relative; left: 45%; top: 20px; padding-bottom: 20px">
    <form action="registrar.php" method="post">
        <input type="text" placeholder="Ingrese N° de Documento de Identidad" onkeypress="return checkIt(event)" required name="IDEs" class="textbox">
        <input type="text" placeholder="Ingrese Primer Nombre" name="PNombre" required class="textbox">
        <p>
            <input type="text" placeholder="Ingrese Segundo Nombre" name="SNombre" class="textbox">
            <input type="text" placeholder="Ingrese Primer Apellido" required name="PApe" class="textbox">

        </p>
        <p>
            <input type="text" placeholder="Ingrese Segundo Apellido" name="SApe" class="textbox">
            <input type="text" placeholder="Ingrese Direccion" name="Dire" required class="textbox">

        </p>
        <p>
            <input type="text" placeholder="Ingrese el numero del Grado que cursa" required name="Grado" onkeypress="return checkIt(event)" class="textbox">
            <input type="date" required name="FechaN" class="date" title="Ingresa tu fecha de nacimiento">

        </p>
        <p>
            <input type="text" placeholder="Ingrese Correo" required name="Correo" class="textbox">
            <input type="text" placeholder="Ingrese Telefono" required name="Telefono" onkeypress="return checkIt(event)" class="textbox">
            </p>
            <p>
                <input type="text" placeholder="Ingrese Nombre de Usuario" required name="Nick" class="textbox">
                <input type="password" placeholder="Ingrese Contraseña" required name="Pass" class="textbox">
            </p>
        <p>
            <input type="submit" value="Registate" class="boton">
            <input type="reset" value="Reiniciar Datos" class="boton">
        </p>
    </form>
    </div>
    <?php
        if(isset($_POST['IDEs']) && isset($_POST['PNombre'])){
            if (isset($_POST['SNombre']) && isset($_POST['PApe'])){
                if (isset($_POST['SApe']) && isset($_POST['Dire'])){
                    if(isset($_POST['Telefono']) && isset($_POST['Correo'])){
                        if(isset($_POST['Nick']) && isset($_POST['FechaN'])){
                            if(isset($_POST['Pass']) && isset($_POST['Grado'])){
                                $user = new Usuario($_POST['IDEs'],$_POST['Nick'],$_POST['Pass'], $_POST['PNombre'], $_POST['SNombre'],$_POST['PApe'], $_POST['SApe'], $_POST['Dire'],$_POST['Grado'], $_POST['FechaN'], $_POST['Telefono'],$_POST['Correo'],9);
                                $_SESSION['Biblioteca']->registrar($user);
                            }
                        }
                    }
                }
            }
        }
    ?>
</div>
</body>
</html>