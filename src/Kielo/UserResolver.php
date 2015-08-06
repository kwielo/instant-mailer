<?php

namespace Kielo;

use Kielo\Exception\UserNotFoundException;

class UserResolver
{
    public function __construct()
    {
        $this->configuration = new MailerConfiguration();
    }

    public function getUserByApiKey($apiKey)
    {
        foreach ($this->configuration->getUsersConfiguration() as $user) {
            if ($apiKey === $user['apiKey']) {
                return UserAccount::makeFromArray($user);
            }
        }

        throw new UserNotFoundException(sprintf('User with api key %s not found', $apiKey));
    }

}