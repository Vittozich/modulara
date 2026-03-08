<?php

namespace Vittozich\Modulara\Console;

use Illuminate\Console\Command;
use Vittozich\Modulara\Modular;

class ClearCacheCommand extends Command
{
    protected $signature = 'modulara:cache-clear';

    protected $description = 'Clear cached modular paths (routes/views/migrations)';

    public function handle(): int
    {
        /** @var Modular $modular */
        $modular = app(Modular::class);
        $modular->clearCachedPaths();

        $this->info('Modulara paths cache cleared.');

        return self::SUCCESS;
    }
}
