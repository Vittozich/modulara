<?php

namespace Vittozich\Modulara;

use Illuminate\Support\Facades\Cache;
use Throwable;
use Vittozich\Modulara\Helpers\Filesystem;

class Modular
{
    protected int $nestingLevel;
    protected bool $cacheEnabled;
    protected string $cacheStore;
    protected ?int $cacheTtlSeconds;
    protected string $cacheKeyPrefix;
    protected array $runtimePathsCache = [];

    public function __construct()
    {
        $this->nestingLevel = (int) config('modulara.nesting_level', 1);
        $this->bootCacheSettings();
    }

    protected function bootCacheSettings(): void
    {
        $cacheConfig = (array) config('modulara.cache', []);
        $disabledEnvs = array_map('strval', (array) ($cacheConfig['disabled_on_envs'] ?? []));
        $isDisabledByEnvironment = app()->environment($disabledEnvs);

        $this->cacheEnabled = (bool) ($cacheConfig['enabled'] ?? true) && !$isDisabledByEnvironment;
        $this->cacheStore = (string) ($cacheConfig['store'] ?? 'file');
        $this->cacheKeyPrefix = trim((string) ($cacheConfig['key_prefix'] ?? 'modulara'), ':');

        $ttlSeconds = $cacheConfig['ttl_seconds'] ?? 3600;
        $this->cacheTtlSeconds = is_numeric($ttlSeconds) && (int) $ttlSeconds > 0
            ? (int) $ttlSeconds
            : null;
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
        return $this->getCachedModuleFolderPath('views', 'Views');
    }

    /**
     * get path to routes folder in the module
     *
     * @return array
     */
    public function getOnlyRoutesPath(): array
    {
        return $this->getCachedModuleFolderPath('routes', 'Routes');
    }

    /**
     * getting a path to migrations folder in the module
     * Used only in в AppServiceProvider - like provider
     *
     * @return array
     */
    public function getOnlyMigrationsPath(): array
    {
        return $this->getCachedModuleFolderPath('migrations', 'Migrations');
    }

    protected function getCachedModuleFolderPath(string $group, string $folderName): array
    {
        if (array_key_exists($group, $this->runtimePathsCache)) {
            return $this->runtimePathsCache[$group];
        }

        if (!$this->cacheEnabled) {
            return $this->runtimePathsCache[$group] = $this->getModuleFolderPath($folderName);
        }

        $cacheKey = $this->getCacheKey($group);
        $resolver = fn() => $this->getModuleFolderPath($folderName);

        try {
            $store = Cache::store($this->cacheStore);
            $paths = $this->cacheTtlSeconds === null
                ? $store->rememberForever($cacheKey, $resolver)
                : $store->remember($cacheKey, now()->addSeconds($this->cacheTtlSeconds), $resolver);
        } catch (Throwable) {
            $paths = $resolver();
        }

        if (!is_array($paths)) {
            $paths = [];
        }

        return $this->runtimePathsCache[$group] = $paths;
    }

    public function clearCachedPaths(): void
    {
        $this->runtimePathsCache = [];

        if (!$this->cacheEnabled) {
            return;
        }

        try {
            $store = Cache::store($this->cacheStore);
            foreach (['routes', 'views', 'migrations'] as $group) {
                $store->forget($this->getCacheKey($group));
            }
        } catch (Throwable) {
            // Ignore cache store errors to avoid affecting runtime behavior.
        }
    }

    protected function getCacheKey(string $group): string
    {
        return "{$this->cacheKeyPrefix}:paths:{$group}:nesting:{$this->nestingLevel}";
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
        $maxDepth = $this->nestingLevel + 1;

        while ($nestingModulePaths !== []) {
            // +1 because module folders live one level above Routes/Views/Migrations.
            if ($currentNesting > $maxDepth) {
                break;
            }

            foreach ($nestingModulePaths as $nestingModulePath) {
                if (basename($nestingModulePath) === $folderName) {
                    $moduleName = basename(pathinfo($nestingModulePath)['dirname']);
                    $nestingRoutePaths[$moduleName] = $nestingModulePath;
                }
            }

            $currentNesting++;
            $nestingModulePaths = $this->getModulesPaths($nestingModulePaths);
        }

        return $nestingRoutePaths;
    }
}
