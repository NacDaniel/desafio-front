<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

if (!(key_exists("REQUEST_METHOD", $_SERVER) && $_SERVER["REQUEST_METHOD"] == "POST")) {
    return;
}

$body = file_get_contents('php://input');
$body = json_decode($body != "" ? $body : "[]", true);
$form_name = $body["nome"];
$form_mail = $body["email"];

if (empty($form_name) || strlen($form_name) <= 1) {
    response("Você deve preencher o campo \"Nome\"");
    return;
}
if (empty($form_mail) || strlen($form_mail) <= 1) {
    response("Você deve preencher o campo \"E-mail\"");
    return;
}

try {
    sendMail($form_name, $form_mail);
    response("E-mail enviado com sucesso.", 201);
} catch (Exception $e) {
    response("Ocorreu um erro ao enviar o e-mail.");
}

function sendMail($remetenteNome, $remetenteEmail)
{
    try {
        $mailer = new PHPMailer(true);
        $mailer->isSMTP();
        $mailer->Host = 'smtp.gmail.com';
        $mailer->SMTPAuth = true;
        $mailer->Username = 'preencher';
        $mailer->Password = 'phrp nxrk dgew mswi';
        $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mailer->Port = 465;

        $mailer->setFrom('preencher', 'Daniel');
        $mailer->addAddress("preencheer2", "Daniel recebedor");

        $mailer->isHTML(true);
        $mailer->Subject = 'Newsletter';
        $mailer->Body = "<h4>Nome: $remetenteNome</h4><h4>E-mail: $remetenteEmail</h4>";
        $mailer->AltBody = "Nome: $remetenteNome | E-mail: $remetenteEmail";
        $mailer->send();
        return true;
    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }
}
function response($msg, $code = null): bool
{
    header("Content-Type: application/json");
    http_response_code($code ?? 400);
    echo json_encode(["message" => $msg]);
    return true;
}

?>