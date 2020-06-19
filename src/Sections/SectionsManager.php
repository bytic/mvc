<?php

namespace Nip\Mvc\Sections;

use Nip\Collections\AbstractCollection;


/**
 * Class SectionsManager
 * @package Nip\Mvc\Sections
 */
class SectionsManager
{
    protected $currentKey = null;

    /**
     * @var SectionsCollection
     */
    protected $sections = null;

    /**
     * @return Section
     */
    public function getCurrent()
    {
        return $this->getSections()->get($this->getCurrentKey());
    }

    /**
     * @return null
     */
    public function getCurrentKey()
    {
        if ($this->currentKey === null) {
            $this->setCurrentKey(SectionDetector::run($this->sections));
        }

        return $this->currentKey;
    }

    /**
     * @param $key
     */
    public function setCurrentKey($key)
    {
        $this->currentKey = $key;
    }

    /**
     * @return SectionsCollection
     */
    public function getSections(): SectionsCollection
    {
        if ($this->sections === null) {
            $this->sections = new SectionsCollection();
            $this->loadFromConfig();
        }
        return $this->sections;
    }

    /**
     * @param SectionsCollection $sections
     */
    public function setSections(SectionsCollection $sections): void
    {
        $this->sections = $sections;
    }

    /**
     * @return void
     * @deprecated no need to call init
     */
    public function init()
    {
    }

    /**
     * @param $place
     * @return mixed
     */
    public function visibleIn($place)
    {
        return $this->getSections()->filter(function ($item) use ($place) {
            /** @var Section $item */
            return $item->visibleIn($place);
        });
    }

    protected function loadFromConfig()
    {
        if (function_exists('config')) {
            $data = config('mvc.sections', []);
            foreach ($data as $key => $row) {
                $this->sections->set($key, $this->newSection($row->toArray()));
            }
        }
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function newSection($data)
    {
        $section = app(Section::class);
        $section->writeData($data);
        return $section;
    }
}
