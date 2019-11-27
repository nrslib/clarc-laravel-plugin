<?php


namespace nrslib\ClarcLaravelPlugin\Config;


class LaravelConfig
{
    public const NAMESPACE_HTTP = 'App\\Http\\';
    public const NAMESPACE_CONTROLLER = self::NAMESPACE_HTTP . 'Controllers';
    public const NAMESPACE_PRESENTER = self::NAMESPACE_HTTP . 'Presenters';
    public const NAMESPACE_MIDDLEWARE = self::NAMESPACE_HTTP . 'Middleware';
    public const NAMESPACE_VIEWMODEL = self::NAMESPACE_HTTP . 'ViewModels';
    public const NAMESPACE_PACKAGE = 'packages\\';
    public const NAMESPACE_INPUT_PORT = self::NAMESPACE_PACKAGE . 'InputPorts';
    public const NAMESPACE_INTERACTOR = self::NAMESPACE_PACKAGE . 'Interactors';
    public const NAMESPACE_OUTPUT_PORT = self::NAMESPACE_PACKAGE . 'OutputPorts';

    public const DIR_HTTP = 'app/Http/';
    public const DIR_CONTROLLER = self::DIR_HTTP . 'Controllers/';
    public const DIR_PRESENTER = self::DIR_HTTP . 'Presenters/';
    public const DIR_VIEWMODEL = self::DIR_HTTP . 'ViewModels/';
    public const DIR_PACKAGE = 'packages/';
    public const DIR_INPUT_PORT = self::DIR_PACKAGE . 'InputPorts/';
    public const DIR_INTERACTOR = self::DIR_PACKAGE . 'Interactors/';
    public const DIR_OUTPUT_PORT = self::DIR_PACKAGE . 'OutputPorts/';
    public const DIR_PROVIDER = 'app/Providers/';
    public const DIR_MIDDLEWARE = self::DIR_HTTP . 'Middleware/';

    public const FILE_CLARC_PROVIDER = self::DIR_PROVIDER . 'ClarcProvider.php';
}