<?php

namespace Nip\Mvc\Tests;

use Nip\Container\Container;
use Nip\Mvc\Modules;
use Nip\Mvc\MvcServiceProvider;
use Nip\Mvc\Sections\SectionsManager;

/**
 * Class MvcServiceProviderTest
 * @package Nip\Mvc\Tests
 */
class MvcServiceProviderTest extends AbstractTest
{
    public function testRegister()
    {
        $serviceProvider = new MvcServiceProvider();
        $serviceProvider->setContainer(new Container());

        $serviceProvider->register();
        $container = $serviceProvider->getContainer();

        $modules = $container->get('mvc.modules');
        self::assertInstanceOf(Modules::class, $modules);

        $sections = $container->get('mvc.sections');
        self::assertInstanceOf(SectionsManager::class, $sections);
    }
}
