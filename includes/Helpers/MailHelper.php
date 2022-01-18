<?php
require '../../vendor/autoload.php';
use Mailgun\Mailgun;
use PHPMailer\PHPMailer\Exception;
use Config\Config;

$emails = $_POST['emails'];
$link = $_POST['link'];

try {
    $mailgun = Mailgun::create(Config::FX_MAILGUN_API_KEY, Config::FX_MAILGUN_ENDPOINT);
    $response = $mailgun->messages()->send(Config::FX_MAILGUN_DOMAIN, [
        'from'    => Config::FX_MAILGUN_FROM_ADDR,
        'to'      => $emails,
        'subject' => 'Flexity Podcast',
        'text'    => "It is so simple use Flexity.\n $link",
    ]);
    echo json_encode($response);
    exit;
} catch(Exception $exception) {
    var_dump($exception);
}

