<?php

namespace Kielo;

class Message
{
    public $subject;
    public $body;
    public $to;
    public $fromAddress;
    public $fromName;

    public function __construct($subject, $body, $to, UserAccount $userAccount)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->to = $to;
        $this->fromAddress = $userAccount->getFromAddress();
        $this->fromName = $userAccount->getFromName();
    }
}