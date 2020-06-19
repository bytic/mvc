<?php

namespace Nip\Mvc\Tests\Sections;

use Nip\Container\Container;
use Nip\Mvc\Sections\Section;
use Nip\Mvc\Tests\AbstractTest;

/**
 * Class SectionTest
 * @package Nip\Mvc\Tests\Sections
 */
class SectionTest extends AbstractTest
{
    public function test_visibleIn()
    {
        $section = new Section();
        $section->writeData(['visibleIn' => ['admin']]);

        self::assertTrue($section->visibleIn('admin'));
        self::assertFalse($section->visibleIn('frontend'));
    }

    public function test_getURL()
    {
        $this->initRequest();
        $section = new Section();

        self::assertSame('http://mydomain.com/subfolder', $section->getURL());
    }

    protected function initRequest()
    {
        $server = [
            'HTTP_HOST' => 'mydomain.com',
            'SCRIPT_FILENAME' => '/home/app/subfolder/index.php',
            'SCRIPT_NAME' => '/subfolder/index.php',
            'REQUEST_URI' => '/subfolder/',
        ];
        $request = new \Nip\Http\Request([], [], [], [], [], $server);

        Container::getInstance()->set('request', $request);
    }
}