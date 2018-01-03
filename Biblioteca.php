<?php
include 'libro.php';
include 'Conexion.php';
include 'Usuario.php';

class Biblioteca
{


    /**
     * Biblioteca constructor.
     */
    public $usuario;

    public function agregarLibro(Libro $libro)
    {
        $link = new Conexion();
        if (isset($_COOKIE['IdUser']) && isset($_COOKIE['NickUser'])) {
            if ($_COOKIE['IdUser'] != '' && $_COOKIE['NickUser'] != '') {
                $sql = "INSERT INTO libros (ISBN, Titulo, ImgPortada, Autor, Editorial, Cantidad, IdIdioma,IdPais,NumPaginas, Estante, IdCategoria, IdEstado, FPublicacion, FAgregado ) VALUES ('" . $libro->getISBN() . "','" . $libro->getTitulo() . "', '" . $libro->getImgPortada() . "', '" . $libro->getAutor() . "',
        '" . $libro->getEditorial() . "','" . $libro->getCantidad() . "','" . $libro->getIdioma() . "', '" . $libro->getUbicacion() . "' , '" . $libro->getNumPag() . "','" . $libro->getEstante() . "','" . $libro->getCategoria() . "',
         '" . $libro->getEstado() . "','" . $libro->getFechaPub() . "','" . date("Y-m-d") . "')";
                if ($link->getSql()->query($sql)) {
                    echo "<div id=\"fade\" class=\"overlay\" onclick=\"document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'\" style=\"display: block;\">
                  </div><div id=\"light\" class=\"modal\" style=\"display: block;\"><a href=\"javascript:void(0)\" onclick=\"document.getElementById('light').style.display='none';document.getElementById('fade').
                  style.display='none'\"><img src='icon\cerrar.png' width='20' height='20' align='right'></a></img><h1 class='text'>Libro agregado correctamente! </h1></div>";
                } else {
                    echo "<div id=\"fade\" class=\"overlay\" onclick=\"document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'\" style=\"display: block;\">
                  </div><div id=\"light\" class=\"modal\" style=\"display: block;\"><a href=\"javascript:void(0)\" onclick=\"document.getElementById('light').style.display='none';document.getElementById('fade').
                  style.display='none'\"><img src='icon\cerrar.png' width='20' height='20' align='right'></a></img><h1 class='text2'>No se ha podido guardar el libro! </h1></div>";
                }
            } else {
                echo "<script type='text/javascript'>alert('No puedes realizar esta accion como invitado, por favor inicia sesion.')</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('No puedes realizar esta accion como invitado, por favor inicia sesion.')</script>";
        }
    }

    public function buscarlibro($op, $buscar)
    {
        $link = new Conexion();
        $sql = "SELECT * FROM libros WHERE " . $op . " LIKE '" . $buscar . "%'";
        $res = $link->getSql()->query($sql);
        $array = array();
        while ($res1 = $res->fetch_assoc()) {
            $sql2 = "SELECT Valor FROM valorparametro WHERE IdValorParametro = " . $res1['IdIdioma'];
            $sql3 = "SELECT Valor FROM valorparametro WHERE IdValorParametro = " . $res1['IdEstado'];
            $sql4 = "SELECT Valor FROM valorparametro WHERE IdValorParametro = " . $res1['IdPais'];
            $sql5 = "SELECT Valor FROM valorparametro WHERE IdValorParametro = " . $res1['IdCategoria'];
            $res2 = $link->getSql()->query($sql2);
            $res3 = $link->getSql()->query($sql3);
            $res4 = $link->getSql()->query($sql4);
            $res5 = $link->getSql()->query($sql5);
            $res2 = $res2->fetch_assoc();
            $res3 = $res3->fetch_assoc();
            $res4 = $res4->fetch_assoc();
            $res5 = $res5->fetch_assoc();
            $libro = new Libro($res1['ISBN'], $res1['Titulo'], $res1['ImgPortada'], $res1['Autor'], $res1['Editorial'], $res1['Cantidad'],
                $res2['Valor'], $res4['Valor'], $res1['NumPaginas'], $res1['Estante'], $res5['Valor'], $res3['Valor'], $res1['FPublicacion']);
            array_push($array, $libro);
        }
        return $array;
    }


