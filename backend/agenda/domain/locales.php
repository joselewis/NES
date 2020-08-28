<?php

require_once("baseDomain.php");


class Locales extends BaseDomain implements \JsonSerializable{

    //attributes
    private $idCodigo_Cliente;
    private $Cedula_Juridica;
    private $Persona_idPersona;
    private $Latitud;
    private $Longitud;
    private $Nombre_Local;

    //constructors
    public function __construct() {
        parent::__construct();
    }

    public static function createNullLocales() {
        $instance = new self();
        return $instance;
    }

    public static function createLocales($idCodigo_Cliente, $Cedula_Juridica, $Persona_idPersona, $Latitud, $Longitud, $Nombre_Local) {
        $instance = new self();
        $instance->idCodigo_Cliente            = $idCodigo_Cliente;
        $instance->Cedula_Juridica             = $Cedula_Juridica;
        $instance->Personas_idPersonas       = $Persona_idPersona;
        $instance->Latitud                              = $Latitud;
        $instance->Longitud                           = $Longitud;
        $instance->Nombre_Local              = $Nombre_Local;
        return $instance;
    }

    /****************************************************************************/
    //properties
    /****************************************************************************/
   
    function getIdCodigo_Cliente() {
        return $this->idCodigo_Cliente;
    }

    function setIdCodigo_Cliente($idCodigo_Cliente) {
        $this->idCodigo_Cliente = $idCodigo_Cliente;
    }

        
    /****************************************************************************/

    function getCedula_Juridica() {
        return $this->Cedula_Juridica;
    }

    function setCedula_Juridica($Cedula_Juridica) {
        $this->Cedula_Juridica = $Cedula_Juridica;
    }

    

    /****************************************************************************/

    function getPersona_idPersona() {
        return $this->Personas_idPersonas;
    }

    function setPersonas_idPersonas($Personas_idPersonas) {
        $this->Personas_idPersonas = $Personas_idPersonas;
    }

    
    /****************************************************************************/

    function getLatitud() {
        return $this->Latitud;
    }

    function setLatitud($Latitud) {
        $this->Latitud = $Latitud;
    }

    
    
    /****************************************************************************/
    
    function getLongitud() {
        return $this->Longitud;
    }

    function setLongitud($Longitud) {
        $this->Longitud = $Longitud;
    }
    
    
     /****************************************************************************/ 
    
     function getNombre_Local() {
         return $this->Nombre_Local;
     }

     function setNombre_Local($Nombre_Local) {
         $this->Nombre_Local = $Nombre_Local;
     }

     
                 
    /****************************************************************************/
    //Convertir el obj a JSON
    /****************************************************************************/
    

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}