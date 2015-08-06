<?php

namespace Kielo;

use Kielo\Exception\InvalidMessageException;

class MailSender
{
    /**
     * @var
     */
    private $mailer;
    /**
     * @var
     */
    private $message;

    /**
     * @param \PHPMailer $mailer
     * @param Message    $message
     */
    public function __construct(\PHPMailer $mailer, Message $message)
    {
        $this->mailer = $mailer;
        $this->message = $message;
    }

    public function send()
    {
        $this->setMessage();
        return $this->mailer->send();
    }

    private function setMessage()
    {
        $this->validateMessage();

        $this->mailer->addAddress($this->message->to);
        $this->mailer->Subject = $this->message->subject;
        $this->mailer->Body = $this->message->body;
        $this->mailer->From= $this->message->fromAddress;
        $this->mailer->FromName = $this->message->fromName;
    }

    private function validateMessage()
    {
        if (
            empty($this->message->subject)
            || empty($this->message->body)
            || empty($this->message->to)
            || empty($this->message->fromAddress)
            || empty($this->message->fromName)
        ) {
            throw new InvalidMessageException();
        }
    }
}