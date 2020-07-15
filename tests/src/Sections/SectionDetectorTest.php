<?php

namespace Nip\Mvc\Tests\Sections;

use Mockery;
use Nip\Config\Config;
use Nip\Container\Container;
use Nip\Mvc\Sections\SectionDetector;
use Nip\Mvc\Sections\SectionsManager;
use Nip\Mvc\Tests\AbstractTest;

/**
 * Class SectionDetectorTest
 * @package Nip\Mvc\Tests\Sections
 */
class SectionDetectorTest extends AbstractTest
{
    public function test_detectFromSubdomain()
    {
        $this->prepareConfig();
        $manager = new SectionsManager();
        $sections = $manager->getSections();

        /** @var Mockery\Mock|SectionDetector $detector */
        $detector = Mockery::mock(SectionDetector::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $detector->shouldReceive('detectFromConstant')->andReturn(false);
        $detector->shouldReceive('getCurrentSubdomain')->andReturn('sec2');

        $detected = $detector->detect($sections);
        self::assertSame(1, $detected);
        self::assertSame('sec2', $sections[$detected]->getSubdomain());
    }

    /**
     * @param string $file
     */
    protected function prepareConfig($file = 'basic')
    {
        $data = require TEST_FIXTURE_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $file . '.php';
        $config = new Config(['mvc' => $data]);
        Container::getInstance()->set('config', $config);
    }
}
