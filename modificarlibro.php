<?php
include "Biblioteca.php";
session_start();
if (!isset($_SESSION["Biblioteca"])) {
    $_SESSION["Biblioteca"] = new Biblioteca();
}
?>
<html>
<head>
    <title>
        Modificar un libro
    </title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/EstiloGeneral.css">
    <link rel="stylesheet" href="CSS/Login.css">
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
    <div style="font-family: 'Source Sans Pro', serif;">
        <h1 align="center">Modificar libro</h1>
        <h4 style="font-family: 'Source Sans Pro', sans-serif; margin: -20px 100px 0 0;
    float: right;">Vista previa de la portada del libro: </h4>
        <p>
        <div class="image">
            <img src="/Biblioteca/imgportadas/<?php
            if ($_POST['img3'] != '') {
                echo $_POST['img3'];
            } elseif (isset($_POST['img'])) {
                echo $_POST['img'];
            } else {
                echo 'descarga.jpg';
            } ?>" height="350" width="350" alt=""/>
        </div>
        <form action="modificarlibro.php" enctype="multipart/form-data" method="post">
            <input type="text" class="textbox" value="<?php echo $_POST['isbn']; ?>" readonly name="isbn"
                   placeholder="Ingrese el ISBN...">
            <input class="textbox" type="text" name="titulo3" value="<?php echo $_POST['titulo3'] ?>"
                   placeholder="Ingrese el Titulo...">
            <p>
                Portada: <br><input class="select" id="imagen" name="img" size="30" type="file"
                                    value="<?php echo $_POST['img3'] ?>"/>
                <input class="textbox" type="text" name="autor" value="<?php echo $_POST['autor']; ?>"
                       placeholder="Ingrese el nombre del Autor...">
            <p>
                <input type="text" class="textbox" name="editorial" value="<?php echo $_POST['editorial']; ?>"
                       placeholder="Ingrese la Editorial...">
                <input class="textbox" type="text" onkeypress="return checkIt(event)" name="cantidad"
                       value="<?php echo $_POST['cantidad']; ?>"
                       placeholder="Ingrese la Cantidad de libros...">
            <p>
                <select class="select" name="idioma" title="Idiomas">
                    <option>Idioma del libro...</option>
                    <?php
                    $link = new Conexion();
                    $sql = "SELECT * FROM libros WHERE ISBN = " . $_POST['isbn'];
                    $sql2 = "SELECT * FROM valorparametro WHERE IdParametro = 3";
                    $res = $link->getSql()->query($sql);
                    $res2 = $link->getSql()->query($sql2);
                    $items = $res->fetch_assoc();
                    while ($items2 = $res2->fetch_assoc()) {
                        if ($items['IdIdioma'] == $items2['IdValorParametro']) {
                            echo "<option value=\"$items2[IdValorParametro]\" selected>$items2[Valor]</option>";
                        } else {
                            echo "<option value=\"$items2[IdValorParametro]\">$items2[Valor]</option>";
                        }
                    }
                    ?>
                </select>
                <select class="select" name="pais" title="Paises">
                    <option>Pais de Publicacion...</option>
                    <?php
                    $link = new Conexion();
                    $sql = "SELECT * FROM libros WHERE ISBN = " . $_POST['isbn'];
                    $sql2 = "SELECT * FROM valorparametro WHERE IdParametro = 2";
                    $res = $link->getSql()->query($sql);
                    $res2 = $link->getSql()->query($sql2);
                    $items = $res->fetch_assoc();
                    while ($items2 = $res2->fetch_assoc()) {
                        if ($items['IdPais'] == $items2['IdValorParametro']) {
                            echo "<option value=\"$items2[IdValorParametro]\" selected>$items2[Valor]</option>";
                        } else {
                            echo "<option value=\"$items2[IdValorParametro]\">$items2[Valor]</option>";
                        }
                    }
                    ?>
                </select>
            <p>
                <input type="text" class="textbox" onkeypress="return checkIt(event)"
                       value="<?php echo $_POST['numpag']; ?>" name="numpag"
                       placeholder="Ingrese Numero de Paginas...">
                <input type="text" class="textbox" name="estante" onkeypress="return checkIt(event)"
                       value="<?php echo $_POST['estante']; ?>"
                       placeholder="Ingrese el N° de estante...">
            <p>
                <select class="select" name="categoria" title="Categorias">
                    <option>Categoria del Libro...</option>
                    <?php
                    $link = new Conexion();
                    $sql = "SELECT * FROM libros WHERE ISBN = " . $_POST['isbn'];
                    $sql2 = "SELECT * FROM valorparametro WHERE IdParametro = 1";
                    $res = $link->getSql()->query($sql);
                    $res2 = $link->getSql()->query($sql2);
                    $items = $res->fetch_assoc();
                    while ($items2 = $res2->fetch_assoc()) {
                        if ($items['IdCategoria'] == $items2['IdValorParametro']) {
                            echo "<option value=\"$items2[IdValorParametro]\" selected>$items2[Valor]</option>";
                        } else {
                            echo "<option value=\"$items2[IdValorParametro]\">$items2[Valor]</option>";
                        }
                    }
                    ?>
                </select>
                <select name="estados" class="select" title="Estado del Libro">
                    <option>Estado del Libro...</option>
                    <?php
                    $link = new Conexion();
                    $sql = "SELECT * FROM libros WHERE ISBN = " . $_POST['isbn'];
                    $sql2 = "SELECT * FROM valorparametro WHERE IdParametro = 4";
                    $res = $link->getSql()->query($sql);
                    $res2 = $link->getSql()->query($sql2);
                    $items = $res->fetch_assoc();
                    while ($items2 = $res2->fetch_assoc()) {
                        if ($items['IdEstado'] == $items2['IdValorParametro']) {
                            echo "<option value=\"$items2[IdValorParametro]\" selected>$items2[Valor]</option>";
                        } else {
                            echo "<option value=\"$items2[IdValorParametro]\">$items2[Valor]</option>";
                        }
                    }
                    ?>
                </select>
            <p>
                <input type="date" name="fechapub"
                       value="<?php if (isset($_POST['fechapub1'])) echo $_POST['fechapub1']; else echo $_POST['fechapub']; ?>"
                       class="date" title="Fecha Publicacion">
            <p>
                <input type="submit" class="boton" value="Modificar Libro" title="Modificar libro en la Base de Datos"
                       onclick="cerrarse()">
        </form>
    </div>
    <?php

    if (isset($_POST['isbn']) && isset($_POST['titulo3'])) {
        if (isset($_POST['autor']) && isset($_POST['editorial'])) {
            if (isset($_POST['cantidad']) && isset($_POST['idioma'])) {
                if (isset($_POST['pais']) && isset($_POST['categoria'])) {
                    if (isset($_POST['estados']) && isset($_POST['fechapub'])) {
                        if (isset($_POST['numpag']) && isset($_POST['estante'])) {
                            if (isset($_FILES['img'])) {
                                if ($_FILES['img']['error'] != 4) {
                                    $nombre_img = $_FILES['img']['name'];
                                    $tmp = $_FILES['img']['tmp_name'];
                                    $folder = 'imgportadas';
                                    move_uploaded_file($tmp, $folder . '/' . $nombre_img);
                                    $link = new Conexion();
                                    $result = $link->getSql()->query("SELECT ImgPortada FROM libros WHERE ISBN = " . $_POST['isbn']);
                                    $row = $result->fetch_assoc();
                                    /*almacenamos el nombre de la ruta en la variable $ruta_img*/
                                    $ruta_img = $row["ImgPortada"];
                                    $libro = new Libro($_POST['isbn'], $_POST['titulo3'], $nombre_img, $_POST['autor'], $_POST['editorial'], $_POST['cantidad'],
                                        $_POST['idioma'], $_POST['pais'], $_POST['numpag'], $_POST['estante'], $_POST['categoria'], $_POST['estados'], $_POST['fechapub']);
                                    $_SESSION['Biblioteca']->modificarLibro($libro);
                                    echo "<script type=\"text/javascript\">
                                window.close();
                                window.opener.document.location.reload()
                                </script>";
                                } else {
                                    $link = new Conexion();
                                    $result = $link->getSql()->query("SELECT ImgPortada FROM libros WHERE ISBN = " . $_POST['isbn']);
                                    $row = $result->fetch_assoc();
                                        /*almacenamos el nombre de la ruta en la variable $ruta_img*/
                                    $ruta_img = $row["ImgPortada"];
                                    $libro = new Libro($_POST['isbn'], $_POST['titulo3'], $ruta_img, $_POST['autor'], $_POST['editorial'], $_POST['cantidad'],
                                        $_POST['idioma'], $_POST['pais'], $_POST['numpag'], $_POST['estante'], $_POST['categoria'], $_POST['estados'], $_POST['fechapub']);
                                    $_SESSION['Biblioteca']->modificarLibro($libro);
                                    echo "<script type=\"text/javascript\">
                                window.close();
                                window.opener.document.location.reload()
                                </script>";
                                }
                            }
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