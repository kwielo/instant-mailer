<?php

namespace Kielo;

use Kielo\Exception\ConfigurationNotFoundException;
use Symfony\Component\Yaml\Yaml;

class MailerConfiguration
{

    public function getConfiguration()
    {
        return Yaml::parse($this->getConfigurationFile());
    }

    public function getUsersConfiguration()
    {
        $configuration = $this->getConfiguration();

        return $configuration['users'];
    }

    /**
     * @return string
     * @throws ConfigurationNotFoundException
     */
    public function getConfigurationFile()
    {
        $configFilename = APP_ROOT_DIR . 'app/config/users.yml';
        if (!file_exists($configFilename)) {
            throw new ConfigurationNotFoundException(sprintf('File %s not found', $configFilename));
        }
        return $configFilename;
    }
}