    public function modificarLibro(Libro $libro)
    {
        $link = new Conexion();
        if (isset($_COOKIE['IdUser']) && isset($_COOKIE['NickUser'])) {
            if ($_COOKIE['IdUser'] != '' && $_COOKIE['NickUser'] != '') {
                $sql = "UPDATE libros SET Titulo = '" . $libro->getTitulo() . "', ImgPortada = '" . $libro->getImgPortada() . "', Autor = '" . $libro->getAutor() . "',
        Editorial = '" . $libro->getEditorial() . "',  Cantidad = '" . $libro->getCantidad() . "', IdIdioma = '" . $libro->getIdioma() . "', IdPais = '" . $libro->getUbicacion() . "',
        NumPaginas= '" . $libro->getNumPag() . "', Estante = '" . $libro->getEstante() . "', IdCategoria = '" . $libro->getCategoria() . "', IdEstado = '" . $libro->getEstado() . "',
        FPublicacion = '" . $libro->getFechaPub() . "' WHERE ISBN = " . $libro->getISBN();
                if ($link->getSql()->query($sql)) {
                    echo "<script type='text/javascript'>
            alert('Actualizado Correctamente');
            </script>";
                } else {
                    echo "<script type='text/javascript'>
            alert('No se ha podido actualizar'+" . $link->getSql()->error . ");
            </script>";
                }
            } else {
                echo "<script type='text/javascript'>alert('No puedes realizar esta accion como invitado, por favor inicia sesion.')</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('No puedes realizar esta accion como invitado, por favor inicia sesion.')</script>";
        }
    }

    public function ingresarUser($user, $pass)
    {
        $link = new Conexion();
        $sql = "SELECT * FROM usuarios WHERE NickName LIKE '" . $user . "%'";
        $x = $link->getSql()->query($sql);
        $x1 = $x->fetch_assoc();
        if (strcasecmp($x1['NickName'], $user) == 0 && $x1['Contrasena'] == $pass) {
            $usuario = new Usuario($x1['Identificacion'], $x1['NickName'], $x1['Contrasena'], $x1['PNombre'], $x1['SNombre'], $x1['PApellido'], $x1['SApellido'], $x1['Direccion'], $x1['Grado'], $x1['FechaNacimiento'], $x1['Telefono'], $x1['Correo'], $x1['IdTipoUsuario']);
            mt_srand(time());
            $numero_aleatorio = mt_rand(1000000, 999999999);
            $sql1 = "UPDATE usuarios SET Cookie='$numero_aleatorio' where NickName='" . $usuario->getNick() . "'";
            $link->getSql()->query($sql1);
            setcookie("NickUser", $usuario->getNick(), time() + (60 * 60 * 24 * 365));
            setcookie("TipoUser", hash('md5', $usuario->getTipo()), time() + (60 * 60 * 24 * 365));
            setcookie("IdUser", $usuario->getId(), time() + (60 * 60 * 24 * 365));
            setcookie("Marcauser", $numero_aleatorio, time() + (60 * 60 * 24 * 365));
            $_SESSION['Inicio'] = $usuario;
            $bool = true;
        } else {
            $bool = false;
        }
        return $bool;
    }

    function getRealIP()
    {

        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            return $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
            return $_SERVER["HTTP_X_FORWARDED"];
        } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
            return $_SERVER["HTTP_FORWARDED"];
        } else {
            return $_SERVER["REMOTE_ADDR"];
        }

    }

    public function iniciarTipoUser($tipo)
    {
        
        if ($tipo == md5(10)) {

            echo "<div align=\"right\" style=\"display: block\" id=\"div1\">
        <span style=\"top: 10px; position: absolute; right: 0;font-family: 'Source Sans Pro', sans-serif \">Bienvenido: &nbsp; <img src=\"icon/user.png\">
        <a href=\"#\" id=\"loginButton2\"><span>" . $_COOKIE['NickUser'] . "</span></a>
        <div id=\"div2\" align=\"right\">
            <form action=\"logout.php\" method=\"post\" id=\"loginForm\">
                <fieldset id=\"body\">
                    <fieldset>
                       <div style=\"display: block;\" id=div3>
                            <label align=\"left\" style=\"font-size: 14px; font-family: 'Source Sans Pro', sans-serif;\">Panel de Administracion: </label>
                            <hr>
                            <a class=\"boton\" style='float: left;z-index: auto;text-align: center;width: 90%;height: auto; position: static; font-size: 14px;' href=\"index.php\"><img src=\"icon/inicio.png\">&nbsp;Inicio</img></a><br><br>
                            <a class=\"boton\" style='float: left;z-index: auto;text-align: center;width: 90%;height: auto; position: static; font-size: 14px;' href=\"insertarlibro.php\"><img src=\"icon/anadir.png\">&nbsp;Insertar Libro</img></a><br><br>
                            <a class=\"boton\" style='float: left;z-index: auto;text-align: center;width: 90%;height: auto; position: static; font-size: 14px;' href=\"buscarlibro.php\"><img src=\"icon/buscar.png\">&nbsp;Buscar/Modificar Libro</a></img><br><br>
                            <a class=\"boton\" style='float: left;z-index: auto;text-align: center;width: 90%;height: auto; position: static; font-size: 14px;' href=\"eliminarlibro.php\"><img src=\"icon/eliminarlibro.png\">&nbsp;Eliminar Libro</a></img><br><br>
                            <a class=\"boton\" style='float: left;z-index: auto;text-align: center;width: 90%;height: auto; position: static; font-size: 14px;' href=\"infoprestamo.php\"><img src=\"icon/solicitud.png\">&nbsp;Solicitud de Prestamos</a></img><br><br>
                            <a class=\"boton\" style='float: left;z-index: auto;text-align: center;width: 90%;height: auto; position: static; font-size: 14px;' href=\"devolucion.php\"><img src=\"icon/dev.png\">&nbsp;Devolucion de libros</img></a><br><br>
                            <a class=\"boton\" style='float: left;z-index: auto;text-align: center;width: 90%;height: auto; position: static; font-size: 14px;' href=\"registrar.php\"><img src=\"icon/nuevouser.png\">Registrar Estudiantes</a></img><br><br>
                            <a class=\"boton\" style='float: left;z-index: auto;text-align: center;width: 90%;height: auto; position: static; font-size: 14px;' href=\"configurar.php\"><img src=\"icon/config.png\">&nbsp;Configura tu cuenta</img></a><br><br> 
                       </div>
                       <input type=\"text\" hidden name=\"cerrar\" value=\"cerrar\">
                        <hr>
                <button type=\"submit\" class=\"boton\" style='float: left;z-index: auto;text-align: center;width: 90%;height: auto; position: static; font-size: 14px;' id=\"login\"><img src=\"icon/salir.png\">&nbsp;Cerrar Sesion</a></img></button>
                    </fieldset>
                </form></div></div>
                
                 ";

        } elseif ($tipo == md5(9)) {

            echo "<div align=\"right\" style=\"display: block\" id=\"div1\">
        <span id='s1' style=\"top: 10px; position: absolute; right: 0;font-family: 'Source Sans Pro', sans-serif \">Bienvenido: &nbsp; <img src=\"icon/user.png\">
        <a href=\"#\" id=\"loginButton2\"><span>" . $_COOKIE['NickUser'] . "</span></a>
        <div id=\"div2\" align=\"right\">
            <form action=\"logout.php\" method=\"post\" id=\"loginForm\">
                <fieldset id=\"body\">
                    <fieldset>
                       <div style=\"display: block;\" id=div3>
                            <label align=\"left\" style=\"font-size: 14px; font-family: 'Source Sans Pro', sans-serif;\">Panel de Administracion: </label>
                            <hr>
                            <a class=\"boton\" style='float: left;z-index: auto;text-align: center;width: 90%;height: auto; position: static; font-size: 14px;' href=\"index.php\"><img src=\"icon/inicio.png\">&nbsp;Inicio</img></a><br><br>
                            <a class=\"boton\" style='float: left;z-index: auto;text-align: center;width: 90%;height: auto; position: static; font-size: 14px;' href=\"prestamo.php\"><img src=\"icon/anadir.png\">&nbsp;Prestar Libros</img></a><br><br>
                            <a class=\"boton\" style='float: left;z-index: auto;text-align: center;width: 90%;height: auto; position: static; font-size: 14px;' href=\"listaprestamo.php\"><img src=\"icon/lista.png\">&nbsp;Prestamos Realizados</img></a><br><br>
                            <a class=\"boton\" style='float: left;z-index: auto;text-align: center;width: 90%;height: auto; position: static; font-size: 14px;' href=\"configurar.php\"><img src=\"icon/config.png\">&nbsp;Configura tu cuenta</img></a><br><br>                            

                       </div>
                        <hr>
                <button type=\"submit\" class=\"boton\" style='float: left;z-index: auto;text-align: center;width: 90%;height: auto; position: static; font-size: 14px;' id=\"login\"><img src=\"icon/salir.png\">&nbsp;Cerrar Sesion</a></img></button>
                    </fieldset>
            </form></div></div>";
        }
    }

    public function iniciarSesion()
    {
        echo "<script type='text/javascript'>document.getElementById('loginButton').style.display='block'</script>";
        echo "<a href=\"#\" id=\"loginButton\"><span>Iniciar Sesion</span><em></em></a>
            <div id=\"loginBox\" style=\"z-index: 2\">
            <form id=\"loginForm\" method=\"post\" action=\"login.php\">
            <fieldset id=\"body\">
                <fieldset>
                    <label for=\"email\">Correo o Usuario</label>
                    <input type=\"text\" required name=\"user\" class=\"textbox\"/>
                </fieldset>
                <fieldset>
                    <label for=\"password\">Contrase&ntilde;a</label>
                    <input type=\"password\" required name=\"password\" class=\"textbox\"/>
                </fieldset>
                <input type=\"submit\" class=\"boton\" value=\"Iniciar Sesion\" id=\"login\"/>
            </fieldset>
            <span><a href=\"registrar.php\">¿No tienes una cuenta? ¡Registrate ya!</a></span>
        </form>
    </div>";
    }

    public function cerrar()
    {
        setcookie("NickUser");
        setcookie("Marcauser");
        setcookie("IdUser");
        setcookie("TipoUser");
        echo "<script type='text/javascript'> alert('Sesion cerrada correctamente');</script>";
        header("location: index.php");
    }

    public function prestamo($tipo, $buscar, $idLibro)
    {
        $link = new Conexion();
        $libro = $this->buscarlibro($tipo, $buscar);
        if (count($libro) > 0) {
            if (isset($_COOKIE['NickUser']) && isset($_COOKIE['IdUser'])) {
                if ($_COOKIE['NickUser'] != '' && $_COOKIE['IdUser'] != '') {
                    foreach ($libro as $clave => $valor) {
                        if ($valor->getISBN() == $idLibro) {
                            if ($valor->getCantidad() > 0) {
                                $restar = $valor->getCantidad() - 1;
                                $sql = "INSERT INTO prestamos(IdLibroPres,IdUsuario, FPrestamo, Aprobado) VALUES (" . $valor->getISBN() . ", " . $_COOKIE['IdUser'] . ",'" . date('Y-m-d') . "', 'NO')";
                                $sql2 = "UPDATE libros SET Cantidad = " . $restar . " WHERE ISBN = " . $valor->getISBN();
                                $sql3 = "SELECT VecesPrestado FROM usuarios WHERE Identificacion = " . $_COOKIE['IdUser'];
                                if ($link->getSql()->query($sql) === TRUE && $link->getSql()->query($sql2) === TRUE) {
                                    $res = $link->getSql()->query($sql3);

                                    $res1 = $res->fetch_assoc();
                                    $sumaV = $res1['VecesPrestado'] + 1;
                                    $sql4 = "UPDATE usuarios SET VecesPrestado = " . $sumaV . " WHERE Identificacion = " . $_COOKIE['IdUser'];
                                    $link->getSql()->query($sql4);
                                    echo "<script type='text/javascript'>
                        alert('Muy bien, ya has realizado el prestamo.');
                        </script>";
                                } else {
                                    echo "<script type='text/javascript'>
                        alert('No se ha podido realizar el prestamo intentalo nuevamente.' + '".$link->getSql()->error."');
                        
                        </script>";
                                }
                            } else {
                                echo "<script type='text/javascript'>
                         alert('No se ha podido realizar el prestamo intentalo nuevamente.' + '".$link->getSql()->error."');
                        </script>";
                            }
                        }
                    }
                } else {
                    echo "<script type='text/javascript'>
                           alert('No has iniciado sesion');
                           </script>
                           ";
                }
            } else {
                echo "<script type='text/javascript'>
                           alert('No has iniciado sesion');
                           </script>
                           ";
            }
        }
    }

    public function devolverprestamo($idLibro, $idDetalle)
    {
        $link = new Conexion();
        if (isset($_COOKIE['IdUser']) && isset($_COOKIE['NickUser'])) {
            if ($_COOKIE['IdUser'] != '' && $_COOKIE['NickUser'] != '') {
                $libro = $this->buscarlibro('ISBN', $idLibro);
                if (count($libro) > 0) {
                    foreach ($libro as $clave => $valor) {
                        if ($valor->getISBN() == $idLibro) {
                            if ($valor->getCantidad() >= 0) {
                                $sumar = $valor->getCantidad() + 1;
                                $sql2 = "UPDATE libros SET Cantidad = " . $sumar . " WHERE ISBN = " . $valor->getISBN();
                                $sql1 = "UPDATE detalleprestamo SET Devuelto = 'SI' WHERE Id = " . $idDetalle;
                                if ($link->getSql()->query($sql2) && $link->getSql()->query($sql1)) ;
                                echo "<script type='text/javascript'>
                        alert('El libro ha sido devuelto correctamente, debe depositarlo en el estante: ' + '" . $valor->getEstante() . "' + '. Para refrescar los resultados, actualice la pagina.');
                        
                        </script>";
                            } else {
                                echo "<script type='text/javascript'>
                        alert('No se ha podido realizar el prestamo intentalo nuevamente.');
                       
                        </script>";
                            }
                        } else {
                            echo "<script type='text/javascript'>
                        alert('No se ha podido solicitar el prestamo, intentelo más tarde.');
                        </script>";
                        }
                    }
                }
            } else {
                echo "<script type='text/javascript'>alert('No puedes realizar esta accion como invitado, por favor inicia sesion.')</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('No puedes realizar esta accion como invitado, por favor inicia sesion.')</script>";
        }
    }

    public function top5()
    {
        $link = new Conexion();
        $sql = "SELECT CONCAT(PNombre, ' ', PApellido) AS NombreCompleto, VecesPrestado FROM usuarios WHERE VecesPrestado > 0 ORDER BY VecesPrestado DESC LIMIT 5 ";
        $res = $link->getSql()->query($sql);
        echo "<table class=\"table\"><thead>
	        <tr>
		        <th>Nombre y Apellido</th>
		        <th># Prestamos</th>
	        </tr></thead>";
        while ($res2 = $res->fetch_assoc()) {
            echo "   
	        <tr>
		    <td>" . $res2['NombreCompleto'] . "</td>
		    <td>" . $res2['VecesPrestado'] . "</td>
		    </tr>
	    ";
        }
        echo "
		</table>";
    }

    public function librosrecientes()
    {
        $link = new Conexion();
        $sql = "SELECT * FROM libros ORDER BY FAgregado DESC LIMIT 5";
        $res = $link->getSql()->query($sql);
        while ($res2 = $res->fetch_assoc()) {
            $sql2 = "SELECT Valor FROM valorparametro WHERE IdValorParametro = " . $res2['IdIdioma'];
            $sql3 = "SELECT Valor FROM valorparametro WHERE IdValorParametro = " . $res2['IdEstado'];
            $sql4 = "SELECT Valor FROM valorparametro WHERE IdValorParametro = " . $res2['IdPais'];
            $sql5 = "SELECT Valor FROM valorparametro WHERE IdValorParametro = " . $res2['IdCategoria'];
            $res2a = $link->getSql()->query($sql2);
            $res3 = $link->getSql()->query($sql3);
            $res4 = $link->getSql()->query($sql4);
            $res5 = $link->getSql()->query($sql5);
            $res2x = $res2a->fetch_assoc();
            $res3 = $res3->fetch_assoc();
            $res4 = $res4->fetch_assoc();
            $res5 = $res5->fetch_assoc();
            if ($res2['ImgPortada'] == '')
                $x = "descarga.jpg";
            else
                $x = $res2['ImgPortada'];
            echo "
            <div class=\"contenedor\" style=\"width: 66%;position: relative;bottom: 500px;height: 210px;\">
            <img src='imgportada/" . $x . "' height='200' width='150'>
            <form action='prestamo.php' method='post'>
            <div style=\"font-family: Source Sans Pro, sans-serif; position: relative; padding-right: 25%; left: 160px; bottom: 200px; word-wrap: break-word;\">
            <h2 style=\"margin-top: 1px;\"> " . $res2['Titulo'] . "</h2>
            <b>ISBN:</b> " . $res2['ISBN'] . ", <b>Autor: </b>" . $res2['Autor'] . ", <b>Editorial: </b>" . $res2['Editorial'] . ", <b>Cantidad de Ejemplares: </b>" . $res2['Cantidad'] . "
        , <p><b>Numero de Paginas: </b> " . $res2{'NumPaginas'} . ", <b>Estante: </b> " . $res2['Estante'] . ", <b>Idioma: </b> " . $res2x['Valor'] . ", <b>Pais: </b>" . $res4['Valor'] . ", </p><b>Categoria: </b> " . $res5['Valor'] . "
        , <b>Estado del libro: </b> " . $res3['Valor'] . ", <b>Fecha Publicación:</b> " . $res2['FPublicacion'] . "
            
            <input type='hidden' value=" . $res2['ISBN'] . " name='buscar2'>
            <input type='hidden' value='ISBN' name='ids2'>
            <input type=\"hidden\" id=\"form1\" name=\"enviar\">
            <input type='hidden' value=" . $res2['ISBN'] . " name='ISBN2'>
            <input type='submit' style='width: 160px;height: 18px; float: right; position: relative; right: 20px; top: 40px;' class='boton' id='recibir' value='¡Prestar ya!'>
            </form></div>
            </div><br><br>";
        }
    }

    public function top5Libros()
    {
        $link = new Conexion();
        $sql = "SELECT l.Titulo, Count(p.IdLibroPres) AS Total FROM prestamos p JOIN libros l ON l.ISBN=p.IdLibroPres GROUP BY p.IdlibroPres ORDER BY `Total` DESC LIMIT 5";
        $res = $link->getSql()->query($sql);
        echo "<table class=\"table\"><thead>
	        <tr>
		        <th>Titulo del libro</th>
		        <th># Prestamos</th>
	        </tr></thead>";
        while ($res2 = $res->fetch_assoc()) {
            echo "   
	        <tr>
		    <td>" . $res2['Titulo'] . "</td>
		    <td>" . $res2['Total'] . "</td>
		    </tr>
	    ";
        }
        echo "
		</table>";
    }

    public function listadoDevolucion()
    {
        $link = new Conexion();
        if (isset($_COOKIE['IdUser']) && isset($_COOKIE['NickUser'])) {
            if ($_COOKIE['IdUser'] != '' && $_COOKIE['NickUser'] != '') {
                $sql = "SELECT l.ISBN, l.Titulo, d.Id AS IdDetalle, p.FPrestamo, d.Ftope, d.Fdevolucion, d.Devuelto, CONCAT(u.PNombre, ' ', u.PApellido) AS NombreCompleto FROM detalleprestamo d JOIN prestamos p ON p.Id=d.IdPrestamo JOIN usuarios u ON p.IdUsuario = u.Identificacion JOIN libros l ON l.ISBN = p.IdLibroPres  WHERE d.Devuelto = 'NO'";
                $x = $link->getSql()->query($sql);
                if ($link->getSql()->affected_rows == 0) {
                    echo "<h5>No han realizado prestamos o ya todos los libros fueron devueltos.</h5>";
                } else {
                    while ($x1 = $x->fetch_assoc()) {
                        echo "<div class=\"contenedor\">
                              <form action='devolucion.php' method='post'>
                              <span style='font-family: Source Sans Pro, sans-serif'>
                              <b>Nombre Completo del usuario qué solicitó el prestamo: </b>" . $x1['NombreCompleto'] . ", <b> Fecha del prestamo:</b> " . $x1['FPrestamo'] . ", <b>Fecha de Devolucion:</b>  " . $x1['Fdevolucion'] . ", <b>Fecha limite: </b>" . $x1['Ftope'] . ",<p style='margin-top: 3px'><b>Libro a entregar: </b>" . $x1['Titulo'] . ", <b>ISBN del libro: </b>" . $x1['ISBN'] . "</p>
                              <br><br><input type='submit' style='position: absolute; top: 50px; width: 120px;height: 18px;' class='boton' id='recibir' value='Recibir libro'>
                              <input type='hidden' name='IdDetalle' value=" . $x1['IdDetalle'] . ">
                              <input type='hidden' name='ISBND' value=" . $x1['ISBN'] . ">
                              </span>
                              </form>
                              </div><br><br>
                        ";
                    }
                }
            } else {
                echo "<script type='text/javascript'>alert('No puedes ver este listado como invitado, por favor inicia sesion.')</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('No puedes ver este listado como invitado, por favor inicia sesion.')</script>";
        }
    }

    public function listado()
    {
        $link = new Conexion();
        if (isset($_COOKIE['IdUser']) && isset($_COOKIE['NickUser'])) {
            if ($_COOKIE['IdUser'] != '' && $_COOKIE['NickUser'] != '') {
                $sql = "SELECT p.Id, p.FPrestamo, l.Estante, l.ISBN,l.Titulo, CONCAT(u.PNombre,' ',u.PApellido) AS Nombre, Aprobado FROM prestamos p JOIN usuarios u ON p.IdUsuario=u.Identificacion JOIN libros l ON l.ISBN = p.IdLibroPres WHERE p.Aprobado= 'NO'";
                $x = $link->getSql()->query($sql);
                if ($link->getSql()->affected_rows == 0) {
                    echo "<h5>No se han realizados solicitudes por parte de los estudiantes.</h5>";
                } else {
                    while ($x1 = $x->fetch_assoc()) {
                        echo "<div class=\"contenedor\">
            <form action='infoprestamo.php' method='post'>
            <span style='font-family: Source Sans Pro, sans-serif'>
            <b> ISBN del libro solicitado: </b>" . $x1['ISBN'] . ", <b>Titulo del libro: </b>" . $x1['Titulo'] . ", <b>El libro está en el estante: </b>" . $x1['Estante'] . ", <b>Nombre Completo del usuario qué solicitó el libro: </b>" . $x1['Nombre'] . "
            <br><br><hr>
            <b>Fecha del prestamo:</b>  " . $x1['FPrestamo'] . "&nbsp <b>Fecha de Devolucion: </b><input type='date' required style=' width: auto;height: 10px;padding: 10px;border: none;' class='date' name='fdev'> &nbsp <b>Fecha limite: </b><input type='date' required style=' width: auto;height: 10px;padding: 10px;border: none;' name='flimi' class='date'> &nbsp <input type='submit' style='width: 120px;height: 18px;' class='boton' value='Aceptar'>
            <input type='hidden' name='IdPrestamo' value=" . $x1['Id'] . ">
            </span>
            </form>
            </div><br><br>
        ";
                    }
                }
            } else {
                echo "<script type='text/javascript'>alert('No puedes ver este listado como invitado, por favor inicia sesion.')</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('No puedes ver este listado como invitado, por favor inicia sesion.')</script>";
        }
    }

    public function aceptar($idPrestamo, $fdev, $tope)
    {
        $link = new Conexion();
        if (isset($_COOKIE['IdUser']) && isset($_COOKIE['NickUser'])) {
            if ($_COOKIE['IdUser'] != '' && $_COOKIE['NickUser'] != '') {
                $sql = "INSERT INTO detalleprestamo(IdPrestamo, Fdevolucion, Ftope, Devuelto) VALUES ('" . $idPrestamo . "','" . $fdev . "','" . $tope . "', 'NO')";
                $sql2 = "UPDATE prestamos SET Aprobado = 'SI' WHERE Id = " . $idPrestamo;
                if ($link->getSql()->query($sql) === TRUE && $link->getSql()->query($sql2) === TRUE) {
                    echo "<script type='text/javascript'>
                     alert('Prestamo aceptado correctamente');
                  </script>";
                } else {
                    echo "<script type='text/javascript'>
                     alert('No se ha podido realizar la aprobacion.' + '" . $link->getSql()->error . "');
                  </script>";
                }
            } else {
                echo "<script type='text/javascript'>alert('No puedes realizar esta accion como invitado, por favor inicia sesion.')</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('No puedes realizar esta accion como invitado, por favor inicia sesion.')</script>";
        }
    }

    public function registrar(Usuario $user)
    {
        $link = new Conexion();
        $sql3 = "SELECT NickName as Nick FROM usuarios WHERE NickName LIKE '" . $user->getNick() . "%'";
        $res = $link->getSql()->query($sql3);
        $res1 = $res->fetch_assoc();
        if ($res1['Nick'] == $user->getNick()) {
            echo "<script>alert('Este nombre de usuario ya se encuentra en la base de datos, por favor especifique otro.')</script>";
        } else {
            $sql = "INSERT INTO usuarios(Identificacion, NickName, Contrasena, PNombre, SNombre, PApellido, SApellido, Direccion, Grado, FechaNacimiento, Telefono, Correo, IdPrestamo, IdEstadoEst, IdTipoUsuario, Cookie, VecesPrestado) VALUES ('" . $user->getId() . "','" . $user->getNick() . "',
                '" . $user->getPass() . "','" . $user->getPnombre() . "','" . $user->getSnombre() . "','" . $user->getPapellido() . "','" . $user->getSapellido() . "','" . $user->getDireccion() . "','" . $user->getGrado() . "','" . $user->getFecha() . "','" . $user->getTelefono() . "','" . $user->getCorreo() . "','0','0','" . $user->getTipo() . "','0','0')";
            if ($link->getSql()->query($sql) === TRUE) {
                echo "<script type='text/javascript'>alert('Muy bien ya te has registrado correctamente, ya puedes ingresar a Colbooks.')</script>";
            } else {
                echo "<script type='text/javascript'>alert('Se ha producido un error en el registro, compruebe los datos.')</script>";
            }
        }
    }

    public function eliminarLibro($tipo, $buscar, $idLibro)
    {
        $link = new Conexion();
        $libro = $this->buscarlibro($tipo, $buscar);
        if (isset($_COOKIE['IdUser']) && isset($_COOKIE['NickUser'])) {
            if ($_COOKIE['IdUser'] != '' && $_COOKIE['NickUser'] != '') {
                if (count($libro) > 0) {
                    foreach ($libro as $clave => $valor) {
                        if ($valor->getISBN() == $idLibro) {
                            $sql4 = "SELECT p.Id, p.Aprobado, d.Devuelto FROM prestamos p JOIN detalleprestamo d ON d.IdPrestamo=p.Id";
                            $res = $link->getSql()->query($sql4);
                            $res1 = $res->fetch_assoc();
                            if ($res1['Aprobado'] == 'NO' || $res1['Devuelto'] == 'SI' || $res1['Devuelto'] == '' || $res1['Aprobado'] == '') {
                                $sql3 = "DELETE FROM detalleprestamo WHERE IdPrestamo = " . $res1['Id'];
                                $sql2 = "DELETE FROM prestamos WHERE IdLibroPres = " . $idLibro;
                                $sql = "DELETE FROM libros WHERE ISBN = " . $idLibro;
                                $link->getSql()->query($sql3);
                                $link->getSql()->query($sql2);
                                if ($link->getSql()->query($sql) === TRUE) {
                                    echo "<script type='text/javascript'>alert('Libro Eliminado con exito.')</script>";
                                } else {
                                    echo "<script type='text/javascript'>alert('No se ha podido eliminar el libro, comprueba tu conexion.')</script>";
                                }
                            } else {
                                echo "<script type='text/javascript'>alert('No se ha podido eliminar el libro, el libro aun no ha sido devuelto.')</script>";
                            }
                        }
                    }
                }
            } else {
                echo "<script type='text/javascript'>alert('No puedes realizar esta accion como invitado, por favor inicia sesion.')</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('No puedes realizar esta accion como invitado, por favor inicia sesion.')</script>";
        }
    }

    public function prestamosRealizados()
    {
        $link = new Conexion();
        if (isset($_COOKIE['IdUser']) && isset($_COOKIE['NickUser'])) {
            if ($_COOKIE['IdUser'] != '' && $_COOKIE['NickUser'] != '') {
                $sql = "SELECT u.NickName, l.ISBN, l.Titulo, p.FPrestamo, p.Aprobado FROM prestamos p INNER JOIN usuarios u ON p.IdUsuario=u.Identificacion JOIN libros l ON l.ISBN=p.IdLibroPres WHERE u.Identificacion = " . $_COOKIE['IdUser'];
                $sql2 = "SELECT d.Fdevolucion, d.Ftope,d.Devuelto FROM prestamos p INNER JOIN detalleprestamo d ON p.Id=d.IdPrestamo WHERE p.IdUsuario = " . $_COOKIE['IdUser'];
                $res = $link->getSql()->query($sql);
                while ($res1 = $res->fetch_assoc()) {
                    $res2 = $link->getSql()->query($sql2);
                    $res2a = $res2->fetch_assoc();
                    if ($res1['Aprobado'] == 'NO') {
                        echo "<div class=\"contenedor\" style='padding-right: 15px; width: 97%; height: 55px'>
                <span style='font-family: Source Sans Pro, sans-serif'>
                <b>ISBN del libro solicitado: </b>" . $res1['ISBN'] . ", <b>Titulo del libro: </b>" . $res1['Titulo'] . ", <b>Fecha de prestamo: </b>" . $res1['FPrestamo'] . "<b>&nbsp ¿Tu prestamo fue aprobado?: </b>" . $res1['Aprobado'] . " &nbsp <b>¿Has devuelto el libro?: </b>" . $res2a['Devuelto'] . ", <p><b>Fecha en la que debes devolverlo: </b>Aun no tienes fecha definida, <b>Fecha limite: </b> Aun no tienes fecha definida</p> </span>               
                </div><br><br>
                ";
                    } else {
                        echo "<div class=\"contenedor\" style='padding-right: 15px; width: 97%; height: 55px'>
                <span style='font-family: Source Sans Pro, sans-serif'>
                <b> ISBN del libro solicitado: </b>" . $res1['ISBN'] . ", <b>Titulo del libro: </b>" . $res1['Titulo'] . ", <b>Fecha de prestamo: </b>" . $res1['FPrestamo'] . "<b> &nbsp ¿Tu prestamo fue aceptado?: </b>" . $res1['Aprobado'] . " &nbsp <b>¿Has devuelto el libro?: </b>" . $res2a['Devuelto'] . ", <b>Fecha en la que debes devolverlo: </b>" . $res2a['Fdevolucion'] . "
                , <b>Fecha limite: </b>" . $res2a['Ftope'] . "
                </span>               
                </div><br><br>
                ";
                    }
                }
            } else {
                echo "<script type='text/javascript'>alert('No puedes ver este listado como invitado, por favor inicia sesion.')</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('No puedes ver este listado como invitado, por favor inicia sesion.')</script>";
        }
    }

    public function modificarDatos(Usuario $user)
    {
        $link = new Conexion();
        if (isset($_COOKIE['IdUser']) && isset($_COOKIE['NickUser'])) {
            if ($_COOKIE['IdUser'] != '' && $_COOKIE['NickUser'] != '') {
                $sql3 = "SELECT NickName as Nick FROM usuarios WHERE NickName LIKE '" . $user->getNick() . "%'";
                $res = $link->getSql()->query($sql3);
                $res1 = $res->fetch_assoc();
                if ($res1['Nick'] == $user->getNick()) {
                    echo "<script>alert('Este nombre de usuario ya se encuentra en la base de datos, por favor especifique otro.')</script>";
                } else {
                    if ($user->getPass() == '' || is_null($user->getPass())) {
                        $sql = "UPDATE usuarios SET NickName = '" . $user->getNick() . "', PNombre = '" . $user->getPnombre() . "', SNombre = '" . $user->getSnombre() . "', PApellido = '" . $user->getPapellido() . "',
                SApellido = '" . $user->getSapellido() . "', Direccion = '" . $user->getDireccion() . "', Grado = '" . $user->getGrado() . "', Telefono = '" . $user->getTelefono() . "', Correo = '" . $user->getCorreo() . "',
                FechaNacimiento = '" . $user->getFecha() . "' WHERE Identificacion = '" . $_COOKIE['IdUser'] . "'";
                        if ($link->getSql()->query($sql) === TRUE) {
                            echo "<script>alert('Datos modificados correctamente'); </script>";
                        } else {
                            echo "<script>alert('No se ha podido modificar los datos, comprueba los valores que ingresaste.'); </script>";
                        }
                    } else {
                        $sql1 = "UPDATE usuarios SET NickName = '" . $user->getNick() . "', PNombre = '" . $user->getPnombre() . "', SNombre = '" . $user->getSnombre() . "', PApellido = '" . $user->getPapellido() . "',
                SApellido = '" . $user->getSapellido() . "', Direccion = '" . $user->getDireccion() . "', Grado = '" . $user->getGrado() . "', Telefono = '" . $user->getTelefono() . "', Correo = '" . $user->getCorreo() . "',
                FechaNacimiento = '" . $user->getFecha() . "', Contrasena = '" . $user->getPass() . "' WHERE Identificacion = '" . $_COOKIE['IdUser'] . "'";
                        if ($link->getSql()->query($sql1) === TRUE) {
                            echo "<script>alert('Datos modificados correctamente'); </script>";
                        } else {
                            echo "<script>alert('No se ha podido modificar los datos, comprueba los valores que ingresaste.'); </script>";
                        }
                    }
                }
            } else {
                echo "<script type='text/javascript'>alert('No puedes realizar esta accion como invitado, por favor inicia sesion.')</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('No puedes realizar esta accion como invitado, por favor inicia sesion.')</script>";
        }
    }
}

