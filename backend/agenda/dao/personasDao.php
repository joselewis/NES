<?php

require_once("../../utlis/utils.php");
require_once("../../utlis/config.php");
require_once("../../utlis/connections/uia_agenda.php");
require_once("../domain/personas.php");



//this attribute enable to see the SQL's executed in the data base
//$labAdodb->debug=true;

class PersonasDao {

    public function __construct() {
        
    }

    //***********************************************************
    //agrega a una persona a la base de datos
    //***********************************************************

    public function add(Personas $personas) {

        global $labAdodb;
        try {
            $sql = sprintf("insert into Persona (idPersona, Nombre, Apellido1, Apellido2, Telefono, Correo, Telefono_Fijo) 
                                          values (%s,%s,%s,%s,%s,%s,%s)",
                    $labAdodb->Param("idPersona"),
                    $labAdodb->Param("Nombre"),
                    $labAdodb->Param("Apellido1"),
                    $labAdodb->Param("Apellido2"),
                    $labAdodb->Param("Telefono"),
                    $labAdodb->Param("Correo"),
                    $labAdodb->Param("TelefonoFijo"));
            $sqlParam = $labAdodb->Prepare($sql);

            $valores = array();

            $valores["idPersona"]       = $personas->getidPersona();
            $valores["Nombre"]          = $personas->getNombre();
            $valores["Apellido1"]       = $personas->getApellido1();
            $valores["Apellido2"]       = $personas->getApellido2();
            $valores["Telefono"]   = $personas->getTelefono();
            $valores["Correo"]            = $personas->getCorreo();
            $valores["TelefonoFijo"]            = $personas->getTelefonoFijo();

            $labAdodb->Execute($sqlParam, $valores) or die($labAdodb->ErrorMsg());
        } catch (Exception $e) {
            throw new Exception('No se pudo insertar el registro (Error generado en el metodo add de la clase PersonasDao), error:'.$e->getMessage());
        }
    }

    //***********************************************************
    //verifica si una persona existe en la base de datos por ID
    //***********************************************************

    public function exist(Personas $personas) {

        global $labAdodb;
        $exist = false;
        try {
            $sql = sprintf("select * from Persona where  idPersona = %s ",
                            $labAdodb->Param("idPersona"));
            $sqlParam = $labAdodb->Prepare($sql);

            $valores = array();
            $valores["idPersona"] = $personas->getidPersona();

            $resultSql = $labAdodb->Execute($sqlParam, $valores) or die($labAdodb->ErrorMsg());
            if ($resultSql->RecordCount() > 0) {
                $exist = true;
            }
            return $exist;
        } catch (Exception $e) {
            throw new Exception('No se pudo obtener el registro (Error generado en el metodo exist de la clase PersonasDao), error:'.$e->getMessage());
        }
    }

    //***********************************************************
    //modifica una persona en la base de datos
    //***********************************************************

    public function update(Personas $personas) {

        global $labAdodb;
        try {
            $sql = sprintf("update Personas set Nombre = %s, 
                                                Apellido1 = %s, 
                                                Apellido2 = %s, 
                                                Telefono = %s, 
                                                Correo = %s,
                                                TelefonoFijo = %s,
                            where idPersona = %s",
                    $labAdodb->Param("Nombre"),
                    $labAdodb->Param("Apellido1"),
                    $labAdodb->Param("Apellido2"),
                    $labAdodb->Param("Telefono"),
                    $labAdodb->Param("Correo"),
                    $labAdodb->Param("TelefonoFijo"),
                    $labAdodb->Param("idPersona"));
            $sqlParam = $labAdodb->Prepare($sql);

            $valores = array();

            $valores["Nombre"]          = $personas->getNombre();
            $valores["Apellido1"]       = $personas->getApellido1();
            $valores["Apellido2"]       = $personas->getApellido2();
            $valores["Telefono"]   = $personas->geTelefono();
            $valores["Correo"]            = $personas->getCorreo();
             $valores["TelefonoFijo"]            = $personas->getTelefonoFijo();
            $valores["idPersona"]       = $personas->getidPersona();
            $labAdodb->Execute($sqlParam, $valores) or die($labAdodb->ErrorMsg());
        } catch (Exception $e) {
            throw new Exception('No se pudo actualizar el registro (Error generado en el metodo update de la clase PersonasDao), error:'.$e->getMessage());
        }
    }

    //***********************************************************
    //elimina una persona en la base de datos
    //***********************************************************

    public function delete(Personas $personas) {

        global $labAdodb;
        try {
            $sql = sprintf("delete from Persona where  idPersona = %s",
                            $labAdodb->Param("idPersona"));
            $sqlParam = $labAdodb->Prepare($sql);

            $valores = array();

            $valores["idPersona"] = $personas->getidPersona();

            $labAdodb->Execute($sqlParam, $valores) or die($labAdodb->ErrorMsg());
        } catch (Exception $e) {
            throw new Exception('No se pudo eliminar el registro (Error generado en el metodo delete de la clase PersonasDao), error:'.$e->getMessage());
        }
    }

    //***********************************************************
    //busca a una persona en la base de datos
    //***********************************************************

    public function searchById(Personas $personas) {

        global $labAdodb;
        $returnPersonas = null;
        try {
            $sql = sprintf("select * from Persona where  idPersona = %s",
                            $labAdodb->Param("idPersona"));
            $sqlParam = $labAdodb->Prepare($sql);

            $valores = array();

            $valores["idPersona"] = $personas->getidPersona();

            $resultSql = $labAdodb->Execute($sqlParam, $valores) or die($labAdodb->ErrorMsg());
            
            if ($resultSql->RecordCount() > 0) {
                $returnPersonas = Personas::createNullPersonas();
                $returnPersonas->setidPersona($resultSql->Fields("idPersona"));
                $returnPersonas->setNombre($resultSql->Fields("Nombre"));
                $returnPersonas->setApellido1($resultSql->Fields("Apellido1"));
                $returnPersonas->setApellido2($resultSql->Fields("Apellido2"));
                $returnPersonas->setTelefono($resultSql->Fields("Telefono"));
                $returnPersonas->setCorreo($resultSql->Fields("Correo"));
                $returnPersonas->setTelefonoFijo($resultSql->Fields("TelefonoFijo"));
            }
        } catch (Exception $e) {
            throw new Exception('No se pudo consultar el registro (Error generado en el metodo searchById de la clase PersonasDao), error:'.$e->getMessage());
        }
        return $returnPersonas;
    }

    //***********************************************************
    //obtiene la información de las personas en la base de datos
    //***********************************************************
    
    public function getAll() {

        global $labAdodb;
        try {
            $sql = sprintf("select * from Persona");
            $resultSql = $labAdodb->Execute($sql);
            return $resultSql;
        } catch (Exception $e) {
            throw new Exception('No se pudo obtener los registros (Error generado en el metodo getAll de la clase PersonasDao), error:'.$e->getMessage());
        }
    }

}
