<?php
include "Biblioteca.php";
session_start();
if (!isset($_SESSION["Biblioteca"])) {
    $_SESSION["Biblioteca"] = new Biblioteca();
}
?>
<html>
<head>
    <title>Historial de prestamos</title>
    <meta charset="utf-8">
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
    <h3>Historial de prestamos</h3>
    <span style="font-family: 'Source Sans Pro', sans-serif">Aqui encontrarás los detalles de tus prestamos realizados, están ordenados desde el más reciente hasta el más antiguo, revisa constantemente las fechas de devoluciones de los libros que has solicitado
        para que evites una posible multa.</span>
    <hr>
    <?php $_SESSION['Biblioteca']->prestamosRealizados() ?>
</div>
</body>
</html>