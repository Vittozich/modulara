<?php

declare(strict_types=1);

namespace Vittozich\Modulara\Helpers;

use Symfony\Component\Finder\Finder;

class Filesystem
{

    /**
     * Get all of the directories within a given directory or directories
     * If no directories return empty array []
     *
     * @param string|array $directories
     * @return array
     */
    static public function directories(string|array $directories): array
    {
        $result = [];

        foreach (Finder::create()->in($directories)->directories()->depth(0)->sortByName() as $directory) {
            $result[] = $directory->getPathname();
        }

        return $result;
    }

}
