<?php

namespace Nip\Mvc\Sections;

use Nip\Utility\Str;
use Nip\Utility\Traits\DynamicPropertiesTrait;

/**
 * Class Section
 * @package Nip\Mvc\Sections
 *
 * @property $menu
 * @property $folder
 */
class Section
{
    use DynamicPropertiesTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $subdomain;

    /**
     * @var string
     */
    protected $path = null;

    /**
     * @var string
     */
    protected $folder = null;

    protected $icon = null;

    protected $baseUrl = null;

    protected $visibleIn = [];

    /**
     * Section constructor.
     * @param array $data
     */
    public function __construct($data = [])
    {
        $this->writeData($data);
    }

    /**
     * @inheritDoc
     */
    public function __call(string $name, array $arguments)
    {
        if (strpos($name, 'is') ===0) {
            $section = substr($name, 2);
            $section = inflector()->underscore($section);
            return $this->visibleIn($section);
        }
        throw new \Exception("Invalid call " . $name . " on " . __CLASS__ . "");
    }

    /**
     * @param $data
     */
    public function writeData($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * @return string
     */
    public function getSubdomain()
    {
        return $this->subdomain;
    }

    /**
     * @return string
     */
    public function printIcon()
    {
        if (empty($this->icon)) {
            return '';
        }
        if (Str::contains($this->icon,'<path')) {
            return '<svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"  focusable="false" aria-hidden="true" role="presentation">'
                . $this->icon
                . '</svg>';
        }
        return $this->icon;
    }

    /**
     * @param bool $url
     * @return string
     */
    public function getURL($url = false)
    {
        $url = $url ? $url : request()->root();

        if (strpos($url, 'http') === 0) {
            return $this->getManager()->getUrlTransformer()->transform($url, $this);
        }

        return $this->getBaseUrl() . $url;
    }

    /**
     * @return string|null
     */
    public function getBaseUrl()
    {
        if ($this->baseUrl === null) {
            $this->initBaseUrl();
        }

        return $this->baseUrl;
    }

    protected function initBaseUrl()
    {
        $baseUrl = request()->root();

        $this->baseUrl = $this->getManager()->getUrlTransformer()->transform($baseUrl, $this);
    }

    /**
     * @param bool $url
     * @param array $params
     * @return mixed
     */
    public function assembleURL($url = false, $params = [])
    {
        $url = $url ? $url : '/';

        $url = $this->getBaseUrl() . $url;
        if (count($params)) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }

    /**
     * Compile path for this section from a given path of current section
     *
     * @param bool $path
     * @return string
     */
    public function compilePath($path = false)
    {
        $currentBasePath = $this->getManager()->getCurrent()->getPath();
        $path = str_replace($currentBasePath, $this->getPath(), $path);
        return $path;
    }

    /**
     * Return the path for section
     *
     * @return null|string
     */
    public function getPath()
    {
        if ($this->path === null) {
            $this->initPath();
        }
        return $this->path;
    }

    protected function initPath()
    {
        $this->path = $this->generatePath();
    }

    /**
     * @return string
     */
    protected function generatePath()
    {
        $path = app('path.base');
        if (!$this->isCurrent()) {
            $path = str_replace(
                DIRECTORY_SEPARATOR . $this->getManager()->getCurrent()->getFolder() . '',
                DIRECTORY_SEPARATOR . $this->getFolder() . '',
                $path
            );
        }
        return $path;
    }

    /**
     * @return bool
     */
    public function isCurrent()
    {
        return $this->getName() == $this->getManager()->getCurrent()->getName();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return SectionsManager
     */
    protected function getManager()
    {
        return app('mvc.sections');
    }

    /**
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param string $place
     * @return bool
     */
    public function visibleIn($place)
    {
        return in_array($place, $this->visibleIn);
    }
}
