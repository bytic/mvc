<?php

namespace Nip\Mvc\Tests\Sections\UrlTransformer;

use Nip\Http\Request;
use Nip\Mvc\Sections\Section;
use Nip\Mvc\Sections\UrlTransformer\UrlTransformer;

/**
 * Class UrlTransformerTest
 * @package Nip\Mvc\Tests\Sections\UrlTransformer
 */
class UrlTransformerTest extends \Nip\Mvc\Tests\AbstractTest
{
    public function test_transform()
    {
        $request = new Request(
            [],
            [],
            [],
            [],
            [],
            [
            'SERVER_NAME' => 'current.domain.com'
        ]
        );
        $section = new Section(['subdomain' => 'new']);

        $url = 'https://current.domain.com/index?redirect=https://current.domain.com';
        $transformer = UrlTransformer::from($request);

        self::assertSame(
            'https://new.domain.com/index?redirect=https://current.domain.com',
            $transformer->transform($url, $section)
        );
    }
}
