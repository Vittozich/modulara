<?php
namespace Vittozich\Modulara\Modular\Base\Actions;

use Vittozich\Modulara\Modular\Base\Dtos\CoreDto;

abstract class DtoAction extends CoreAction
{
    public abstract function run(CoreDto $dto);
}
