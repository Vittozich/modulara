<?php
namespace Vittozich\Modulara\Modular\Base\Actions;

use Vittozich\Modulara\Modular\Core\CoreAction;

abstract class SimpleAction extends CoreAction
{
    public abstract function run(...$args);
}
