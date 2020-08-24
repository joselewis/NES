<?php

require_once("../bo/personasBo.php");
require_once("../domain/personas.php");
require_once("../bo/UsuarioBo.php");
require_once("../domain/Usuario.php");


//************************************************************
// Personas Controller 
//************************************************************

if (filter_input(INPUT_POST, 'quequiereHacerelsuaurio') != null) {
    $action = filter_input(INPUT_POST, 'quequiereHacerelsuaurio');

    try {
        $myPersonasBo = new PersonasBo();
        $myPersonas = Personas::createNullPersonas();
        $myUsuariosBo = new UsuarioBo();
        $myUsuarios= Usuario::createNullUsuario();

        //***********************************************************
        //choose the action
        //***********************************************************

        if ($action === "registrarse" or $action === "update_Usuario") {
            //se valida que los parametros hayan sido enviados por post
            if ((filter_input(INPUT_POST, 'idPersona') != null) && (filter_input(INPUT_POST, 'nombre') != null) && (filter_input(INPUT_POST, 'apellido1') != null) && (filter_input(INPUT_POST, 'apellido2') != null) && (filter_input(INPUT_POST, 'Telefono') != null) && (filter_input(INPUT_POST, 'Correo') != null)) {
                //$personasguardar = Personas::createPersonas();
                $myPersonas->setidPersona(filter_input(INPUT_POST, 'idPersona'));
                $myPersonas->setnombre(filter_input(INPUT_POST, 'nombre'));
                $myPersonas->setapellido1(filter_input(INPUT_POST, 'apellido1'));
                $myPersonas->setapellido2(filter_input(INPUT_POST, 'apellido2'));
                $myPersonas->setTelefono(filter_input(INPUT_POST, 'Telefono'));
                $myPersonas->setCorreo(filter_input(INPUT_POST, 'Correo'));
                $myUsuarios->setidUsuario(filter_input(INPUT_POST, 'idUsuario'));
                $myUsuarios->setidCedula(filter_input(INPUT_POST,'idPersona'));
                $myUsuarios->setLat(filter_input(INPUT_POST,'Lat'));
                $myUsuarios->setLong(filter_input(INPUT_POST,'Long'));
                if ($action == "registrarse") {
                    $myPersonasBo->add($myPersonas);
                    $myUsuariosBo -> add($myUsuarios);
                    echo('M~Registro Incluido Correctamente');
                }
                if ($action == "update_personas") {
                    $myPersonasBo->update($myPersonas);
                     $myUsuariosBo -> add($myUsuarios);
                    echo('M~Registro Modificado Correctamente');
                }
            }
        }

        //***********************************************************
        //***********************************************************

        if ($action === "showAll_personas") {//accion de consultar todos los registros
            $resultDB   = $myPersonasBo->getAll();
            $json       = json_encode($resultDB->GetArray());
            $resultado = '{"data": ' . $json . '}';
            if($resultDB->RecordCount() === 0){
                $resultado = '{"data": []}';
            }
            echo $resultado;
        }

        //***********************************************************
        //***********************************************************

        
        if ($action === "show_personas") {//accion de mostrar cliente por ID
            //se valida que los parametros hayan sido enviados por post
            if (filter_input(INPUT_POST, 'idPersona') != null) {
                $myPersonas->setidPersona(filter_input(INPUT_POST, 'idPersona'));
                $myPersonas = $myPersonasBo->searchById($myPersonas);
                if ($myPersonas != null) {
                    echo json_encode(($myPersonas));
                } else {
                    echo('E~NO Existe un cliente con el ID especificado');
                }
            }
        }

        //***********************************************************
        
        if ($action === "delete_personas") {//accion de eliminar cliente por ID
            //se valida que los parametros hayan sido enviados por post
            if (filter_input(INPUT_POST, 'idPersona') != null) {
                $myPersonas->setidPersona(filter_input(INPUT_POST, 'idPersona'));
                $myPersonasBo->delete($myPersonas);
                echo('M~Registro Fue Eliminado Correctamente');
            }
        }

        //***********************************************************
        //se captura cualquier error generado
        //***********************************************************
    } catch (Exception $e) { //exception generated in the business object..
        echo("E~" . $e->getMessage());
    }
} else {
    echo('M~Parametros no enviados desde el formulario - Prueba'); //se codifica un mensaje para enviar
}
?>
