<?php

class Conexion
{
    private $sql;
    public function __construct()
    {
        $host = 'localhost';
        $user = 'id1076662_root';
        $pass = '12345';
        $bd = 'id1076662_colbooks';
        $this->sql = new mysqli($host ,$user,$pass,$bd);
        $this->sql->query("SET NAMES 'utf8'");
        if ($this->sql->connect_errno){
            echo "<script type='text/javascript'>alert('No se ha podido realizar la conexión a la Base de Datos.');
                  </script>";
        }
    }

    /**
     * @return mysqli
     */
    public function getSql()
    {
        return $this->sql;
    }

}