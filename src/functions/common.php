<?php

/**
 * @return \Nip\Mvc\Modules
 */
function mvc_modules()
{
    if (!function_exists('app')) {
        return null;
    }
    return app('mvc.modules');
}

/**
 * @return \Nip\Mvc\Sections\SectionsManager
 */
function mvc_sections()
{
    if (!function_exists('app')) {
        return null;
    }
    return app('mvc.sections');
}

/**
 * @param $section
 * @param $url
 * @return string
 */
function mvc_section_url($section, $url = false): string
{
    $section = mvc_sections()->getOne($section);
    return $section->getURL($url);
}
