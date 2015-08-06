<?php

namespace Kielo;

use Kielo\Exception\DefaultConfigurationNotFoundException;

class UserAccount
{
    private $name;
    private $apiKey;
    private $fromEmail;
    private $fromName;
    private $groups;
    private $servers;

    public function __construct($name, $apiKey, $fromEmail, $fromName, $groups = array(), $servers = array())
    {
        $this->name = $name;
        $this->apiKey = $apiKey;
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromEmail;
        $this->groups = $groups ?: array();
        $this->servers = $servers ?: array();
    }

    public static function makeFromArray(array $user)
    {
        $account = new self(
            $user['name'],
            $user['apiKey'],
            $user['fromEmail'],
            $user['fromName'],
            $user['groups'],
            $user['servers']
        );

        return $account;
    }

    public function getDefaultServerConfiguration()
    {
        if (!isset($this->servers['default']) || empty($this->servers['default'])) {
            throw new DefaultConfigurationNotFoundException();
        }

        return $this->servers['default'];
    }

    public function getFromAddress()
    {
        return $this->fromEmail;
    }

    public function getFromName()
    {
        return $this->fromName;
    }
}