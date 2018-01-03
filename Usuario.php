<?php

class Usuario
{
    private $id;
    private $nick;
    private $pnombre;
    private $snombre;
    private $papellido;
    private $sapellido;
    private $direccion;
    private $grado;
    private $telefono;
    private $correo;
    private $pass;
    private $tipo;
    private $fecha;

    public function __construct($id = null, $nick=null,  $pass=null,$pnombre=null, $snombre=null, $papellido=null, $sapellido=null, $direccion=null, $grado = null, $fecha = null, $telefono=null, $correo=null, $tipo=null)
    {
        $this->id = $id;
        $this->nick = $nick;
        $this->pass = $pass;
        $this->pnombre = $pnombre;
        $this->snombre = $snombre;
        $this->papellido = $papellido;
        $this->sapellido = $sapellido;
        $this->direccion = $direccion;
        $this->grado = $grado;
        $this->fecha = $fecha;
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->tipo= $tipo;
    }

    /**
     * @return null
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param null $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return null
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @return null
     */
    public function getGrado()
    {
        return $this->grado;
    }

    /**
     * @param null $grado
     */
    public function setGrado($grado)
    {
        $this->grado = $grado;
    }


    public function getNick()
    {
        return $this->nick;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPass()
    {
        return $this->pass;
    }


    public function setPass($pass)
    {
        $this->pass = $pass;
    }


    public function setNick($nick)
    {
        $this->nick = $nick;
    }


    public function getPnombre()
    {
        return $this->pnombre;
    }


    public function setPnombre($pnombre)
    {
        $this->pnombre = $pnombre;
    }


    public function getSnombre()
    {
        return $this->snombre;
    }


    public function setSnombre($snombre)
    {
        $this->snombre = $snombre;
    }


    public function getPapellido()
    {
        return $this->papellido;
    }


    public function setPapellido($papellido)
    {
        $this->papellido = $papellido;
    }


    public function getSapellido()
    {
        return $this->sapellido;
    }


    public function setSapellido($sapellido)
    {
        $this->sapellido = $sapellido;
    }


    public function getDireccion()
    {
        return $this->direccion;
    }


    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }


    public function getTelefono()
    {
        return $this->telefono;
    }


    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }


    public function getCorreo()
    {
        return $this->correo;
    }


    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }


}