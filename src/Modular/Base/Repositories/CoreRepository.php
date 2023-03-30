<?php

namespace Vittozich\Modulara\Modular\Base\Repositories;

use Vittozich\Modulara\Modular\Base\Models\CoreModel;

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
