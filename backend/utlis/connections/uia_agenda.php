<?php

require_once("../../utlis/adodb5/adodb.inc.php");

/*
  Inicializacion de la conexion
  Desarrollo o produccion
 */

global $config_AMBIENTE_BD;

switch ($config_AMBIENTE_BD) {
    case "desarrollo":
        $driver = 'mysqli';
        $labAdodb = newAdoConnection($driver);
        $labAdodb->setCharset('utf8');
        $labAdodb->setConnectionParameter('CharacterSet', 'WE8ISO8859P15');
        $labAdodb->Connect("localhost", "root", "Programacion2uia", "NESTLE");
       
        break;
    case "produccion":
        $driver = 'mysqli';
        $labAdodb = newAdoConnection($driver);
        $labAdodb->setCharset('utf8');
        $labAdodb->setConnectionParameter('CharacterSet', 'WE8ISO8859P15');
        $labAdodb->Connect("prd", "user_prd", "user_pass", "database");
        break;
}
	
