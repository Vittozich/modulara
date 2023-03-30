<?php

use Vittozich\Modulara\Modular;

/** @var $modular Modular */
$modular = app(Modular::class);

foreach ($modular->getOnlyRoutesPath() as $pathWay):
    @include $pathWay . '/api.php';
endforeach;
