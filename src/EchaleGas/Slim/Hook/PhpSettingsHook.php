<?php
namespace EchaleGas\Slim\Hook;

class PhpSettingsHook
{
    protected $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    public function __invoke()
    {
        $this->setPhpIniSettings();
    }

    public function setPhpIniSettings()
    {
        foreach ($this->settings as $iniKey => $iniValue) {
            ini_set($iniKey, $iniValue);
        }
    }
}