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

    public function test_visibleIn_magicCall()
    {
        $section = new Section();
        $section->writeData(['visibleIn' => ['admin','admin_menu']]);

        self::assertTrue($section->isAdmin());
        self::assertTrue($section->isAdminMenu());
        self::assertFalse($section->isFrontend());
    }

    public function test_printIcon()
    {
        $section = new Section();
        $section->writeData(['icon' => '<path class="fil0" d="M512 402l0 110" >']);

        self::assertSame(
            '<svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"  focusable="false" aria-hidden="true" role="presentation"><path class="fil0" d="M512 402l0 110" ></svg>',
            $section->printIcon()
        );
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