<?php
include("Biblioteca.php");
session_start();
if(!isset($_SESSION["Biblioteca"])){
    $_SESSION["Biblioteca"] = new Biblioteca();
}

?>

<html>
<head>
    <title>
        Actualizar libro
    </title>
    <link rel="stylesheet" href="CSS/EstiloGeneral.css">
    <link rel="stylesheet" href="CSS/Login.css">
    <script src="JS/jquery-3.1.1.min.js"></script>
    <script src="JS/login.js"></script>
    <meta charset="utf-8">
    <script type="text/javascript">
        function mostrarReferencia() {
            if (document.modificar.ids[1].checked == true) {
                document.getElementById('desdeotro').style.display = 'block';
            } else if (document.modificar.ids[0].checked == true) {
                document.getElementById('desdeotro').style.display = 'block';
            } else if (document.modificar.ids[2].checked == true) {
                document.getElementById('desdeotro').style.display = 'block';
            }
            else {
                document.getElementById('desdeotro').style.display = 'none';
            }
        }
    </script>
    <script>
        function abrir(url) {
            open(url, '', 'top=150,left=150,width=670,height=670');
        }
    </script>
</head>
<body class="back">
<div class="login">
    <div align="left">
        <a href="index.php"><img class="logo" title="Pagina de Inicio de ColBooks"src="icon/logo.png" height="40"></a>
    </div>
    <div align="center">
        <form action="prestamo.php" method="post">
            <input type="text" style="width: 30%;height: 10px;padding: 10px;border: none; border-radius: 2px;" class="textbox" name="buscar" placeholder="Busca tu libro favorito y prestalo!">
            <select style="width: 5%; height: 20px; padding: 5px" CLASS="select"  name="ids">
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
<div id="wrapper" style="width: 994px;">
    <div style="font-family: 'Source Sans Pro', serif;">
        <h2>Modificacion de Libros</h2>
        <h4>Para modificar un libro registrado, primero debes buscarlo.</h4>
    </div>
    <span style="font-family: 'Source Sans Pro', sans-serif">
<form action="buscarlibro.php" method="post" name="modificar">
    <input type="radio" name="ids" value="ISBN" id="isbn" onclick="mostrarReferencia();"/>ISBN
    <input type="radio" name="ids" value="Titulo" id="titulo" onclick="mostrarReferencia();"/>Titulo
    <input type="radio" name="ids" value="Autor" id="autor" onclick="mostrarReferencia();"/>Autor
    <div id="desdeotro" style="display:none;">
        <p><input type="text" name="buscar" class="textbox" style="font-family: 'Source Sans Pro', sans-serif"
                  placeholder="Buscar..."/></p>
    </div><p>
    <input type="submit" style="font-family: 'Source Sans Pro', sans-serif" value="Buscar Libro" class="boton"/>
    </p>
</form></span>
    <?php

    if (isset($_POST['ids']) && isset($_POST['buscar'])) {
        $edit = $_SESSION['Biblioteca']->buscarlibro($_POST['ids'], $_POST['buscar']);
        if (count($edit) > 0) {
            foreach ($edit as $value) {
                echo "<br><hr><span style='font-family: Source Sans Pro, sans-serif'>Informacion del libro:<br>
        <div class='contenedor' style='overflow-wrap: break-word; padding-right: 20px; width:97%; height: auto; padding-bottom: 7px'>
        <div style='position: relative; float: left'>
        <img src='imgportada/".$value->getImgPortada()."' height='150' width='120'>
        </div>
        <span style='font-family: Source Sans Pro, sans-serif; position: relative; left: 15px;'>
        <b>ISBN:</b>" . $value->getISBN() . ", <b>Titulo: </b>" . $value->getTitulo() . ", <b>Autor: </b>" . $value->getAutor() . ", <b>Editorial: </b>" . $value->getEditorial() . "<br><br> <b>Cantidad de Ejemplares: </b>" . $value->getCantidad() . ", <b>Numero de Paginas: </b>" . $value->getNumPag() . ", <b>Estante: </b> " . $value->getEstante() . "<br><br> <b>Idioma: </b> " . $value->getIdioma() . ", <b>Pais: </b>" . $value->getUbicacion() . ", <b>Categoria: </b> " . $value->getCategoria().", <b>Estado del libro: </b>" . $value->getEstado() . ", <b>Fecha Publicación:</b> " . $value->getFechaPub() . "<br><br>
        <form action=\"modificarlibro.php\" target=\"ventana\" onSubmit=\"window.open('modificarlibro.php','ventana', 'width=1124,height=633,resizable=no')\" method=\"post\">
        <input type=\"hidden\" id=\"form1\" name=\"isbn\" value=".$value->getISBN().">
        <input type=\"hidden\" id=\"form1\" name=\"img3\" value=".$value->getImgPortada().">
        <input type=\"hidden\" id=\"form1\" name=\"titulo3\" value='".$value->getTitulo()."'>
        <input type=\"hidden\" id=\"form1\" name=\"autor\" value=".$value->getAutor().">
        <input type=\"hidden\" id=\"form1\" name=\"editorial\" value=".$value->getEditorial().">
        <input type=\"hidden\" id=\"form1\" name=\"cantidad\" value=".$value->getCantidad().">
        <input type=\"hidden\" id=\"form1\" name=\"numpag\" value=".$value->getNumPag().">
        <input type=\"hidden\" id=\"form1\" name=\"estante\" value=".$value->getEstante().">
        <input type=\"hidden\" id=\"form1\" name=\"estante\" value=".$value->getEstante().">
        <input type=\"hidden\" id=\"form1\" name=\"idioma\" value=".$value->getIdioma().">
        <input type=\"hidden\" id=\"form1\" name=\"categoria\" value=".$value->getCategoria().">
        <input type=\"hidden\" id=\"form1\" name=\"estados\" value=".$value->getEstado().">
        <input type=\"hidden\" id=\"form1\" name=\"pais\" value=".$value->getUbicacion().">
        <input type=\"hidden\" id=\"form1\" name=\"fechapub1\" value=".$value->getFechaPub().">
        <input type=\"hidden\" id=\"form1\" name=\"enviar\">
        <input type='submit' class='boton' style='position: relative; top: 16px' value='Modificar'>
        </form>
        </div>
        </span>
        </br><br>";
            }
        } else {
            echo "<script type='text/javascript'>
  				alert('No se ha podido encontrar libros con estos criterios, compruebe los datos.');
			</script>";
        }
    }


    ?>
</div>
</body>
</html>
