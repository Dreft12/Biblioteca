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
        Bienvenidos a ColBooks - ¡Qué esperas para leer un buen libro!
    </title>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="CSS/EstiloGeneral.css">
    <link rel="stylesheet" href="CSS/Login.css"/>
    <script src="JS/jquery-3.1.1.min.js"></script>
    <script src="JS/login.js"></script>

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
        <h3>Bienvenido al sistema Bibliotecario Colbooks podrás consultar y prestar tus libros favoritos.</h3>
        <div style="width: 27%;padding-left: 1px;padding-right: 15px;height: 1px;position: relative;padding-bottom: 9px; float: right;">
            <h4 style="position: relative; bottom: 16px; margin-bottom: 1px; ">Rankings Estadisticos.</h4>
            <div class="contenedor" style="height: auto;padding-bottom: 15px;">
                <span style="font-family: 'Source Sans Pro', sans-serif">TOP 5 estudiantes con mayores prestamos.<hr
                        style="position: inherit; left: 8px;">
                    <?php $_SESSION['Biblioteca']->top5(); ?>
                </span>
            </div>
            <br><br>
            <div class="contenedor" style="height: auto;padding-bottom: 15px;">
                <span style="font-family: 'Source Sans Pro', sans-serif"><div align="left" style="padding-left: 12px">TOP 5 libros más populares.</div><hr
                        style="position: inherit; left: 8px;">
                    <?php $_SESSION['Biblioteca']->top5Libros(); ?>
                </span>
            </div>
        </div>
        <div style="position: relative; top: 520px; margin-bottom: 1px">
        <h4  style="position: relative; bottom: 520px; margin-bottom: 1px">Ultimos libros agregados recientemente.</h4>
            <?php $_SESSION['Biblioteca']->librosrecientes() ?>
</div>
    </span>
</div>
</body>
</html>