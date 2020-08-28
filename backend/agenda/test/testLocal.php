<?php


require_once ("../bo/localBo.php");
require_once ("../domain/locales.php");

$obj_Local = new Locales();
$obj_Local->setidCodigo_Cliente(1234567898);
$obj_Local->setCedula_Juridica(1234567897);
$obj_Local->setPersonas_idPersonas(116160613);
$obj_Local->setLatitud(12,12);
$obj_Local->setLongitud(11,11);
$obj_Local->setNombre_Local("Super Gigante");


$bo_Local = new LocalBo();

$operacion = 1; //variable para pruebas

switch ($operacion) {
    case 1: //Prueba para guardar en la base de datos
        $bo_Local->add($obj_Local);
        echo("<h1>Prueba de agregar exitosa</h1>");
    break;

    case 2: //Prueba para modificar en la base de datos
        $bo_Local->update($obj_Local);
        echo("<h1>Prueba de modificar exitosa</h1>");
    break;

    case 3: //Prueba para eliminar en la base de datos
        $bo_Local->delete($obj_Local);
        echo("<h1>Prueba de eliminar exitosa</h1>");
    break;

    case 4: //Prueba para consultar en la base de datos
        $LocalConsultada = $bo_Local->searchById($obj_Local);
        echo("<h1>Prueba de consultar por ID exitosa exitosa</h1>");
        echo (json_encode($LocalConsultada));
    break;

    case 5: //Prueba para consultar todos en la base de datos
        $resutlado = $bo_Local->getAll();
        echo("<h1>Prueba de consultar todos los registros exitosa</h1>");
        echo (json_encode($resutlado->GetArray()));
    break;

    default:
    break;
}
