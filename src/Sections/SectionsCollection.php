<?php

namespace Nip\Mvc\Sections;

use Nip\Collections\AbstractCollection;


/**
 * Class SectionsManager
 * @package Nip\Mvc\Sections
 */
class SectionsCollection extends AbstractCollection
{
    /**
     * @param $place
     * @return mixed
     */
    public function visibleIn($place)
    {
        return $this->filter(function ($item) use ($place) {
            /** @var Section $item */
            return $item->visibleIn($place);
        });
    }
}
