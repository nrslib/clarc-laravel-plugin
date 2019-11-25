<?php


namespace nrslib\ClarcLaravelPlugin\Config;


class LaravelConfig
{
    public const CONTROLLER_NAMESPACE = 'App\\Http\\Controllers\\';
    public const PACKAGE_NAMESPACE = 'packages\\';
    public const INPUT_PORT_NAMESPACE = LaravelConfig::PACKAGE_NAMESPACE . 'InputPorts\\';
    public const INTERACTOR_NAMESPACE = LaravelConfig::PACKAGE_NAMESPACE . 'Interactors\\';
    public const OUTPUT_PORT_NAMESPACE = LaravelConfig::PACKAGE_NAMESPACE . 'OutputPorts\\';
    public const PRESENTER_NAMESPACE = LaravelConfig::PACKAGE_NAMESPACE . 'Presenters\\';

}