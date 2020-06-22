<?php

namespace Nip\Mvc\Tests\Modules;

use Nip\Config\Config;
use Nip\Container\Container;
use Nip\Mvc\Modules\ModulesManager;
use Nip\Mvc\Sections\SectionsManager;
use Nip\Mvc\Tests\AbstractTest;

/**
 * Class ModulesManagerTest
 * @package Nip\Mvc\Tests\Modules
 */
class ModulesManagerTest extends AbstractTest
{
    public function test_getNames()
    {
        $this->prepareConfig();
        $manager = new ModulesManager();

        self::assertSame(['admin', 'frontend', 'api'], $manager->getNames());
    }

    public function test_loadFromConfig()
    {
        $this->prepareConfig();
        $manager = new ModulesManager();

        self::assertCount(3, $manager->getModules());
    }

    /**
     * @param string $file
     */
    protected function prepareConfig($file = 'basic')
    {
        $data = require TEST_FIXTURE_PATH . DIRECTORY_SEPARATOR. 'config'. DIRECTORY_SEPARATOR . $file.'.php';
        $config = new Config(['mvc' => $data]);
        Container::getInstance()->set('config', $config);
    }
}