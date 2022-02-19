<?php

use Modulizm\Core\Modular;

$modular = app(Modular::class);
foreach ($modular->getOnlyRoutesPath() as $pathWay):
    @include $pathWay . '/web.php';
endforeach;
