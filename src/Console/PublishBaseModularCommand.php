<?php

namespace Vittozich\Modulara\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class PublishBaseModularCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'modulara:base';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     */
    protected static $defaultName = 'modulara:base';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all base structure with template';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (!is_dir($modularPath = app_path('Modular')))
            (new Filesystem)->makeDirectory($modularPath);

        if (!is_dir($basePath = $modularPath . '/Base'))
            (new Filesystem)->makeDirectory($basePath);

        $baseStructure = [
            'Controllers' => [
                'ApiController.php',
                'WebController.php'
            ],
            'Models' => [
                'Model.php'
            ],
            'Repositories' => [
                'Repository.php'
            ],
            'Tests' => [
                'DbTestCase.php',
                'ExistsDbTestCase.php',
                'SimpleTestCase.php'
            ],
            'DTOs' => [
                'DTO.php'
            ],
            'Actions' => [
                'DTOAction.php',
                'SimpleAction.php'
            ]
        ];

        foreach ($baseStructure as $baseElement => $publishedElements) {
            if (!is_dir($baseElementPath = $basePath . '/' . $baseElement))
                (new Filesystem)->makeDirectory($baseElementPath);

            $this->putFileToNewPlace($publishedElements, __DIR__ . '/../Modular/Base/' . $baseElement, $baseElementPath);
        }

        if (!is_dir($modulesPath = $modularPath . '/Modules'))
            (new Filesystem)->makeDirectory($modulesPath);

        $this->info('Modular base structure published complete.');
    }

    protected function putFileToNewPlace(array $files, $from, $to): void
    {
        foreach ($files as $file) {
            $fromFile = $from . '/' . $file;
            $toFile = $to . '/' . $file;

            if (!file_exists($toFile) || $this->option('force')) {
                $fileContent = file_get_contents($fromFile);
                $fileContent = $this->changeNamespace($fileContent);
                file_put_contents($toFile, $fileContent);
            }
        }
    }

    protected function changeNamespace(string $fileContent, bool $onlyNamespace = true): string
    {
        $namespaceString = '';

        if ($onlyNamespace) {
            $namespaceString = 'namespace ';
        }

        return str_replace(
            $namespaceString . 'Vittozich\\Modulara\\',
            $namespaceString . app()->getNamespace(),
            $fileContent
        );
    }


}