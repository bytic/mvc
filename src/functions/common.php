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
