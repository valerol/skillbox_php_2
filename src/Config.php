<?php
namespace App;

/**
 * Class Config
 * @package App
 */
final class Config
{
    private static $instance;

    private array $configurations = [];

    /**
     * @return Config
     */
    public static function getInstance(): Config
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Config constructor.
     */
    private function __construct()
    {
        $this->load();
    }

    private function load()
    {
        foreach (scandir(APP_DIR . 'configs') as $key => $config_file) {
            if ($key > 1) {
                $configs = require(APP_DIR . 'configs' . DIRECTORY_SEPARATOR . $config_file);

                if (!empty($configs)) {
                    foreach ($configs as $key => $val) {
                        $this->configurations[$key] = $val;
                    }
                }
            }
        }
    }

    /**
     * @param string $config
     * @param null $default
     * @return array|mixed|null
     */
    public function get(string $config, $default = null)
    {
        return \array_get($this->configurations, $config, $default);
    }
}
