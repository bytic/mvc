<?php

namespace Nip\Mvc\Sections\UrlTransformer;

/**
 * Trait HasUrlTransformerTrait
 * @package Nip\Mvc\Sections\UrlTransformer
 */
trait HasUrlTransformerTrait
{
    /**
     * @var UrlTransformer
     */
    protected $urlTransformer = null;

    /**
     * @return UrlTransformer
     */
    public function getUrlTransformer(): UrlTransformer
    {
        if ($this->urlTransformer == null) {
            $this->initUrlTransformer();
        }
        return $this->urlTransformer;
    }

    /**
     * @param UrlTransformer $urlTransformer
     */
    public function setUrlTransformer(UrlTransformer $urlTransformer)
    {
        $this->urlTransformer = $urlTransformer;
    }

    protected function initUrlTransformer()
    {
        $this->setUrlTransformer(UrlTransformer::from());
    }
}