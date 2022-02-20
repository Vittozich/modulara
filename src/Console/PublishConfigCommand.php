<?php

namespace Vittozich\Modulara\Console;

use Illuminate\Console\Command;

class PublishConfigCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'modulara:config';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     */
    protected static $defaultName = 'modulara:config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish config';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $toFile = config_path('modulara.php');
        $fromFile = __DIR__ . '../../../config/modulara.php';

        if (!file_exists($toFile) || $this->option('force'))
            file_put_contents($toFile,  file_get_contents($fromFile));

        $this->info('Modular config published as modulara.php file in config folder');
    }

}