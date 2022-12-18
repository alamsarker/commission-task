<?php

declare(strict_types=1);

namespace App;

final class Configuration
{
    /**
     * Constructor
     *
     * Get the global config as array
     *
     * @param array $config- the config is comming fron config.json file
     */
    public function __construct(private array $config)
    {
    }

    /**
     * Get Config value
     *
     * @param string $key - The key of the config
     * @param mixed $default - Default value if the key is missing in config
     */
    public function get(string $key, mixed $defatult ='')
    {
        if (!empty($this->config[$key])) {
            return $this->config[$key];
        }

        return $defatult;
    }
}
