<?php
$nivelCarpeta = isset($nivelCarpeta)?$nivelCarpeta:"../../../../";
require_once($nivelCarpeta."appCenter/login/backEnd/domain/SistemaSeguridadDTO.php");//WBB 05/05/2020 NOTA: se debe mantener las paginas a un mismo nivel para que funcione el include
require_once($nivelCarpeta."appCenter/login/backEnd/domain/ModuloSeguridadDTO.php");//WBB 05/05/2020 NOTA: se debe mantener las paginas a un mismo nivel para que funcione el include
require_once($nivelCarpeta."appCenter/login/backEnd/domain/MenuSeguridadDTO.php");//WBB 05/05/2020 NOTA: se debe mantener las paginas a un mismo nivel para que funcione el include

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_name('ice_RHAppCenter');
session_start();
if (empty($_SESSION['u_userInfo'])) {
    header("Location: ".$nivelCarpeta."index.php");
    echo "<script>location.href='".$nivelCarpeta."index.php';</script>";
    die();//rosaura
}