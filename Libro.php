<?php
    class Libro
    {
        private $ISBN;
        private $titulo;
        private $imgPortada;
        private $Autor;
        private $FechaPub;
        private $Editorial;
        private $Cantidad;
        private $Idioma;
        private $Ubicacion;
        private $NumPag;
        private $Categoria;
        private $Estado;
        private $Estante;
        private $FAgregado;

        public function __construct($ISBN=null, $titulo=null, $imgportada=null, $Autor=null, $Editorial=null, $Cantidad=null,
                                    $Idioma=null, $Ubicacion=null, $NumPag=null, $Estante = null,$Categoria=null, $Estado=null, $FechaPub=null, $FAgregado = null)
        {
            $this->ISBN = $ISBN;
            $this->titulo = $titulo;
            $this->imgPortada = $imgportada;
            $this->Autor = $Autor;
            $this->FechaPub = $FechaPub;
            $this->Editorial = $Editorial;
            $this->Cantidad = $Cantidad;
            $this->Idioma = $Idioma;
            $this->Ubicacion = $Ubicacion;
            $this->NumPag = $NumPag;
            $this->Categoria = $Categoria;
            $this->Estado = $Estado;
            $this->Estante = $Estante;
            $this->FAgregado = $FAgregado;
        }


        public function getEstante()
        {
            return $this->Estante;
        }


        public function setEstante($estante)
        {
            $this->Estante = $estante;
        }


        public function getISBN()
        {
            return $this->ISBN;
        }


        public function setISBN($ISBN)
        {
            $this->ISBN = $ISBN;
        }


        public function getTitulo()
        {
            return $this->titulo;
        }


        public function setTitulo($titulo)
        {
            $this->titulo = $titulo;
        }


        public function getImgPortada()
        {
            return $this->imgPortada;
        }


        public function setImgPortada($imgPortada)
        {
            $this->imgPortada = $imgPortada;
        }


        public function getAutor()
        {
            return $this->Autor;
        }


        public function setAutor($Autor)
        {
            $this->Autor = $Autor;
        }


        public function getFechaPub()
        {
            return $this->FechaPub;
        }


        public function setFechaPub($FechaPub)
        {
            $this->FechaPub = $FechaPub;
        }


        public function getEditorial()
        {
            return $this->Editorial;
        }


        public function setEditorial($Editorial)
        {
            $this->Editorial = $Editorial;
        }


        public function getCantidad()
        {
            return $this->Cantidad;
        }


        public function setCantidad($Cantidad)
        {
            $this->Cantidad = $Cantidad;
        }


        public function getIdioma()
        {
            return $this->Idioma;
        }


        public function setIdioma($Idioma)
        {
            $this->Idioma = $Idioma;
        }


        public function getUbicacion()
        {
            return $this->Ubicacion;
        }


        public function setUbicacion($Ubicacion)
        {
            $this->Ubicacion = $Ubicacion;
        }


        public function getNumPag()
        {
            return $this->NumPag;
        }


        public function setNumPag($NumPag)
        {
            $this->NumPag = $NumPag;
        }


        public function getCategoria()
        {
            return $this->Categoria;
        }


        public function setCategoria($Categoria)
        {
            $this->Categoria = $Categoria;
        }


        public function getEstado()
        {
            return $this->Estado;
        }


        public function setEstado($Estado)
        {
            $this->Estado = $Estado;
        }

    }
