<?php

namespace Nip\Mvc;

use ByTIC\PackageBase\BaseBootableServiceProvider;
use Nip\Mvc\Modules\ModulesManager;
use Nip\Mvc\Sections\SectionsManager;

/**
 * Class MvcServiceProvider
 * @package Nip\Mvc
 */
class MvcServiceProvider extends BaseBootableServiceProvider
{
    public const NAME = 'mvc';

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
        $this->getContainer()->share('mvc.modules', function () {
            return $this->createModulesProvider();
        });
    }

    /**
     * @return ModulesManager
     */
    protected function createModulesProvider()
    {
        if ($this->getContainer()->has(Modules::class)) {
            return $this->getContainer()->get(Modules::class);
        }
        if ($this->getContainer()->has(ModulesManager::class)) {
            return $this->getContainer()->get(ModulesManager::class);
        }

        return new ModulesManager();
    }

    protected function registerSections()
    {
        $this->getContainer()->share('mvc.sections', function () {
            return $this->createSectionsManager();
        });
    }

    /**
     * @return SectionsManager
     */
    protected function createSectionsManager()
    {
        if ($this->getContainer()->has(SectionsManager::class)) {
            return $this->getContainer()->get(SectionsManager::class);
        }

        return new SectionsManager();
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['mvc.modules', 'mvc.sections'];
    }
}
