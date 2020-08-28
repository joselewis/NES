<?php

require_once("baseDomain.php");


class Personas extends BaseDomain implements \JsonSerializable{

    //attributes
    private $idPersona;
    private $Nombre;
    private $Apellido1;
    private $Apellido2;
    private $Telefono;
    private $Correo;
    private $TelefonoFijo;

    //constructors
    public function __construct() {
        parent::__construct();
    }

    public static function createNullPersonas() {
        $instance = new self();
        return $instance;
    }

    public static function createPersonas($idPersona, $Nombre, $Apellido1, $Apellido2, $Telefono, $Correo, $TelefonoFijo) {
        $instance = new self();
        $instance->idPersona        = $idPersona;
        $instance->Nombre           = $Nombre;
        $instance->Apellido1        = $Apellido1;
        $instance->Apellido2        = $Apellido2;
        $instance->Telefono         = $Telefono;
        $instance->Correo             = $Correo;
        $instance->TelefonoFijo = $TelefonoFijo;
        return $instance;
    }

    /****************************************************************************/
    //properties
    /****************************************************************************/
    public function getidPersona() {
        return $this->idPersona;
    }

    public function setidPersona($idPersona) {
        $this->idPersona = $idPersona;
    }

    /****************************************************************************/

    public function getNombre() {
        return $this->Nombre;
    }

    public function setNombre($Nombre) {
        $this->Nombre = $Nombre;
    }

    /****************************************************************************/

    public function getApellido1() {
        return $this->Apellido1;
    }

    public function setApellido1($Apellido1) {
        $this->Apellido1 = $Apellido1;
    }

    /****************************************************************************/

    public function getApellido2() {
        return $this->Apellido2;
    }

    public function setApellido2($Apellido2) {
        $this->Apellido2 = $Apellido2;
    }

    /****************************************************************************/

    function getTelefono() {
        return $this->Telefono;
    }

    function setTelefono($Telefono) {
        $this->Telefono = $Telefono;
    }

    
    /****************************************************************************/

    function getCorreo() {
        return $this->Correo;
    }

    function setCorreo($Correo) {
        $this->Correo = $Correo;
    }
    
    /****************************************************************************/

    function getTelefonoFijo() {
        return $this->TelefonoFijo;
    }

    function setTelefonoFijo($TelefonoFijo) {
        $this->TelefonoFijo = $TelefonoFijo;
    }

        
    /****************************************************************************/
    //Convertir el obj a JSON
    /****************************************************************************/
    

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}