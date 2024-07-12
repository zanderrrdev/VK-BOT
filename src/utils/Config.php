<?php

namespace App\utils;

use Symfony\Component\Yaml\Yaml;

class Config
{
    private $config;

    public function __construct($file)
    {
        $this->config = Yaml::parseFile($file);
    }

    public function get($path, $default = null)
    {
        $keys = explode('.', $path);
        $value = $this->config;

        foreach ($keys as $key) {
            if (isset($value[$key])) {
                $value = $value[$key];
            } else {
                return $default;
            }
        }

        return $value;
    }
}