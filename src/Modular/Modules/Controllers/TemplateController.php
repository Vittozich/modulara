<?php

namespace Vittozich\Modulara\Modular\Modules\Controllers;

use Vittozich\Modulara\Modular\Base\Controllers\WebController;

class TemplateController extends WebController
{
    public function test()
    {
        return view('TemplateModule::template');
    }
}
