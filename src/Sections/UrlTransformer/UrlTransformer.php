<?php

namespace Nip\Mvc\Sections\UrlTransformer;

use Nip\Http\Request;

/**
 * Class UrlTransformer
 * @package Nip\Mvc\Sections\UrlTransformer
 */
class UrlTransformer
{
    /**
     * @var Request
     */
    protected $request = null;

    /**
     * @param Request $request
     * @return UrlTransformer
     */
    public static function from(Request $request = null)
    {
        $transformer = new self($request);
        return $transformer;
    }

    /**
     * @param $url
     * @param $section
     * @return string
     */
    public function transform($url, $section)
    {
        $http = $this->request->getHttp();
        $httpSubdomain = $http->getSubdomain();
        $rootDomain = $http->getRootDomain();

        $replace = '://' . $section->getSubdomain() . '.' . $rootDomain;
        $transform = [
            '://' . $httpSubdomain . '.' . $rootDomain => $replace,
            '://' . $rootDomain => $replace,
        ];

        foreach ($transform as $search => $replace) {
            $pos = strpos($url, $search);
            if ($pos === false || $pos > 5) {
                continue;
            }
            $url = substr_replace($url, '#####', $pos, strlen($search));
            $url = str_replace('#####', $replace, $url);
        }

        return $url;
    }

    /**
     * UrlTransformer constructor.
     * @param Request|null $request
     */
    protected function __construct(Request $request = null)
    {
        $this->request = $request ? $request : request();
    }
}
