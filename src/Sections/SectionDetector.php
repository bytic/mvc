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
        $detector = new static();
        return $detector->detect($collection);
    }

    /**
     * @param $collection
     * @return bool|int|mixed|string
     */
    public function detect($collection)
    {
        $current = $this->detectFromConstant();
        if ($current) {
            return $current;
        }
        $current = $this->detectFromSubdomain($collection);
        if ($current) {
            return $current;
        }

        return 'main';
    }

    /**
     * @return bool|string
     */
    protected function detectFromConstant()
    {
        return false;
//        return (defined('SPORTIC_SECTION')) ? SPORTIC_SECTION : false;
    }

    /**
     * @param $collection
     * @return bool|mixed
     */
    protected function detectFromSubdomain($collection)
    {
        $subDomain = $this->getCurrentSubdomain();
        foreach ($collection as $key => $section) {
            if ($subDomain == $section->getSubdomain()) {
                return $key;
            }
        }

        return $subDomain;
    }

    /**
     * @return bool|mixed
     */
    protected function getCurrentSubdomain()
    {
        return request()->getHttp()->getSubdomain();
    }
}
