<?php

namespace Nip\Mvc\Tests\Sections;

use Nip\Config\Config;
use Nip\Container\Container;
use Nip\Mvc\Sections\SectionsManager;
use Nip\Mvc\Tests\AbstractTest;

/**
 * Class SectionsManagerTest
 * @package Nip\Mvc\Tests\Sections
 */
class SectionsManagerTest extends AbstractTest
{
    public function test_loadFromConfig()
    {
        $this->prepareConfig();
        $manager = new SectionsManager();

        self::assertCount(3, $manager->getSections());
    }

    public function test_visibleIn()
    {
        $this->prepareConfig();
        $manager = new SectionsManager();

        $adminSections = $manager->visibleIn('admin');
        self::assertCount(2, $adminSections);
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