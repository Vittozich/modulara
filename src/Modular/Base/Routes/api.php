<?php

use Vittozich\Modulara\Modular;

$modular = app(Modular::class);
foreach ($modular->getOnlyRoutesPath() as $pathWay):
    @include $pathWay . '/api.php';
endforeach;
