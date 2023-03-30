<?php

namespace Vittozich\Modulara;

use Vittozich\Modulara\Helpers\Filesystem;

class Modular
{
    protected int $nestingLevel;

    public function __construct()
    {
        $this->nestingLevel = config('modulara.nesting_level');
    }

    /**
     * getting file paths in the Modular directory
     *
     * @param array|null $nestingPaths // вложенный путь
     *
     * @return array
     */
    public function getModulesPaths(array $nestingPaths = null): array
    {
        if (is_null($nestingPaths)) {
            if (is_dir(app_path('Modular/Modules'))) {
                return Filesystem::directories(app_path('Modular/Modules'));
            }
            return Filesystem::directories(__DIR__ . '/Modular/Modules');
        }

        return Filesystem::directories($nestingPaths);
    }


    /**
     * getting a path to views in the module
     * Used only in в AppServiceProvider - like provider
     *
     * @return array
     */
    public function getOnlyViewsPath(): array
    {
        return $this->getModuleFolderPath('Views');
    }

    /**
     * get path to routes folder in the module
     *
     * @return array
     */
    public function getOnlyRoutesPath(): array
    {
        return $this->getModuleFolderPath('Routes');
    }

    /**
     * getting a path to migrations folder in the module
     * Used only in в AppServiceProvider - like provider
     *
     * @return array
     */
    public function getOnlyMigrationsPath(): array
    {
        return $this->getModuleFolderPath('Migrations');
    }

    /**
     * In the module folder search for required folders
     *
     * @param string $folderName
     *
     * @return array
     */
    protected function getModuleFolderPath(string $folderName): array
    {
        $nestingModulePaths = $this->getModulesPaths();

        $nestingRoutePaths = [];
        $currentNesting = 1;

        while ($nestingModulePaths !== []) {
            foreach ($nestingModulePaths as $nestingModulePath) {
                if (basename($nestingModulePath) === $folderName) {
                    $moduleName = basename(pathinfo($nestingModulePath)['dirname']);
                    $nestingRoutePaths[$moduleName] = $nestingModulePath;
                    $currentNesting++;
                }
            }

            if ($currentNesting > $this->nestingLevel) {
                break;
            }
            $nestingModulePaths = $this->getModulesPaths($nestingModulePaths);
        }

        return $nestingRoutePaths;
    }
}
