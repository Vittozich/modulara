<?php

namespace Vittozich\Modulara\Modular\Core;

use Vittozich\Modulara\Modular\Core\CoreModel;

abstract class CoreRepository
{
    protected CoreModel $model;

    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    /**
     * Need to define model and write inside the method return Model::class`
     *
     * @return mixed
     */
    abstract protected function getModelClass(): string;

    protected function startConditions()
    {
        return clone $this->model;
    }

}
