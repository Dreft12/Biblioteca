<?php
include "Biblioteca.php";
session_start();
if(!isset($_SESSION["Biblioteca"])){
    $_SESSION["Biblioteca"] = new Biblioteca();
}
?>

<html>
<head>
    <title>
        Insertar Libros a la Base de Datos
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
<div id="wrapper" style="width: 994px">

    <h1 align="center" style="font-family: 'Source Sans Pro', sans-serif;">Insertar Libro en la Biblioteca</h1>
    <h4 style="font-family: 'Source Sans Pro', sans-serif; margin: -20px 80px 0 0;
    float: right;">Vista previa de la portada del libro anterior: </h4><p>
    <div class="image">
        <img src="/imgportada/<?php if(isset($_FILES['imagen']['name'])){echo $_FILES['imagen']['name'];}else{ echo 'descarga.jpg';} ?>" height="350" width="350" alt="" />
    </div>
    <div style="font-family: 'Source Sans Pro', sans-serif;">
<form action="insertarlibro.php" enctype="multipart/form-data" method="post">
    <input type="text" class="textbox" onkeypress="return checkIt(event)" name="isbn" id="isbn" required placeholder="Ingrese el ISBN...">
        <input class="textbox" type="text" required name="titulo" placeholder="Ingrese el Titulo...">
    <p>
        Portada: <br><input class="select" id="imagen" required name="imagen" size="30" type="file"/>
        <input class="textbox" required type="text" name="autor" placeholder="Ingrese el nombre del Autor...">
    <p>
        <input type="text" required class="textbox" name="editorial" placeholder="Ingrese la Editorial...">
        <input class="textbox" required type="text" name="cantidad" onkeypress="return checkIt(event)" placeholder="Ingrese  la Cantidad de libros...">
    <p>
        <select required class="select" name="idioma" title="Idiomas">
            <option value="">Idioma del libro...</option>
            <?php
            $link = new Conexion();
            $sql = "SELECT * FROM valorparametro WHERE IdParametro = 3";
            $res = $link->getSql()->query($sql);
            while ($idioma = $res->fetch_assoc()) {
                echo '<OPTION VALUE="' . $idioma['IdValorParametro'] . '">' . $idioma['Valor'] . '</OPTION>';
            }
            ?>
        </select>
        <select required class="select" name="pais" title="Paises">
            <option value="">Pais de Publicacion...</option>
            <?php
            $link = new Conexion();
            $sql = "SELECT * FROM valorparametro WHERE IdParametro = 2";
            $res = $link->getSql()->query($sql);
            while ($pais = $res->fetch_assoc()) {
                echo '<OPTION VALUE="' . $pais['IdValorParametro'] . '">' . $pais['Valor'] . '</OPTION>';
            }
            ?>
        </select>
    <p>
        <input required type="text" class="textbox" name="numpag" onkeypress="return checkIt(event)" placeholder="Ingrese Numero de Paginas...">
        <input required type="text" class="textbox" name="estante" onkeypress="return checkIt(event)" placeholder="Ingrese el N° de estante...">
    <p>
        <select required class="select" name="categoria" title="Categorias">
            <option value="">Categoria del Libro...</option>
            <?php
            $link = new Conexion();
            $sql = "SELECT * FROM valorparametro WHERE IdParametro = 1";
            $res = $link->getSql()->query($sql);
            while ($categoria = $res->fetch_assoc()) {
                echo '<OPTION VALUE="' . $categoria['IdValorParametro'] . '">' . $categoria['Valor'] . '</OPTION>';
            }
            ?>
        </select>
        <select required name="estados" class="select" title="Estado del Libro">
            <option value="">Estado del Libro...</option>
            <?php
            $link = new Conexion();
            $sql = "SELECT * FROM valorparametro WHERE IdParametro = 4";
            $res = $link->getSql()->query($sql);
            while ($estado = $res->fetch_assoc()) {
                echo '<OPTION VALUE="' . $estado['IdValorParametro'] . '">' . $estado['Valor'] . '</OPTION>';
            }
            ?>
        </select>
    <p>
        <input type="date" required name="fechapub" class="date" title="Fecha Publicacion">
    <p>
        <input  type="submit" class="boton" value="Guardar Libro" title="Guardar libro en la Base de Datos">
        <input type="reset" class="boton" value="Reiniciar Datos">
</form>
    </div>



    </div>
<?php

if (isset($_POST['isbn']) && isset($_POST['titulo'])) {
    if (isset($_POST['autor']) && isset($_POST['editorial'])) {
        if (isset($_POST['cantidad']) && isset($_POST['idioma'])) {
            if (isset($_POST['pais']) && isset($_POST['categoria'])) {
                if (isset($_POST['estados']) && isset($_POST['fechapub'])) {
                    if (isset($_POST['numpag']) && isset($_FILES['imagen'])) {
                        if(isset($_POST['estante'])) {
                            $nombre_img = $_FILES['imagen']['name'];
                            $tmp = $_FILES['imagen']['tmp_name'];
                            $folder = 'imgportada';
                            move_uploaded_file($tmp, $folder . '/' . $nombre_img);
                            $libro = new Libro($_POST['isbn'], $_POST['titulo'], $nombre_img, $_POST['autor'], $_POST['editorial'], $_POST['cantidad'],
                                $_POST['idioma'], $_POST['pais'], $_POST['numpag'], $_POST['estante'], $_POST['categoria'],$_POST['estados'], $_POST['fechapub']);
                            $_SESSION['Biblioteca']->agregarLibro($libro);
                            $result = $link->getSql()->query("SELECT * FROM libros");
                        }
                    }
                }
            }
        }
    }

}
?>
</body>
</html>