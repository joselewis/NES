<?php

require_once("../../utlis/utils.php");
require_once("../../utlis/config.php");
require_once("../../utlis/connections/uia_agenda.php");
require_once("../domain/locales.php");



//this attribute enable to see the SQL's executed in the data base
//$labAdodb->debug=true;

class LocalesDao {

    public function __construct() {
        
    }

    //***********************************************************
    //agrega a una persona a la base de datos
    //***********************************************************

    public function add(Locales $Local) {

        global $labAdodb;
        try {
            $sql = sprintf("insert into Local (idCodigo_Cliente, Cedula_Juridica, Persona_idPersona, Latitud, Longitud, Nombre_Local) 
                                          values (%s,%s,%s,%s,%s,%s)",
                    $labAdodb->Param("idCodigo_Cliente"),
                    $labAdodb->Param("Cedula_Juridica"),
                    $labAdodb->Param("Persona_idPersona"),
                    $labAdodb->Param("Latitud"),
                    $labAdodb->Param("Longitud"),
                    $labAdodb->Param("Nombre_Local"));
            $sqlParam = $labAdodb->Prepare($sql);

            $valores = array();

            $valores["idCodigo_Cliente"]                        = $Local->getidCodigo_Cliente();
            $valores["Cedula_Juridica"]        = $Local->getCedula_Juridica();
            $valores["Persona_idPersona"]     = $Local->getPersona_idPersona();
            $valores["Latitud"]                         = $Local->getLatitud();
            $valores["Longitud"]                      = $Local->getLongitud();
            $valores["Nombre_Local"]                      = $Local->getNombre_Local();

            $labAdodb->Execute($sqlParam, $valores) or die($labAdodb->ErrorMsg());
        } catch (Exception $e) {
            throw new Exception('No se pudo insertar el registro (Error generado en el metodo add de la clase LocalesDao), error:'.$e->getMessage());
        }
    }

    //***********************************************************
    //verifica si una persona existe en la base de datos por ID
    //***********************************************************

    public function exist(Locales $Local) {

        global $labAdodb;
        $exist = false;
        try {
            $sql = sprintf("select * from Local where  idCodigo_Cliente = %s ",
                            $labAdodb->Param("idCodigo_Cliente"));
            $sqlParam = $labAdodb->Prepare($sql);

            $valores = array();
            $valores["idCodigo_Cliente"] = $Local->getidCodigo_Cliente();

            $resultSql = $labAdodb->Execute($sqlParam, $valores) or die($labAdodb->ErrorMsg());
            if ($resultSql->RecordCount() > 0) {
                $exist = true;
            }
            return $exist;
        } catch (Exception $e) {
            throw new Exception('No se pudo obtener el registro (Error generado en el metodo exist de la clase LocalesDao), error:'.$e->getMessage());
        }
    }

    //***********************************************************
    //modifica una persona en la base de datos
    //***********************************************************

    public function update(Locales $Local) {

        global $labAdodb;
        try {
            $sql = sprintf("update Local set Cedula_Juridica = %s, 
                                                Persona_idPersona = %s, 
                                                Latitud = %s, 
                                                Longitud = %s, 
                                                Nombre_Local = %s,
                            where idCodigo_Cliente = %s",
                    $labAdodb->Param("Cedula_Juridica"),
                    $labAdodb->Param("Persona_idPersona"),
                    $labAdodb->Param("Latitud"),
                    $labAdodb->Param("Longitud"),
                    $labAdodb->Param("Nombre_Local"),
                    $labAdodb->Param("idCodigo_Cliente"));
            $sqlParam = $labAdodb->Prepare($sql);

            $valores = array();

            $valores["Cedula_Juridica"]       = $Local->getCedula_Juridica();
            $valores["Persona_idPersona"]       = $Local->getPersona_idPersona();
            $valores["Latitud"]   = $Local->getLatitud();
            $valores["Longitud"]            = $Local->getLongitud();
            $valores["Nombre_Local"]            = $Local->getNombre_Local();
            $valores["idCodigo_Cliente"]       = $Local->getidCodigo_Cliente();
            $labAdodb->Execute($sqlParam, $valores) or die($labAdodb->ErrorMsg());
        } catch (Exception $e) {
            throw new Exception('No se pudo actualizar el registro (Error generado en el metodo update de la clase LocalesDao), error:'.$e->getMessage());
        }
    }

    //***********************************************************
    //elimina un local en la base de datos
    //***********************************************************

    public function delete(Locales $Local) {

        global $labAdodb;
        try {
            $sql = sprintf("delete from Local where  idLocal = %s",
                            $labAdodb->Param("idLocal"));
            $sqlParam = $labAdodb->Prepare($sql);

            $valores = array();

            $valores["idLocal"] = $Local->getidLocal();

            $labAdodb->Execute($sqlParam, $valores) or die($labAdodb->ErrorMsg());
        } catch (Exception $e) {
            throw new Exception('No se pudo eliminar el registro (Error generado en el metodo delete de la clase LocalesDao), error:'.$e->getMessage());
        }
    }

    //***********************************************************
    //busca a una persona en la base de datos
    //***********************************************************

    public function searchById(Locales $Local) {

        global $labAdodb;
        $returnLocal = null;
        try {
            $sql = sprintf("select * from Local where  idLocal = %s",
                            $labAdodb->Param("idLocal"));
            $sqlParam = $labAdodb->Prepare($sql);

            $valores = array();

            $valores["idLocal"] = $Local->getidLocal();

            $resultSql = $labAdodb->Execute($sqlParam, $valores) or die($labAdodb->ErrorMsg());
            
            if ($resultSql->RecordCount() > 0) {
                $returnLocal = Locales::createNullLocales();
                $returnLocal->setidLocal($resultSql->Fields("idCodigo_Cliente"));
                $returnLocal->setCedula_Juridica($resultSql->Fields("Cedula_Juridica"));
                $returnLocal->setPersonas_idPersonas($resultSql->Fields("Persona_idPersona"));
                $returnLocal->setLatitud($resultSql->Fields("Latitud"));
                $returnLocal->setLongitud($resultSql->Fields("Longitud"));
                $returnLocal->setLongitud($resultSql->Fields("Nombre_Local"));
            }
        } catch (Exception $e) {
            throw new Exception('No se pudo consultar el registro (Error generado en el metodo searchById de la clase LocalesDao), error:'.$e->getMessage());
        }
        return $returnLocal;
    }

    //***********************************************************
    //obtiene la información de las personas en la base de datos
    //***********************************************************
    
    public function getAll() {

        global $labAdodb;
        try {
            $sql = sprintf("select * from Local");
            $resultSql = $labAdodb->Execute($sql);
            return $resultSql;
        } catch (Exception $e) {
            throw new Exception('No se pudo obtener los registros (Error generado en el metodo getAll de la clase LocalesDao), error:'.$e->getMessage());
        }
    }

}
