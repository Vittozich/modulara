<?php
namespace Vittozich\Modulara\Modular\Base\Actions;

use Vittozich\Modulara\Modular\Base\DTOs\CoreDTO;

abstract class DTOAction extends CoreAction
{
    public abstract function run(CoreDTO $dto);
}
