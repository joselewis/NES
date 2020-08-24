<?php

require_once('../../../utlis/PHPMailer/PHPMailer.php');
require_once('../../../utlis/PHPMailer/Exception.php');
require_once("../../../utlis/PHPMailer/SMTP.php");
require_once('../../../utlis/sms/TextMagicAPI.php');

require_once("../../../utlis/config.php");

function enviar_sms($TelefonoPar, $Mensaje) {
    $Telefono = str_replace("+", "", $TelefonoPar);
    $usuario = 'cristhiangaritafonse';
    $password = 'pass'; //crear usuario
    $enrutador = new TextMagicAPI(array(
        'username' => $usuario,
        'password' => $password
    ));
    $respuesta = $enrutador->send($Mensaje, array($Telefono), true);
    return $respuesta;
}

function enviar_email($correo, $mensaje, $nombre, $copias, $subject, $attachment = null) {
    global $config_AMBIENTE_CORREO;
    
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    if ($config_AMBIENTE_CORREO == "desarrollo") {
        //$mail->SMTPDebug    = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->CharSet          = "UTF-8";
        $mail->SMTPAuth         = true; // authentication enabled
        $mail->SMTPSecure       = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host             = "smtp.gmail.com";
        $mail->Port             = 465; // or 587
        $mail->Username         = "stebanmac@gmail.com";
        $mail->Password         = "wurm tkhr bjck ahga";  // password
        $mail->From             = "stebanmac@gmail.com";
        $mail->FromName         = "Cristhian Garita Fonseca";
        $mail->Subject          = $subject;
        $mail->Body             = $mensaje;
        $mail->Timeout          = 60;

        //*********************************************
        //Se agreal el adjunto si viene por parametro
        //*********************************************
        if ($attachment !== "" && $attachment !== NULL) {
            $archivos = split("&", $attachment);
            for ($index = 0; $index < count($archivos); $index++) {
                $mail->AddAttachment($archivos[$index], split("/", $archivos[$index])[2], "base64", "application/octet-stream");
            }
        }
    } else {
        //$mail->SMTPDebug    = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->CharSet          = "UTF-8";
        $mail->SMTPAuth         = true; // authentication enabled
        $mail->SMTPSecure       = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host             = "smtp.gmail.com";
        $mail->Port             = 465; // or 587
        $mail->Username         = "stebanmac@gmail.com";
        $mail->Password         = "wurm tkhr bjck ahga";  // password
        $mail->From             = "stebanmac@gmail.com";
        $mail->FromName         = "Cristhian Garita Fonseca";
        $mail->Subject          = $subject;
        $mail->Body             = $mensaje;
        $mail->Timeout          = 60;

        //*********************************************
        //Se agreal el adjunto si viene por parametro
        //*********************************************
        if ($attachment !== "" && $attachment !== NULL) {
            $archivos = split("&", $attachment);
            for ($index = 0; $index < count($archivos); $index++) {
                $mail->AddAttachment($archivos[$index], split("/", $archivos[$index])[2], "base64", "application/octet-stream");
            }
        }
    }

    //Agrega los diferentes correos a los que debe enviar la informacion
    $direccionesCorreo = explode(";", $correo);
    for ($i = 0; $i < count($direccionesCorreo); $i++) {
        $mail->AddAddress($direccionesCorreo[$i], $nombre);
    }
    
    //agrega a las personas a las que le debe poner copia
    if ($copias !== "" && $copias !== NULL) {
        foreach ($copias as $clave => $valor) {
            $mail->addCC($clave, $valor);
        }
    }

    if (!$mail->Send()) {
        echo "E-Mailer Error: " . $mail->ErrorInfo;
    }
}

function enviar_email_varios($mensaje, $correos, $copias, $subject, $attachment = null) {
    global $config_AMBIENTE_CORREO;
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    if ($config_AMBIENTE_CORREO == "desarrollo") {
        
        //$mail->SMTPDebug        = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
         ); 
        
        $mail->IsHTML(true);
        $mail->CharSet          = "UTF-8";
        $mail->SMTPAuth         = true; // authentication enabled
        $mail->SMTPSecure       = 'tls'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host             = "smtp.gmail.com";
        $mail->Port             = 587; // or 587
        $mail->Username         = "stebanmac@gmail.com";
        $mail->Password         = "wurm tkhr bjck ahga";  // password
        $mail->From             = "stebanmac@gmail.com";
        $mail->FromName         = "Cristhian Garita Fonseca";
        $mail->Subject          = $subject;
        $mail->Body             = $mensaje;
        $mail->Timeout          = 60;

        //*********************************************
        //Se agreal el adjunto si viene por parametro
        //*********************************************
        if ($attachment !== "" && $attachment !== NULL) {
            $archivos = explode("&", $attachment);
            for ($index = 0; $index < count($archivos); $index++) {
                $mail->AddAttachment($archivos[$index], explode("/", $archivos[$index])[2], "base64", "application/octet-stream");
            }
        }
    } else {
        
        $mail->IsHTML(true);
        $mail->CharSet          = "UTF-8";
        $mail->SMTPAuth         = true; // authentication enabled
        $mail->SMTPSecure       = 'tls'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host             = "smtp.gmail.com";
        $mail->Port             = 587; // or 587
        $mail->Username         = "stebanmac@gmail.com";
        $mail->Password         = "wurm tkhr bjck ahga";  // password
        $mail->From             = "stebanmac@gmail.com";
        $mail->FromName         = "Cristhian Garita Fonseca";
        $mail->Subject          = $subject;
        $mail->Body             = $mensaje;
        $mail->Timeout          = 60;

        //*********************************************
        //Se agreal el adjunto si viene por parametro
        //*********************************************
        if ($attachment !== "" && $attachment !== NULL) {
            $archivos = explode("&", $attachment);
            for ($index = 0; $index < count($archivos); $index++) {
                $mail->AddAttachment($archivos[$index], explode("/", $archivos[$index])[2], "base64", "application/octet-stream");
            }
        }
    }

    //*********************************************************************
    //Agrega los diferentes correos a los que debe enviar la informacion
    //*********************************************************************
    //agrega a las personas a las que le debe poner copia
    if ($correos !== "" && $correos !== NULL) {
        foreach ($correos as $clave => $valor) {
            $mail->AddAddress($clave, $valor);
        }
    }

    //agrega a las personas a las que le debe poner copia
    if ($copias !== "" && $copias !== NULL) {
        foreach ($copias as $clave => $valor) {
            $mail->addCC($clave, $valor);
        }
    }

    if (!$mail->Send()) {
        echo "E-Mailer Error: " . $mail->ErrorInfo;
    }
}
