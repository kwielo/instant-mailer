<?php

namespace Kielo;

class MailerFactory
{
    public static function createFromUserConfiguration(array $config)
    {
        $mailer = new \PHPMailer(true);

        $mailer->isSMTP();                                      // Set mailer to use SMTP
        $mailer->Host = $config['smtpHost'];  // Specify main and backup SMTP servers
        $mailer->SMTPAuth = true;                               // Enable SMTP authentication
        $mailer->Username = $config['smtpUsername'];                 // SMTP username
        $mailer->Password = $config['smtpPassword'];                           // SMTP password
        $mailer->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mailer->Port = isset($config['smptPort']) ? $config['smptPort'] : 587;

        return $mailer;
    }
}