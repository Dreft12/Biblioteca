<?php
include "Biblioteca.php";
session_start();
header("Content-Type: text/html;charset=utf-8");
if (!isset($_SESSION["Biblioteca"])) {
    $_SESSION["Biblioteca"] = new Biblioteca();
}
?>
<html>
<head>
    <title>
        Configura tu cuenta
    </title>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
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
    <span style="font-family: 'Source Sans Pro', sans-serif">
         <h3>En esta pagina podras configurar tu cuenta, debes ingresar datos validos.</h3>
    <div style="padding-right: 600px;padding-top: 20px; position:absolute; font-family: 'Source Sans Pro', sans-serif">
        <h3 style="margin-top: 0">Configuracion de la cuenta</h3>
        Bienvenido al panel de configuracion de cuenta, en el podrá actualizar sus datos personales.
        <p>Nota: Rellene todos los campos e ingrese informacion valida, si no quieres actualizar tu contraseña deja ese campo de Contraseña en blanco.
           <p> Cuando realices dicho proceso, deberás reloguear para que los cambios surtan efecto.</p>
        </p></div>
    <div style="position: relative; left: 45%; top: 20px; padding-bottom: 20px">
    <form action="configurar.php" method="post">
        <input type="text" placeholder="Ingrese N° de Documento de Identidad" required name="IDEs" value="<?php echo $_SESSION['Inicio']->getId() ?>" readonly class="textbox">
        <input type="text" placeholder="Ingrese Primer Nombre" readonly name="PNombre" value="<?php echo $_SESSION['Inicio']->getPNombre() ?>" required class="textbox">
        <p>
            <input type="text" placeholder="Ingrese Segundo Nombre" name="SNombre" value="<?php echo $_SESSION['Inicio']->getSNombre() ?>" class="textbox">
            <input type="text" placeholder="Ingrese Primer Apellido" readonly required name="PApe" value="<?php echo $_SESSION['Inicio']->getPApellido() ?>" class="textbox">

        </p>
        <p>
            <input type="text" placeholder="Ingrese Segundo Apellido" name="SApe" value="<?php echo $_SESSION['Inicio']->getSApellido() ?>" class="textbox">
            <input type="text" placeholder="Ingrese Direccion" name="Dire" required value="<?php echo $_SESSION['Inicio']->getDireccion() ?>" class="textbox">

        </p>
        <p>
            <input type="text" placeholder="Ingrese el numero del Grado que cursa" required onkeypress="return checkIt(event)"  name="Grado" value="<?php echo $_SESSION['Inicio']->getGrado() ?>" class="textbox">
            <input type="text" placeholder="Ingrese Telefono" required name="Telefono" onkeypress="return checkIt(event)"  value="<?php echo $_SESSION['Inicio']->getTelefono() ?>" class="textbox">

        </p>
        <p>
            <input type="text" placeholder="Ingrese Correo" required name="Correo" value="<?php echo $_SESSION['Inicio']->getCorreo() ?>" class="textbox">
            <input type="date" class="date" title="Ingresa tu fecha de nacimiento" name="FechaN" value="<?php echo $_SESSION['Inicio']->getFecha() ?>">
            </p>
            <p>
                <input type="text" placeholder="Ingrese Nombre de Usuario" required name="Nick" value="<?php echo $_SESSION['Inicio']->getNick() ?>" class="textbox">
                <input type="password" placeholder="Ingrese nueva Contraseña" name="Pass" class="textbox">
            </p>
        <p>
            <input type="submit" style="position: relative; right: -150px" value="Modificar datos" class="boton">
        </p>
    </form>
    </div>
        </span>
    </div>

<?php
    if (isset($_POST['PNombre']) && isset($_POST['SNombre'])){
        if (isset($_POST['PApe']) && isset($_POST['SApe'])){
            if (isset($_POST['Nick']) && isset($_POST['Telefono'])){
                if (isset($_POST['Grado']) && isset($_POST['Dire'])){
                    if (isset($_POST['FechaN']) && isset($_POST['Correo'])){
                        $usuario = new Usuario(null,$_POST['Nick'], $_POST['Pass'], $_POST['PNombre'], $_POST['SNombre'], $_POST['PApe'], $_POST['SApe'], $_POST['Dire'], $_POST['Grado']
                        , $_POST['FechaN'], $_POST['Telefono'], $_POST['Correo'],null);
                        $_SESSION['Biblioteca']->modificarDatos($usuario);
                    }
                }
            }
        }
    }
?>
</body>
</html>