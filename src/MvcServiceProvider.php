<?php

namespace Nip\Mvc;

use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;
use Nip\Mvc\Modules\ModulesManager;
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
