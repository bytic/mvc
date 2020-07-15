<?php

namespace Nip\Mvc\Tests\Sections;

use Mockery\Mock;
use Nip\Container\Container;
use Nip\Mvc\Sections\Section;
use Nip\Mvc\Sections\SectionsManager;
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

    /**
     * @dataProvider data_getURL
     */
    public function test_getURL($expected, $input)
    {
        $this->initRequest();
        $section = $this->newSectionMock();
        $section->writeData(['subdomain' => 'test']);

        self::assertSame($expected, $section->getURL($input));
    }

    /**
     * @return array
     */
    public function data_getURL()
    {
        return [
            ['http://test.mydomain.com/subfolder', ''],
            ['http://test.mydomain.com/subfolder/MyController/Action', '/MyController/Action'],
            ['http://test.mydomain.com/MyController/Action', 'http://mydomain.com/MyController/Action'],
        ];
    }

    public function test_getBaseUrl()
    {
        $this->initRequest();
        $section = $this->newSectionMock();
        $section->writeData(['subdomain' => 'test']);

        self::assertSame('http://test.mydomain.com/subfolder', $section->getBaseUrl());
    }

    /**
     * @return Mock|Section
     */
    protected function newSectionMock()
    {
        $manager = new SectionsManager();

        /** @var Section|Mock $section */
        $section = \Mockery::mock(Section::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $section->shouldReceive('getManager')->andReturn($manager);

        return $section;
    }

    protected function initRequest()
    {
        $server = [
            'HTTP_HOST' => 'mydomain.com',
            'SERVER_NAME' => 'mydomain.com',
            'SCRIPT_FILENAME' => '/home/app/subfolder/index.php',
            'SCRIPT_NAME' => '/subfolder/index.php',
            'REQUEST_URI' => '/subfolder/MyController/Action',
        ];
        $request = new \Nip\Http\Request([], [], [], [], [], $server);

        Container::getInstance()->set('request', $request);
    }
}