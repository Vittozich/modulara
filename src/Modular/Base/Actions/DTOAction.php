<?php
namespace Vittozich\Modulara\Modular\Base\Actions;

use Vittozich\Modulara\Modular\Core\CoreAction;
use Vittozich\Modulara\Modular\Core\CoreDTO;

abstract class DTOAction extends CoreAction
{
    public abstract function run(CoreDTO $dto);
}
