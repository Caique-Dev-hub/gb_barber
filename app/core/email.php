<?php

require 'c:\xampp\htdocs\gb-barber\public\vendor/PHPMailer.php';
require 'c:\xampp\htdocs\gb-barber\public\vendor/SMTP.php';
require 'c:\xampp\htdocs\gb-barber\public\vendor/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{
    public function __construct()
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'gustavocostabrito314@gmail.com';
            $mail->Password   = 'Gustavo22052008'; // use senha de app
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            // Recomendado no localhost
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true
                ]
            ];

            $mail->setFrom('gustavocostabrito314@gmail.com', 'Gustavo Costa Brito');
            $mail->addAddress('gustavocostabrito2008@dominio.com', 'Teste');

            $mail->isHTML(true);
            $mail->Subject = 'Assunto do E-mail';
            $mail->Body    = '<strong>Olá!</strong> Este é um teste de envio de e-mail com PHPMailer.';
            $mail->AltBody = 'Olá! Este é um teste de envio de e-mail com PHPMailer.';

            $mail->send();
            echo 'E-mail enviado com sucesso!';
        } catch (Exception $e) {
            echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
        }
    }
}
