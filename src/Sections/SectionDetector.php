<?php

namespace Nip\Mvc\Sections;

/**
 * Class SectionDetector
 * @package Nip\Mvc\Sections
 */
class SectionDetector
{
    /**
     * @param SectionsCollection $collection
     * @return string
     */
    public static function run($collection)
    {
        return static::detect($collection);
    }

    /**
     * @param $collection
     * @return bool|int|mixed|string
     */
    protected static function detect($collection)
    {
        $current = static::detectFromConstant();
        if ($current) {
            return $current;
        }
        $current = static::detectFromSubdomain($collection);
        if (!$current) {
            return $current;
        }

        return 'main';
    }

    /**
     * @return bool|string
     */
    protected static function detectFromConstant()
    {
        return false;
//        return (defined('SPORTIC_SECTION')) ? SPORTIC_SECTION : false;
    }

    /**
     * @param $collection
     * @return bool|mixed
     */
    protected static function detectFromSubdomain($collection)
    {
        $subDomain = request()->getHttp()->getSubdomain();
        foreach ($collection as $key => $section) {
            if ($subDomain == $section->getSubdomain()) {
                return $key;
            }
        }

        return $subDomain;
    }
}