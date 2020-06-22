<?php

namespace Nip\Mvc\Modules;

/**
 * Class ModulesManager
 * @package Nip\Mvc\Modules
 */
class ModulesManager
{

    /**
     * @var ModulesCollection
     */
    protected $modules = null;


    /**
     * @param $name
     */
    public function addModule($name)
    {
        if (!$this->getModules()->offsetExists($name)) {
            $this->getModules()->set($name, $name);
        }
    }

    /**
     * @param $name
     *
     * @return string
     */
    public function getViewPath($name)
    {
        return $this->getModuleDirectory($name) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;
    }

    /**
     * @param $name
     *
     * @return string
     */
    public function getModuleDirectory($name)
    {
        return $this->getModulesBaseDirectory() . $name;
    }

    /**
     * @return string
     */
    public function getModulesBaseDirectory()
    {
        return defined('MODULES_PATH') ?
            MODULES_PATH
            : app('path') . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR;
    }

    /**
     * @return ModulesCollection
     */
    public function getModules(): ModulesCollection
    {
        if ($this->modules === null) {
            $this->modules = new ModulesCollection();
            $this->loadFromConfig();
        }
        return $this->modules;
    }

    /**
     * @param ModulesCollection $sections
     */
    public function setModules(ModulesCollection $sections): void
    {
        $this->modules = $sections;
    }

    protected function loadFromConfig()
    {
        if (function_exists('config')) {
            $data = config('mvc.modules', ['admin', 'frontend']);
            foreach ($data as $key => $row) {
                $this->modules->set($key, $row);
            }
        }
    }
}
