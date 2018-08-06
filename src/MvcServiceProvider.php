<?php

namespace Nip\Mvc;

use Nip\Container\ServiceProvider\AbstractSignatureServiceProvider;
use Nip\Mvc\Sections\SectionsManager;


/**
 * Class MvcServiceProvider
 * @package Nip\Mvc
 */
class MvcServiceProvider extends AbstractSignatureServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->registerModules();
        $this->registerSections();
    }

    protected function registerModules()
    {
        $this->getContainer()->singleton('mvc.modules', function () {
            return $this->createModulesProvider();
        });
    }

    /**
     * @return Modules
     */
    protected function createModulesProvider()
    {
        $modules = $this->getContainer()->has(Modules::class) ?
            $this->getContainer()->get(Modules::class)
            : new Modules();

        return $modules;
    }

    protected function registerSections()
    {
        $this->getContainer()->singleton('mvc.sections', function () {
            return $this->createSectionsManager();
        });
    }

    /**
     * @return Modules
     */
    protected function createSectionsManager()
    {
        $sections = $this->getContainer()->has(SectionsManager::class) ?
            $this->getContainer()->get(SectionsManager::class)
            : new SectionsManager();
        $sections->init();
        return $sections;
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['mvc.modules', 'mvc.sections'];
    }
}
