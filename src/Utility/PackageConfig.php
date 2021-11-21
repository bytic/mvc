<?php

namespace Nip\Mvc\Utility;

use Nip\Mvc\MvcServiceProvider;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class PackageConfig
 * @package Nip\Mvc\Utility
 */
class PackageConfig extends \ByTIC\PackageBase\Utility\PackageConfig
{
    use SingletonTrait;

    protected $name = MvcServiceProvider::NAME;
}